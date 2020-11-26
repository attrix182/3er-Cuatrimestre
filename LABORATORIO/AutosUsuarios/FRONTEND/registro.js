/// <reference path="./node_modules/@types/jquery/index.d.ts" />
$(document).ready(function () {
    $("#btnRegistrar").click(function () {
        var nombre = $('#nombre').val();
        var apellido = $('#apellido').val();
        var email = $('#correo').val();
        var perfil = $('#perfil').val();
        var clave = $('#clave').val();
        var foto = document.getElementById("foto");
        var formData = new FormData();
        formData.append('usuario', '{"nombre":"' + nombre + '","apellido":"' + apellido + '","correo":"' + email + '","clave":"' + clave + '", "perfil": "' + perfil + '"}');
        formData.append('foto', foto.files[0]);
        var url = './BACKEND/usuarios';
        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function (retorno) {
                console.log(retorno);
                $("#errorRegistro").html("<div class=\"alert alert-success\" role=\"alert\"><strong>EXITO!</strong> " + retorno.mensaje + "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>");
                $("#errorRegistro").show();
                location.href = "./login.html";
            }
        }).fail(function (jqXHR, textStatus, errorThrown) {
            var retorno = JSON.parse(jqXHR.responseText);
            console.log(retorno);
            $("#errorRegistro").html("<div class=\"alert alert-danger\" role=\"alert\">\n            <strong>ERROR!</strong> " + retorno.mensaje + "\n            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">\n              <span aria-hidden=\"true\">&times;</span>\n            </button>\n          </div>");
            $("#errorRegistro").show();
        });
    });
});
