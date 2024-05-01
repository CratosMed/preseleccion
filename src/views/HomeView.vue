<template>
  <div>
    <div class="row">
      <!-- Tarjeta de bienvenida -->
      <div class="bg-white text-dark col-12 text-center py-3">
        <h5 class="m-0"> <img src="@/assets/logo.png" class="logo1" alt="Logo"> Universidad Nacional Experimental
          Simón
          Rodríguez-UNESR. Núcleo "Valles del Tuy" <br /> </h5>
      </div>
    </div>
    <div class="row">
      <!-- Formulario de inicio de sesión -->
      <div class="col-lg-2"></div>
      <div class="col-lg-4 col-md-4 container mt-5 mb-5 mb-lg-0" style="z-index: 10">
        <h1 class="my-5 display-5 fw-bold ls-tight margen" style="color: hsl(218, 81%, 95%)">
          Bienvenidos a <span class="texto" style="color: hsl(218, 81%, 75%)"> Presélek</span> el Sistema de
          Preselección
          de
          Cursos <br />
        </h1>
        <div class="top d-none d-lg-block">
        </div>
      </div>
      <div class="col-lg-6  col-md-8 mt-4  col-sm-10 container  fade-in-down">
        <div class="home">
          <div class="wrapper">
            <div id="formContent">
              <!-- Icono -->
              <div class="fadeIn first">
                <img src="@/assets/logo5.png" class="logo" alt="Logo">
              </div>
              <br />
              <!-- Formulario de inicio de sesión -->
              <form v-on:submit.prevent="login">
                <input type="text" id="login" class="fadeIn second form-control mb-3" name="login" placeholder="Usuario"
                  v-model="usuario">
                <input type="password" id="clave" class="fadeIn third form-control mb-3" name="password"
                  placeholder="Contraseña" v-model="clave">
                <div class="text-center">
                  <!-- Cambio de color del botón de inicio -->
                  <input type="submit" class="fadeIn fourth btn btn-primary custom-btn" value="Inicio">
                </div>
              </form>
              <!-- Enlace para cambiar la clave -->
              <p @click="recuperarclave" class="mt-3" style="text-decoration: underline; cursor: pointer;">Cambiar Clave
              </p>
              <!-- Mensaje de error -->
              <div class="alert alert-danger mt-3" role="alert" v-if="error">
                {{ error_msg }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'HomeView',
  data() {
    return {
      usuario: "",
      clave: "",
      error: false,
      error_msg: "",
    };
  },
  methods: {
    recuperarclave() {
      // Redirigir a la página de recuperar contraseña
      this.$router.push('/RecuperarClave');
    },
    login() {
      let json = {
        "usuario": this.usuario,
        "clave": this.clave
      };

      axios.post('auth.php', json)
        .then(data => {
          if (data.data.status == "ok") {
            localStorage.token = data.data.result.token;
            this.token = localStorage.getItem("token");
            let direccion3 = "http://localhost/preseleccion/sistemaapi/apirest/auth.php?token=" + this.token;
            axios.get(direccion3).then(datos => {
              this.estatus = datos.data;
              if (this.estatus[0].estatus === 'usuario') {
                const cedula = this.estatus[0].cedula;
                this.$router.push('preseleccion/' + cedula);
              } else {
                this.$router.push('inicio');
              }
            })
          } else {
            this.error = true;
            this.error_msg = data.data.result.error_msg;
          }
        });
    }
  },
  mounted() {
    // Agrega la clase 'show' después de que el componente se monta para activar la transición
    this.$nextTick(() => {
      const element = this.$el.querySelector('.fade-in-down');
      if (element) {
        element.classList.add('show');
      }
    });
  }
}
</script>

<style scoped>
.fade-in-down {
  opacity: 0;
  /* Establece la opacidad inicial en 0 para que el contenedor esté oculto */
  transform: translateY(-20px);
  /* Desplaza el contenedor hacia arriba */
  transition: opacity 0.5s ease-in-out, transform 0.5s ease-in-out;
  /* Aplica transiciones a la opacidad y al desplazamiento */
}

.fade-in-down.show {
  opacity: 1;
  /* Cuando se agrega la clase 'show', establece la opacidad en 1 para que el contenedor aparezca */
  transform: translateY(0);
  /* Elimina el desplazamiento hacia arriba */
}

.logo1 {
  max-width: 100%;
  width: 93.5px;
  height: 52.4px;
}

.logo {
  max-width: 100%;
  width: 50%;
  height: auto;
}

.wrapper {
  padding: 20px;
}

#formContent {
  background: rgba(255, 255, 255, 0.8);
  border-radius: 10px;
  padding: 30px;
  max-width: 450px;
  margin: auto;
  box-shadow: 0 30px 60px 0 rgba(0, 0, 0, 0.3);
  text-align: center;
}

/* Estilo personalizado para el botón de inicio */
.custom-btn {
  background-color: #41B4D3;
}

.custom-btn:hover {
  background-color: hsl(218, 41%, 15%);
}

/* Animación de fade */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}

.fade-enter,
.fade-leave-to

/* .fade-leave-active en <2.1.8 */
  {
  opacity: 0;
}

@media (max-width: 576px) {
  #formContent {
    padding: 20px;
  }
}
</style>
