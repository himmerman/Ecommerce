<?php

class adminModel extends CI_Model{

	public function __construct()
	{
		$this->load->database();
	}

	public function getAdminStats()
	{
		$html = "<div>";

		// total new purchases
		$sql = "SELECT COUNT(*) AS count FROM purchase WHERE isFulfilled = 0";
		$new_purchases = $this->db->query($sql);
		$row = $new_purchases->row();

		$html .= "<h3>Total New Purchases: <span class='required'><i>{$row->count}</i></span></h3>";

		// total purchases
		$sql = "SELECT COUNT(*) AS count FROM purchase";
		$purchases = $this->db->query($sql);
		$row = $purchases->row();

		$html .= "<h3>Total Purchases: <span class='required'><i>{$row->count}</i></span></h3>";

		// Total products
		$sql = "SELECT COUNT(*) AS count FROM product";
		$product_count = $this->db->query($sql);
		$row = $product_count->row();

		$html .= "<h3>Total Products: <span class='required'><i>{$row->count}</i></span></h3>";

		// total customers
		$sql = "SELECT COUNT(*) AS count FROM customer";		
		$customers = $this->db->query($sql);
		$row = $customers->row();

		$html .= "<h3>Total Customers: <span class='required'><i>{$row->count}</i></span></h3>";

		return $html;
	}

	public function getCustomerDataByPurchaseId($id)
	{
		return $this->db->query('SELECT c.firstName, c.LastName, c.email FROM purchase p INNER JOIN customer c ON c.id = p.customer_id WHERE p.id = ?', array($id));
	}

	public function getAllPurchases()
	{
		$sql = "SELECT 
				p.id
				, p.date as 'Date'
				, c.firstName AS 'First Name'
				, c.LastName AS 'Last Name'
				, a.city 'City'
				, a.state 'State'
				, format((p.total/100), 2) AS 'Sale Price'
				, p.isFulfilled AS 'Order Fulfilled'
				FROM purchase p 
				INNER JOIN customer c 
				ON c.id = p.customer_id 
				INNER JOIN address a 
				ON a.id = p.address_id 
				ORDER BY p.isFulfilled, p.date";
		$result = $this->db->query($sql);

		return array('result' => $result, 'table' => 'purchase', 'is_sub_table' => false);
	}
	public function getShippingById($id)
	{
		$sql = "SELECT * FROM shipping WHERE id = {$id}";
		$result = $this->db->query($sql);
		return $result->row();
	}
	public function getPurchaseById($id)
	{
		$sql = "SELECT 
				p.id
				, p.date as 'Date'
				, c.firstName
				, c.LastName
				, c.email
				, a.streetAddress
				, a.city
				, a.state
				, a.zip
				, format((p.subtotal/100), 2) AS subtotal
				, format((p.shipping_cost/100), 2) AS shipping_cost
				, format((p.total/100), 2) AS total
				, p.isFulfilled
				FROM purchase p 
				INNER JOIN customer c 
				ON c.id = p.customer_id 
				INNER JOIN address a 
				ON a.id = p.address_id 
				WHERE p.id = ?
				ORDER BY p.isFulfilled, p.date ASC";
				
		$result = $this->db->query($sql, array($id));
		// die();
		return $this->parsePurchaseForm($result);
	}

	public function getAllPromos()
	{
		$sql = "SELECT `id`, `code` as 'Promo Code', `percent_off` as 'Percent Off', format((amount_off/100),2) as 'Amount Off', `free_shipping` AS 'Free Shipping', `redeemed_by` as 'Redeemed By' FROM promotions";
		$result = $this->db->query($sql);


		return array('result' => $result, 'table' => 'promotions', 'is_sub_table' => false);
	}

