
		
		<?= $this->load->view('includes/header')?>
		
		<div class="clear"></div>

		<div id="featured_slider">
			<div class="slider_stretched">
			<script type="text/javascript">
				jQuery(document).ready(function($) {
					jQuery(".flexslider").flexslider({
						animation: "fade",
						controlsContainer: ".flex-container",
						slideshow: true,
						slideshowSpeed: 3000,
						animationDuration: 400,
						directionNav: true,
						controlNav: false,
						mousewheel: false,
						smoothHeight :true,
						start: function(slider) {
							jQuery(".total-slides").text(slider.count);
						},
						after: function(slider) {
							jQuery(".current-slide").text(slider.currentSlide);
						}
					});
				});	
			</script>
				<div class="clearfix" id="slider_bg">
			<div class="planbox_slider">
				<div class="two_third">
					<div class="plan_box">
						<div class="plan_info" style="top: 0px;">
							<div class="content">
								<iframe  src="https://www.youtube.com/embed/0ijlkAmAiSc" frameborder="0" allowfullscreen></iframe>
							</div>
						</div>
						<div class="plan_details">
							<div class="content">

							</div>
						</div>
					</div>
				</div>

				<div class="one_third last">
					<div class="plan_box">
						<div class="plan_info" style="top: 0px;">
							<div class="content">
								<h4>About Tech Protect Bags</h4>
								<div class="divider_line"></div>
								<p>There has never been an easier way to protect your critical electronics. EMP Bags are designed to protect against damaging EMP current. One cannot predict the size, strength, or proximity of an EMP, but by using our bags, electronics should be protected. It is our highest recommendation that you “nest” items inside multiple layers of protection for best results. This can be achieved by double bagging or storing your EMP bags inside a metal container. More layers = more protection.</p>
								<!-- <div class="divider_line"></div> -->
								
									<a class=" btn  medium  charcoal    iva_anim " href="<?= base_url()?>products"><span>Order Now</span></a>
							</div>
						</div>
						<div class="plan_details">
							<div class="content">
								<a class=" btn  medium  charcoal    iva_anim " href="#"><span>Order Now</span></a>
							</div>
						</div>
					</div>
				</div><!-- one_third last -->
				<div class="clear"></div>
			</div>	<!-- planbox_slider -->
		</div><!-- #slider_bg -->
		
		<div class="pagemid_section">
			<script type="text/javascript">
			jQuery(document).ready(function() {
				atpcustom.MySlider(3000,"testimonial70");
			});
			</script>
			
			<div class="section_row clearfix" style="padding:20px 0;color:#ffffff;">
				<div class="section_bg orange"></div>
					<div class="section_inner">
						<div data-id="fadeInDown" class="custom-animation iva_anim">
							<div  class="callOutBox iva_anim" >
								<div class="teaser_Content">
									<div class="callOut_Text">
										<h2 class="callOut_Heading"> Military Grade <strong>Faraday Bags!</strong></h2>
										<p>Protect your tech, cell phones, computers, and TV's from an EMP attack</p>
									</div>
									<div class="callOut_Button"><a class="btn large flat charcoal" href="<?= base_url()?>products"><span>Shop Now!</span></a></div>
								</div>
							</div>
						</div>
					</div><!-- .section_inner -->
			</div><!-- .section_row -->
			<div class="section_row clearfix">
				<div class="section_bg" style="background-color:#e0e0e0;"></div>
					<div class="section_inner">
						<h1 class="center">Featured Products</h1>
							<div data-id="bounceIn" class="pricetable  iva_anim">
								<div class="pricing-inner">

								<? foreach ($featured as $product) {
									$price = "$" . number_format($product->price / 100, 2);
									echo <<<HTML
									<div class="column">
										<div class='price-head'>
											<h2 class="title">{$product->name}</h2>
											<h4 class="price-font">$price</h4>

										</div>
										<div class="price-content">
											<div class='ribbon'><img src='assets/images/ribbons/04.png'></div>
											<img src="$product->photo">
											<p class="center"><a href="product/$product->id" class='btn center medium full charcoal iva_anim '><span >View Product</span></a></p>
										</div>
									</div>


HTML;
								}
								?><!-- .column -->
									
									
								</div><!-- .pricing-inner -->
								
								<div class="clear"></div>
							</div><!-- .pricetable -->
					</div><!-- .section_inner -->
			</div><!-- .section_row -->
			<div class="section_row clearfix">
				<div class="section_bg"></div>
					<div class="section_inner">
						<div data-id="fadeInUp" class="custom-animation center iva_anim">
							<h1><strong>Phone Orders:</strong>  (832) 627-2325</h1>
								<div  class="messagebox info center clearfix iva_anim">
									Office is open from Monday - Friday, 9:00 am - 5:00 pm CST<br />
								</div>
						</div>
						<div class="demo_space"></div>
						
						<div class="one_fourth">
							<div class="iva_anim facnyicon_circle large center animated bounceIn" style="background-color:#494949; border-color:#494949;">
								<a href="<?= base_url() ?>videos"><i class="fa fa-video-camera" style="color:#ffffff;"></i></a>
							</div>
							<a href="<?= base_url() ?>videos"><h4 class="center">Videos</h4></a>
							<p>View videos on how the Tech Protect bags work as well as the type of protection they give.<br /></p>
						</div><!-- .one_fourth -->
						
						<div class="one_fourth">
							<div class="iva_anim facnyicon_circle large center animated bounceIn" style="background-color:#494949; border-color:#494949;">
								<a href="<?= base_url() ?>news"><i class="fa  fa-bullhorn" style="color:#ffffff;"></i></a>
							</div>
							<a href="<?= base_url() ?>news"><h4 class="center">News</h4></a>
							<p>Get the latest info on EMPs and Solar Flares to stay informed and be prepared for possible events.<br /></p>
						</div><!-- .one_fourth -->
						
						<div class="one_fourth">
							<div class="iva_anim facnyicon_circle large center animated bounceIn" style="background-color:#494949; border-color:#494949;">
								<a href="<?= base_url() ?>faqs"><i class="fa fa-question" style="color:#ffffff;"></i></a>
							</div>
								<a href="<?= base_url() ?>faqs"><h4 class="center">FAQ's</h4></a>
								<p>Want answers? See common questions that people just like you ask and get a clear answer to your concerns.<br /></p>
						</div><!-- .one_fourth -->
						
						<div class="one_fourth last">
							<div class="iva_anim facnyicon_circle large center animated bounceIn" style="background-color:#494949; border-color:#494949;">
								<a href="<?= base_url() ?>contact"><i class="fa fa-envelope" style="color:#ffffff"></i></a>
							</div>
							<a href="<?= base_url() ?>contact"><h4 class="center">Contact Us</h4></a>
							<p>Feel free to contact us via Email or Phone.<br />
						</div><!-- .one_fourth last -->
						
						<div class="clear"></div>
						
					</div><!-- .section_inner -->
			</div><!-- .section_row -->
			
			

			
		</div><!-- .pagemid_section -->

		<?= $this->load->view('includes/footer')?><!-- #footer -->
	</div><!-- #wrapper -->
</div>
<!-- #layout -->
	
<div id="back-top"><a href="#header"><span></span></a></div>
<script type='text/javascript' src='<?= base_url() ?>assets/js/sys_custom.js'></script>
</body>


</html>