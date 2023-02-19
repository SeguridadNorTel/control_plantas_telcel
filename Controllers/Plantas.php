<?php
class Plantas extends Controller //heredamos controller
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

        if ($_SESSION['rol_plantas_fijas'] == 'radiobases' || $_SESSION['rol_plantas_fijas'] == 'jefe') { //Evaluamos si el usuairo ya esta autenticado
            header("location: " . base_url . 'Solicitar');
        }
        
        $data['localidades_lista'] = $this->model->getLocalidades(); //Guardar Lista Localidades
        $data['gerencias_lista'] = $this->model->getGerencia(); //Guardar Lista Gerencias
        $data['departamentos_lista'] = $this->model->getDepartamentos(); //Guardar Lista Departamentos
        $data['admin_lista'] = $this->model->getPersonalJefe(); //Guardar Lista Usuarios Admin
        $data['combustible'] = $this->model->getCombustibles(); //Guardar Lista Usuarios Admin

        $this->views->getView($this, "index", $data); //Cargamois la vista de Usuarios
    }

    public function listar() //Listar Usuarios en Tabla
    {
        $data = $this->model->getPlantas(); //Obtener todos los usuarios para la tabla de Usuarios Data table
        for ($i = 0; $i < count($data); $i++) { //Form para evaluar cada uno de los registros


            $fechaActual = date('Y-m-d'); //Obtenemos Fecha Actual
            $fechaUsuarioPsw = $data[$i]['f_mantenimiento']; //Guardamos la fecha en que el usuario cambio por ultima vez su password

            $date = strtotime($fechaActual); //Convertimos la fecha en formato Unix
            $your_date = strtotime($fechaUsuarioPsw); //Convertimos la fecha en formato Unix
            $datediff = $date - $your_date; //Sacamos la diferencia entre las dos fechas

            $dias = $datediff / (60 * 60 * 24); //Obtenemos los dias

            switch ($data[$i]['tipo']) {
                case 'FIJA':
                    if ($dias <= 7) {
                        $data[$i]['true_mantenimiento'] = true;
                    }
                    break;

                default:
                    if ($data[$i]['t_operando'] >= 17 ) {
                        $data[$i]['true_mantenimiento'] = true;
                    }
                    break;
            }

            switch ($data[$i]['estatus']) {
                case 'DISPONIBLE':
                    $data[$i]['acciones'] = '<div>
                        <button type="button" class="btn btn-primary btn-sm" onclick="btnEditarPlanta(' . $data[$i]['id'] . ');" title="Editar""><i class="fas fa-edit"></i></button>
                        <button type="button" class="btn btn-danger btn-sm" onclick="btnEliminarPlanta(\'' . $data[$i]['id'] . '\',\'' . $data[$i]['estatus'] . '\');" title="Eliminar""><i class="fas fa-trash-alt"></i></button>
                        </div>'; //Añadimos los button a cada uno de los registros 
                    $data[$i]['estatus'] = '<span style="color: green;">DISPONIBLE</span>';
                    break;
                case 'NO DISPONIBLE':
                    $data[$i]['acciones'] = '<div>
                        <button type="button" class="btn btn-info btn-sm" onclick="btnReingresarPlanta(\'' . $data[$i]['id'] . '\',\'' . $data[$i]['estatus'] . '\');" title="Reingresar""><i class="fas fa-sign-in-alt"></i></i></button>
                        </div>'; //Añadimos los button a cada uno de los registros 
                    $data[$i]['estatus'] = '<span style="color: red;">NO DISPONIBLE</span>';
                    break;
                case 'OPERANDO':
                    $data[$i]['acciones'] = '<div>
                        <button type="button" class="btn btn-primary btn-sm" onclick="btnEditarPlanta(' . $data[$i]['id'] . ');" title="Editar""><i class="fas fa-edit"></i></button>
                        </div>'; //Añadimos los button a cada uno de los registros 
                    $data[$i]['estatus'] = '<span style="color: #AD4509;">OPERANDO</span>';
                    break;
                case 'MANTENIMIENTO':
                    $data[$i]['acciones'] = '<div>
                        <button type="button" class="btn btn-primary btn-sm" onclick="btnEditarPlanta(' . $data[$i]['id'] . ');" title="Editar""><i class="fas fa-edit"></i></button>
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

    public function registrar() //Creamos funcion resistrar por el metodo POST
    {            
        $id = $_POST['id']; //Guardamos datos del ID en el caso de que sea actualizacion

        $no_economico = $_POST['no_economico']; //Guardamos datos
        $tipo = $_POST['tipo']; //Guardamos datos
        $marca = $_POST['marca']; //Guardamos datos
        $modelo = $_POST['modelo']; //Guardamos datos
        $no_serie = $_POST['no_serie']; //Guardamos datos
        $departamento_id = $_POST['departamento_id']; //Guardamos datos
        $localidad_id = $_POST['localidad_id']; //Guardamos datos
        $gerencia_id = $_POST['gerencia_id']; //Guardamos datos
        $responsable_id = $_POST['responsable_id']; //Guardamos datos
        $capacidad_kw = $_POST['capacidad_kw']; //Guardamos datos
        $capacidad_lts = $_POST['capacidad_lts']; //Guardamos datos
        $lts_actual = $_POST['lts_actual']; //Guardamos datos
        $f_mantenimiento = $_POST['f_mantenimiento']; //Guardamos datos
        $combustible_id = $_POST['combustible_id']; //Guardamos datos
        $horometro = $_POST['horometro']; //Guardamos datos
        $comentarios = empty($_POST['comentarios']) ?  'NA' : $_POST['comentarios']; //Evaluamos si el la planta tiene nombre del sitio si no evaluamos directamente a NA
        $nombre_sitio = empty($_POST['nombre_sitio']) ?  'NA' : $_POST['nombre_sitio']; //Evaluamos si el la planta tiene nombre del sitio si no evaluamos directamente a NA
        $placas = empty($_POST['placas']) ?  'NA'  : $_POST['placas']; //Evaluamos si la planta tiene placas si no evaluamos directamente a NA
        $ip = empty($_POST['ip']) ?  'NA'  : $_POST['ip']; //Evaluamos si la planta tiene placas si no evaluamos directamente a NA

        $data_actual = $this->model->editarPlanta($id); //Obtenemos la informacion actuali de la planta
        $horometro = ($_SESSION['rol_plantas_fijas'] != 'developer') ?  $data_actual['horometro'] : $_POST['horometro']; //Evaluamos privileguis del usuariocomentarios = empty($_POST['comentarios']) ?  'NA' : $_POST['comentarios'];

        if ($data_actual['horometro'] > $horometro) { //Evaluamos si el horometro es menor al ya existente
            $msg = "Horometro Menos";
        }else{
            if ($departamento_id != $_SESSION['id_departamento_plantas_fijas'] && $_SESSION['rol_plantas_fijas'] == 'jefe') {
                $msg = "Corresponde a otro Departamento";
            } else {
                if (
                    empty($no_economico) | empty($tipo) | empty($marca) | empty($modelo) | empty($no_serie) | empty($departamento_id) |
                    empty($localidad_id) | empty($gerencia_id) | empty($responsable_id) | empty($capacidad_kw) | empty($capacidad_lts)
                    | empty($f_mantenimiento)
                ) { //Evaluamos que los campos este, se tiene doble validacion de campos obliharotios tanto en el backend como en el frontend
                    $msg = "Todos los campos son obligatorios";
                } else {
                    if ($id == "") {

                        $data = $this->model->registrarPlanta($no_economico, $tipo, $marca, $modelo, $no_serie, $departamento_id, $localidad_id, $gerencia_id, $responsable_id, $capacidad_kw,
                            $capacidad_lts, $lts_actual, $f_mantenimiento, $comentarios, $horometro, $nombre_sitio, $ip, $placas, $combustible_id); // Mandmaos a llamar al modelo y le mandamos datos Si es un nuevo planta

                        if ($data == "ok") { //Evaluamos si la peticion se ejecuto correctamente
                            $msg = "si";
                        } else if ($data == "existe") {
                            $msg = "Planta ya Registrada"; //Mandamos mensaje de planta registrado
                        } else {
                            $msg = "Error al Ingresar Planta"; //Error
                        }
                    } else {
                        $data = $this->model->modificarPlanta($no_economico, $tipo, $marca, $modelo, $no_serie, $departamento_id, $localidad_id, $gerencia_id, $responsable_id, $capacidad_kw,
                            $capacidad_lts, $lts_actual, $f_mantenimiento, $comentarios, $horometro, $nombre_sitio, $ip, $placas, $combustible_id, $id); // Mandmaos a llamar al modelo y le mandamos datos si se va a actualizar Planta

                        if ($data == "modificado") { //Evaluamos si la peticion se ejecuto correctamente
                            $msg = "modificado"; //Mandamos mensaje de usuario modificado
                        } else {
                            $msg = "Error al Modificar Planta"; //Error
                        }
                    }
                }
            }
        }



        echo json_encode($msg, JSON_UNESCAPED_UNICODE); //Mandamos la respuesta
        die();
    }

    public function eliminar(int $id) //Funcion Eliminar Planta
    {
        $data = $this->model->accionPlanta(0, $id);

        if (
            $data == 1
        ) {
            $msg = "ok";
        } else {
            $msg = "Error al Eliminar Planta";
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function reingresar(int $id) //Funcion Reingresar Planta
    {
        $data = $this->model->accionPlanta(1, $id);

        if ($data == 1) {
            $msg = "ok";
        } else {
            $msg = "Error al Reingresar Planta";
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function editar(int $id) //La funcion  recibe el id que es el numero de Planta ya que esa es la PRIMARY KEY
    {
        $data = $this->model->editarPlanta($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
}
