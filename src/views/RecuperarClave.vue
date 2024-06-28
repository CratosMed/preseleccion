<template>
    <div>
        <div class="container fade-in-down">
            <div class="home">
                <div class="wrapper ">
                    <div id="formContent" v-if="nuevaClave != true" class="">
                        <!-- Tabs Titles -->
                        <br>
                        <!-- Icon -->
                        <div class="fadeIn first">
                            <img src="@/assets/logo5.png" id="icon" alt="User Icon" />
                        </div>
                        <br>
                        <!-- Login Form -->
                        <h6>
                            Ingrese su correo eletrónico registrado en el sistema
                        </h6>
                        <input type="text" id="correo" class="fadeIn fourth col-lg-6 col-sm-12 btn btn-primary"
                            name="correo" placeholder="Correo electrónico" v-model="correo">
                        <br>
                        <br>

                        <button class="fadeIn fourth btn btn-primary custom-btn" @click="forgotPassword">Enviar</button>
                        <!-- Remind Passowrd -->
                        <div class="alert alert-danger" role="alert" v-if="error">
                            {{ error_msg }}
                        </div>
                        <br>
                        <br>

                    </div>
                    <div v-if="nuevaClave" id="formContent" class="">
                        <!-- Tabs Titles -->
                        <br>
                        <!-- Icon -->
                        <div class="fadeIn first">
                            <img src="@/assets/logo5.png" id="icon" alt="User Icon" />
                        </div>
                        <br>
                        <!-- Login Form -->
                        <h6>
                            Establezca su nueva clave
                        </h6>
                        <input type="text" id="claveActual" v-model="claveActual"
                            class="fadeIn fourth col-lg-6 col-sm-12 btn btn-primary" name="correo"
                            placeholder="Clave actual ">
                        <input type="text" id="nuevaClave" class="fadeIn fourth col-lg-6 col-sm-12 btn btn-primary"
                            name="correo" placeholder="Nueva Clave " v-model="newClave">
                        <input type="text" id="confirClave" class="fadeIn fourth col-lg-6 col-sm-12 btn btn-primary"
                            name="correo" placeholder="Confirmar Clave" v-model="confirmarClave">
                        <br>
                        <br>

                        <button class="fadeIn fourth btn btn-primary custom-btn" @click="comparePassword">Listo</button>
                        <!-- Remind Passowrd -->
                        <div class="alert alert-danger" role="alert" v-if="error">
                            {{ error_msg }}
                        </div>
                        <br>
                        <br>

                    </div>
                </div>

            </div>
        </div>

    </div>
</template>


<script>
// @ is an alias to /src
import axios from 'axios';
export default {
    name: 'RecuperarClave',
    components: {

    },
    data: function () {
        return {
            error: false,
            error_msg: "",
            showSidebar: false,
            nuevaClave: false, //
            form: {
                "id_usuario": "",
                "clave": "",
                "estatus": "",
                "estado": "",
                "usuario": "",
                "nombre": "",
                "apellido": "",
                "cedula": "",
                "correo": "",
                "imagen": "",
                "token": ""
            }
        };

    },
    methods: {
        forgotPassword() {
            let json = {
                "correo": this.correo
            };

            axios.post('auth.php?forgot', json)
                .then(response => {
                    alert(response.data.message);
                    this.nuevaClave = true
                })
                .catch(error => {
                    alert("Ha ocurrido un error al enviar la solicitud de restablecimiento de contraseña.");
                    console.log(error.message);
                });
        },
        comparePassword() {
            let correo = this.correo;
            let pass = this.claveActual;
            let direccion = "http://localhost/preseleccion/sistemaapi/apirest/auth.php?correo=" + correo + "&pass=" + pass
            console.log(direccion)
            axios.get(direccion).then(datos => {
                console.log(datos)
                if (this.confirmarClave == this.newClave) {
                    this.form.clave = this.confirmarClave
                }
                this.form.id_usuario = datos.data[0].id_usuario;
                this.form.estatus = datos.data[0].estatus;
                this.form.estado = datos.data[0].estado;
                this.form.usuario = datos.data[0].usuario;
                this.form.nombre = datos.data[0].nombre;
                this.form.apellido = datos.data[0].apellido;
                this.form.cedula = datos.data[0].cedula;
                this.form.correo = datos.data[0].correo;
                this.form.imagen = datos.data[0].imagen;
                this.updatePassword()

                console.log(this.form)
            })
                .catch(error => {
                    console.error('Clave anterior no coiciden', error);
                });
        },
        updatePassword() {
            axios.put("http://localhost/preseleccion/sistemaapi/apirest/auth.php", this.form)
                .then(datos => {
                    console.log(datos);
                })
        }

        //metodo para cambiar clave mediante verificacion por correo.
        /*forgotPassword() {
            let json = {
                "correo": this.correo
            };
            console.log(json.correo);
            axios.post('auth.php?forgot', json)
                .then(response => {
                    alert(response.data.message);
                    console.log(response.data);
                })
                .catch(error => {
                    alert("Ha ocurrido un error al enviar la solicitud de restablecimiento de contraseña.");
                    console.log(error.message);
                });
        },*/
    },


}
</script>

