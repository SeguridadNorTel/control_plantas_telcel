<?php
class GastoPorPlanta extends Controller //heredamos controller
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

        if ($_SESSION['rol_plantas_fijas'] != 'developer' && $_SESSION['rol_plantas_fijas'] != 'jefe') { //Evaluamos si el usuairo ya esta autenticado
            header("location: " . base_url . 'Plantas');
        }

        $data['departamentos_lista'] = $this->model->getDepartamentos(); //Guardar Lista Departamentos

        $this->views->getView($this, "index", $data); //Cargamois la vista de Autorizar
    }


    public function list_GPP() //Listar Registros en Tabla
    {
        $tipo = empty($_POST['tipo']) ?  0 : $_POST['tipo']; //Evaluamos si el la planta tiene nombre del sitio si no evaluamos directamente a NA
        $periodo = empty($_POST['periodo']) ?  0 : $_POST['periodo']; //Evaluamos si el la planta tiene nombre del sitio si no evaluamos directamente a NA
        $departamento = empty($_POST['departamento']) ?  0 : $_POST['departamento']; //Evaluamos si el la planta tiene nombre del sitio si no evaluamos directamente a NA
        $from = empty($_POST['desde']) ?  date("Y-m-d") : $_POST['desde']; //Evaluamos si el la planta tiene nombre del sitio si no evaluamos directamente a NA
        $to = empty($_POST['hasta']) ?  date("Y-m-d") : $_POST['hasta']; //Evaluamos si el la planta tiene nombre del sitio si no evaluamos directamente a NA

        $data = []; //Declaramos la variable del objeto a traer para los datos de la tabla

        switch ($tipo) {
            case 0: //Tipo Anual
                date_default_timezone_set("America/Mexico_City"); //Declaramos como fecha de mexico
                $ano_actual = date('Y'); //Obtenemos el Year en curso
                $ano_anterior = date('Y', strtotime('-1 year')); //Obtenemos el Year anterior

                $data = $this->model->getCRAnual($ano_actual, $ano_anterior, $periodo, $departamento); //Obtener todos los registros para la tabla de operacion
                break;
            case 1: //Tipo Mensual
                date_default_timezone_set("America/Mexico_City"); //Declaramos como la fecha de mexico
                $year_actual = date('Y'); //Obtenemos el Year en curso
                $mes_actual = date('m'); // Obtenemos el mes actual
                $mes_anterior = date('m', strtotime('-1 month')); // Obtenemos el mes anterior

                $fecha_mensual_actual = $year_actual . '-' . $mes_actual; // Generamos la fecha de busqueda del mes actual
                $fecha_mensual_anterior = $year_actual . '-' . $mes_anterior; // Obtenemos el mes anterior

                $data = $this->model->getCRMensual($fecha_mensual_actual, $fecha_mensual_anterior, $periodo, $departamento); //Obtener todos los registros para la tabla de operacion; //Obtener todos los registros para la tabla de operacion
                break;
            case 2: //Tipo Fecha
                $data = $this->model->getCRRangoFechas($from, $to, $departamento); //Obtener todos los registros para la tabla de operacion; //Obtener todos los registros para la tabla de operacion
                break;
            default:
                $data = []; //Mandamos un array vacio
                break;
        }

        $data_departamentos = $this->model->getDepartamentos(); //obtenemos los departamentos disponibles 
        
        for ($i = 0; $i < count($data); $i++) { //Form para evaluar cada uno de los registros

            $gasto_total = $data[$i]['gasto_combustible_total'] + $data[$i]['total_importe_preventivo'] + $data[$i]['total_importe_correctivo'];

            $data[$i]['departamento'] = '<strong><p>' . $data[$i]['departamento'] .'</p></strong>';
            $data[$i]['gasto_total'] = $gasto_total;
            
        }

        for ($i = 0; $i < count($data_departamentos); $i++) { //Quitamos los departamentos que se encuentran en el select de la consulta para la tabla de consumo regional
            for ($z = 0; $z < count($data); $z++) {
                if (($key = array_search($data[$z]['departamento'], $data_departamentos)) !== false) {
                    unset($data_departamentos[$key]);
                }
            }
        }

        echo json_encode($data, JSON_UNESCAPED_UNICODE); //Convertir a json la data
            die();
    }
    
}
