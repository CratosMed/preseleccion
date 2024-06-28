<template>
    <div :class='contentClass'>
        <MenuLateral @collapsed-updated="updateCollapsed" v-if="showSidebar" :menuItems="menuItems"
            @menu-item-click="handleMenuItemClick" />

        <br />
        <div class="col-lg-12 col-md-8">
            <h5 class="display-5 fw-bold custom-h5 " style="color: #000;">
                Cursos y Secciones
            </h5>
        </div>
        <br />

        <DataTable :data="graficospreseleccion" :columns="columns" class="table table-striped table-bordered display"
            ref=" table" :options="{
        responsive: true, autoWidth: false, dom: dom, select: true, language: {
            search: 'Buscar', zeroRecords: 'No hay registros para mostrar',
            info: 'Mostrando del _START_ a _END_ de _TOTAL_ registros',
            infoFiltered: '(Filtrados de _MAX_ registros.)',
            paginate: { first: 'Primero', previous: 'Anterior', next: 'Siguiente', last: 'Ultimo' }

        }, buttons: botones
    }">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Cod</th>
                    <th scope="col">Cursos</th>
                    <th scope="col">Participantes</th>
                    <th scope="col">Participantes por Secciones</th>
                    <th scope="col">Secciones</th>
                    <th scope="col">Total de Secciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- <tr v-for="participante in participantes" :key="participante.id_participantes"
                    v-on:click="editar(participante.id_participantes)">
                    <td>{{ participante.id_cedula }}</td>
                    <td>{{ participante.nombre }}</td>
                    <td>{{ participante.apellido }}</td>
                    <td>{{ participante.correo }}</td>
                    <td>{{ participante.carrera }}</td>
                    <td>{{ participante.u_c_acumuladas }}
                </tr> -->
            </tbody>
        </DataTable>
        <Footer />
    </div>
</template>

<script>
/* eslint-disable */
import MenuLateral from "@/components/MenuLateral.vue";
import Footer from '@/components/FooterVue.vue';
import axios from 'axios';
import DataTable from 'datatables.net-vue3';
import DataTableLib from 'datatables.net-bs5'
import Select from 'datatables.net-select';
import { ref } from 'vue'
import Buttons from 'datatables.net-buttons-bs5'
import ButtonsHtml5 from 'datatables.net-buttons/js/buttons.html5'
import print from 'datatables.net-buttons/js/buttons.print'
import pdfmake from 'pdfmake'
import pdfFonts from 'pdfmake/build/vfs_fonts'
pdfmake.vfs = pdfFonts.pdfMake.vfs;
import 'datatables.net-responsive-bs5'
import JsZip from 'jszip'

window.JSZip = JsZip
DataTable.use(Select);
DataTable.use(DataTableLib)
DataTable.use(pdfmake)
DataTable.use(ButtonsHtml5)


