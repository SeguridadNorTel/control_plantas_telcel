//===================================================================================================================================================================//
//================================================================== APP-PLANTAS CONTROLLER=========================================================================//
let tblPlantas; //Tabla de Usuarios
document.addEventListener('DOMContentLoaded', function () {
    tblPlantas = $('#tblPlantas').DataTable({ //Declaramos el Id de la tabla de Usuarios
        ajax: {
            url: base_url + "Plantas/listar",
            dataSrc: ''
        },
        "rowCallback": function (row, data, index) {
            if (data.true_mantenimiento == true) {
                $(row).css('background', '#FFD7D7'); //Dar estilo a la fila basado en un valor
            }
        },
        dom: 'lBfrtip', "responsive": true, "lengthChange": true, "autoWidth": false,
        columns: [
            {
                'data': 'no_economico',
            },
            {
                'data': 'tipo',
            },
            {
                'data': 'departamento',
            },
            {
                'data': 'responsable',
            },
            {
                'data': 'nombre_sitio',
            },
            {
                'data': 'localidad'
            },
            {
                'data': 'f_mantenimiento'
            },
            {
                'data': 'estatus'
            },
            {
                'data': 'acciones'
            }
        ],
    });
});

$('#tipo').on('change', function () { //-------Funcion change seleccionando tipo de planta-------//
    var tipo = document.getElementById('tipo');
    switch (tipo.value) {
        case 'FIJA':
            document.getElementById('nombre_sitio').readOnly = false; //Habilitando el campo read only nombre sitio
            document.getElementById('ip').readOnly = false; //Habilitando el campo read only nombre sitio
            document.getElementById("btn_Conect").disabled = false;

            document.getElementById('placas').readOnly = true; //Poner en ReadOnly Placas ya que solo las moviles llevan este dato
            document.getElementById('placas').value = ''; //Limpiar el valor de el input Placas
            break;
        case 'MOVIL':
            document.getElementById('placas').readOnly = false; //Habilitando el campo read only placas

            document.getElementById('nombre_sitio').readOnly = true; //Poner en ReadOnly nombre del sitio ya que solo las Fijas llevan este dato
            document.getElementById('nombre_sitio').value = ''; //Limpiar el valor de el input Placas
            document.getElementById('ip').readOnly = true; //Habilitando el campo read only nombre sitio
            document.getElementById('ip').value = ''; //Limpiar el valor de el input Placas
            document.getElementById("btn_Conect").disabled = true;
            break;
        default:
            document.getElementById('placas').readOnly = true; //Poner en ReadOnly Placas ya que solo las moviles llevan este dato
            document.getElementById('placas').value = ''; //Limpiar el valor de el input Placas

            document.getElementById('nombre_sitio').readOnly = true; //Poner en ReadOnly nombre del sitio ya que solo las Fijas llevan este dato
            document.getElementById('nombre_sitio').value = ''; //Limpiar el valor de el input Placas
            document.getElementById('ip').readOnly = true; //Habilitando el campo read only nombre sitio
            document.getElementById('ip').value = ''; //Limpiar el valor de el input Placas
            document.getElementById("btn_Conect").disabled = true;
            break;
    }
});

function registrarPlanta(e) { //----------------Funcion Registrar Usuario Nuevo--------------------//
    e.preventDefault(); //Prevenir la recarga

    var campos_obligatorios = false; //Creamos la variable campos obligatorios

    const no_economico = document.getElementById("no_economico"); //Tomamos el elemento de la por medio del ID
    const tipo = document.getElementById("tipo"); //Tomamos el elemento de la por medio del ID
    const marca = document.getElementById("marca"); //Tomamos el elemento de la por medio del ID
    const modelo = document.getElementById("modelo"); //Tomamos el elemento de la por medio del ID
    const no_serie = document.getElementById("no_serie"); //Tomamos el elemento de la por medio del ID
    const departamento_id = document.getElementById("departamento_id"); //Tomamos el elemento de la por medio del ID
    const localidad_id = document.getElementById("localidad_id"); //Tomamos el elemento de la por medio del ID
    const gerencia_id = document.getElementById("gerencia_id"); //Tomamos el elemento de la por medio del ID
    const responsable_id = document.getElementById("responsable_id"); //Tomamos el elemento de la por medio del ID
    const capacidad_kw = document.getElementById("capacidad_kw"); //Tomamos el elemento de la por medio del ID
    const capacidad_lts = document.getElementById("capacidad_lts"); //Tomamos el elemento de la por medio del ID
    const lts_actual = document.getElementById("lts_actual"); //Tomamos el elemento de la por medio del ID
    const f_mantenimiento = document.getElementById("f_mantenimiento"); //Tomamos el elemento de la por medio del ID\
    const nombre_sitio = document.getElementById("nombre_sitio"); //Tomamos el elemento de la por medio del ID
    const placas = document.getElementById("placas"); //Tomamos el elemento de la por medio del ID
    const horometro = document.getElementById("horometro"); //Tomamos el elemento de la por medio del ID
    const ip = document.getElementById("ip"); //Tomamos el elemento de la por medio del ID

    if (no_economico.value == "" | tipo.value == "" | marca.value == "" | modelo.value == "" | no_serie.value == "" | departamento_id.value == "" |
        localidad_id.value == "" | gerencia_id.value == "" | responsable_id.value == "" | capacidad_kw.value == "" | capacidad_lts.value == "" |
        f_mantenimiento.value == "" || horometro.value == "") { //Se evaluan que todos los campos esten llenos

        campos_obligatorios = true;
    }

    if (!document.querySelector("#nombre_sitio").readOnly) {  //Validamos si el imput nombre sitio esta activo y verificamos que tenga valor
        if (nombre_sitio.value == "") {
            campos_obligatorios = true;
        }
    }

    if (!document.querySelector("#placas").readOnly) { //Validamos si el imput placas esta activo y verificamos que tenga valor
        if (placas.value == "") {
            campos_obligatorios = true;
        }
    }

    if (!document.querySelector("#ip").readOnly) { //Validamos si el imput placas esta activo y verificamos que tenga valor
        if (ip.value == "") {
            campos_obligatorios = true;
        }
    }

    if (campos_obligatorios == true) { //Evaluamos Si al usuario le faltan llenar campos obligatorios
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'error',
            title: 'Faltan Campos Obligatorios' //Mensaje de campos obligatorios
        })

        campos_obligatorios = false;

    } else {

        const url = base_url + "Plantas/registrar"; // Construimos la base URL del CONTROLADOR
        const frm = document.getElementById("frmPlanta"); // Seleccionamos el contenido del formulario
        const http = new XMLHttpRequest(); //Creamos una instancia de HTTPRequest
        http.open("POST", url, true); //Seleccionamos el metodo y mandamos la url
        http.send(new FormData(frm)); //Enviamos todo el formulario 
        http.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) { //si la peticion se ejecuta correctamente

                console.log(this.responseText);

                const res = JSON.parse(this.responseText);

                if (res == "si") { //Si el usuario fue guardado correctamente mandamos un swal alert
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'success',
                        title: 'Planta Registrada' //Mensaje de usuario registrado
                    })

                    frm.reset();
                    $("#nuevo_planta").modal("hide");
                    document.getElementById('nombre_sitio').readOnly = true; //Habilitando el campo read only nombre sitio
                    document.getElementById('placas').readOnly = true; //Habilitando el campo read only placas
                    document.getElementById('ip').readOnly = true; //Habilitando el campo read only nombre sitio
                    document.getElementById("btn_Conect").disabled = true;
                    tblPlantas.ajax.reload();

                } else if (res == "modificado") { //Evaluamos el al guardar el usuario hubo algun error
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'success',
                        title: 'Planta Modificada'
                    })

                    tblPlantas.ajax.reload();


                } else {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'error',
                        title: res
                    })
                }
            } else if (this.status == 400) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'error',
                    title: "Error"
                })
            }
        }

    }
}

function btnEditarPlanta(id) { //---------------------Funcion Editar usuario------------------------//
    const url = base_url + "Plantas/editar/" + id; // Construimos la base URL del CONTROLADOR
    const http = new XMLHttpRequest(); //Creamos una instancia de HTTPRequest
    http.open("GET", url, true); //Seleccionamos el metodo y mandamos la url
    http.send(); //Enviamos todo el formulario 
    http.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) { //si la peticion se ejecuta correctamente

            const res = JSON.parse(this.responseText); //Guardamos la respuesta de la peticion POST

            document.getElementById("id").value = res.id; //Obtener valor del usuario a actualizar
            document.getElementById("no_economico").value = res.no_economico; //Obtener valor del usuario a actualizar
            document.getElementById("tipo").value = res.tipo; //Obtener valor del usuario a actualizar
            document.getElementById("marca").value = res.marca; //Obtener valor del usuario a actualizar
            document.getElementById("modelo").value = res.modelo; //Obtener valor del usuario a actualizar
            document.getElementById("no_serie").value = res.no_serie; //Obtener valor del usuario a actualizar
            document.getElementById("departamento_id").value = res.departamento_id; //Obtener valor del usuario a actualizar
            document.getElementById("localidad_id").value = res.localidad_id; //Obtener valor del usuario a actualizar
            document.getElementById("gerencia_id").value = res.gerencia_id; //Obtener valor del usuario a actualizar
            document.getElementById("responsable_id").value = res.responsable_id; //Obtener valor del usuario a actualizar
            document.getElementById("capacidad_kw").value = res.capacidad_kw; //Obtener valor del usuario a actualizar
            document.getElementById("capacidad_lts").value = res.capacidad_lts; //Obtener valor del usuario a actualizar
            document.getElementById("lts_actual").value = res.lts_actual; //Obtener valor del usuario a actualizar
            document.getElementById("f_mantenimiento").value = res.f_mantenimiento; //Obtener valor del usuario a actualizar
            document.getElementById("comentarios").value = res.comentarios; //Obtener valor del usuario a actualizar
            document.getElementById("nombre_sitio").value = res.nombre_sitio; //Obtener valor del usuario a actualizar
            document.getElementById("placas").value = res.placas; //Obtener valor del usuario a actualizar
            document.getElementById("combustible_id").value = res.combustible_id; //Obtener valor del usuario a actualizar
            document.getElementById("horometro").value = res.horometro; //Obtener valor del usuario a actualizar
            document.getElementById("ip").value = res.ip; //Obtener valor del usuario a actualizar


            if (res.tipo == 'FIJA') {
                document.getElementById('nombre_sitio').readOnly = false; //Habilitando el campo read only nombre sitio
                document.getElementById('ip').readOnly = false; //Habilitando el campo read only nombre sitio
                document.getElementById("btn_Conect").disabled = false;
            }

            if (res.tipo == 'MOVIL') {
                document.getElementById('placas').readOnly = false; //Habilitando el campo read only placas
            }

        } else if (this.status == 400) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'error',
                title: "Error"
            })
        }
    }

    document.getElementById("title").innerHTML = "Actualizar Planta"; //Poner titulo al modal
    document.getElementById("btnAccion").innerHTML = "Actualizar"; //Poner titulo al boton


    $('#nuevo_planta').modal({ //Evitar cierre del modal por click outsite
        backdrop: 'static',
        keyboard: false
    });
    $("#nuevo_planta").modal("show");


}

