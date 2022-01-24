<?php
namespace App\Controllers;

//traigo el modelo del bot de citas donde estan las consultas sql para este bot y poder aca crear los objetos
use App\Models\Botcitasmodel;
class BotcitasController extends BaseController
{

    public function botCitas()
    {

        return view('vistasbots/index');
    }

    public function saludoCitas(){




       echo "Hola soy Avis Tu asesor virtual por favor digita tu cedula para poder continuar apoyandote";
   }

   public function cedulaConsultawsSiTieneCitas(){
    $objeto=new Botcitasmodel();

    $cedula=$_POST['messageValue'];

    //creamos la sesion de la cedula para que quede una variable global
    $data=['cedula'=>$cedula];
    $session = session();
    $session->set($data);
    //verificamos si el cliente tiene cita o no, contamos si la consulta al servidor nos retorna mas de 1 dato si es mayor a cero tiene cita si no no existe retorna cero y no hay cita
   $consulta_cliente_db=$objeto->validarSiTieneCita($cedula);
   $consulta_cliente_db=count($consulta_cliente_db);
   if($consulta_cliente_db>0){
   echo "si";
   }else{
   echo "no";
   }
}


public function menuppalAgendamiento(){

//citas
    $objeto= new Botcitasmodel();
    $citas_disponibles=$objeto->listarCitas();
    $total_citas= count($citas_disponibles);
    $pocicion_Cita_dispo=array();
    for($i=0;$i<$total_citas;$i++){
      $cita=$citas_disponibles[$i]->{'citas'};
      $estado=$citas_disponibles[$i]->{'estado'};
      $fecha_hora_actual=date('Y-m-d H:i:s');
      if($cita>$fecha_hora_actual && $estado=="disponible")
      {
        array_push($pocicion_Cita_dispo, $i);
    }
}

$indice_cita_1=$pocicion_Cita_dispo[0];
$indice_cita_2=$pocicion_Cita_dispo[1];

$cita1=$citas_disponibles[$indice_cita_1]->{'citas'};
$id_cita1=$citas_disponibles[$indice_cita_1]->{'id'};

$cita2=$citas_disponibles[$indice_cita_2]->{'citas'};
$id_cita2=$citas_disponibles[$indice_cita_2]->{'id'};




$cedula=session('cedula');
//creamos la sesion de los datos del cliente
$nombre_cliente=$_POST['nombre'];
$correo_cliente=$_POST['correo'];
$celular_cliente=$_POST['celular'];

$data=['nombre_cliente'=>$nombre_cliente,
'correo_cliente'=>$correo_cliente,
'celular_cliente'=>$celular_cliente,
'cita1'=>$cita1,
'id_cita1'=>$id_cita1,
'cita2'=>$cita2,
'id_cita2'=>$id_cita2
]; 
$session=session();
$session->set($data);




echo "Marca el numero de la opcion que deseas:";
echo "<ol><li>opcion 1: ".$cita1."</li><li>opcion 2: ".$cita2."</li></ol>";


}
//ca hacemos la insercion de la cita en la bd este es el agendamiento
public function citaSeleecionada(){
    $objeto= new Botcitasmodel();
//citas
    $cedula=session('cedula');
    $cita1=session('cita1');
    $id1=session('id_cita1');
    $cita2=session('cita2');
    $id2=session('id_cita2');
//datos de contacto
    $nombre_cliente=session('nombre_cliente');
    $correo_cliente=session('correo_cliente');
    $celular_cliente=session('celular_cliente');
    $estado="ocupado";
    

    $cita_seleccionada=$_POST['userMessage'];
    if($cita_seleccionada=="1"){
        $total_caracteres=strlen($cita1);
        $hora_array=array();
        $manana_tarde=array();
        for($i=0;$i<$total_caracteres;$i++){
    //aca extraemos la hora
            if($i>10 && $i<19){
               array_push($hora_array,$cita1[$i]);
           }
    //aca extraemos solo la hora sin min y segundos para comparar si es tarde o mañana
           if($i==11 || $i==12){
             array_push($manana_tarde,$cita1[$i]);
         }

     }



     $fecha_cita=substr($cita1, 0,10);
     $hora_cita=implode($hora_array);
     $am_pm=implode($manana_tarde);
     if($am_pm=="00"||$am_pm <"12"){
        $horario_am_pm=" de la mañana";
    }else{
        $horario_am_pm=" de la tarde";
    }

    //insercion en la bd
    $datos=array($cedula,$nombre_cliente,$correo_cliente,$celular_cliente,$estado,$id1);
    $objeto->citaSeleecionada($datos);

/*enviamos email
$to=$correo_cliente;
$setSubject='Agendamiento de citas chatbot';
$mensaje='Mensajes de pruebas, sr(a) '.$nombre_cliente.' Tu cita ha sido Agendada  exitosamente para la fecha '.$fecha_cita.' a las '.$hora_cita.$horario_am_pm.'';
$email = \Config\Services::email();
$email->setFrom('pruebasautomatizadas1993@gmail.com', 'Mensajes de pruebas');
$email->setTo($to);
$email->setSubject($setSubject);
$email->setMessage($mensaje);
$email->send();
*/
//respuesta al bot via ajax
echo "Agendamiento exitoso,la cita seleccionada fue:";
echo "</br>";
echo $fecha_cita." a las ".$hora_cita.$horario_am_pm;
echo  "</br>";
echo "Gracias por comunicarte con Nosotros que tengas un gran dia.";
//destruimos las sesiones
$session = session();
$session->destroy();

}else{

    $total_caracteres=strlen($cita2);
    $hora_array=array();
    $manana_tarde=array();
    for($i=0;$i<$total_caracteres;$i++){
    //aca extraemos la hora
        if($i>10 && $i<19){
           array_push($hora_array,$cita2[$i]);
       }
    //aca extraemos solo la hora sin min y segundos para comparar si es tarde o mañana
       if($i==11 || $i==12){
         array_push($manana_tarde,$cita2[$i]);
     }

 }



 $fecha_cita=substr($cita2, 0,10);
 $hora_cita=implode($hora_array);
 $am_pm=implode($manana_tarde);
 if($am_pm=="00"||$am_pm <"12"){
    $horario_am_pm=" de la mañana";
}else{
    $horario_am_pm=" de la tarde";
}

    //insercion en la bd
$datos=array($cedula,$nombre_cliente,$correo_cliente,$celular_cliente,$estado,$id2);
$objeto->citaSeleecionada($datos);

/*enviamos email
$to=$correo_cliente;
$setSubject='Agendamiento de citas chatbot';
$mensaje='Mensajes de pruebas, sr(a) '.$nombre_cliente.' Tu cita ha sido Agendada  exitosamente para la fecha '.$fecha_cita.' a las '.$hora_cita.$horario_am_pm.'';
$email = \Config\Services::email();
$email->setFrom('pruebasautomatizadas1993@gmail.com', 'Mensajes de pruebas');
$email->setTo($to);
$email->setSubject($setSubject);
$email->setMessage($mensaje);
$email->send();
     
*/
echo "Agendamiento exitoso,la cita seleccionada fue:";
echo "</br>";
echo $fecha_cita." a las ".$hora_cita.$horario_am_pm;
echo  "</br>";
echo "Gracias por comunicarte con Nosotros que tengas un gran dia.";

//destruimos las sesiones
$session = session();
$session->destroy();
}



}

public function menuppalAsesor(){
//obtenemos los datos del cliente para enviarlos al email del asesor
$nombre_cliente=$_POST['nombre'];
$correo_cliente=$_POST['correo'];
$celular_cliente=$_POST['celular'];



$objeto= new Botcitasmodel();
$datos_asesor=$objeto->listarAsesor();

//para recorrer esto asi simplemente desde el modelo retornamos el statement y ya
foreach ($datos_asesor->getResult() as $row)
{
    $nombre_asesor= $row->nombre;
    $telefono_asesor=$row->telefono;
    $email_asesor=$row->email;
   
}
/*enviamos el email al asesor con los datos del cliente para que le contacte
$to=$email_asesor;
$setSubject='Solicitud asesor menu agendamiento';
$mensaje='Mensajes de pruebas,Los datos de contacto del cliente son: nombre='.$nombre_cliente.' correo del cliente='.$correo_cliente.' celular del cliente='.$celular_cliente;
$email = \Config\Services::email();
$email->setFrom('pruebasautomatizadas1993@gmail.com', 'Mensajes de pruebas');
$email->setTo($to);
$email->setSubject($setSubject);
$email->setMessage($mensaje);
$email->send();
*/
//respuesta entregada al bot  via ajax

echo"En unos instantes seras contactado por el asesor ".$nombre_asesor." del telefono ".$telefono_asesor.",Si posees wathsapp de lo contrario te llamara o te escribira a tu email, por favor espera un momento, que tengas un feliz dia";



}

public function mostrarCitaActualizar(){
//citas
    $objeto= new Botcitasmodel();
    $citas_disponibles=$objeto->listarCitas();
    $total_citas= count($citas_disponibles);
    $pocicion_Cita_dispo=array();
    for($i=0;$i<$total_citas;$i++){
      $cita=$citas_disponibles[$i]->{'citas'};
      $estado=$citas_disponibles[$i]->{'estado'};
      $fecha_hora_actual=date('Y-m-d H:i:s');
      if($cita>$fecha_hora_actual && $estado=="disponible")
      {
        array_push($pocicion_Cita_dispo, $i);
    }
}

$indice_cita_1=$pocicion_Cita_dispo[0];
$indice_cita_2=$pocicion_Cita_dispo[1];

$cita1=$citas_disponibles[$indice_cita_1]->{'citas'};
$id_cita1=$citas_disponibles[$indice_cita_1]->{'id'};

$cita2=$citas_disponibles[$indice_cita_2]->{'citas'};
$id_cita2=$citas_disponibles[$indice_cita_2]->{'id'};




$cedula=session('cedula');
//aca vamos a coger la cita que tiene esta persona asignada el id para colocar todos los dtos vacios y el estado en disponible  obtenemos los datos de lacita que ya tenia 
$id_cita_limpiar=$objeto->validarSiTieneCita($cedula);
//sacamos los datos de la persona
$nombre_cliente=$id_cita_limpiar[0]->{'nombre'};
$correo_cliente=$id_cita_limpiar[0]->{'correo'};
$celular_cliente=$id_cita_limpiar[0]->{'celular'};

//creamos la sesiones de todos los datos
$data=['nombre_cliente'=>$nombre_cliente,
'correo_cliente'=>$correo_cliente,
'celular_cliente'=>$celular_cliente,
'cita1'=>$cita1,
'id_cita1'=>$id_cita1,
'cita2'=>$cita2,
'id_cita2'=>$id_cita2

]; 
$session=session();
$session->set($data);




echo "Marca el numero de la opcion que deseas:";
echo "<ol><li>opcion 1: ".$cita1."</li><li>opcion 2: ".$cita2."</li></ol>";

}

public function actualizadoCitaFinal(){
 $objeto= new Botcitasmodel();

  
   
    $cedula=session('cedula');
    $cita1=session('cita1');
    $id1=session('id_cita1');
    $cita2=session('cita2');
    $id2=session('id_cita2');
//datos de contacto
    $nombre_cliente=session('nombre_cliente');
    $correo_cliente=session('correo_cliente');
    $celular_cliente=session('celular_cliente');
    //como en esta funcion debemos liberar una cita y ocupar otra lo hacemos a la ocupada la dejamos disponible y a la nueva la ponemos ocupada
    $estado1="disponible";
    $estado2="ocupado";
  //aca sacaremos el id a actualizar
 $datos_cita_limpiar=$objeto->validarSiTieneCita($cedula);
for($i=0;$i<1;$i++){
$id_liberar=$datos_cita_limpiar[0]->{'id'};
}

   $cita_seleccionada=$_POST['userMessage'];
   
    if($cita_seleccionada=="1"){
        $total_caracteres=strlen($cita1);
        $hora_array=array();
        $manana_tarde=array();
        for($i=0;$i<$total_caracteres;$i++){
    //aca extraemos la hora
            if($i>10 && $i<19){
               array_push($hora_array,$cita1[$i]);
           }
    //aca extraemos solo la hora sin min y segundos para comparar si es tarde o mañana
           if($i==11 || $i==12){
             array_push($manana_tarde,$cita1[$i]);
         }

     }



     $fecha_cita=substr($cita1, 0,10);
     $hora_cita=implode($hora_array);
     $am_pm=implode($manana_tarde);
     if($am_pm=="00"||$am_pm <"12"){
        $horario_am_pm=" de la mañana";
    }else{
        $horario_am_pm=" de la tarde";
    }
   //liberamos la cita que estaba actualmente ocupada
    $vacios="";
    
    
    $data=array($vacios,$vacios,$vacios,$vacios,$estado1,$id_liberar);
    $objeto->citaFinalLiberada($data);
    //insercion en la bd de la nueva cita
    $datos=array($cedula,$nombre_cliente,$correo_cliente,$celular_cliente,$estado2,$id1);
    $objeto->citaSeleecionada($datos);
    

/*enviamos email
$to=$correo_cliente;
$setSubject='Actualizacionde citas chatbot';
$mensaje='Mensajes de pruebas, sr(a) '.$nombre_cliente.' Tu cita ha sido Actualizada exitosamente para la fecha '.$fecha_cita.' a las '.$hora_cita.$horario_am_pm.'';
$email = \Config\Services::email();
$email->setFrom('pruebasautomatizadas1993@gmail.com', 'Mensajes de pruebas');
$email->setTo($to);
$email->setSubject($setSubject);
$email->setMessage($mensaje);
$email->send();
*/
//respuesta al bot via ajax

echo "Actualizacion exitosa,la cita seleccionada fue:";
echo "</br>";
echo $fecha_cita." a las ".$hora_cita.$horario_am_pm;
echo  "</br>";
echo "Gracias por comunicarte con Nosotros que tengas un gran dia.";


//destruimos las sesiones
$session = session();
$session->destroy();

}else{

    $total_caracteres=strlen($cita2);
    $hora_array=array();
    $manana_tarde=array();
    for($i=0;$i<$total_caracteres;$i++){
    //aca extraemos la hora
        if($i>10 && $i<19){
           array_push($hora_array,$cita2[$i]);
       }
    //aca extraemos solo la hora sin min y segundos para comparar si es tarde o mañana
       if($i==11 || $i==12){
         array_push($manana_tarde,$cita2[$i]);
     }

 }



 $fecha_cita=substr($cita2, 0,10);
 $hora_cita=implode($hora_array);
 $am_pm=implode($manana_tarde);
 if($am_pm=="00"||$am_pm <"12"){
    $horario_am_pm=" de la mañana";
}else{
    $horario_am_pm=" de la tarde";
}
 //liberamos la cita que estaba actualmente ocupada
    $vacios="";
    //toco hacer este implode por que no podia transformar array a string y al parecer este es el que generaba el error
     $data=array($vacios,$vacios,$vacios,$vacios,$estado1,$id_liberar);
    $objeto->citaFinalLiberada($data);
    //insercion en la bd
$datos=array($cedula,$nombre_cliente,$correo_cliente,$celular_cliente,$estado2,$id2);
$objeto->citaSeleecionada($datos);

/*enviamos email
$to=$correo_cliente;
$setSubject='Actualizacion de citas chatbot';
$mensaje='Mensajes de pruebas, sr(a) '.$nombre_cliente.' Tu cita ha sido Actualizada exitosamente para la fecha '.$fecha_cita.' a las '.$hora_cita.$horario_am_pm.'';
$email = \Config\Services::email();
$email->setFrom('pruebasautomatizadas1993@gmail.com', 'Mensajes de pruebas');
$email->setTo($to);
$email->setSubject($setSubject);
$email->setMessage($mensaje);
$email->send();
     
*/
echo "Actualizacion Exitosa,la cita seleccionada fue:";
echo "</br>";
echo $fecha_cita." a las ".$hora_cita.$horario_am_pm;
echo  "</br>";
echo "Gracias por comunicarte con Nosotros que tengas un gran dia.";

//destruimos las sesiones
$session = session();
$session->destroy();
}




}

public function cancelarCita(){
$objeto= new Botcitasmodel();
$cedula=session('cedula');
  $datos_cita_cancelar=$objeto->validarSiTieneCita($cedula);
for($i=0;$i<1;$i++){
$id_liberar=$datos_cita_cancelar[0]->{'id'};
$nombre_cliente=$datos_cita_cancelar[0]->{'nombre'};
$correo_cliente=$datos_cita_cancelar[0]->{'correo'};
}
//la liberamos utilizando el mismo metodo de cita liberada solo que ya no se hace la insercion asi que e cliente queda sin cita
    $vacios="";
    $estado="disponible";
    $data=array($vacios,$vacios,$vacios,$vacios,$estado,$id_liberar);
    $objeto->citaFinalLiberada($data);
/*
$to=$correo_cliente;
$setSubject='Cancelcion de citas chatbot';
$mensaje='Mensajes de pruebas, sr(a) '.$nombre_cliente.' Tu cita ha sido cancelada exitosamente , para agendar una nueva cita vuelve a escribir al bot, que tengas un feliz dia ';
$email = \Config\Services::email();
$email->setFrom('pruebasautomatizadas1993@gmail.com', 'Mensajes de pruebas');
$email->setTo($to);
$email->setSubject($setSubject);
$email->setMessage($mensaje);
$email->send();
*/
echo $respuesta_ajax='Mensajes de pruebas, sr(a) '.$nombre_cliente.' Tu cita ha sido cancelada exitosamente , para agendar una nueva cita vuelve a escribir al bot, que tengas un feliz dia ';
}

public function consultaMiCita(){
    $objeto=new Botcitasmodel();
    $cedula=session('cedula');
    $consulta_cliente_db=$objeto->validarSiTieneCita($cedula);
    for($i=0;$i<1;$i++){
     $nombre_cliente=$consulta_cliente_db[0]->{'nombre'};
     $cita=$consulta_cliente_db[0]->{'citas'};
    }

    echo "Sr(a) ".$nombre_cliente." usted tiene agendada una cita para la fecha ".$cita;
}




//esta funcion la cree para apoyarme es un post pero aca la utilizo con get para obtener las citas y hacer la logica es una ruta auxiliar
public function probandoBot(){
$objeto=new Botcitasmodel();
$cedula="123456789";
$id_cita_limpiar=$objeto->validarSiTieneCita($cedula);
$id_cita_limpiar=$id_cita_limpiar[0]->{'id'};
}

//esta es una prueba para mandar desde el formulario post para hacer los procesos de post ya que no da para probarlo via url
public function pruebasFormulario(){
 echo view('vistasbots/pruebas.php');
}

}
