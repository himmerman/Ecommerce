

<h2>Edit Shipping Rate</h2>
<form action='<?= base_url()?>admin/updateShipping/<?= $shipping->id?>' method='post' id='productForm' enctype="multipart/form-data" onsubmit="">

	<label><span class="required">*</span>Minimum Cart Price</label><input id="" name="price_low" placeholder="i.e. 0.00" type="text" value="<?= $shipping->price_low?>">
	<label><span class="required">*</span>Maximum Cart Price</label><input id="" name="price_high" placeholder="i.e. 3.45" type="text" value="<?= $shipping->price_high?>">
	<label><span class="required">*</span>Shipping Price</label><input id="" name="shipping_price" type="text" placeholder="i.e. 5.54" value="<?= number_format($shipping->shipping_price/100, 2)?>">

	<button id="adminSave">Save</button>

</form>