	public function parsePurchaseForm($result)
	{
		$purchase = $result->row();

		$html = "<h2>Purchase Made {$purchase->Date}</h2>";

		$html .= "<h3>Customer Information</h3>";
		$html .= "<ul><li>{$purchase->firstName} {$purchase->LastName}</li>";
		$html .= "<li>{$purchase->email}</li>";
		$html .= "</ul>";

		$html .= "<h3>Address Information</h3>";
		$html .= "<ul><li>{$purchase->streetAddress}</li>";
		$html .= "<li>{$purchase->city}, {$purchase->state} {$purchase->zip}</li>";
		$html .= "</ul>";

		// $product_result = $this->db->query('SELECT product_id AS id, quantity FROM purchase_product WHERE purchase_id = ?', array($purchase->id));

		// $products = array();
		
		// foreach ($product_result->result() as $row) {
		// 	$products[] = $row->id;
		// }

		$html .= "<h3>Products</h3>";

		$html .= $this->getCustomerCart($purchase->id);

		$html .= "<h3>Purchase Data</h3>";
		$html .= "<ul><li>Subtotal: \${$purchase->subtotal}</li>";
		$html .= "<li>Shipping Cost: \${$purchase->shipping_cost}</li>";
		$html .= "<li>Total: \${$purchase->total}</li>";
		$html .= "</ul>";

		$base_url = base_url();
		
		$html .= <<<HTML
			<form action="{$base_url}admin/fulfillPurchase/{$purchase->id}" method="POST" onsubmit="return confirm('Do you want to fulfill this order? That means it is ready to ship within the day.')">
				<input type="submit" value="Fulfill/Ship This Order">
			</form>
			<form action="{$base_url}admin/purchases" method="POST" >
				<input type="submit" value="Cancel">
			</form>
HTML;

		return $html;
	}

	private function getCustomerCart($purchase_id)
	{
		$sql = "SELECT product_id, quantity FROM purchase_product WHERE purchase_id =?";
		$result = $this->db->query($sql, array($purchase_id));

		$products = array();

		foreach ($result->result() as $row) {
			$products[] = $this->db->query('SELECT p.id, p.productCode, p.photo, p.name , format((p.price/100), 2) AS price, pp.quantity FROM product p INNER JOIN purchase_product pp ON pp.product_id = p.id WHERE p.id = ? AND pp.purchase_id = ?', array($row->product_id, $purchase_id));
		}


		$html = "<table id='adminTable'>";
		$html .= "<tr><th>Photo</th><th>Product Code</th><th>Product Name</th><th>Price per Unit</th><th>Quantity</th></tr>";
		foreach ($products as $product) {
			$html .= "<tr>";
			$row = $product->result();
			$html .= "<td><img src = '" . $row[0]->photo . "'></td>";
			$html .= "<td>" . $row[0]->productCode . "</td>";
			$html .= "<td>" . $row[0]->name . "</td>";
			$html .= "<td>" . $row[0]->price . "</td>";
			$html .= "<td>" . $row[0]->quantity . "</td>";
			$html .= "</tr>";
		}

		$html .= "</table>";
		return $html;
	}


	public function getAllProducts()
	{
		$result = $this->db->query('SELECT 
									p.id,
									p.productCode AS "Product Code", 
									p.photo AS Photo, 
									p.name AS "Product Name", 
									p.quantity AS "Quantity in Stock",
									format((p.price/100), 2) AS "Price per Unit"
									FROM product p'
									);

		return array('result' => $result, 'table' => 'product', 'is_sub_table' => false);
	}

	public function getProductsByIds($idlist)
	{

		$sql = 'SELECT 
				p.id,
				p.productCode AS "Product Code", 
				p.photo AS Photo, 
				p.name AS "Product Name", 
				p.quantity AS "Quantity in Stock", 
				format((p.price/100), 2) AS "Price per Unit" 
				FROM product p
				WHERE p.id = ?';

		$sql2 = $sql;
		
		for ($i=1; $i < count($idlist); $i++) { 
			$sql2 .= " UNION {$sql}";
		}

		$result = $this->db->query($sql2, $idlist);

		return array('result' => $result, 'table' => 'products', 'is_sub_table' => true);
	}

