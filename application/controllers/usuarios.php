<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuarios extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('usuarios_model');
		$this->load->library('form_validation');

		header("Content-Type: application/json");

		//Esto nos permite recuperar los datos
		$res_json = file_get_contents("php://input");
		$_POST = json_decode($res_json, true);
	}

	public function index(){

		$this->mostrarusuarios();

	}

	public function registrar(){

		$this->form_validation->set_rules('username', 'Username', 'required|max_length[45]');
		$this->form_validation->set_rules('password', 'Password', 'required|max_length[45]');

		if ($this->form_validation->run() == FALSE) {
			
			echo validation_errors();
		} 
		else{

			$id_usuario = $this->usuarios_model->obtener_ultimo_id_usuario();
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$estado_usuario = "Activo";

			$usuario = array(
			'id_usuario'        => $id_usuario,
			'username'          => $username,
			'password'          => sha1($password),
			'token'             => "",
			'estado_usuario'    => $estado_usuario);

			if ($this->usuarios_model->validar_existencia_usuario($username)) {

				$respuesta = $this->usuarios_model->insertar_usuario($usuario);

				if ($respuesta == true) {

					$data['mensaje'] = "usuario registrado satisfactoriamente";
					echo json_encode($data);
				}
				else{

					$data['mensaje'] = "usuario no registrado";
					echo json_encode($data);
				}
				
			}
			else{

				$data['mensaje'] = "username ya existe";
				echo json_encode($data);
			}

		}
		
	}

	public function mostrarusuarios(){

		$data = array(

			'usuarios' => $this->usuarios_model->buscar_usuario()

		);

		echo json_encode($data);

	}

	public function modificar(){

		$this->form_validation->set_rules('id_usuario', 'Id Usuario', 'required|numeric');
		$this->form_validation->set_rules('username', 'Username', 'required|max_length[45]');
		$this->form_validation->set_rules('password', 'Password', 'required|max_length[45]');
		$this->form_validation->set_rules('estado_usuario', 'Estado', 'required|max_length[10]');

		if ($this->form_validation->run() == FALSE) {
			
			echo validation_errors();
		}
		else{

			$id_usuario = $this->input->post('id_usuario');
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$estado_usuario = $this->input->post('estado_usuario');

			$usuario = array(
			'username'          => $username,
			'password'          => sha1($password),
			'estado_usuario'    => $estado_usuario);

			if ($this->usuarios_model->validar_existencia_id_usuario($id_usuario)) {

				$username_bus = $this->usuarios_model->obtener_informacion_usuario($id_usuario);

				if ($username_bus == $username) {

					$respuesta = $this->usuarios_model->modificar_usuario($id_usuario,$usuario);

					if ($respuesta == true) {

						$data['mensaje'] = "usuario actualizado satisfactoriamente";
						echo json_encode($data);
					}
					else{

						$data['mensaje'] = "usuario no actualizado";
						echo json_encode($data);
					}

				}
				else{

					if ($this->usuarios_model->validar_existencia_usuario($username)) {

						$respuesta = $this->usuarios_model->modificar_usuario($id_usuario,$usuario);

						if ($respuesta == true) {

							$data['mensaje'] = "usuario actualizado satisfactoriamente";
							echo json_encode($data);
						}
						else{

							$data['mensaje'] = "usuario no actualizado";
							echo json_encode($data);
						}
						
					}
					else{

						$data['mensaje'] = "username ya existe";
						echo json_encode($data);
					}

				}

			}
			else{

				$data['mensaje'] = "id_usuario no existe";
				echo json_encode($data);
			}

		}

	}

	public function eliminar(){

		$this->form_validation->set_rules('id_usuario', 'Id Usuario', 'required|numeric');

		if ($this->form_validation->run() == FALSE) {
			
			echo validation_errors();
		}
		else{

			$id_usuario = $this->input->post('id_usuario');

			if ($this->usuarios_model->validar_existencia_id_usuario($id_usuario)) {

				$respuesta = $this->usuarios_model->eliminar_usuario($id_usuario);

				if ($respuesta == true) {
					
					$data['mensaje'] = "usuario eliminado satisfactoriamente";
					echo json_encode($data);
				}
				else{

					$data['mensaje'] = "usuario no eliminado";
					echo json_encode($data);
				}			

			}
			else{

				$data['mensaje'] = "id_usuario no existe";
				echo json_encode($data);
			}

		}

	}

}