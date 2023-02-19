    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Control de Platas</title>
        <link rel="shortcut icon" href="<?php echo base_url ?>Assets/img/favicon.ico">
        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- IonIcons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- DataTables -->
        <link rel="stylesheet" href="<?php echo base_url ?>Assets/js/datatables/datatables-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="<?php echo base_url ?>Assets/js/datatables/datatables-responsive/css/responsive.bootstrap4.min.css">
        <link rel="stylesheet" href="<?php echo base_url ?>Assets/js/datatables/datatables-buttons/css/buttons.bootstrap4.min.css">
        <!-- Hoja de Estilos css-->
        <link rel="stylesheet" href="<?php echo base_url ?>Assets/css/style/style.min.css">
        <link rel="stylesheet" href="<?php echo base_url ?>Assets/css/style/css.css">
        <!--Font Awsome-->
        <script src="<?php echo base_url ?>Assets/js/fontawesome/all.min.js" crossorigin="anonymous"></script>
    </head>

    <body class="hold-transition sidebar-mini text-sm layout-footer-fixed">
        <div class="wrapper">
            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-grey-dark" style="background: #212529; ">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" role="button" style="color: white;"><i class="fas fa-bars"></i></a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="<?php echo base_url; ?>Perfil" class="nav-link" style="color: white;">Operacion y Mantenimiento - OYM</a>
                    </li>
                </ul>

                <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                            <i class="fas fa-expand-arrows-alt" style="color: white;"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                            <i class="fas fa-th-large" style="color: white;"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" title="Logout" data-slide="true" href="<?php echo base_url; ?>Usuarios/salir" role="button">
                            <i class="fa-solid fa-power-off"></i>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary" style="background-color: #dadadb;">
                <!-- Brand Logo -->
                <a href="<?php echo base_url; ?>Perfil" class="brand-link">
                    <img src="<?php echo base_url ?>/Assets/img/5G.jpg" class="brand-image img-circle elevation-3" style="opacity: .8;">
                    <img src="<?php echo base_url ?>/Assets/img/logo_telcel2_azul.png" class="brand-text font-weight-light" style="opacity: .8">
                </a>

                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- Sidebar user panel (optional) -->
                    <div class="user-panel m-2 d-flex">
                        <div class="info">
                            <p style="color: black;"><i class="fa-regular fa-user"></i> - <?php echo $_SESSION['nombre_plantas_fijas'] ?></p>
                        </div>
                    </div>


                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">

                            <?php if ($_SESSION['rol_plantas_fijas'] == "admin") { ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo base_url; ?>Plantas"><i class="nav-icon fas fa-users"></i>
                                        <p>PLANTAS</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo base_url; ?>Solicitar"><i class="nav-icon fas fa-bars"></i>
                                        <p>SOLICITAR</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo base_url; ?>Autorizar"><i class="nav-icon fas fa-address-card"></i>
                                        <p>AUTORIZAR</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fa-solid fa-table-list"></i>
                                        <p>
                                            REPORTES
                                            <i class="fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="<?php echo base_url; ?>ConsumoRegional" class="nav-link">
                                                <i class="fa-solid fa-angle-right nav-icon"></i>
                                                <p>Consumo Regional</p>
                                            </a>
                                        </li>
                                    </ul>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="<?php echo base_url; ?>GastoRegional" class="nav-link">
                                                <i class="fa-solid fa-angle-right nav-icon"></i>
                                                <p>Gasto Regional</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            <?php } else if ($_SESSION['rol_plantas_fijas'] == "jefe") { ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo base_url; ?>Solicitar"><i class="nav-icon fas fa-bars"></i>
                                        <p>SOLICITAR</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo base_url; ?>Autorizar"><i class="nav-icon fas fa-address-card"></i>
                                        <p>AUTORIZAR</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fa-solid fa-table-list"></i>
                                        <p>
                                            REPORTES
                                            <i class="fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="<?php echo base_url; ?>ConsumoPorPlanta" class="nav-link">
                                                <i class="fa-solid fa-angle-right nav-icon"></i>
                                                <p>Consumo por Planta</p>
                                            </a>
                                        </li>
                                    </ul>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="<?php echo base_url; ?>GastoPorPlanta" class="nav-link">
                                                <i class="fa-solid fa-angle-right nav-icon"></i>
                                                <p>Gasto por Planta</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            <?php } else if ($_SESSION['rol_plantas_fijas'] == "radiobases") { ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo base_url; ?>Solicitar"><i class="nav-icon fas fa-address-card"></i>
                                        <p>SOLICITAR</p>
                                    </a>
                                </li>
                            <?php } else if ($_SESSION['rol_plantas_fijas'] == "developer") { ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo base_url; ?>Plantas"><i class="nav-icon fas fa-users"></i>
                                        <p>PLANTAS</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo base_url; ?>Solicitar"><i class="nav-icon fas fa-bars"></i>
                                        <p>SOLICITAR</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo base_url; ?>Autorizar"><i class="nav-icon fas fa-address-card"></i>
                                        <p>AUTORIZAR</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fa-solid fa-table-list"></i>
                                        <p>
                                            REPORTES
                                            <i class="fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="<?php echo base_url; ?>ConsumoRegional" class="nav-link">
                                                <i class="fa-solid fa-angle-right nav-icon"></i>
                                                <p>Consumo Regional</p>
                                            </a>
                                        </li>
                                    </ul>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="<?php echo base_url; ?>GastoRegional" class="nav-link">
                                                <i class="fa-solid fa-angle-right nav-icon"></i>
                                                <p>Gasto Regional</p>
                                            </a>
                                        </li>
                                    </ul>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="<?php echo base_url; ?>ConsumoPorPlanta" class="nav-link">
                                                <i class="fa-solid fa-angle-right nav-icon"></i>
                                                <p>Consumo por Planta</p>
                                            </a>
                                        </li>
                                    </ul>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="<?php echo base_url; ?>GastoPorPlanta" class="nav-link">
                                                <i class="fa-solid fa-angle-right nav-icon"></i>
                                                <p>Gasto por Planta</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo base_url; ?>Admin"><i class="nav-icon fas fa-lock"></i>
                                        <p>ADMINISTRADOR</p>
                                    </a>
                                </li>
                            <?php } else { ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo base_url; ?>Plantas"><i class="nav-icon fas fa-address-card"></i>
                                        <p>Plantas</p>
                                    </a>
                                </li>
                            <?php } ?>

                        </ul>
                    </nav>
                    <!-- /.sidebar-menu -->
                </div>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->