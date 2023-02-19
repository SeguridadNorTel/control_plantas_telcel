<?php
class SolicitarModel extends Query //Heredamos la clase Query
{
    private $sitio_operacion, $motivo_operacion, $f_inicio_operacion, $fechaActual, $lts_actual_operacion, $id_personal_solicitante, $precio,
    $tipo_mantenimiento, $motivo_mantenimiento,$id_personal_responsable, $f_inicio_mantenimiento, $estatus_planta, $estatus_solicitud, $id_planta, 
    $id_personal_aprobacion, $horas_operando, $gasto_carga_combustible,  //Variables Generales

    $id_finalizar_f, $lts_final_f, $cargo_combustible_f, $importe_combustible_f, $fecha_final_f, $precio_combustible_f, $cargo_correctivo_f, $descripcion_correctivo_f, 
    $importe_correctivo_f, $cargo_preventivo_f, $descripcion_preventivo_f, $importe_preventivo_f, $comentarios_f, $f_prox_mantenimiento // Variables para finalizar Operacion/Mantenimiento
    ;

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
    public function getSolicitar() //Obtener Lista de todas las plantas para la tabla
    {
        $departamento_id = $_SESSION['id_departamento_plantas_fijas']; //guardamos el departamento del usuario logueado
        $localidad_id = $_SESSION['id_localidad_plantas_fijas']; //guardamos el departamento del usuario logueado

        $rol = $_SESSION['rol_plantas_fijas'];
        if ($rol == "developer" or $rol == "admin") { //Evaluamos los privilegios del usuario logueado
            $sql = "SELECT p.*, l.id as id_localidad, l.localidad, g.id AS id_gerencia, g.gerencia, d.id AS id_departamento, d.departamento, per.id AS id_responsable, 
            per.nombre AS responsable FROM plantas p INNER JOIN control_usuarios.localidad l ON p.localidad_id = l.id INNER JOIN control_usuarios.gerencia g ON 
            p.gerencia_id = g.id INNER JOIN control_usuarios.departamentos d ON p.departamento_id = d.id INNER JOIN control_usuarios.personal per ON p.responsable_id = 
            per.id WHERE p.activo = 1"; //Cremaos Query de consulta
        }else{
            $sql = "SELECT p.*, l.id as id_localidad, l.localidad, g.id AS id_gerencia, g.gerencia, d.id AS id_departamento, d.departamento, per.id AS id_responsable, 
            per.nombre AS responsable FROM plantas p INNER JOIN control_usuarios.localidad l ON p.localidad_id = l.id INNER JOIN control_usuarios.gerencia g ON 
            p.gerencia_id = g.id INNER JOIN control_usuarios.departamentos d ON p.departamento_id = d.id INNER JOIN control_usuarios.personal per ON p.responsable_id = 
            per.id WHERE p.localidad_id = '$localidad_id' AND p.activo = 1"; //Cremaos Query de consulta
        }

        $data = $this->selectAll($sql); //Mandamos la consulta al Select y la duardamos en una variable al metodo del Query.php
        return $data; // Retornamos la respuesta
    }

    public function getSolicitar_bitacora_operacion() //Obtener Lista de todas las plantas para la tabla
    {
        $id_user_plantas_fijas = $_SESSION['id_user_plantas_fijas']; //Guardamos el id del usuario logueado para poder realizar la consulta

        $sql = "SELECT bo.*, p.id AS planta_id, p.no_economico, p.tipo, p_solicito.id AS solicitante_personal_id, p_solicito.nombre AS nombre_solicito, 
        p_solicito.num_empleado AS num_empleado_solicito, p_responsable.id AS responsable_personal_id, p_responsable.nombre AS nombre_responsable, 
        p_responsable.num_empleado AS num_empleado_responsable FROM bitacora_operacion bo INNER JOIN plantas p ON p.id = bo.id_planta INNER JOIN 
        control_usuarios.personal p_solicito ON p_solicito.id = bo.id_personal_solicitante INNER JOIN control_usuarios.personal p_responsable ON 
        p_responsable.id = bo.id_personal_responsable WHERE p_solicito.id = '$id_user_plantas_fijas'"; //Cremaos Query de consulta

        $data = $this->selectAll($sql); //Mandamos la consulta al Select y la duardamos en una variable al metodo del Query.php
        return $data; // Retornamos la respuesta
    }

