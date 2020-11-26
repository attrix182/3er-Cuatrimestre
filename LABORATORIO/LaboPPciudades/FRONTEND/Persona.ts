
namespace Entidades {

    export class Persona {

        email:string;
        clave:number;

        public constructor(email:string, clave:number)
        {
            this.email = email;
            this.clave = clave;

            
        }

        public ToString(): string {
            return `{"email":"${this.email}","clave":${this.clave},`;
        }

    }


}