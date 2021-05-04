<?php

if(!$_POST) exit;

function tommus_email_validate($email) { return filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match('/@.+\./', $email); }

$name = $_POST['name']; $email = $_POST['email']; $website = $_POST['website']; $comments = $_POST['comments'];

// Variables adicionales
$empresa = $_POST['empresa']; $size = $_POST['size']; $acteco = $_POST['acteco']; $ventas = $_POST['ventas'];

switch($ventas){
	case 1:
		$ventasDesc = "Micro - Hasta $4 mdp";
		break;
	case 2:
		$ventasDesc = "Pequeña - De $4.01 hasta $100 mdp";
		break;
	case 3:
		$ventasDesc = "Grande - De $100.01 hasta $250 mdp";
		break;
}


if(trim($name) == '') {
	exit('<div class="alert alert-danger">Favor de proporcionar nombre.</div>');
} else if(trim($name) == 'Name') {
	exit('<div class="alert alert-danger">Favor de proporcionar nombre.</div>');
/*
} else if(trim($empresa) == '') {
	exit('<div class="alert alert-danger">Favor de proporcionar el nombre de su empresa.</div>');
} else if(trim($empresa) == 'Nombre Empresa') {
	exit('<div class="alert alert-danger">Favor de proporcionar nombre de su empresa.</div>');
*/
} else if(trim($email) == '') {
	exit('<div class="alert alert-danger">Por favor proporcione una dirección de correo válida.</div>');
} else if(!tommus_email_validate($email)) {
	exit('<div class="alert alert-danger">Por favor proporcione una dirección de correo válida.</div>');
} else if(trim($website) == 'Website') {
	exit('<div class="alert alert-danger">Proporcione los datos de su website.</div>');
} else if(trim($website) == '') {
	exit('<div class="alert alert-danger">Proporcione los datos de su website.</div>');
} else if(trim($size) == '') {
	exit('<div class="alert alert-danger">Favor de proporcionar número de trabajadores de su empresa.</div>');
} else if(trim($acteco) == '') {
	exit('<div class="alert alert-danger">Favor de proporcionar actividad económica.</div>');
} else if(trim($comments) == 'Message') {
	exit('<div class="alert alert-danger">Por favor registre un mensaje.</div>');
} else if(trim($comments) == '') {
	exit('<div class="alert alert-danger">Por favor registre un mensaje.</div>');
} else if( strpos($comments, 'href') !== false ) {
	exit('<div class="alert alert-danger">Por favor capture los enlaces como solo texto.</div>');
} else if( strpos($comments, '[url') !== false ) {
	exit('<div class="alert alert-danger">Por favor capture los enlaces como solo texto.</div>');
} if(get_magic_quotes_gpc()) { $comments = stripslashes($comments); }

//ENTER YOUR EMAIL ADDRESS HERE
//$addressTo = 'alberto.castaneda@alliancegvc.com';
//$addressFrom = 'acastanedao@gmail.com';
$addressTo = 'alvaro.fernandez@alliancegvc.com';
$addressFrom = 'alberto.castaneda@alliancegvc.com';

$e_subject = 'Ha recibido correo de ' . $name ;
$e_body = "Se ha recibido correo de $name (website: $website) solicitando mas información. El texto del mensaje es el siguiente:" . "\r\n" . "\r\n";
$e_perfil = "Empresa: " . $empresa . "\r\nTrabajadores: " . $size . "\r\nActividad económica: " . $acteco . "\r\nVentas: " . $ventasDesc . "\r\n" . "\r\n";
$e_content = "\"$comments\"" . "\r\n" . "\r\n";
$e_reply = "El correo de contacto de $name es, $email";

$msg = wordwrap( $e_body . $e_perfil . $e_content . $e_reply, 70 );

$headers = "From: $addressFrom" . "\r\n";
$headers .= "Reply-To: $email" . "\r\n";
$headers .= "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type: text/plain; charset=utf-8" . "\r\n";
$headers .= "Content-Transfer-Encoding: quoted-printable" . "\r\n";



if(mail($addressTo, $e_subject, $msg, $headers)) { echo "<fieldset><div id='success_page'><h4 class='remove-bottom'>Correo electronico enviado.</h4><p>Gracias <strong>$name</strong>, hemos recibido su mensaje.</p></div></fieldset>"; }