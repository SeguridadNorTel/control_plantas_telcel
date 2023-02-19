<?php

class Views
{
    public function getView($controlador, $vista, $data = "") //Generar classe vista resive dor parametros
    {
        $controlador = get_class($controlador);
        if ($controlador == "Home") {
            $vista = "Views/" . $vista . ".php";
        } else {
            $vista = "Views/" . $controlador . "/" . $vista . ".php";
        }
        require $vista;
    }
}
