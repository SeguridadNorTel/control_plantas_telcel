<?php
class AutorizarModel extends Query //Heredamos la clase Query
{
    private $id, $lts_actual, $f_inicial, $id_personal_aprobacion; //Variables para registro del usuario

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
    public function getAutorizar_operacion() //Obtener Lista de todas los registros de bitacora operacion para autorizar
    {
        $id_user_plantas_fijas = $_SESSION['id_user_plantas_fijas']; //Obtenemos el Id del usuario log en la aplicacion del planta fijas

        $rol = $_SESSION['rol_plantas_fijas']; //Obtenemos el rol del usuario de la session

        if ($rol == "admin" || $rol == "developer") {
            $sql = "SELECT bo.*, p.id AS planta_id, p.no_economico, p.tipo, p_solicito.id AS solicitante_personal_id, p_solicito.nombre AS nombre_solicito, 
            p_solicito.num_empleado AS num_empleado_solicito, p_responsable.id AS responsable_personal_id, p_responsable.nombre AS nombre_responsable, 
            p_responsable.num_empleado AS num_empleado_responsable FROM bitacora_operacion bo INNER JOIN plantas p ON p.id = bo.id_planta INNER JOIN 
            control_usuarios.personal p_solicito ON p_solicito.id = bo.id_personal_solicitante INNER JOIN control_usuarios.personal p_responsable ON 
            p_responsable.id = bo.id_personal_responsable WHERE bo.estatus = 'NUEVO' OR bo.estatus = 'APROBADO'"; //Cremaos Query de consulta    
        } else {
            $sql = "SELECT bo.*, p.id AS planta_id, p.no_economico, p.tipo, p_solicito.id AS solicitante_personal_id, p_solicito.nombre AS nombre_solicito, 
            p_solicito.num_empleado AS num_empleado_solicito, p_responsable.id AS responsable_personal_id, p_responsable.nombre AS nombre_responsable, 
            p_responsable.num_empleado AS num_empleado_responsable FROM bitacora_operacion bo INNER JOIN plantas p ON p.id = bo.id_planta INNER JOIN 
            control_usuarios.personal p_solicito ON p_solicito.id = bo.id_personal_solicitante INNER JOIN control_usuarios.personal p_responsable ON 
            p_responsable.id = bo.id_personal_responsable WHERE bo.id_personal_responsable = '$id_user_plantas_fijas' AND (bo.estatus = 'NUEVO' OR bo.estatus = 'APROBADO')"; //Cremaos Query de consulta
        }

        $data = $this->selectAll($sql); //Mandamos la consulta al Select y la duardamos en una variable al metodo del Query.php
        return $data; // Retornamos la respuesta
    }

    public function getAutorizar_bitacora_operacion() //Obtener Lista de todas los registros de bitacora operacion para ver historial
    {
        $id_user_plantas_fijas = $_SESSION['id_user_plantas_fijas']; //Obtenemos el Id del usuario log en la aplicacion del planta fijas

        $sql = "SELECT bo.*, p.id AS planta_id, p.no_economico, p.tipo, p_solicito.id AS solicitante_personal_id, p_solicito.nombre AS nombre_solicito, 
        p_solicito.num_empleado AS num_empleado_solicito, p_responsable.id AS responsable_personal_id, p_responsable.nombre AS nombre_responsable, 
        p_responsable.num_empleado AS num_empleado_responsable FROM bitacora_operacion bo INNER JOIN plantas p ON p.id = bo.id_planta INNER JOIN 
        control_usuarios.personal p_solicito ON p_solicito.id = bo.id_personal_solicitante INNER JOIN control_usuarios.personal p_responsable ON 
        p_responsable.id = bo.id_personal_responsable WHERE bo.id_personal_responsable = '$id_user_plantas_fijas' AND (bo.estatus = 'FINALIZADO' OR bo.estatus = 'RECHAZADO')"; //Cremaos Query de consulta        

        $data = $this->selectAll($sql); //Mandamos la consulta al Select y la duardamos en una variable al metodo del Query.php
        return $data; // Retornamos la respuesta
    }

    public function getAutorizar_mantenimiento() //Obtener Lista de todas los registros de bitacora mantenimiento par aautorizar
    {
        $id_user_plantas_fijas = $_SESSION['id_user_plantas_fijas']; //Obtenemos el Id del usuario log en la aplicacion del planta fijas

        $rol = $_SESSION['rol_plantas_fijas']; //Obtenemos el rol del usuario de la session

        if ($rol == "admin" || $rol == "developer") {
            $sql = "SELECT bo.*, p.id AS planta_id, p.no_economico, p.tipo, p_solicito.id AS solicitante_personal_id, p_solicito.nombre AS nombre_solicito, 
            p_solicito.num_empleado AS num_empleado_solicito, p_responsable.id AS responsable_personal_id, p_responsable.nombre AS nombre_responsable, 
            p_responsable.num_empleado AS num_empleado_responsable FROM bitacora_mantenimiento bo INNER JOIN plantas p ON p.id = bo.id_planta INNER JOIN 
            control_usuarios.personal p_solicito ON p_solicito.id = bo.id_personal_solicitante INNER JOIN control_usuarios.personal p_responsable ON 
            p_responsable.id = bo.id_personal_responsable WHERE bo.estatus = 'NUEVO' OR bo.estatus = 'APROBADO'"; //Cremaos Query de consulta    
        } else {
            $sql = "SELECT bo.*, p.id AS planta_id, p.no_economico, p.tipo, p_solicito.id AS solicitante_personal_id, p_solicito.nombre AS nombre_solicito, 
            p_solicito.num_empleado AS num_empleado_solicito, p_responsable.id AS responsable_personal_id, p_responsable.nombre AS nombre_responsable, 
            p_responsable.num_empleado AS num_empleado_responsable FROM bitacora_mantenimiento bo INNER JOIN plantas p ON p.id = bo.id_planta INNER JOIN 
            control_usuarios.personal p_solicito ON p_solicito.id = bo.id_personal_solicitante INNER JOIN control_usuarios.personal p_responsable ON 
            p_responsable.id = bo.id_personal_responsable WHERE bo.id_personal_responsable = '$id_user_plantas_fijas' AND (bo.estatus = 'NUEVO' OR bo.estatus = 'APROBADO')"; //Cremaos Query de consulta
        }

        $data = $this->selectAll($sql); //Mandamos la consulta al Select y la duardamos en una variable al metodo del Query.php
        return $data; // Retornamos la respuesta
    }

