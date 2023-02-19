<?php
class UsuariosModel extends Query //Heredamos la clase Query
{
    private $numero_emp, $mail, $departamento, $localidad, $puesto, $nombre_emp, $clave, $region, $gerencia, $telefono, $num_emp_jefe, $fecha_password, $id; //Variables para registro del usuario

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
        $sql = "SELECT * FROM control_usuarios.gerencia WHERE activo = 1";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function getDepartamentos() //Obtener catalogo de Departamentos
    {
        $sql = "SELECT * FROM control_usuarios.departamentos WHERE activo = 1";
        $data = $this->selectAll($sql);
        return $data;
    }
    /*====================================================================== CATALOGOS =========================================================================*
    /*==========================================================================================================================================================*/
    /*==========================================================================================================================================================*/

    /*==========================================================================================================================================================*/
    /*==========================================================================================================================================================*/
    /*====================================================================== FUNCIONES =========================================================================*/
    public function getUsuario(string $usuario) //Obtener usuario en aplicacion
    {
        $sql = "SELECT u.*, r.id as id_rol, r.rol FROM control_usuarios.users_plantas_fijas u INNER JOIN control_usuarios.roles_plantas_fijas r ON u.rol_id = r.id WHERE num_empleado = '$usuario'"; //Cremaos Query de consulta
        $data = $this->select($sql); //Mandamos la consulta al Select y la duardamos en una variable al metodo
        return $data; // Retornamos la respuesta
    }

    public function getUsuario_info(string $usuario, string $clave) //Obtener info from control de Usuarios
    {
        $sql = "SELECT p.*, l.id as id_localidad, l.localidad, g.id as id_gerencia, g.gerencia, d.id as id_departamento, d.departamento FROM 
                control_usuarios.personal p INNER JOIN control_usuarios.localidad l ON p.localidad_id = l.id INNER JOIN control_usuarios.gerencia g ON p.gerencia_id = g.id INNER JOIN 
                control_usuarios.departamentos d ON p.departamento_id = d.id WHERE num_empleado='$usuario' AND password='$clave'"; //Cremaos Query de consulta
                
        $data = $this->select($sql); //Mandamos la consulta al Select y la duardamos en una variable al metodo
        return $data; // Retornamos la respuesta
    }
    
    /*====================================================================== FUNCIONES =========================================================================*/
    /*==========================================================================================================================================================*/
    /*==========================================================================================================================================================*/
}
