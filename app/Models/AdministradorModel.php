<?php
namespace App\Models;



// esto es para ejecutar queys manual segun documentacion
use CodeIgniter\Database\Query;
use CodeIgniter\Model;

class AdministradorModel extends Model
{

 /*
 ---------------------------------------
 sesion de Gestionamiento de usuarios
 --------------------------------------
 */
 public function mostrarRol()
 {
  $dato = $this->db->query('SELECT * FROM roles');
  return $dato->getResult();
}

public function mostrarUsuariosFormularioBuscador($search)
{
        /*
        esta funcion la llamo en la vista de gestionar usuarios en vistas del sistema incluso en la vista llame al modelo y alli cree el objeto
        lo de abajito de query builder es lo que hace  esta consulta de like or
        $dato  = $this->db->query("SELECT * FROM USUARIOS WHERE  username LIKE CONCAT('%',:search,'%') OR  Cedula LIKE CONCAT('%',:search,'%') OR Nombres LIKE CONCAT('%',:search,'%') OR Apellidos LIKE CONCAT('%',:search,'%') OR Perfil LIKE CONCAT('%',:search,'%')OR Estado LIKE CONCAT('%',:search,'%')");
         */
        $datos = $this->db->table('usuarios');
        $datos->like('username', $search);
        $datos->orLike('Cedula', $search);
        $datos->orLike('Nombres', $search);
        $datos->orLike('Apellidos', $search);
        $datos->orLike('Perfil', $search);
        $datos->orLike('Estado', $search);
        return $datos->get()->getResultArray();
      }


//Inicio Borrado de Usuarios

    /* Traer todos los datos de persona a borrar
    el borrado de usuarios lleva todos estos metodos donde sacamos todo por el id, donde debemos mirar si es asesor o admin solo se borra de usuarios y si genero liquidaciones tambien borrarlo de liquidaciones, si es cliente hay que borrarlo de usuarios de cliente y de liquidaciones si genero alguna liquidacion
    */
    public function pasoTodosLosDatosUsuarioaEditar($id)
    {
     $statement = $this->db->query("SELECT *FROM usuarios where id_usuario='$id'");
     // este me retorna un arreglo de arreglos
     return $statement->getResult();
   }
 /* eliminacion de la tabla usuarios
 para la eliminacion de un usuario debemos hacer 2 querys de eliminacion 1 en la tabla de usuarios y otra en la tabla de clientes
   */
 public function borrarClienTabUsua($id){
   $statement=$this->db->query("DELETE FROM usuarios where id_usuario='$id'");
   return $statement;
 }
   /*Borrado en la tabla clientes
   este id cliente lo sacamos de laconsulta asoTodosLosDatosUsuarioaEditar($id) donde tiene una columna que nos retorna ese identificador ya que cuando se crea un cliente se inserta ese id cliente en la tabla de usuarios
   */
   public function borrarClienTabClient($id_cliente)
   {
    $statement = $this->db->query("DELETE  FROM clientes where idClientes='$id_cliente'");

  }
/*Borrado en tabla liquidaciones
para este caso nos sirve el id de usuarios solo que en la consulta lo buscamos en la columna de cedula que es igual al id_usuario de tabla usuarios
*/
public function borrarTablaLiquidaciones($id){
  $statements=$this->db->query("DELETE FROM liquidaciones where usuCedula='$id'");
  return $statements;
}

public function agregarUsuarios($datos)
{
  $statement = $this->db->query("INSERT INTO usuarios (username,password,Cedula,Nombres,Apellidos,Email,Telefono,Perfil,Estado) VALUES ('$datos[0]','$datos[1]','$datos[2]','$datos[3]','$datos[4]','$datos[5]','$datos[6]','$datos[7]','$datos[8]')");
        //esta linea retorna el id que se le asigno cuando fue
  return $this->db->insertID();

}

public function actualizarUsuario($datos){

  $statement = $this->db->query("UPDATE usuarios SET   username='$datos[0]',password='$datos[1]',Cedula='$datos[2]',Nombres='$datos[3]',Apellidos='$datos[4]',Email='$datos[5]',Telefono='$datos[6]',Perfil='$datos[7]',Estado='$datos[8]' where id_usuario='$datos[9]' ");

}

//fin borrado de usuarios


