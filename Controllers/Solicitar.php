<?php

require_once("Assets/Mailer/src/Exception.php");
require_once("Assets/Mailer/src/PHPMailer.php");
require_once("Assets/Mailer/src/SMTP.php");

class Solicitar extends Controller //heredamos controller
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

        $this->views->getView($this, "index"); //Cargamois la vista de Usuarios
    }

    //***************************************************** SECCION TABLAS ****************************************************************/
    //*************************************************************************************************************************************/
    public function listar_solicitar() //Listar Plantas en Tabla
    {
        $data = $this->model->getSolicitar(); //Obtener todos los registros para la tabla de Plantas Solicitar
        for ($i = 0; $i < count($data); $i++) { //Form para evaluar cada uno de los registros

            switch ($data[$i]['estatus']) {
                case 'DISPONIBLE':
                    $data[$i]['acciones'] = '<div>
                    <button type="button" class="btn btn-primary btn-sm" onclick="frmOperacion(\'' . $data[$i]['id'] . '\',\'' . $data[$i]['estatus'] . '\');" title="Operacion""><i class="fa-solid fa-angles-up"></i></button>
                    <button type="button" class="btn btn-info btn-sm" onclick="frmMantenimiento(\'' . $data[$i]['id'] . '\',\'' . $data[$i]['estatus'] . '\');" title="Mantenimiento""><i class="fa-solid fa-screwdriver-wrench"></i></button>
                    </div>'; //Añadimos los button a cada uno de los registros 
                    $data[$i]['estatus'] = '<span style="color: green;">DISPONIBLE</span>';
                    break;
                case 'OPERANDO':
                    $data[$i]['acciones'] = '<div>
                        <button type="button" class="btn btn-primary btn-sm" disabled title="Operacion""><i class="fa-solid fa-angles-up"></i></button>
                        <button type="button" class="btn btn-info btn-sm" disabled title="Mantenimiento""><i class="fa-solid fa-screwdriver-wrench"></i></button>
                        </div>'; //Añadimos los button a cada uno de los registros 
                    $data[$i]['estatus'] = '<span style="color: #AD4509;">OPERANDO</span>';
                    break;
                case 'MANTENIMIENTO':
                    $data[$i]['acciones'] = '<div>
                        <button type="button" class="btn btn-primary btn-sm"  disabled title="Operacion""><i class="fa-solid fa-angles-up"></i></button>
                        <button type="button" class="btn btn-info btn-sm"  disabled title="Mantenimiento""><i class="fa-solid fa-screwdriver-wrench"></i></button>
                        </div>'; //Añadimos los button a cada uno de los registros 
                    $data[$i]['estatus'] = '<span style="color: blue;">MANTENIMIENTO</span>';
                    break;
                default:
                    # code...
                    break;
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE); //Convertir a json la data
        die();
    }
    public function listar_bitacora_operacion() //Listar Operacion Bitacora en Tabla
    {
        $data = $this->model->getSolicitar_bitacora_operacion(); //Obtener todos los registros para la tabla de Bitacora Operacion
        for ($i = 0; $i < count($data); $i++) { //Form para evaluar cada uno de los registros

            switch ($data[$i]['estatus']) {
                case 'NUEVO':
                    $data[$i]['acciones'] = '<div>
                        <button type="button" class="btn btn-primary btn-sm"  disabled title="Entregar""><i class="fa-solid fa-inbox"></i></button>
                        </div>'; //Añadimos los button a cada uno de los registros 
                    $data[$i]['estatus'] = '<span style="color: blue;">NUEVO</span>';
                    break;
                case 'APROBADO':
                    $data[$i]['acciones'] = '<div>
                        <button type="button" class="btn btn-primary btn-sm" onclick="frmEntregarOperacion(\'' . $data[$i]['id'] . '\',\'' . $data[$i]['estatus'] . '\');" title="Entregar""><i class="fa-solid fa-inbox"></i></button>
                        </div>'; //Añadimos los button a cada uno de los registros 
                    $data[$i]['estatus'] = '<span style="color: green;">APROBADO</span>';
                    break;
                case 'RECHAZADO':
                    $data[$i]['acciones'] = '<div>
                        <button type="button" class="btn btn-primary btn-sm" disabled title="Entregar""><i class="fa-solid fa-inbox"></i></button>                        
                        </div>'; //Añadimos los button a cada uno de los registros 
                    $data[$i]['estatus'] = '<span style="color: red;">RECHAZADO</span>';
                    break;
                case 'FINALIZADO':
                    $data[$i]['acciones'] = '<div>
                        <button type="button" class="btn btn-primary btn-sm" disabled title="Entregar""><i class="fa-solid fa-inbox"></i></button>
                        </div>'; //Añadimos los button a cada uno de los registros 
                    $data[$i]['estatus'] = '<span style="color: black;">FINALIZADO</span>';
                    break;
                default:
                    //code...
                    break;
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE); //Convertir a json la data
        die();
    }

    public function listar_bitacora_mantenimiento() //Listar Mantenimient Bitacora en Tabla
    {
        $data = $this->model->getSolicitar_bitacora_mantenimiento(); //Obtener todos los registros para la tabla de Bitacora Mantenimiento
        for ($i = 0; $i < count($data); $i++) { //Form para evaluar cada uno de los registros

            switch ($data[$i]['estatus']) {
                case 'NUEVO':
                    $data[$i]['acciones'] = '<div>
                        <button type="button" class="btn btn-primary btn-sm"  disabled title="Entregar""><i class="fa-solid fa-inbox"></i></button>
                        </div>'; //Añadimos los button a cada uno de los registros 
                    $data[$i]['estatus'] = '<span style="color: blue;">NUEVO</span>';
                    break;
                case 'APROBADO':
                    $data[$i]['acciones'] = '<div>
                        <button type="button" class="btn btn-primary btn-sm" onclick="frmEntregarMantenimiento(\'' . $data[$i]['id'] . '\',\'' . $data[$i]['estatus'] . '\');" title="Finalizar""><i class="fa-solid fa-inbox"></i></button>
                        </div>'; //Añadimos los button a cada uno de los registros 
                    $data[$i]['estatus'] = '<span style="color: green;">APROBADO</span>';
                    break;
                case 'RECHAZADO':
                    $data[$i]['acciones'] = '<div>
                        <button type="button" class="btn btn-primary btn-sm" disabled title="Entregar""><i class="fa-solid fa-inbox"></i></button>
                        </div>'; //Añadimos los button a cada uno de los registros 
                    $data[$i]['estatus'] = '<span style="color: red;">RECHAZADO</span>';
                    break;
                case 'FINALIZADO':
                    $data[$i]['acciones'] = '<div>
                        <button type="button" class="btn btn-primary btn-sm"  disabled title="Entregar""><i class="fa-solid fa-inbox"></i></button>
                        </div>'; //Añadimos los button a cada uno de los registros 
                    $data[$i]['estatus'] = '<span style="color: black;">FINALIZADO</span>';
                    break;
                default:
                    //code...
                    break;
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE); //Convertir a json la data
        die();
    }
    //*************************************************************************************************************************************/
    //***************************************************** SECCION TABLAS ****************************************************************/



    //*************************************************************************************************************************************/
    //*************************************************** FUNCIONES SOLICITAR *************************************************************/
    public function solicitar_operacion() //Creamos funcion resistrar por el metodo POST
    {
        $id_planta = $_POST['id_operacion']; //Guardamos datos del ID en el caso de que sea actualizacion
        $id_personal_responsable = $_POST['id_responsable_operacion']; //Guardamos el id del responsable
        $lts_actual_operacion = $_POST['lts_actual_operacion']; //Guardamos datos
        $sitio_operacion = $_POST['sitio_operacion']; //Guardamos datos
        $motivo_operacion = $_POST['motivo_operacion']; //Guardamos datos
        $f_inicio_operacionca = $_POST['f_inicio_operacion']; //Guardamos datos
        $id_personal_solicitante = $_SESSION['id_user_plantas_fijas'];
        $fechaActual = date('Y-m-d'); //Obtenemos Fecha Actual para guardar el dia del registro de la solicitud
        $estatus = "OPERANDO"; //generamos variable del estadus

        $f_inicio_operacionca = $_POST['f_inicio_operacion']; //Guardamos datos
        $hora_inicio_operacionca = $_POST['hora_inicio_operacion']; //Guardamos datos

        $combinedDT = date('Y-m-d H:i:s', strtotime("$f_inicio_operacionca $hora_inicio_operacionca")); //Unimos la fecha con la hora de el inicio

        $rol_plantas_fijas = $_SESSION['rol_plantas_fijas']; //Obtener rol del usuario en la session
        $estatus_solicitud = ($rol_plantas_fijas == 'jefe') ? 'APROBADO' : 'NUEVO'; // Determinamos el estadus de la solicitud segun los pribilegios del usuario
        if (
            empty($sitio_operacion) | empty($motivo_operacion) | empty($f_inicio_operacionca)
        ) { //Evaluamos que los campos este, se tiene doble validacion de campos obligatorios tanto en el backend como en el frontend
            $msg = "Todos los campos son obligatorios";
        } else {
            $data = $this->model->registrarSolicitudOperacion($id_planta, $sitio_operacion, $motivo_operacion, $id_personal_responsable, $combinedDT, $fechaActual, $lts_actual_operacion, $id_personal_solicitante, $estatus_solicitud); // Mandmaos a llamar al modelo y le mandamos datos Si es un nuevo planta
            if ($data == "ok") { //Evaluamos si la peticion se ejecuto correctamente
                //Mandamos a cambiar el estadus de la planta a OPERANDO
                $data_estatus = $this->model->accionEstatusPlanta($estatus, $id_planta); // Mandmaos a llamar al modelo y le mandamos datos Si es un nuevo planta
                if ($data_estatus == 1) {
                    $msg = "si";
                } else {
                    $msg = "Solicitud hecha, estatus planta no actualizado";
                }
            } else {
                $msg = "Error al Ingresar Solicitud"; //Error
            }
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE); //Mandamos la respuesta
        die();
    }

    public function solicitar_mantenimiento() //Creamos funcion resistrar por el metodo POST
    {
        $id_planta = $_POST['id_mantenimiento']; //Guardamos datos del ID en el caso de que sea actualizacion
        $id_personal_responsable = $_POST['id_responsable_mantenimiento']; //guardamos id del responsable
        $lts_actual_mantenimiento = $_POST['lts_actual_mantenimiento']; //Guardamos datos
        $tipo_mantenimiento = $_POST['tipo_mantenimiento']; //Guardamos datos
        $motivo_mantenimiento = $_POST['motivo_mantenimiento']; //Guardamos datos
        $id_personal_solicitante = $_SESSION['id_user_plantas_fijas'];
        $fechaActual = date('Y-m-d'); //Obtenemos Fecha Actual para guardar el dia del registro de la solicitud
        $estatus = "MANTENIMIENTO"; //generamos variable del estadus

        $f_inicio_mantenimiento = $_POST['f_inicio_mantenimiento']; //Guardamos datos
        $hora_inicio_mantenimiento = $_POST['hora_inicio_mantenimiento']; //Guardamos datos

        $combinedDT = date('Y-m-d H:i:s', strtotime("$f_inicio_mantenimiento $hora_inicio_mantenimiento")); //Unimos la fecha con la hora de el inic

        $rol_plantas_fijas = $_SESSION['rol_plantas_fijas'];
        $estatus_solicitud = ($rol_plantas_fijas == 'jefe') ? 'APROBADO' : 'NUEVO'; // Determinamos el estadus de la solicitud segun los pribilegios del usuario

        if (
            empty($tipo_mantenimiento) | empty($motivo_mantenimiento) | empty($f_inicio_mantenimiento)
        ) { //Evaluamos que los campos este, se tiene doble validacion de campos Obligatorios tanto en el backend como en el frontend
            $msg = "Todos los campos son obligatorios";
        } else {
            $data = $this->model->registrarSolicitudMantenimiento($id_planta, $tipo_mantenimiento, $motivo_mantenimiento, $id_personal_responsable, $combinedDT, $fechaActual, $lts_actual_mantenimiento, $id_personal_solicitante, $estatus_solicitud); // Mandmaos a llamar al modelo y le mandamos datos Si es un nuevo planta

            if ($data == "ok") { //Evaluamos si la peticion se ejecuto correctamente
                //Mandamos a cambiar el estadus de la planta a MANTENIMIENTO
                $data_estatus = $this->model->accionEstatusPlanta($estatus, $id_planta); // Mandmaos a llamar al modelo y le mandamos datos Si es un nuevo registro
                if ($data_estatus == 1) {
                    $msg = "si";
                } else {
                    $msg = "Solicitud hecha, estatus planta no actualizado";
                }

            } else {
                $msg = "Error al Ingresar Solicitud"; //Error
            }
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE); //Mandamos la respuesta
        die();
    }
    public function GetInfo(int $id) //La funcion  recibe el id que es el numero de Planta ya que esa es la PRIMARY KEY
    {
        $data = $this->model->getInfo($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function GetInfoBitacoraOperacion(int $id) //La funcion  recibe el id que es el numero de Planta ya que esa es la PRIMARY KEY
    {
        $data = $this->model->getInfoBitacoraOperacion($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function GetInfoBitacoraMantenimiento(int $id) //La funcion  recibe el id que es el numero de Planta ya que esa es la PRIMARY KEY
    {
        $data = $this->model->getInfoBitacoraMantenimiento($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function finalizar_operacion() //Creamos funcion Finalizar Operacion por el metodo POST
    {
        $id_finalizar_planta = $_POST['id_finalizar_planta']; //Guardamos datos del ID en el caso de que sea actualizacion
        $id_finalizar_operacion = $_POST['id_finalizar_operacion']; //Guardamos datos del ID en el caso de que sea actualizacion
        $lts_final_f_operacion = $_POST['lts_final_f_operacion']; //Guardamos datos
        $cargo_combustible_f_operacion = $_POST['cargo_combustible_f_operacion']; //Guardamos datos
        $importe_combustible_f_operacion = $_POST['importe_combustible_f_operacion']; //Guardamos datos
        $precio_combustible_f_operacion = $_POST['precio_combustible_f_operacion']; //Guardamos datos
        $comentarios_f_operacion = $_POST['comentarios_f_operacion']; //Guardamos datos
        $tiempo_operando_operacion = $_POST['tiempo_operando_operacion']; //Guardamos datos
        $f_inicio_f_operacion = $_POST['f_inicio_f_operacion']; //Guardamos datos

        $f_final_f_operacion = $_POST['f_final_f_operacion']; //Guardamos el id del responsable
        $hora_final_f_operacion = $_POST['hora_final_f_operacion']; //Guardamos datos
        $combinedDT = date('Y-m-d H:i:s', strtotime("$f_final_f_operacion $hora_final_f_operacion")); //Unimos la fecha con la hora de el inicio

        $hourdiff = round((strtotime($combinedDT) - strtotime($f_inicio_f_operacion))/3600);        
        $horasOperando = $tiempo_operando_operacion + $hourdiff;

        $gasto_carga_combustible = ($importe_combustible_f_operacion * $precio_combustible_f_operacion);

        if ($hourdiff >= 0) {
            if (
                empty($comentarios_f_operacion) | empty($f_final_f_operacion)  | empty($hora_final_f_operacion)
            ) { //Evaluamos que los campos este, se tiene doble validacion de campos obligatorios tanto en el backend como en el frontend
                $msg = "Faltan Campos Oblogatorios";
            } else {
                $data = $this->model->finalizarOperacion($id_finalizar_operacion, $lts_final_f_operacion, $cargo_combustible_f_operacion, $importe_combustible_f_operacion, 
                $combinedDT, $precio_combustible_f_operacion, $comentarios_f_operacion, $gasto_carga_combustible); // Mandmaos a llamar al modelo y le mandamos datos Si es un nuevo planta
                if ($data == 1) { //Evaluamos si la peticion se ejecuto correctamente                  
                    $data_planta_finalizar = $this->model->accionPlantaFinalizarOperacion($id_finalizar_planta, $lts_final_f_operacion, $horasOperando); // Mandmaos a llamar al modelo y le mandamos datos Si es un nuevo planta
                    if ($data_planta_finalizar == 1) { //Evaluamos si la peticion se ejecuto correctamente  
                        $msg = "si";   
                    } else {
                        $msg = "Error tabla Plantas "; //Error
                    }
                } else {
                    $msg = "Error al Finalizar"; //Error
                }
            }   
        }else {
            $msg = "Fecha final no valida"; //Error
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE); //Mandamos la respuesta
        die();
    }

    public function finalizar_mantenimiento() //Creamos funcion resistrar por el metodo POST
    {
        $id_finalizar_mantenimiento = $_POST['id_finalizar_mantenimiento']; //Guardamos datos del ID en el caso de que sea actualizacion
        $lts_final_f_mantenimiento = $_POST['lts_final_f_mantenimiento']; //Guardamos datos
        $cargo_combustible_f_mantenimiento = $_POST['cargo_combustible_f_mantenimiento']; //Guardamos datos
        $importe_combustible_f_mantenimiento = $_POST['importe_combustible_f_mantenimiento']; //Guardamos datos
        $precio_combustible_f_mantenimiento = $_POST['precio_combustible_f_mantenimiento']; //Guardamos datos
        $cargo_correctivo_f_mantenimiento = $_POST['cargo_correctivo_f_mantenimiento']; //Guardamos datos
        $descripcion_correctivo_f_mantenimiento = $_POST['descripcion_correctivo_f_mantenimiento']; //Guardamos datos
        $importe_correctivo_f_mantenimiento = $_POST['importe_correctivo_f_mantenimiento']; //Guardamos datos
        
        $cargo_preventivo_f_mantenimiento = $_POST['cargo_preventivo_f_mantenimiento']; //Guardamos datos
        $descripcion_preventivo_f_mantenimiento = $_POST['descripcion_preventivo_f_mantenimiento']; //Guardamos datos
        $importe_preventivo_f_mantenimiento = $_POST['importe_preventivo_f_mantenimiento']; //Guardamos datos

        $comentarios_f_mantenimiento = $_POST['comentarios_f_mantenimiento']; //Guardamos datos
        $tipo_mantenimiento_finalizar = $_POST['tipo_mantenimiento_finalizar']; //Guardamos datos
        $f_final_f_mantenimiento = $_POST['f_final_f_mantenimiento']; //Guardamos la fecha de final del mantenimineto
        $hora_final_f_mantenimiento = $_POST['hora_final_f_mantenimiento']; //Guardamos la hora final del mantenimiento
        $combinedDT = date('Y-m-d H:i:s', strtotime("$f_final_f_mantenimiento $hora_final_f_mantenimiento")); //Unimos la fecha con la hora de el inicio
        
        $id_planta_finalizar_mantenimiento = $_POST['id_planta_finalizar_mantenimiento']; //Guardamos datos DATOS DE LA PLANTS
        $f_prox_mantenimiento_f_mantenimiento = $_POST['f_prox_mantenimiento_f_mantenimiento']; //Guardamos datos DATOS DE LA PLANTS

        $gasto_carga_combustible = ($importe_combustible_f_mantenimiento * $precio_combustible_f_mantenimiento);

        if (
            empty($id_finalizar_mantenimiento) | empty($lts_final_f_mantenimiento) | empty($descripcion_correctivo_f_mantenimiento) | empty($comentarios_f_mantenimiento) | empty($f_final_f_mantenimiento) 
        ) { //Evaluamos que los campos este, se tiene doble validacion de campos obligatorios tanto en el backend como en el frontend
            $msg = "Faltan Campos Oblogatorios";
        } else {
            $data = $this->model->finalizarMantenimiento($id_finalizar_mantenimiento, $lts_final_f_mantenimiento, $cargo_combustible_f_mantenimiento, $importe_combustible_f_mantenimiento, 
            $combinedDT, $precio_combustible_f_mantenimiento, $cargo_correctivo_f_mantenimiento, $descripcion_correctivo_f_mantenimiento, $importe_correctivo_f_mantenimiento, 
            $cargo_preventivo_f_mantenimiento, $descripcion_preventivo_f_mantenimiento, $importe_preventivo_f_mantenimiento , $comentarios_f_mantenimiento, $gasto_carga_combustible); // Mandmaos a llamar al modelo y le mandamos datos Si es un nuevo planta
            if ($data == 1) { //Evaluamos si la peticion se ejecuto correctamente  
                $data_actualizar_planta = $this->model->accionPlantaFinalizarMantenimiento($id_planta_finalizar_mantenimiento, $lts_final_f_mantenimiento, $tipo_mantenimiento_finalizar,
                $f_prox_mantenimiento_f_mantenimiento); // Mandmaos a llamar al modelo y le mandamos datos Si es un nuevo registro
                if ($data_actualizar_planta == 1) {
                    $msg = "si";
                } else {
                    $msg = "Erro tabla, Plantas";
                }
            } else {
                $msg = "Error al Finalizar"; //Error
            }
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE); //Mandamos la respuesta
        die();
    }

    //*************************************************** FUNCIONES SOLICITAR *************************************************************/
    //*************************************************************************************************************************************/
}


