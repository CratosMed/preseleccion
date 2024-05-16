<template>
  <div :class='contentClass'>
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
                  <input type="text" class="form-control " :disabled=this.form.editar name="cedula" id="cedula"
                    v-model="form.cedula" placeholder="Cedula">
                  <label for="cedula">Cédula:</label>
                </div>
              </div>
            </div>
            <div class="col-sm-12 col-md-6 col-xl-4">
              <div class="form-group left">
                <div class="form-floating ">
                  <input type="text" class="form-control" name="nombre" :disabled=this.form.editar id="nombre"
                    v-model="form.nombre" placeholder="Nombre">
                  <label for="nombre">Nombre:</label>
                </div>
              </div>
            </div>
            <div class="col-sm-12 col-md-12 col-xl-4">
              <div class="form-group left">
                <div class="form-floating ">
                  <input type="text" class="form-control" :disabled=this.form.editar name="apellido" id="apellido"
                    v-model="form.apellido" placeholder="Apellido">
                  <label for="apellido">Apellido:</label>
                </div>
              </div>
            </div>
          </div>
          <div class="row container">
            <div class="col-sm-12 col-md-6 col-xl-4">
              <div class="form-group left">
                <div class="form-floating ">
                  <input type="date" class="form-control" :disabled=this.form.editar name="fecha_nacimiento"
                    id="fecha_nacimiento" v-model="form.fecha_nacimiento" placeholder="fecha de Nacimiento">
                  <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                </div>
              </div>
            </div>
            <div class="col-sm-12 col-md-6 col-xl-4">
              <div class="form-group left">
                <div class="form-floating ">
                  <input type="text" class="form-control" :disabled=this.form.editar name="telefono" id="telefono"
                    v-model="form.telefono" placeholder="Telefono">
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
                  <input type="text" class="form-control" :disabled=this.form.editar name="direccion" id="direccion"
                    v-model="form.direccion" placeholder="Direccion">
                  <label for="direccion">Dirección:</label>
                </div>
              </div>
            </div>
          </div>
          <div class="row container">
            <div class="col-sm-12 col-md-6 col-xl-4">
              <div class="form-group left">
                <div class="form-floating ">
                  <input type="text" class="form-control" :disabled=this.form.editar name="u_c_acumuladas"
                    id="u_c_acumuladas" v-model="form.u_c_acumuladas" placeholder="U/C">
                  <label for="u_c_acumuladas">Unidad de crédito acumulada:</label>
                </div>
              </div>
            </div>
            <div class="col-sm-12 col-md-12 col-xl-4">
              <div class="form-group left">
                <div class="form-floating">
                  <select class="form-control" :disabled="form.editar" name="sexo" id="sexo" v-model="form.sexo">
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
                  <input type="text" class="form-control" :disabled=this.form.editar name="correo" id="correo"
                    v-model="form.correo" placeholder="Correo">
                  <label for="correo">Correo:</label>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <br />
            <button class="btn btn-primary izquierda1" v-on:click="guardar()">
              Guardar
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
    <MenuLateral @collapsed-updated="updateCollapsed" v-if="showSidebar" />
    <Footer />
  </div>
</template>

<script>
import MenuLateral from "@/components/MenuLateral.vue";

import Footer from '@/components/FooterVue.vue';
import axios from "axios";

export default {
  name: "NuevoVue",
  data: function () {
    return {
      showSidebar: true,
      isCollapsed: false,
      form: {
        nombre: "",
        direccion: "",
        cedula: "",
        correo: "",
        codigoPostal: "",
        genero: "",
        telefono: "",
        fechaNacimiento: "",
        token: "",
      },
      form2: {
        clave: "",
        estatus: "usuario",
        estado: "Activo",
        usuario: "",
        nombre: "",
        apellido: "",
        cedula: "",
        imagen: "",
        token: "",
      }
    }
  },
  components: {
    Footer,

    MenuLateral,




  },
  computed: {
    //menuClass() {
    //  return this.isCollapsed ? 'col-1' : 'col-1';
    //},
    contentClass() {
      return this.isCollapsed ? 'full' : 'collap';
    },
    //   contentClass1() {
    //     return this.isCollapsed ? 'd-none' : 'col-1';
    //  },

  },
  methods: {
    guardar() {
      this.form.token = localStorage.getItem("token");
      //crear participante
      axios
        .post("http://localhost/preseleccion/sistemaapi/apirest/participantes.php", this.form)
        .then(data => {
          console.log(data);
          this.crearUsuario()
          this.$router.push("Participantes");
        }).catch(error => {
          console.log(error);

        })

    },
    crearUsuario() {
      //crear usuario
      this.form2.token = localStorage.getItem("token");
      this.form2.clave = this.form.cedula;
      this.form2.nombre = this.form.nombre;
      this.form2.apellido = this.form.apellido;
      this.form2.cedula = this.form.cedula;
      this.form2.usuario = this.form.correo;
      axios
        .post("http://localhost/preseleccion/sistemaapi/apirest/usuario.php", this.form2)
        .then(data => {
          console.log(data);
          this.$router.push("Participantes");
        }).catch(error => {
          console.log(error);

        })
    },
    salir() {
      this.$router.push("Participantes");
    },


    updateCollapsed(value) {
      this.isCollapsed = value;
    },
  },
  watch: {
    $route(to) {
      // Consulta la meta "showSidebar" de la ruta actual
      this.showSidebar = to.meta.showSidebar !== false;

    }
  },
};
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