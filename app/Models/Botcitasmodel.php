<?php
namespace App\Models;
//en el bot no hice modelo mejor hice un ws 
use CodeIgniter\Model;

class Botcitasmodel extends Model
{
//mostramos las citas disponibles
    public function listarCitas()
    {

       $statement = $this->db->query("SELECT * FROM citas");
       return $statement->getResult();
  }
  //creamos la cita al cliente
  public function  citaSeleecionada($datos){
   $statement = $this->db->query("UPDATE citas Set cedula='$datos[0]',nombre='$datos[1]',correo='$datos[2]',celular='$datos[3]',estado='$datos[4]' WHERE id='$datos[5]'");

}

public function citaFinalLiberada($datos){
   $statement = $this->db->query("UPDATE citas Set cedula='$datos[0]',nombre='$datos[1]',correo='$datos[2]',celular='$datos[3]',estado='$datos[4]' WHERE id='$datos[5]'");

}

// listamos los asesores para cominicarsen posteriormente con el cliente
public function listarAsesor(){
$statement = $this->db->query("SELECT * FROM asesores");
//para recorrer un foreach unicamente retornamos el dato  y alla en el controlador ejecutamos el foreach con el get controller
return $statement;


}
public function validarSiTieneCita($id){
    $statement=$this->db->query("SELECT * FROM citas WHERE cedula='$id'");
    return $statement->getResult();
}


}
