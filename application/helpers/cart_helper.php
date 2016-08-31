<?php
/**
* SHOPPING CART OBJECT
*/
class Cart
{
	private $products = array();
	private $shipping_cost;
	private $subtotal_price = 0;
	private $total_price = 0;
	private $discount_code= null;
	private $discount_amount = 0;
	private $discount_type = null;
	private $free_shipping = false;

	function __construct($products)
	{
		if (count($products) > 0) {
			for ($i=0; $i < count($products); $i++) { 
				$this->addProductToCart($products[$i]);
			}
		}
		
	}

	/*SETTERS*/
	public function setDiscount($code, $amount, $type, $free_shipping = false) {
		$this->discount_amount = $amount;
		$this->discount_code = $code;
		$this->discount_type = $type;
		$this->free_shipping = $free_shipping;
	}

	public function addProductToCart($product_row)
	{
		for ($i=0; $i < count($this->products); $i++) { 
			if ($this->products[$i]->id == $product_row->id) {
				$this->products[$i]->quantity += $product_row->quantity;
				return true;
			} 
		}

		$this->products[] = $product_row;
	}
	
	public function removeProduct($product_id)
	{
		for ($i=0; $i < count($this->products); $i++) { 
			if ($this->products[$i]->id == $product_id) {
				unset($this->products[$i]);
				$switch = array_values($this->products); 
				$this->products = $switch;
				return true;
			}
			
		}
		return false; // product not found in cart
	}

	public function changeProductQuantity($product_id, $quantity)
	{
		if ($quantity == 0) {
			$this->removeProduct($product_id);
			return true;
		}
		for ($i=0; $i < count($this->products); $i++) { 
			if ($this->products[$i]->id == $product_id) {
				$this->products[$i]->quantity = $quantity;
				return true;
			}
		}

		return false;
	}

	// private function addPrice($price)
	// {
	// 	$this->subtotal_price += $price;
	// }

	/*GETTERS*/
	public function getProducts()
	{
		return $this->products;
	}

	public function getShippingCost()
	{
		if (count($this->products) > 0 && !$this->free_shipping) {
			$this->getSubtotalPrice();
			$subtotal = $this->subtotal_price / 100;
			$CI =& get_instance();
			$this->shipping_cost = $CI->productmodel->getShippingPrice($subtotal);
			// if ($this->subtotal_price < 3500 && count($this->products) > 0) {
			// 	$this->shipping_cost = 600;
			// } else {
			// 	$this->shipping_cost = 0;
			// }
			return $this->shipping_cost;
		} else{
			return 0;
		}
		
	}

	public function getSubtotalPrice()
	{	
		$this->subtotal_price = 0;
		for ($i=0; $i < count($this->products); $i++) { 
			if ($this->products[$i]->is_on_sale) {
				$this->subtotal_price += ($this->products[$i]->sale_price * $this->products[$i]->quantity);	
			} else {
				$this->subtotal_price += ($this->products[$i]->price * $this->products[$i]->quantity);
			}
		}
		return $this->subtotal_price;
	}

	public function getTotalPrice()
	{
		$this->getSubtotalPrice();
		$this->getShippingCost();
		$this->total_price = ($this->subtotal_price + $this->shipping_cost) - $this->getDiscountAmount();
		return $this->total_price;
	}

	private function calculateDiscount()
	{
		$subtotal_price = $this->getSubtotalPrice();
		// check if it is a percentage or whole amount
		if($this->discount_type == 'percent') {
			$discount = $subtotal_price * ($this->discount_amount / 100);
			$discount = round($discount/100, 2)*100;
			return $discount;
		} elseif($this->discount_type == 'amount') {
			return $this->discount_amount;
		} else {
			return 0;
		}
	}	
	public function getDiscountAmount()
	{
		return $this->calculateDiscount();
	}

	public function getPromoCode()
	{
		return $this->discount_code;
	}

	
}
?>