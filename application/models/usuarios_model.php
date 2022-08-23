<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuarios_model extends CI_Model {

	public function insertar_usuario($usuario){

		if ($this->db->insert('usuarios', $usuario)) {
			
			return true;
		}
		else{

			return false;
		}

	}

	public function buscar_usuario(){

		$this->db->select('usuarios.id_usuario,usuarios.username,usuarios.password,usuarios.token,usuarios.estado_usuario');

		$query = $this->db->get('usuarios');

		return $query->result();

	}

	public function modificar_usuario($id_usuario,$usuario){

		$this->db->where('id_usuario', $id_usuario);
		
		if ($this->db->update('usuarios', $usuario)) {
			
			return true;
		}
		else{

			return false;
		}

	}

	public function eliminar_usuario($id_usuario){

		$this->db->where('id_usuario', $id_usuario);

		if ($this->db->delete('usuarios')) {
			
			return true;
		}
		else{

			return false;
		}

	}

	public function obtener_ultimo_id_usuario(){

		$this->db->select_max('id_usuario');
		$query = $this->db->get('usuarios');

		if ($query->num_rows() > 0) {
			
			$row = $query->result_array();
			$id_usuario = 1 + $row[0]['id_usuario'];

			return $id_usuario;

		}
		else{

			return false;
		}
		
	}

	public function validar_existencia_usuario($username){

		$this->db->where('username', $username);
		$query = $this->db->get('usuarios');

		if ($query->num_rows() > 0) {
			
			return false;
		}
		else{

			return true;
		}

	}

	public function validar_existencia_id_usuario($id_usuario){

		$this->db->where('id_usuario', $id_usuario);
		$query = $this->db->get('usuarios');

		if ($query->num_rows() > 0) {
			
			return true;
		}
		else{

			return false;
		}

	}

	public function obtener_informacion_usuario($id_usuario){

		$this->db->where('id_usuario', $id_usuario);
		$query = $this->db->get('usuarios');

		if ($query->num_rows() > 0) {

			$row = $query->result_array();
			$username = $row[0]['username'];

			return $username;

		}
		else{

			return false;
		}

	}

}