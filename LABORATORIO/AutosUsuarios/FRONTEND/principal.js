/// <reference path="./node_modules/@types/jquery/index.d.ts" />
function VerificarJWT() {
    $("#divResultado").html("");
    //RECUPERO DEL LOCALSTORAGE
    var jwt = localStorage.getItem("jwt");
    $.ajax({
        type: 'GET',
        url: "./BACKEND/login",
        dataType: "json",
        data: {},
        headers: { "token": jwt },
        async: true
    })
        .done(function (resultado) {
        console.log(resultado);
        var app = resultado.app;
        var usuario = resultado.datos;
        localStorage.setItem("user", JSON.stringify(usuario.data));
    })
        .fail(function (jqXHR, textStatus, errorThrown) {
        var retorno = JSON.parse(jqXHR.responseText);
        console.log(retorno);
        alert("Error TOKEN EXPIRADO, sera redirigido a login");
        var html = '<div class="alert alert-danger alert-dissmisable"></div>';
        $("#divAlert").html(html);
        location.href = "./login.html";
    });
}
function MostrarUsuarios() {
    var pagina = "./BACKEND/";
    $.ajax({
        url: pagina,
        type: "get",
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        async: true
    }).done(function (resultado) {
        var listaElementos = resultado;
        var html = '<table class="table table-hover table-responsive ">';
        html += '<tr><th>Correo</th><th>Nombre</th><th>Apellido</th><th>Perfil</th><th>Foto</th></tr>';
        listaElementos.forEach(function (element) {
            html += '<tr>';
            html += '<td>' + element.correo + '</td>';
            html += '<td>' + element.nombre + '</td>';
            html += '<td>' + element.apellido + '</td>';
            html += '<td>' + element.perfil + '</td>';
            html += '<td>' + '<img src="BACKEND/fotos/' + element.foto + '" width="50px" height="50px"></td>';
            html += '</tr>';
        });
        html += '</table>';
        $("#tabDerecha").html(html);
    }).fail(function (jqXHR, textStatus, errorThrown) {
        var respuesta = jqXHR.responseJSON;
        console.log(respuesta);
        var html = '<div class="alert alert-danger alert-dissmisable">' + "Error,no se a podido cargar la Tabla" + '</div>';
        $("#divAlert").html(html);
    });
}
function MostrarAutos() {
    var pagina = "./BACKEND/autos";
    $.ajax({
        url: pagina,
        type: "get",
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        async: true
    }).done(function (resultado) {
        var listaElementos = resultado;
        var html = '<table class="table table-hover table-striped table-responsive">';
        html += '<tr><th>Marca</th><th>color</th><th>Modelo</th><th>Precio</th><th>Eliminar</th><th>Modificar</th></tr>';
        listaElementos.forEach(function (element) {
            html += '<tr>';
            html += '<td>' + element.marca + '</td>';
            html += '<td>' + element.color + '</td>';
            html += '<td>' + element.modelo + '</td>';
            html += '<td>' + element.precio + '</td>';
            html += '<td>' + '<input type="button" value="Eliminar" onclick="EliminarAuto(' + element.id + ')" class="btn-danger form-control">' + '</td>';
            html += '<td>' + "<input type='button' value='Modificar' onclick='ModificarAuto(" + JSON.stringify(element) + ")' class='btn-info form-control'>" + '</td>';
            html += '</tr>';
        });
        html += '</table>';
        $("#tabIzquierda").html(html);
    }).fail(function (jqXHR, textStatus, errorThrown) {
        var respuesta = jqXHR.responseJSON;
        console.log(respuesta);
        var html = '<div class="alert alert-danger alert-dissmisable">' + "Error,no se a podido cargar la Tabla" + '</div>';
        $("#divAlert").html(html);
    });
}
function EliminarAuto(id) {
    var confirmar = confirm("Esta seguro que desea eliminar este Auto?");
    if (confirmar) {
        var pagina = "./BACKEND/";
        var jwt = localStorage.getItem("jwt");
        var json = { "id_auto": id };
        var token = { "token": jwt };
        $.ajax({
            url: pagina,
            type: "delete",
            headers: token,
            data: json,
            dataType: "json",
            cache: false,
            //contentType:false,
            //processData:false,
            async: true
        }).done(function (resultado) {
            MostrarAutos();
        }).fail(function (jqXHR, textStatus, errorThrown) {
            var respuesta = jqXHR.responseJSON;
            var estado = jqXHR.status;
            if (!respuesta.exito) {
                if (estado == 403) {
                    location.href = "login.html";
                    return;
                }
                var html = '<div class="alert alert-warning alert-dissmisable">' + "ACCION SOLO PROPIETARIOS " + respuesta.mensaje + '</div>';
                $("#divAlert").html(html);
            }
            console.log("no se pudo eliminar");
        });
    }
}
function ModificarAuto(json) {
    var html;
    html = '<div class="container-fluid" style="background-color: darkcyan; ">';
    html += '<form action="" >';
    html += '<div class="form-group" >';
    html += '<div class="row mt-1" >';
    html += '<div class="col-1 mt-3" ><label for="txtMarca" class="fas fa-trademark "></label></div>';
    html += '<div class="col mt-3"><input type="text" id="txtMarca" class="form-control" value="' + json.marca + '" placeholder="Marca"></div></div>';
    html += '<div class="row mt-1">';
    html += '<div class="col-1"><label for="txtColor" class="fas fa-palette "></label></div>';
    html += '<div class="col"><input type="text" id="txtColor" class="form-control" value="' + json.color + '" placeholder="Color"></div></div>';
    html += '<div class="row mt-1">';
    html += '<div class="col-1"><label for="txtModelo" class="fas fa-car"></label></div>';
    html += '<div class="col"><input type="text" id="txtModelo" class="form-control" value="' + json.modelo + '" placeholder="Modelo"></div></div>';
    html += '<div class="row mt-1">';
    html += '<div class="col-1"><label for="txtPrecio" class="fas fa-dollar-sign "></label></div>';
    html += '<div class="col"><input type="text" id="txtPrecio" class="form-control" value="' + json.precio + '" placeholder="Precio"></div>';
    html += '</div>';
    html += '<div class="row mt-3">';
    html += '<div class="col ml-5"><input type="button" value="Modificar" class="btn-success form-control" onclick="ObtenerdatosModificar(' + json.id + ')"></div>';
    html += '<div class="col mr-5"><input type="reset" value="Limpiar" class="btn-warning form-control" ></div>';
    html += '</div>';
    html += '</div></form></div>';
    $("#tabIzquierda").html(html);
}
function ObtenerdatosModificar(id) {
    var marca = $("#txtMarca").val();
    var color = $("#txtColor").val();
    var modelo = $("#txtModelo").val();
    var precio = $("#txtPrecio").val();
    var pagina = "./BACKEND/";
    var cadenaJson = JSON.stringify({ "marca": marca, "color": color, "modelo": modelo, "precio": precio });
    var jwt = localStorage.getItem("jwt");
    var token = { "token": jwt };
    var auto = { "auto": cadenaJson, "id_auto": id };
    $.ajax({
        url: pagina,
        type: "PUT",
        headers: token,
        dataType: "json",
        cache: false,
        data: auto,
        //contentType:false,
        //processData:false,
        async: true
    }).done(function (resultado) {
        console.log(resultado);
        console.log("estoy en el done");
        MostrarAutos();
    }).fail(function (jqXHR, textStatus, errorThrown) {
        console.log("estoy en el fail");
        console.log(jqXHR.responseText);
        var respuesta = JSON.parse(jqXHR.responseText);
        if (!respuesta.exito) {
            var respuesta_1 = jqXHR.responseJSON;
            var estado = jqXHR.status;
            if (!respuesta_1.exito) {
                if (estado == 403) {
                    location.href = "login.html";
                    return;
                }
                var html = '<div class="alert alert-warning alert-dissmisable">' + "ACCION SOLO ENCARGADOS " + respuesta_1.mensaje + '</div>';
                $("#divAlert").html(html);
            }
        }
    });
}
function AltaAutos() {
    var html;
    html = '<div class="container-fluid" style="background-color: darkcyan; ">';
    html += '<form action="" >';
    html += '<div class="form-group" >';
    html += '<div class="row mt-1" >';
    html += '<div class="col-1 mt-3" ><label for="txtMarca" class="fas fa-trademark "></label></div>';
    html += '<div class="col mt-3"><input type="text" id="txtMarca" class="form-control"  placeholder="Marca"></div></div>';
    html += '<div class="row mt-1">';
    html += '<div class="col-1"><label for="txtColor" class="fas fa-palette "></label></div>';
    html += '<div class="col"><input type="text" id="txtColor" class="form-control" placeholder="Color"></div></div>';
    html += '<div class="row mt-1">';
    html += '<div class="col-1"><label for="txtModelo" class="fas fa-car"></label></div>';
    html += '<div class="col"><input type="text" id="txtModelo" class="form-control" placeholder="Modelo"></div></div>';
    html += '<div class="row mt-1">';
    html += '<div class="col-1"><label for="txtPrecio" class="fas fa-dollar-sign "></label></div>';
    html += '<div class="col"><input type="text" id="txtPrecio" class="form-control" placeholder="Precio"></div>';
    html += '</div>';
    html += '<div class="row mt-3">';
    html += '<div class="col ml-5"><input type="button" value="Agregar" class="btn-success form-control" onclick="AgregoUno()"></div>';
    html += '<div class="col mr-5"><input type="reset" value="Limpiar" class="btn-warning form-control" ></div>';
    html += '</div>';
    html += '</div></form></div>';
    $("#tabIzquierda").html(html);
}
function AgregoUno() {
    var marca = $("#txtMarca").val();
    var color = $("#txtColor").val();
    var modelo = $("#txtModelo").val();
    var precio = $("#txtPrecio").val();
    var pagina = "./BACKEND/";
    var auto = JSON.stringify({ "marca": marca, "color": color, "modelo": modelo, "precio": precio });
    var form = new FormData();
    form.append("auto", auto);
    $.ajax({
        url: pagina,
        type: "post",
        data: form,
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        async: true
    }).done(function (resultado) {
        console.log(resultado);
        console.log("estoy en el done");
        MostrarAutos();
    }).fail(function (jqXHR, textStatus, errorThrown) {
        console.log("estoy en el fail");
        var respuesta = jqXHR.responseJSON;
        console.log(jqXHR);
        alert(respuesta.mensaje);
    });
}