    public function getSolicitar_bitacora_mantenimiento() //Obtener Lista de todas las plantas para la tabla
    {
        $id_user_plantas_fijas = $_SESSION['id_user_plantas_fijas']; //Guardamos el id del usuario para poder generar la consulta

        $sql = "SELECT bm.*, p.id AS planta_id, p.no_economico, p.tipo, p_solicito.id AS solicitante_personal_id, p_solicito.nombre AS nombre_solicito, 
        p_solicito.num_empleado AS num_empleado_solicito, p_responsable.id AS responsable_personal_id, p_responsable.nombre AS nombre_responsable, 
        p_responsable.num_empleado AS num_empleado_responsable FROM bitacora_mantenimiento bm INNER JOIN plantas p ON p.id = bm.id_planta INNER JOIN 
        control_usuarios.personal p_solicito ON p_solicito.id = bm.id_personal_solicitante INNER JOIN control_usuarios.personal p_responsable ON 
        p_responsable.id = bm.id_personal_responsable"; //Cremaos Query de consulta

        $data = $this->selectAll($sql); //Mandamos la consulta al Select y la duardamos en una variable al metodo del Query.php
        return $data; // Retornamos la respuesta
    }


    public function registrarSolicitudOperacion(int $id_planta, string $sitio_operacion, string $motivo_operacion, int $id_personal_responsable, string $f_inicio_operacion, string $fechaActual, float $lts_actual_operacion, int $id_personal_solicitante, string $estatus_solicitud) //Funcion Registrar Departamento
    {
        $this->id_planta = $id_planta; //Guardamos la variable
        $this->id_personal_responsable = $id_personal_responsable; //Guardamos la variable
        $this->lts_actual_operacion = $lts_actual_operacion; //Guardamos la variable
        $this->sitio_operacion = strtoupper($sitio_operacion); //Guardamos la variable
        $this->motivo_operacion =strtoupper($motivo_operacion); //Guardamos la variable
        $this->f_inicio_operacion = $f_inicio_operacion; //Guardamos la variable
        $this->fechaActual = $fechaActual; //Guardamos la variable 
        $this->id_personal_solicitante = $id_personal_solicitante; //Guardamos la variable 
        $this->estatus_solicitud = $estatus_solicitud; //Guardamos la variable 
        $this->id_personal_aprobacion = $id_personal_solicitante; //Guardamos la variable 

        if ($estatus_solicitud == 'APROBADO') {
            $sql = "INSERT INTO bitacora_operacion(sitio, motivo, f_inicio, f_registro, lts_inicial, id_personal_solicitante, id_personal_responsable, id_personal_aprobacion, estatus, id_planta) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"; //Creamos el Query para guardar el nuevo departamento
            $datos = array(
                $this->sitio_operacion, $this->motivo_operacion, $this->f_inicio_operacion, $this->fechaActual, $this->lts_actual_operacion, $this->id_personal_solicitante, $this->id_personal_responsable, $this->id_personal_aprobacion, $this->estatus_solicitud, $this->id_planta
            ); //Mandamos los datos que se guardaran    
        }else {
            $sql = "INSERT INTO bitacora_operacion(sitio, motivo, f_inicio, f_registro, lts_inicial, id_personal_solicitante, id_personal_responsable, estatus, id_planta) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"; //Creamos el Query para guardar el nuevo departamento
            $datos = array(
                $this->sitio_operacion, $this->motivo_operacion, $this->f_inicio_operacion, $this->fechaActual, $this->lts_actual_operacion, $this->id_personal_solicitante, $this->id_personal_responsable, $this->estatus_solicitud, $this->id_planta
            ); //Mandamos los datos que se guardaran
        }

        $data = $this->save($sql, $datos); //Mandamos a llamar a la funcion save

        if ($data == 1) { //Evaluamos la respuesta si es que nos arroja un error
            $res = "ok";
        } else {
            $res = "Error";
        }
        
        return $res;
    }

