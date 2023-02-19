<?php
class Admin extends Controller //heredamos controller
{
    public function __construct() //Constructor iniciar session
    {
        session_start(); //Inicias la session
        parent::__construct(); //cargar el constructor de la instancia del modelo
    }

    public function index()
    {
        if (empty($_SESSION['activo_plantas_fijas'])) { //Evaluamos si el usuairo ya esta autenticado
            header("location: " . base_url);
        }

        if ($_SESSION['rol_plantas_fijas'] != 'developer') { //Evaluamos si el usuairo ya esta autenticado
            header("location: " . base_url . 'Plantas');
        }
        
        $this->views->getView($this, "index"); //Cargamois la vista de Autorizar
    }
    
    public function list_operacion() //Listar Registros en Tabla
    {
        $data = $this->model->getBOperacion(); //Obtener todos los registros para la tabla de operacion
        for ($i = 0; $i < count($data); $i++) { //Form para evaluar cada uno de los registros

            switch ($data[$i]['estatus']) {
                case 'NUEVO':
                    $data[$i]['acciones'] = '<div>
                        <button type="button" class="btn btn-primary btn-sm" onclick="frmInfoOperacion(' . $data[$i]['id'] . ');" title="Info""><i class="fa-solid fa-inbox"></i></button>
                        </div>'; //Añadimos los button a cada uno de los registros 
                    $data[$i]['estatus'] = '<span style="color: blue;">NUEVO</span>';
                    break;
                case 'APROBADO':
                    $data[$i]['acciones'] = '<div>
                        <button type="button" class="btn btn-primary btn-sm" onclick="frmInfoOperacion(' . $data[$i]['id'] . ');" title="Info""><i class="fa-solid fa-inbox"></i></button>
                        </div>'; //Añadimos los button a cada uno de los registros 
                    $data[$i]['estatus'] = '<span style="color: green;">APROBADO</span>';
                    break;
                case 'RECHAZADO':
                    $data[$i]['acciones'] = '<div>
                        <button type="button" class="btn btn-primary btn-sm" onclick="frmInfoOperacion(' . $data[$i]['id'] . ');" title="Info""><i class="fa-solid fa-inbox"></i></button>                        
                        </div>'; //Añadimos los button a cada uno de los registros 
                    $data[$i]['estatus'] = '<span style="color: red;">RECHAZADO</span>';
                    break;
                default:
                case 'FINALIZADO':
                    $data[$i]['acciones'] = '<div>
                        <button type="button" class="btn btn-primary btn-sm" onclick="frmInfoOperacion(' . $data[$i]['id'] . ');" title="Info""><i class="fa-solid fa-inbox"></i></button>
                        </div>'; //Añadimos los button a cada uno de los registros 
                    $data[$i]['estatus'] = '<span style="color: black;">FINALIZADO</span>';
                    break;
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE); //Convertir a json la data
        die();
    }

    public function list_mantenimiento() //Listar Registros en Tabla
    {
        $data = $this->model->getBMantenimiento(); //Obtener todos los registros para la tabla de operacion
        for ($i = 0; $i < count($data); $i++) { //Form para evaluar cada uno de los registros

            switch ($data[$i]['estatus']) {
                case 'NUEVO':
                    $data[$i]['acciones'] = '<div>
                        <button type="button" class="btn btn-primary btn-sm" onclick="frmInfoMantenimiento(' . $data[$i]['id'] . ');" title="Info""><i class="fa-solid fa-inbox"></i></button>
                        </div>'; //Añadimos los button a cada uno de los registros 
                    $data[$i]['estatus'] = '<span style="color: blue;">NUEVO</span>';
                    break;
                case 'APROBADO':
                    $data[$i]['acciones'] = '<div>
                        <button type="button" class="btn btn-primary btn-sm" onclick="frmInfoMantenimiento(' . $data[$i]['id'] . ');" title="Info""><i class="fa-solid fa-inbox"></i></button>
                        </div>'; //Añadimos los button a cada uno de los registros 
                    $data[$i]['estatus'] = '<span style="color: green;">APROBADO</span>';
                    break;
                case 'RECHAZADO':
                    $data[$i]['acciones'] = '<div>
                        <button type="button" class="btn btn-primary btn-sm" onclick="frmInfoMantenimiento(' . $data[$i]['id'] . ');" title="Info""><i class="fa-solid fa-inbox"></i></button>                        
                        </div>'; //Añadimos los button a cada uno de los registros 
                    $data[$i]['estatus'] = '<span style="color: red;">RECHAZADO</span>';
                    break;
                default:
                case 'FINALIZADO':
                    $data[$i]['acciones'] = '<div>
                        <button type="button" class="btn btn-primary btn-sm" onclick="frmInfoMantenimiento(' . $data[$i]['id'] . ');" title="Info""><i class="fa-solid fa-inbox"></i></button>
                        </div>'; //Añadimos los button a cada uno de los registros 
                    $data[$i]['estatus'] = '<span style="color: black;">FINALIZADO</span>';
                    break;
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE); //Convertir a json la data
        die();
    }
    
   
}
