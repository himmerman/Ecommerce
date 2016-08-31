<?php

class productmodel extends CI_Model{

	public function __construct()
	{
		$this->load->database();

	}
	public function getFeaturedProducts()
	{
		$sql = "SELECT * FROM product WHERE featured = 1";
		$result = $this->db->query($sql);
		$featured = array();
		foreach ($result->result() as $row) {
			$featured[] = $row;
		}
		return $featured;
	}
	public function getAllProductsByCategory($category)
	{
		$sql = "SELECT * FROM product p JOIN product_category pc ON pc.product_id = p.id WHERE pc.category_id = ?";

		$result = $this->db->query($sql, array($category));
		$products = array();
		foreach ($result->result() as $row) {
			$products[] = $row;
			
		}
		return $products;
	}

	public function buildProductBoxes($products, $category)
	{
		if ($category != 'Search Results') {
			$result = $this->db->query('SELECT name FROM category WHERE id = ?', array($category));
			$category_name = $result->row();
			$html = "<h1>{$category_name->name}</h1>";
		} else {
			$html = "<h1>$category</h1>";
		}
		$base = base_url();
		foreach ($products as $row) {
			if (function_exists("money_format")) {
				$row->price = money_format('%i', ($row->price/100));
			} else{
				$row->price = number_format($row->price / 100, 2); 
			}
			if (!$row->photo) {
				$row->photo = "http://rubiconthemovie.com/wp-content/uploads/2012/01/coming-soon6.jpg";
			}
			$html .= <<<HTML
<div class="product_box" id="product{$row->id}">
	<div class="product_photo">
		<a href="{$base}view_product/{$row->id}">
			<img src="{$row->photo}">
		</a>
	</div>
	
	<h3><a href="{$base}productView/{$row->id}">{$row->name}</a></h3>
	
	<span class="product_price">\${$row->price}</span>
	<a class="product_view" href="{$base}view_product/{$row->id}">View Item</a>
</div>
HTML;
		}
		
		return $html;
	}

	public function getShippingPrice($subtotal)
	{
		$result = $this->db->query("SELECT * FROM shipping WHERE {$subtotal} >= price_low AND {$subtotal} <= price_high");
		$shipping = $result->row();
		return $shipping->shipping_price;
	}
	public function getAllProducts()
	{
		$result = $this->db->query('SELECT * FROM product ORDER BY price ASC');
		$products = array();
		foreach ($result->result() as $row) {
			$row->price = number_format($row->price / 100, 2);
			if ($row->is_on_sale && $row->sale_price != null) {
				$row->sale_price = number_format($row->sale_price / 100, 2);
			}
			$products[] = $row;

		}
		return $products;
	}

	public function getProductById($product_id)
	{
		$sql = "SELECT * FROM product WHERE id = ?";
		$result = $this->db->query($sql, array($product_id));
		return $result;

	}	

	public function getPromoCode($code)
	{
		$sql = "SELECT * FROM promotions WHERE code = ?";
		$result = $this->db->query($sql, array($code));
		if ($result->num_rows > 0) {
			$promo = $result->row();
			$today = new DateTime('today');
			$promo_cutoff = new DateTime($promo->redeemed_by);
			
			if ($today <= $promo_cutoff) {

				return $promo;

			} elseif ($promo->redeemed_by == "0000-00-00 00:00:00") {
				return $promo;
			} else {
				return false;
			}
			
		} else {
			return false;
		}
	
		
	}

	public function getCategoryIdByName($name)
	{

		$name = str_replace('_', ' ', $name);
		$result = $this->db->query('SELECT id from category where name = ?', array($name));
		$row = $result->row();
		return $row->id;


	}

	public function getAllCategoryLinks()
	{
		$result = $this->db->query('SELECT * FROM category');
		$categories = $result->result();
		$base = base_url();
		$html = '<ul>';
		foreach ($categories as $category) {
			$category->name = str_replace(' ', '_', $category->name);
			$link_name = str_replace('_', ' ', $category->name);
			$html .= "<li><a href='{$base}products/category/{$category->name}'>{$link_name}</a></li>";
		}
		$html .= '</ul>';

		return $html;

	}



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

	
	public function insertNewPurchase($cart, $post)
	{
		// Address insertion
		$address_sql = "INSERT INTO address VALUES (null, ?, ?, ?, ?)";
		$address_data = array(
			$post['streetAddress'], 
			$post['city'], 
			$post['zip'], 
			$post['state']
		);
		$this->db->query($address_sql, $address_data);
		$result = $this->db->query('SELECT LAST_INSERT_ID() AS id');
		$address = $result->row();

		// Customer insertion
		$customer_sql = "INSERT INTO customer VALUES (null, ?, ?, ?, null, null, ?)";
		$customer_data = array(
			$post['firstName'], 
			$post['lastName'],
			$post['email'],
			$address->id
		);
		$this->db->query($customer_sql, $customer_data);
		$result = $this->db->query('SELECT LAST_INSERT_ID() AS id');
		$customer = $result->row();

		// Purchase Insertion
		$purchase_sql = "INSERT INTO purchase VALUES (null, UTC_TIMESTAMP(), ?, ?, ?, ?, ?, 0)";
		$purchase_data = array(
			$customer->id,
			$address->id,
			$cart->getSubtotalPrice(),
			$cart->getShippingCost(),
			$cart->getTotalPrice(),
		);
		$this->db->query($purchase_sql, $purchase_data);
		$result = $this->db->query('SELECT LAST_INSERT_ID() AS id');
		$purchase = $result->row();

		// Product Insertions
		foreach ($cart->getProducts() as $product) {
			$product_sql = "INSERT INTO purchase_product VALUES (?, ?, ?)";
			$product_data = array(
				 $purchase->id,
				 $product->id,
				 $product->quantity

			);
			$this->db->query($product_sql, $product_data);
		}

	}
	
	public function getProductStockCount($id)
	{
		return $this->db->query('SELECT quantity FROM product WHERE id = ?', array($id));
	}

	public function searchProducts($query)
	{
		$queryArray = array("%{$query}%", "%{$query}%", "%{$query}%", "%{$query}%");
		$sql = "SELECT p.name, p.id, p.photo, p.price FROM product p INNER JOIN wood w ON w.id = p.wood WHERE p.description LIKE ? OR p.name LIKE ? OR p.tags LIKE ? OR w.name LIKE ?";
		$result = $this->db->query($sql, $queryArray);

		$products = array();
		foreach ($result->result() as $row) {
			$products[] = $row;
			
		}
		return $this->buildProductBoxes($products, 'Search Results');
	}


	
}



