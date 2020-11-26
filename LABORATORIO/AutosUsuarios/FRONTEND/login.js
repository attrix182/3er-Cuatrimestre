/// <reference path="./node_modules/@types/jquery/index.d.ts" />
function Enviar() {
    var pagina = "./BACKEND/login";
    var correo = $("#correoLogin").val();
    var clave = $("#claveLogin").val();
    var json = { "correo": correo, "clave": clave };
    var userJson = JSON.stringify(json);
    var form = new FormData();
    form.append("user", userJson);
    $.ajax({
        url: pagina,
        type: "post",
        dataType: "json",
        data: form,
        cache: false,
        contentType: false,
        processData: false,
        async: true
    }).done(function (respuesta) {
        if (respuesta.exito) {
            localStorage.setItem("jwt", respuesta.jwt);
            location.href = "./principal.php";
        }
        else {
            var html = '<div class="alert alert-danger alert-dissmisable">' + respuesta.mensaje + '</div>';
            $("#divAlert").html(html);
        }
    }).fail(function (jqXHR, textStatus, errorThrown) {
        console.log(errorThrown);
        var respuesta = JSON.parse(jqXHR.responseText);
        var html = '<div class="alert alert-danger alert-dissmisable">' + respuesta.mensaje + '</div>';
        $("#divAlert").html(html);
    });
}
