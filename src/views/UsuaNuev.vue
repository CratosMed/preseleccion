<template>
  <div>
    <br />
    <div class="container">
      <div class="form-group left">
        <div class="col-sm-10">
          <input type="text" class="form-control" name="nombre" id="nombre" v-model="form.nombre"
            placeholder="Nombre Completo" />
        </div>
      </div>

      <div class="form-group left">
        <div class="col-sm-10">
          <input type="text" class="form-control" name="telefono" id="telefono" v-model="form.telefono"
            placeholder="Teléfono" />
        </div>
      </div>

      <div class="form-group left">
        <div class="col-sm-10">
          <input type="text" class="form-control" name="dni" id="dni" v-model="form.dni" placeholder="Cédula" />
        </div>
      </div>

      <div class="form-group left">
        <div class="col-sm-10">
          <input type="text" class="form-control" name="correo" id="correo" v-model="form.correo"
            placeholder="Correo" />
        </div>
      </div>

      <div class="form-group left">
        <div class="col-sm-10">
          <input type="text" class="form-control" name="direccion" id="direccion" v-model="form.direccion"
            placeholder="Estatus" />
        </div>
      </div>

      <div class="form-group left">
        <div class="col-sm-10">
          <input type="text" class="form-control" name="correo" id="correo" v-model="form.correo"
            placeholder="Usuario" />
        </div>
      </div>

      <div class="form-group left">
        <div class="col-sm-10">
          <input type="text" class="form-control" name="direccion" id="direccion" v-model="form.direccion"
            placeholder="Contraseña" />
        </div>
      </div>
      <div class="form-group">
        <br />
        <button type="button" class="btn btn-primary" v-on:click="guardar()">
          Guardar
        </button>
        <button type="button" class="btn btn-dark margen" v-on:click="salir()">
          Salir
        </button>
      </div>
      <Footer />
    </div>
  </div>
</template>

<script>

import Footer from '@/components/FooterVue.vue';
import axios from "axios";

export default {
  name: "UsuaNuev.vue",
  data: function () {
    return {
      form: {
        nombre: "",
        direccion: "",
        dni: "",
        correo: "",
        codigoPostal: "",
        genero: "",
        telefono: "",
        fechaNacimiento: "",
        token: "",
      },
    }
  },
  components: {
    Footer,
  },
  methods: {
    guardar() {
      this.form.token = localStorage.getItem("token");
      axios
        .post("https://api.solodata.es/pacientes", this.form)
        .then(data => {
          console.log(data);
          this.makeToast("Hecho", "paciente creado", "success");
          this.$router.push("UsuaNuev.vue");
        }).catch(error => {
          console.log(error);
          this.makeToast("error", "error al guardar", "error");
        })
    },
    salir() {
      this.$router.push("UsuaNuev.vue");
    },

    makeToast(titulo, texto, tipo) {
      this.toastCount++
      this.$bvToast.toast(texto, {
        title: titulo,
        variant: tipo,
        autoHideDelay: 50000000,
        appendToast: true,
      });
    },
  },
};
</script>

<style scoped>
.left {
  text-align: left;
  margin: 20px;
}
</style>