 /*
 ---------------------------------------
 sesion de Gestionamiento Impuestos
 --------------------------------------
 */

 public function mostrarImpuestos(){
   $dato=$this->db->query("SELECT * FROM impuestos");
   return $dato->getResult();
 }

 public function traerImpuestoById($id){
  $dato=$this->db->query("SELECT * FROM impuestos WHERE idImpuesto='$id'");
  return $dato->getResult();
}

public function actualizarImpuesto($datos)
{
  $statement = $this->db->query("UPDATE impuestos SET   impuestoRenta='$datos[1]',derechoCamara='$datos[2]',  formulario='$datos[3]',certificadoPJuridica='$datos[4]',certificadoPNatural='$datos[5]' where idImpuesto='$datos[0]'");
}



       /*
 ---------------------------------------
 sesion de Gestionamiento Municipios
 --------------------------------------
 */
 public function mostrarMunicipios(){
  $statement = $this->db->query("SELECT * FROM municipio");
  return $statement->getResult();
}

public function agregarMunicipio($municipio){
  $statement = $this->db->query("INSERT INTO municipio (municipio) VALUES ('$municipio')");
  return $this->db->insertID();
}

public function traerMunicipioById($id){
  $statement = $this->db->query("SELECT * FROM municipio where idMunicipio='$id'");
  return $statement->getResult();
}

public function eliminarMunicipio($id){
  $statement = $this->db->query("DELETE FROM municipio where idMunicipio='$id'");
}
public function actualizarMunicipio($datos){

  $statement=$this->db->query("UPDATE municipio SET municipio='$datos[1]' where idMunicipio='$datos[0]'");

}

       /*
 ---------------------------------------
 sesion de Gestionamiento Rangos
 --------------------------------------
 */

 public function mostrarRangos(){
   $statement=$this->db->query("SELECT * FROM rangos");
   return $statement->getResult();


 }
 public function actualizarRangos($datos){

  $statement=$this->db->query("UPDATE rangos SET   rangoUno='$datos[1]',rangoDos='$datos[2]' where idRango='$datos[0]' ");
  
}





       /*
 ---------------------------------------
 sesion Pnael de clientes
 --------------------------------------
 */
       /*
 ---------------------------------------
 sesion Pnael de clientes
 --------------------------------------
 */

 public function mostUsuSinElBuscador(){
   $statement=$this->db->query("SELECT * FROM usuarios");
   return $statement->getResult();
 }
  //registro de liquidacion pn

 public function liquidarCliente($tipoEmpresa, $fecha, $valorPago, $usuCedula, $ccCliente, $idMunicipio, $idImpuesto, $idRango){

  $statement=$this->db->query("INSERT INTO liquidaciones(tipoPnJur,Fecha,valorPago,usuCedula,ccCliente,idMunicipio,idImpuesto,idRango) VALUES('$tipoEmpresa', '$fecha','$valorPago','$usuCedula', '$ccCliente', '$idMunicipio','$idImpuesto','$idRango')");
         //esta linea retorna el id que se le asigno cuando fue
  return $this->db->insertID();

}

//creamos liquidar cliente ya que el tiene un id cliente, y el funcionaio no, ya que no es un cliente, esta es para un asesoro administrador, de igual manera guardara los datos pero e el controlador  hare un comparativo con la sesion para ver si es adin o hacersor no insertar id cliente
public function liquidarFuncionario($tipoEmpresa, $fecha, $valorPago, $usuCedula, $idMunicipio, $idImpuesto, $idRango){
 $statement=$this->db->query("INSERT INTO liquidaciones (tipoPnJur,Fecha,valorPago,usuCedula,idMunicipio,idImpuesto,idRango) VALUES ('$tipoEmpresa', '$fecha','$valorPago','$usuCedula','$idMunicipio','$idImpuesto','$idRango')");
 return $this->db->insertID();
}
     //aca gestionaremos las liquidaciones que hallarealizado un usuario para que pueda imprimir su soporte
public function listarLiquidacionesPorUsuario($cedula)
{
  $statement = $this->db->query("SELECT * FROM liquidaciones where usuCedula='$cedula'");
  return $statement->getResult();
}
public function mostrarCliente($search)
{
        /*
        esta funcion la llamo en la vista de gestionar usuarios en vistas del sistema incluso en la vista llame al modelo y alli cree el objeto
        lo de abajito de query builder es lo que hace  esta consulta de like or
        $dato  = $this->db->query("SELECT * FROM USUARIOS WHERE  username LIKE CONCAT('%',:search,'%') OR  Cedula LIKE CONCAT('%',:search,'%') OR Nombres LIKE CONCAT('%',:search,'%') OR Apellidos LIKE CONCAT('%',:search,'%') OR Perfil LIKE CONCAT('%',:search,'%')OR Estado LIKE CONCAT('%',:search,'%')");
         */
        $datos = $this->db->table('clientes');
        $datos->like('ccCliente', $search);
        $datos->orLike('Nombres', $search);
        $datos->orLike('Apellidos', $search);
        $datos->orLike('Email', $search);
        $datos->orLike('Telefono', $search);
        
        return $datos->get()->getResult();
      }


