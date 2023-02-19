<?php
class Controller
{

    public function __construct()
    {
        $this->views = new Views();
        $this->cargarModel();
    }

    public function cargarModel()
    {
        $model = get_class($this) . "Model"; // Obtener classe de modelo
        $ruta = "Models/" . $model . ".php"; //generar ruta del modelo
        if (file_exists($ruta)) {
            require_once $ruta;
            $this->model = new $model();
        }
    }
}
