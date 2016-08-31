<h2><?=$product->name?></h2>

<form action='<?= base_url()?>admin/updateProduct' method='post' id='productForm' enctype="multipart/form-data">
	<input type="text" id="admin-product_id" name="id" readonly="readonly" value="<?=$product->id?>">
	<label><span class="required">*</span>Product Photo:</label><input name="file" type="file" value='<?= $product->photo?>'>
	<label><span class="required">*</span>Product Name:</label><input name="name" type="text" value='<?=$product->name?>'>
	<label><span class="required">*</span>Product Code:</label><input name="productCode" type="text" value='<?=$product->productCode?>'>
	<label><span class="required">*</span>Product Price: $</label><input name="price" type="text" value='<?=number_format($product->price / 100, 2); ?>'>
	<label><span class="required">*</span>Product Quantity:</label><input name="quantity" type="text" value='<?=$product->quantity?>'>
	
	<label>Product Width:</label><input name="width" step=".01" min="0" type="number" value='<?=$product->width?>'>
	<label>Product Height:</label><input name="height" step=".01" min="0" type="number" value='<?=$product->height?>'>
	<label>Product Depth:</label><input name="depth" step=".01" min="0" type="number" value='<?=$product->depth?>'>			
	<!-- <label>Is Package?</label><input name="is_package" type="checkbox"> -->
	<label>Product Description: </label><textarea id = "pDescription" name="description" placeholder="Description..."><?= $product->description?></textarea>
	<label>Featured? </label> <input type="checkbox" id="pFeatured" name="featured" <?= $product->featured ? 'checked' : ''?> >
	<label>On Sale? </label> <input type="checkbox" id="pFeatured" name="is_on_sale" <?= $product->is_on_sale ? 'checked' : ''?> >
	<label>Sale Price $</label><input name="sale_price" type="text" value='<?=number_format($product->sale_price / 100, 2); ?>'>
	<label>Tags:</label><input name="tags" type="text" value="<?=$product->tags?>" placeholder="keywords for search such as: tag, tag2, tag3">
	<button id="adminSave">Save</button>
</form>
<img id="productImage" src="<?=$product->photo?>">