export default {
    name: "GraficosPreseleccion.vue",

    data() {
        return {
            graficospreseleccion: null,
            pagina: 1,
            showSidebar: true,
            isCollapsed: false,
            columns: [
                { data: null, render: function (data, type, row, meta) { return `${meta.row + 1}` } },
                { data: 'codigo' },
                { data: 'nombre' },
                { data: 'cantidad' },
                {
                    data: 'cantidad',
                    render: function (data, type, row) {
                        // If the quantity is less than or equal to 25, don't create sections
                        if (data <= 25) {
                            return data;
                        }

                        // If the quantity is greater than 25, create sections dynamically
                        const maxSectionSize = 25;
                        const numSections = Math.ceil(data / maxSectionSize);
                        const idealSectionSize = Math.floor(data / numSections);
                        const remainder = data % numSections;

                        const sections = [];
                        for (let i = 0; i < numSections; i++) {
                            const sectionSize = idealSectionSize + (i < remainder ? 1 : 0);
                            sections.push(sectionSize);
                        }

                        // Return the section values as a comma-separated string
                        return sections.join(', ');
                    }
                },
                {
                    data: 'cantidad',
                    render: function (data, type, row) {
                        // If the quantity is less than or equal to 10, don't create sections
                        if (data < 10) {
                            return 'Faltan participantes minimos';
                        }

                        // If the quantity is greater than 10 and less than or equal to 25, create one section
                        if (data <= 25) {
                            return 'A';
                        }

                        // If the quantity is greater than 25, create sections dynamically
                        const maxSectionSize = 25;
                        const numSections = Math.ceil(data / maxSectionSize);
                        const idealSectionSize = Math.floor(data / numSections);
                        const remainder = data % numSections;

                        const sections = [];
                        for (let i = 0; i < numSections; i++) {
                            const sectionSize = idealSectionSize + (i < remainder ? 1 : 0);
                            sections.push(String.fromCharCode('A'.charCodeAt(0) + i));
                        }

                        // Return the section values as a comma-separated string
                        return sections.join(', ');
                    }
                },
                {
                    data: 'cantidad',
                    render: function (data, type, row) {
                        // If the quantity is less than or equal to 10, there are 0 sections
                        if (data < 10) {
                            return "No hay secciones";
                        }

                        // If the quantity is greater than 10 and less than or equal to 25, there is one section
                        if (data <= 25) {
                            return 1;
                        }

                        // If the quantity is greater than 25, calculate the number of sections
                        const maxSectionSize = 25;
                        const numSections = Math.ceil(data / maxSectionSize);

                        return numSections;
                    }
                },


            ],
            botones: [
                {
                    title: 'Lista de Cursos',
                    extend: 'excelHtml5',
                    text: '<i class="bi bi-file-spreadsheet"></i> Excel',
                    className: 'btn btn-success'
                },
                {
                    title: 'Lista de Cursos',
                    extend: 'print',
                    text: '<i class="bi bi-printer"></i> Imprimir',
                    className: 'btn btn-dark'
                },
                {
                    title: 'Lista de Cursos',
                    extend: 'pdfHtml5',
                    text: '<i class="bi bi-filetype-pdf"></i> Pdf',
                    className: 'btn btn-danger'
                },
                {
                    title: 'Lista de Cursos',
                    extend: 'copy',
                    text: '<i class="bi bi-copy"></i> Copiar texto',
                    className: 'btn btn-light'
                },
            ],
            dom:
                "B<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

        }

    },
    components: {
        Footer,
        DataTable,
        MenuLateral,

    },
    computed: {
        contentClass() {
            return this.isCollapsed ? 'full' : 'collap';
        },
    },
    methods: {

        editar() {
            const table = this.$refs.table.dt;
            let id = table.row('.selected').data().id_preselecciones;
            this.$router.push('/editar/' + id);
        },

        nuevo() {
            this.$router.push('/nuevo');
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

        let direccion = "http://localhost/preseleccion/sistemaapi/apirest/preseleccion.php?grap=";
        console.log(direccion);
        axios.get(direccion).then(datos => {
            this.graficospreseleccion = datos.data;

            console.log(datos);
        });

    }
}
// const update = () => {
//     console.log("hola que hace")
//     dt.rows({ selected: true }).every(function () {
//         let indice = participantes.indexOf(this.data());
//         let id = participantes[indice].id;
//         console.log(id);
//     })
// }


</script>
<style scoped>
@import 'datatables.net-bs5';

.custom-h5 {
    font-size: 2.5rem;
    /* Tamaño de fuente para <h5> */
    font-weight: bold;
    /* Grosor de la fuente */
    color: #000;
    /* Color del texto */
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

.izquierda {
    text-align: right;
    background-color: #041B2D;
    font-size: 15px;
}



.padindic {
    padding: 1.5rem;
    max-width: 100%;
    padding-right: calc(var(--bs-gutter-x) / 2);
    padding-left: calc(var(--bs-gutter-x) / 2);
    margin-top: var(--bs-gutter-y);
}
</style>
