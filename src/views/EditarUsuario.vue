<template>
    <div :class='contentClass'>
        <div :class="menuClass">
            <MenuLateral @collapsed-updated="updateCollapsed" v-if="showSidebar" :menuItems="menuItems"
                @menu-item-click="handleMenuItemClick" />
        </div>
        <br />
        <div class="container">
            <form action="" class="form-hor-horizontal"></form>
            <div class="form-group left">
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="nombre" id="nombre" v-model="form.nombre"
                        placeholder="Nombre Completo">
                </div>
            </div>

            <div class="form-group left">
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="telefono" id="telefono" v-model="form.telefono"
                        placeholder="Teléfono">
                </div>
            </div>

            <div class="form-group left">
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="dni" id="dni" v-model="form.dni" placeholder="Cédula">
                </div>
            </div>

            <div class="form-group left">
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="correo" id="correo" v-model="form.correo"
                        placeholder="Correo">
                </div>
            </div>

            <div class="form-group left">
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="direccion" id="direccion" v-model="form.direccion"
                        placeholder="Estatus">
                </div>
            </div>

            <div class="form-group left">
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="direccion" id="direccion" v-model="form.direccion"
                        placeholder="Usuario">
                </div>
            </div>

            <div class="form-group">

                <br />
                <button type="button" class="btn btn-primary" v-on:click="Editar()">Guardar</button>
                <button type="button" class="btn btn-danger margen" v-on:click="Eliminar()">Eliminar</button>
                <button type="button" class="btn btn-dark margen" v-on:click="Salir()">Salir</button>




            </div>
        </div>
        <Footer />
    </div>
</template>
<script>
import MenuLateral from "@/components/MenuLateral.vue";
import Footer from '@/components/FooterVue.vue';

import axios from 'axios';

export default {
    name: "EditarUsuario",
    components: {
        Footer,
        MenuLateral,
    },
    data: function () {
        return {
            form: {
                "pacienteId": "",
                "nombre": "",
                "dni": "",
                "correo": "",
                "codigoPostal": "",
                "genero": "",
                "telefono": "",
                "fechaNacimiento": "",
                "token": ""
            },
            showSidebar: true,
            isCollapsed: false,
        }
    },
    computed: {
        contentClass() {
            return this.isCollapsed ? 'full' : 'collap';
        },
    },
    methods: {
        editar() {
            axios.put("https://api.solodata.es/pacientes", this.form)
                .then(datos => {
                    console.log(datos);
                    this.$router.push("/EditarUsuario");
                })
        },
        salir() {
            this.$router.push("/UsuaNuev");

        },
        eliminar() {
            var enviar = {
                "pacienteId": this.form.pacienteId,
                "token": this.form.token
            };
            axios.delete("https://api.solodata.es/pacientes", { headers: enviar })
                .then(datos => {
                    this.$router.push("/EditarUsuario");
                    console.log(datos);
                });
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
    mounted: function () {
        this.form.pacienteId = this.$route.params.id;
        axios.get("https://api.solodata.es/pacientes?id=" + this.form.pacienteId)
            .then(data => {

                this.form.nombre = data.data[0].Nombre;
                this.form.dni = data.data[0].DNI;
                this.form.correo = data.data[0].Correo;
                this.form.codigoPostal = data.data[0].CodigoPostal;
                this.form.genero = data.data[0].Genero;
                this.form.telefono = data.data[0].Telefono;
                this.form.fechaNacimiento = data.data[0].FechaNacimiento;
                this.form.token = localStorage.getItem("token");
                console.log(this.form);
            })

    }
}
</script>

<style scoped>
.left {
    text-align: left;
    margin: 20px;
}

.full {
    width: 100%;
    padding-left: 97px;
    padding-right: 40px;
}

.collap {
    width: 100%;
    padding-left: 251px;
    padding-right: 50px;
}
</style>