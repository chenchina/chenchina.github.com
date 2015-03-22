<?php
/*
Template Name: Contact Form
*/
?>

<?php 
//If the form is submitted
if(isset($_POST['submitted'])) {

	//Check to see if the honeypot captcha field was filled in
	if(trim($_POST['checking']) !== '') {
		$captchaError = true;
	} else {
	
		//Check to make sure that the name field is not empty
		if(trim($_POST['contactName']) === '') {
			$nameError =  __('You forgot to enter your name.', 'colabsthemes'); 
			$hasError = true;
		} else {
			$name = trim($_POST['contactName']);
		}
		
		//Check to make sure sure that a valid email address is submitted
		if(trim($_POST['email']) === '')  {
			$emailError = __('You forgot to enter your email address.', 'colabsthemes');
			$hasError = true;
		} else if (!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", trim($_POST['email']))) {
			$emailError = __('You entered an invalid email address.', 'colabsthemes');
			$hasError = true;
		} else {
			$email = trim($_POST['email']);
		}
			
		//Check to make sure comments were entered	
		if(trim($_POST['comments']) === '') {
			$commentError = __('You forgot to enter your comments.', 'colabsthemes');
			$hasError = true;
		} else {
			if(function_exists('stripslashes')) {
				$comments = stripslashes(trim($_POST['comments']));
			} else {
				$comments = trim($_POST['comments']);
			}
		}
			
		//If there is no error, send the email
		if(!isset($hasError)) {
			
			$emailTo = get_option('colabs_contactform_email'); 
			$subject = __('Contact Form Submission from ', 'colabsthemes').$name;
			$sendCopy = trim($_POST['sendCopy']);
			$body = __("Name: $name \n\nEmail: $email \n\nComments: $comments", 'colabsthemes');
			$headers = __('From: ', 'colabsthemes') .' <'.$email.'>' . "\r\n" . __('Reply-To: ','colabsthemes') . $email;

			//Modified 2010-04-29 (fox)
			wp_mail($emailTo, $subject, $body, $headers);

			if($sendCopy == true) {
				$subject = __('You emailed ', 'colabsthemes').get_bloginfo('title');
				$headers = __('From: ','colabsthemes') . '<'.$emailTo.'>';
				wp_mail($email, $subject, $body, $headers);
			}

			$emailSent = true;

		}
	}
} ?>


<?php get_header(); ?>

