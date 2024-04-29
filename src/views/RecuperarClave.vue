<template>
    <div>
        <div class="col-lg-12 container">
            <div class="home">
                <div class="wrapper fadeInDown ">
                    <div id="formContent" v-if="nuevaClave != true" class="">
                        <!-- Tabs Titles -->
                        <br>
                        <br>
                        <!-- Icon -->
                        <div class="fadeIn first">
                            <img src="@/assets/logo5.png" id="icon" alt="User Icon" />
                        </div>
                        <br>
                        <br>
                        <!-- Login Form -->
                        <h6>
                            Ingrese su correo eletrónico registrado en el sistema
                        </h6>
                        <input type="text" id="correo" class="fadeIn fourth col-lg-6 col-sm-12 btn btn-primary"
                            name="correo" placeholder="Correo electrónico" v-model="correo">
                        <br>
                        <br>

                        <button class="fadeIn fourth btn btn-primary col-lg-6" @click="forgotPassword">Enviar</button>
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
                        <br>
                        <!-- Icon -->
                        <div class="fadeIn first">
                            <img src="@/assets/logo5.png" id="icon" alt="User Icon" />
                        </div>
                        <br>
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

                        <button class="fadeIn fourth btn btn-primary col-lg-6" @click="comparePassword">Listo</button>
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



/* STRUCTURE */

.wrapper {
    display: flex;
    align-items: center;
    flex-direction: column;
    justify-content: center;
    width: 80%;
    min-height: 100%;
    padding: 20px;
}

#formContent {
    -webkit-border-radius: 10px 10px 10px 10px;
    border-radius: 10px 10px 10px 10px;
    background: #fff;
    width: 90%;
    max-width: 450px;
    position: relative;
    padding: 0px;
    -webkit-box-shadow: 0 30px 60px 0 rgba(0, 0, 0, 0.3);
    box-shadow: 0 30px 60px 0 rgba(0, 0, 0, 0.3);
    text-align: center;
    margin-left: 270px;
}

#formFooter {
    background-color: #f6f6f6;
    border-top: 1px solid #dce8f1;
    padding: 25px;
    text-align: center;
    -webkit-border-radius: 0 0 10px 10px;
    border-radius: 0 0 10px 10px;
}



/* TABS */

h2.inactive {
    color: #cccccc;
}

h2.active {
    color: #0d0d0d;
    border-bottom: 2px solid #5fbae9;
}



/* FORM TYPOGRAPHY*/

input[type=button],
input[type=submit],
input[type=reset] {
    background-color: #41B4D3;
    border: none;
    color: white;
    padding: 10px 50px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    text-transform: uppercase;
    font-size: 13px;
    -webkit-box-shadow: 0 10px 30px 0 rgba(95, 186, 233, 0.4);
    box-shadow: 0 10px 30px 0 rgba(95, 186, 233, 0.4);
    -webkit-border-radius: 5px 5px 5px 5px;
    border-radius: 100px;
    margin: 5px 20px 40px 20px;
    -webkit-transition: all 0.3s ease-in-out;
    -moz-transition: all 0.3s ease-in-out;
    -ms-transition: all 0.3s ease-in-out;
    -o-transition: all 0.3s ease-in-out;
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
    -moz-transform: scale(0.95);
    -webkit-transform: scale(0.95);
    -o-transform: scale(0.95);
    -ms-transform: scale(0.95);
    transform: scale(0.95);
}

input[type=text] {
    background-color: #f6f6f6;
    border: none;
    color: #0d0d0d;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 5px;
    width: 55%;
    border: 2px solid #f6f6f6;
    -webkit-transition: all 0.5s ease-in-out;
    -moz-transition: all 0.5s ease-in-out;
    -ms-transition: all 0.5s ease-in-out;
    -o-transition: all 0.5s ease-in-out;
    transition: all 0.5s ease-in-out;
    -webkit-border-radius: 5px 5px 5px 5px;
    border-radius: 40px 40px 40px 40px;
}

input[type=text]:focus {
    background-color: #fff;
    border-bottom: 2px solid #5fbae9;
}

input[type=text]:placeholder {
    color: #cccccc;
}



/* ANIMATIONS */

/* Simple CSS3 Fade-in-down Animation */
.fadeInDown {
    -webkit-animation-name: fadeInDown;
    animation-name: fadeInDown;
    -webkit-animation-duration: 1s;
    animation-duration: 1s;
    -webkit-animation-fill-mode: both;
    animation-fill-mode: both;
}

@-webkit-keyframes fadeInDown {
    0% {
        opacity: 0;
        -webkit-transform: translate3d(0, -100%, 0);
        transform: translate3d(0, -100%, 0);
    }

    100% {
        opacity: 1;
        -webkit-transform: none;
        transform: none;
    }
}

@keyframes fadeInDown {
    0% {
        opacity: 0;
        -webkit-transform: translate3d(0, -100%, 0);
        transform: translate3d(0, -100%, 0);
    }

    100% {
        opacity: 1;
        -webkit-transform: none;
        transform: none;
    }
}

/* Simple CSS3 Fade-in Animation */
@-webkit-keyframes fadeIn {
    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }
}

@-moz-keyframes fadeIn {
    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }
}

.fadeIn {
    opacity: 0;
    -webkit-animation: fadeIn ease-in 1;
    -moz-animation: fadeIn ease-in 1;
    animation: fadeIn ease-in 1;

    -webkit-animation-fill-mode: forwards;
    -moz-animation-fill-mode: forwards;
    animation-fill-mode: forwards;

    -webkit-animation-duration: 1s;
    -moz-animation-duration: 1s;
    animation-duration: 1s;
}

.fadeIn.first {
    -webkit-animation-delay: 0.4s;
    -moz-animation-delay: 0.4s;
    animation-delay: 0.4s;
}

.fadeIn.second {
    -webkit-animation-delay: 0.6s;
    -moz-animation-delay: 0.6s;
    animation-delay: 0.6s;
}

.fadeIn.third {
    -webkit-animation-delay: 0.8s;
    -moz-animation-delay: 0.8s;
    animation-delay: 0.8s;
}

.fadeIn.fourth {
    -webkit-animation-delay: 1s;
    -moz-animation-delay: 1s;
    animation-delay: 1s;
}

/* Simple CSS3 Fade-in Animation */
.underlineHover:after {
    display: block;
    left: 0;
    bottom: -10px;
    width: 0;
    height: 2px;
    background-color: #56baed;
    content: "";
    transition: width 0.2s;
}

.underlineHover:hover {
    color: #0d0d0d;
}

.underlineHover:hover:after {
    width: 100%;
}



/* OTHERS */

*:focus {
    outline: none;
}

#icon {
    width: 45%;
}

#formContent {
    /* Estilos para la tarjeta de usuario y contraseña */
    background: rgba(255, 255, 255, 0.8);
    /* Opacidad */
    border-radius: 10px;
    padding: 30px;
    width: 90%;
    max-width: 450px;
    position: relative;
    padding: 0px;
    box-shadow: 0 30px 60px 0 rgba(0, 0, 0, 0.3);
    text-align: center;

}
</style>