<template>
    <div>
        <div class="container fade-in-down">
            <div class="home">
                <div class="wrapper fadeInDown ">
                    <div id="formContent" class="">
                        <!-- Tabs Titles -->
                        <br>
                        <!-- Icon -->
                        <div class="fadeIn first">
                            <img src="@/assets/logo5.png" id="icon" alt="User Icon" />
                        </div>
                        <!-- Login Form -->
                        <h6>
                            Establezca su nueva clave
                        </h6>
                        <input type="text" id="correo" class="fadeIn fourth col-lg-6 col-sm-12 btn btn-primary"
                            name="correo" placeholder="Clave actual " v-model="correo">
                        <input type="text" id="correo" class="fadeIn fourth col-lg-6 col-sm-12 btn btn-primary"
                            name="correo" placeholder="Nueva Clave " v-model="correo">
                        <input type="text" id="correo" class="fadeIn fourth col-lg-6 col-sm-12 btn btn-primary"
                            name="correo" placeholder="Confirmar Clave" v-model="correo">
                        <br>
                        <br>

                        <button class="fadeIn fourth btn btn-primary custom-btn" @click="forgotPassword">Listo</button>
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
    name: 'RecuperarClavepaso2',
    components: {

    },
    data: function () {
        return {

            usuario: "",
            clave: "",
            error: false,
            error_msg: "",
            showSidebar: false,
        };

    },
    methods: {
        forgotPassword() {
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
        },
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

.custom-btn {
    background-color: #41B4D3;
}

.custom-btn:hover {
    background-color: hsl(218, 41%, 15%);
}
</style>
