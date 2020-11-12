
namespace Entidades {

    export class Ciudad {


        id : number;
        nombre : string;
        poblacion : string;
        pais : string;
        foto : string;


        
        public constructor(id: number, nombre: string, poblacion: string, pais : string) {
            this.id = id;
            this.nombre = nombre;
            this.poblacion = poblacion;
            this.pais = pais;
        }


        public ToJSON(): any {

            let retornoJSON= `{"id":"${this.id}","nombre":${this.nombre},"poblacion":"${this.poblacion}","pais":${this.pais}"} `;
            return JSON.parse(retornoJSON);

        }





    }
}