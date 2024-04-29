<template>
  <div class="full-screen" id="app">
    <div class="content">
      <router-view />
    </div>


    <div class="margen">

    </div>

    <footer>
      <div class="container">
        <div class="row">
          <!-- Sección 1 -->
          <div class="col-md-4">
            <br />
            <p @click="redireccionarInicio" style="text-decoration: underline; cursor: pointer;">Inicio</p>
          </div>

          <!-- Sección 2 -->
          <div class="col-md-4">
            <br />
            <p> Desarrollado por:<br /> Katherine Urbina <br />(16/04/2024)<br />
            </p>
          </div>

          <!-- Sección 3 -->
          <div class="col-md-4">
            <br />
            <p @click="irASobreNosotros"><span style="text-decoration: underline; cursor: pointer;">Sobre
                Nosotros</span></p>
          </div>
        </div>
      </div>
    </footer>
  </div>
</template>
<script>
import axios from 'axios';
export default {

  data() {
    return {


      rutaAnterior: '1'
    };
  },
  mounted() {

  },
  methods: {
    irASobreNosotros() {
      //asignar ruta

      if (this.rutaAnterior == '1') {
        this.rutaAnterior = this.$route.path;
        this.$router.push('/sobreNosotros');
      } else {
        this.$router.push('/sobreNosotros');
      }
      // Navegar a la ruta "/sobreNosotros"


    },
    redireccionarInicio() {
      const token = localStorage.getItem('token')
      let direccion3 = "http://localhost/preseleccion/sistemaapi/apirest/auth.php?token=" + token;

      axios.get(direccion3).then(datos => {
        this.data = datos.data;
        const estatus = this.data[0].estatus
        const rutaActual = this.$route.path;
        console.log(rutaActual)

        if (rutaActual === '/login') {
          // Si estamos en la página de inicio de sesión, redireccionamos nuevamente a la misma página
          this.$router.push('/login');
        } else if (rutaActual == '/sobreNosotros' && estatus == 'admin') {
          // Si estamos en el dashboard y el usuario está logueado, permanecemos en el dashboard
          this.$router.push('/inicio');
        } else if (rutaActual === '/sobreNosotros' && estatus == 'usuario') {
          // Si estamos en la página de preselección y el usuario está logueado, permanecemos en preselección
          this.$router.push(this.rutaAnterior);
          console.log(estatus)

        } else {
          console.log(estatus)
        }

      })

    },
  },
};


</script>

<style>
.full {
  width: 100%;
}

#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

.content {
  flex: 1;
}

footer {
  height: 100px;
  width: 100%;
  background-color: #041B2D;
  color: blanchedalmond;
  text-align: center;
  padding: 0%;
}

.margen {
  margin-top: 0%;

}

.full-screen {

  /* Establece la altura al 100% de la altura del viewport */

  justify-content: center;
  /* Centra horizontalmente */
  /* Centra verticalmente */
  background: url(@/assets/4920971.jpg);
  /* Fondo de degradado azul */
  background-size: cover;
  /* Cubre todo el viewport */
  background-repeat: no-repeat;
  /* No se repite */

}
</style>
