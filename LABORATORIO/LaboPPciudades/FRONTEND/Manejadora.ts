/// <reference path="./Persona.ts" />
/// <reference path="./Ciudadano.ts" />


namespace PrimerParcial {

    export interface IParte2 {
        AgregarVerificarCiudad(objetoJson: any): void;
        EliminarCiudad(objetoJson: any): void;
        ModificarCiudad(objetoJson: any): void;
    }





    export class Manejadora {

        public static AgregarCiudadano() {

            let xhr: XMLHttpRequest = new XMLHttpRequest();

            let email: string = (<HTMLInputElement>document.getElementById("correo")).value;
            let clave: string = (<HTMLSelectElement>document.getElementById("clave")).value;
            let ciudad: string = (<HTMLInputElement>document.getElementById("ciudad")).value;

            let form: FormData = new FormData();

            form.append('email', email);
            form.append('clave', clave);
            form.append('ciudad', ciudad);
            xhr.open('POST', './BACKEND/AltaCiudadano.php', true);
            xhr.setRequestHeader("enctype", "multipart/form-data");
            xhr.send(form);

            xhr.onreadystatechange = () => {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    console.log(xhr.responseText);
                    let retJSON = JSON.parse(xhr.responseText);
                    if (retJSON.exito) {
                        console.info("Todo ok");
                    } else {
                        console.error("Hubo un error - No se pudo agregar");
                    }
                }
            };
        }

        public static MostrarCiudadanos() {
            let xhr: XMLHttpRequest = new XMLHttpRequest();

            xhr.open('GET', './BACKEND/ListadoCiudadanos.php', true);
            xhr.setRequestHeader("enctype", "multipart/form-data");
            xhr.send();

            xhr.onreadystatechange = () => {
                if (xhr.readyState == 4 && xhr.status == 200) {

                    let arrayJson = JSON.parse(xhr.responseText);
                    let tabla: string = "";
                    tabla += "<table border=1 style='width:100%' text-aling='center'> <thead>";
                    tabla += "<tr>";
                    tabla += "<th>email</th>";
                    tabla += "<th>clave</th>";
                    tabla += "<th>ciudad</th>";
                    tabla += "</tr> </thead>";

                    for (let i = 0; i < arrayJson.length; i++) {
                        let ciudadano = JSON.parse(arrayJson[i]);
              
                        tabla += "<tr>";
                        tabla += "<td>" + ciudadano.email + "</td>";
                        tabla += "<td>" + ciudadano.clave + "</td>";
                        tabla += "<td>" + ciudadano.ciudad + "</td>";

                
                        tabla += "</tr>";
                    }
                    tabla += "</table>";
                    (<HTMLInputElement>document.getElementById("divTabla")).innerHTML = tabla;
                }
            };
        }

        public static VerificarExistencia() {
            let xhr: XMLHttpRequest = new XMLHttpRequest();
            
            let email: string = (<HTMLInputElement>document.getElementById("correo")).value;
            let clave: string = (<HTMLSelectElement>document.getElementById("clave")).value;

            let form: FormData = new FormData();

            form.append('email', email);
            form.append('clave', clave);
            xhr.open('POST', './BACKEND/VerificarCiudadano.php', true);
            xhr.setRequestHeader("enctype", "multipart/form-data");
            xhr.send(form);

            xhr.onreadystatechange = () => {
                if (xhr.readyState == 4 && xhr.status == 200) {

                    let rta = JSON.parse(xhr.responseText);

               
                        alert(rta.mensaje);
                        console.log(rta.mensaje);
           

                }

            };
        }



        public static AgregarCiudadSinFoto()
        {
            let xhr: XMLHttpRequest = new XMLHttpRequest();
            let nombre: string = (<HTMLInputElement>document.getElementById("nombre")).value;
            let poblacion: string = (<HTMLSelectElement>document.getElementById("poblacion")).value;
            let pais: string = (<HTMLInputElement>document.getElementById("cboPais")).value;

            let form: FormData = new FormData();

            form.append('nombre', nombre);
            form.append('poblacion', poblacion);
            form.append('pais', pais);
            xhr.open('POST', './BACKEND/AgregarCiudadSinFoto.php', true);
            xhr.setRequestHeader("enctype", "multipart/form-data");
            xhr.send(form);

            xhr.onreadystatechange = () => {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    console.log(xhr.responseText);
                    let retJSON = JSON.parse(xhr.responseText);
                   
                        console.info("Todo ok");
                    
                    
                }
            };
        }

        public static MostrarCiudades()
        {
            let xhr: XMLHttpRequest = new XMLHttpRequest();

            xhr.open('GET', './BACKEND/ListadoCiudades.php', true);
            xhr.setRequestHeader("enctype", "multipart/form-data");
            xhr.send();

            xhr.onreadystatechange = () => {
                if (xhr.readyState == 4 && xhr.status == 200) {

                    let tabla : any = (<HTMLInputElement>document.getElementById("divTabla"));
                    tabla.innerHTML = xhr.responseText;

                 
                }
            };
        }

        public static AgregarVerificarCiudad()
        {
            let xhr: XMLHttpRequest = new XMLHttpRequest();
            let nombre: string = (<HTMLInputElement>document.getElementById("nombre")).value;
            let poblacion: string = (<HTMLSelectElement>document.getElementById("poblacion")).value;
            let pais: string = (<HTMLInputElement>document.getElementById("cboPais")).value;

            let foto: any = (<HTMLInputElement>document.getElementById("foto"));
     

            let form: FormData = new FormData();

            form.append('nombre', nombre);
            form.append('poblacion', poblacion);
            form.append('pais', pais);
            form.append('foto', foto.files[0]);
            xhr.open('POST', './BACKEND/AgregarCiudad.php', true);
            xhr.setRequestHeader("enctype", "multipart/form-data");
            xhr.send(form);

            xhr.onreadystatechange = () => {
                if (xhr.readyState == 4 && xhr.status == 200) {

                    let retJSON = JSON.parse(xhr.responseText);
                   
                        console.log(retJSON.mensaje);
                        alert(retJSON.mensaje);
                        this.MostrarCiudades();
                }
            };
        }

        public static ElimianarCiudad(ciudad : any)
        {
            let xhr: XMLHttpRequest = new XMLHttpRequest();

        
            let form: FormData = new FormData();

            form.append('ciudad_json', ciudad);
            form.append('accion', "borrar");
            xhr.open('POST', './BACKEND/EliminarCiudad.php', true);
            xhr.setRequestHeader("enctype", "multipart/form-data");
            xhr.send(form);

            xhr.onreadystatechange = () => {
                if (xhr.readyState == 4 && xhr.status == 200) {

                    let retJSON = JSON.parse(xhr.responseText);
                   
                        console.log(retJSON.mensaje);
                        alert(retJSON.mensaje);
                        this.MostrarCiudades();
                }
            };
        }



    }
}
