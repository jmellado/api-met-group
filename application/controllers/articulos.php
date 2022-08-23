<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Articulos extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('articulos_model');
		$this->load->library('form_validation');

		header("Content-Type: application/json");

		//Esto nos permite recuperar los datos
		$res_json = file_get_contents("php://input");
		$_POST = json_decode($res_json, true);
	}

	public function index(){

		$this->mostrararticulos();

	}

	public function registrar(){

		$this->form_validation->set_rules('nombre_articulo', 'Nombre Articulo', 'required|max_length[45]');
		$this->form_validation->set_rules('descripcion_articulo', 'Descripción Articulo', 'required|max_length[45]');
		$this->form_validation->set_rules('precio_articulo', 'Precio Articulo', 'required|numeric|max_length[11]');
		$this->form_validation->set_rules('id_tienda', 'Id Tienda', 'required|numeric');

		if ($this->form_validation->run() == FALSE) {
			
			echo validation_errors();
		} 
		else{

			$id_articulo = $this->articulos_model->obtener_ultimo_id_articulo();
			$nombre_articulo = $this->input->post('nombre_articulo');
			$descripcion_articulo = $this->input->post('descripcion_articulo');
			$precio_articulo = $this->input->post('precio_articulo');
			$id_tienda = $this->input->post('id_tienda');
			$estado_articulo = "Activo";

			$articulo = array(
			'id_articulo'         	=> $id_articulo,
			'nombre_articulo'      	=> $nombre_articulo,
			'descripcion_articulo'	=> $descripcion_articulo,
			'precio_articulo'		=> $precio_articulo,
			'id_tienda'            	=> $id_tienda,
			'estado_articulo'      	=> $estado_articulo);

			if ($this->articulos_model->validar_existencia_id_tienda($id_tienda)) {

				if ($this->articulos_model->validar_existencia_articulo($nombre_articulo,$id_tienda)) {

					$respuesta = $this->articulos_model->insertar_articulo($articulo);

					if ($respuesta == true) {

						$data['mensaje'] = "articulo registrado satisfactoriamente";
						echo json_encode($data);
					}
					else{

						$data['mensaje'] = "articulo no registrado";
						echo json_encode($data);
					}
					
				}
				else{

					$data['mensaje'] = "nombre_articulo ya existe";
					echo json_encode($data);
				}

			}
			else{

				$data['mensaje'] = "id_tienda no existe";
				echo json_encode($data);
			}

		}
		
	}

	public function mostrararticulos(){

		$data = array(

			'articulos' => $this->articulos_model->buscar_articulo()

		);

		echo json_encode($data);

	}

	public function modificar(){

		$this->form_validation->set_rules('id_articulo', 'Id Articulo', 'required|numeric');
		$this->form_validation->set_rules('nombre_articulo', 'Nombre Articulo', 'required|max_length[45]');
		$this->form_validation->set_rules('descripcion_articulo', 'Descripción Articulo', 'required|max_length[45]');
		$this->form_validation->set_rules('precio_articulo', 'Precio Articulo', 'required|numeric|max_length[11]');
		$this->form_validation->set_rules('id_tienda', 'Id Tienda', 'required|numeric');
		$this->form_validation->set_rules('estado_articulo', 'Estado', 'required|max_length[10]');

		if ($this->form_validation->run() == FALSE) {
			
			echo validation_errors();
		}
		else{

			$id_articulo = $this->input->post('id_articulo');
			$nombre_articulo = $this->input->post('nombre_articulo');
			$descripcion_articulo = $this->input->post('descripcion_articulo');
			$precio_articulo = $this->input->post('precio_articulo');
			$id_tienda = $this->input->post('id_tienda');
			$estado_articulo = $this->input->post('estado_articulo');

			$articulo = array(
			'nombre_articulo'       => $nombre_articulo,
			'descripcion_articulo'	=> $descripcion_articulo,
			'precio_articulo'       => $precio_articulo,
			'id_tienda'        		=> $id_tienda,
			'estado_articulo'    	=> $estado_articulo);

			if ($this->articulos_model->validar_existencia_id_articulo($id_articulo)) {

				if ($this->articulos_model->validar_existencia_id_tienda($id_tienda)) {

					$info_art = $this->articulos_model->obtener_informacion_articulo($id_articulo);
					//var_dump($nombre_articulo_bus);
					if ($info_art[0] == $nombre_articulo && $info_art[1] == $id_tienda) {

						$respuesta = $this->articulos_model->modificar_articulo($id_articulo,$articulo);

						if ($respuesta == true) {

							$data['mensaje'] = "articulo actualizado satisfactoriamente";
							echo json_encode($data);
						}
						else{

							$data['mensaje'] = "articulo no actualizado";
							echo json_encode($data);
						}

					}
					else{

						if ($this->articulos_model->validar_existencia_articulo($nombre_articulo,$id_tienda)) {

							$respuesta = $this->articulos_model->modificar_articulo($id_articulo,$articulo);

							if ($respuesta == true) {

								$data['mensaje'] = "articulo actualizado satisfactoriamente";
								echo json_encode($data);
							}
							else{

								$data['mensaje'] = "articulo no actualizado";
								echo json_encode($data);
							}
							
						}
						else{

							$data['mensaje'] = "nombre_articulo ya existe";
							echo json_encode($data);
						}

					}

				}
				else{

					$data['mensaje'] = "id_tienda no existe";
					echo json_encode($data);
				}

			}
			else{

				$data['mensaje'] = "id_articulo no existe";
				echo json_encode($data);
			}

		}

	}

	public function eliminar(){

		$this->form_validation->set_rules('id_articulo', 'Id Articulo', 'required|numeric');

		if ($this->form_validation->run() == FALSE) {
			
			echo validation_errors();
		}
		else{

			$id_articulo = $this->input->post('id_articulo');

			if ($this->articulos_model->validar_existencia_id_articulo($id_articulo)) {

				$respuesta = $this->articulos_model->eliminar_articulo($id_articulo);

				if ($respuesta == true) {
					
					$data['mensaje'] = "articulo eliminado satisfactoriamente";
					echo json_encode($data);
				}
				else{

					$data['mensaje'] = "articulo no eliminado";
					echo json_encode($data);
				}			

			}
			else{

				$data['mensaje'] = "id_articulo no existe";
				echo json_encode($data);
			}

		}

	}

}