<?php
class AdminModel extends Query //Heredamos la clase Query
{
    private $id; //Variables para registro del usuario

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
    public function getBOperacion() //Obtener Lista de todas los registros de bitacora operacion para autorizar
    {        
        $sql = "SELECT b.*, p.id AS planta_id, p.no_economico, p.departamento_id, d.departamento, p_solicito.nombre AS nombre_solicito, 
        p_solicito.num_empleado AS num_emp_solicito, p_responsable.nombre AS nombre_responsable, p_responsable.num_empleado AS num_emp_responsable
        FROM bitacora_operacion b INNER JOIN plantas p ON p.id = b.id_planta INNER JOIN control_usuarios.departamentos AS d ON d.id = 
        p.departamento_id INNER JOIN control_usuarios.personal AS p_solicito ON p_solicito.id = b.id_personal_solicitante INNER JOIN 
        control_usuarios.personal AS p_responsable ON p_responsable.id = b.id_personal_responsable;"; //Cremaos Query de consulta
        
        $data = $this->selectAll($sql); //Mandamos la consulta al Select y la duardamos en una variable al metodo del Query.php
        return $data; // Retornamos la respuesta
    }
    public function getBMantenimiento() //Obtener Lista de todas los registros de bitacora operacion para autorizar
    {        
        $sql = "SELECT b.*, p.id AS planta_id, p.no_economico, p.departamento_id, d.departamento, p_solicito.nombre AS nombre_solicito, 
        p_solicito.num_empleado AS num_emp_solicito, p_responsable.nombre AS nombre_responsable, p_responsable.num_empleado AS num_emp_responsable
         FROM bitacora_mantenimiento b INNER JOIN plantas p ON p.id = b.id_planta INNER JOIN control_usuarios.departamentos AS d ON d.id = 
         p.departamento_id INNER JOIN control_usuarios.personal AS p_solicito ON p_solicito.id = b.id_personal_solicitante INNER JOIN 
         control_usuarios.personal AS p_responsable ON p_responsable.id = b.id_personal_responsable;"; //Cremaos Query de consulta
        
        $data = $this->selectAll($sql); //Mandamos la consulta al Select y la duardamos en una variable al metodo del Query.php
        return $data; // Retornamos la respuesta
    }
    /*====================================================================== FUNCIONES =========================================================================*/
    /*==========================================================================================================================================================*/
    /*==========================================================================================================================================================*/
}
