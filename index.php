<?php
require 'Config/Config.php';
$ruta = !empty($_GET['url']) ? $_GET['url'] : "Home/index"; //Validar si el usuaro ingreso una url
$array = explode("/", $ruta); //array ce Controlador/Metodo/parametros
$controller = $array[0];
$metodo = "index"; //Metodo por default
$parametro = ""; //Parametro por default
if (!empty($array[1])) {
    if (!empty($array[1] != "")) {
        $metodo = $array[1]; //Si el url trae metodo entonces lo guardamos
    }
}

if (!empty($array[2])) {  //Evaluar Si existen parametros
    if (!empty($array[2] != "")) {
        for ($i = 2; $i < count($array); $i++) { //Recorrer cada uno de los parametros mandados en el url
            $parametro .= $array[$i] . ",";
        }
        $parametro = trim($parametro, ",");
    }
}

require_once "Config/App/autoload.php";

$dirController = "Controllers/" . $controller . ".php"; //Crear ruta al controlador
if (file_exists($dirController)) { //Evaluar si eciste el controlador
    require "Controllers/" . $controller . ".php"; //Jalamos el controlador
    $controller = new $controller(); //Creamos instancia del controlador
    if (method_exists($controller, $metodo)) { //Verificamos si el metodo existe
        $controller->$metodo($parametro);
    } else {
        echo "No existe el metodo";
    }
} else {
    echo "No existe el controlador";
}
