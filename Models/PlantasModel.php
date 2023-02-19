<?php
class PlantasModel extends Query //Heredamos la clase Query
{
    private $no_economico, $tipo, $marca, $modelo, $no_serie, $departamento_id, $localidad_id, $gerencia_id, 
    $responsable_id, $capacidad_kw, $capacidad_lts, $lts_actual, $f_mantenimiento, $comentarios, $horometro, $nombre_sitio, $ip, $placas, $estado, $combustible_id, $id; //Variables para registro del usuario

    public function __construct()
    {
        parent::__construct(); //Obtenemos el contructor de Query para el metodo
    }

    /*==========================================================================================================================================================*/
    /*==========================================================================================================================================================*/
    /*====================================================================== CATALOGOS =========================================================================*/

    public function getLocalidades() //Obtener catalogo de Localidades
    {
        $sql = "SELECT * FROM control_usuarios.localidad WHERE activo = 1";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function getGerencia() //Obtener catalogo de Gerencias
    {
        $sql = "SELECT * FROM control_usuarios.gerencia WHERE gerencia = 'GERENCIA OPERACION Y MANTENIMIENTO' AND activo = 1";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function getCombustibles() //Obtener catalogo de Gerencias
    {
        $sql = "SELECT * FROM configuracion WHERE activo = 1";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function getDepartamentos() //Obtener catalogo de Departamentos
    {
        $sql = "SELECT * FROM control_usuarios.departamentos WHERE departamento LIKE '%CENTAURO%' OR departamento LIKE '%COMPLEJO%' OR departamento 
        LIKE '%RAZA%' OR departamento LIKE '%COPERNICO%' OR departamento = 'TORREON 1' OR departamento = 'TORREON 2' OR departamento = 'DURANGO' 
        AND activo = 1 ORDER BY departamento ASC";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function getPersonalJefe() //Obtener catalogo de Usuarios Admin
    {
        $sql = "SELECT u.*, r.id AS id_rol, r.rol, p.num_empleado AS num_empleado_personal, p.nombre, p.id AS id_personal FROM control_usuarios.users_plantas_fijas 
        u INNER JOIN control_usuarios.roles_plantas_fijas r ON u.rol_id = r.id INNER JOIN control_usuarios.personal p ON u.num_empleado = p.num_empleado WHERE 
        r.rol = 'jefe' AND u.activo = 1";
        $data = $this->selectAll($sql);
        return $data;
    }
    
    /*====================================================================== CATALOGOS =========================================================================*
    /*==========================================================================================================================================================*/
    /*==========================================================================================================================================================*/

    /*==========================================================================================================================================================*/
    /*==========================================================================================================================================================*/
    /*====================================================================== FUNCIONES =========================================================================*/
    
    public function getPlantas() //Obtener Lista de todas las plantas para la tabla
    {
        $sql = "SELECT p.*, l.id as id_localidad, l.localidad, g.id AS id_gerencia, g.gerencia, d.id AS id_departamento, d.departamento, per.id 
        AS id_responsable, per.nombre AS responsable FROM plantas p INNER JOIN control_usuarios.localidad l ON p.localidad_id = l.id INNER JOIN control_usuarios.gerencia g 
        ON p.gerencia_id = g.id INNER JOIN control_usuarios.departamentos d ON p.departamento_id = d.id INNER JOIN control_usuarios.personal per 
        ON p.responsable_id = per.id"; //Cremaos Query de consulta
        $data = $this->selectAll($sql); //Mandamos la consulta al Select y la duardamos en una variable al metodo del Query.php
        return $data; // Retornamos la respuesta
    }

    public function registrarPlanta(string $no_economico, string $tipo, string $marca, string $modelo, string $no_serie, int $departamento_id, int $localidad_id, 
    int $gerencia_id, int $responsable_id, float $capacidad_kw, float $capacidad_lts, float $lts_actual, string $f_mantenimiento, string $comentarios, float $horometro, string $nombre_sitio, string $ip, string $placas, int $combustible_id) //Funcion Registrar Departamento
    {
        $this->no_economico = strtoupper($no_economico); //Guardamos la variable
        $this->tipo = strtoupper($tipo); //Guardamos la variable
        $this->marca = strtoupper($marca); //Guardamos la variable
        $this->modelo = strtoupper($modelo); //Guardamos la variable
        $this->no_serie = strtoupper($no_serie); //Guardamos la variable
        $this->departamento_id = $departamento_id; //Guardamos la variable
        $this->localidad_id = $localidad_id; //Guardamos la variable
        $this->gerencia_id = $gerencia_id; //Guardamos la variable
        $this->responsable_id = $responsable_id; //Guardamos la variable
        $this->capacidad_kw = $capacidad_kw; //Guardamos la variable
        $this->capacidad_lts = $capacidad_lts; //Guardamos la variable
        $this->lts_actual = $lts_actual; //Guardamos la variable
        $this->f_mantenimiento = $f_mantenimiento; //Guardamos la variable
        $this->comentarios = strtoupper($comentarios); //Guardamos la variable
        $this->horometro = $horometro; //Guardamos la variable
        $this->nombre_sitio = strtoupper($nombre_sitio); //Guardamos la variable
        $this->placas = strtoupper($placas); //Guardamos la variable
        $this->ip = strtoupper($ip); //Guardamos la variable
        $this->combustible_id = $combustible_id; //Guardamos la variable


        $verificar = "SELECT * FROM plantas WHERE no_economico = '$this->no_economico'"; //Creamos el Query para verificar si existe el departamento registrado
        $existe = $this->select($verificar);

        if (empty($existe)) { //Aqui validamos si la localidad existe

            $sql = "INSERT INTO plantas(no_economico, tipo, marca, modelo, no_serie, departamento_id, localidad_id, gerencia_id, responsable_id, capacidad_kw
            , capacidad_lts, lts_actual, f_mantenimiento, comentarios, horometro, nombre_sitio, ip, placas, combustible_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"; //Creamos el Query para guardar el nuevo departamento
            $datos = array(
                $this->no_economico, $this->tipo, $this->marca, $this->modelo, $this->no_serie, $this->departamento_id, $this->localidad_id, $this->gerencia_id,
                $this->responsable_id, $this->capacidad_kw, $this->capacidad_lts, $this->lts_actual, $this->f_mantenimiento, $this->comentarios, $this->horometro, $this->nombre_sitio, 
                $this->ip, $this->placas, $this->combustible_id
            ); //Mandamos los datos que se guardaran

            $data = $this->save($sql, $datos); //Mandamos a llamar a la funcion save

            if ($data == 1) { //Evaluamos la respuesta si es que nos arroja un error
                $res = "ok";
            } else {
                $res = "Error";
            }
        } else {
            $res = "existe";
        }

        return $res;
    }

    public function modificarPlanta(string $no_economico, string $tipo, string $marca, string $modelo, string $no_serie, int $departamento_id, int $localidad_id, 
    int $gerencia_id, int $responsable_id, float $capacidad_kw, float $capacidad_lts, float $lts_actual, string $f_mantenimiento, string $comentarios, float $horometro, 
    string $nombre_sitio, string $ip, string $placas, int $combustible_id, int $id) //Funcion Modificar Usuario
    {
        $this->no_economico = strtoupper($no_economico); //Guardamos la variable
        $this->tipo = strtoupper($tipo); //Guardamos la variable
        $this->marca = strtoupper($marca); //Guardamos la variable
        $this->modelo = strtoupper($modelo); //Guardamos la variable
        $this->no_serie = strtoupper($no_serie); //Guardamos la variable
        $this->departamento_id = $departamento_id; //Guardamos la variable
        $this->localidad_id = $localidad_id; //Guardamos la variable
        $this->gerencia_id = $gerencia_id; //Guardamos la variable
        $this->responsable_id = $responsable_id; //Guardamos la variable
        $this->capacidad_kw = $capacidad_kw; //Guardamos la variable
        $this->capacidad_lts = $capacidad_lts; //Guardamos la variable
        $this->lts_actual = $lts_actual; //Guardamos la variable
        $this->f_mantenimiento = $f_mantenimiento; //Guardamos la variable
        $this->comentarios = strtoupper($comentarios); //Guardamos la variable
        $this->horometro = $horometro; //Guardamos la variable
        $this->nombre_sitio = strtoupper($nombre_sitio); //Guardamos la variable
        $this->placas = strtoupper($placas); //Guardamos la variable
        $this->ip = strtoupper($ip); //Guardamos la variable
        $this->combustible_id = $combustible_id; //Guardamos la variable
        $this->id = $id; //Guardamos la variable


        $sql = "UPDATE plantas SET no_economico = ?, tipo = ?, marca = ?, modelo = ?, no_serie = ?, departamento_id = ?, localidad_id = ?, gerencia_id = ?, responsable_id = ?, capacidad_kw = ?
        , capacidad_lts = ?, lts_actual = ?, f_mantenimiento = ?, comentarios = ?, horometro = ?, nombre_sitio = ?, ip = ?, placas = ?, combustible_id = ? WHERE id = ?"; //Creamos el Query para guardar el nuevo Empleado
        $datos = array(
            $this->no_economico, $this->tipo, $this->marca, $this->modelo, $this->no_serie, $this->departamento_id, $this->localidad_id, $this->gerencia_id,
            $this->responsable_id, $this->capacidad_kw, $this->capacidad_lts, $this->lts_actual, $this->f_mantenimiento, $this->comentarios, $this->horometro, $this->nombre_sitio,
            $this->ip, $this->placas, $this->combustible_id, $this->id
        ); //Mandamos los datos que se guardaran
        $data = $this->save($sql, $datos); //Mandamos a llamar a la funcion save
        if ($data == 1) { //Evaluamos la respuesta si es que nos arroja un error
            $res = "modificado";
        } else {
            $res = "Error";
        }


        return $res;
    }

    public function accionPlanta(int $estado, int $id) //Eliminar o Reingresar usuario
    {
        $this->id = $id; //Guardamos Id del usuario
        $this->estado = $estado; //Guardamos Id del usuario
        if ($estado == 1) {
            $sql = "UPDATE plantas SET activo = ?, estatus = ? WHERE id = ?"; //Creamos consulta sql
            $datos = array($this->estado, 'DISPONIBLE', $this->id); //Creamos el arreglo con el Id
        } else {
            $sql = "UPDATE plantas SET activo = ?, estatus = ? WHERE id = ?"; //Creamos consulta sql
            $datos = array($this->estado, 'NO DISPONIBLE', $this->id); //Creamos el arreglo con el Id
        }
        $data = $this->save($sql, $datos); //Mandamos a llamar a save
        return $data; //retornamos la respuesta
    }

    public function editarPlanta(int $id) //Mandamos a traer los datos del usuario a actualizar
    {
        $sql = "SELECT * FROM plantas WHERE id = '$id'"; //Creamos la consulta SQL
        $data = $this->select($sql); //Mandamos llamar el metodo select
        return $data; //Retornamos la data
    }
    /*====================================================================== FUNCIONES =========================================================================*/
    /*==========================================================================================================================================================*/
    /*==========================================================================================================================================================*/
}