	public function getProductById($product_id)
	{
		$sql = "SELECT * FROM product WHERE id = ?";
		$result = $this->db->query($sql, array($product_id));
		$product = $result->row();
		return $product;
		// return $this->parseProductForm($result);
	}	

	public function getPromoById($promo_id)
	{
		$sql = "SELECT * FROM promotions WHERE id = ?";
		$result = $this->db->query($sql, array($promo_id));
		$promo = $result->row();
		return $promo;
	}

	public function getAllShippingData()
	{
		$result = $this->db->query('SELECT id, price_low, price_high, format(shipping_price/100, 2) AS `Shipping Price` FROM shipping ORDER BY price_low ASC');
		return array('result' => $result, 'table' => 'shipping', 'is_sub_table' => false);
	}
	/******************
	PRIVATE FUNCTIONS
	******************/
	// private function parseTableResults($result, $table, $is_sub_table = false)
	// {
	
	// 	if ($result->num_rows() > 0){
			
	// 		if ($table == "product") {
	// 			$html = "<form action='" . base_url() . "admin/editMultiProduct' method='post'>";
	// 			$html .= "<p><input type='submit' value='Edit Products'></p>";
	// 			$html .= "<table id='adminTable'>";

	// 		} else {
	// 			$html = "<table id='adminTable'>";
	// 		}

	// 		$html .= "<tr>";

	// 		if ($table == 'product') {
	// 			$html .= "<th>Multi Edit</th>";
	// 		}

	// 		foreach ($result->list_fields() as $field) {
	// 			if ($field != 'id') {
	// 				$html .= "<th>$field</th>";
	// 			}
				
	// 		}

	// 		if (!$is_sub_table) {
	// 			$html .= "<th>Action</th>";
	// 		}

	// 		$html .= "</tr>";
	// 		$counter = 0;
	// 		foreach ($result->result() as $row) {
	// 			$html .= "<tr>";
				
	// 			$id = $row->id;
	// 			unset($row->id);
				
	// 			if ($table == 'product') {
	// 				$html .= "<td><input type='checkbox' name='ids[{$counter}]={$id}' value='{$id}'></td>";
	// 				$counter++;
	// 			}
				

	// 			foreach ($row as $key => $value) {
					
	// 				if ($key != 'Photo' && $key != 'Price per Unit' && $key != 'Order Fulfilled' && $key != 'Sale Price') {
	// 					$html .= "<td>{$value}</td>";
	// 				} elseif ($key == 'Photo') {
	// 					$html .= "<td><img src='{$value}'></td>";
	// 				} elseif ($key == 'Order Fulfilled') {
	// 					if ($value) {
	// 						$html .= "<td>Yes</td>";
	// 					} else {
	// 						$html .= "<td><span class='required'>No</span></td>";
	// 					}
	// 				} else {
	// 					$html .="<td>\${$value}</td>";
	// 				}		
	// 			}
	// 			$function = ucfirst($table);
	// 			if (!$is_sub_table) {
	// 				$html .= "<td><a href='edit{$function}/{$id}'>Edit</a> <a id='formDelete' onclick='confirmDelete(\"{$function}\", {$id})'>Delete</a></td>";	
	// 			}
				
	// 			$html .= "</tr>";
					
	// 		}
	// 		$html .= "</table>";
	// 		if ($table == "product") {
	// 			$html .= "</form>";
	// 		}
	// 		return $html;

	// 	} else {
	// 		return false;
	// 	}
	// }

	public function getWoodList($wood_id = null)
	{
		$result = $this->db->query('SELECT * FROM wood');
		$list = "";
		foreach ($result->result() as $row) {
			if ($row->id == $wood_id) {
				$list .= "<option selected value='{$row->id}''>{$row->name}</option>";			
			} else {
				$list .= "<option value='{$row->id}''>{$row->name}</option>";			
			}
		}

		return $list;
	}

