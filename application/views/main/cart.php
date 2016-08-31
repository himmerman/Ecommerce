<div class="fullwidth">
	<?php
	// $cart->getShippingCost();
	// echo "<pre>";
	// var_dump($cart);
	// echo "</pre>";
	$products = null;
	if (is_object($cart)) {
		$products = $cart->getProducts();
	} else{
		$products = array();
	}

	$quantity = 0;
	foreach ($products as $product) {
		$quantity += $product->quantity;
	}
?>
	<div class="two_third cartbox">
	<h4 class="fancytitle orange"><?= $quantity?> Items In Your Cart</h4>
<?
	$base_url = base_url();	
	if (count($products) > 0) {
		for ($i=0; $i < count($products); $i++) { 
		$result = $this->db->query('SELECT quantity FROM product WHERE id = ?', array($products[$i]->id));
		$stock = $result->row();
		$stock_status = "In Stock";
		if ($products[$i]->quantity > $stock->quantity) {
			$stock_status = "Back Ordered";
		}

		$quantity_field = '<form action="'.$base_url.'products/updateCart/'.$products[$i]->id.'" method="POST">
					<input type="number" name="quantity" value="'.$products[$i]->quantity.'" min="0">
					<button class="btn center medium full charcoal iva_anim">Update</button>
				</form>';
		$delete_row = "<a href='{$base_url}products/removeFromCart/{$products[$i]->id}' class='red'>X</a>";
		$price = number_format($products[$i]->price/100, 2);
		if ($products[$i]->is_on_sale) {
			$sale_price = number_format($products[$i]->sale_price/100, 2);
			$row_subtotal = number_format($products[$i]->quantity * $products[$i]->sale_price/100, 2);

		} else {
			$row_subtotal = number_format($products[$i]->quantity * $products[$i]->price/100, 2);
		}

		$shipping = $cart->getShippingCost();
	
	?>


		<div class="one_third">
			<div class="imageframe">
			<a href="<?= base_url()?>product/<?= $products[$i]->id?>"><img src="<?= $products[$i]->photo?>"></a>
			</div>
			<p><?= $stock_status ?></p>
		
		</div>
		<div class="one_third">
			<h5><a href="<?= base_url()?>product/<?= $products[$i]->id?>"><?= $products[$i]->name ?></a></h5>
			<? if ($products[$i]->is_on_sale) {
				echo "<p class='original'>\${$price}</p>";
				echo "<p><span class='sale_price'>\${$sale_price}</span> each</p>";
			} else {

				echo "<p class='cart_price'>\${$price} each</p>";
			}
			?>
			
		</div>
		<div class="one_third last">
			<div class="one_half">
				<?= $quantity_field ?>
			</div>
			<div class="one_half last">
				<p class="price">$<?= $row_subtotal ?></p>
				<?= $delete_row ?>
			</div>
		</div>
		<!-- <div class="one_fifth cartbox">
		<h4 class="fancytitle orange">SKU</h4>
		</div> -->
		
		<div class="divider fat"></div>
	<?
		}
	}
	?>
	</div>
	<div class="one_third last">
		<h4 class="fancytitle charcoal large">Cart Summary</h4>
		<form id="promo_form" method="GET" action="products/applyPromoCode">
			
			<p><label>Promo Code</label> <input type="text" name="promo_code" value="<?= ($promo_code = $cart->getPromoCode()) ? $promo_code: '' ?>"><button class="right btn full large charcoal iva-anim no-border">Apply</button></p>

			
		</form>
		<table class="cart-summary">
			<tr><td class="left">Subtotal</td>			<td class="right">$<?= number_format($cart->getSubtotalPrice()/100, 2)?></td></tr>
			<tr><td class="left">Shipping</td>			<td class="right">$<?= number_format($cart->getShippingCost()/100, 2)?></td></tr>
			<?
			if ($cart->getPromoCode() != null) {
				?>
				<tr><td class="left">Discount</td>		<td class="right">-$<?= number_format($cart->getDiscountAmount()/100, 2)?></td></tr>
				<?
			}
			?>
			<tr><td class="left total">Total</td>		<td class="right total">$<?= number_format($cart->getTotalPrice()/100, 2)?></td></tr>
		</table>
		
		<a  href="<?= base_url()?>check-out" class="orange checkout">Check out</a>
		
	
	</div>

</div>












