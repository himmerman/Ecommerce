<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>
	<link rel="stylesheet" type="text/css" href="<?= base_url()?>/assets/styles/admin.css">
	<script src="<?= base_url()?>assets/js/admin.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
</head>
<body>

<div id="container">
	<h1>Administratory Login</h1>
	<form action="main/adminLogin" method="POST">
		<input type="text" name="username" placeholder="username/email"><br>
		<input type="password" name="password" placeholder="password"><br>
		<input type="submit" value="Sign In">
	</form>
</div>
</body>