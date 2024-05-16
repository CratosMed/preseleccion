<template>
    <div>
        <section>
            <div class="position-relative ">
                <br>
                <br>
                <strong>
                    <h3 class="fuente font-weight-bold">Participante: {{ form.nombre }} {{ form.apellido }}</h3>
                </strong>
                <hr class="linea">
                <div class="container alto">
                    <div class="row  container">
                        <div class="col-sm-12 col-md-6 col-xl-4">
                            <div class="form-group left">
                                <div class="form-floating ">
                                    <input type="text" class="form-control " :disabled=this.form.editar name="cedula"
                                        id="cedula" v-model="form.cedula" placeholder="Cedula">
                                    <label for="cedula">Cédula:</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-xl-4">
                            <div class="form-group left">
                                <div class="form-floating ">
                                    <input type="text" class="form-control" name="nombre" :disabled=this.form.editar
                                        id="nombre" v-model="form.nombre" placeholder="Nombre">
                                    <label for="nombre">Nombre:</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-xl-4">
                            <div class="form-group left">
                                <div class="form-floating ">
                                    <input type="text" class="form-control" :disabled=this.form.editar name="apellido"
                                        id="apellido" v-model="form.apellido" placeholder="Apellido">
                                    <label for="apellido">Apellido:</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row container">
                        <div class="col-sm-12 col-md-6 col-xl-4">
                            <div class="form-group left">
                                <div class="form-floating ">
                                    <input type="date" class="form-control" :disabled=this.form.editar
                                        name="fecha_nacimiento" id="fecha_nacimiento" v-model="form.fecha_nacimiento"
                                        placeholder="fecha de Nacimiento">
                                    <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-xl-4">
                            <div class="form-group left">
                                <div class="form-floating ">
                                    <input type="text" class="form-control" :disabled=this.form.editar name="telefono"
                                        id="telefono" v-model="form.telefono" placeholder="Telefono">
                                    <label for="telefono">Teléfono:</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-xl-4">
                            <div class="form-group left">
                                <div class="form-floating">
                                    <select class="form-control" :disabled="form.editar" name="carrera" id="carrera"
                                        v-model="form.carrera">
                                        <option value="Educación Inicial">Administración Mención RRHH</option>
                                        <option value="Educación Integral">Administración Mención RMF</option>
                                        <option value="Administración de Recursos Humanos">Administración Mención
                                            Informatica</option>
                                        <option value="Administración de Informática y Recursos Humanos">Administración
                                            Mención Mercadeo </option>
                                        <option value="Educación Inicial">Educación Integra</option>
                                        <option value="Educación Inicial">Educación Inicial</option>
                                    </select>
                                    <label for="carrera">Carrera:</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-xl-12">
                            <div class="form-group left">
                                <div class="form-floating">
                                    <input type="text" class="form-control" :disabled=this.form.editar name="direccion"
                                        id="direccion" v-model="form.direccion" placeholder="Direccion">
                                    <label for="direccion">Dirección:</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row container">
                        <div class="col-sm-12 col-md-6 col-xl-4">
                            <div class="form-group left">
                                <div class="form-floating ">
                                    <input type="text" class="form-control" :disabled=this.form.editar
                                        name="u_c_acumuladas" id="u_c_acumuladas" v-model="form.u_c_acumuladas"
                                        placeholder="U/C">
                                    <label for="u_c_acumuladas">Unidad de crédito acumulada:</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-xl-4">
                            <div class="form-group left">
                                <div class="form-floating">
                                    <select class="form-control" :disabled="form.editar" name="sexo" id="sexo"
                                        v-model="form.sexo">
                                        <option value="Educación Inicial">Femenino</option>
                                        <option value="Educación Integral">Masculino</option>
                                    </select>
                                    <label for="sexo">Género:</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-xl-4">
                            <div class="form-group left">
                                <div class="form-floating ">
                                    <input type="text" class="form-control" :disabled=this.form.editar name="correo"
                                        id="correo" v-model="form.correo" placeholder="Correo">
                                    <label for="correo">Correo:</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <br />
                        <button class="btn btn-primary izquierda1" v-bind:message="message" id="Editar"
                            v-on:click="cambiarBoton()">
                            {{ message }}
                            <Icon icon="bx:user-plus" width="18" height="18" />
                        </button>

                        <button class="btn btn-danger izquierda2" v-on:click="eliminar()"> Eliminar
                            <Icon icon="bx:user-plus" width="18" height="18" />
                        </button>
                        <button class="btn btn-dark izquierda3" v-on:click="salir()"> Salir
                            <Icon icon="bx:user-plus" width="18" height="18" />
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import axios from 'axios';
// this.$route.fullPath
export default {
    name: "EditarVue",

    components: {


    },

    data: function () {
        return {
            message: "Editar",
            form: {
                "id_participante": "",
                "cedula": "",
                "nombre": "",
                "apellido": "",
                "fecha_nacimiento": "",
                "telefono": "",
                "direccion": "",
                "carrera": "",
                "u_c_acumuladas": "",
                "sexo": "",
                "correo": "",
                "token": "",
                guardar: false,
                editar: true,


            }
        }
    },


    methods: {

        cambiarBoton() {

            if (this.message === 'Editar') {
                this.form.editar = false;
                this.message = 'Guardar';
            } else {
                this.form.editar = true;
                this.message = 'Editar';
                axios.put("http://localhost/preseleccion/sistemaapi/apirest/participantes.php", this.form)
                    .then(datos => {
                        console.log(datos);
                        // this.$router.push("/Participantes");
                    })
            }
        },

        salir() {
            this.$router.push("/Participantes");

        },
        eliminar() {

            var enviar = {
                "id_participante": this.form.id_participante,
                "token": this.form.token
            };

            axios.delete("http://localhost/preseleccion/sistemaapi/apirest/participantes.php", { headers: enviar })
                .then(datos => {
                    this.$router.push("/Participantes");
                    console.log(datos);
                });
        },

    },

    mounted: function () {
        this.form.id_participante = this.$route.params.id;
        axios.get("http://localhost/preseleccion/sistemaapi/apirest/participantes.php?id=" + this.form.id_participante)
            .then(data => {
                this.form.cedula = data.data[0].cedula;
                this.form.nombre = data.data[0].nombre;
                this.form.apellido = data.data[0].apellido;
                this.form.fecha_nacimiento = data.data[0].fecha_nacimiento;
                this.form.telefono = data.data[0].telefono;
                this.form.direccion = data.data[0].direccion;
                this.form.carrera = data.data[0].carrera;
                this.form.u_c_acumuladas = data.data[0].u_c_acumuladas;
                this.form.sexo = data.data[0].sexo;
                this.form.correo = data.data[0].correo;
                this.form.token = localStorage.getItem("token");
                console.log(this.form);

            })
            .catch(e => console.error(e))

    }
}

