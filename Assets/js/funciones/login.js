//----------------Funcion login-----------------//
function frmLogin(e) {
    e.preventDefault(); //Prevenir la recarga de la pagina
    const usuario = document.getElementById("usuario"); //Seleccionamos el input
    const clave = document.getElementById("clave"); //Seleccionamos el input

    if (usuario.value == "") { //Evaluamos si tiene contenido
        clave.classList.remove("is-invalid");
        usuario.classList.add("is-invalid");
        usuario.focus();
    } else if (clave.value == "") { //Evaluamos si tiene contenido
        usuario.classList.remove("is-invalid");
        clave.classList.add("is-invalid");
        clave.focus();
    } else {
        const url = base_url + "Usuarios/validar"; // Construimos la base URL
        const frm = document.getElementById("frmLogin"); // Seleccionamos el contenido del formulario
        const http = new XMLHttpRequest();  //Creamos una instancia de HTTPRequest
        http.open("POST", url, true); //Seleccionamos el metodo y mandamos la url
        http.send(new FormData(frm)); //Enviamos todo el formulario 
        http.onreadystatechange = function () {
            
            if (this.readyState == 4 && this.status == 200) { //si la peticion se ejecuta correctamente
                
                const res = JSON.parse(this.responseText); //convertimos la respuesta 
                if (res == "ok") {
                    window.location = base_url + "Plantas" //Si la respuesta es valida enviamos al usuario a la pagina principal ya con la SESSION declarada en Usuarios
                }else if(res == "cambio"){
                    document.getElementById("alerta").innerHTML = "Tu password vencio, favor de renovar en la aplicacion de control de usuarios"; //Igualamos la respuesta de error en la alerta
                    $("#alerta").removeClass('d-none'); //Removemos clase
                } else {
                    document.getElementById("alerta").innerHTML = res; //Igualamos la respuesta de error en la alerta
                    $("#alerta").removeClass('d-none'); //Removemos clase
                }
            }
        }
    }
}