	public function getCategoryCheckList($product_id = null)
	{
		$sql = "SELECT * FROM category";

		$all_categories = $this->db->query($sql,array($product_id));

		$html = "";
		$used_categories = array();
		$counter = 0;

		if ($product_id != null) {
			// echo 'product_id';
			$sql2 = "SELECT c.id, c.name FROM product_category pc JOIN category c ON c.id = pc.category_id WHERE pc.product_id = ?";
			$all_products_categories = $this->db->query($sql2, array($product_id));

			foreach ($all_products_categories->result() as $pc) {
				$html .= "<p class='category'><input name='category[{$counter}]={$pc->id}' class='cat-check' type='checkbox' checked='true' value='{$pc->id}'><span>{$pc->name}</span></p>";
				$used_categories[] = $pc->id;
				$counter++;
			}
		}

		foreach ($all_categories->result() as $c) {
			$key = array_search($c->id, $used_categories);
			if (gettype($key) != 'boolean') {
				$key++;
			}

			if (!$key) {
				$html .= "<p class='category'><input name='category[{$counter}]={$c->id} ' class='cat-check' type='checkbox' value='{$c->id}'><span>{$c->name}</span></p>";
				$counter++;
			}
		}

		return $html;
	}

	private function parseProductForm($result_set)
	{
		$product = $result_set->row();
		$cats = $this->getCategoryCheckList($product->id);
		// $wood = $this->getWoodList($product->wood);
		$product->price = money_format('%i', $product->price/100);
		$base_url = base_url();
		$html = <<<HTML
<h2>{$product->name}</h2>

<form action='{$base_url}admin/updateProduct' method='post' id='productForm' enctype="multipart/form-data">
	<input type="text" id="admin-product_id" name="id" readonly="readonly" value="{$product->id}">
	<label><span class="required">*</span>Product Photo:</label><input name="file" type="file">
	<label><span class="required">*</span>Product Name:</label><input name="name" type="text" value="{$product->name}">
	<label><span class="required">*</span>Product Code:</label><input name="productCode" type="text" value="{$product->productCode}">
	<label><span class="required">*</span>Product Price: $</label><input name="price" type="text" value='{$product->price}'>
	<label><span class="required">*</span>Product Quantity:</label><input name="quantity" type="text" value='{$product->quantity}'>
	<label><span class="required">*</span>Wood Type:</label>
	<select name="wood">
		{$wood}
	</select>
	<label>Product Width:</label><input name="width" step=".01" min="0" type="number" value='{$product->width}'>
	<label>Product Height:</label><input name="height" step=".01" min="0" type="number" value='{$product->height}'>
	<label>Product Depth:</label><input name="depth" step=".01" min="0" type="number" value='{$product->depth}'>			
	<!-- <label>Is Package?</label><input name="is_package" type="checkbox"> -->
	<label>Categorys:</label>
	{$cats}
	<label>Tags:</label><input name="tags" type="text" value="{$product->tags}" placeholder="keywords for search such as: tag, tag2, tag3">
	<button id="adminSave">Save</button>
</form>
<img id="productImage" src="{$product->photo}">


HTML;


		return $html;
	}

	public function insertNewProduct($product_data)
	{
		$product_data['createdBy'] = $this->session->userdata('user_id');

		$sql = "INSERT INTO product (";

		$categories = $product_data['category'];
		unset($product_data['category']);

		// set up column names
		$num_cols = count($product_data);
		$i = 1;

		foreach ($product_data as $key => $value) {
			if ($i != $num_cols) {
				$sql .= "$key, ";
			} else {
				$sql .= $key;
			}
			$i++;	
		}

		$i = 1;

		$sql .= ") VALUES (";
		$product_data['price'] *= 100; 
		$values = array();
		foreach ($product_data as $key => $value) {
			$values[] = $value;

			if ($i != $num_cols) {
				$sql .= "?, ";
			} else {
				$sql .= "?";
			}
			$i++;	
		}
		$sql .= ")";
	
		try {
			$this->db->query($sql, $values);
		} catch (Exception $e) {
			echo $e;
			return false;
		}

		// **** INSERT NEW PRODUCT'S CATEGORIES
		$result = $this->db->query('SELECT LAST_INSERT_ID() as id ');

		$row = $result->row();

		// $this->setProductCategories($row->id, $categories);
		return true;

	}

