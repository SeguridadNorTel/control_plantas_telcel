<?php include "Views/Templates/header.php"; ?>
<!--Incluimos la Vista Header-->

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><strong>Consumo por Planta</strong></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#"><strong>Home</strong></a></li>
                    <li class="breadcrumb-item active"><strong>Consumo por Planta</strong></li>
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
                                    <div class="col-md-5">
                                        <h3 class="card-title mt-1" style="color: black;">Consumo Total</h3>
                                    </div>
                                    <div class="col-md-7">
                                        <button class="btn btn-dark btn-sm float-end" type="button" onclick="buscar_CPP();" title="Buscar"><i class="fas fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <form class="form-inline float-right">
                                    <div class="form-group">
                                        <select id="tab_CPP_tipo" class="form-control-sm float-right" name="tab_CPP_tipo">
                                            <option value="0" selected>ANUAL</option>
                                            <option value="1">MENSUAL</option>
                                            <option value="2">FECHAS</option>
                                        </select>
                                    </div>
                                    <div class="form-group ml-3">
                                        <select id="tab_CPP_departamento_id" class="form-control-sm float-right" name="tab_CPP_departamento_id">
                                            <option value="todos" selected>TODOS</option>
                                            <?php foreach ($data['departamentos_lista'] as $row) { ?>
                                                <option value="<?php echo $row['id'] ?>"><?php echo $row['departamento'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group mx-sm-3">
                                        <div id="tab_CPP_periodo" style="display: block;">
                                            <div class="form-group">
                                                <select id="CPP_periodo" class="form-control-sm float-right" name="CPP_periodo">
                                                    <option value="0" selected>ACTUAL</option>
                                                    <option value="1">ANTERIOR</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div id="tab_CPP_rango_fechas" style="display: none;">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col">
                                                                <input id="tab_CPP_desde" type="date" class="form-control form-control-sm" value="<?php echo date("Y-m-d") ?>" name="tab_CPP_desde" placeholder="...">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col">
                                                                <input id="tab_CPP_hasta" type="date" class="form-control form-control-sm" value="<?php echo date("Y-m-d") ?>" name="tab_CPP_hasta" paceholder="...">
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
                        
                        <table class="table table-striped table-bordered" id="tblCPPlanta">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No.Economico</th>
                                    <th>Departamento</th>
                                    <th>Tipo</th>
                                    <th>Operando (Hrs)</th>
                                    <th>Gasto Operacion</th>
                                    <th>Carga.Gas (Lts)</th>
                                    <th>Importe.Gas</th>
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