function btnEliminarPlanta(id, estatus) { //---------------------Funcion Eliminar usuario----------------------//
    if (estatus != 'DISPONIBLE') {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'error',
            title: "No Disponible"
        })
    } else {
        Swal.fire({
            title: `Eliminar Planta`,
            text: "La Planta no se eliminara de forma permanente, solo cambiara a inactivo!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si!',
            cancelButtonText: "No"
        }).then((result) => {
            if (result.isConfirmed) {

                const url = base_url + "Plantas/eliminar/" + id; // Construimos la base URL del CONTROLADOR
                const http = new XMLHttpRequest(); //Creamos una instancia de HTTPRequest
                http.open("GET", url, true); //Seleccionamos el metodo y mandamos la url
                http.send(); //Enviamos todo el formulario 
                http.onreadystatechange = function () {

                    if (this.readyState == 4 && this.status == 200) { //si la peticion se ejecuta correctamente
                        const res = JSON.parse(this.responseText);
                        if (res == "ok") {
                            Swal.fire(
                                'Mensaje!',
                                'Planta Eliminada Correctamente',
                                'success'
                            )
                            tblPlantas.ajax.reload();
                        } else {
                            Swal.fire(
                                'Mensaje!',
                                res,
                                'error'
                            )
                        }
                    }
                }
            }
        })
    }
}

