<?php
// Check for empty fields
if(empty($_POST['name'])      ||
   empty($_POST['email'])     ||
//   empty($_POST['phone'])     ||
   empty($_POST['message'])   ||
   !isset($_POST['age']) ||
   !isset($_POST['grecaptcharesponse']) ||
   !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) {
     echo "No arguments Provided!";
     return false;
   }
   
$name          = strip_tags(htmlspecialchars($_POST['name']));
$email_address = strip_tags(htmlspecialchars($_POST['email']));
//$phone         = strip_tags(htmlspecialchars($_POST['phone']));
$message       = strip_tags(htmlspecialchars($_POST['message']));

$selectage = $_POST['age'];
$selectedu = $_POST['edu'];
$radios1   = $_POST['radios1'];
$radios2   = $_POST['radios2'];
$radios3   = $_POST['radios3'];
$radios4   = $_POST['radios4'];

// verify recaptcha
$captcha=$_POST['grecaptcharesponse'];
if(!$captcha){
      echo '<h2>Please check the captcha form.</h2>';
      exit;
    }
$secretKey = "6LcejRAUAAAAAJnOLVMNz8XdOalpBFGe3jTdSVBe";
    $ip = $_SERVER['REMOTE_ADDR'];
    $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
    $responseKeys = json_decode($response,true);
    if(intval($responseKeys["success"]) !== 1) {
      echo '<h2>You are spammer ! Get the @$%K out</h2>';
    } else {
      //echo '<h2>Thanks for posting comment.</h2>';
    }
    // end recaptcha verification



function clean_string($string) {
  $bad = array("content-type","bcc:","to:","cc:","href");
  return str_replace($bad,"",$string);
}

// Create the email and send the message
$to = 'venu.developers@physics.ox.ac.uk'; // Add your email address inbetween the '' replacing yourname@yourdomain.com - This is where the form will send a message to.
$email_subject = "Website Contact Form:  $name";

$email_body = "You have received a new message from your website contact form.\n\n"."Here are the details:\n\nName: $name\n\nEmail: $email_address\n\nMessage:\n$message\n\n";
$email_body .= "Age: ".clean_string($selectage)."\n";
$email_body .= "Education: ".clean_string($selectedu)."\n";
$email_body .= "Interested in Particle Physics: ".clean_string($radios1)."\n";
$email_body .= "Topics were interesting: ".clean_string($radios2)."\n";
$email_body .= "Developed understanding: ".clean_string($radios3)."\n";
$email_body .= "Encouraged to study further: ".clean_string($radios4)."\n";

$headers = "From: noreply@venu.physics.ox.ac.uk\n"; // This is the email address the generated message will be from. We recommend using something like noreply@yourdomain.com.
$headers .= "Reply-To: $email_address";   
mail($to,$email_subject,$email_body,$headers);
return true;         
?>
