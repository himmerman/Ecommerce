<h2>Add New Product</h2>

<form action='<?= base_url()?>admin/insertProduct' method='post' id='productForm' enctype="multipart/form-data" onsubmit="return checkNewProductFields()">

	<label><span class="required">*</span>Product Photo:</label><input id="photo" name="file" type="file">
	<label><span class="required">*</span>Product Name:</label><input id="pName" name="name" type="text" value="">
	<label><span class="required">*</span>Product Code:</label><input id="pCode" name="productCode" type="text" value="">
	<label><span class="required">*</span>Product Price: $</label><input id="pPrice" name="price" type="text" value=''>
	<label><span class="required">*</span>Product Quantity:</label><input id="pQuantity" name="quantity" type="text" value=''>
	

	<label>Product Width:</label><input id="pWidth" name="width" step=".01" min="0" type="number" value=''>
	<label>Product Height:</label><input id="pHeight" name="height" step=".01" min="0" type="number" value=''>
	<label>Product Depth:</label><input id="pDepth" name="depth" step=".01" min="0" type="number" value=''>	
	<!-- <label>Categories:</label>
	<?= $cat?>		 -->
	<label>Product Description: </label><textarea id = "pDescription" name="description" placeholder="Description..."></textarea>
	<label>Tags:</label><input id="pTags" name="tags" type="text" value="" placeholder="keywords for search such as: tag, tag2, tag3">
	<button id="adminSave">Save</button>
</form>