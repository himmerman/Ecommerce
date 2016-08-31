
<div class="one_half product">
	<?php
		$base = base_url();
		if ($product_data->is_on_sale) {
			echo "<div class='ribbon'><img src='{$base}assets/images/ribbons/25.png'></div>";
			
		}
	?>
	<div class="imageframe">
	<img src="<?= $product_data->photo?>">
	</div>
</div>
<div class="one_half last">
	<h2><?= $product_data->name?></h2>
	<?php 
		if ($product_data->is_on_sale) {
			echo "<p class='original'><span>$</span>{$product_data->price}</p>";
			echo "<h3 class='sale_price'><span>$</span>{$product_data->sale_price}</h3>";
		} else{
			echo "<h3 class='sale_price'><span>$</span>{$product_data->price}</h3>";
		}

	?>
	<!-- <h3>$<?= $product_data->price?></h3> -->
	<form class="product_form" action="<?= base_url()?>products/addToCart/<?=$product_data->id?>" method="post">
		<p><label for="quantity">Quantity: </label><input type="number" step="1" min="1" name="quantity" value="1"></p>
		<input type="hidden" value="<?= $product_data->id?>">
		<button class="btn center medium full charcoal iva_anim" type="submit">+<i class="fa fa-shopping-cart"> </i> Add to Cart</button>
	</form>
	<p>Product Code: <?= $product_data->productCode?></p>



</div>
<div class="clear"></div>
<div class="fullwidth">
	<h2>Product Description</h2>
	<p>Width: <?= $product_data->width?> inches</p>
	<p>Height: <?= $product_data->height?> inches</p>
	<div>
		<?= $product_data->description?>
	</div>
</div>


