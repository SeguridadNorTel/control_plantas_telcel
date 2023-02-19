<?php include "Views/Templates/header.php"; ?>
<!--Incluimos la Vista Header-->

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><strong>Autorizacion</strong></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#"><strong>Home</strong></a></li>
                    <li class="breadcrumb-item active"><strong>Autorizacion</strong></li>
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
                                <h3 class="card-title" style="color: black;">Autotizar</h3>
                            </div>
                            <div class="col-md-6">
                                <select id="tab_autorizar" class="form-control-sm float-right" name="tab_autorizar">
                                    <option value="A_OPERACION" selected>OPERACION</option>
                                    <option value="A_MTTO">MANTENIMIENTO</option>
                                    <option value="A_BITACORA_OPERACION">BITACORA OPERACION</option>
                                    <option value="A_BITACORA_MTTO">BITACORA MANTENIMIENTO</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="test" id="tabla_autorizar_operacion" style="display: block;">
                            <table class="table table-striped table-bordered" id="tblAutorizar_operacion">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>No.Economico</th>
                                        <th>Tipo</th>
                                        <th>Sitio</th>
                                        <th>Motivo</th>
                                        <th>F.Registro</th>
                                        <th>Solicito</th>
                                        <th>Responsable</th>
                                        <th>Estatus</th>
                                        <th style="width: 95px;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody style="font-size: 11px;">
                                </tbody>
                            </table>
                        </div>

                        <div class="test" id="tabla_autorizar_mantenimiento" style="display: none;">
                            <table class="table table-striped table-bordered" id="tblAutorizar_mantenimiento">
                                <thead>
                                    <tr class="thead-dark">
                                        <th>No.Economico</th>
                                        <th>Tipo</th>
                                        <th>Sitio</th>
                                        <th>Motivo</th>
                                        <th>F.Registro</th>
                                        <th>Solicito</th>
                                        <th>Responsable</th>
                                        <th>Estatus</th>
                                        <th style="width: 95px;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody style="font-size: 11px;">
                                </tbody>
                            </table>
                        </div>

                        <div class="test" id="tabla_autorizar_bitacora_operacion" style="display: none;">
                            <table class="table table-striped table-bordered" id="tblAutorizar_bitacora_operacion">
                                <thead>
                                    <tr class="thead-dark">
                                        <th>No.Economico</th>
                                        <th>Tipo</th>
                                        <th>Sitio</th>
                                        <th>Motivo</th>
                                        <th>F.Registro</th>
                                        <th>Solicito</th>
                                        <th>Responsable</th>
                                        <th>Estatus</th>
                                    </tr>
                                </thead>
                                <tbody style="font-size: 11px;">
                                </tbody>
                            </table>
                        </div>

                        <div class="test" id="tabla_autorizar_bitacora_mantenimiento" style="display: none;">
                            <table class="table table-striped table-bordered" id="tblAutorizar_bitacora_mantenimiento">
                                <thead>
                                    <tr class="thead-dark">
                                        <th>No.Economico</th>
                                        <th>Tipo</th>
                                        <th>Mantenimiento</th>
                                        <th>Motivo</th>
                                        <th>F.Registro</th>
                                        <th>Solicito</th>
                                        <th>Responsable</th>
                                        <th>Estatus</th>
                                    </tr>
                                </thead>
                                <tbody style="font-size: 11px;">
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->


<?php include "Views/Templates/footer.php"; ?>
<!--Incluimos la Vista Footer-->