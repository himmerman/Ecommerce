<h2>Edit multiple products</h2>

<form action='<?= base_url()?>admin/updateMultiProducts' method='post' id='productForm' enctype="multipart/form-data">
	
	<!-- product list -->
	<?php 
		$id_string = json_encode($products);

		// echo $id_string;
		echo "<input class='hidden' name='ids' value='{$id_string}'/>";
		// var_dump($products);
	?>
	<!-- price -->
	<label><span class="required">*</span>Product Price: $</label><input id="pPrice" name="price" type="text" value=''>
	
	<!-- wood -->
	<label>Wood:</label>
	<select id="pWood" name="wood">
		<?= $wood ?>
	</select>
	
	<label>Product Quantity:</label><input id="pQuantity" name="quantity" type="text" value=''>

	<!-- categories -->
	<label>Categories:</label>
		<?= $cat?>		

	<input type="submit"/>
</form>