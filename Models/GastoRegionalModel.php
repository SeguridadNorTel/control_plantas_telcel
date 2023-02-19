<?php
class GastoRegionalModel extends Query //Heredamos la clase Query
{
    private $id, $fecha_mensual_actual, $fecha_mensual_anterior, $ano_actual, $ano_anterior, $periodo, $from, $to; //Variables para registro del usuario

    public function __construct()
    {
        parent::__construct(); //Obtenemos el contructor de Query para el metodo
    }

    /*==========================================================================================================================================================*/
    /*==========================================================================================================================================================*/
    /*====================================================================== CATALOGOS =========================================================================*/

    
    /*====================================================================== CATALOGOS =========================================================================*
    /*==========================================================================================================================================================*/
    /*==========================================================================================================================================================*/

    /*==========================================================================================================================================================*/
    /*==========================================================================================================================================================*/
    /*====================================================================== FUNCIONES =========================================================================*/
    
    public function getCRAnual(string $ano_actual, string $ano_anterior, int $periodo) //Obtener Lista de todas los registros de bitacora operacion para autorizar
    {
        $this->periodo = $periodo; //Guardamos la variable
        $this->ano_actual = '%'.$ano_actual.'%'; //Guardamos la variable
        $this->ano_anterior = '%'.$ano_anterior.'%'; //Guardamos la variable
        
        if ($periodo == 0) {
            $sql = "SELECT b.id_planta, b.f_inicio, b.f_final, SUM(b.importe_combustible) AS importe_total_combustible, TRUNCATE(SUM(b.gasto_carga_combustible), 2) AS 
            gasto_combustible_total, TRUNCATE(SUM(b.importe_correctivo), 2) AS total_importe_correctivo, TRUNCATE(SUM(b.importe_preventivo),2) AS total_importe_preventivo, 
            sum(if(b.tipo_mantenimiento = 'PREVENTIVO', 1, 0)) AS MMTOS_PREVENTIVO, sum(if(b.tipo_mantenimiento = 'CORRECTIVO', 1, 0)) AS MMTOS_CORRECTIVO, 
            p.departamento_id AS id_departamento, d.departamento FROM bitacora_mantenimiento b INNER JOIN plantas p ON p.id = b.id_planta INNER JOIN 
            control_usuarios.departamentos AS d ON d.id = p.departamento_id WHERE b.f_inicio LIKE '$this->ano_actual' GROUP BY d.departamento;"; //Cremaos Query de consulta   
        }else{
            $sql = "SELECT b.id_planta, b.f_inicio, b.f_final, SUM(b.importe_combustible) AS importe_total_combustible, TRUNCATE(SUM(b.gasto_carga_combustible), 2) AS 
            gasto_combustible_total, TRUNCATE(SUM(b.importe_correctivo), 2) AS total_importe_correctivo, TRUNCATE(SUM(b.importe_preventivo),2) AS total_importe_preventivo, 
            sum(if(b.tipo_mantenimiento = 'PREVENTIVO', 1, 0)) AS MMTOS_PREVENTIVO, sum(if(b.tipo_mantenimiento = 'CORRECTIVO', 1, 0)) AS MMTOS_CORRECTIVO, 
            p.departamento_id AS id_departamento, d.departamento FROM bitacora_mantenimiento b INNER JOIN plantas p ON p.id = b.id_planta INNER JOIN 
            control_usuarios.departamentos AS d ON d.id = p.departamento_id WHERE b.f_inicio LIKE '$this->ano_anterior' GROUP BY d.departamento;"; //Cremaos Query de consulta
        }
        
        $data = $this->selectAll($sql); //Mandamos la consulta al Select y la duardamos en una variable al metodo del Query.php
        return $data; // Retornamos la respuesta
    }

