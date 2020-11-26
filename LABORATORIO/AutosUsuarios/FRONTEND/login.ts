/// <reference path="./node_modules/@types/jquery/index.d.ts" />


function Enviar() {
    let pagina = "./BACKEND/login";
    let correo = $("#correoLogin").val();
    let clave = $("#claveLogin").val();


    let json = { "correo": correo, "clave": clave };
    let userJson = JSON.stringify(json);
    let form = new FormData()
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
            let html = '<div class="alert alert-danger alert-dissmisable">' + respuesta.mensaje + '</div>';
            $("#divAlert").html(html);
        }


    }).fail(function (jqXHR, textStatus, errorThrown) {
        console.log(errorThrown);
        let respuesta = JSON.parse(jqXHR.responseText);


        let html = '<div class="alert alert-danger alert-dissmisable">' + respuesta.mensaje + '</div>';
        $("#divAlert").html(html);

    });

}   
