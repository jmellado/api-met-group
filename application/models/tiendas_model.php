<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tiendas_model extends CI_Model {

	public function insertar_tienda($tienda){

		if ($this->db->insert('tiendas', $tienda)) {
			
			return true;
		}
		else{

			return false;
		}

	}

	public function buscar_tienda(){

		$this->db->select('tiendas.id_tienda,tiendas.nombre_tienda,tiendas.direccion_tienda,tiendas.estado_tienda');

		$query = $this->db->get('tiendas');

		if ($query->num_rows() > 0) {

			$tiendas = $query->result_array();

			if (count($tiendas) > 0) {

				$tiendas_array = array();

				for ($i=0; $i < count($tiendas); $i++) { 
					
					$id_tienda = $tiendas[$i]['id_tienda'];
					$nombre_tienda = $tiendas[$i]['nombre_tienda'];
					$direccion_tienda = $tiendas[$i]['direccion_tienda'];
					$estado_tienda = $tiendas[$i]['estado_tienda'];
					$articulos = $this->buscar_articulos_tienda($id_tienda);

					$tienda = array(
						'id_tienda' 		=> $id_tienda,
						'nombre_tienda' 	=> $nombre_tienda,
						'direccion_tienda' 	=> $direccion_tienda, 
						'estado_tienda' 	=> $estado_tienda,
						'articulos'         => $articulos
					);

					$tiendas_array[] = $tienda;

				}

				return $tiendas_array;

			}
			else{

				return [];
			}

		}
		else{

			return [];
		}

	}

	public function buscar_articulos_tienda($id_tienda){

		$this->db->where('id_tienda', $id_tienda);

		$this->db->select('articulos.id_articulo,articulos.nombre_articulo,articulos.descripcion_articulo,articulos.precio_articulo,articulos.estado_articulo');

		$query = $this->db->get('articulos');

		if ($query->num_rows() > 0) {

			return $query->result_array();
		}
		else{

			return [];
		}

	}

	public function modificar_tienda($id_tienda,$tienda){

		$this->db->where('id_tienda', $id_tienda);
		
		if ($this->db->update('tiendas', $tienda)) {
			
			return true;
		}
		else{

			return false;
		}

	}

	public function eliminar_tienda($id_tienda){

		$this->db->where('id_tienda', $id_tienda);

		if ($this->db->delete('tiendas')) {
			
			return true;
		}
		else{

			return false;
		}

	}

	public function obtener_ultimo_id_tienda(){

		$this->db->select_max('id_tienda');
		$query = $this->db->get('tiendas');

		if ($query->num_rows() > 0) {
			
			$row = $query->result_array();
			$id_tienda = 1 + $row[0]['id_tienda'];

			return $id_tienda;

		}
		else{

			return false;
		}
		
	}

	public function validar_existencia_tienda($nombre_tienda){

		$this->db->where('nombre_tienda', $nombre_tienda);
		$query = $this->db->get('tiendas');

		if ($query->num_rows() > 0) {
			
			return false;
		}
		else{

			return true;
		}

	}

	public function validar_existencia_id_tienda($id_tienda){

		$this->db->where('id_tienda', $id_tienda);
		$query = $this->db->get('tiendas');

		if ($query->num_rows() > 0) {
			
			return true;
		}
		else{

			return false;
		}

	}

	public function obtener_informacion_tienda($id_tienda){

		$this->db->where('id_tienda', $id_tienda);
		$query = $this->db->get('tiendas');

		if ($query->num_rows() > 0) {

			$row = $query->result_array();
			$nombre_tienda = $row[0]['nombre_tienda'];

			return $nombre_tienda;

		}
		else{

			return false;
		}

	}

}