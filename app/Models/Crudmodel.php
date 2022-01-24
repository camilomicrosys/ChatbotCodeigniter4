<?php
namespace App\Models;

use CodeIgniter\Model;

class Crudmodel extends Model
{
    public function listarNombres()
    {
        $dato = $this->db->query('SELECT * FROM personas');
        return $dato->getResult();
    }

    public function insertar($datos)
    {
        $nombres = $this->db->table('personas');
        $nombres->insert($datos);
        // ESTE ES PARA QUE ME RETORNE EL ID DEL NOMBRE CREADO
        return $this->db->insertID();
    }
//aca ponemso data por que ya desde  el controladosr sacamos en un array asociativo id_perosna = id$nombre que se aplica en este were
    public function obtenerNombre($data)
    {
        $nombres = $this->db->table('personas');
        $nombres->where($data);
        // este me retorna un arreglo de arreglos
        return $nombres->get()->getResultArray();
    }

    public function actualizar($data, $idNombre)
    {
        $nombres = $this->db->table('personas');
        //set es para actualizar y data es lo que tiene todos los datos en orden de la tabla y el id nombre es el id que se actualizara
        $nombres->set($data);
        $nombres->where('id_persona', $idNombre);
        return $nombres->update();

    }

    public function eliminar($id)
    {
        $nombres = $this->db->table('personas');
        // este es el mismo de actualizar solo que puede enviarse como array asociativo o por parametros al igual que puede utilizarse el builder query, o solo el query sql como lo hacemos siempre en la primer linea
        $nombres->where($id);
        // este return tru si se dio o false si no se dio al igual que actualizar pero con eso temenos ya para el proceso del mensaje en el controlador
        return $nombres->delete($id);

    }
}
