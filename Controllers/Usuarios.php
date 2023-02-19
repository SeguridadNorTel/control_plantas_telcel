<?php
class Usuarios extends Controller //heredamos controller
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
        
        $data['localidades_lista'] = $this->model->getLocalidades(); //Guardar Lista Localidades
        $data['gerencias_lista'] = $this->model->getGerencia(); //Guardar Lista Localidades
        $data['departamentos_lista'] = $this->model->getDepartamentos(); //Guardar Lista Localidades

        $this->views->getView($this, "index", $data); //Cargamois la vista de Usuarios
    }

    public function salir() //Funcion Salid e la aplicacion
    {
        //session_destroy(); Elimina todas las variables de la session incluyendo las demas aplicaciones
        unset($_SESSION['activo_plantas_fijas']);
        header("location: " . base_url);
    }
    public function validar() //validad LOGIN usuario
    {
        if (empty($_POST['usuario']) || empty($_POST['clave'])) { //conpruebas que los campos existan
            $msg = "Los campos estan vacios";
        } else {
            $usuario = $_POST['usuario']; //almacenas la variable usuario
            $clave = $_POST['clave']; //almacenas la variable clave

            $hash = hash("SHA256", $clave); //Crear passowrd Encriptada

            $data_user = $this->model->getUsuario($usuario); //almacenas la variable de los usuarios reistrados en la aplicacion

            if ($data_user) {

                $_SESSION['rol_plantas_fijas'] = $data_user['rol']; //Guardamos el nombre del rol del usuario en la aplicacion
                $_SESSION['id_rol_plantas_fijas'] = $data_user['id_rol']; //Guardmaos le id del rol del usuario en la aplicacion

                $data_info = $this->model->getUsuario_info($usuario, $hash); //almacenas la variable all data Usuarios
                if ($data_info) {
                    if (
                        $data_info['activo'] == 1 //Evaluar si el usuario esta Activo en las aplicaciones
                    ) {
                        $fechaActual = date('Y-m-d'); //Obtenemos Fecha Actual
                        $fechaUsuarioPsw = $data_info['fecha_password']; //Guardamos la fecha en que el usuario cambio por ultima vez su password

                        $date = strtotime($fechaActual); //Convertimos la fecha en formato Unix
                        $your_date = strtotime($fechaUsuarioPsw); //Convertimos la fecha en formato Unix
                        $datediff = $date - $your_date; //Sacamos la diferencia entre las dos fechas

                        $dias = $datediff / (60 * 60 * 24); //Obtenemos los dias

                        if ($dias > 60) {
                            $msg = "cambio"; // Mensaje confirmando el login del usuario    
                        } else {
                            $_SESSION['id_user_plantas_fijas'] = $data_info['id']; //guardas informacion en la session
                            $_SESSION['num_empleado_plantas_fijas'] = $data_info['num_empleado']; //guardas informacion en la session
                            $_SESSION['nombre_plantas_fijas'] = $data_info['nombre']; //guardas informacion en la session
                            $_SESSION['region_plantas_fijas'] = $data_info['region']; //guardas informacion en la session
                            $_SESSION['puesto_plantas_fijas'] = $data_info['puesto']; //guardas informacion en la session
                            $_SESSION['mail_plantas_fijas'] = $data_info['mail']; //guardas informacion en la session
                            $_SESSION['telefono_plantas_fijas'] = $data_info['telefono']; //guardas informacion en la session
                            $_SESSION['localidad_plantas_fijas'] = $data_info['localidad']; //guardas informacion en la session
                            $_SESSION['id_localidad_plantas_fijas'] = $data_info['id_localidad']; //guardas informacion en la session
                            $_SESSION['gerencia_plantas_fijas'] = $data_info['gerencia']; //guardas informacion en la session
                            $_SESSION['departamento_plantas_fijas'] = $data_info['departamento']; //guardas informacion en la session
                            $_SESSION['id_departamento_plantas_fijas'] = $data_info['id_departamento']; //guardas informacion en la session
                            $_SESSION['num_emp_jefe_plantas_fijas'] = $data_info['num_emp_jefe']; //guardas informacion en la session
                            $_SESSION['activo_plantas_fijas'] = true; //guardas informacion en la session
                            $_SESSION['dias'] = $dias; //guardas informacion en la session

                            $msg = "ok"; // Mensaje confirmando el login del usuario
                        }

                    } else {
                        $msg = "Usuario Bloqueado"; // Mensaje usuario bloqueado 
                    }
                } else {
                    $msg = "Usuario o contraseña Incorrecta"; //Mensaje los datos del usuario son incorrectos
                }
            } else {
                $msg = "Usuario no registrado en la aplicacion"; //EL usuario no esta registrado en la aplicacion
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE); //Mostrar mensaje por medio de la consola con Ñ incluida(UNICODE)
        die();
    }

    public function obtener_usuario_logueado() //Creamos funcion resistrar por el metodo POST
    {
        $usuario = $_SESSION['nombre_plantas_fijas'];               
        echo json_encode($usuario, JSON_UNESCAPED_UNICODE); //Mandamos la respuesta
        die();
    }
}
