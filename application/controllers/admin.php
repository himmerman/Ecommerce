<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		session_start();
		$this->load->model('adminModel');
		if (!isset($_SESSION['logged_in'])) {
			redirect(base_url() . 'administrator');
		}
	}


	
/********************
* Page Views
*********************/

	public function index()
	{
		$data['view'] = 'admin/main';
		$data['stats'] = $this->adminModel->getAdminStats();
		$this->load->view('admin_template', $data);

	}
	public function purchases()
	{
		$result = $this->adminModel->getAllPurchases();
		$data['result'] = $result['result'];
		$data['table'] = $result['table'];
		$data['is_sub_table'] = $result['is_sub_table'];
		$data['view'] = 'admin/table';
		$this->load->view('admin_template', $data);
	}

	public function products()
	{
		$result = $this->adminModel->getAllProducts();
		$data['addFunction'] = "Product";
		$data['result'] = $result['result'];
		$data['table'] = $result['table'];
		$data['is_sub_table'] = $result['is_sub_table'];
		$data['view'] = 'admin/table';
		$this->load->view('admin_template', $data);
		// $this->renderView($result, $data);
	}


	public function shipping()
	{
		$result = $this->adminModel->getAllShippingData();
		$data['addFunction'] = "Shipping";
		$data['result'] = $result['result'];
		$data['table'] = $result['table'];
		$data['is_sub_table'] = $result['is_sub_table'];
		$data['view'] = 'admin/table';
		$this->load->view('admin_template', $data);
		// $result, $table, $is_sub_table = false?
		// $this->renderView($result, $data);
	}

	public function promos()
	{
		$result = $this->adminModel->getAllPromos();
		$data['addFunction'] = "Promos";
		$data['result'] = $result['result'];
		$data['table'] = $result['table'];
		$data['is_sub_table'] = $result['is_sub_table'];
		$data['view'] = 'admin/table';
		$this->load->view('admin_template', $data);
	}

/********************
* Adding Views
*********************/

	public function addShipping()
	{
		$data['view'] = 'admin/new_shipping';
		$this->load->view('admin_template', $data);

	}
	public function addProduct()
	{
		$data['view'] = 'admin/new_product';
		// $data['wood'] = $this->adminModel->getWoodList();
		// $data['cat'] = $this->adminModel->getCategoryCheckList();
		
		$this->load->view('admin_template', $data);
	}

	public function addPromos()
	{
		$data['view'] = 'admin/new_promo';
		$this->load->view('admin_template', $data);
	}

/********************
* Editing Views
*********************/
	public function editShipping($shipping_id)
	{
		$result = $this->adminModel->getShippingById($shipping_id);
		$data['view'] = 'admin/edit_shipping';
		$data['shipping'] = $result;
		$this->load->view('admin_template', $data);
	}
	
	public function editProduct($product_id)
	{
		$result = $this->adminModel->getProductById($product_id);
		// $this->renderView($result);
		$data['view'] = "admin/edit_product";
		$data['product'] = $result;
		$this->load->view('admin_template', $data);
	}

	public function editPurchase($purchase_id)
	{
		$result = $this->adminModel->getPurchaseById($purchase_id);
		$this->renderView($result);
	}

	public function editMultiProduct()
	{
		if (empty($_POST)) {
			header("Location: " . base_url() . "admin/products");
		}
		$data = array();
		
		$data['cat'] = $this->adminModel->getCategoryCheckList();
		$data['products'] = $_POST['ids'];

		$data['view'] = 'admin/multi_edit_product';
		$this->load->view('admin_template', $data);
	}

	public function editPromotions($id)
	{
		$result = $this->adminModel->getPromoById($id);
		// $this->renderView($result);
		$data['view'] = "admin/edit_promo";
		$data['promo'] = $result;
		$this->load->view('admin_template', $data);
	}

/********************
* Inserting Functions
*********************/

	public function insertCategory ()
	{
		$category_data = $_POST;
		unset($_POST);

		if ($category_data['name']) {
			$this->adminModel->insertObject($category_data, 'category');
			redirect(base_url() . "admin/categories");
		} else {
			// fail
		}
	}

	public function checkProductCode($product_code)
	{
		try {
		 	$this->adminModel->checkProductCode($product_code);
		 	echo 'true';
		 } catch (Exception $e) {
		 	echo $e->getMessage();
		 } 
	}
	
	public function insertProduct()
	{

		$product_data = $_POST;
		unset($_POST);


		if ($this->uploadImage($product_data)) {
			if ($this->adminModel->insertNewProduct($product_data)) {
				redirect(base_url() . 'admin/products');				
			} else {
				$this->renderView("<b>Error in Entry</b>");
			}
		}		
				// add created by foreign key

		$product_data['createdBy'] = 1;
	}

	public function insertShipping()
	{
		$shipping_data = $_POST;
		$this->adminModel->insertNewShipping($shipping_data);
		// var_dump($shipping_data);
		redirect(base_url() . 'admin/shipping');
	}

	public function insertPromo()
	{
		$promo_data = $_POST;
		// var_dump($promo_data);
		// var_dump($promo_data['free_shipping']);
		// die();
		
		if(isset($promo_data['free_shipping'])) {
			$promo_data['free_shipping'] = True;
		} else {
			$promo_data['free_shipping'] = False;
		}

		$this->adminModel->insertNewPromo($promo_data);
		redirect(base_url() . 'admin/promos');
		
	}

