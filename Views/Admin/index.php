<?php include "Views/Templates/header.php"; ?>
<!--Incluimos la Vista Header-->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><strong>Vista Administrador</strong></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#"><strong>Home</strong></a></li>
                    <li class="breadcrumb-item active"><strong>Adminsitrasdor</strong></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="card-title" style="color: black;">Tabla de Plantas</h3>
                            </div>
                            <div class="col-md-6">
                                <select id="tab_bitacora" class="form-control-sm float-right" name="tab_bitacora">
                                    <option value="BITACORA_OPERACION_ADMIN">BITACORA OPERACION</option>
                                    <option value="BITACORA_MTTO_ADMIN">BITACORA MANTENIMIENTO</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="tab_tblBOperacion" style="display: block;">
                            <table class="table table-striped table-bordered" id="tblBOperacion">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>N.Economico</th>
                                        <th>Departamento</th>
                                        <th>Inicio</th>
                                        <th>Final</th>
                                        <th>Sitio</th>
                                        <th>Motivo</th>
                                        <th>Solicito</th>
                                        <th>Responsable</th>
                                        <th>Estatus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>

                        <div id="tab_tblBMantenimiento" style="display: none;">
                            <table class="table table-striped table-bordered" id="tblBMantenimiento">
                                <thead>
                                    <tr class="thead-dark">
                                        <th>N.Economico</th>
                                        <th>Departamento</th>
                                        <th>Inicio</th>
                                        <th>Final</th>
                                        <th>Tipo</th>
                                        <th>Motivo</th>
                                        <th>Solicito</th>
                                        <th>Responsable</th>
                                        <th>Estatus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</div>
<?php include "Views/Templates/footer.php"; ?>
<!--Incluimos la Vista Footer-->