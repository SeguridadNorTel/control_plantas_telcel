<?php include "Views/Templates/header.php"; ?>
<!--Incluimos la Vista Header-->

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><strong>Solicitar</strong></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#"><strong>Home</strong></a></li>
                    <li class="breadcrumb-item active"><strong>Solicitar</strong></li>
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
                                <select id="tab_solicitar" class="form-control-sm float-right" name="tab_solicitar">
                                    <option value="SOLICITAR" selected>SOLICITAR</option>
                                    <option value="BITACORA_OPERACION">BITACORA OPERACION</option>
                                    <option value="BITACORA_MANTENIMIENTO">BITACORA MANTENIMIENTO</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <!--TABLA OPERACION-->
                        <div id="tabla_solicitar" style="display: block;">
                            <table class="table table-striped table-bordered" id="tblSolicitar">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>No.Economico</th>
                                        <th>Tipo</th>
                                        <th>Departamento</th>
                                        <th>Responsable</th>
                                        <th>Sitio</th>
                                        <th>Localidad</th>
                                        <th>Mantenimiento</th>
                                        <th>Estatus</th>
                                        <th style="width: 50px;"></th>
                                    </tr>
                                </thead>
                                <tbody style="font-size: 10px;">
                                </tbody>
                            </table>
                        </div>
                        <!--TABLA BITACORA OPERACION-->
                        <div id="tabla_bitacora_operacion" style="display: none;">
                            <table class="table table-striped table-bordered" id="tblSolicitar_bitacora_operacion">
                                <thead>
                                    <tr class="thead-dark">
                                        <th>No.Economico</th>
                                        <th>Tipo</th>
                                        <th>Sitio</th>
                                        <th>Motivo</th>
                                        <th>F.Registro</th>
                                        <th>Solicita</th>
                                        <th>Responsable</th>
                                        <th>Estatus</th>
                                        <th style="width: 65px;"></th>
                                    </tr>
                                </thead>
                                <tbody style="font-size: 11px;">
                                </tbody>
                            </table>
                        </div>

                        <!--TABLA BITACORA MANTENIMIENTO-->
                        <div id="tabla_bitacora_mantenimiento" style="display: none;">
                            <table class="table table-striped table-bordered" id="tblSolicitar_bitacora_mantenimiento">
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
                                        <th style="width: 20px;"></th>
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

<!--------------------------------------------------------------------------------------MODAL SOLICITUD OPERACION-------------------------------------------------------------------------------------->
<div id="nuevo_operacion" class="modal fade">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #030215;">
                <h5 class="modal-title" id="title_operacion" id="my-modal-title" style="color: white;">Solicitud Operacion</h5>
                <button type="button" class="close text-white" data-dismiss="modal"  aria-label="Close" onclick="cerrarModalOperacion();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="frmOperacion">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-general" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div id="info-general">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group m-2">
                                            <input type="hidden" id="id_operacion" name="id_operacion">
                                            <input type="hidden" id="id_responsable_operacion" name="id_responsable_operacion">
                                            <label for="no_economico_operacion" style="font-weight: bold;">Numero Economico</label>
                                            <input id="no_economico_operacion" class="form-control form-control-sm" type="text" style="text-transform: uppercase;" readonly="readonly" name="no_economico_operacion" placeholder="...">
                                        </div>
                                        <div class="form-group m-2">
                                            <label for="sitio_operacion" style="font-weight: bold;">Sitio</label>
                                            <input id="sitio_operacion" class="form-control form-control-sm" type="text" name="sitio_operacion" style="text-transform: uppercase;" placeholder="...">
                                        </div>

                                        <div class="form-group m-2">
                                            <label for="motivo_operacion" style="font-weight: bold;">Motivo</label>
                                            <input id="motivo_operacion" class="form-control form-control-sm" type="text" name="motivo_operacion" maxlength="40" style="text-transform: uppercase;" placeholder="...">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group m-2">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label for="f_inicio_operacion" style="font-weight: bold;">Fecha Inicio</label>
                                                    <input id="f_inicio_operacion" type="date" class="form-control form-control-sm" name="f_inicio_operacion" placeholder="...">
                                                </div>
                                                <div class="col-6">
                                                    <label for="hora_inicio_operacion" style="font-weight: bold;">Hora Inicio</label>
                                                    <input id="hora_inicio_operacion" type="time" class="form-control form-control-sm" name="hora_inicio_operacion" placeholder="...">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group m-2">
                                            <label for="lts_actual_operacion" style="font-weight: bold;">Lts Actual</label>
                                            <select id="lts_actual_operacion" class="form-control form-control-sm" name="lts_actual_operacion" readonly="readonly" >
                                                <option value="0" selected>0%</option>
                                                <option value="25">25%</option>
                                                <option value="50">50%</option>
                                                <option value="75">75%</option>
                                                <option value="100">100%</option>
                                            </select>
                                        </div>
                                        <div class="form-group m-2">
                                            <label for="f_mantenimiento_operacion" style="font-weight: bold;">Fecha Mantenimiento</label>
                                            <input id="f_mantenimiento_operacion" class="form-control form-control-sm" type="date" name="f_mantenimiento_operacion" readonly="readonly" placeholder="...">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="text-center">
                        <button class="btn btn-primary" style="margin-right: 10px;" id="btnAccion_operacion" type="button" onclick="registrarOperacion(event)">Solicitar</button>
                        <button class="btn btn-danger" data-dismiss="modal" aria-label="Close" type="button" onclick="cerrarModalOperacion();">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--------------------------------------------------------------------------------------MODAL SOLICITUD OPERACION-------------------------------------------------------------------------------------->


