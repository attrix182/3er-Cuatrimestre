var __extends = (this && this.__extends) || (function () {
    var extendStatics = function (d, b) {
        extendStatics = Object.setPrototypeOf ||
            ({ __proto__: [] } instanceof Array && function (d, b) { d.__proto__ = b; }) ||
            function (d, b) { for (var p in b) if (Object.prototype.hasOwnProperty.call(b, p)) d[p] = b[p]; };
        return extendStatics(d, b);
    };
    return function (d, b) {
        extendStatics(d, b);
        function __() { this.constructor = d; }
        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
    };
})();
var Entidades;
(function (Entidades) {
    var Persona = /** @class */ (function () {
        function Persona(email, clave) {
            this.email = email;
            this.clave = clave;
        }
        Persona.prototype.ToString = function () {
            return "{\"email\":\"" + this.email + "\",\"clave\":" + this.clave + ",";
        };
        return Persona;
    }());
    Entidades.Persona = Persona;
})(Entidades || (Entidades = {}));
var Entidades;
(function (Entidades) {
    var Ciudadano = /** @class */ (function (_super) {
        __extends(Ciudadano, _super);
        function Ciudadano(email, clave, ciudad) {
            var _this = _super.call(this, email, clave) || this;
            _this.ciudad = ciudad;
            return _this;
        }
        Ciudadano.prototype.ToJSON = function () {
            var retornoJSON = _super.prototype.ToString.call(this) + "\"email\":\"" + this.email + "\",\"ciudad\":\"" + this.ciudad + "\"}";
            return JSON.parse(retornoJSON);
        };
        return Ciudadano;
    }(Entidades.Persona));
    Entidades.Ciudadano = Ciudadano;
})(Entidades || (Entidades = {}));
/// <reference path="./Persona.ts" />
/// <reference path="./Ciudadano.ts" />
var PrimerParcial;
(function (PrimerParcial) {
    var Manejadora = /** @class */ (function () {
        function Manejadora() {
        }
        Manejadora.AgregarCiudadano = function () {
            var xhr = new XMLHttpRequest();
            var email = document.getElementById("correo").value;
            var clave = document.getElementById("clave").value;
            var ciudad = document.getElementById("ciudad").value;
            var form = new FormData();
            form.append('email', email);
            form.append('clave', clave);
            form.append('ciudad', ciudad);
            xhr.open('POST', './BACKEND/AltaCiudadano.php', true);
            xhr.setRequestHeader("enctype", "multipart/form-data");
            xhr.send(form);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    console.log(xhr.responseText);
                    var retJSON = JSON.parse(xhr.responseText);
                    if (retJSON.exito) {
                        console.info("Todo ok");
                    }
                    else {
                        console.error("Hubo un error - No se pudo agregar");
                    }
                }
            };
        };
        Manejadora.MostrarCiudadanos = function () {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', './BACKEND/ListadoCiudadanos.php', true);
            xhr.setRequestHeader("enctype", "multipart/form-data");
            xhr.send();
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var arrayJson = JSON.parse(xhr.responseText);
                    var tabla = "";
                    tabla += "<table border=1 style='width:100%' text-aling='center'> <thead>";
                    tabla += "<tr>";
                    tabla += "<th>email</th>";
                    tabla += "<th>clave</th>";
                    tabla += "<th>ciudad</th>";
                    tabla += "</tr> </thead>";
                    for (var i = 0; i < arrayJson.length; i++) {
                        var ciudadano = JSON.parse(arrayJson[i]);
                        tabla += "<tr>";
                        tabla += "<td>" + ciudadano.email + "</td>";
                        tabla += "<td>" + ciudadano.clave + "</td>";
                        tabla += "<td>" + ciudadano.ciudad + "</td>";
                        tabla += "</tr>";
                    }
                    tabla += "</table>";
                    document.getElementById("divTabla").innerHTML = tabla;
                }
            };
        };
        Manejadora.VerificarExistencia = function () {
            var xhr = new XMLHttpRequest();
            var email = document.getElementById("correo").value;
            var clave = document.getElementById("clave").value;
            var form = new FormData();
            form.append('email', email);
            form.append('clave', clave);
            xhr.open('POST', './BACKEND/VerificarCiudadano.php', true);
            xhr.setRequestHeader("enctype", "multipart/form-data");
            xhr.send(form);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var rta = JSON.parse(xhr.responseText);
                    alert(rta.mensaje);
                    console.log(rta.mensaje);
                }
            };
        };
        Manejadora.AgregarCiudadSinFoto = function () {
            var xhr = new XMLHttpRequest();
            var nombre = document.getElementById("nombre").value;
            var poblacion = document.getElementById("poblacion").value;
            var pais = document.getElementById("cboPais").value;
            var form = new FormData();
            form.append('nombre', nombre);
            form.append('poblacion', poblacion);
            form.append('pais', pais);
            xhr.open('POST', './BACKEND/AgregarCiudadSinFoto.php', true);
            xhr.setRequestHeader("enctype", "multipart/form-data");
            xhr.send(form);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    console.log(xhr.responseText);
                    var retJSON = JSON.parse(xhr.responseText);
                    console.info("Todo ok");
                }
            };
        };
        Manejadora.MostrarCiudades = function () {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', './BACKEND/ListadoCiudades.php', true);
            xhr.setRequestHeader("enctype", "multipart/form-data");
            xhr.send();
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var tabla = document.getElementById("divTabla");
                    tabla.innerHTML = xhr.responseText;
                }
            };
        };
        Manejadora.AgregarVerificarCiudad = function () {
            var _this = this;
            var xhr = new XMLHttpRequest();
            var nombre = document.getElementById("nombre").value;
            var poblacion = document.getElementById("poblacion").value;
            var pais = document.getElementById("cboPais").value;
            var foto = document.getElementById("foto");
            var form = new FormData();
            form.append('nombre', nombre);
            form.append('poblacion', poblacion);
            form.append('pais', pais);
            form.append('foto', foto.files[0]);
            xhr.open('POST', './BACKEND/AgregarCiudad.php', true);
            xhr.setRequestHeader("enctype", "multipart/form-data");
            xhr.send(form);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var retJSON = JSON.parse(xhr.responseText);
                    console.log(retJSON.mensaje);
                    alert(retJSON.mensaje);
                    _this.MostrarCiudades();
                }
            };
        };
        Manejadora.ElimianarCiudad = function (ciudad) {
            var _this = this;
            var xhr = new XMLHttpRequest();
            var form = new FormData();
            form.append('ciudad_json', ciudad);
            form.append('accion', "borrar");
            xhr.open('POST', './BACKEND/EliminarCiudad.php', true);
            xhr.setRequestHeader("enctype", "multipart/form-data");
            xhr.send(form);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var retJSON = JSON.parse(xhr.responseText);
                    console.log(retJSON.mensaje);
                    alert(retJSON.mensaje);
                    _this.MostrarCiudades();
                }
            };
        };
        return Manejadora;
    }());
    PrimerParcial.Manejadora = Manejadora;
})(PrimerParcial || (PrimerParcial = {}));
