<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Articulos_model extends CI_Model {

	public function insertar_articulo($articulo){

		if ($this->db->insert('articulos', $articulo)) {
			
			return true;
		}
		else{

			return false;
		}

	}

	public function buscar_articulo(){

		$this->db->join('tiendas', 'articulos.id_tienda = tiendas.id_tienda');

		$this->db->select('articulos.id_articulo,articulos.nombre_articulo,articulos.descripcion_articulo,articulos.precio_articulo,articulos.id_tienda,tiendas.nombre_tienda,articulos.estado_articulo');

		$query = $this->db->get('articulos');

		return $query->result();

	}

	public function modificar_articulo($id_articulo,$articulo){

		$this->db->where('id_articulo', $id_articulo);
		
		if ($this->db->update('articulos', $articulo)) {
			
			return true;
		}
		else{

			return false;
		}

	}

	public function eliminar_articulo($id_articulo){

		$this->db->where('id_articulo', $id_articulo);

		if ($this->db->delete('articulos')) {
			
			return true;
		}
		else{

			return false;
		}

	}

	public function obtener_ultimo_id_articulo(){

		$this->db->select_max('id_articulo');
		$query = $this->db->get('articulos');

		if ($query->num_rows() > 0) {
			
			$row = $query->result_array();
			$id_articulo = 1 + $row[0]['id_articulo'];

			return $id_articulo;

		}
		else{

			return false;
		}
		
	}

	public function validar_existencia_articulo($nombre_articulo,$id_tienda){

		$this->db->where('nombre_articulo', $nombre_articulo);
		$this->db->where('id_tienda', $id_tienda);

		$query = $this->db->get('articulos');

		if ($query->num_rows() > 0) {
			
			return false;
		}
		else{

			return true;
		}

	}

	public function validar_existencia_id_articulo($id_articulo){

		$this->db->where('id_articulo', $id_articulo);
		$query = $this->db->get('articulos');

		if ($query->num_rows() > 0) {
			
			return true;
		}
		else{

			return false;
		}

	}

	public function obtener_informacion_articulo($id_articulo){

		$this->db->where('id_articulo', $id_articulo);
		$query = $this->db->get('articulos');

		if ($query->num_rows() > 0) {

			$row = $query->result_array();
			$nombre_articulo = $row[0]['nombre_articulo'];
			$id_tienda = $row[0]['id_tienda'];

			return [$nombre_articulo,$id_tienda];

		}
		else{

			return false;
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

}