<!--------------------------------------------------------------------------------------MODAL FINALIZAR OPERACION----------------------------------------------------------------------------------->
<div id="finalizar_operacion" class="modal fade">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #030215;">
                <h5 class="modal-title" id="title_finalizar_operacion" id="my-modal-title" style="color: white;">Finalizar Operacion</h5>
                <button type="button" class="close text-white" data-dismiss="modal"  aria-label="Close" onclick="cerrarModalFinalizarOperacion();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="frmFinalizarOperacion">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-general" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div id="info-general">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group m-2">
                                            <input type="hidden" id="id_finalizar_planta" name="id_finalizar_planta">
                                            <input type="hidden" id="id_finalizar_operacion" name="id_finalizar_operacion">
                                            <input type="hidden" id="tiempo_operando_operacion" name="tiempo_operando_operacion">
                                            <label for="no_economico_f_operacion" style="font-weight: bold;">Numero Economico</label>
                                            <input id="no_economico_f_operacion" class="form-control form-control-sm" type="text" style="text-transform: uppercase;" readonly="readonly" name="no_economico_f_operacion" placeholder="...">
                                        </div>
                                        <div class="form-group m-2">
                                            <label for="f_inicio_f_operacion" style="font-weight: bold;">Fecha Inicio</label>
                                            <input id="f_inicio_f_operacion" type="datetime" value="2018-02-25T19:24:23" class="form-control form-control-sm" name="f_inicio_f_operacion" readonly="readonly" placeholder="...">
                                        </div>
                                        <div class="form-group m-2">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label for="f_final_f_operacion" style="font-weight: bold;">Fecha Final</label>
                                                    <input id="f_final_f_operacion" type="date" class="form-control form-control-sm" name="f_final_f_operacion" placeholder="...">
                                                </div>
                                                <div class="col-6">
                                                    <label for="hora_final_f_operacion">Hora Final</label>
                                                    <input id="hora_final_f_operacion" type="time" class="form-control form-control-sm" name="hora_final_f_operacion" placeholder="...">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group m-2">
                                            <label for="lts_actual_f_operacion" style="font-weight: bold;">Lts Actual</label>
                                            <select id="lts_actual_f_operacion" class="form-control form-control-sm" name="lts_actual_f_operacion" readonly="readonly" aria-disabled="true">
                                                <option value="0" selected>0%</option>
                                                <option value="25">25%</option>
                                                <option value="50">50%</option>
                                                <option value="75">75%</option>
                                                <option value="100">100%</option>
                                            </select>
                                        </div>
                                        <div class="form-group m-2">
                                            <label for="lts_final_f_operacion" style="font-weight: bold;">Lts Final</label>
                                            <select id="lts_final_f_operacion" class="form-control form-control-sm" name="lts_final_f_operacion">
                                                <option value="0" selected>0%</option>
                                                <option value="25">25%</option>
                                                <option value="50">50%</option>
                                                <option value="75">75%</option>
                                                <option value="100">100%</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group m-2">
                                            <label for="cargo_combustible_f_operacion" style="font-weight: bold;">Cargo Combustible</label>
                                            <select id="cargo_combustible_f_operacion" class="form-control form-control-sm" name="cargo_combustible_f_operacion">
                                                <option value="0" selected>NO</option>
                                                <option value="1">SI</option>
                                            </select>
                                        </div>
                                        <div class="form-group m-2">
                                            <label for="importe_combustible_f_operacion" style="font-weight: bold;">Importe Combustible (Lts)</label>
                                            <input id="importe_combustible_f_operacion" class="form-control form-control-sm" type="number" min="0" name="importe_combustible_f_operacion" readonly="readonly" placeholder="...">
                                        </div>
                                        <div class="form-group m-2">
                                            <label for="precio_combustible_f_operacion" style="font-weight: bold;">Precio Combustible</label>
                                            <input id="precio_combustible_f_operacion" class="form-control form-control-sm" type="number" min="0" name="precio_combustible_f_operacion" readonly="readonly" placeholder="...">
                                        </div>
                                        <div class="form-group m-2">
                                            <label for="comentarios_f_operacion" style="font-weight: bold;">Comentarios</label>
                                            <input id="comentarios_f_operacion" class="form-control form-control-sm" type="text" name="comentarios_f_operacion" style="text-transform: uppercase;" placeholder="...">
                                        </div>
                                        <div class="form-group m-2">
                                            <label for="f_mantenimiento_f_operacion" style="font-weight: bold;">Fecha Mantenimiento</label>
                                            <input id="f_mantenimiento_f_operacion" class="form-control form-control-sm" type="date" name="f_mantenimiento_f_operacion" readonly="readonly" placeholder="...">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="text-center">
                        <button class="btn btn-primary" style="margin-right: 10px;" id="btnAccion_f_operacion" type="button" onclick="finalizarOperacion(event)">Finalizar</button>
                        <button class="btn btn-danger" data-dismiss="modal" aria-label="Close" type="button" onclick="cerrarModalFinalizarOperacion();">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--------------------------------------------------------------------------------------MODAL FINALIZAR OPERACION----------------------------------------------------------------------------------->