    public function registrarSolicitudMantenimiento(int $id_planta, string $tipo_mantenimiento, string $motivo_mantenimiento, int $id_personal_responsable, string $f_inicio_mantenimiento, string $fechaActual, float $lts_actual_operacion, int $id_personal_solicitante, string $estatus_solicitud) //Funcion Registrar Departamento
    {
        $this->id_planta = $id_planta; //Guardamos la variable
        $this->id_personal_responsable = $id_personal_responsable; //Guardamos la variable
        $this->lts_actual_operacion = $lts_actual_operacion; //Guardamos la variable
        $this->tipo_mantenimiento = strtoupper($tipo_mantenimiento); //Guardamos la variable
        $this->motivo_mantenimiento =strtoupper($motivo_mantenimiento); //Guardamos la variable
        $this->f_inicio_mantenimiento = $f_inicio_mantenimiento; //Guardamos la variable
        $this->fechaActual = $fechaActual; //Guardamos la variable 
        $this->id_personal_solicitante = $id_personal_solicitante; //Guardamos la variable 
        $this->estatus_solicitud = $estatus_solicitud; //Guardamos la variable 
        $this->id_personal_aprobacion = $id_personal_solicitante; //Guardamos la variable 

        if ($estatus_solicitud == 'APROBADO'){
            $sql = "INSERT INTO bitacora_mantenimiento(tipo_mantenimiento, motivo, f_inicio, f_registro, lts_inicial, id_personal_solicitante, id_personal_responsable, id_personal_aprobacion, estatus, id_planta) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"; //Creamos el Query para guardar el nuevo departamento
            $datos = array(
                $this->tipo_mantenimiento, $this->motivo_mantenimiento, $this->f_inicio_mantenimiento, $this->fechaActual, $this->lts_actual_operacion, $this->id_personal_solicitante, $this->id_personal_responsable, $this->id_personal_aprobacion, $this->estatus_solicitud, $this->id_planta
            ); //Mandamos los datos que se guardaran
        }else{
            $sql = "INSERT INTO bitacora_mantenimiento(tipo_mantenimiento, motivo, f_inicio, f_registro, lts_inicial, id_personal_solicitante, id_personal_responsable, estatus, id_planta) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"; //Creamos el Query para guardar el nuevo departamento
            $datos = array(
                $this->tipo_mantenimiento, $this->motivo_mantenimiento, $this->f_inicio_mantenimiento, $this->fechaActual, $this->lts_actual_operacion, $this->id_personal_solicitante, $this->id_personal_responsable, $this->estatus_solicitud, $this->id_planta
            ); //Mandamos los datos que se guardaran
        }

        $data = $this->save($sql, $datos); //Mandamos a llamar a la funcion save

        if ($data == 1) { //Evaluamos la respuesta si es que nos arroja un error
            $res = "ok";
        } else {
            $res = "Error";
        }
        
        return $res;
    }

    public function getInfo(int $id) //Mandamos a traer los datos del la planta
    {
        $sql = "SELECT p.*, c.id AS id_combustible, c.combustible, c.precio FROM plantas p INNER JOIN configuracion c ON c.id = p.combustible_id WHERE p.id = '$id'"; //Creamos la consulta SQL
        $data = $this->select($sql); //Mandamos llamar el metodo select
        return $data; //Retornamos la data
    }

    public function accionEstatusPlanta(string $estatus_planta, int $id) //Eliminar o Reingresar usuario
    {
        $this->id = $id; //Guardamos Id del usuario
        $this->estatus_planta = $estatus_planta; //Guardamos Id del usuario
        if ($estatus_planta == 'OPERANDO') {
            $sql = "UPDATE plantas SET estatus = ? WHERE id = ?"; //Creamos consulta sql
            $datos = array($this->estatus_planta, $this->id); //Creamos el arreglo con el Id

        }else if($estatus_planta == 'MANTENIMIENTO'){
            $sql = "UPDATE plantas SET estatus = ? WHERE id = ?"; //Creamos consulta sql
            $datos = array($this->estatus_planta, $this->id); //Creamos el arreglo con el Id

        }
        $data = $this->save($sql, $datos); //Mandamos a llamar a save
        return $data; //retornamos la respuesta
    }

