<?php
if(!isset($_POST['submit']))
{
	//This page should not be accessed directly. Need to submit the form.
	echo "error; you need to submit the form!";
}
$name = $_POST['name'];
$visitor_email = $_POST['email'];
$message = $_POST['message'];
$tel = $_POST['tel'];

//Validate first
if(empty($name)||empty($visitor_email)) 
{
    echo "Name and email are mandatory!";
    exit;
}

if(IsInjected($visitor_email))
{
    echo "Bad email value!";
    exit;
}
$message = str_replace("\'","'",$message);
$email_from = 'contact@cmicho.fr';
$email_subject = "Demande de renseignements";
$email_body = "VOUS AVEZ UN NOUVEAU MESSAGE DE : $name\n\n".
    "$message\n\n".
$tel = "TEL : $tel\n".
$visitor_email = "MAIL : $visitor_email";
$to = "contact@cmicho.fr";
$headers = "From: $email_from \r\n";
$headers .= "Reply-To: $visitor_email \r\n";
//Send the email!
mail($to,$email_subject,$email_body,$headers);
//done. redirect to merci page.
header('Location: merci.html');
// Function to validate against any email injection attempts
function IsInjected($str)
{
  $injections = array('(\n+)',
              '(\r+)',
              '(\t+)',
              '(%0A+)',
              '(%0D+)',
              '(%08+)',
              '(%09+)'
              );
  $inject = join('|', $injections);
  $inject = "/$inject/i";
  if(preg_match($inject,$str))
    {
    return true;
  }
  else
    {
    return false;
  }
}
echo " Merci pour votre message.<br>Je ne manquerai pas de vous repondre tres prochainement,<br><br>Cordialement<br>Christophe Micheau" 
?>