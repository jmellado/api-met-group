<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model {

	public function login_usuarios($username,$password){

		$this->db->select('usuarios.id_usuario,usuarios.username,usuarios.token,usuarios.estado_usuario');
		$this->db->from('usuarios');
		$this->db->where('username',$username);
		$this->db->where('password',$password);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			
			return $query->row();
		}
		else{

			return false;
		}

	}

	public function modificar_token_usuario($id_usuario,$data){

		$this->db->where('id_usuario', $id_usuario);
		
		if ($this->db->update('usuarios', $data)) {
			
			return true;
		}
		else{

			return false;
		}

	}

}