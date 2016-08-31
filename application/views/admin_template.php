<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to Admin Panel</title>
	<link rel="stylesheet" type="text/css" href="<?= base_url()?>/assets/styles/admin.css">
	<script src="<?= base_url()?>assets/js/admin.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
</head>
<body>

<div id="container">
	<h1>Admin Panel</h1>
	<nav>
		<ul>
			<li><a href="<?= base_url()?>admin">Main</a></li>
			<li><a href="<?= base_url()?>admin/purchases">Purchases</a></li>
			<li><a href="<?= base_url()?>admin/products">Products</a></li>
			<!-- <li><a href="<?= base_url()?>admin/categories">Categories</a></li> -->
			<li><a href="<?= base_url()?>admin/promos">Promotionals</a></li>
			<li><a href="<?= base_url()?>admin/shipping">Shipping</a></li>
			<li><a href="<?= base_url()?>admin/logOut">Log Out</a></li>
		</ul>
	</nav>
	<div id="body">
		<?= $this->load->view($view, '', true) ?>

		
	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</div>

</body>
</html>

