<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products extends CI_Controller {

	public function __construct()
	{
		session_start();
		

		parent::__construct();
		$this->load->model('productmodel');
		$categories = $this->productmodel->getAllCategoryLinks();
		$data['categories'] = $categories;
	}

	public function index($value='')
	{
		$data['title'] = "Products | Tech Protect Bag";
		$data['products'] = $this->productmodel->getAllProducts();
		$data['layout'] = "rightsidebar";
		$data['view'] = 'main/products';
		$data['page_title'] = "Our Products";
		$data['sub_header'] = "Military grade faraday bags";
		$data['sidebar'] = "includes/aside";
		$this->load->view('main_template', $data);
	}
	public function search()
	{
		$query = $_GET['query'];
		$html = $this->productmodel->searchProducts($query);
	
		// render html and load view
		$data['view'] = 'main/products';
		$data['html'] = $html;
		$this->load->view('main_template', $data);
	}

	public function category($category)
	{
		$id = $this->productmodel->getCategoryIdByName($category);
		$this->getProductsByCategory($id);
	}



	public function getProductsByCategory($category)
	{

		// get product by category
		$products = $this->productmodel->getAllProductsByCategory($category);
		// parse into boxes

		$html = $this->productmodel->buildProductBoxes($products, $category);

		// render html and load view
		$data['view'] = 'main/products';
		$data['html'] = $html;
		$this->load->view('main_template', $data);
	}

	public function addToCart($product_id)
	{	
		// var_dump($this->session);
		// unset($_SESSION['cart']);
		$result = $this->productmodel->getProductById($product_id);
		$row = $result->row();
		if (!isset($_POST['quantity'])) {
			$row->quantity = 1;
		} else {
			$row->quantity = $_POST['quantity'];
		}

		if (!isset($_SESSION['cart'])) {
			$cart = new Cart(array($row));			
		} else {
			$cart = $this->getCartObject();
			$cart->addProductToCart($result->row());
		}
		$this->setCartObject($cart);
		redirect(base_url() . "shopping-cart");

		/*CI SESSION*/
		// if (!unserialize($this->session->userdata('cart'))) {
			
		// 	$result = $this->productmodel->getProductById($product_id);
		// 	$cart = new Cart(array($result->row()));
		// 	// $this->session->set_userdata('cart', serialize($cart));
			
		// 	$this->session->set_userdata(array('cart' => serialize($cart)));
		// 	echo "<pre>";

		// 	var_dump($this->session);
		// } else {

		// 	$result = $this->productmodel->getProductById($product_id);
		// 	$cart = unserialize($this->session->userdata('cart'));
		// 	$cart->addProductToCart($result->row());
		// 	$this->session->set_userdata('cart', serialize($cart));
		// 	echo "<pre>";
		// 	var_dump($this->session);
		// // 	$this->session->set_userdata(array('cart' => serialize($cart)));

		// }

		// $cart = unserialize($this->session->userdata('cart'));
		// var_dump($cart->getSubtotalPrice());
		// redirect(base_url() . "index.php/view_product/$product_id");
	}


	public function updateCart($product_id)
	{
		$quantity = $_POST['quantity'];
		$cart = $this->getCartObject();
		$cart->changeProductQuantity($product_id, $quantity);
		$this->setCartObject($cart);
		$this->loadShoppingCart();
	}
	public function removeFromCart($product_id)
	{
		$cart = $this->getCartObject();
		$cart->removeProduct($product_id);
		$this->setCartObject($cart);
		$this->loadShoppingCart();
	}


	public function viewProduct($product_id)
	{
		// echo "<pre>";
		// var_dump($this->session);
		// echo "</pre>";
		$result = $this->productmodel->getProductById($product_id);

		$row = $result->row();
		$row->price = number_format($row->price/100,2);
		if ($row->is_on_sale && $row->sale_price) {
			$row->sale_price = number_format($row->sale_price/100,2);
		}
		$data['view'] = 'main/product_view';
		$data['product_data'] = $row;
		$data['layout'] = "rightsidebar";
		$data['sidebar'] = "includes/aside";
		$data['view'] = 'main/product_view';
		$data['page_title'] = $row->name;
		$data['sub_header'] = "Military grade faraday bag";
		$data['title'] = $data['page_title'] . " | " . $data['sub_header'] . " | " . "EMP faraday bags";
		
		$this->load->view('main_template', $data);

	}

	public function viewCart()
	{

		if ($data['cart'] = $this->getCartObject()) {
			# code...
		}
		// echo "<pre>";
		// var_dump($data['cart']);
		$data['title'] = "Your Shopping Cart";
		$data['page_title'] = "Shopping Cart";
		$data['sub_header'] = "Edit and view your cart";
		$data['layout'] = "fullwidth";
		$data['view'] = 'main/cart';
		$this->load->view('main_template', $data);
	}

	public function checkOut()
	{
		$data['title'] = "Tech Protect Check out Form | EMP Faraday Bags";
		$data['page_title'] = "Check out";
		$data['sub_header'] = "Please fill out the form below";
		$data['layout'] = "fullwidth";
		
		$data['view'] = 'main/check_out_form';
		$data['cart'] = $this->getCartObject();
		$this->load->view('main_template', $data);
	}

	public function completeCheckOut()
	{
		// var_dump($_POST);
		$cart = $this->getCartObject();
		$this->load->file('./stripe/config.php');

		$token  = $_POST['stripeToken'];
 
 		try{
			$customer = Stripe_Customer::create(array(
				'email' => $_POST['email'],
				'card'  => $token
			));

 			$charge = Stripe_Charge::create(array(
				'customer' => $customer->id,
				'amount'   => $cart->getTotalPrice(),
				'currency' => 'usd',
				'description' => 'Customer Email: ' . $_POST['email'],
			));
 		// 	$data['view'] = 'main/thank_you';
			// $this->load->view('main_template', $data);
 			// echo "Thank you for your purchase, <pre>";
			// var_dump($_POST);
 		} catch (Stripe_CardError $e) {
 			// handle error
 			echo "NO GOOD!";
 		}

 		$this->productmodel->insertNewPurchase($cart, $_POST);
 		$this->sendConfirmationEmail();

 		$_SESSION['recent_purchase'] = true;

		redirect(base_url() . 'products/thankYou');
	}

	public function foreachProducts()
	{
		$cart = $this->getCartObject();
		foreach ($cart->getProducts() as $key) {
			echo "<pre>";
			var_dump($key);
		}
	}

	public function sendConfirmationEmail()
	{
		$to = $_POST['email'];
	
		$subject = "Purchase Confirmation.";

		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= "Content-type: text/html\r\n"; 
		$headers .= "From: info@techprotectbag.com\r\n";
		$headers .= "Reply-to: info@techprotectbag.com\r\n";

		$message =  $this->generateReceiptEmail($this->getCartObject());




		if(mail($to, $subject, $message, $headers)) {
			$message = $this->getRecentPurchaseEmail($this->getCartObject());
			mail('info@techprotectbag.com', "New Purchase to Website", $message, $headers);
			// mail('himmerman@gmail.com', "New Purchase to Website", $message, $headers);
		} else {

		}
	}

// EMAIL SENT TO ADMIN
	private function getRecentPurchaseEmail($cart)
	{
		$base_url = base_url();
		$html = <<<HTML
			<html>
			<head>
				<title></title>
				<link href="{$base_url}assets/styles/email.css" rel="stylesheet" type="text/css">
			</head>
			<body>

HTML;
		$html .= '<h1>A recent purchase has been made.</h1>';
		$html .= "<p>Below is a copy of the receipt sent to the Customer. They will recieve another email when their purchase has shipped and it has been \"Fulfilled\" on the website. Manage the purchase by logging into <a href='http://americanwoodarts.com/admin'>americanwoodarts.com/admin</a>.</p>";
		
		$html .= '<table id="cart_products">';
		$html .= '<tr class="table_head"><th>Product Details</th><th>SKU</th><th>Price</th><th>Quantity</th><th>Subtotal</th></tr>';

		$products = $cart->getProducts();

		$subtotal = money_format('%i', $cart->getSubtotalPrice()/100);
		$total = money_format('%i', $cart->getTotalPrice()/100);


		for ($i=0; $i < count($products); $i++) { 
			$result = $this->productmodel->getProductStockCount($products[$i]->id);
			$stock = $result->row();
			$stock_status = "In Stock";
			if ($products[$i]->quantity > $stock->quantity) {
				$stock_status = "Back Ordered";
			}

			$quantity_field = $products[$i]->quantity;

			$price = money_format('%i', $products[$i]->price/100);
			$row_subtotal = money_format('%i', $products[$i]->quantity * $products[$i]->price/100);
			$shipping = $cart->getShippingCost();
			$shipping = money_format('%i', $shipping/100);
			$html .= <<<HTML
				<tr>
					<td>
						<img style="width: 300px" src='{$products[$i]->photo}'>
						<ul>
							<li>{$products[$i]->name}</li>
							<li>Made of {$products[$i]->wood_name}</li>
							<li><span class="orange">$stock_status</span></li>
						</ul>
					</td>
					<td>
						{$products[$i]->productCode}
					</td>
					<td>
						\${$price}
					</td>
					<td>
						{$quantity_field}
					</td>
					<td>
						\${$row_subtotal}
					</td>

				</tr>
HTML;
			}
		$html .= <<<HTML
		</table>
		<ul>
			<li>Subtotal: {$subtotal} </li>
			<li>Shipping: {$shipping}</li>
			<li>Total: {$total}</li>
		</ul>
		
	</body>
</html>
HTML;

		return $html;
	}


// EMAIL SENT TO CUSTOMER
	private function generateReceiptEmail($cart)
	{
		$base_url = base_url();
		$html = <<<HTML
			<html>
			<head>
				<title></title>
				<link href="{$base_url}assets/styles/email.css" rel="stylesheet" type="text/css">
			</head>
			<body>

HTML;
		$html .= '<h1>Thank you for your purchase</h1>';
		$html .= "<p>Below is a copy of your receipt. You should recieve another email when your purchase has shipped. Expect your purchase to arrive 3-7 business days after that second email.</p>";
		$html .= "<p>If a product in your order is back ordered then expect that email to arrive later than usual.</p>";
		$html .= '<table id="cart_products">';
		$html .= '<tr class="table_head"><th>Product Details</th><th>SKU</th><th>Price</th><th>Quantity</th><th>Subtotal</th></tr>';

		$products = $cart->getProducts();

		$subtotal = money_format('%i', $cart->getSubtotalPrice()/100);
		$total = money_format('%i', $cart->getTotalPrice()/100);


		for ($i=0; $i < count($products); $i++) { 
			$result = $this->productmodel->getProductStockCount($products[$i]->id);
			$stock = $result->row();
			$stock_status = "In Stock";
			if ($products[$i]->quantity > $stock->quantity) {
				$stock_status = "Back Ordered";
			}

			$quantity_field = $products[$i]->quantity;

			$price = money_format('%i', $products[$i]->price/100);
			$row_subtotal = money_format('%i', $products[$i]->quantity * $products[$i]->price/100);
			$shipping = $cart->getShippingCost();
			$shipping = money_format('%i', $shipping/100);
			$html .= <<<HTML
				<tr>
					<td>
						<img style="width: 300px" src='{$products[$i]->photo}'>
						<ul>
							<li>{$products[$i]->name}</li>
							<li>Made of {$products[$i]->wood_name}</li>
							<li><span class="orange">$stock_status</span></li>
						</ul>
					</td>
					<td>
						{$products[$i]->productCode}
					</td>
					<td>
						\${$price}
					</td>
					<td>
						{$quantity_field}
					</td>
					<td>
						\${$row_subtotal}
					</td>

				</tr>
HTML;
			}
		$html .= <<<HTML
		</table>
		<ul>
			<li>Subtotal: {$subtotal} </li>
			<li>Shipping: {$shipping}</li>
			<li>Total: {$total}</li>
		</ul>
		<p>Feel free to contact us at americanwoodarts@gmail.com. Thank you for your business and have a great day.</p>
	</body>
</html>
HTML;

		return $html;
	}

	public function applyPromoCode()
	{
		$promo_code = $_GET['promo_code'];

		$promo = $this->productmodel->getPromoCode($promo_code);

		// $this->load->file('./stripe/lib/Stripe.php');
		// Stripe::setApiKey("sk_live_xWXnKF20CO65PDXWf3QU3qnS");
		// try {
		// 	$promo = Stripe_Coupon::retrieve($promo_code);
		// } catch (Exception $e) {
		// 	$promo = null;
		// }

		$cart = $this->getCartObject();

		if (is_object($promo)) {

			$type = "";
			
			if(!$promo->max_redemptions || ($promo->redemptions < $promo->max_redemptions)) {

				if ($promo->percent_off) {
					$type = "percent";
					$cart->setDiscount($promo->code, $promo->percent_off, $type, $promo->free_shipping);
					$this->setCartObject($cart);
				} elseif ($promo->amount_off) {
					$type = "amount";
					$cart->setDiscount($promo->code, $promo->amount_off, $type, $promo->free_shipping);
					$this->setCartObject($cart);
				}
			}
		} else {
			$cart->setDiscount(null, null, null);
			$this->setCartObject($cart);
		}
		redirect(base_url() . "shopping-cart");
	}

	public function thankYou()
	{
		if (isset($_SESSION['recent_purchase']) && isset($_SESSION['cart'])) {
	 		$data['cart'] = $this->getCartObject();
	 		$data['view'] = 'main/thank_you';
	 		$data['no_buttons'] = true;
	 		$this->unsetCart();
	 		unset($_SESSION['recent_purchase']);
	 		$this->load->view('main_template', $data);
 		} else {
 			redirect(base_url());
 		}
	}

	private function loadShoppingCart()
	{
		redirect(base_url() . "shopping-cart");
	}

	private function setCartObject($cart)
	{
		$_SESSION['cart'] = serialize($cart);
	}
	private function getCartObject()
	{
		if (isset($_SESSION['cart'])) {
			return unserialize($_SESSION['cart']);
		} else {
			$cart = $cart = new Cart(array());
			$_SESSION['cart'] = serialize($cart);
			return unserialize($_SESSION['cart']);
		}
	}
	private function unsetCart()
	{
		unset($_SESSION['cart']);
	}
}