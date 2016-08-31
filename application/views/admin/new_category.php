<h1>New Category</h1>
<h3><i>Categories are automatically rendered as left menu items on the website so only add needed categories and remove unused ones</i></h3>
<form action="<?= base_url()?>admin/insertCategory" method="POST">
	<label>Name: </label><input type="text" name="name"><br>
	<label>Page SEO content: </label><br><textarea name="content" cols="50" rows="10" placeholder="SEO Content. Type here..."></textarea>
	<br><button>Save</button>
</form>