<!--------------------------------------------------------------------------------------MODAL SOLICITUD MANTENIMIENTO-------------------------------------------------------------------------------------->
<div id="nuevo_mantenimiento" class="modal fade">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #030215;">
                <h5 class="modal-title" id="title_mantenimiento" id="my-modal-title" style="color: white;">Solicitud Mantenimiento</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" onclick="cerrarModalMantenimiento();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="frmMantenimiento">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-general" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div id="info-general">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group m-2">
                                            <input type="hidden" id="id_mantenimiento" name="id_mantenimiento">
                                            <input type="hidden" id="id_responsable_mantenimiento" name="id_responsable_mantenimiento">
                                            <label for="no_economico_mantenimiento" style="font-weight: bold;">Numero Economico</label>
                                            <input id="no_economico_mantenimiento" class="form-control form-control-sm" type="text" style="text-transform: uppercase;" readonly="readonly" name="no_economico_mantenimiento" placeholder="...">
                                        </div>
                                        <div class="form-group m-2">
                                            <label for="tipo_mantenimiento" style="font-weight: bold;">Tipo de Mantenimiento</label>
                                            <select id="tipo_mantenimiento" class="form-control form-control-sm" name="tipo_mantenimiento">
                                                <option value="" selected>No</option>
                                                <option value="PREVENTIVO">PREVENTIVO</option>
                                                <option value="CORRECTIVO">CORRECTIVO</option>
                                            </select>
                                        </div>
                                        <div class="form-group m-2">
                                            <label for="motivo_mantenimiento" style="font-weight: bold;">Motivo</label>
                                            <input id="motivo_mantenimiento" class="form-control form-control-sm" type="text" name="motivo_mantenimiento" placeholder="...">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group m-2">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label for="f_inicio_mantenimiento" style="font-weight: bold;">Fecha de Inicio</label>
                                                    <input id="f_inicio_mantenimiento" class="form-control form-control-sm" type="date" name="f_inicio_mantenimiento" placeholder="...">
                                                </div>
                                                <div class="col-6">
                                                    <label for="hora_inicio_mantenimiento" style="font-weight: bold;">Hora de Inicio</label>
                                                    <input id="hora_inicio_mantenimiento" class="form-control form-control-sm" type="time" name="hora_inicio_mantenimiento" placeholder="...">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group m-2">
                                            <label for="lts_actual_mantenimiento" style="font-weight: bold;">Lts Actual</label>
                                            <select id="lts_actual_mantenimiento" class="form-control form-control-sm" name="lts_actual_mantenimiento" readonly="readonly" aria-disabled="true">
                                                <option value="0" selected>0%</option>
                                                <option value="25">25%</option>
                                                <option value="50">50%</option>
                                                <option value="75">75%</option>
                                                <option value="100">100%</option>
                                            </select>
                                        </div>
                                        <div class="form-group m-2">
                                            <label for="f_mantenimiento_mantenimiento" style="font-weight: bold;">Fecha Mantenimiento</label>
                                            <input id="f_mantenimiento_mantenimiento" class="form-control form-control-sm" type="date" name="f_mantenimiento_mantenimiento" readonly="readonly" placeholder="...">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="text-center">
                        <button class="btn btn-primary" style="margin-right: 10px;" id="btnAccion_mantenimiento" type="button" onclick="registrarMantenimiento(event)">Solicitar</button>
                        <button class="btn btn-danger" data-dismiss="modal" aria-label="Close" type="button" onclick="cerrarModalMantenimiento();">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--------------------------------------------------------------------------------------MODAL SOLICITUD MANTENIMIENTO----------------------------------------------------------------------------------->