<style scoped>
.custom-btn {
    background-color: #41B4D3;
}

.custom-btn:hover {
    background-color: hsl(218, 41%, 15%);
}

body {
    font-family: "Poppins", sans-serif;
    height: 100vh;
}

a {
    color: #92badd;
    display: inline-block;
    text-decoration: none;
    font-weight: 400;
}

h2 {
    text-align: center;
    font-size: 16px;
    font-weight: 600;
    text-transform: uppercase;
    display: inline-block;
    margin: 40px 8px 10px 8px;
    color: #cccccc;
}

.wrapper {
    display: flex;
    align-items: center;
    flex-direction: column;
    justify-content: center;
    width: 100%;
    min-height: 100%;
    padding: 20px;
}

#formContent {
    border-radius: 10px;
    background: #fff;
    width: 100%;
    max-width: 450px;
    padding: 20px;
    box-shadow: 0 30px 60px 0 rgba(0, 0, 0, 0.3);
    text-align: center;
}

input[type=button],
input[type=submit],
input[type=reset] {
    background-color: #41B4D3;
    border: none;
    color: white;
    padding: 10px 50px;
    text-align: center;
    display: inline-block;
    text-transform: uppercase;
    font-size: 13px;
    box-shadow: 0 10px 30px 0 rgba(95, 186, 233, 0.4);
    border-radius: 5px;
    margin: 5px 20px 40px 20px;
    transition: all 0.3s ease-in-out;
}

input[type=button]:hover,
input[type=submit]:hover,
input[type=reset]:hover {
    background-color: #39ace7;
}

input[type=button]:active,
input[type=submit]:active,
input[type=reset]:active {
    transform: scale(0.95);
}

input[type=text] {
    background-color: #f6f6f6;
    border: none;
    color: #0d0d0d;
    padding: 15px 32px;
    text-align: center;
    display: inline-block;
    font-size: 16px;
    margin: 5px;
    width: 90%;
    border: 2px solid #f6f6f6;
    transition: all 0.5s ease-in-out;
    border-radius: 5px;
}

input[type=text]:focus {
    background-color: #fff;
    border-bottom: 2px solid #5fbae9;
}

.fadeIn {
    opacity: 0;
    animation: fadeIn ease-in 1s forwards;
}

.fadeIn.first {
    animation-delay: 0.4s;
}

.fadeIn.fourth {
    animation-delay: 1s;
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }
}

.underlineHover:hover {
    color: #0d0d0d;
}

#icon {
    width: 45%;
}

/* Media Queries for responsiveness */
@media (max-width: 767px) {
    .wrapper {
        width: 100%;
    }

    #formContent {
        width: 100%;
        padding: 20px;
    }
}

@media (min-width: 768px) and (max-width: 991px) {
    #formContent {
        width: 80%;
    }
}

@media (min-width: 992px) and (max-width: 1199px) {
    #formContent {
        width: 60%;
    }
}

@media (min-width: 1200px) {
    #formContent {
        width: 50%;
    }
}
</style>