      public function agregarClienExterClient($cedula, $nombre, $apellido, $email, $telefono, $fechaRegistro, $idMunicipio){
        $statement=$this->db->query("INSERT INTO clientes (ccCliente,Nombres,Apellidos,Email,Telefono,fechaRegistro,idMunicipio) VALUES ('$cedula','$nombre','$apellido','$email','$telefono','$fechaRegistro','$idMunicipio')");
        return $this->db->insertID();

      }

      public function agregarClienExterUsua($usuario, $password, $cedula, $nombre, $apellido, $email, $telefono, $perfil, $estado, $idClientes){
        $statement=$this->db->query("INSERT INTO usuarios (username,password,Cedula,Nombres,Apellidos,Email,Telefono,Perfil,Estado,idClientes) VALUES ('$usuario','$password','$cedula','$nombre','$apellido','$email','$telefono','$perfil','$estado','$idClientes')");


      }
//actualizar un cliente lleva dos pasos actualizarlo como cliente y como usuario
      public function actualizarClienExterUsua($id, $usuario, $password, $cedula, $nombre, $apellido, $email, $telefono, $estado){

       $statement=$this->db->query("UPDATE usuarios SET   username='$usuario',password='$password',Cedula='$cedula',Nombres='$nombre',Apellidos='$apellido',Email='$email',Telefono='$telefono',Estado='$estado' where idClientes='$id' ");
     }
   //MODULO DE ACTUALIZAR DEL CLIENTE EN TABLA CLIENTE DESDE ASESOR
     public function actualizarClienExterClient($id, $cedula, $nombre, $apellido, $email, $telefono, $idMunicipio){
      $statement=$this->db->query("UPDATE clientes SET   ccCliente='$cedula',Nombres='$nombre',Apellidos='$apellido',Email='$email',Telefono='$telefono',idMunicipio='$idMunicipio' where idClientes='$id' ");

    }

    public function seleccionarClientePorId($id){

      $statement=$this->db->query("SELECT * FROM clientes WHERE idClientes='$id'");
      return $statement->getResult();
    }
    public function mostrarUsuariosPorForaneaCliente($id)
    {
      $statement = $this->db->query("SELECT * FROM usuarios where idClientes='$id'");
      return $statement->getResult();
    }



    //MODULO GENERACION DE PDF
      public function listarLiquidacionesPorRadicado($radicado)
    {

        
        $statement = $this->db->query("SELECT * FROM liquidaciones where Radicado='$radicado'");
      
        return $statement->getResult();

    }
     //esta es para sacar los datos de nombre y cedula del usuario generador de la liquidacion

    public function listarLiquidacionesPorUsuariopdf($id_usuario)
    {

       $statement = $this->db->query("SELECT * FROM usuarios where id_usuario='$id_usuario'");
       return $statement->getResult();

    }

  }

  

  