<!--------------------------------------------------------------------------------------MODAL FINALIZAR MANTENIMIENTO-------------------------------------------------------------------------------------->
<div id="finalizar_mantenimiento" class="modal fade">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #030215;">
                <h5 class="modal-title" id="title_finalizar_mantenimiento" id="my-modal-title" style="color: white;">Finalizar Mantenimiento</h5>
                <button type="button" class="close text-white" data-dismiss="modal"  aria-label="Close" onclick="cerrarModalFinalizarMantenimiento();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="frmFinalizarMantenimiento">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-general" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div id="info-general">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group m-2">
                                            <input type="hidden" id="id_planta_finalizar_mantenimiento" name="id_planta_finalizar_mantenimiento">
                                            <input type="hidden" id="id_finalizar_mantenimiento" name="id_finalizar_mantenimiento">
                                            <label for="no_economico_f_mantenimiento" style="font-weight: bold;">Numero Economico</label>
                                            <input id="no_economico_f_mantenimiento" class="form-control form-control-sm" type="text" style="text-transform: uppercase;" readonly="readonly" name="no_economico_f_mantenimiento" placeholder="...">
                                        </div>
                                        <div class="form-group m-2" id="div_tipo_mantenimiento">
                                            <label for="tipo_mantenimiento_finalizar" style="font-weight: bold;">Tipo de Mantenimiento</label>
                                            <select id="tipo_mantenimiento_finalizar" class="form-control form-control-sm" readonly="readonly" aria-disabled="true" name="tipo_mantenimiento_finalizar">
                                                <option value="" selected>No</option>
                                                <option value="PREVENTIVO">PREVENTIVO</option>
                                                <option value="CORRECTIVO">CORRECTIVO</option>
                                            </select>
                                        </div>
                                        <div class="form-group m-2">
                                            <label for="motivo_f_mantenimiento" style="font-weight: bold;">Motivo</label>
                                            <input id="motivo_f_mantenimiento" class="form-control form-control-sm" type="text" name="motivo_f_mantenimiento" style="text-transform: uppercase;" readonly="readonly" placeholder="...">
                                        </div>
                                        <div class="form-group m-2">
                                            <label for="f_inicio_f_mantenimiento" style="font-weight: bold;">Fecha Inicio</label>
                                            <input id="f_inicio_f_mantenimiento" type="datetime" class="form-control form-control-sm" name="f_inicio_f_mantenimiento" readonly="readonly" placeholder="...">
                                        </div>
                                        <div class="form-group m-2">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label for="f_final_f_mantenimiento" style="font-weight: bold;">Fecha Final</label>
                                                    <input id="f_final_f_mantenimiento" type="date" class="form-control form-control-sm" name="f_final_f_mantenimiento" placeholder="...">
                                                </div>
                                                <div class="col-6">
                                                    <label for="hora_final_f_mantenimiento" style="font-weight: bold;">Hora Final</label>
                                                    <input id="hora_final_f_mantenimiento" type="time" class="form-control form-control-sm" name="hora_final_f_mantenimiento" placeholder="...">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="form-group m-2">
                                            <label for="lts_actual_f_mantenimiento" style="font-weight: bold;">Lts Actual</label>
                                            <select id="lts_actual_f_mantenimiento" class="form-control form-control-sm" name="lts_actual_f_mantenimiento" readonly="readonly" aria-disabled="true">
                                                <option value="0" selected>0%</option>
                                                <option value="25">25%</option>
                                                <option value="50">50%</option>
                                                <option value="75">75%</option>
                                                <option value="100">100%</option>
                                            </select>
                                        </div>
                                        <div class="form-group m-2">
                                            <label for="lts_final_f_mantenimiento" style="font-weight: bold;">Lts Final</label>
                                            <select id="lts_final_f_mantenimiento" class="form-control form-control-sm" name="lts_final_f_mantenimiento">
                                                <option value="0" selected>0%</option>
                                                <option value="25">25%</option>
                                                <option value="50">50%</option>
                                                <option value="75">75%</option>
                                                <option value="100">100%</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group m-2">
                                            <label for="tipo_planta_mantenimiento" style="font-weight: bold;">Tipo de Planta</label>
                                            <select id="tipo_planta_mantenimiento" class="form-control form-control-sm" readonly="readonly" aria-disabled="true" name="tipo_planta_mantenimiento">
                                                <option value="FIJA">FIJA</option>
                                                <option value="MOVIL">MOVIL</option>
                                                <option value="PORTATIL">PORTATIL</option>
                                            </select>
                                        </div>
                                        <div class="form-group m-2">
                                            <label for="cargo_combustible_f_mantenimiento" style="font-weight: bold;">Cargo Combustible</label>
                                            <select id="cargo_combustible_f_mantenimiento" class="form-control form-control-sm" name="cargo_combustible_f_mantenimiento">
                                                <option value="0" selected>NO</option>
                                                <option value="1">SI</option>
                                            </select>
                                        </div>
                                        <div class="form-group m-2">
                                            <label for="importe_combustible_f_mantenimiento" style="font-weight: bold;">Importe Combustible</label>
                                            <input id="importe_combustible_f_mantenimiento" class="form-control form-control-sm" type="number" min="0" name="importe_combustible_f_mantenimiento" readonly="readonly" placeholder="...">
                                        </div>
                                        <div class="form-group m-2">
                                            <label for="precio_combustible_f_mantenimiento" style="font-weight: bold;">Precio Combustible</label>
                                            <input id="precio_combustible_f_mantenimiento" class="form-control form-control-sm" type="text" name="precio_combustible_f_mantenimiento" style="text-transform: uppercase;" readonly="readonly" placeholder="...">
                                        </div>
                                        <div class="form-group m-2">
                                            <label for="cargo_correctivo_f_mantenimiento" style="font-weight: bold;">Cargo Correctivo</label>
                                            <select id="cargo_correctivo_f_mantenimiento" class="form-control form-control-sm" name="cargo_correctivo_f_mantenimiento">
                                                <option value="0" selected>NO</option>
                                                <option value="1">SI</option>
                                            </select>
                                        </div>
                                        <div class="form-group m-2">
                                            <label for="descripcion_correctivo_f_mantenimiento" style="font-weight: bold;">Descripcion Correctivo</label>
                                            <input id="descripcion_correctivo_f_mantenimiento" class="form-control form-control-sm" type="text" name="descripcion_correctivo_f_mantenimiento" readonly="readonly" style="text-transform: uppercase;" placeholder="...">
                                        </div>
                                        <div class="form-group m-2">
                                            <label for="importe_correctivo_f_mantenimiento" style="font-weight: bold;">Importe Correctivo</label>
                                            <input id="importe_correctivo_f_mantenimiento" class="form-control form-control-sm" type="number" min="0" name="importe_correctivo_f_mantenimiento" readonly="readonly" placeholder="...">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group m-2">
                                            <label for="cargo_preventivo_f_mantenimiento" style="font-weight: bold;">Cargo Preventivo</label>
                                            <select id="cargo_preventivo_f_mantenimiento" class="form-control form-control-sm" name="cargo_preventivo_f_mantenimiento">
                                                <option value="0" selected>NO</option>
                                                <option value="1">SI</option>
                                            </select>
                                        </div>
                                        <div class="form-group m-2">
                                            <label for="descripcion_preventivo_f_mantenimiento" style="font-weight: bold;">Descripcion Preventivo</label>
                                            <input id="descripcion_preventivo_f_mantenimiento" class="form-control form-control-sm" type="text" name="descripcion_preventivo_f_mantenimiento" readonly="readonly" style="text-transform: uppercase;" placeholder="...">
                                        </div>
                                        <div class="form-group m-2">
                                            <label for="importe_preventivo_f_mantenimiento" style="font-weight: bold;">Importe Preventivo</label>
                                            <input id="importe_preventivo_f_mantenimiento" class="form-control form-control-sm" type="number" min="0" name="importe_preventivo_f_mantenimiento" readonly="readonly" placeholder="...">
                                        </div>
                                        <div class="form-group m-2">
                                            <label for="comentarios_f_mantenimiento" style="font-weight: bold;">Comentarios</label>
                                            <input id="comentarios_f_mantenimiento" class="form-control form-control-sm" type="text" name="comentarios_f_mantenimiento" style="text-transform: uppercase;" placeholder="...">
                                        </div>
                                        <div class="form-group m-2">
                                            <label for="f_mantenimiento_f_mantenimiento" style="font-weight: bold;">Fecha Mantenimiento</label>
                                            <input id="f_mantenimiento_f_mantenimiento" class="form-control form-control-sm" type="date" name="f_mantenimiento_f_mantenimiento" readonly="readonly" placeholder="...">
                                        </div>
                                        <div class="form-group m-2" id="div_prox_mantenimiento">
                                            <label for="f_prox_mantenimiento_f_mantenimiento" style="font-weight: bold;">Proximo Mantenimiento</label>
                                            <input id="f_prox_mantenimiento_f_mantenimiento" class="form-control form-control-sm" type="date" name="f_prox_mantenimiento_f_mantenimiento" readonly="readonly" placeholder="...">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="text-center">
                        <button class="btn btn-primary" style="margin-right: 10px;" id="btnAccion_f_mantenimiento" type="button" onclick="finalizarMantenimiento(event)">Finalizar</button>
                        <button class="btn btn-danger" data-dismiss="modal" aria-label="Close" type="button" onclick="cerrarModalFinalizarMantenimiento();">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include "Views/Templates/footer.php"; ?>
<!--Incluimos la Vista Footer-->