function btnReingresarPlanta(id, estatus) { //---------------------Funcion Reingresar usuario--------------------//
    if (estatus == 'OPERANDO' || estatus == 'MANTENIMIENTO') {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'error',
            title: "No Disponible"
        })
    } else {
        Swal.fire({
            title: `Reingresar Planta?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si!',
            cancelButtonText: "No"
        }).then((result) => {
            if (result.isConfirmed) {

                const url = base_url + "Plantas/reingresar/" + id; // Construimos la base URL del CONTROLADOR
                const http = new XMLHttpRequest(); //Creamos una instancia de HTTPRequest
                http.open("GET", url, true); //Seleccionamos el metodo y mandamos la url
                http.send(); //Enviamos todo el formulario 
                http.onreadystatechange = function () {

                    if (this.readyState == 4 && this.status == 200) { //si la peticion se ejecuta correctamente
                        const res = JSON.parse(this.responseText);
                        if (res == "ok") {
                            Swal.fire(
                                'Mensaje!',
                                'Planta Reingresada Correctamente',
                                'success'
                            )
                            tblPlantas.ajax.reload();
                        } else {
                            Swal.fire(
                                'Mensaje!',
                                res,
                                'error'
                            )
                        }
                    }
                }
            }
        })
    }
}

function frmPlanta() { //----------------Abrir Modal Registrar Nuevo Planta-----------------//
    document.getElementById("title").innerHTML = "Nueva Planta"; //Poner titulo al modal
    document.getElementById("btnAccion").innerHTML = "Registrar"; //Poner titulo al boton
    document.getElementById("frmPlanta").reset();
    $('#nuevo_planta').modal({ //Evitar cierre del modal por click outsite
        backdrop: 'static',
        keyboard: false
    });
    $("#nuevo_planta").modal("show");
    document.getElementById("id").value = "";
}

function cerrarModalPlanta() { //----------------------Funcion Cerrar Modal------------------------//
    document.getElementById("frmPlanta").reset(); //Resetear Formulario al cerral el modal
    document.getElementById("id").value = ""; //Igualar id a ""
    document.getElementById('nombre_sitio').readOnly = true; //Habilitando el campo read only nombre sitio
    document.getElementById('placas').readOnly = true; //Habilitando el campo read only placas
    document.getElementById('ip').readOnly = true; //Habilitando el campo read only nombre sitio
    document.getElementById("btn_Conect").disabled = true;
}

function conectarPlantaIp() {
    const ip = document.getElementById("ip"); //Tomamos el elemento de la por medio del ID

    if (ip.value == "" || ip.value == "NA") {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'error',
            title: 'IP no registrada'
        })
    } else {
        window.open('http://' + ip.value);
    }

}
//================================================================== APP-PLANTAS CONTROLLER=========================================================================//
//===================================================================================================================================================================//

//===================================================================================================================================================================//
//================================================================== APP-SOLICITAR CONTROLLER=========================================================================//
//*****************************SECCION SOLICITAR************************************/
let tblSolicitar; //Tabla Solicitar - Solicitar
document.addEventListener('DOMContentLoaded', function () {
    tblSolicitar = $('#tblSolicitar').DataTable({ //Declaramos el Id de la tabla de Usuarios
        ajax: {
            url: base_url + "Solicitar/listar_solicitar",
            dataSrc: ''
        },
        dom: 'lBfrtip', "responsive": true, "lengthChange": true, "autoWidth": false,
        columns: [
            {
                'data': 'no_economico',
            },
            {
                'data': 'tipo',
            },
            {
                'data': 'departamento',
            },
            {
                'data': 'responsable',
            },
            {
                'data': 'nombre_sitio',
            },
            {
                'data': 'localidad'
            },
            {
                'data': 'f_mantenimiento'
            },
            {
                'data': 'estatus'
            },
            {
                'data': 'acciones'
            }
        ],
    });
});

$('#tab_solicitar').on('change', function () { //-------Funcion change seleccionando tipo de solicitud-------//
    var tipo = document.getElementById('tab_solicitar');
    switch (tipo.value) {
        case 'SOLICITAR':
            //MOSTRAR
            document.getElementById('tabla_solicitar').style.display = 'block'; //Mostrar div Solicitar

            //OCULTAR
            document.getElementById('tabla_bitacora_operacion').style.display = 'none'; //Ocultar div OPERACION
            document.getElementById('tabla_bitacora_mantenimiento').style.display = 'none'; //Ocultar div OPERACION
            break;
        case 'BITACORA_OPERACION':
            //MOSTRAR
            document.getElementById('tabla_bitacora_operacion').style.display = 'block'; //Mostrar div Bitacora Operacion

            //OCULTAR
            document.getElementById('tabla_solicitar').style.display = 'none'; //Ocultar div OPERACION
            document.getElementById('tabla_bitacora_mantenimiento').style.display = 'none'; //Ocultar div OPERACION
            break;
        case 'BITACORA_MANTENIMIENTO':
            //MOSTRAR
            document.getElementById('tabla_bitacora_mantenimiento').style.display = 'block'; //Mostrar div Bitacor Mantenimiento

            //OCULTAR
            document.getElementById('tabla_solicitar').style.display = 'none'; //Ocultar div OPERACION
            document.getElementById('tabla_bitacora_operacion').style.display = 'none'; //Ocultar div OPERACION
            break;
        default:
            console.log('Mostrar operacion');
            break;
    }
});

function frmOperacion(id, estatus) { //----------Abrir Modal Registrar Nuevo Operacion----------//

    if (estatus == 'DISPONIBLE') {
        const url = base_url + "Solicitar/GetInfo/" + id; // Construimos la base URL del CONTROLADOR
        const http = new XMLHttpRequest(); //Creamos una instancia de HTTPRequest
        http.open("GET", url, true); //Seleccionamos el metodo y mandamos la url
        http.send(); //Enviamos todo el formulario 
        http.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) { //si la peticion se ejecuta correctamente

                const res = JSON.parse(this.responseText); //Guardamos la respuesta de la peticion POST

                document.getElementById("id_operacion").value = res.id; //Obtener valor del id operacion
                document.getElementById("id_responsable_operacion").value = res.responsable_id; //Obtener valor del id responsable 
                document.getElementById("no_economico_operacion").value = res.no_economico; //Obtener valor del no economico
                document.getElementById("lts_actual_operacion").value = res.lts_actual; //Obtener valor del lts actual
                document.getElementById("f_mantenimiento_operacion").value = res.f_mantenimiento; //Obtener valor del f mantenimiento 

            } else if (this.status == 400) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'error',
                    title: "Error"
                })
            }
        }

        document.getElementById("title_operacion").innerHTML = "Solicitud Operacion"; //Poner titulo al modal
        document.getElementById("btnAccion_operacion").innerHTML = "Solicitar"; //Poner titulo al boton
        document.getElementById("frmOperacion").reset();
        $('#nuevo_operacion').modal({ //Evitar cierre del modal por click outsite
            backdrop: 'static',
            keyboard: false
        });
        $("#nuevo_operacion").modal("show");
        document.getElementById("id_operacion").value = id;
    } else {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'error',
            title: "No Disponible"
        })
    }
}

function registrarOperacion(e) { //----------Funcion Registrar Nuevo Operacion----------//
    e.preventDefault();

    const id = document.getElementById('id_operacion'); //Obtenemos el valor por medio del id
    const sitio = document.getElementById('sitio_operacion'); //Obtenemos el valor por medio del id
    const motivo = document.getElementById('motivo_operacion'); //Obtenemos el valor por medio del id
    const fecha_inicio = document.getElementById('f_inicio_operacion'); //Obtenemos el valor por medio del id
    const hora_inicio = document.getElementById('hora_inicio_operacion'); //Obtenemos el valor por medio del id

    if (id.value == "" | sitio.value == "" | motivo.value == "" | fecha_inicio.value == "" | hora_inicio.value == "") { //Evaluamos los campos obligatorios
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'error',
            title: 'Faltan Campos Obligatorios' //Mensaje de campos obligatorios
        })
    } else {
        const url = base_url + "Solicitar/solicitar_operacion"; // Construimos la base URL del CONTROLADOR
        const frm = document.getElementById("frmOperacion"); // Seleccionamos el contenido del formulario
        const http = new XMLHttpRequest(); //Creamos una instancia de HTTPRequest
        http.open("POST", url, true); //Seleccionamos el metodo y mandamos la url
        http.send(new FormData(frm)); //Enviamos todo el formulario 
        http.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) { //si la peticion se ejecuta correctamente

                console.log(this.responseText);

                const res = JSON.parse(this.responseText);

                if (res == "si") { //Si el regostro fue guardado correctamente mandamos un swal alert
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'success',
                        title: 'Solicitud Registrada' //Mensaje de que la solicitud fue registrada
                    })

                    frm.reset();
                    $("#nuevo_operacion").modal("hide");
                    tblSolicitar.ajax.reload();
                    tblSolicitar_bitacora_operacion.ajax.reload();

                } else {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'error',
                        title: res
                    })
                }
            } else if (this.status == 400) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'error',
                    title: "Error"
                })
            }
        }
    }
}

function cerrarModalOperacion() { //----------------------Funcion Cerrar Modal------------------------//
    document.getElementById("frmOperacion").reset(); //Resetear Formulario al cerral el modal
    document.getElementById("id_operacion").value = ""; //Igualar id a ""
}

function frmMantenimiento(id, estatus) { //-----------Abrir Modal Registrar Nuevo Mantenimiento---------//

    if (estatus == 'DISPONIBLE') {
        const url = base_url + "Solicitar/GetInfo/" + id; // Construimos la base URL del CONTROLADOR
        const http = new XMLHttpRequest(); //Creamos una instancia de HTTPRequest
        http.open("GET", url, true); //Seleccionamos el metodo y mandamos la url
        http.send(); //Enviamos todo el formulario 
        http.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) { //si la peticion se ejecuta correctamente

                const res = JSON.parse(this.responseText); //Guardamos la respuesta de la peticion POST

                document.getElementById("id_mantenimiento").value = res.id; //Obtener valor del id a actualizar
                document.getElementById("id_responsable_mantenimiento").value = res.responsable_id; //Obtener valor del id responsable
                document.getElementById("no_economico_mantenimiento").value = res.no_economico; //Obtener valor del no economico
                document.getElementById("lts_actual_mantenimiento").value = res.lts_actual; //Obtener valor del lts actual
                document.getElementById("f_mantenimiento_mantenimiento").value = res.f_mantenimiento; //Obtener valor del mantenimiento

            } else if (this.status == 400) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'error',
                    title: "Error"
                })
            }
        }

        document.getElementById("title_mantenimiento").innerHTML = "Solicitud Mantenimiento"; //Poner titulo al modal
        document.getElementById("btnAccion_mantenimiento").innerHTML = "Solicitar"; //Poner titulo al boton
        document.getElementById("frmMantenimiento").reset();
        $('#nuevo_mantenimiento').modal({ //Evitar cierre del modal por click outsite
            backdrop: 'static',
            keyboard: false
        });
        $("#nuevo_mantenimiento").modal("show");
        document.getElementById("id_mantenimiento").value = id; //guardamos el id en el input para guardarlo en la tabla de solicitud en id planta

    } else {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'error',
            title: "No Disponible"
        })
    }


}

function registrarMantenimiento(e) {  //----------Funcion Registrar Nuevo Mantenimiento----------//
    e.preventDefault();

    const id = document.getElementById('id_mantenimiento'); //Obtenemos el elemenro por medio del id
    const tipo_mantenimiento = document.getElementById('tipo_mantenimiento'); //Obtenemos el elemenro por medio del id
    const motivo = document.getElementById('motivo_mantenimiento'); //Obtenemos el elemenro por medio del id
    const fecha_inicio = document.getElementById('f_inicio_mantenimiento'); //Obtenemos el elemenro por medio del id
    const hora_inicio = document.getElementById('hora_inicio_mantenimiento'); //Obtenemos el elemenro por medio del id

    if (id.value == "" | tipo_mantenimiento.value == "" | motivo.value == "" | fecha_inicio.value == "" | hora_inicio.value == "") { //Evaluamos los campos obligatorios
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'error',
            title: 'Faltan Campos Obligatorios' //Mensaje de campos obligatorios
        })
    } else {
        const url = base_url + "Solicitar/solicitar_mantenimiento"; // Construimos la base URL del CONTROLADOR
        const frm = document.getElementById("frmMantenimiento"); // Seleccionamos el contenido del formulario
        const http = new XMLHttpRequest(); //Creamos una instancia de HTTPRequest
        http.open("POST", url, true); //Seleccionamos el metodo y mandamos la url
        http.send(new FormData(frm)); //Enviamos todo el formulario 
        http.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) { //si la peticion se ejecuta correctamente

                console.log(this.responseText);

                const res = JSON.parse(this.responseText);

                if (res == "si") { //Si el registro fue guardado correctamente mandamos un swal alert
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'success',
                        title: 'Solicitud Registrada' //Mensaje de solicitud registrada
                    })

                    frm.reset();
                    $("#nuevo_mantenimiento").modal("hide");
                    tblSolicitar.ajax.reload(); //Recargar tabla solicitar
                    tblSolicitar_bitacora_mantenimiento.ajax.reload(); //Recargar tabla bitacor amantenimiento

                } else {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'error',
                        title: res
                    })
                }
            } else if (this.status == 400) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'error',
                    title: "Error"
                })
            }
        }
    }
}

function cerrarModalMantenimiento() { //----------------------Funcion Cerrar Modal------------------------//
    document.getElementById("frmMantenimiento").reset(); //Resetear Formulario al cerral el modal
    document.getElementById("id_mantenimiento").value = ""; //Igualar id a ""
}

//*****************************SECCION SOLICITAR************************************/

//*****************************SECCION BITACORA OPERACION************************************/
let tblSolicitar_bitacora_operacion; //Tabla Solicitar - Operacion
document.addEventListener('DOMContentLoaded', function () {

    tblSolicitar_bitacora_operacion = $('#tblSolicitar_bitacora_operacion').DataTable({ //Declaramos el Id de la tabla
        ajax: {
            url: base_url + "Solicitar/listar_bitacora_operacion",
            dataSrc: ''
        },
        dom: 'lBfrtip', "responsive": true, "lengthChange": true, "autoWidth": false,
        columns: [
            {
                'data': 'no_economico',
            },
            {
                'data': 'tipo',
            },
            {
                'data': 'sitio',
            },
            {
                'data': 'motivo',
            },
            {
                'data': 'f_registro',
            },
            {
                'data': 'num_empleado_solicito'
            },
            {
                'data': 'nombre_responsable'
            },
            {
                'data': 'estatus'
            },
            {
                'data': 'acciones'
            }
        ],
    });
});

function frmEntregarOperacion(id, estatus) {
    const url = base_url + "Solicitar/GetInfoBitacoraOperacion/" + id; // Construimos la base URL del CONTROLADOR
    const http = new XMLHttpRequest(); //Creamos una instancia de HTTPRequest
    http.open("GET", url, true); //Seleccionamos el metodo y mandamos la url
    http.send(); //Enviamos todo el formulario 
    http.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) { //si la peticion se ejecuta correctamente

            const res = JSON.parse(this.responseText); //Guardamos la respuesta de la peticion POST

            document.getElementById("no_economico_f_operacion").value = res.no_economico; //Obtener valor del id a actualizar
            document.getElementById("f_inicio_f_operacion").value = res.f_inicio; //Obtener valor del id a actualizar
            document.getElementById("lts_actual_f_operacion").value = res.lts_inicial; //Obtener valor del id a actualizar
            document.getElementById("lts_final_f_operacion").value = res.lts_inicial; //Obtener valor del id a actualizar
            document.getElementById("cargo_combustible_f_operacion").value = res.cargo_combustible; //Obtener valor del id a actualizar
            document.getElementById("importe_combustible_f_operacion").value = res.importe_combustible; //Obtener valor del id a actualizar
            document.getElementById("precio_combustible_f_operacion").value = res.precio_combustible; //Obtener valor del id a actualizar
            document.getElementById("comentarios_f_operacion").value = res.comentarios; //Obtener valor del id a actualizar
            document.getElementById("f_mantenimiento_f_operacion").value = res.f_mantenimiento; //Obtener valor del id a actualizar
            document.getElementById("id_finalizar_planta").value = res.planta_id; //Obtener valor del id a actualizar
            document.getElementById("tiempo_operando_operacion").value = res.t_operando; //Obtener valor del id a actualizar
        } else if (this.status == 400) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'error',
                title: "Error"
            })
        }
    }


    document.getElementById("btnAccion_f_operacion").innerHTML = "Finalizar"; //Poner titulo al boton
    document.getElementById("frmFinalizarOperacion").reset();
    $('#finalizar_operacion').modal({ //Evitar cierre del modal por click outsite
        backdrop: 'static',
        keyboard: false
    });
    $("#finalizar_operacion").modal("show");
    document.getElementById("id_finalizar_operacion").value = id;
}

function finalizarOperacion(e) { //Abrir modal Finalizar Operacion
    e.preventDefault();
    var campos_obligatorios = false; //Creamos la variable campos obligatorios

    const f_final_f_operacion = document.getElementById("f_final_f_operacion"); //Tomamos el elemento de la por medio del ID
    const hora_final_f_operacion = document.getElementById("hora_final_f_operacion"); //Tomamos el elemento de la por medio del ID
    const comentarios_f_operacion = document.getElementById("comentarios_f_operacion"); //Tomamos el elemento de la por medio del ID

    const importe_combustible_f_operacion = document.getElementById("importe_combustible_f_operacion"); //Tomamos el elemento de la por medio del ID
    const precio_combustible_f_operacion = document.getElementById("precio_combustible_f_operacion"); //Tomamos el elemento de la por medio del ID

    if (f_final_f_operacion.value == "" | hora_final_f_operacion.value == "" | comentarios_f_operacion.value == "") { //Se evaluan que todos los campos esten llenos
        campos_obligatorios = true;
    }

    if (!document.querySelector("#importe_combustible_f_operacion").readOnly) {  //Validamos si el imput  esta activo y verificamos que tenga valor
        if (importe_combustible_f_operacion.value == "" || importe_combustible_f_operacion.value < 0) {
            campos_obligatorios = true;
        }
    }

    if (!document.querySelector("#precio_combustible_f_operacion").readOnly) { //Validamos si el imput esta activo y verificamos que tenga valor
        if (precio_combustible_f_operacion.value == "" || precio_combustible_f_operacion.value < 0) {
            campos_obligatorios = true;
        }
    }

    if (campos_obligatorios == true) { //Evaluamos Si al usuario le faltan llenar campos obligatorios
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'error',
            title: 'Faltan Campos Obligatorios' //Mensaje de campos obligatorios
        })

        campos_obligatorios = false;

    } else {
        const url = base_url + "Solicitar/finalizar_operacion"; // Construimos la base URL del CONTROLADOR
        const frm = document.getElementById("frmFinalizarOperacion"); // Seleccionamos el contenido del formulario
        const http = new XMLHttpRequest(); //Creamos una instancia de HTTPRequest
        http.open("POST", url, true); //Seleccionamos el metodo y mandamos la url
        http.send(new FormData(frm)); //Enviamos todo el formulario 
        http.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) { //si la peticion se ejecuta correctamente

                console.log(this.responseText);

                const res = JSON.parse(this.responseText);

                if (res == "si") { //Si el regostro fue guardado correctamente mandamos un swal alert

                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'success',
                        title: 'Solicitud Finalizada'
                    })

                    tblSolicitar.ajax.reload();
                    tblSolicitar_bitacora_operacion.ajax.reload(); //Volvemos a cargar la tabla de las solicitudes
                    $('#finalizar_operacion').modal('hide'); //Cerramos el modal al ejecutar correctamente la finalizacion
                    cerrarModalFinalizarOperacion(); //mandamos a llamar al metodo para limpiar los campos del modal

                } else {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'error',
                        title: res
                    })
                }
            }
        }
    }
}

function cerrarModalFinalizarOperacion() { //Cerrar modal finalizar operacion
    document.getElementById("frmFinalizarOperacion").reset(); //Resetear Formulario al cerral el modal
    document.getElementById("id_finalizar_operacion").value = ""; //Igualar id a ""
    document.getElementById('importe_combustible_f_operacion').readOnly = true;
    document.getElementById('precio_combustible_f_operacion').readOnly = true;

    document.getElementById('importe_combustible_f_operacion').value = 0;
    document.getElementById('precio_combustible_f_operacion').value = 0;
}

$('#cargo_combustible_f_operacion').on('change', function () { //-------Funcion change seleccionando tipo de solicitud-------//
    var cargo_combustible = document.getElementById('cargo_combustible_f_operacion');

    if (cargo_combustible.value == 1) {
        document.getElementById('importe_combustible_f_operacion').readOnly = false;
        document.getElementById('precio_combustible_f_operacion').readOnly = false;
    } else {
        document.getElementById('importe_combustible_f_operacion').readOnly = true;
        document.getElementById('precio_combustible_f_operacion').readOnly = true;

        document.getElementById('importe_combustible_f_operacion').value = 0;
        document.getElementById('precio_combustible_f_operacion').value = 0;
    }
});
//*****************************SECCION BITACORA OPERACION************************************/

//*****************************SECCION BITACORA MANTENIMIENTO************************************/
let tblSolicitar_bitacora_mantenimiento; //Tabla Solicitar - Mantenimiento
document.addEventListener('DOMContentLoaded', function () {
    tblSolicitar_bitacora_mantenimiento = $('#tblSolicitar_bitacora_mantenimiento').DataTable({ //Declaramos el Id de la tabla
        ajax: {
            url: base_url + "Solicitar/listar_bitacora_mantenimiento",
            dataSrc: ''
        },
        dom: 'lBfrtip', "responsive": true, "lengthChange": true, "autoWidth": false,
        columns: [
            {
                'data': 'no_economico',
            },
            {
                'data': 'tipo',
            },
            {
                'data': 'tipo_mantenimiento',
            },
            {
                'data': 'motivo',
            },
            {
                'data': 'f_registro',
            },
            {
                'data': 'num_empleado_solicito'
            },
            {
                'data': 'nombre_responsable'
            },
            {
                'data': 'estatus'
            },
            {
                'data': 'acciones'
            }
        ],
    });
});

function frmEntregarMantenimiento(id, estatus) { //Abrir modal Finalizar Mantenimiento

    const url = base_url + "Solicitar/GetInfoBitacoraMantenimiento/" + id; // Construimos la base URL del CONTROLADOR
    const http = new XMLHttpRequest(); //Creamos una instancia de HTTPRequest
    http.open("GET", url, true); //Seleccionamos el metodo y mandamos la url
    http.send(); //Enviamos todo el formulario 
    http.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) { //si la peticion se ejecuta correctamente

            const res = JSON.parse(this.responseText); //Guardamos la respuesta de la peticion POST

            document.getElementById("no_economico_f_mantenimiento").value = res.no_economico; //Obtener valor del id a actualizar
            document.getElementById("f_inicio_f_mantenimiento").value = res.f_inicio; //Obtener valor del id a actualizar
            document.getElementById("lts_actual_f_mantenimiento").value = res.lts_inicial; //Obtener valor del id a actualizar
            document.getElementById("lts_final_f_mantenimiento").value = res.lts_inicial; //Obtener valor del id a actualizar
            document.getElementById("cargo_combustible_f_mantenimiento").value = res.cargo_combustible; //Obtener valor del id a actualizar
            document.getElementById("importe_combustible_f_mantenimiento").value = res.importe_combustible; //Obtener valor del id a actualizar
            document.getElementById("precio_combustible_f_mantenimiento").value = res.precio_combustible; //Obtener valor del id a actualizar
            document.getElementById("comentarios_f_mantenimiento").value = res.comentarios; //Obtener valor del id a actualizar
            document.getElementById("cargo_correctivo_f_mantenimiento").value = res.cargo_correctivo; //Obtener valor del id a actualizar
            document.getElementById("descripcion_correctivo_f_mantenimiento").value = res.descripcion_correctivo; //Obtener valor del id a actualizar
            document.getElementById("importe_correctivo_f_mantenimiento").value = res.importe_correctivo; //Obtener valor del id a actualizar
            document.getElementById("cargo_preventivo_f_mantenimiento").value = res.cargo_correctivo; //Obtener valor del id a actualizar
            document.getElementById("descripcion_preventivo_f_mantenimiento").value = res.descripcion_correctivo; //Obtener valor del id a actualizar
            document.getElementById("importe_preventivo_f_mantenimiento").value = res.importe_correctivo; //Obtener valor del id a actualizar
            document.getElementById("motivo_f_mantenimiento").value = res.motivo; //Obtener valor del id a actualizar
            document.getElementById("f_mantenimiento_f_mantenimiento").value = res.f_mantenimiento; //Obtener valor del id a actualizar
            document.getElementById("id_planta_finalizar_mantenimiento").value = res.planta_id; //Obtener valor del id a actualizar
            document.getElementById("tipo_mantenimiento_finalizar").value = res.tipo_mantenimiento; //Obtener valor del id a actualizar
            document.getElementById("tipo_planta_mantenimiento").value = res.tipo; //Obtener valor del id a actualizar

            if (res.tipo == 'FIJA') {
                var fecha = new Date($('#f_mantenimiento_f_mantenimiento').val()); //Obtenemos el valor de la fecha actual de mantenimiento programada
                fecha.setDate(fecha.getDate() + 90); //Le sumamos la cantidad de dias sugeridos para el procciomo mantenimiento
                document.getElementById("f_prox_mantenimiento_f_mantenimiento").valueAsDate = fecha; //Asignamos el valor del nuevo mantenimiento   
            } else {
                var fecha = new Date($('#f_mantenimiento_f_mantenimiento').val()); //Obtenemos el valor de la fecha actual de mantenimiento programada
                fecha.setDate(fecha.getDate() + 60); //Le sumamos la cantidad de dias sugeridos para el procciomo mantenimiento
                document.getElementById("f_prox_mantenimiento_f_mantenimiento").valueAsDate = fecha; //Asignamos el valor del nuevo mantenimiento
            }

            if (res.tipo_mantenimiento == 'CORRECTIVO') { //Evaluamos si es preventivo o correctivo para mostrar la informacion del proximo mantenimiento
                document.getElementById("div_prox_mantenimiento").style.display = 'none'; //Mandamos a ocultar el inpur
                document.getElementById("div_tipo_mantenimiento").style.display = 'none'; //Mandamos a ocultar el inpur
            } else {
                document.getElementById("div_prox_mantenimiento").style.display = 'block'; //Mandamos a mostrar el inpur
                document.getElementById("div_tipo_mantenimiento").style.display = 'block'; //Mandamos a mostrar el inpur
            }
        } else if (this.status == 400) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'error',
                title: "Error"
            })
        }
    }

    document.getElementById("btnAccion_f_mantenimiento").innerHTML = "Finalizar"; //Poner titulo al boton
    document.getElementById("frmFinalizarMantenimiento").reset();
    $('#finalizar_mantenimiento').modal({ //Evitar cierre del modal por click outsite
        backdrop: 'static',
        keyboard: false
    });
    $("#finalizar_mantenimiento").modal("show");
    document.getElementById("id_finalizar_mantenimiento").value = id;
}

function finalizarMantenimiento(e) { // Funcion Finalizar Mantenimiento
    e.preventDefault();
    var campos_obligatorios = false; //Creamos la variable campos obligatorios

    const f_final_f_mantenimiento = document.getElementById("f_final_f_mantenimiento"); //Tomamos el elemento de la por medio del ID
    const hora_final_f_mantenimiento = document.getElementById("hora_final_f_mantenimiento"); //Tomamos el elemento de la por medio del ID
    const comentarios_f_mantenimiento = document.getElementById("comentarios_f_mantenimiento"); //Tomamos el elemento de la por medio del ID

    const importe_combustible_f_mantenimiento = document.getElementById("importe_combustible_f_mantenimiento"); //Tomamos el elemento de la por medio del ID
    const precio_combustible_f_mantenimiento = document.getElementById("precio_combustible_f_mantenimiento"); //Tomamos el elemento de la por medio del ID

    const descripcion_correctivo_f_mantenimiento = document.getElementById("descripcion_correctivo_f_mantenimiento"); //Tomamos el elemento de la por medio del ID
    const importe_correctivo_f_mantenimiento = document.getElementById("importe_correctivo_f_mantenimiento"); //Tomamos el elemento de la por medio del ID



    if (f_final_f_mantenimiento.value == "" | hora_final_f_mantenimiento.value == "" | comentarios_f_mantenimiento.value == "") { //Se evaluan que todos los campos esten llenos
        campos_obligatorios = true;
    }

    if (!document.querySelector("#importe_combustible_f_mantenimiento").readOnly) {  //Validamos si el imput nombre campo esta activo y verificamos que tenga valor
        if (importe_combustible_f_mantenimiento.value == "" || importe_combustible_f_mantenimiento.value < 0) {
            campos_obligatorios = true;
        }
    }
    if (!document.querySelector("#precio_combustible_f_mantenimiento").readOnly) { //Validamos si el imput placas esta campo y verificamos que tenga valor
        if (precio_combustible_f_mantenimiento.value == "" || precio_combustible_f_mantenimiento.value < 0) {
            campos_obligatorios = true;
        }
    }
    if (!document.querySelector("#descripcion_correctivo_f_mantenimiento").readOnly) { //Validamos si el imput placas esta campo y verificamos que tenga valor
        if (descripcion_correctivo_f_mantenimiento.value == "" || descripcion_correctivo_f_mantenimiento.value < 0) {
            campos_obligatorios = true;
        }
    }
    if (!document.querySelector("#importe_correctivo_f_mantenimiento").readOnly) { //Validamos si el imput placas esta campo y verificamos que tenga valor
        if (importe_correctivo_f_mantenimiento.value == "" || importe_correctivo_f_mantenimiento.value < 0) {
            campos_obligatorios = true;
        }
    }

    if (!document.querySelector("#descripcion_preventivo_f_mantenimiento").readOnly) { //Validamos si el imput placas esta campo y verificamos que tenga valor
        if (descripcion_preventivo_f_mantenimiento.value == "" || descripcion_preventivo_f_mantenimiento.value < 0) {
            campos_obligatorios = true;
        }
    }
    if (!document.querySelector("#importe_preventivo_f_mantenimiento").readOnly) { //Validamos si el imput placas esta campo y verificamos que tenga valor
        if (importe_preventivo_f_mantenimiento.value == "" || importe_preventivo_f_mantenimiento.value < 0) {
            campos_obligatorios = true;
        }
    }


    if (campos_obligatorios == true) { //Evaluamos Si al usuario le faltan llenar campos obligatorios
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'error',
            title: 'Faltan Campos Obligatorios' //Mensaje de campos obligatorios
        })

        campos_obligatorios = false;

    } else {
        const url = base_url + "Solicitar/finalizar_mantenimiento"; // Construimos la base URL del CONTROLADOR
        const frm = document.getElementById("frmFinalizarMantenimiento"); // Seleccionamos el contenido del formulario
        const http = new XMLHttpRequest(); //Creamos una instancia de HTTPRequest
        http.open("POST", url, true); //Seleccionamos el metodo y mandamos la url
        http.send(new FormData(frm)); //Enviamos todo el formulario 
        http.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) { //si la peticion se ejecuta correctamente

                console.log(this.responseText);

                const res = JSON.parse(this.responseText);

                if (res == "si") { //Si el regostro fue guardado correctamente mandamos un swal alert

                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'success',
                        title: 'Solicitud Finalizada'
                    })

                    tblSolicitar.ajax.reload(); //Refrescamos la tabla para solicitas mantenimiento o operacion
                    tblSolicitar_bitacora_mantenimiento.ajax.reload(); //Volvemos a cargar la tabla de las solicitudes
                    $('#finalizar_mantenimiento').modal('hide'); //Cerramos el modal al ejecutar correctamente la finalizacion
                    cerrarModalFinalizarMantenimiento(); //mandamos a llamar al metodo para limpiar los campos del modal

                } else {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'error',
                        title: res
                    })
                }
            }
        }
    }
}

function cerrarModalFinalizarMantenimiento() { // Cerrar modal Finalizar Mantenimiento
    document.getElementById("frmFinalizarMantenimiento").reset(); //Resetear Formulario al cerral el modal
    document.getElementById("id_finalizar_mantenimiento").value = ""; //Igualar id a ""

    document.getElementById("div_prox_mantenimiento").style.display = 'block';
    document.getElementById("div_tipo_mantenimiento").style.display = 'block';

    document.getElementById('importe_combustible_f_mantenimiento').readOnly = true;//Lo volvemos a poner como readonly
    document.getElementById('precio_combustible_f_mantenimiento').readOnly = true;//Lo volvemos a poner como readonly

    document.getElementById('descripcion_correctivo_f_mantenimiento').readOnly = true;//Lo volvemos a poner como readonly
    document.getElementById('importe_correctivo_f_mantenimiento').readOnly = true;//Lo volvemos a poner como readonly

    document.getElementById('descripcion_preventivo_f_mantenimiento').readOnly = true;//Lo volvemos a poner como readonly
    document.getElementById('importe_preventivo_f_mantenimiento').readOnly = true;//Lo volvemos a poner como readonly
}

$('#cargo_combustible_f_mantenimiento').on('change', function () { //-------Funcion change seleccionando tipo de solicitud-------//
    var cargo_combustible = document.getElementById('cargo_combustible_f_mantenimiento');

    if (cargo_combustible.value == 1) {
        document.getElementById('importe_combustible_f_mantenimiento').readOnly = false;//Le quitamo la propiedad readonly
        document.getElementById('precio_combustible_f_mantenimiento').readOnly = false;//Le quitamo la propiedad readonly
    } else {
        document.getElementById('importe_combustible_f_mantenimiento').readOnly = true;//Lo volvemos a poner como readonly
        document.getElementById('precio_combustible_f_mantenimiento').readOnly = true;//Lo volvemos a poner como readonly

        document.getElementById('importe_combustible_f_mantenimiento').value = 0;//Evaluamos el campo como NA
        document.getElementById('precio_combustible_f_mantenimiento').value = 0;//Evaluamos el campo como NA
    }
});

$('#cargo_correctivo_f_mantenimiento').on('change', function () { //-------Funcion change seleccionando tipo de solicitud-------//
    var cargo_combustible = document.getElementById('cargo_correctivo_f_mantenimiento');

    if (cargo_combustible.value == 1) {
        document.getElementById('descripcion_correctivo_f_mantenimiento').readOnly = false;//Le quitamo la propiedad readonly
        document.getElementById('importe_correctivo_f_mantenimiento').readOnly = false;//Le quitamo la propiedad readonly
    } else {
        document.getElementById('descripcion_correctivo_f_mantenimiento').readOnly = true;//Lo volvemos a poner como readonly
        document.getElementById('importe_correctivo_f_mantenimiento').readOnly = true;//Lo volvemos a poner como readonly

        document.getElementById('descripcion_correctivo_f_mantenimiento').value = 'NA';
        document.getElementById('importe_correctivo_f_mantenimiento').value = 0;//Evaluamos el campo como NA
    }
});

$('#cargo_preventivo_f_mantenimiento').on('change', function () { //-------Funcion change seleccionando tipo de solicitud-------//
    var cargo_combustible = document.getElementById('cargo_preventivo_f_mantenimiento');

    if (cargo_combustible.value == 1) {
        document.getElementById('descripcion_preventivo_f_mantenimiento').readOnly = false;//Le quitamo la propiedad readonly
        document.getElementById('importe_preventivo_f_mantenimiento').readOnly = false;//Le quitamo la propiedad readonly
    } else {
        document.getElementById('descripcion_preventivo_f_mantenimiento').readOnly = true;//Lo volvemos a poner como readonly
        document.getElementById('importe_preventivo_f_mantenimiento').readOnly = true;//Lo volvemos a poner como readonly

        document.getElementById('descripcion_preventivo_f_mantenimiento').value = 'NA';
        document.getElementById('importe_preventivo_f_mantenimiento').value = 0;//Evaluamos el campo como NA
    }
});

//*****************************SECCION BITACORA MANTENIMIENTO************************************/

//================================================================== APP-SOLICITAR CONTROLLER=========================================================================//
//===================================================================================================================================================================//


//===================================================================================================================================================================//
//================================================================== APP-AUTORIZAR CONTROLLER=========================================================================//
//-------Funcion change seleccionando tipo de AUTORIZACION-------//
$('#tab_autorizar').on('change', function () {
    var tipo = document.getElementById('tab_autorizar');
    switch (tipo.value) {
        case 'A_OPERACION':
            //MOSTRAR
            document.getElementById('tabla_autorizar_operacion').style.display = 'block'; //Mostrar div OPERACION

            //OCULTAR
            document.getElementById('tabla_autorizar_mantenimiento').style.display = 'none'; //div MANTENIMIENTI
            document.getElementById('tabla_autorizar_bitacora_operacion').style.display = 'none'; //div BITACORA OPERACION
            document.getElementById('tabla_autorizar_bitacora_mantenimiento').style.display = 'none'; //div BITACORA MANTENIMIENTO
            break;
        case 'A_MTTO':
            //MOSTRAR
            document.getElementById('tabla_autorizar_mantenimiento').style.display = 'block'; //Mostrar div MANTENIMIENTO

            //OCULTAR
            document.getElementById('tabla_autorizar_operacion').style.display = 'none'; //div OPERACION
            document.getElementById('tabla_autorizar_bitacora_operacion').style.display = 'none'; ////div BITACORA OPERACION
            document.getElementById('tabla_autorizar_bitacora_mantenimiento').style.display = 'none'; //div BITACORA MANTENIMIENTO
            break;
        case 'A_BITACORA_OPERACION':
            //MOSTRAR
            document.getElementById('tabla_autorizar_bitacora_operacion').style.display = 'block'; //div BITACORA OPERACION

            //OCULTAR
            document.getElementById('tabla_autorizar_operacion').style.display = 'none'; //div OPERACION
            document.getElementById('tabla_autorizar_mantenimiento').style.display = 'none'; //Mostrar div MANTENIMIENTO
            document.getElementById('tabla_autorizar_bitacora_mantenimiento').style.display = 'none'; //div BITACORA MANTENIMIENTO
            break;
        case 'A_BITACORA_MTTO':
            //MOSTRAR
            document.getElementById('tabla_autorizar_bitacora_mantenimiento').style.display = 'block'; //Mostrar div BITACORA MANTENIMIENTO

            //OCULTAR
            document.getElementById('tabla_autorizar_operacion').style.display = 'none'; //Mostrar div OPERACION
            document.getElementById('tabla_autorizar_mantenimiento').style.display = 'none'; //Mostrar div MANTENIMIENTO
            document.getElementById('tabla_autorizar_bitacora_operacion').style.display = 'none'; //Mostrar div BITACORA OPERACION
            break;
        default:
            console.log('Mostrar operacion');
            break;
    }
});

let tblAutorizar_operacion; //Tabla Autorizar - Operacion
document.addEventListener('DOMContentLoaded', function () {
    tblAutorizar_operacion = $('#tblAutorizar_operacion').DataTable({ //Declaramos el Id de la tabla
        ajax: {
            url: base_url + "Autorizar/listar_autorizar_operacion",
            dataSrc: ''
        },
        dom: 'lBfrtip', "responsive": true, "lengthChange": true, "autoWidth": false,
        columns: [
            {
                'data': 'no_economico',
            },
            {
                'data': 'tipo',
            },
            {
                'data': 'sitio',
            },
            {
                'data': 'motivo',
            },
            {
                'data': 'f_registro',
            },
            {
                'data': 'nombre_solicito'
            },
            {
                'data': 'num_empleado_responsable'
            },
            {
                'data': 'estatus'
            },
            {
                'data': 'acciones'
            }
        ],
    });
});

function frmAutorizarOperacion(id) {  //-----------Funcion Aprobar Solicitud operacion---------//
    Swal.fire({
        title: `Autorizar Solicitud`,
        text: "Deseas autorizar solicitud de operacion?",
        icon: 'success',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Autorizar',
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {

            const url = base_url + "Autorizar/aprobar_solicitud_operacion"; // Construimos la base URL del CONTROLADOR

            let formData = new FormData();
            formData.append('id', id);
            const http = new XMLHttpRequest(); //Creamos una instancia de HTTPRequest
            http.open("POST", url, true); //Seleccionamos el metodo y mandamos la url
            http.send(formData); //Enviamos todo el formulario 
            http.onreadystatechange = function () {

                if (this.readyState == 4 && this.status == 200) { //si la peticion se ejecuta correctamente

                    console.log(this.responseText);

                    const res = JSON.parse(this.responseText);

                    if (res == "si") { //Si el regostro fue guardado correctamente mandamos un swal alert

                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })

                        Toast.fire({
                            icon: 'success',
                            title: 'Solicitud Aprobada'
                        })

                        tblAutorizar_operacion.ajax.reload(); //Volvemos a cargar la tabla de las solicitudes
                        tblAutorizar_bitacora_operacion.ajax.reload(); //Volvemos a cargar la tabla de las solicitudes

                    } else {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })

                        Toast.fire({
                            icon: 'error',
                            title: res
                        })
                    }
                }
            }
        }
    })
}

function frmRechazarOperacion(id, lts_actual, fecha_inicial) {  //-----------Funcion Rechazar Solicitud Operacion---------//
    Swal.fire({
        title: `Rechazar Solicitud`,
        text: "Deseas rechazar solicitud de operacion?",
        icon: 'error',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Rechazar',
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {

            const url = base_url + "Autorizar/rechazar_solicitud_operacion"; // Construimos la base URL del CONTROLADOR
            let formData = new FormData();
            formData.append('id', id); //Agregamos el id al FormData            
            formData.append('lts_actual', lts_actual); //Agregamos el lts Actual al FormData
            formData.append('fecha_inicial', fecha_inicial); //Agregamos el Fecha de Inicio al FormData
            const http = new XMLHttpRequest(); //Creamos una instancia de HTTPRequest
            http.open("POST", url, true); //Seleccionamos el metodo y mandamos la url
            http.send(formData); //Enviamos todo el formulario 
            http.onreadystatechange = function () {

                if (this.readyState == 4 && this.status == 200) { //si la peticion se ejecuta correctamente

                    console.log(this.responseText);

                    const res = JSON.parse(this.responseText);

                    if (res == "si") { //Si el regostro fue guardado correctamente mandamos un swal alert

                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })

                        Toast.fire({
                            icon: 'error',
                            title: 'Solicitud Rechazada'
                        })

                        tblAutorizar_operacion.ajax.reload(); //Volvemos a cargar la tabla de las solicitudes
                        tblAutorizar_bitacora_operacion.ajax.reload(); //Volvemos a cargar la tabla de las solicitudes

                    } else {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })

                        Toast.fire({
                            icon: 'error',
                            title: res
                        })
                    }
                }
            }
        }
    })
}

let tblAutorizar_bitacora_operacion; //Tabla Autorizar Bitacora Operacion
document.addEventListener('DOMContentLoaded', function () {
    tblAutorizar_bitacora_operacion = $('#tblAutorizar_bitacora_operacion').DataTable({ //Declaramos el Id de la tabla
        ajax: {
            url: base_url + "Autorizar/listar_autorizar_bitacora_operacion",
            dataSrc: ''
        },
        dom: 'lBfrtip', "responsive": true, "lengthChange": true, "autoWidth": false,
        columns: [
            {
                'data': 'no_economico',
            },
            {
                'data': 'tipo',
            },
            {
                'data': 'sitio',
            },
            {
                'data': 'motivo',
            },
            {
                'data': 'f_registro',
            },
            {
                'data': 'num_empleado_solicito'
            },
            {
                'data': 'nombre_responsable'
            },
            {
                'data': 'estatus'
            }
        ],
    });
});

let tblAutorizar_mantenimiento; //Tabla Autorizar - Mantenimiento
document.addEventListener('DOMContentLoaded', function () {
    tblAutorizar_mantenimiento = $('#tblAutorizar_mantenimiento').DataTable({ //Declaramos el Id de la tabla
        ajax: {
            url: base_url + "Autorizar/listar_autorizar_mantenimiento",
            dataSrc: ''
        },
        dom: 'lBfrtip', "responsive": true, "lengthChange": true, "autoWidth": false,
        columns: [
            {
                'data': 'no_economico',
            },
            {
                'data': 'tipo',
            },
            {
                'data': 'tipo_mantenimiento',
            },
            {
                'data': 'motivo',
            },
            {
                'data': 'f_registro',
            },
            {
                'data': 'num_empleado_solicito'
            },
            {
                'data': 'nombre_responsable'
            },
            {
                'data': 'estatus'
            },
            {
                'data': 'acciones'
            }
        ],
    });
});

function frmAutorizarMantenimiento(id) { //-----------Funcion Aprobar Solicitud mantenimiento---------//
    Swal.fire({
        title: `Autorizar Solicitud`,
        text: "Deseas autorizar solicitud de mantenimiento?",
        icon: 'success',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Autorizar',
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {

            const url = base_url + "Autorizar/aprobar_solicitud_mantenimiento"; // Construimos la base URL del CONTROLADOR

            let formData = new FormData();
            formData.append('id', id);
            const http = new XMLHttpRequest(); //Creamos una instancia de HTTPRequest
            http.open("POST", url, true); //Seleccionamos el metodo y mandamos la url
            http.send(formData); //Enviamos todo el formulario 
            http.onreadystatechange = function () {

                if (this.readyState == 4 && this.status == 200) { //si la peticion se ejecuta correctamente

                    console.log(this.responseText);

                    const res = JSON.parse(this.responseText);

                    if (res == "si") { //Si el regostro fue guardado correctamente mandamos un swal alert

                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })

                        Toast.fire({
                            icon: 'success',
                            title: 'Solicitud Aprobada'
                        })

                        tblAutorizar_mantenimiento.ajax.reload(); //Volvemos a cargar la tabla de las solicitudes
                        tblAutorizar_bitacora_mantenimiento.ajax.reload(); //Volvemos a cargar la tabla de las solicitudes

                    } else {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })

                        Toast.fire({
                            icon: 'error',
                            title: res
                        })
                    }
                }
            }
        }
    })
}

function frmRechazarMantenimiento(id, lts_actual, fecha_inicial) { //-----------Funcion Rechazar Solicitud Mantenimiento---------//
    Swal.fire({
        title: `Rechazar Solicitud`,
        text: "Deseas rechazar solicitud de mantenimiento?",
        icon: 'error',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Rechazar',
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {

            const url = base_url + "Autorizar/rechazar_solicitud_mantenimiento"; // Construimos la base URL del CONTROLADOR
            let formData = new FormData();
            formData.append('id', id); //Agregamos el id al FormData            
            formData.append('lts_actual', lts_actual); //Agregamos el lts Actual al FormData
            formData.append('fecha_inicial', fecha_inicial); //Agregamos el Fecha de Inicio al FormData
            const http = new XMLHttpRequest(); //Creamos una instancia de HTTPRequest
            http.open("POST", url, true); //Seleccionamos el metodo y mandamos la url
            http.send(formData); //Enviamos todo el formulario 
            http.onreadystatechange = function () {

                if (this.readyState == 4 && this.status == 200) { //si la peticion se ejecuta correctamente

                    console.log(this.responseText);

                    const res = JSON.parse(this.responseText);

                    if (res == "si") { //Si el regostro fue guardado correctamente mandamos un swal alert

                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })

                        Toast.fire({
                            icon: 'error',
                            title: 'Solicitud Rechazada'
                        })

                        tblAutorizar_mantenimiento.ajax.reload(); //Volvemos a cargar la tabla de las solicitudes
                        tblAutorizar_bitacora_mantenimiento.ajax.reload(); //Volvemos a cargar la tabla de las solicitudes

                    } else {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })

                        Toast.fire({
                            icon: 'error',
                            title: res
                        })
                    }
                }
            }
        }
    })
}

let tblAutorizar_bitacora_mantenimiento; //Tabla Autorizar Bitacora MANTENIMIENTO
document.addEventListener('DOMContentLoaded', function () {
    tblAutorizar_bitacora_mantenimiento = $('#tblAutorizar_bitacora_mantenimiento').DataTable({ //Declaramos el Id de la tabla
        ajax: {
            url: base_url + "Autorizar/listar_autorizar_bitacora_mantenimiento",
            dataSrc: ''
        },
        dom: 'lBfrtip', "responsive": true, "lengthChange": true, "autoWidth": false,
        columns: [
            {
                'data': 'no_economico',
            },
            {
                'data': 'tipo',
            },
            {
                'data': 'tipo_mantenimiento',
            },
            {
                'data': 'motivo',
            },
            {
                'data': 'f_registro',
            },
            {
                'data': 'num_empleado_solicito'
            },
            {
                'data': 'nombre_responsable'
            },
            {
                'data': 'estatus'
            }
        ],
    });
});
//================================================================== APP-AUTORIZAR CONTROLLER=========================================================================//
//===================================================================================================================================================================//

//===================================================================================================================================================================//
//================================================================== APP-ADMIN CONTROLLER=========================================================================//

$('#tab_bitacora').on('change', function () { //-------Funcion change seleccionando tipo de solicitud-------//
    var tipo = document.getElementById('tab_bitacora');
    switch (tipo.value) {
        case 'BITACORA_OPERACION_ADMIN':
            //MOSTRAR
            document.getElementById('tab_tblBOperacion').style.display = 'block'; //Mostrar div Solicitar

            //OCULTAR
            document.getElementById('tab_tblBMantenimiento').style.display = 'none'; //Ocultar div OPERACION
            break;
        case 'BITACORA_MTTO_ADMIN':
            //MOSTRAR
            document.getElementById('tab_tblBMantenimiento').style.display = 'block'; //Mostrar div Bitacora Operacion

            //OCULTAR
            document.getElementById('tab_tblBOperacion').style.display = 'none'; //Ocultar div OPERACION
            break;
        default:
            console.log('Falla Seleccion');
            break;
    }
});

let tblBOperacion; //Tabla Autorizar - Operacion
document.addEventListener('DOMContentLoaded', function () {
    tblBOperacion = $('#tblBOperacion').DataTable({ //Declaramos el Id de la tabla
        ajax: {
            url: base_url + "Admin/list_operacion",
            dataSrc: ''
        },
        dom: 'lBfrtip', "responsive": true, "lengthChange": true, "autoWidth": false,
        columns: [
            {
                'data': 'no_economico',
            },
            {
                'data': 'departamento',
            },
            {
                'data': 'f_inicio',
            },
            {
                'data': 'f_final',
            },
            {
                'data': 'sitio',
            },
            {
                'data': 'motivo',
            },
            {
                'data': 'nombre_solicito',
            },
            {
                'data': 'nombre_responsable',
            },
            {
                'data': 'estatus',
            }
        ],
        dom: 'lBfrtip',
        buttons: [
            'copy', 'excel', 'pdf', 'print'
        ]
    });
});

let tblBMantenimiento; //Tabla Autorizar - Operacion
document.addEventListener('DOMContentLoaded', function () {
    tblBMantenimiento = $('#tblBMantenimiento').DataTable({ //Declaramos el Id de la tabla
        ajax: {
            url: base_url + "Admin/list_mantenimiento",
            dataSrc: ''
        },
        dom: 'lBfrtip', "responsive": true, "lengthChange": true, "autoWidth": false,
        columns: [
            {
                'data': 'no_economico',
            },
            {
                'data': 'departamento',
            },
            {
                'data': 'f_inicio',
            },
            {
                'data': 'f_final',
            },
            {
                'data': 'tipo_mantenimiento',
            },
            {
                'data': 'motivo',
            },
            {
                'data': 'nombre_solicito',
            },
            {
                'data': 'nombre_responsable',
            },
            {
                'data': 'estatus',
            }
        ],
        dom: 'lBfrtip',
        buttons: [
            'copy', 'excel', 'pdf', 'print'
        ]
    });
});

//================================================================== APP-ADMIN CONTROLLER=========================================================================//
//===================================================================================================================================================================//


//===================================================================================================================================================================//
//================================================================== APP-CONSUMO-REGIONAL CONTROLLER=========================================================================//
$('#tab_CR_tipo').on('change', function () { //-------Funcion change seleccionando tipo de solicitud-------//
    var tipo = document.getElementById('tab_CR_tipo');
    switch (tipo.value) {
        case '0':
            //MOSTRAR
            document.getElementById('periodo').style.display = 'block'; //Mostrar div Solicitar

            //OCULTAR
            document.getElementById('rango_fechas').style.display = 'none'; //Ocultar div OPERACION
            break;
        case '1':
            //MOSTRAR
            document.getElementById('periodo').style.display = 'block'; //Mostrar div Bitacora Operacion

            //OCULTAR
            document.getElementById('rango_fechas').style.display = 'none'; //Ocultar div OPERACION
            break;
        case '2':
            //MOSTRAR
            document.getElementById('rango_fechas').style.display = 'block'; //Mostrar div Bitacora Operacion

            //OCULTAR
            document.getElementById('periodo').style.display = 'none'; //Ocultar div OPERACION
            break;
        default:
            console.log('Falla Seleccion');
            break;
    }
});

let tblCRegional; //Tabla Autorizar - Operacion
document.addEventListener('DOMContentLoaded', function () { //Ejecutamos las funciones al momento de carcar el DOM
    tablaCR(); //mandamos a llamar a la tabla Consumo Regional
});

function tablaCR() { //Funcion tabla DATABLES POR AJAX

    tblCRegional = $('#tblCRegional').DataTable({ //Declaramos el Id de la tabla
        ajax: {
            type: 'POST',
            url: base_url + "ConsumoRegional/list_CR",
            dataSrc: '',
            data: function (d) {
                d.tipo = $("#tab_CR_tipo").val(); //Mandamos por POST la variable
                d.periodo = $("#tab_CR_periodo").val(); //Mandamos por POST la variable 
                d.desde = $("#desde").val(); //Mandamos por POST la variable
                d.hasta = $("#hasta").val(); //Mandamos por POST la variable
            }
        },
        dom: 'lBfrtip', "responsive": true, "lengthChange": true, "autoWidth": false,
        columns: [
            {
                'data': 'departamento',
            },
            {
                'data': 'tiempo_operando_total',
            },
            {
                'data': 'gasto_operacion', render: $.fn.dataTable.render.number(',', '.', 2, '$'),
            },
            {
                'data': 'importe_total_combustible',
            },
            {
                'data': 'gasto_combustible_total', render: $.fn.dataTable.render.number(',', '.', 2, '$'),
            }
        ],
        "footerCallback": function (tfoot, data, start, end, display) {
            var api = this.api();
            const formato = new Intl.NumberFormat('es-MX', { maximumFractionDigits: 2 }); //Declaramos el formato con dos decimales
            var intVal = function (i) { //Ejecutamos la funcion sumar para dada columna 
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            var col0 = api.column(0).data() //Evaluamos variable a la primera columna
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            var t_operando = api.column(1).data() //Evaluamos variable a la primera columna
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            var gasto_operacion = api.column(2).data() //Evaluamos variable a la primera columna
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            var garga_combustible = api.column(3).data() //Evaluamos variable a la primera columna
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            var importe_combustible = api.column(4).data() //Evaluamos variable a la primera columna
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);


            $(api.column(0).footer()).html('Total'); //Generamos la constante texto
            // Agredar las ROWS
            $(api.column(1).footer()).html(t_operando + ' Hrs'); //Imprimimos el valor del total de la columna
            $(api.column(2).footer()).html('$ ' + formato.format(gasto_operacion)); //Imprimimos el valor del total de la columna
            $(api.column(3).footer()).html(garga_combustible + ' Lts'); //Imprimimos el valor del total de la columna
            $(api.column(4).footer()).html('$ ' + formato.format(importe_combustible)); //Imprimimos el valor del total de la columna
        },
        "bFilter": false, //Ocultamos el boton del filtro
        dom: 'lBfrtip',
        buttons: [
            'copy',
            'excel',
            {
                extend: 'print',
                text: 'PRINT',
                title: 'CONSUMO REGION 3',
                footer: true,
                customize: function (win) {
                    $(win.document.body)
                        .css('font-size', '10pt')
                        .prepend(
                            '<img src="' + base_url + 'Assets/img/Telecel logo.svg' + '" style="position:absolute; top:0; right:0;" />',
                        );
                    $(win.document.body)
                        .append('<div style=" margin-top: 50px;text-align: center;margin-left: 250px;">' +
                            '<div style="float:left;margin-right:100px;">' + '<p>Gerente OYM Telcel R3</p>' +
                            '<div style="border-top: 1px solid black;height: 2px;max-width: 200px;padding: 0;margin: 50px auto 0 auto;">' +
                            '<p>ING.MIGUEL ANGEL GARCIA SOTO</p>'
                            + '</div>'
                            + '</div>' +
                            '<div style="display: table-cell;">' + '<p>Solicito Reporte</p>' +
                            '<div style="border-top: 1px solid black;height: 2px;max-width: 200px;padding: 0;margin: 50px auto 0 auto;">' +
                            '<p>ING.' + nombre_usuario_logueado + '</p>'
                            + '</div>'
                            + '</div>'
                            + '</div>'
                        ); //after the table
                    //$(win.document.body).append('<p style="font-size: 32px;text-align: center;">' + test +'</p>'); //after the table

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            }
        ],
    });
}

function buscar_CR() { //Mandamos a llamar la tabla cada vez que se cambia la configuracion de busqueda
    tblCRegional.ajax.reload(); //Volvemos a cargar la tabla de las solicitudes
}

//================================================================== APP-CONSUMO-REGIONAL CONTROLLER=========================================================================//
//==================================================================================================================================================================


//==================================================================================================================================================================
//================================================================== APP-CONSUMO-POR-PLANTA CONTROLLER=========================================================================//

$('#tab_CPP_tipo').on('change', function () { //-------Funcion change seleccionando tipo de solicitud-------//
    var tipo = document.getElementById('tab_CPP_tipo');
    switch (tipo.value) {
        case '0':
            //MOSTRAR
            document.getElementById('tab_CPP_periodo').style.display = 'block'; //Mostrar div Solicitar

            //OCULTAR
            document.getElementById('tab_CPP_rango_fechas').style.display = 'none'; //Ocultar div OPERACION
            break;
        case '1':
            //MOSTRAR
            document.getElementById('tab_CPP_periodo').style.display = 'block'; //Mostrar div Bitacora Operacion

            //OCULTAR
            document.getElementById('tab_CPP_rango_fechas').style.display = 'none'; //Ocultar div OPERACION
            break;
        case '2':
            //MOSTRAR
            document.getElementById('tab_CPP_rango_fechas').style.display = 'block'; //Mostrar div Bitacora Operacion

            //OCULTAR
            document.getElementById('tab_CPP_periodo').style.display = 'none'; //Ocultar div OPERACION
            break;
        default:
            console.log('Falla Seleccion');
            break;
    }
});

let tblCPPlanta; //Tabla Autorizar - Operacion
document.addEventListener('DOMContentLoaded', function () { //Ejecutamos las funciones al momento de carcar el DOM
    tablaCPP(); //mandamos a llamar a la tabla Consumo Regional
});

function tablaCPP() { //Funcion tabla DATABLES POR AJAX

    tblCPPlanta = $('#tblCPPlanta').DataTable({ //Declaramos el Id de la tabla
        ajax: {
            type: 'POST',
            url: base_url + "ConsumoPorPlanta/list_CPP",
            dataSrc: '',
            data: function (d) {
                d.tipo = $("#tab_CPP_tipo").val(); //Mandamos por POST la variable
                d.periodo = $("#CPP_periodo").val(); //Mandamos por POST la variable 
                d.desde = $("#tab_CPP_desde").val(); //Mandamos por POST la variable
                d.hasta = $("#tab_CPP_hasta").val(); //Mandamos por POST la variable
                d.departamento = $("#tab_CPP_departamento_id").val(); //Mandamos por POST la variable
            }
        },
        dom: 'lBfrtip', "responsive": true, "lengthChange": true, "autoWidth": false,
        columns: [
            {
                'data': 'no_economico',
            },
            {
                'data': 'departamento',
            },
            {
                'data': 'tipo',
            },
            {
                'data': 'tiempo_operando_total',
            },
            {
                'data': 'gasto_operacion', render: $.fn.dataTable.render.number(',', '.', 2, '$'),
            },
            {
                'data': 'importe_total_combustible',
            },
            {
                'data': 'gasto_combustible_total', render: $.fn.dataTable.render.number(',', '.', 2, '$'),
            }
        ],
        "footerCallback": function (tfoot, data, start, end, display) {
            var api = this.api();
            const formato = new Intl.NumberFormat('es-MX', { maximumFractionDigits: 2 }); //Declaramos el formato con dos decimales
            var intVal = function (i) { //Ejecutamos la funcion sumar para dada columna 
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            var col0 = api.column(0).data() //Evaluamos variable a la primera columna
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            var t_operando = api.column(3).data() //Evaluamos variable a la primera columna
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            var gasto_operacion = api.column(4).data() //Evaluamos variable a la primera columna
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            var garga_combustible = api.column(5).data() //Evaluamos variable a la primera columna
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            var importe_combustible = api.column(6).data() //Evaluamos variable a la primera columna
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            $(api.column(0).footer()).html('Total'); //Generamos la constante texto
            // Agredar las ROWS
            $(api.column(3).footer()).html(t_operando + ' Hrs'); //Imprimimos el valor del total de la columna
            $(api.column(4).footer()).html('$ ' + formato.format(gasto_operacion)); //Imprimimos el valor del total de la columna
            $(api.column(5).footer()).html(garga_combustible + ' Lts'); //Imprimimos el valor del total de la columna
            $(api.column(6).footer()).html('$ ' + formato.format(importe_combustible)); //Imprimimos el valor del total de la columna
        },
        "bFilter": false, //Ocultamos el boton del filtro
        dom: 'lBfrtip',
        buttons: [
            'copy',
            'excel',
            {
                extend: 'print',
                text: 'PRINT',
                title: 'CONSUMO POR PLANTA',
                footer: true,
                customize: function (win) {
                    $(win.document.body)
                        .css('font-size', '10pt')
                        .prepend(
                            '<img src="' + base_url + 'Assets/img/Telecel logo.svg' + '" style="position:absolute; top:0; right:0;" />',
                        );
                    $(win.document.body)
                        .append('<div style=" margin-top: 50px;text-align: center;margin-left: 250px;">' +
                            '<div style="float:left;margin-right:100px;">' + '<p>Gerente OYM Telcel R3</p>' +
                            '<div style="border-top: 1px solid black;height: 2px;max-width: 200px;padding: 0;margin: 50px auto 0 auto;">' +
                            '<p>ING.MIGUEL ANGEL GARCIA SOTO</p>'
                            + '</div>'
                            + '</div>' +
                            '<div style="display: table-cell;">' + '<p>Solicito Reporte</p>' +
                            '<div style="border-top: 1px solid black;height: 2px;max-width: 200px;padding: 0;margin: 50px auto 0 auto;">' +
                            '<p>ING.' + nombre_usuario_logueado + '</p>'
                            + '</div>'
                            + '</div>'
                            + '</div>'
                        ); //after the table
                    //$(win.document.body).append('<p style="font-size: 32px;text-align: center;">' + test +'</p>'); //after the table

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            }
        ],
    });
}

function buscar_CPP() { //Mandamos a llamar la tabla cada vez que se cambia la configuracion de busqueda
    tblCPPlanta.ajax.reload(); //Volvemos a cargar la tabla de las solicitudes
}
//================================================================== APP-CONSUMO-POR-PLANTA CONTROLLER=========================================================================//
//==================================================================================================================================================================

//===========================================================================================================================================================================//
//================================================================== APP-GASTO-REGIONAL CONTROLLER=========================================================================//

$('#tab_GR_tipo').on('change', function () { //-------Funcion change seleccionando tipo de solicitud-------//
    var tipo = document.getElementById('tab_GR_tipo');
    switch (tipo.value) {
        case '0':
            //MOSTRAR
            document.getElementById('periodo').style.display = 'block'; //Mostrar div Solicitar

            //OCULTAR
            document.getElementById('rango_fechas').style.display = 'none'; //Ocultar div OPERACION
            break;
        case '1':
            //MOSTRAR
            document.getElementById('periodo').style.display = 'block'; //Mostrar div Bitacora Operacion

            //OCULTAR
            document.getElementById('rango_fechas').style.display = 'none'; //Ocultar div OPERACION
            break;
        case '2':
            //MOSTRAR
            document.getElementById('rango_fechas').style.display = 'block'; //Mostrar div Bitacora Operacion

            //OCULTAR
            document.getElementById('periodo').style.display = 'none'; //Ocultar div OPERACION
            break;
        default:
            console.log('Falla Seleccion');
            break;
    }
});

let tblGRegional; //Tabla Autorizar - Operacion
document.addEventListener('DOMContentLoaded', function () { //Ejecutamos las funciones al momento de carcar el DOM
    tablaGR(); //mandamos a llamar a la tabla Consumo Regional
});

function tablaGR() { //Funcion tabla DATABLES POR AJAX

    tblGRegional = $('#tblGRegional').DataTable({ //Declaramos el Id de la tabla
        ajax: {
            type: 'POST',
            url: base_url + "GastoRegional/list_GR",
            dataSrc: '',
            data: function (d) {
                d.tipo = $("#tab_GR_tipo").val(); //Mandamos por POST la variable
                d.periodo = $("#tab_GR_periodo").val(); //Mandamos por POST la variable 
                d.desde = $("#GR_desde").val(); //Mandamos por POST la variable
                d.hasta = $("#GR_hasta").val(); //Mandamos por POST la variable
            }
        },
        dom: 'lBfrtip', "responsive": true, "lengthChange": true, "autoWidth": false,
        columns: [
            {
                'data': 'departamento',
            },
            {
                'data': 'importe_total_combustible',
            },
            {
                'data': 'gasto_combustible_total', render: $.fn.dataTable.render.number(',', '.', 2, '$'),
            },
            {
                'data': 'total_importe_correctivo', render: $.fn.dataTable.render.number(',', '.', 2, '$'),
            },
            {
                'data': 'total_importe_preventivo', render: $.fn.dataTable.render.number(',', '.', 2, '$'),
            },
            {
                'data': 'MMTOS_PREVENTIVO',
            },
            {
                'data': 'MMTOS_CORRECTIVO',
            },
            {
                'data': 'gasto_total', render: $.fn.dataTable.render.number(',', '.', 2, '$'),
            }
        ],
        "footerCallback": function (tfoot, data, start, end, display) {
            var api = this.api();
            const formato = new Intl.NumberFormat('es-MX', { maximumFractionDigits: 2 }); //Declaramos el formato con dos decimales
            var intVal = function (i) { //Ejecutamos la funcion sumar para dada columna 
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            var importeGAS = api.column(1).data() //Evaluamos variable a la primera columna
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            var gastoGAS = api.column(2).data() //Evaluamos variable a la primera columna
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            var gasto_Correctivo = api.column(3).data() //Evaluamos variable a la primera columna
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            var garga_Preventivo = api.column(4).data() //Evaluamos variable a la primera columna
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            var mttos_preventivos_total = api.column(5).data() //Evaluamos variable a la primera columna
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            var mttos_correctivos_total = api.column(6).data() //Evaluamos variable a la primera columna
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            var gasto_total = api.column(7).data() //Evaluamos variable a la primera columna
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);


            $(api.column(0).footer()).html('Total'); //Generamos la constante texto
            // Agredar las ROWS
            $(api.column(1).footer()).html(importeGAS + ' Lts'); //Imprimimos el valor del total de la columna
            $(api.column(2).footer()).html('$ ' + formato.format(gastoGAS)); //Imprimimos el valor del total de la columna
            $(api.column(3).footer()).html('$ ' + formato.format(gasto_Correctivo)); //Imprimimos el valor del total de la columna
            $(api.column(4).footer()).html('$ ' + formato.format(garga_Preventivo)); //Imprimimos el valor del total de la columna
            $(api.column(5).footer()).html(mttos_preventivos_total); //Imprimimos el valor del total de la columna
            $(api.column(6).footer()).html(mttos_correctivos_total); //Imprimimos el valor del total de la columna
            $(api.column(7).footer()).html('$ ' + formato.format(gasto_total)); //Imprimimos el valor del total de la columna
        },
        "bFilter": false, //Ocultamos el boton del filtro
        dom: 'lBfrtip',
        buttons: [
            'copy',
            'excel',
            {
                extend: 'print',
                text: 'PRINT',
                title: 'GASTO REGION 3',
                footer: true,
                customize: function (win) {
                    $(win.document.body)
                        .css('font-size', '10pt')
                        .prepend(
                            '<img src="' + base_url + 'Assets/img/Telecel logo.svg' + '" style="position:absolute; top:0; right:0;" />',
                        );
                    $(win.document.body)
                        .append('<div style=" margin-top: 50px;text-align: center;margin-left: 250px;">' +
                            '<div style="float:left;margin-right:100px;">' + '<p>Gerente OYM Telcel R3</p>' +
                            '<div style="border-top: 1px solid black;height: 2px;max-width: 200px;padding: 0;margin: 50px auto 0 auto;">' +
                            '<p>ING.MIGUEL ANGEL GARCIA SOTO</p>'
                            + '</div>'
                            + '</div>' +
                            '<div style="display: table-cell;">' + '<p>Solicito Reporte</p>' +
                            '<div style="border-top: 1px solid black;height: 2px;max-width: 200px;padding: 0;margin: 50px auto 0 auto;">' +
                            '<p>ING.' + nombre_usuario_logueado + '</p>'
                            + '</div>'
                            + '</div>'
                            + '</div>'
                        ); //after the table
                    //$(win.document.body).append('<p style="font-size: 32px;text-align: center;">' + test +'</p>'); //after the table

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            }
        ],
    });
}

function buscar_GR() { //Mandamos a llamar la tabla cada vez que se cambia la configuracion de busqueda
    tblGRegional.ajax.reload(); //Volvemos a cargar la tabla de las solicitudes
}
//================================================================== APP-GASTO-REGIONAL CONTROLLER=========================================================================//
//===========================================================================================================================================================================//

//=============================================================================================================================================================================//
//================================================================== APP-GASTO-POR-PLANTA CONTROLLER=========================================================================//
$('#tab_GPP_tipo').on('change', function () { //-------Funcion change seleccionando tipo de solicitud-------//
    var tipo = document.getElementById('tab_GPP_tipo');
    switch (tipo.value) {
        case '0':
            //MOSTRAR
            document.getElementById('tab_GPP_periodo').style.display = 'block'; //Mostrar div Solicitar

            //OCULTAR
            document.getElementById('tab_GPP_rango_fechas').style.display = 'none'; //Ocultar div OPERACION
            break;
        case '1':
            //MOSTRAR
            document.getElementById('tab_GPP_periodo').style.display = 'block'; //Mostrar div Bitacora Operacion

            //OCULTAR
            document.getElementById('tab_GPP_rango_fechas').style.display = 'none'; //Ocultar div OPERACION
            break;
        case '2':
            //MOSTRAR
            document.getElementById('tab_GPP_rango_fechas').style.display = 'block'; //Mostrar div Bitacora Operacion

            //OCULTAR
            document.getElementById('tab_GPP_periodo').style.display = 'none'; //Ocultar div OPERACION
            break;
        default:
            console.log('Falla Seleccion');
            break;
    }
});

let tblGPPlanta; //Tabla Autorizar - Operacion
document.addEventListener('DOMContentLoaded', function () { //Ejecutamos las funciones al momento de carcar el DOM
    tablaGPP(); //mandamos a llamar a la tabla Consumo Regional
});

function tablaGPP() { //Funcion tabla DATABLES POR AJAX

    const url = base_url + "Usuarios/obtener_usuario_logueado"; // Construimos la base URL del CONTROLADOR
    const http = new XMLHttpRequest(); //Creamos una instancia de HTTPRequest
    http.open("GET", url, true); //Seleccionamos el metodo y mandamos la url
    http.send(); //Enviamos todo el formulario 
    http.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) { //si la peticion se ejecuta correctamente

            const res = JSON.parse(this.responseText); //Guardamos la respuesta de la peticion POST

            nombre_usuario_logueado = res; //Obtener valor del usuario a actualizar

        } else if (this.status == 400) {
            console.log('Error al obtener usuario logueado en aplicacion');
        }
    }

    tblGPPlanta = $('#tblGPPlanta').DataTable({ //Declaramos el Id de la tabla
        ajax: {
            type: 'POST',
            url: base_url + "GastoPorPlanta/list_GPP",
            dataSrc: '',
            data: function (d) {
                d.tipo = $("#tab_GPP_tipo").val(); //Mandamos por POST la variable
                d.periodo = $("#GPP_periodo").val(); //Mandamos por POST la variable 
                d.desde = $("#tab_GPP_desde").val(); //Mandamos por POST la variable
                d.hasta = $("#tab_GPP_hasta").val(); //Mandamos por POST la variable
                d.departamento = $("#tab_GPP_departamento_id").val(); //Mandamos por POST la variable
            }
        },
        dom: 'lBfrtip', "responsive": true, "lengthChange": true, "autoWidth": false,
        columns: [
            {
                'data': 'no_economico',
            },
            {
                'data': 'departamento',
            },
            {
                'data': 'tipo',
            },
            {
                'data': 'importe_total_combustible',
            },
            {
                'data': 'gasto_combustible_total', render: $.fn.dataTable.render.number(',', '.', 2, '$'),
            },
            {
                'data': 'total_importe_correctivo', render: $.fn.dataTable.render.number(',', '.', 2, '$'),
            },
            {
                'data': 'total_importe_preventivo', render: $.fn.dataTable.render.number(',', '.', 2, '$'),
            },
            {
                'data': 'MMTOS_PREVENTIVO',
            },
            {
                'data': 'MMTOS_CORRECTIVO',
            },
            {
                'data': 'gasto_total', render: $.fn.dataTable.render.number(',', '.', 2, '$'),
            }
        ],
        "footerCallback": function (tfoot, data, start, end, display) {
            var api = this.api();
            const formato = new Intl.NumberFormat('es-MX', { maximumFractionDigits: 2 }); //Declaramos el formato con dos decimales
            var intVal = function (i) { //Ejecutamos la funcion sumar para dada columna 
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            var importeGAS = api.column(3).data() //Evaluamos variable a la primera columna
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            var gastoGAS = api.column(4).data() //Evaluamos variable a la primera columna
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            var gasto_Correctivo = api.column(5).data() //Evaluamos variable a la primera columna
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            var garga_Preventivo = api.column(6).data() //Evaluamos variable a la primera columna
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            var mttos_preventivos_total = api.column(7).data() //Evaluamos variable a la primera columna
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            var mttos_correctivos_total = api.column(8).data() //Evaluamos variable a la primera columna
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            var gasto_total = api.column(9).data() //Evaluamos variable a la primera columna
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);


            $(api.column(0).footer()).html('Total'); //Generamos la constante texto
            // Agredar las ROWS
            $(api.column(3).footer()).html(importeGAS + ' Lts'); //Imprimimos el valor del total de la columna
            $(api.column(4).footer()).html('$ ' + formato.format(gastoGAS)); //Imprimimos el valor del total de la columna
            $(api.column(5).footer()).html('$ ' + formato.format(gasto_Correctivo)); //Imprimimos el valor del total de la columna
            $(api.column(6).footer()).html('$ ' + formato.format(garga_Preventivo)); //Imprimimos el valor del total de la columna
            $(api.column(7).footer()).html(mttos_preventivos_total); //Imprimimos el valor del total de la columna
            $(api.column(8).footer()).html(mttos_correctivos_total); //Imprimimos el valor del total de la columna
            $(api.column(9).footer()).html('$ ' + formato.format(gasto_total)); //Imprimimos el valor del total de la columna
        },
        "bFilter": false, //Ocultamos el boton del filtro
        dom: 'lBfrtip',
        buttons: [
            'copy',
            'excel',
            {
                extend: 'print',
                text: 'PRINT',
                title: 'GASTO POR PLANTA',
                footer: true,
                customize: function (win) {
                    $(win.document.body)
                        .css('font-size', '10pt')
                        .prepend(
                            '<img src="' + base_url + 'Assets/img/Telecel logo.svg' + '" style="position:absolute; top:0; right:0;" />',
                        );
                    $(win.document.body)
                        .append('<div style=" margin-top: 50px;text-align: center;margin-left: 250px;">' +
                            '<div style="float:left;margin-right:100px;">' + '<p>Gerente OYM Telcel R3</p>' +
                            '<div style="border-top: 1px solid black;height: 2px;max-width: 200px;padding: 0;margin: 50px auto 0 auto;">' +
                            '<p>ING.MIGUEL ANGEL GARCIA SOTO</p>'
                            + '</div>'
                            + '</div>' +
                            '<div style="display: table-cell;">' + '<p>Solicito Reporte</p>' +
                            '<div style="border-top: 1px solid black;height: 2px;max-width: 200px;padding: 0;margin: 50px auto 0 auto;">' +
                            '<p>ING.' + nombre_usuario_logueado + '</p>'
                            + '</div>'
                            + '</div>'
                            + '</div>'
                        ); //after the table
                    //$(win.document.body).append('<p style="font-size: 32px;text-align: center;">' + test +'</p>'); //after the table

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            }
        ],
    });
}

function buscar_GPP() { //Mandamos a llamar la tabla cada vez que se cambia la configuracion de busqueda
    tblGPPlanta.ajax.reload(); //Volvemos a cargar la tabla de las solicitudes
}
//================================================================== APP-CONSUMO-POR-PLANTA CONTROLLER=========================================================================//
//=============================================================================================================================================================================//