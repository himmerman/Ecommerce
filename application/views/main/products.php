
				
				<?php
				$base = base_url();
				$i = 1;
				foreach ($products as $product) {	
					$sale = false;
					if ($i % 2 == 0) {
						$i = 0;
						$outer = '<div class="one_half last product"> <div  class="fancybox iva_anim">';
						// echo $box;
						
					} else {
						$outer = '<div class="one_half product"> <div  class="fancybox iva_anim">';
					}
					
					$box = $outer;
					
					if ($product->is_on_sale && !is_null($product->sale_price)) {
						// ONSALE!!!
						$base = base_url();
						$box .= <<<HTML
						<div class='ribbon'><a href="{$base}product/{$product->id}"><img src='{$base}assets/images/ribbons/25.png'></a></div>
						<h4 class="fancytitle orange"  style=""><a href="{$base}product/{$product->id}">$product->name</a></h4>
			<div class="boxcontent">
				
				<a href="{$base}product/{$product->id}"><img src="$product->photo"/></a>
				
				<div class="row">
					<div class="two_third addcart">
						<p><a href="{$base}products/addToCart/{$product->id}">+<i class="fa fa-shopping-cart"> </i> Add to cart</a></p>
						

					</div>

					
					<div class="one_third last sale">
						<p class="original"><a href="{$base}product/{$product->id}"><span>$</span>$product->price</a></p>
						<p class="sale_price"><a href="{$base}product/{$product->id}"><span>$</span>$product->sale_price</a></p>
					</div>
					
				</div>
			</div>
		</div>
	</div>
HTML;
					} else {

					
						$box .= <<<HTML
			<h4 class="fancytitle orange"  style=""><a href="{$base}product/{$product->id}">$product->name</a></h4>
			<div class="boxcontent">
				
				<a href="{$base}product/{$product->id}"><img src="$product->photo"/></a>
				
				<div class="row">
					<div class="two_third addcart">
						<p><a href="{$base}products/addToCart/{$product->id}">+<i class="fa fa-shopping-cart"> </i> Add to cart</a></p>
						
					</div>

					
					<div class="one_third last price">
						<p><a href="{$base}product/{$product->id}"><span>$</span>$product->price</a></p>
					</div>
					
				</div>
			</div>
		</div>
	</div>
HTML;
					}				
					
					echo $box;
					$i++;
				}
				?>
			
		


		
		