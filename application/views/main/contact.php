	<h3>Fill out the form to contact us</h3>  
     
    <form class="large_form" method="post" action="main/sendEmail" onsubmit="return validateCheckOutForm()">
	    <p class="red message" id="contact">
	        <?php
	            if (isset($_SESSION['contact_sent'])) {
	                echo "Thank you for your email. A representative will be in contact with you shortly";
	                unset($_SESSION['contact_sent']);
	            }
	        ?>
	    </p>     
        <p>
            <input placeholder="Your Name" class="required" name="name" type="text">
        </p>
        <p>
            <input placeholder="Your Email addresss" class="required" name="email" type="email">
        </p>
        <p>
            <input placeholder="The message's subject" class="required" name="subject" type="text">
        </p>
        <p>
            <textarea placeholder="Your message goes here" class="required" name="message"></textarea>
        </p>
        <br>
        <button class="btn full orange large no-border iva-anim">Send Mail</button>

    </form>
    <script src="<?= base_url()?>assets/js/validate_form.js"></script>