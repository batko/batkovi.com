<?php

// Do not edit this if you are not familiar with php
error_reporting (E_ALL ^ E_NOTICE);
$post = (!empty($_POST)) ? true : false;
if($post) {
	function ValidateEmail($email){

		$regex = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^";
		$eregi = preg_replace($regex,'', trim($email));
		
		return empty($eregi) ? true : false;
	}

	$event1 = stripslashes($_POST['c1']);
	$event2 = stripslashes($_POST['c2']);
	$event3 = stripslashes($_POST['c3']);
	$event4 = stripslashes($_POST['c4']);
	$event5 = stripslashes($_POST['c5']);
	$event6 = stripslashes($_POST['c6']);
	$mainmeal = stripslashes($_POST['mainmeal']);
	$secondmeal = stripslashes($_POST['secondmeal']);
	$desert = stripslashes($_POST['desert']);
	$menunotes = stripslashes($_POST['menunotes']);
	$guests = stripslashes($_POST['guests']);
	
	$name = stripslashes($_POST['rsvpname']);
	$to = trim($_POST['to']);
	$email = strtolower(trim($_POST['rsvpemail']));
	$phone = stripslashes($_POST['rsvpphone']);
	$message = stripslashes($_POST['rsvpcomments']);
	$subject = stripslashes($_POST['subject']);
	$error = '';
	$Reply=$to;
	$from=$to;
	
	// Check Name Field
	if(!$name) {
		$error .= 'Please enter your name.<br />';
	}
	
	// Checks Email Field
	if(!$email) { 
		$error .= 'Please enter an e-mail address.<br />';
	}
	if($email && !ValidateEmail($email)) {
		$error .= 'Please enter a valid e-mail address.<br />';
	}

	// Checks Subject Field
	if(!$phone) {
		$error .= 'Please enter your phont.<br />';
	}
	
	// Checks Message (length)
	if(!$message || strlen($message) < 3) {
		$error .= "Please enter your message. It should have at least 5 characters.<br />";
	}
	
	// Let's send the email.
	if(!$error) {
		$messages="From: $email <br>";
		$messages.="Name: $name <br>";
		$messages.="Email: $email <br>";	
		$messages.="Phone: $phone <br>";
		$messages.="Message: $message <br><br>";
		$messages.="Event will be attending: $event1 <br> $event2 <br> $event3 <br> $event4 <br> $event5 <br> $event6  <br><br>";
		$messages.="Nr of guests: $guests <br>";
		$messages.="Meal selection: $mainmeal <br>";
		$messages.="Second Meal selection: $secondmeal <br>";
		$messages.="Desert selection: $desert <br>";
		$messages.="Menu notes: $menunotes <br>";
		$emailto=$to;
		
		$mail = mail($emailto,$subject,$messages,"from: $from <$Reply>\nReply-To: $Reply \nContent-type: text/html");	
	
		if($mail) {
			echo 'success';
		}
	} else {
		echo '<div class="error">'.$error.'</div>';
	}

}
?>