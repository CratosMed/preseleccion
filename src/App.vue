<template>
  <div class="full-screen" id="app">
    <div class="content">
      <router-view />
    </div>

    <div class="margen"></div>

    <footer class="footer text-light py-3">
      <div class="container">
        <div class="row">
          <!-- Sección 1 -->
          <div class="col-md-4">
            <p class="mb-0"><a @click="redireccionarInicio" class="text-light"
                style="text-decoration: underline; cursor: pointer;">Inicio</a></p>
          </div>

          <!-- Sección 2 -->
          <div class="col-md-4">
            <p class="mb-0"> Desarrollado por:<br /> Katherine Urbina <br />(16/04/2024)</p>
          </div>

          <!-- Sección 3 -->
          <div class="col-md-4">
            <p class="mb-0"><a @click="irASobreNosotros" class="text-light"
                style="text-decoration: underline; cursor: pointer;">Sobre Nosotros</a></p>
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
      if (this.rutaAnterior == '1') {
        this.rutaAnterior = this.$route.path;
        this.$router.push('/sobreNosotros');
      } else {
        this.$router.push('/sobreNosotros');
      }
    },
    redireccionarInicio() {
      const token = localStorage.getItem('token')
      if (!token) {
        this.$router.push('/')
      } else {
        let direccion3 = "http://localhost/preseleccion/sistemaapi/apirest/auth.php?token=" + token;

        axios.get(direccion3).then(datos => {
          this.data = datos.data;
          const estatus = this.data[0].estatus
          const rutaActual = this.$route.path;

          if (rutaActual === '/login') {
            this.$router.push('/login');
          } else if (rutaActual == '/sobreNosotros' && estatus == 'admin') {
            this.$router.push('/inicio');
          } else if (rutaActual === '/sobreNosotros' && estatus == 'usuario') {
            this.$router.push('/preseleccion/' + this.data[0].cedula);
          } else if (estatus == 'admin') {
            this.$router.push('/inicio');
          } else if (estatus == 'usuario') {
            this.$router.push('/preseleccion/' + this.data[0].cedula);
          }
          console.log(this.data)
        })
      }

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
  width: 100%;
}

.margen {
  margin-top: 0%;
}

.full-screen {
  justify-content: center;
  background: url(@/assets/4920971.jpg);
  background-size: cover;
  background-repeat: no-repeat;
}

/* Personalización de los enlaces en el footer */
footer a {
  color: blanchedalmond;
  text-decoration: none;
}

footer a:hover {
  text-decoration: underline;
}

.footer {
  background-color: hsl(218, 41%, 15%);
}
</style>
