<?php
namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;

class WebServiceCitasController extends ResourceController
{
    //aca ponemos el nombre del modelo  al cual le haremos el ws, en este caso yo cree un modelo para el ws el cual tiene el mismo modelo del bot, pero en la realidad podria ser apuntando al modelo del bot para no hacer doble trabajo
 protected $modelName = 'App\Models\WebservicecitasModel';
 protected $format    = 'json';

 public function index()
 {
   
   //autenticacion basica en postman y aca ponemos el operador ternario
   $usuario_ws=isset($_SERVER['PHP_AUTH_USER'])?$_SERVER['PHP_AUTH_USER']:"";
   $password_ws=isset($_SERVER['PHP_AUTH_PW'])?$_SERVER['PHP_AUTH_PW']:"";
   if($usuario_ws=='admin'&& $password_ws=="123456789"){
        //ponemos esto y despues del model la funcion que nececitamos mostrar del modelo puedo ponerlo asi y functiona, o hicimos una funcion generica para que entregue la respuesta que yo  quiero que es como lo deje la funcion generica y la linea de codigo que esta activa return $this->respond($this->model->listarCitas());el generic es la ultima funcion de este archivo es la que trae correcto o error en las comillas es el mesnaje y puede ir lo que queramos en este caso lo dejamos vacio
        $data=$this->model->listarCitas();
        //generic es la ultima funcion abajo de este arcivo se creo es basica y valida cntra e 200 si esta bien se pasa la data y estado 200 o el que yo quiera eso esta quemado es solo parametros que pasamos a la funcion y mire que cuando esta bien muestra data y 200 por eso pasamos en esos parametros cuando esta malo el de data se deja en blanco y el segundo con el error y el 400 puede ser cualquier codigo es quemado, asi esta a funcion en bueno data y en malo muestra sms que es el del medio
        return $this->genericResponse($data,"",200);
     }else{
      return $this->genericResponse("","Error, no te haz autenticado",400);
     }


    //con solo esta linea de codigo en el index se expone via rest api nuestra app de chatbot, ya seria crear en la pagina que lo consuma un botoncito modal que al darle clic muestre response, en el htm de consumo se pone el ws de postman se crea un modal y ahi es que se muestra el response el cual muestra el html completo y el solo hace la interactuacion con la bd
    // return view('vistasbots/index.php');
     }


//verificamos si el cliente tiene cita show segn la documentacion en rest api esta consulta se llama sow para la ruta

     public function show($id=null){

       if($id==null){
        return $this->genericResponse(null,"debes diligenciar una cedula",200);
     }
    //verificamos si la cedula tiene citas ya que si tiene retorna un array 1
     $datos=$this->model->validarSiTieneCita($id);
     $datos=count($datos);

     if($datos>0){
      return $this->genericResponse($this->model->validarSiTieneCita($id),"",200);
   }else{
     return $this->genericResponse("","Este cliente no tiene citas",400); 
  }

  
  
}
//creando asesor desde postman
public function create(){
   //linea que se requiere para validar formuarios
   $validation =  \Config\Services::validation();
        //rcogemos los datos del post
   $datos=['cedula'=>$_POST['cedula'],
   'nombre'=>$_POST['nombre'],
   'email'=>$_POST['email'],
   'telefono'=>$_POST['telefono'],
   'totalTramitesAsignados'=>$_POST['totalTramitesAsignados']
];
if($this->validate('validar_web_services_bot')){
   $this->model->crearAsesor($datos);
   return $this->genericResponse("Asesor creado exitosamente","",200);
}else{
   //si no valido el formulario por erores diligenciados
  
  return $this->genericResponse("",print($validation->listErrors()),400);
}
}
//actualizando asesor via postman

public function update($id=null){
//validacion de formulario
  $validation =  \Config\Services::validation();

    //aca recibimos todos los datos del postman como es un put se recogen en getrawinput que llegan en un array el id que entra por parametro en la funcion no se por que no lo reconoce entonces toca validar contra este que recibimos en get raw que son los que se colocan en el body en postman
  $datos_recibidos_postman=$this->request->getRawInput();
  $cedula=  $datos_recibidos_postman['cedula'];
    //verificamos si la cedula tiene citas ya que si tiene retorna un array 1 toca validar con la cedula que recogemos por que la de la url no se por que no la reconoce
  $existe=$this->model->validadSiAsesorExiste($cedula);
  $existe=count($existe);
//validamos formulario
  if($this->validate('validar_web_services_bot')){
    if($existe>0){
 //como getRainput me entrega en array aca empiso asignarlos a cada variable y accedo a la propiedad del array
      $nombre=  $datos_recibidos_postman['nombre'];
      $email= $datos_recibidos_postman['email'];
      $telefono=$datos_recibidos_postman['telefono'];
      $total_tramites= $datos_recibidos_postman['totalTramitesAsignados'];
      $datos=array($cedula,$nombre,$email,$telefono,$total_tramites);

      $this->model->actualizarAsesor($datos,$id);
      return $this->genericResponse("actualizado exitosamente","",200);
   }else{

    return $this->genericResponse("","cedula no existe",400);
 }

}else{
   //si no valido el formulario por erores diligenciados
  
  return $this->genericResponse(print($validation->listErrors()),"",200); 
}
}

//eliminando asesor via postman
public function delete($id = null){
   //toca pasar cedula por body en posman ya que la url no la reconoce no se por que 
   $datos_recibidos_postman=$this->request->getRawInput();
   $id=$datos_recibidos_postman['cedula'];
//verificamos que la cedula si exista para poder eliminarlo
   $existe=$this->model->validadSiAsesorExiste($id);
   $existe=count($existe);
   if($existe>0){
      $this->model->eliminarAsesor($id);
      return $this->genericResponse("eliminado exitosamente","",200);
   }else{
    return $this->genericResponse("","eliminado errado cedula no existe",400); 
 }
}


  //crearemos respuesta del servidor nosotros mismos de igual forma arribita se muestra  pero aca creamos una manual
private function genericResponse($data,$msm,$code){
   if($code==200){
      return $this->respond(array(
         "data"=>$data,
         "code"=>$code
       )); //si todo esta bien entrega data y el 200
   }else{
      return $this->respond(array(
         "msm"=>$msm,
         "code"=>$code
       ));  //esta malo 400
   }
}
}