    public function accionPlantaFinalizarOperacion(int $id, float $lts_final, float $horas_operando) //Eliminar o Reingresar usuario
    {
        $this->id_finalizar_f = $id; //Guardamos Id del usuario
        $this->lts_final_f = $lts_final; //Guardamos Id del usuario
        $this->horas_operando = $horas_operando; //Guardamos Id del usuario
        
        $sql = "UPDATE plantas SET lts_actual = ?, t_operando = ?, estatus = ? WHERE id = ?"; //Creamos consulta sql
        $datos = array($this->lts_final_f, $this->horas_operando, 'DISPONIBLE', $this->id_finalizar_f); //Creamos el arreglo con el Id

        
        $data = $this->save($sql, $datos); //Mandamos a llamar a save
        return $data; //retornamos la respuesta
    }

    public function accionPlantaFinalizarMantenimiento(int $id, float $lts_final, string $tipo_mantenimiento_finalizar, string $f_prox_mantenimiento) //Eliminar o Reingresar usuario
    {
        $this->id_finalizar_f = $id; //Guardamos Id del usuario
        $this->lts_final_f = $lts_final; //Guardamos Id del usuario
        $this->tipo_mantenimiento = $tipo_mantenimiento_finalizar; //Guardamos Id del usuario
        $this->f_prox_mantenimiento = $f_prox_mantenimiento; //Guardamos Id del usuario

        if ($tipo_mantenimiento_finalizar == 'PREVENTIVO') {
            $sql = "UPDATE plantas SET lts_actual = ?, t_operando = ?, f_mantenimiento = ?, estatus = ? WHERE id = ?"; //Creamos consulta sql
            $datos = array($this->lts_final_f, 0, $this->f_prox_mantenimiento, 'DISPONIBLE', $this->id_finalizar_f); //Creamos el arreglo con el Id   
        }else{
            $sql = "UPDATE plantas SET lts_actual = ?, t_operando = ?, estatus = ? WHERE id = ?"; //Creamos consulta sql
            $datos = array($this->lts_final_f, 0, 'DISPONIBLE', $this->id_finalizar_f); //Creamos el arreglo con el Id
        }

        
        $data = $this->save($sql, $datos); //Mandamos a llamar a save
        return $data; //retornamos la respuesta
    }


    public function getInfoBitacoraOperacion(int $id) //Mandamos a traer los datos del la planta
    {
        $sql = "SELECT b.*, p.id AS planta_id, p.no_economico, p.f_mantenimiento, p.t_operando FROM bitacora_operacion b INNER JOIN plantas p ON p.id = b.id_planta WHERE b.id = '$id'"; //Creamos la consulta SQL
        $data = $this->select($sql); //Mandamos llamar el metodo select
        return $data; //Retornamos la data
    }

    public function getInfoBitacoraMantenimiento(int $id) //Mandamos a traer los datos del la planta
    {
        $sql = "SELECT b.*, p.id AS planta_id, p.no_economico, p.f_mantenimiento, p.tipo FROM bitacora_mantenimiento b INNER JOIN plantas p ON p.id = b.id_planta WHERE b.id = '$id'"; //Creamos la consulta SQL
        $data = $this->select($sql); //Mandamos llamar el metodo select
        return $data; //Retornamos la data
    }

