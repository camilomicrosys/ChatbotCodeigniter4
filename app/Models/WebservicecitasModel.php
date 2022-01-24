<?php
namespace App\Models;

use CodeIgniter\Model;

class WebservicecitasModel extends Model
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
//MODULO DE GESTION DE ASESORES
//crear un asesor
public function crearAsesor($datos){
$nombres = $this->db->table('asesores');
        $nombres->insert($datos);
        // ESTE ES PARA QUE ME RETORNE EL ID DEL NOMBRE CREADO
        return $this->db->insertID();
}

//actualizar asesor
public function actualizarAsesor($datos){
 $statement = $this->db->query("UPDATE asesores Set cedula='$datos[0]',nombre='$datos[1]',email='$datos[2]',telefono='$datos[3]',totalTramitesAsignados='$datos[4]' WHERE cedula='$datos[0]'");
}
public function eliminarAsesor($id){
$statement=$this->db->query("DELETE from  asesores where cedula='$id'");
}
public function validadSiAsesorExiste($id){
   $statement = $this->db->query("SELECT * FROM asesores WHERE cedula='$id'");
//para recorrer un foreach unicamente retornamos el dato  y alla en el controlador ejecutamos el foreach con el get controller
    return $statement->getResult();; 
}
}