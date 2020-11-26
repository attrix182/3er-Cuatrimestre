
namespace Entidades {

    export class Ciudadano extends Persona {


        ciudad: string;


        public constructor(email: string, clave: number, ciudad: string) {
            super(email, clave);
            this.ciudad = ciudad;

        }


        public ToJSON(): any {

            let retornoJSON= `${super.ToString()}"email":"${this.email}","ciudad":"${this.ciudad}"}`;
            return JSON.parse(retornoJSON);

        }


    }


}