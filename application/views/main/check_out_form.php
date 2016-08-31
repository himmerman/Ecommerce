
	

<form class="large_form" method="post" onsubmit="return validateCheckOutForm()" action="https://www.paypal.com/cgi-bin/webscr">
	<div class="one_third">
		
		<input type='hidden' name='cmd' value="_cart"/>
		<input type="hidden" name="upload" value="1">
		<input type="hidden" name="business" value="info@techprotectbag.com">
		
		<input type="hidden" name="return" value="<?= base_url()?>thank-you">

		<input type="hidden" name="handling_1" value="<?= number_format($cart->getShippingCost()/100, 2)?>">
		<?
		$count = 1;
		$discount = 0;
		foreach ($cart->getProducts() as $product) {
			echo "<input type='hidden' name='item_name_{$count}' value='{$product->name}'>";
			echo "<input type='hidden' name='amount_{$count}' value='" . number_format($product->price/100, 2) . "'>";
			echo "<input type='hidden' name='quantity_{$count}' value='{$product->quantity}'>";
			if ($product->is_on_sale) {
				$discount += number_format(($product->price - $product->sale_price)/100, 2);
				echo "<input type='hidden' name='discount_amount_{$count}' value='" . number_format(($product->price - $product->sale_price)/100, 2) . "'>";
			}
			$count++;
		}


		if ($cart->getPromoCode() != null) {
			$discount += number_format($cart->getDiscountAmount()/100, 2);
			echo "<input type='hidden' name='discount_amount_cart' value='{$discount}'>";
		}
	

		?>
 			

	<!-- Customer Info -->
		<h2>Customer Information</h2>
		<p>
			<span class="red">*</span><input onchange="validateCheckOutForm()" placeholder="Your First Name" class="required" type="text" id="firstName" name="first_name">	</p>
		<p>
			<span class="red">*</span><input onchange="validateCheckOutForm()" placeholder="Your Last Name" class="required" type="text" id="lastname" name="last_name">
		</p>
		<p>
			<span class="red">*</span><input onchange="validateCheckOutForm()" placeholder="Email address: you@email.com" class="required" id="email" type="email" name="email">
		</p>

	</div>
	<!-- Address/Shipping Info -->
	<div class="one_third">
		<h2>Shipping Address</h2>
		<p>
			<span class="red">*</span><input onchange="validateCheckOutForm()" placeholder="Street Address" class="required" type="text" placeholder="123 Maple St." id="streetAddress" name="address1">
		</p>
		<p>
			<span class="red">*</span><input placeholder="Street Address 2" type="text" placeholder="APT 12" id="streetAddress2" name="address2">
		</p>
		<p>
			<span class="red">*</span><input onchange="validateCheckOutForm()" placeholder="City" class="required" type="text" id="city" name="city">
		</p>
		<p>
		<span class="red">*</span>
		<select onchange="validateCheckOutForm()" class="required" id="state" name="state"> 
			<option value="" selected="selected">Select Your State</option> 
			<option value="AL">Alabama</option> 
			<option value="AK">Alaska</option> 
			<option value="AZ">Arizona</option> 
			<option value="AR">Arkansas</option> 
			<option value="CA">California</option> 
			<option value="CO">Colorado</option> 
			<option value="CT">Connecticut</option> 
			<option value="DE">Delaware</option> 
			<option value="DC">District Of Columbia</option> 
			<option value="FL">Florida</option> 
			<option value="GA">Georgia</option> 
			<option value="HI">Hawaii</option> 
			<option value="ID">Idaho</option> 
			<option value="IL">Illinois</option> 
			<option value="IN">Indiana</option> 
			<option value="IA">Iowa</option> 
			<option value="KS">Kansas</option> 
			<option value="KY">Kentucky</option> 
			<option value="LA">Louisiana</option> 
			<option value="ME">Maine</option> 
			<option value="MD">Maryland</option> 
			<option value="MA">Massachusetts</option> 
			<option value="MI">Michigan</option> 
			<option value="MN">Minnesota</option> 
			<option value="MS">Mississippi</option> 
			<option value="MO">Missouri</option> 
			<option value="MT">Montana</option> 
			<option value="NE">Nebraska</option> 
			<option value="NV">Nevada</option> 
			<option value="NH">New Hampshire</option> 
			<option value="NJ">New Jersey</option> 
			<option value="NM">New Mexico</option> 
			<option value="NY">New York</option> 
			<option value="NC">North Carolina</option> 
			<option value="ND">North Dakota</option> 
			<option value="OH">Ohio</option> 
			<option value="OK">Oklahoma</option> 
			<option value="OR">Oregon</option> 
			<option value="PA">Pennsylvania</option> 
			<option value="RI">Rhode Island</option> 
			<option value="SC">South Carolina</option> 
			<option value="SD">South Dakota</option> 
			<option value="TN">Tennessee</option> 
			<option value="TX">Texas</option> 
			<option value="UT">Utah</option> 
			<option value="VT">Vermont</option> 
			<option value="VA">Virginia</option> 
			<option value="WA">Washington</option> 
			<option value="WV">West Virginia</option> 
			<option value="WI">Wisconsin</option> 
			<option value="WY">Wyoming</option>
		</select>
	</p>
	<p>
		<span class="red">*</span><input onchange="validateCheckOutForm()" placeholder="Zip/Postal Code" class="required" type="text" id="zip" name="zip">
	</p>
<button id="customButton"  class="check_out btn full large orange iva-anim no-border">Check Out with Card/PayPal</button>
	<span class="red">Shipping restricted to the USA, please contact Tech Protect for outside USA shipping</span>
 
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.js"></script>

	
	
	

	<p>
		<span class="red">* - denotes a required field.</span>
	</p>
  </div>
</form>

<div class="one_third last">
		<h4 class="fancytitle green">Cart Summary</h4>
		<table class="cart-summary">
			<?
				foreach ($cart->getProducts() as $product) {
					if ($product->is_on_sale) {
						$price = $product->sale_price;
					} else {
						$price = $product->price;
					}

					$subtotal = number_format(($price * $product->quantity)/100, 2);
					echo "<tr><td class='product left'>{$product->name} X {$product->quantity}</td>   <td class='product right'>\${$subtotal}</td></tr>";
				}
			?>
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

		
		<!-- <a  href="<?= base_url()?>check-out" class="orange checkout">Check out</a> -->
		
	
	</div>

	<script src="<?= base_url()?>assets/js/validate_form.js"></script>