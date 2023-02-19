<?php include "Views/Templates/header.php"; ?>
<!--Incluimos la Vista Header-->

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><strong>Control Plantas</strong></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#"  style="color: black;"><strong>Home</strong></a></li>
                    <li class="breadcrumb-item active"><strong>Plantas</strong></li>
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
                <div class="card" >
                    <div class="card-header" >
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title" style="color: black;"><strong>Tabla de Plantas</strong></h3> 
                            <button class="btn btn-dark btn-sm float-end" type="button" onclick="frmPlanta();" title="Nuevo Registro">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped" id="tblPlantas">
                            <thead>
                                <tr class="thead-dark">
                                    <th>No.Economico</th>
                                    <th>Tipo</th>
                                    <th>Departamento</th>
                                    <th>Responsable</th>
                                    <th>Sitio</th>
                                    <th>Localidad</th>
                                    <th>Mantenimiento</th>
                                    <th>Estatus</th>
                                    <th style="width: 95px;">Acciones</th>
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
    <!-- /.container-fluid -->
</div>

<!--modal Nueva Planta-->
<div id="nuevo_planta" class="modal fade">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #030215">
                <h5 class="modal-title" id="title" id="title" style="color: white;">Nueva Planta</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" onclick="cerrarModalPlanta();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="frmPlanta">

                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-general" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div id="info-general">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group m-2">
                                            <input type="hidden" id="id" name="id">
                                            <label for="no_economico">Numero Economico</label>
                                            <input id="no_economico" class="form-control form-control-sm" type="text" style="text-transform: uppercase;" name="no_economico" placeholder="...">
                                        </div>
                                        <div class="form-group m-2">
                                            <label for="tipo">Tipo</label>
                                            <select id="tipo" class="form-control form-control-sm" name="tipo">
                                                <option value="" selected>No</option>
                                                <option value="FIJA">FIJA</option>
                                                <option value="MOVIL">MOVIL</option>
                                                <option value="PORTATIL">PORTATIL</option>
                                            </select>
                                        </div>
                                        <div class="form-group m-2">
                                            <label for="placas">Placas</label>
                                            <input id="placas" class="form-control form-control-sm" type="text" name="placas" style="text-transform: uppercase;" readonly="readonly" placeholder="NA">
                                        </div>

                                        <div class="form-group m-2">
                                            <label for="marca">Marca</label>
                                            <input id="marca" class="form-control form-control-sm" type="text" name="marca" placeholder="...">
                                        </div>
                                        <div class="form-group m-2">
                                            <label for="modelo">Modelo</label>
                                            <input id="modelo" class="form-control form-control-sm" type="text" name="modelo" placeholder="...">
                                        </div>

                                        <div class="form-group m-2">
                                            <label for="no_serie">Numero de Serie</label>
                                            <input id="no_serie" class="form-control form-control-sm" type="text" name="no_serie" placeholder="...">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group m-2">
                                            <label for="departamento_id">Departamento</label>
                                            <select id="departamento_id" class="form-control form-control-sm" name="departamento_id">
                                                <option value="" selected>No</option>
                                                <?php foreach ($data['departamentos_lista'] as $row) { ?>
                                                    <option value="<?php echo $row['id'] ?>"><?php echo $row['departamento'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group m-2">
                                            <label for="localidad_id">Localidad</label>
                                            <select id="localidad_id" class="form-control form-control-sm" name="localidad_id">
                                                <option value="" selected>No</option>
                                                <?php foreach ($data['localidades_lista'] as $row) { ?>
                                                    <option value="<?php echo $row['id'] ?>"><?php echo $row['localidad'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group m-2">
                                            <label for="gerencia_id">Gerencia</label>
                                            <select id="gerencia_id" class="form-control form-control-sm" name="gerencia_id">
                                                <option value="" selected>No</option>
                                                <?php foreach ($data['gerencias_lista'] as $row) { ?>
                                                    <option value="<?php echo $row['id'] ?>"><?php echo $row['gerencia'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group m-2">
                                            <label for="responsable_id">Responsable</label>
                                            <select id="responsable_id" class="form-control form-control-sm" name="responsable_id">
                                                <option value="" selected>No</option>
                                                <?php foreach ($data['admin_lista'] as $row) { ?>
                                                    <option value="<?php echo $row['id_personal'] ?>"><?php echo $row['nombre'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group m-2">
                                            <label for="capacidad_kw">Capacidad Kw</label>
                                            <input id="capacidad_kw" class="form-control form-control-sm" type="number" name="capacidad_kw" placeholder="...">
                                        </div>
                                        <div class="form-group m-2">
                                            <label for="capacidad_lts">Capacidad Lts</label>
                                            <input id="capacidad_lts" class="form-control form-control-sm" type="number" name="capacidad_lts" placeholder="...">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group m-2">
                                            <label for="nombre_sitio">Nombre del Sitio</label>
                                            <input id="nombre_sitio" class="form-control form-control-sm" type="text" name="nombre_sitio" readonly="readonly" placeholder="NA">
                                        </div>
                                        <div class="form-group m-2">
                                            <label for="lts_actual">LTS Actual</label>
                                            <select id="lts_actual" class="form-control form-control-sm" name="lts_actual">
                                                <option value="0" selected>0%</option>
                                                <option value="25">25%</option>
                                                <option value="50">50%</option>
                                                <option value="75">75%</option>
                                                <option value="100">100%</option>
                                            </select>
                                        </div>
                                        <div class="form-group m-2">
                                            <label for="f_mantenimiento">Fecha Mantenimiento</label>
                                            <input id="f_mantenimiento" class="form-control form-control-sm" type="date" name="f_mantenimiento">
                                        </div>
                                        <div class="form-group m-2">
                                            <label for="comentarios">Comentarios</label>
                                            <input id="comentarios" class="form-control form-control-sm" type="text" name="comentarios" placeholder="...">
                                        </div>
                                        <div class="form-group m-2">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="combustible_id">Tipo Combustible</label>
                                                    <select id="combustible_id" class="form-control form-control-sm" name="combustible_id">
                                                        <?php foreach ($data['combustible'] as $row) { ?>
                                                            <option value="<?php echo $row['id'] ?>"><?php echo $row['combustible'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="horometro">Horometro</label>
                                                    <input id="horometro" class="form-control form-control-sm" type="number" min="0" name="horometro" placeholder="NA">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group m-2">
                                            <div class="row">
                                                <div class="col-9">
                                                    <div class="form-group m-2">
                                                        <label for="ip">IP</label>
                                                        <input id="ip" class="form-control form-control-sm" type="text" name="ip" readonly="readonly" placeholder="NA">
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="form-group m-2">
                                                        <button type="button" id="btn_Conect" style="margin-top: 32px; float:right" onclick="conectarPlantaIp();" title="Conectar" disabled class="btn btn-dark"><i class="fa-solid fa-bolt"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="text-center">
                        <button class="btn btn-primary" style="margin-right: 10px;" id="btnAccion" type="button" onclick="registrarPlanta(event)">Registrar</button>
                        <button class="btn btn-danger" data-dismiss="modal" aria-label="Close" type="button" onclick="cerrarModalPlanta();">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--modal Nueva Planta-->

<?php include "Views/Templates/footer.php"; ?>
<!--Incluimos la Vista Footer-->