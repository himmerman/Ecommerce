<h2>Add New Shipping Rate</h2>
<form action='<?= base_url()?>admin/insertShipping' method='post' id='productForm' enctype="multipart/form-data" onsubmit="">

	<label><span class="required">*</span>Minimum Cart Price</label><input id="" name="min_cart_price" placeholder="i.e. 0.00" type="text">
	<label><span class="required">*</span>Maximum Cart Price</label><input id="" name="max_cart_price" placeholder="i.e. 3.45" type="text" value="">
	<label><span class="required">*</span>Shipping Price</label><input id="" name="shipping_price" type="text" placeholder="i.e. 5.54" value="">

	<button id="adminSave">Save</button>

</form>