<template>
    <div :class='contentClass'>
        <br />
        <MenuLateral @collapsed-updated="updateCollapsed" v-if="showSidebar" />
        <div class="">
            <div v-for="preseleccion in preselecciones" :key="preseleccion.curso_id"> </div>
        </div>

        <div class="container-center">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-sm-12 mt-4 ">
                    <div class="card border border-dark">
                        <div class="card-header bg-dark fuente">
                            <button @click="graficos()" class="card-header bg-dark fuente1">
                                <h4 class="titulo">Gráficos de Cursos</h4>
                            </button>
                        </div>
                        <div class="card-body">
                            <pie v-if="loaded" :data="chartData" :options="chartOptions" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12 mt-4 ">
                    <div class="card border border-dark">
                        <div class="card-header bg-dark fuente">
                            <button @click="preseleccion()" class="card-header bg-dark fuente1">
                                <h4 class="titulo">Preselecciones</h4>
                            </button>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Apellido</th>
                                        <th scope="col">Total_U/C</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="preseleccionview in preseleccionesview" :key="preseleccionview.cedula">

                                        <td> {{ preseleccionview.nombre }} </td>
                                        <td>{{ preseleccionview.apellido }}</td>
                                        <td>{{ preseleccionview.t_u_c }}</td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <br>

        </div>
        <br>
        <br>
        <br>
    </div>
</template>

<script>
import MenuLateral from "@/components/MenuLateral.vue";

import { Pie } from 'vue-chartjs'
import axios from 'axios';


import { Chart as ChartJS, Title, Tooltip, Legend, ArcElement, CategoryScale, LinearScale } from 'chart.js'
ChartJS.register(Title, Tooltip, Legend, ArcElement, CategoryScale, LinearScale)


export default {
    name: "DashboardView",

    data() {
        return {
            'token': '',
            estado: null,
            showSidebar: true,
            isCollapsed: false,
            loaded: false,
            //preseleccionesview: null,
            preselecciones: null,
            preseleccionesview: [],
            hola: 1,
            chartData: {
                labels: [],
                datasets: [{ label: 'Participantes', data: [], backgroundColor: ['#FF5733', '#3C9953', '#20589F'] }]
            },
            chartOptions: {
                responsive: true
            }
        };
    },
    components: {
        MenuLateral,

        Pie,
    },
    computed: {
        //menuClass() {
        //  return this.isCollapsed ? 'col-1' : 'col-1';
        //},
        contentClass() {
            return this.isCollapsed ? 'full' : 'collap';
        },
        slicedPreseleccionesView() {
            return this.preseleccionesview ? this.preseleccionesview.slice(0, 100) : [];
            //   contentClass1() {
            //     return this.isCollapsed ? 'd-none' : 'col-1';
            //  },

        },
    },
    methods: {
        graficos() {
            this.$router.push('/graficos');
        },
        preseleccion() {
            this.$router.push('/preselecciones');
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
        let direccion = "http://localhost/preseleccion/sistemaapi/apirest/preseleccion.php?grap=" + this.hola;
        axios.get(direccion).then(datos => {
            this.preselecciones = datos.data;
            console.log(datos.data)
            if (this.loaded == false) {
                this.chartData.labels = this.preselecciones.map(item => item.nombre);
                this.chartData.datasets[0].data = this.preselecciones.map(item => item.cantidad);
                this.loaded = true;
            }
        }).catch(error => {
            console.error("Error al obtener datos desde la API", error);
        });

        let direccion2 = "http://localhost/preseleccion/sistemaapi/apirest/preseleccion.php?preselecciones=";
        console.log(direccion2);
        axios.get(direccion2).then(datos => {
            this.preseleccionesview = datos.data;
            console.log(datos);
        })
        this.token = localStorage.getItem("token");
        let direccion3 = "http://localhost/preseleccion/sistemaapi/apirest/auth.php?token=" + this.token;
        console.log(direccion3);
        axios.get(direccion3).then(datos => {
            this.estado = datos.data;
            console.log(datos);
        }),

            axios.get(direccion2).then(datos => {
                this.preseleccionesview = datos.data.slice(-17);
                console.log('Datos de preseleccionesview:', this.preseleccionesview);
            });
    },

};

</script>

<style scoped>
.izquierda {
    text-align: left;
}

.derecha {
    text-align: right;
}

.prueba1 {
    background-color: #041B2D;
}

.padindic {
    padding: 1.5rem;
    max-width: 100%;
    padding-right: calc(var(--bs-gutter-x) / 2);
    padding-left: calc(var(--bs-gutter-x) / 2);
    margin-top: var(--bs-gutter-y);
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

.fuente1 {
    width: 100%;
    height: 15px;
}

.titulo {
    color: #fff;
}
</style>