/********************
* Saving Functions
*********************/

	public function updateMultiProducts()
	{
		// var_dump($_POST);

		$ids = json_decode($_POST['ids']);
		// var_dump($ids);
		foreach ($ids as $key => $id) { 
			$productArray = array('price' => $_POST['price'], 'wood' => $_POST['wood'],'id' => $id, 'quantity' => $_POST['quantity']);
			// update price
						
			$this->adminModel->updateStandardTable('product', $productArray);

			// update categories

			$this->adminModel->setProductCategories($id, $_POST['category']);

			// update wood
	
		}
		header("Location: " . base_url() . "admin/products");

	}

	public function uploadImage(&$product_data)
	{
		$valid = true;
		if ($_FILES['file']['name'] != "") {
			$file_result = $this->adminModel->addFile($product_data);

			if (gettype($file_result) == 'array') {
				$valid = false;
				$html = "<h2>";
				for ($i = 0; $i < count($file_result); $i++) {
					$html .= '<span class="required">ERROR: ' . $file_result[$i] . '</span><br>';
				}
				$html .= "</h2>";

				$this->renderView($html);

			} 
		}
		return $valid;

	}
	
	public function saveCategory($id)
	{
		$data = $_POST;
		$data['id'] = $id;
		if($this->adminModel->updateStandardTable('category', $data)) {
			redirect(base_url() . "admin/categories");
		}
	}

	public function updateShipping($id)
	{
		$shipping_data = $_POST;
		$shipping_data['id'] = $id;
		$shipping_data['shipping_price'] = $shipping_data['shipping_price'] * 100;
		$this->adminModel->updateStandardTable("shipping", $shipping_data);
		redirect(base_url(). "admin/shipping");
	}

	public function updateProduct()
	{
		$product_data = $_POST;

		unset($_POST);
		if (!isset($product_data['featured'])) {
			$product_data['featured'] = 0;
		} else if ($product_data['featured'] == 'on') {
			$product_data['featured'] = 1;
		} 

		if (!isset($product_data['is_on_sale'])) {
			$product_data['is_on_sale'] = 0;
		} else if ($product_data['is_on_sale'] == 'on') {
			$product_data['is_on_sale'] = 1;
		} 

		if (isset($product_data['sale_price'])) {
			$product_data['sale_price'] *= 100;
		}
	
		// $this->adminModel->setProductCategories($product_data['id'], $product_data['category']);

		unset($product_data['category']);
		if ($this->uploadImage($product_data)) {
			if ($this->adminModel->updateStandardTable("product", $product_data)) {
				redirect(base_url() . 'admin/products');				
			} else {
				$this->renderView("<b>Error in Entry</b>");
			}
		}		
	}

	public function updatePromo()
	{
		$promo_data = $_POST;
		unset($_POST);
		if(isset($promo_data['free_shipping'])) {
			$promo_data['free_shipping'] = True;
		} else {
			$promo_data['free_shipping'] = False;
		}

		$this->adminModel->updatePromoCode($promo_data);

		redirect(base_url() . 'admin/promos');	
	}

	public function fulfillPurchase($id)
	{
		// update row in purchase table to be fullfilled
		$data['id'] = $id;
		$data['isFulfilled'] = true;
		$this->adminModel->updateStandardTable('purchase', $data);

		// email client
		$result = $this->adminModel->getCustomerDataByPurchaseId($id);
		$customer = $result->row();
		$base_url = base_url();

		$subject = "Your purchase has been shipped";

		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= "Content-type: text/html\r\n"; 
		$headers .= "From: info@americanwoodarts.com\r\n";
		$headers .= "Reply-to: americanwoodarts@gmail.com\r\n";
		$message = <<<HTML
		<html>
		<head>
			<link href="{$base_url}assets/styles/email.css" rel="stylesheet" type="text/css">
		</head>
		<body>
			<h1>Your Purchase has been shipped</h1>
			<p>We again thank you for your previous purchase and we are happy to inform you that it has shipped. Expect your package to arrive within the next 3-14 business days.</p>
			<p>If you have any questions please contact us through our website <a href="{$base_url}">americanwoodarts.com</a></p>
		</body>
		</html>
HTML;
		mail($customer->email, $subject, $message, $headers);
		// redirect

		redirect(base_url() . 'admin/purchases');
	}

/********************
* Deleting Functions
*********************/
	public function deleteProduct($id)
	{
		$this->adminModel->deleteRow('product', $id);

	}

	public function deletePurchase($id)
	{
		$this->adminModel->deleteRow('purchase', $id);
	}

	public function deleteShipping($id)
	{
		$this->adminModel->deleteRow('shipping', $id);
	}

	public function deletePromotions($id)
	{
		$this->adminModel->deleteRow('promotions', $id);
		echo "1";
	}

/************/
	public function renderView($result, $data = array())
	{
		if ($result) {
			$data['html'] = $result;
		} else {
			$data['html'] = "<p><i>No results</i></p>";
		}
		
		$data['page'] = "page";

		$data['view'] = 'admin/admin_list';

		$this->load->view('admin_template', $data);
	}

	public function logOut()
	{
		unset($_SESSION['logged_in']);
		redirect(base_url() .'admin');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */