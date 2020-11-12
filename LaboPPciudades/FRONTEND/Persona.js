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
