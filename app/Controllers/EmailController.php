<?php
namespace App\Controllers;

class EmailController extends BaseController
{

	public function envioCorreo(){
		$codigo=rand(0,20);


		$to='pruebasautomatizadas1993@gmail.com';
		$setSubject='Titulo ';
		$mensaje='<h1>mensaje html</h1>';






		$email = \Config\Services::email();

		$email->setFrom('pruebasautomatizadas1993@gmail.com', 'ASUNTO');
		$email->setTo($to);
//$email->setCC('another@another-example.com');
//$email->setBCC('them@their-example.com');

		$email->setSubject($setSubject);
		$email->setMessage($mensaje);

		if($email->send()){
			echo "mensaje enviado";
		}else{
			echo $response=$email->printDebugger(['headers']);
		}
	}
}