<?php
class Home extends Controller
{
    public function __construct()
    {
        session_start();
        if (!empty($_SESSION['activo_plantas_fijas'])) {
            header("location: ". base_url . "Plantas");
        }
        parent::__construct();
    }
    public function index()
    {
        $this->views->getView($this, "index");
    }
}
