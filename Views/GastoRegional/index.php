<?php include "Views/Templates/header.php"; ?>
<!--Incluimos la Vista Header-->

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><strong>Gasto Regional</strong></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#"><strong>Home</strong></a></li>
                    <li class="breadcrumb-item active"><strong>Gasto Regional</strong></li>
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
                    <div class="card-header" ">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4">
                                        <h3 class="card-title mt-1" style="color: dask;">Gasto Total</h3>
                                    </div>
                                    <div class="col-md-8">
                                        <button class="btn btn-light btn-sm float-left" type="button" onclick="buscar_GR();" title="Buscar"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <form class="form-inline float-right">
                                    <div class="form-group">
                                        <select id="tab_GR_tipo" class="form-control-sm float-right" name="tab_GR_tipo">
                                            <option value="0" selected>ANUAL</option>
                                            <option value="1">MENSUAL</option>
                                            <option value="2">FECHAS</option>
                                        </select>
                                    </div>
                                    <div class="form-group mx-sm-3">
                                        <div id="periodo" style="display: block;">
                                            <select id="tab_GR_periodo" class="form-control-sm float-right" name="tab_GR_periodo">
                                                <option value="0" selected>ACTUAL</option>
                                                <option value="1">ANTERIOR</option>
                                            </select>
                                        </div>
                                        <div id="rango_fechas" style="display: none;">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col">
                                                                <input id="GR_desde" type="date" class="form-control form-control-sm" value="<?php echo date("Y-m-d") ?>" name="GR_desde" placeholder="...">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col">
                                                                <input id="GR_hasta" type="date" class="form-control form-control-sm" value="<?php echo date("Y-m-d") ?>" name="GR_hasta" paceholder="...">
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
                        <table class="table table-striped table-bordered" id="tblGRegional">
                            <thead>
                                <tr class="thead-dark">
                                    <th>Region</th>
                                    <th>GAS</th>
                                    <th>$-GAS</th>
                                    <th>$-Correctivo</th>
                                    <th>$-PREVENTIVO</th>
                                    <th>Preventivos</th>
                                    <th>Correctivos</th>
                                    <th>Total</th>
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