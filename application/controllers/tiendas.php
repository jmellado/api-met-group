<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tiendas extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('tiendas_model');
		$this->load->library('form_validation');

		header("Content-Type: application/json");

		//Esto nos permite recuperar los datos
		$res_json = file_get_contents("php://input");
		$_POST = json_decode($res_json, true);
	}

	public function index(){

		$this->mostrartiendas();

	}

	public function registrar(){

		$this->form_validation->set_rules('nombre_tienda', 'Nombre Tienda', 'required|max_length[45]');
		$this->form_validation->set_rules('direccion_tienda', 'Dirección Tienda', 'required|max_length[45]');

		if ($this->form_validation->run() == FALSE) {
			
			echo validation_errors();
		} 
		else{

			$id_tienda = $this->tiendas_model->obtener_ultimo_id_tienda();
			$nombre_tienda = $this->input->post('nombre_tienda');
			$direccion_tienda = $this->input->post('direccion_tienda');
			$estado_tienda = "Activo";

			$tienda = array(
			'id_tienda'         => $id_tienda,
			'nombre_tienda'     => $nombre_tienda,
			'direccion_tienda'  => $direccion_tienda,
			'estado_tienda'     => $estado_tienda);

			if ($this->tiendas_model->validar_existencia_tienda($nombre_tienda)) {

				$respuesta = $this->tiendas_model->insertar_tienda($tienda);

				if ($respuesta == true) {

					$data['mensaje'] = "tienda registrada satisfactoriamente";
					echo json_encode($data);
				}
				else{

					$data['mensaje'] = "tienda no registrada";
					echo json_encode($data);
				}
				
			}
			else{

				$data['mensaje'] = "tienda ya existe";
				echo json_encode($data);
			}

		}
		
	}

	public function mostrartiendas(){

		$data = array(

			'tiendas' => $this->tiendas_model->buscar_tienda()

		);

		echo json_encode($data);

	}

	public function modificar(){

		$this->form_validation->set_rules('id_tienda', 'Id Tienda', 'required|numeric');
		$this->form_validation->set_rules('nombre_tienda', 'Nombre Tienda', 'required|max_length[45]');
		$this->form_validation->set_rules('direccion_tienda', 'Dirección Tienda', 'required|max_length[45]');
		$this->form_validation->set_rules('estado_tienda', 'Estado', 'required|max_length[10]');

		if ($this->form_validation->run() == FALSE) {
			
			echo validation_errors();
		}
		else{

			$id_tienda = $this->input->post('id_tienda');
			$nombre_tienda = $this->input->post('nombre_tienda');
			$direccion_tienda = $this->input->post('direccion_tienda');
			$estado_tienda = $this->input->post('estado_tienda');

			$tienda = array(
			'nombre_tienda'     => $nombre_tienda,
			'direccion_tienda'  => $direccion_tienda,
			'estado_tienda'     => $estado_tienda);

			if ($this->tiendas_model->validar_existencia_id_tienda($id_tienda)) {

				$nombre_tienda_bus = $this->tiendas_model->obtener_informacion_tienda($id_tienda);

				if ($nombre_tienda_bus == $nombre_tienda) {

					$respuesta = $this->tiendas_model->modificar_tienda($id_tienda,$tienda);

					if ($respuesta == true) {

						$data['mensaje'] = "tienda actualizada satisfactoriamente";
						echo json_encode($data);
					}
					else{

						$data['mensaje'] = "tienda no actualizada";
						echo json_encode($data);
					}

				}
				else{

					if ($this->tiendas_model->validar_existencia_tienda($nombre_tienda)) {

						$respuesta = $this->tiendas_model->modificar_tienda($id_tienda,$tienda);

						if ($respuesta == true) {

							$data['mensaje'] = "tienda actualizada satisfactoriamente";
							echo json_encode($data);
						}
						else{

							$data['mensaje'] = "tienda no actualizada";
							echo json_encode($data);
						}
						
					}
					else{

						$data['mensaje'] = "tienda ya existe";
						echo json_encode($data);
					}

				}

			}
			else{

				$data['mensaje'] = "id_tienda no existe";
				echo json_encode($data);
			}

		}

	}

	public function eliminar(){

		$this->form_validation->set_rules('id_tienda', 'Id Tienda', 'required|numeric');

		if ($this->form_validation->run() == FALSE) {
			
			echo validation_errors();
		}
		else{

			$id_tienda = $this->input->post('id_tienda');

			if ($this->tiendas_model->validar_existencia_id_tienda($id_tienda)) {

				$respuesta = $this->tiendas_model->eliminar_tienda($id_tienda);

				if ($respuesta == true) {
					
					$data['mensaje'] = "tienda eliminada satisfactoriamente";
					echo json_encode($data);
				}
				else{

					$data['mensaje'] = "tienda no eliminada";
					echo json_encode($data);
				}			

			}
			else{

				$data['mensaje'] = "id_tienda no existe";
				echo json_encode($data);
			}

		}

	}

}