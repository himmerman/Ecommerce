
<?php 
if (isset($addFunction)) {
	echo "<h2>{$addFunction} Page</h2>";

	echo '<a id="add" href="' . base_url() . 'admin/add' . $addFunction . '">+ Add New ' . $addFunction . '</a>';
}


?>
<?= $html?>