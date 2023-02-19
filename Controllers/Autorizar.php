<?php
class Autorizar extends Controller //heredamos controller
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

        if ($_SESSION['rol_plantas_fijas'] == 'radiobases') { //Evaluamos si el usuairo ya esta autenticado
            header("location: " . base_url . 'Solicitar');
        }
        
        $this->views->getView($this, "index"); //Cargamois la vista de Autorizar
    }
    
    public function listar_autorizar_operacion() //Listar Registros en Tabla
    {
        $data = $this->model->getAutorizar_operacion(); //Obtener todos los registros para la tabla de operacion
        for ($i = 0; $i < count($data); $i++) { //Form para evaluar cada uno de los registros

            switch ($data[$i]['estatus']) {
                case 'NUEVO':
                    $data[$i]['acciones'] = '<div>
                        <button type="button" class="btn btn-primary btn-sm" onclick="frmAutorizarOperacion(' . $data[$i]['id'] . ');" title="Autorizar"><i class="fa-solid fa-check"></i></button>
                        <button type="button" class="btn btn-info btn-sm" onclick="frmRechazarOperacion(\'' . $data[$i]['id'] . '\',\'' . $data[$i]['lts_inicial'] . '\',\'' . $data[$i]['f_inicio'] . '\');" title="Rechazar""><i class="fa-solid fa-xmark"></i></button>
                        </div>'; //Añadimos los button a cada uno de los registros 
                    $data[$i]['estatus'] = '<span style="color: blue;">NUEVO</span>';
                    break;
                case 'APROBADO':
                    $data[$i]['acciones'] = '<div>
                        <button type="button" class="btn btn-primary btn-sm" onclick="frmAutorizarOperacion(' . $data[$i]['id'] . ');" disabled title="Autorizar"><i class="fa-solid fa-check"></i></button>
                        <button type="button" class="btn btn-info btn-sm" onclick="frmRechazarOperacion(\'' . $data[$i]['id'] . '\',\'' . $data[$i]['lts_inicial'] . '\',\'' . $data[$i]['f_inicio'] . '\');" disabled title="Rechazar"><i class="fa-solid fa-xmark"></i></button>
                        </div>'; //Añadimos los button a cada uno de los registros 
                    $data[$i]['estatus'] = '<span style="color: green;">APROBADO</span>';
                    break;
                default:
                    //code...
                    break;
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE); //Convertir a json la data
        die();
    }

    public function listar_autorizar_bitacora_operacion() //Listar Registros en Tabla
    {
        $data = $this->model->getAutorizar_bitacora_operacion(); //Obtener todos los registros para la tabla de bitacora operacion
        for ($i = 0; $i < count($data); $i++) { //Form para evaluar cada uno de los registros

            switch ($data[$i]['estatus']) {
                case 'FINALIZADO':
                    $data[$i]['estatus'] = '<span style="color: black;">FINALIZADO</span>';
                    break;
                case 'RECHAZADO':
                    $data[$i]['estatus'] = '<span style="color: red;">RECHAZADO</span>';
                    break;
                default:
                    //code...
                    break;
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE); //Convertir a json la data
        die();
    }

    public function listar_autorizar_mantenimiento() //Listar Registros en Tabla
    {
        $data = $this->model->getAutorizar_mantenimiento(); //Obtener todos los registros para la tabla de mantenimiento
        for ($i = 0; $i < count($data); $i++) { //Form para evaluar cada uno de los registros

            switch ($data[$i]['estatus']) {
                case 'NUEVO':
                    $data[$i]['acciones'] = '<div>
                        <button type="button" class="btn btn-primary btn-sm" onclick="frmAutorizarMantenimiento(' . $data[$i]['id'] . ');" title="Autorizar"><i class="fa-solid fa-check"></i></button>
                        <button type="button" class="btn btn-info btn-sm" onclick="frmRechazarMantenimiento(\'' . $data[$i]['id'] . '\',\'' . $data[$i]['lts_inicial'] . '\',\'' . $data[$i]['f_inicio'] . '\');" title="Rechazar"><i class="fa-solid fa-xmark"></i></button>
                        </div>'; //Añadimos los button a cada uno de los registros 
                    $data[$i]['estatus'] = '<span style="color: blue;">NUEVO</span>';
                    break;
                case 'APROBADO':
                    $data[$i]['acciones'] = '<div>
                        <button type="button" class="btn btn-primary btn-sm" onclick="frmAutorizarMantenimiento(' . $data[$i]['id'] . ');" disabled title="Autorizar""><i class="fa-solid fa-check"></i></button>
                        <button type="button" class="btn btn-info btn-sm" onclick="frmRechazarMantenimiento(\'' . $data[$i]['id'] . '\',\'' . $data[$i]['lts_inicial'] . '\',\'' . $data[$i]['f_inicio'] . '\');" disabled title="Rechazar"><i class="fa-solid fa-xmark"></i></button>
                        </div>'; //Añadimos los button a cada uno de los registros 
                    $data[$i]['estatus'] = '<span style="color: green;">APROBADO</span>';
                    break;
                default:
                    //code...
                    break;
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE); //Convertir a json la data
        die();
    }

    public function listar_autorizar_bitacora_mantenimiento() //Listar Registros en Tabla
    {
        $data = $this->model->getAutorizar_bitacora_mantenimiento(); //Obtener todos los registros para la tabla de bitacora mantenimiento
        for ($i = 0; $i < count($data); $i++) { //Form para evaluar cada uno de los registros

            switch ($data[$i]['estatus']) {
                case 'FINALIZADO':
                    $data[$i]['estatus'] = '<span style="color: black;">FINALIZADO</span>';
                    break;
                case 'RECHAZADO':
                    $data[$i]['estatus'] = '<span style="color: red;">RECHAZADO</span>';
                    break;
                default:
                    //code...
                    break;
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE); //Convertir a json la data
        die();
    }

    public function aprobar_solicitud_operacion() //Aprobar solicitud operacion
    {

        $id = $_POST['id']; //Obtenemo el id que resivimos del FormData

        $data = $this->model->autorizar_operacion($id); //Mandamos a llamar al metodo autorizar del modelo

        if ($data == 1) {
            $msg = "si";
        } else {
            $msg = "Error";
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE); //Mostrar mensaje por medio de la consola con Ñ incluida(UNICODE)
        die();
    }

    public function rechazar_solicitud_operacion()
    {
        $id = $_POST['id']; //Guardamos el id del Registro
        $lts_actual = $_POST['lts_actual']; //Guardamos la fecha actual
        $f_inicial = $_POST['fecha_inicial']; //Guardamos la fecha inicial

        $data = $this->model->rechazar_operacion($id, $lts_actual, $f_inicial); //Mandamos a llamar a la funcion en el modelo

        if($data == 1){ //Evaluamos la respuesta retornada
            $msg = "si";
        }else{
            $msg = 'Error';
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE); //Mostrar mensaje por medio de la consola con Ñ incluida(UNICODE)
        die();
    }

    public function aprobar_solicitud_mantenimiento() //Aprobar solicitud operacion
    {

        $id = $_POST['id']; //Obtenemo el id que resivimos del FormData

        $data = $this->model->autorizar_mantenimiento($id); //Mandamos a llamar al metodo autorizar del modelo

        if ($data == 1) {
            $msg = "si";
        } else {
            $msg = "Error";
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE); //Mostrar mensaje por medio de la consola con Ñ incluida(UNICODE)
        die();
    }

    public function rechazar_solicitud_mantenimiento()
    {
        $id = $_POST['id']; //Guardamos el id del Registro
        $lts_actual = $_POST['lts_actual']; //Guardamos la fecha actual
        $f_inicial = $_POST['fecha_inicial']; //Guardamos la fecha inicial
        
        $data = $this->model->rechazar_mantenimiento($id, $lts_actual, $f_inicial); //Mandamos a llamar a la funcion en el modelo

        if($data == 1){ //Evaluamos la respuesta retornada
            $msg = "si";
        }else{
            $msg = 'Error';
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE); //Mostrar mensaje por medio de la consola con Ñ incluida(UNICODE)
        die();
    }
}