    public function getAutorizar_bitacora_mantenimiento() //Obtener Lista de todas los registros de bitacora mantenimiento para ver historial
    {
        $id_user_plantas_fijas = $_SESSION['id_user_plantas_fijas']; //Obtenemos el Id del usuario log en la aplicacion del planta fijas

        $sql = "SELECT bo.*, p.id AS planta_id, p.no_economico, p.tipo, p_solicito.id AS solicitante_personal_id, p_solicito.nombre AS nombre_solicito, 
        p_solicito.num_empleado AS num_empleado_solicito, p_responsable.id AS responsable_personal_id, p_responsable.nombre AS nombre_responsable, 
        p_responsable.num_empleado AS num_empleado_responsable FROM bitacora_mantenimiento bo INNER JOIN plantas p ON p.id = bo.id_planta INNER JOIN 
        control_usuarios.personal p_solicito ON p_solicito.id = bo.id_personal_solicitante INNER JOIN control_usuarios.personal p_responsable ON 
        p_responsable.id = bo.id_personal_responsable WHERE bo.id_personal_responsable = '$id_user_plantas_fijas' AND (bo.estatus = 'FINALIZADO' OR bo.estatus = 'RECHAZADO')"; //Cremaos Query de consulta        

        $data = $this->selectAll($sql); //Mandamos la consulta al Select y la duardamos en una variable al metodo del Query.php
        return $data; // Retornamos la respuesta
    }

    public function autorizar_operacion(int $id) //Eliminar o Reingresar usuario
    {
        $this->id = $id; //Guardamos Id del Registro
        $this->id_personal_aprobacion = $_SESSION['id_user_plantas_fijas'];
    
        $sql = "UPDATE bitacora_operacion SET estatus = ?, id_personal_aprobacion = ? WHERE id = ?"; //Creamos consulta sql
        $datos = array('APROBADO', $this->id_personal_aprobacion, $this->id); //Creamos el arreglo con el Id

        $data = $this->save($sql, $datos); //Mandamos a llamar a save
        return $data; //retornamos la respuesta
    }

    public function rechazar_operacion(int $id, int $lts_actual, string $f_inicial) //Eliminar o Reingresar usuario
    {
        $this->id = $id; //Guardamos Id del Registro
        $this->lts_actual = $lts_actual; //Guardamos Id del Registro
        $this->f_inicial = $f_inicial; //Guardamos Id del Registro
        $this->id_personal_aprobacion = $_SESSION['id_user_plantas_fijas'];
    
        $sql = "UPDATE bitacora_operacion SET estatus = ?, lts_final = ?, f_final = ?, id_personal_aprobacion = ? WHERE id = ?"; //Creamos consulta sql
        $datos = array('RECHAZADO', $this->lts_actual, $this->f_inicial, $this->id_personal_aprobacion, $this->id); //Creamos el arreglo con el Id

        $data = $this->save($sql, $datos); //Mandamos a llamar a save
        return $data; //retornamos la respuesta
    }

    public function autorizar_mantenimiento(int $id) //Eliminar o Reingresar usuario
    {
        $this->id = $id; //Guardamos Id del Registro
        $this->id_personal_aprobacion = $_SESSION['id_user_plantas_fijas'];
    
        $sql = "UPDATE bitacora_mantenimiento SET estatus = ?, id_personal_aprobacion = ? WHERE id = ?"; //Creamos consulta sql
        $datos = array('APROBADO', $this->id_personal_aprobacion, $this->id); //Creamos el arreglo con el Id

        $data = $this->save($sql, $datos); //Mandamos a llamar a save
        return $data; //retornamos la respuesta
    }

    public function rechazar_mantenimiento(int $id, int $lts_actual, string $f_inicial) //Eliminar o Reingresar usuario
    {
        $this->id = $id; //Guardamos Id del Registro
        $this->lts_actual = $lts_actual; //Guardamos Id del Registro
        $this->f_inicial = $f_inicial; //Guardamos Id del Registro
        $this->id_personal_aprobacion = $_SESSION['id_user_plantas_fijas'];
    
        $sql = "UPDATE bitacora_mantenimiento SET estatus = ?, lts_final = ?, f_final = ?, id_personal_aprobacion = ? WHERE id = ?"; //Creamos consulta sql
        $datos = array('RECHAZADO', $this->lts_actual, $this->f_inicial, $this->id_personal_aprobacion, $this->id); //Creamos el arreglo con el Id

        $data = $this->save($sql, $datos); //Mandamos a llamar a save
        return $data; //retornamos la respuesta
    }

    /*====================================================================== FUNCIONES =========================================================================*/
    /*==========================================================================================================================================================*/
    /*==========================================================================================================================================================*/
}