    public function getCRMensual(string $fecha_mensual_actual, string $fecha_mensual_anterior, int $periodo) //Obtener Lista de todas los registros de bitacora operacion para autorizar
    {        
        $this->periodo = $periodo; //Guardamos la variable
        $this->fecha_mensual_actual = '%'.$fecha_mensual_actual.'%'; //Guardamos la variable
        $this->fecha_mensual_anterior = '%'.$fecha_mensual_anterior.'%'; //Guardamos la variable

        if ($periodo == 0) {
            $sql = "SELECT b.id_planta, b.f_inicio, b.f_final, SUM(b.importe_combustible) AS importe_total_combustible, TRUNCATE(SUM(b.gasto_carga_combustible), 2) AS 
            gasto_combustible_total, TRUNCATE(SUM(b.importe_correctivo), 2) AS total_importe_correctivo, TRUNCATE(SUM(b.importe_preventivo),2) AS total_importe_preventivo, 
            sum(if(b.tipo_mantenimiento = 'PREVENTIVO', 1, 0)) AS MMTOS_PREVENTIVO, sum(if(b.tipo_mantenimiento = 'CORRECTIVO', 1, 0)) AS MMTOS_CORRECTIVO, 
            p.departamento_id AS id_departamento, d.departamento FROM bitacora_mantenimiento b INNER JOIN plantas p ON p.id = b.id_planta INNER JOIN 
            control_usuarios.departamentos AS d ON d.id = p.departamento_id WHERE b.f_inicio LIKE '$this->fecha_mensual_actual' GROUP BY d.departamento;"; //Cremaos Query de consulta   
        }else{
            $sql = "SELECT b.id_planta, b.f_inicio, b.f_final, SUM(b.importe_combustible) AS importe_total_combustible, TRUNCATE(SUM(b.gasto_carga_combustible), 2) AS 
            gasto_combustible_total, TRUNCATE(SUM(b.importe_correctivo), 2) AS total_importe_correctivo, TRUNCATE(SUM(b.importe_preventivo),2) AS total_importe_preventivo, 
            sum(if(b.tipo_mantenimiento = 'PREVENTIVO', 1, 0)) AS MMTOS_PREVENTIVO, sum(if(b.tipo_mantenimiento = 'CORRECTIVO', 1, 0)) AS MMTOS_CORRECTIVO, 
            p.departamento_id AS id_departamento, d.departamento FROM bitacora_mantenimiento b INNER JOIN plantas p ON p.id = b.id_planta INNER JOIN 
            control_usuarios.departamentos AS d ON d.id = p.departamento_id WHERE b.f_inicio LIKE '$this->fecha_mensual_anterior' GROUP BY d.departamento;"; //Cremaos Query de consulta
        }
        
        $data = $this->selectAll($sql); //Mandamos la consulta al Select y la duardamos en una variable al metodo del Query.php
        return $data; // Retornamos la respuesta
    }

    public function getCRRangoFechas(string $from, string $to) //Obtener Lista de todas los registros de bitacora operacion para autorizar
    {        
        $this->from = $from; //Guardamos la variable
        $this->to = $to; //Guardamos la variable

        $sql = "SELECT b.id_planta, b.f_inicio, b.f_final, SUM(b.importe_combustible) AS importe_total_combustible, TRUNCATE(SUM(b.gasto_carga_combustible), 2) AS 
        gasto_combustible_total, TRUNCATE(SUM(b.importe_correctivo), 2) AS total_importe_correctivo, TRUNCATE(SUM(b.importe_preventivo),2) AS total_importe_preventivo, 
        sum(if(b.tipo_mantenimiento = 'PREVENTIVO', 1, 0)) AS MMTOS_PREVENTIVO, sum(if(b.tipo_mantenimiento = 'CORRECTIVO', 1, 0)) AS MMTOS_CORRECTIVO, 
        p.departamento_id AS id_departamento, d.departamento FROM bitacora_mantenimiento b INNER JOIN plantas p ON p.id = b.id_planta INNER JOIN 
        control_usuarios.departamentos AS d ON d.id = p.departamento_id WHERE DATE_FORMAT(b.f_inicio,'%Y-%m-%d') >= '$this->from' AND DATE_FORMAT(b.f_inicio,'%Y-%m-%d') <= '$this->to' 
        GROUP BY d.departamento;"; //Cremaos Query de consulta

        $data = $this->selectAll($sql); //Mandamos la consulta al Select y la duardamos en una variable al metodo del Query.php
        return $data; // Retornamos la respuesta
    }

    public function getDepartamentos() //Obtener Lista de todas los registros de bitacora operacion para autorizar
    {        
        $sql = "SELECT d.departamento FROM control_usuarios.departamentos d WHERE departamento LIKE '%CENTAURO%' OR departamento LIKE '%COMPLEJO%' OR 
        departamento LIKE '%RAZA%' OR departamento LIKE '%COPERNICO%' OR departamento = 'TORREON 1' OR departamento = 'TORREON 2' OR departamento = 
        'DURANGO' AND activo = 1 ORDER BY departamento ASC";
        $data = $this->selectAll($sql);
        return $data;
    }

    /*====================================================================== FUNCIONES =========================================================================*/
    /*==========================================================================================================================================================*/
    /*==========================================================================================================================================================*/
}