	public function insertNewShipping($shipping_data)
	{
		$sql = "INSERT INTO shipping (`price_low`, `price_high`, `shipping_price`) VALUES ('{$shipping_data['price_low']}', '{$shipping_data['price_high']}', '{$shipping_data['shipping_price']}')";
		$this->db->query($sql);
		return true;
	}

	public function insertNewPromo($promo_data)
	{
		if ($promo_data['amount_off'] != '') {
			$promo_data['amount_off'] = $promo_data['amount_off'] * 100;
		}

		foreach ($promo_data as $key => $value) {
			if ($promo_data[$key] == '') {
				$promo_data[$key] = 'null';
			}
		}
		// var_dump($promo_data['amount_off']);
		// die();
		$sql = "INSERT INTO `promotions`(`code`, `percent_off`, `amount_off`, `free_shipping`, `redeemed_by`) VALUES ('{$promo_data['code']}', {$promo_data['percent_off']}, {$promo_data['amount_off']}, {$promo_data['free_shipping']}, '{$promo_data['redeemed_by']}')";
		$this->db->query($sql);
		return true;
	}

	public function updatePromoCode($promo_data)
	{
		if ($promo_data['amount_off'] != '') {
			$promo_data['amount_off'] = $promo_data['amount_off'] * 100;
		}

		foreach ($promo_data as $key => $value) {
			if ($promo_data[$key] == '') {
				$promo_data[$key] = 'null';
			}
		}
		// var_dump($promo_data['amount_off']);
		// die();
		$sql = "UPDATE `promotions` SET `code` = '{$promo_data['code']}', `percent_off` = {$promo_data['percent_off']}, `amount_off` = {$promo_data['amount_off']}, `free_shipping` = {$promo_data['free_shipping']}, `redeemed_by` = '{$promo_data['redeemed_by']}' WHERE id = {$promo_data['id']}";

		$this->db->query($sql);
		return true;
	}

	public function updateStandardTable($table, $data)
	{
		$sql = "UPDATE {$table} SET ";


		$id = $data['id'];
		unset($data['id']);		

		$num_cols = count($data);
		$num_cols -= 1;
		$i = 0;


		foreach ($data as $key => $value) {
			if ($key != 'id') {
				if ($i != $num_cols) {
					$sql .= "{$key} = ?, ";		
				} else {
					$sql .= "{$key} = ? "; 
				}
			}
			$i++;
		}

		$sql .= "WHERE id = ?"; 
		// echo $sql;
		// echo $data['name'];
		// die();

		
		$data['id'] = $id;
		if (isset($data['price'])) {
			$data['price'] *= 100;		
		}

		if ($this->db->query($sql, $data)) {
			return true;
		} else {
			return false;
		}

	}
	public function getAllObjectData($id, $table)
	{
		$sql = "SELECT * FROM `{$table}` WHERE id = ?";

		$result = $this->db->query($sql, array($id));

		return $result;
	}

	public function getCategoryForm($category_data)
	{
		$row = $category_data->row();
		$base_url = base_url();
		$html = "<h3><i>Categories are automatically rendered as left menu items on the website so only add needed categories and remove unused ones</i></h3>";
		$html .= "<form action='{$base_url}admin/saveCategory/{$row->id}' method='POST'>";

		$html .= <<<HTML
<label>Name: </label><input type="text" name="name" value="{$row->name}"><br>
<label>Page SEO content: </label><br><textarea name="content" cols="50" rows="10">{$row->content}</textarea>
<br><button>Save</button>
HTML;
		$html .= "</form>";

		return $html;
	}

