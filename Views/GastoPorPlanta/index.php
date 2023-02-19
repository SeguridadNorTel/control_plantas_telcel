<?php include "Views/Templates/header.php"; ?>
<!--Incluimos la Vista Header-->

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><strong>Gasto por Planta</strong></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#"><strong>Home</strong></a></li>
                    <li class="breadcrumb-item active"><strong>Gasto por Planta</strong></li>
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
                            <div class="col-md-4 mb-1">
                                <div class="row">
                                    <div class="col-md-4">
                                        <h3 class="card-title mt-1" style="color: black;">Gasto Total</h3>
                                    </div>
                                    <div class="col-md-8">
                                        <button class="btn btn-light btn-sm float-end" type="button" onclick="buscar_GPP();" title="Buscar"><i class="fas fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <form class="form-inline float-right">
                                    <div class="form-group">
                                        <select id="tab_GPP_tipo" class="form-control-sm float-right" name="tab_GPP_tipo">
                                            <option value="0" selected>ANUAL</option>
                                            <option value="1">MENSUAL</option>
                                            <option value="2">FECHAS</option>
                                        </select>
                                    </div>
                                    <div class="form-group ml-3">
                                        <select id="tab_GPP_departamento_id" class="form-control-sm float-right" name="tab_GPP_departamento_id">
                                            <option value="todos" selected>TODOS</option>
                                            <?php foreach ($data['departamentos_lista'] as $row) { ?>
                                                <option value="<?php echo $row['id'] ?>"><?php echo $row['departamento'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group mx-sm-3">
                                        <div id="tab_GPP_periodo" style="display: block;">
                                            <select id="GPP_periodo" class="form-control-sm float-right" name="GPP_periodo">
                                                <option value="0" selected>ACTUAL</option>
                                                <option value="1">ANTERIOR</option>
                                            </select>
                                        </div>
                                        <div id="tab_GPP_rango_fechas" style="display: none;">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col">
                                                                <input id="tab_GPP_desde" type="date" class="form-control form-control-sm" value="<?php echo date("Y-m-d") ?>" name="tab_CGP_desde" placeholder="...">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col">
                                                                <input id="tab_GPP_hasta" type="date" class="form-control form-control-sm" value="<?php echo date("Y-m-d") ?>" name="tab_GPP_hasta" paceholder="...">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered" id="tblGPPlanta">
                            <thead>
                                <tr class="thead-dark">
                                    <th>No.Economico</th>
                                    <th>Departamento</th>
                                    <th>Tipo</th>
                                    <th>Total GAS</th>
                                    <th>Gasto GAS</th>
                                    <th>Importe Correctivo</th>
                                    <th>Importe Preventivo</th>
                                    <th>Preventivos</th>
                                    <th>Correctivos</th>
                                    <th>Gasto Total</th>
                                </tr>
                            </thead>
                            <tbody style="font-size: 11px;">
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th style="text-align:right">Total:</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </tfoot>

                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->


<?php include "Views/Templates/footer.php"; ?>
<!--Incluimos la Vista Footer-->