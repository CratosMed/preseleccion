<template>
    <div :class='contentClass'>
        <MenuLateral @collapsed-updated="updateCollapsed" v-if="showSidebar" />
        <br />
        <br />
        <br />

        <DataTable :data="usuario" :columns="columns" class="table table-striped table-bordered display" ref="table"
            :options="{
        responsive: true, autoWidth: false, dom: dom, select: true, language: {
            search: 'Buscar', zeroRecords: 'No hay registros para mostrar',
            info: 'Mostrando del _START_ a _END_ de _TOTAL_ registros',
            infoFiltered: '(Filtrados de _MAX_ registros.)',
            paginate: { first: 'Primero', previous: 'Anterior', next: 'Siguiente', last: 'Ultimo' }
        },
    }" @click="handleTableClick">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Cedula</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellido</th>
                    <th scope="col">Usuario</th>
                    <th scope="col">Estatus</th>
                    <th scope="col">Estado</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </DataTable>
        <Footer />
    </div>
</template>

<script>

/* eslint-disable */
import MenuLateral from '@/components/MenuLateral.vue';
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
import router from '@/router';


window.JSZip = JsZip
DataTable.use(Select);
DataTable.use(DataTableLib)
DataTable.use(pdfmake)
DataTable.use(ButtonsHtml5)

export default {
    name: "usuariosVue",

    data() {
        return {
            usuario: null,
            pagina: 1,
            showSidebar: true,
            isCollapsed: false,


            props: {
                isCollapsed: Boolean,
                // Otras propiedades
            },
            columns: [
                { data: null, render: function (data, type, row, meta) { return `${meta.row + 0}` } },
                { data: 'cedula' },
                { data: 'nombre' },
                { data: 'apellido' },
                { data: 'usuario' },
                { data: 'estatus' },
                { data: 'estado' },
            ],
            'rowsGroup': [0],

            dom:
                "B<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

        }

    },
    components: {
        Footer,
        DataTable,
        MenuLateral
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

        updateCollapsed(value) {
            this.isCollapsed = value;
        },
        // watch: {
        //     $route(to) {
        //         // Consulta la meta "showSidebar" de la ruta actual
        //         this.showSidebar = to.meta.showSidebar !== false;

        //     },

    },
    mounted: function () {

        let direccion = "http://localhost/preseleccion/sistemaapi/apirest/usuario.php?page=" + this.pagina;
        console.log(direccion);
        axios.get(direccion).then(datos => {
            this.usuario = datos.data;
            console.log(datos);
        })


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

.btn-primary {
    --bs-btn-bg: #041B2D;
    --bs-btn-hover-color: #fff;
    --bs-btn-hover-bg: #0b5ed7;
}


&:hover {
    background-color: white;
    /* Cambia al color de fondo deseado al hacer hover */
}
</style>