<script type="text/javascript">
<!--//--><![CDATA[//><!--
jQuery(document).ready(function() {
	jQuery('form#frmcontact').submit(function() {
		jQuery('form#frmcontact .error').remove();
		var hasError = false;
		jQuery('.requiredField').each(function() {
			if(jQuery.trim(jQuery(this).val()) == '') {
                var labelText = jQuery(this).prev('label').attr('id');
				jQuery(this).parent().append('<span class="error"><?php _e('You forgot to enter your', 'woothemes'); ?> '+labelText+'.</span>');
                //jQuery('<br/><label></label><span class="error"><?php _e('You forgot to enter your', 'colabsthemes'); ?> '+labelText+'.</span>').insertAfter(jQuery(this));
				jQuery(this).addClass('inputError');
				hasError = true;
			} else if(jQuery(this).hasClass('email')) {
				var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
				if(!emailReg.test(jQuery.trim(jQuery(this).val()))) {
					var labelText = jQuery(this).prev('label').text();
					jQuery(this).parent().append('<br/><label></label><span class="error"><?php _e('You entered an invalid', 'colabsthemes'); ?> '+labelText+'.</span>');
					jQuery(this).addClass('inputError');
					hasError = true;
				}
			}
		});
		if(!hasError) {
			var formInput = jQuery(this).serialize();
			jQuery.post(jQuery(this).attr('action'),formInput, function(data){
				jQuery('form#frmcontact').slideUp("fast", function() {				   
					jQuery(this).before('<p class="tick"><?php _e('<strong>Thanks!</strong> Your email was successfully sent.', 'colabsthemes'); ?></p>');
				});
			});
		}
		
		return false;
		
	});
});
//-->!]]>
</script>

    <div class="container_16">
    <?php include(TEMPLATEPATH . '/includes/ribbon.php'); ?>
    <div class="clear"></div>
    
		<div class="<?php if ($author==$adam){echo 'box-post-left';}else{echo 'box-post-right';}?>">
        <?php if (($author!=$adam)&& (!is_mobile())){get_sidebar();} ?>
        
        <div class="grid_12 <?php if($post_author_id==$adam){echo 'post-adam';}else{echo 'post-eve';}?>">
            <?php if(isset($emailSent) && $emailSent == true) { ?>
            
                <div class="correctdiv"><?php _e('Your email was successfully sent.', 'colabsthemes'); ?>&nbsp;<?php _e('We will reply your message immediately.', 'colabsthemes'); ?></div>
                
            <?php } else { ?>
            
                <?php if (have_posts()) : ?>
                
                <?php while (have_posts()) : the_post(); ?>
                    
                        <h1><?php the_title(); ?></h1>
                    	
                        <?php the_content(); ?>

                    <?php if(isset($hasError) || isset($captchaError) ) { ?>
                        <div class="errordiv"><?php _e('There was an error submitting the form.', 'colabsthemes'); ?></div>
                    <?php } ?>
                    
                    <?php if ( get_option('colabs_contactform_email') == '' ) { ?>
                        <div class="errordiv"><?php _e('E-mail has not been setup properly. Please add your contact e-mail.', 'colabsthemes'); ?></div>
                    <?php } ?>
                    
                
                    <form action="<?php the_permalink(); ?>" id="frmcontact" method="post">

                        <div>
                            <div><label for="txtname" id="<?php _e('Name', 'colabsthemes'); ?>"><?php _e('Name', 'colabsthemes'); ?>&nbsp;<span>*</span></label>
                                <input type="text" name="contactName" id="txtname" value="<?php if(isset($_POST['contactName'])) echo $_POST['contactName'];?>" class="txt requiredField textboxcontact" />
                                <?php if($nameError != '') { ?>
                                    <span class="error"><?php echo $nameError;?></span> 
                                <?php } ?>
                            <br />
                            </div>
                            
                            <div><label for="txtemail" id="<?php _e('Email', 'colabsthemes'); ?>"><?php _e('Email', 'colabsthemes'); ?>&nbsp;<span>*</span></label>
                                <input type="text" name="email" id="txtemail" value="<?php if(isset($_POST['email']))  echo $_POST['email'];?>" class="txt requiredField email textboxcontact" />
                                <?php if($emailError != '') { ?>
                                    <span class="error"><?php echo $emailError;?></span>
                                <?php } ?>
                            <br /></div>
                            
                            <div><label for="txtphone"><?php _e('Phone', 'colabsthemes'); ?></label>
                                <input type="text" name="phone" id="txtphone" value="<?php if(isset($_POST['phone']))  echo $_POST['phone'];?>" class="txt email textboxcontact" />
                                <?php if($phoneError != '') { ?>
                                    <span class="error"><?php echo $phoneError;?></span>
                                <?php } ?>
                            <br /></div>
                            
                            <div class="contact-message"><label for="txtmessage" id="<?php _e('Message', 'colabsthemes'); ?>"><?php _e('Message', 'colabsthemes'); ?>&nbsp;<span>*</span></label>
                                <textarea  name="comments" id="txtmessage" rows="20" cols="30" class="requiredField textareacontact"><?php if(isset($_POST['comments'])) { if(function_exists('stripslashes')) { echo stripslashes($_POST['comments']); } else { echo $_POST['comments']; } } ?></textarea>
                                <?php if($commentError != '') { ?>
                                    <span class="error"><?php echo $commentError;?></span> 
                                <?php } ?>
                            <br /></div>
                            
                            <div><input type="checkbox" name="sendCopy" id="sendCopy" value="true"<?php if(isset($_POST['sendCopy']) && $_POST['sendCopy'] == true) echo ' checked="checked"'; ?> /><label for="sendCopy" class="sendCopy"><?php _e('Send a copy of this email to yourself', 'colabsthemes'); ?></label><br /></div>
                            
                            <label for="checking" class="screenReader"><?php _e('If you want to submit this form, do not enter anything in this field', 'colabsthemes') ?></label><input type="text" name="checking" id="checking" class="screenReader" value="<?php if(isset($_POST['checking']))  echo $_POST['checking'];?>" />
                            <label></label><input type="hidden" name="submitted" id="submitted" value="true" /><input class="submitcontact submit" type="submit" value="<?php _e('Submit', 'colabsthemes'); ?>" /><br />
                            
                        </div>
                    </form>
                
                    <?php endwhile; ?>
                <?php endif; ?>
            <?php } ?>
            
            </div><!-- /.grid_12 -->
            <?php if (($author==$adam)||(is_mobile())){get_sidebar();} ?>
            
            <div class="clear"></div>
            <div class="<?php if ($author==$adam){echo 'line';}else{echo 'line-left';}?>"></div>
    
		</div><!-- /.box-post -->
        
    <div class="clear"></div>
    </div><!-- /.container_16 -->

<?php get_footer(); ?>