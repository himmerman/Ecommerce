<?= $this->load->view('includes/header')?>
<div class="clear"></div>
<div id="subheader">
	<div class="inner">
		<div class="subdesc">
			<h1 class="page-title"><?= $page_title?></h1>
			<div class="customtext"><h2><?= $sub_header?></h2></div>
		</div>
	</div>
</div><!-- #subheader -->
<div class="pagemid">
	<div class="inner">
		<div id="main">
			<div class="entry-content">
			<?= $this->load->view($view)?>
			</div>
		</div>
		<?
			if ($layout == "rightsidebar") {
				echo $this->load->view($sidebar);
			}
		?>
			<div class="clear"></div>
	</div> <!-- .inner -->
</div> <!-- .pagemid -->


<?= $this->load->view('includes/footer')?>
	</div><!-- #wrapper -->
</div>
</body>


</html>