</script>

<style scoped>
.linea {
    height: 3px;
    /* Grosor de la línea */
    background-color: #083e68;
    /* Color de la línea */
    border: none;
}

.fuente {
    font-family: 'Mukta', sans-serif;
}

.background-radial-gradient {
    background-color: hsl(218, 41%, 15%);
    background-image: radial-gradient(650px circle at 0% 0%,
            hsl(218, 41%, 35%) 15%,
            hsl(218, 41%, 30%) 35%,
            hsl(218, 41%, 20%) 75%,
            hsl(218, 41%, 19%) 80%,
            transparent 100%),
        radial-gradient(1250px circle at 100% 100%,
            hsl(218, 41%, 45%) 15%,
            hsl(218, 41%, 30%) 35%,
            hsl(218, 41%, 20%) 75%,
            hsl(218, 41%, 19%) 80%,
            transparent 100%);
}

#radius-shape-1 {
    height: 220px;
    width: 220px;
    top: 150px;
    left: 250px;
    background: radial-gradient(#44006b, #ad1fff);
    overflow: hidden;
}

#radius-shape-2 {
    border-radius: 38% 62% 63% 37% / 70% 33% 67% 30%;
    bottom: 250px;
    right: 300px;
    width: 300px;
    height: 300px;
    background: radial-gradient(#44006b, #ad1fff);
    overflow: hidden;
}

.left {
    text-align: left;
    margin: 20px;
}

.form-control {
    border-bottom: 1px solid #000000;
    border-radius: 20px;
    border-color: #464545;
}

.form-select:focus,
.form-control:focus {
    box-shadow: none;
    border-bottom-color: #2196f3;


}

.izquierda1 {
    text-align: right;
    background-color: #2196f3;
    font-size: 15px;
    margin: 0.25%;

}

.izquierda2 {
    text-align: right;
    background-color: #bb2d3b;
    font-size: 15px;
    margin: 0.25%;

}

.izquierda2 :hover {
    background-color: #302e2e;
}

.izquierda3 {
    text-align: right;
    background-color: #041b2d;
    font-size: 15px;
    margin: 0.25%;

}

.form-control:disabled {
    background-color: #F1F3F4;
    opacity: 1;
}

.alto {
    margin-top: 10%;

}

.position-relative {
    height: 1024px;
}
</style>