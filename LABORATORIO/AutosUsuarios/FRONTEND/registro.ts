/// <reference path="./node_modules/@types/jquery/index.d.ts" />

$(document).ready(function () {

    $("#btnRegistrar").click(function () {

        let nombre: string = <string>$('#nombre').val();
        let apellido: number = <number>$('#apellido').val();
        let email: number = <number>$('#correo').val();
        let perfil: string = <string>$('#perfil').val();
        let clave = <string>$('#clave').val();
        let foto: any = (<HTMLInputElement>document.getElementById("foto"));


        let formData = new FormData();
        formData.append('usuario', '{"nombre":"' + nombre + '","apellido":"' + apellido + '","correo":"' + email + '","clave":"' + clave + '", "perfil": "' + perfil + '"}');
        formData.append('foto', foto.files[0]);

        let url = './BACKEND/usuarios';

        $.ajax({

            type: 'POST',
            url: url,
            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function (retorno: any) {
                console.log(retorno);

                $("#errorRegistro").html("<div class=\"alert alert-success\" role=\"alert\"><strong>EXITO!</strong> " + retorno.mensaje + "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>");
                $("#errorRegistro").show();
                location.href = "./login.html";

            }
        }).fail(function (jqXHR: any, textStatus: any, errorThrown: any) {
            let retorno = JSON.parse(jqXHR.responseText);
            console.log(retorno);
            $("#errorRegistro").html(`<div class="alert alert-danger" role="alert">
            <strong>ERROR!</strong> ${retorno.mensaje}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>`);
            $("#errorRegistro").show();

        });
    });

});

