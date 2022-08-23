<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('login_model');
		$this->load->library('form_validation');

		header("Content-Type: application/json");

		//Esto nos permite recuperar los datos
		$res_json = file_get_contents("php://input");
		$_POST = json_decode($res_json, true);
	}

	public function login_user(){

		$this->form_validation->set_rules('username', 'Usuario', 'required|max_length[15]');
		$this->form_validation->set_rules('password', 'Contraseña', 'required|max_length[15]');

		if ($this->form_validation->run() == FALSE) {
			
			echo validation_errors();
		}
		else{

			$username = $this->input->post('username');
			$password = sha1($this->input->post('password'));
			$check_user = $this->login_model->login_usuarios($username,$password);

			if ($check_user == true) {
				
				if ($check_user->estado_usuario == "Activo") {
				
					$id_usuario = $check_user->id_usuario;
					$username   = $check_user->username;
					$token      = sha1($id_usuario.$username);

					$data = array('token' => $token);

					if ($this->login_model->modificar_token_usuario($id_usuario,$data)) {
						
						echo json_encode($data);
					}
					else{

						$data['mensaje'] = "token no actualizado";
						echo json_encode($data);
					}

				}
				else{

					$data['mensaje'] = "usuario inactivo";
					echo json_encode($data);
				}
				
			}
			else{

				$data['mensaje'] = "usuario no existe";
				echo json_encode($data);
			}

		}

	}

}