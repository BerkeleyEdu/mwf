<?php

require_once(dirname(dirname(__FILE__)).'/assets/config.php');
include(dirname(__FILE__).'/header.php');
require_once(dirname(__FILE__).'/util.php');

	if($_POST['action'] == "sendContactForm") 
	{
		$problem = FALSE;
		if ($_POST['full_name'] == '')
		{
			$problem = TRUE;
			$problem_message .= '<p>Please enter your name.</p>';
		}	
		elseif(!validateInjectionSafe($_POST['full_name']))
		{
			$problem = TRUE;
			$problem_message .= '<p>Please re-enter your name.</p>';	
		}
		
		if ($_POST['email'] == '')
		{
			$problem = TRUE;
			$problem_message .= '<p>Please enter a email address.</p>';
		}
		elseif (!validateEmail($_POST['email']))
		{
			$problem = TRUE;
			$problem_message .= '<p>Please enter a valid email address.</p>';
		}
		elseif(!validateInjectionSafe($_POST['email']))
		{
			$problem = TRUE;
			$problem_message .= '<p>Please enter a valid email address.</p>';	
		}

		if ($_POST['question'] == '')
		{
			$problem = TRUE;
			$problem_message .= '<p>Please enter a question or comment.</p>';
		}
		elseif(!validateInjectionSafe($_POST['question']))
		{
			$problem = TRUE;
			$problem_message .= '<p>Please re-enter your comments.</p>';	
		}

		if (!$problem)
		{
			//CREATE EMAIL
			$email = $_POST['email']; //PERSON WHO SUBMITTED INQUIRY
	
			$rec_email = "webmaster@berkeley.edu";
			
			//DEBUG MODE
			//$rec_email = "saral@berkeley.edu";
	
			$subject = "Comment from UC Berkeley Mobile";
			
			$body = "The following person has submitted an inquiry:\n";
			$body .= "\nName: ".$_POST['full_name']."\nEmail: ".$_POST['email']."\n\nQuestion/Comment: ".$_POST['question'];	
			
			$headers = 'From:' .$_POST['email']. "\r\n";

			//SEND EMAIL
			mail($rec_email, $subject, $body, $headers); //SEND TO ADMINS
			$success = true;
		}
	}
	
?>       
    <div class="content-elements content-padded">
   
        <div class="content-first">
        	<h1>Contact Us</h1>
        </div>
        
        <div class="content-last">
          
        <?php 
		if($success) 
		{ ?>
            <p>Thank you for your comments.</p>
        <?php 
		} 
		else 
		{
			if ($problem)
			{
				print $problem_message;
			}
		?>
          <form id="contactForm" method="post" action="index.php" onsubmit="return validateContact(this);">
            
            <div class="field">
                <label for="full_name">Your Name</label>
                <br />		
                <input name="full_name" type="text" id="full_name" class="input_text" size="30" value="<?php echo $_POST["full_name"]; ?>"/>
            </div>
            
            <div class="field">
                <label for="email">Your Email</label>
                <br />
                <input name="email" type="text" id="email" class="input_text" size="30" value="<?php echo $_POST["email"]; ?>"/>
            </div>
            
            <div class="field">
                <label for="question">Comments</label><br />
                <textarea name="question" cols="30" rows="10" id="question" class="input_text"><?php echo $_POST["question"]; ?></textarea>
            </div>
            
            <div class="field"> 
                 <span class="formSpacer"><input id="submit-button" type="submit" class="submit_inquiry" value="Submit Comments"></span>
            </div>
            <input type="hidden" name="action" value="sendContactForm" />
          </form>
        <?php } ?>
          
        </div>
    
    </div>

            
    <a class="button-full button-padded" href="..">Go to UCB Mobile</a>

<div id="footer">
        <p><?php echo Config::get('global', 'copyright_text') ?><br />
        <a href="<?php echo Config::get('frontpage', 'full_site_url') ?>">Full Site</a>&nbsp;|&nbsp;
		 <a href="/search">Search</a>&nbsp;|&nbsp;
        <a href="/atoz">A-Z</a>&nbsp;|&nbsp;
         <a href="/about">About</a>&nbsp;|&nbsp;
        <a href="<?php echo Config::get('frontpage', 'contact_url') ?>">Contact</a>
           </p>
    </div>
    
    </body>

</html>