    public function finalizarMantenimiento(int $id_finalizar_mantenimiento, float $lts_final_f_mantenimiento, int $cargo_combustible_f_mantenimiento, float $importe_combustible_f_mantenimiento, 
    string $combinedDT, float $precio_combustible_f_mantenimiento, int $cargo_correctivo_f_mantenimiento, string $descripcion_correctivo_f_mantenimiento, float $importe_correctivo_f_mantenimiento, 
    int $cargo_preventivo_f_mantenimiento, string $descripcion_preventivo_f_mantenimiento, float $importe_preventivo_f_mantenimiento, string $comentarios_f_mantenimiento, float $gasto_carga_combustible) //Mandamos a traer los datos del la planta
    {
        $this->id_finalizar_f = $id_finalizar_mantenimiento; //Guardamos Id del Registro
        $this->lts_final_f = $lts_final_f_mantenimiento; //Guardamos Id del Registro
        $this->cargo_combustible_f = $cargo_combustible_f_mantenimiento; //Guardamos Id del Registro
        $this->importe_combustible_f = $importe_combustible_f_mantenimiento; //Guardamos Id del Registro
        $this->fecha_final_f = $combinedDT; //Guardamos Id del Registro
        $this->precio_combustible_f = $precio_combustible_f_mantenimiento; //Guardamos Id del Registro
        $this->cargo_correctivo_f = $cargo_correctivo_f_mantenimiento; //Guardamos Id del Registro
        $this->descripcion_correctivo_f = $descripcion_correctivo_f_mantenimiento; //Guardamos Id del Registro
        $this->importe_correctivo_f = $importe_correctivo_f_mantenimiento; //Guardamos Id del Registro

        $this->cargo_preventivo_f = $cargo_preventivo_f_mantenimiento; //Guardamos Id del Registro
        $this->descripcion_preventivo_f = $descripcion_preventivo_f_mantenimiento; //Guardamos Id del Registro
        $this->importe_preventivo_f = $importe_preventivo_f_mantenimiento; //Guardamos Id del Registro

        $this->comentarios_f = $comentarios_f_mantenimiento; //Guardamos Id del Registro
        $this->gasto_carga_combustible = $gasto_carga_combustible; //Guardamos Id del Registro

    
        $sql = "UPDATE bitacora_mantenimiento SET lts_final = ?, cargo_combustible = ?, importe_combustible = ?, f_final = ?, 
        precio_combustible = ?, cargo_correctivo = ?, descripcion_correctivo = ?, importe_correctivo = ?, cargo_preventivo = ?, 
        descripcion_preventivo = ?, importe_preventivo = ?, comentarios = ?, 
        estatus = ?, gasto_carga_combustible = ? WHERE id = ?"; //Creamos consulta sql
        $datos = array($this->lts_final_f, $this->cargo_combustible_f, $this->importe_combustible_f, $this->fecha_final_f, 
        $this->precio_combustible_f, $this->cargo_correctivo_f, $this->descripcion_correctivo_f, $this->importe_correctivo_f, 
        $this->cargo_preventivo_f, $this->descripcion_preventivo_f, $this->importe_preventivo_f,
        $this->comentarios_f, 'FINALIZADO', $this->gasto_carga_combustible, $this->id_finalizar_f); //Creamos el arreglo con el Id

        $data = $this->save($sql, $datos); //Mandamos a llamar a save
        $data = 1; //Mandamos a llamar a save
        return $data; //retornamos la respuesta
    }

    public function finalizarOperacion(int $id_finalizar_operacion, int $lts_final_f_operacion, int $cargo_combustible_f_operacion, float $importe_combustible_f_operacion, 
    string $combinedDT, float $precio_combustible_f_operacion, string $comentarios_f_operacion, float $gasto_carga_combustible) //Mandamos a traer los datos del la planta
    {
        $this->id_finalizar_f = $id_finalizar_operacion; //Guardamos Id del Registro
        $this->lts_final_f = $lts_final_f_operacion; //Guardamos Id del Registro
        $this->cargo_combustible_f = $cargo_combustible_f_operacion; //Guardamos Id del Registro
        $this->importe_combustible_f = $importe_combustible_f_operacion; //Guardamos Id del Registro
        $this->fecha_final_f = $combinedDT; //Guardamos Id del Registro
        $this->precio_combustible_f = $precio_combustible_f_operacion; //Guardamos Id del Registro
        $this->comentarios_f = $comentarios_f_operacion; //Guardamos Id del Registro
        $this->gasto_carga_combustible = $gasto_carga_combustible; //Guardamos Id del Registro

    
        $sql = "UPDATE bitacora_operacion SET lts_final = ?, cargo_combustible = ?, importe_combustible = ?, f_final = ?, 
        precio_combustible = ?, comentarios = ?, estatus = ?, gasto_carga_combustible = ? WHERE id = ?"; //Creamos consulta sql
        $datos = array($this->lts_final_f, $this->cargo_combustible_f, $this->importe_combustible_f, $this->fecha_final_f, 
        $this->precio_combustible_f, $this->comentarios_f, 'FINALIZADO', $this->gasto_carga_combustible,  $this->id_finalizar_f); //Creamos el arreglo con el Id

        $data = $this->save($sql, $datos); //Mandamos a llamar a save
        $data = 1; //Mandamos a llamar a save
        return $data; //retornamos la respuesta
    }
    
    /*====================================================================== FUNCIONES =========================================================================*/
    /*==========================================================================================================================================================*/
    /*==========================================================================================================================================================*/
}