	public function insertObject($data, $table)
	{
		$sql = "INSERT INTO `{$table}` (`id`, ";
		
		$i = 1;
		$max = (count($data));
		foreach ($data as $key => $value) {
			if ($i < $max) {
				$sql .= "`$key`, ";
			} else {
				$sql .= "`$key`) ";
			}
			$i++;
		}

		$i = 1;
		$sql .= "VALUES (null, ";
		$values = array();
		foreach ($data as $key => $value) {
			$values[] = $value;
			if ($i < $max) {
				$sql .= "?, ";
			} else {
				$sql .= "?)";
			}
			$i++;
		}

		if ($this->db->query($sql, $values)) {
			return true;
		} else {
			return false;
		}
	}

	public function checkProductCode($product_code)
	{
		$sql = "SELECT productCode FROM product WHERE productCode = ?";

		$result = $this->db->query($sql, array($product_code));

		$row = $result->row();

		if ($result->num_rows > 0) {
			throw new Exception("Error: Product Code already in use. Please make a new Unique product Code", 1);
			
		} else {
			return true;
		}
	}

	public function addFile(&$product_data)
	{

		$errors = array();
		$allowedExts = array("jpeg", "jpg", "png");
		$temp = explode(".", $_FILES["file"]["name"]);
		$extension = end($temp);
		$max_filesize = 1000000;
		$max_filesize_kb = $max_filesize/1024;
		if ($_FILES['file']['size'] > $max_filesize) {
			$errors[] = "Your file size exceeds the maximum file limit. Limit: $max_filesize_kb KB.";
		} 

		if (!(($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/pjpeg")|| 
			($_FILES["file"]["type"] == "image/x-png") || ($_FILES["file"]["type"] == "image/png"))) 
		{
			$errors[] = "You have uploaded the wrong file type. Your file type: {$_FILES['file']['type']}. Allowed file types: .jpg, .jpeg, and .png.";
		}

		if (count($errors) == 0 && in_array($extension, $allowedExts)) 
		{
		
			if ($_FILES["file"]["error"] > 0) {
				// error handle
				$errors[] = "Error uploading file to server. Try again.";

			} else {
				if (file_exists(base_url() . "assets/images/products/" . $_FILES["file"]["name"])) {
					// error file exists
					$errors[] = $_FILES["file"]["name"] . " already exists. Choose another filename.";
					// echo $_FILES["file"]["name"] . " already exists. ";
				} else {
					$filename = $product_data['productCode'] . '.' . $extension;

					move_uploaded_file($_FILES["file"]["tmp_name"],"assets/images/products/" . $filename);
					$product_data['photo'] = base_url() . "assets/images/products/" . $filename;

				}
			}
		} 

		if (count($errors) > 0)
			return $errors;
		else 
			return true;
	}
	
	public function deleteRow($table, $id)
	{

		$sql = "DELETE FROM {$table} WHERE id = ?";
		var_dump($sql);
		$this->db->query($sql, array($id));
	}

	public function setProductCategories($product_id, $categories)
	{
		$sql = "DELETE FROM product_category WHERE product_id = ?";
		$this->db->query($sql, array($product_id));

		$sql = "INSERT INTO product_category VALUES (?, ?)";

		foreach ($categories as $cat => $value) {
		 	$this->db->query($sql, array($product_id, $value));
		 } 
	}


	public function login($email, $password)
	{
		$result = $this->db->query('SELECT * FROM user WHERE email = ?', array($email));

		if ($result->num_rows > 0) {
			$row = $result->row();
			if ($row->password == $this->hash($password)) {

				$session_data = array(
					'email' => $row->email,
					'firstName' => $row->firstName,
					'LastName' => $row->lastName,
					'user_id' => $row->id,
					'logged_in' => TRUE,
				);

				$this->session->set_userdata($session_data);
				return true;
			}
		}
		return false;
	}

	public function hash($value)
	{
		return sha1($value);
	}
}



