<template>
    <div :class='contentClass'>
        <MenuLateral @collapsed-updated="updateCollapsed" v-if="showSidebar" :menuItems="menuItems"
            @menu-item-click="handleMenuItemClick" />
        <br />

        <div class="container mt-4 ">
            <div class="row ">
                <!-- Columna 1 -->
                <div class="col-md-4 margen1">
                    <label for="periodo" class="form-label">
                        <strong>
                            <h4><strong>Seleccionar Periodo:</strong></h4>
                        </strong>
                    </label>
                    <select v-model="periodoSeleccionado" class="form-select ">
                        <option v-for="periodo in periodos" :key="periodo.id"
                            :value="periodo.fechaInicio + ',' + periodo.fechaFin">
                            {{ periodo.nombre }}
                        </option>
                    </select>
                </div>

                <!-- Columna 2 -->

                <div class="col-md-6 margen2">
                    <label for="periodo" class="form-label">
                        <strong>
                            <h4 class="centrarperiodo"><strong>Nuevo Periodo:</strong></h4>
                        </strong>
                    </label>
                    <!-- Columna 2 -->
                    <form class="row">
                        <div class="col-3 padin">
                            <div class="form-floatin seleccionar">
                                <select v-model="form.nombre" class="form-select" id="floatingSelect"
                                    aria-label="Floating label select example">
                                    <option value="" disabled selected>Seleccionar</option>
                                    <option value="Periodo 1-">Periodo 1</option>
                                    <option value="Periodo 2-">Periodo 2</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-3 padin">
                            <input v-model="form.fechaInicio" type="date" placeholder="Fecha de inicio"
                                class="form-control">
                        </div>
                        <div class="col-3 padin">
                            <div class="input-group">
                                <input v-model="form.fechaFin" type="date" placeholder="Fecha Final"
                                    class="form-control">
                                <button class="btn btn-success" @click="addPeriodo"><i class="bi bi-plus"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="margen">
        </div>
        <DataTable :data="preseleccionesview" :columns="columns" class="table table-striped table-bordered display"
            ref="table" :options="{
        responsive: true, autoWidth: false, dom: dom, select: true, language: {
            search: 'Buscar', zeroRecords: 'No hay registros para mostrar',
            info: 'Mostrando del _START_ a _END_ de _TOTAL_ registros',
            infoFiltered: '(Filtrados de _MAX_ registros.)',
            paginate: { first: 'Primero', previous: 'Anterior', next: 'Siguiente', last: 'Ultimo' }
        }, buttons: botones
    }" @click="eliminar">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Cédula</th>
                    <th scope="col">Cursos Preseleccionados</th>
                    <th scope="col">Estatus</th>
                    <th scope="col">Plataforma</th>
                    <th scope="col">Turno</th>
                    <th scope="col">Total U/C</th>
                    <th scope="col">Acciones</th>
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
    name: "PreseleccionesView",

    data() {
        return {
            preseleccionesview: null,
            token: localStorage.getItem("token"),
            pagina: 1,
            showSidebar: true,
            isCollapsed: false,
            fechaInicio: null,
            fechaFinal: null,
            form: {
                nombre: "",
                fechaInicio: "",
                fechaFin: "",
                token: "",
            },
            periodoSeleccionado: '', // Almacena el rango de fechas seleccionado
            periodos: [ // Reemplaza esto con tu lista de periodos o genera dinámicamente
                //{ id: 1, nombre: 'Periodo 1-2023', fechaInicio: '2023-01-01', fechaFin: '2023-06-30' },
                //{ id: 2, nombre: 'Periodo 2-2023', fechaInicio: '2023-07-01', fechaFin: '2023-12-31' },
                //{ id: 3, nombre: 'Periodo 1-2024', fechaInicio: '2024-01-01', fechaFin: '2024-06-30' },
                //{ id: 4, nombre: 'Periodo 2-2024', fechaInicio: '2024-07-01', fechaFin: '2024-12-31' },
                // ... otros periodos ...

            ].sort((a, b) => {
                // Ordena los periodos por fecha de inicio de manera descendente
                return new Date(b.fechaInicio) - new Date(a.fechaInicio);
            }),



            columns: [
                { data: null, render: function (data, type, row, meta) { return `${meta.row + 1}` } },
                { data: 'fecha' },
                { data: 'nombre' },
                { data: 'cedula' },
                {
                    data: 'curso', render: function (data, type, row, meta) {
                        return `${row.curso + ', ' + row.curso_dos + ', ' + row.curso_tres + ', '
                            + row.curso_cuatro + ', ' + row.curso_cinco + ', ' + row.curso_seis}`
                    }
                },
                { data: 'estatus_participante' },
                { data: 'plataforma' },
                { data: 'turno' },
                { data: 't_u_c' },

                {
                    data: null,
                    render: function (data, type, row) {
                        const fechaFila = row.fecha; // Supongamos que 'fecha' es el campo de fecha en la fila

                        // Verifica si la fecha de la fila está dentro del rango del periodo actual

                        const mostrarBoton = this.fechaEnRango(fechaFila);

                        // Renderiza el botón solo si la fecha está en el periodo actual
                        if (mostrarBoton) {
                            return '<button class="btn btn-primary" data-id_preseleccion="' + row.id_preseleccion + '" data-nombre="' + row.nombre + '"><i class="bi bi-trash"></i></button>';
                        } else {
                            return ''; // Devuelve una cadena vacía si no se debe mostrar el botón
                        }
                    }.bind(this), // Asegúrate de que 'this' apunte al contexto correcto
                },

            ],
            'rowsGroup': [0],
            botones: [
                {
                    title: 'Lista de Preselecciones',
                    extend: 'excelHtml5',
                    text: '<i class="bi bi-file-spreadsheet"></i> Excel',
                    className: 'btn btn-success'
                },
                {
                    title: 'Lista de Preselecciones',
                    extend: 'print',
                    text: '<i class="bi bi-printer"></i> Imprimir',
                    className: 'btn btn-dark'
                },
                {
                    title: 'Lista de Preselecciones',
                    extend: 'pdfHtml5',
                    text: '<i class="bi bi-filetype-pdf"></i> Pdf',
                    className: 'btn btn-danger'
                },
                {
                    title: 'Lista de Preselecciones',
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

        customFormatter() {
            return {
                to: date => {
                    const [year, month, day] = date.split('-');
                    return `${day}/${month}/${year}`;
                },
                from: date => {
                    const [day, month, year] = date.split('/');
                    return `${year}-${month}-${day}`;
                },
            };
        },

    },
    methods: {
        addPeriodo() {
            this.guardar()
        },
        guardar() {
            this.form.token = localStorage.getItem("token");
            this.form.nombre = this.form.nombre + this.form.fechaInicio.split("-", 1)
            //crear periodos
            axios
                .post("http://localhost/preseleccion/sistemaapi/apirest/periodos_academicos.php", this.form)
                .then(data => {
                    console.log(data);
                    this.$router.push("preselecciones");
                }).catch(error => {
                    console.log(error);

                })
            console.log(this.form)

        },
        fechaEnRango(fecha) {
            const fechaComparar = new Date(fecha);
            const fechaActual = new Date(); // Obtener la fecha actual del sistema

            // Encuentra el periodo actual basado en la fecha actual
            const periodoActual = this.periodos.find(periodo => {
                const fechaInicio = new Date(periodo.fechaInicio);
                const fechaFin = new Date(periodo.fechaFin);
                return fechaActual >= fechaInicio && fechaActual <= fechaFin;
            });

            if (periodoActual) {
                // Si hay un periodo actual, verifica si la fecha de la fila está dentro de su rango
                const fechaInicioPeriodo = new Date(periodoActual.fechaInicio);
                const fechaFinPeriodo = new Date(periodoActual.fechaFin);
                return fechaComparar >= fechaInicioPeriodo && fechaComparar <= fechaFinPeriodo;
            }

            return false; // Si no se encuentra un periodo actual, devolver false
        },
        eliminar(event) {
            const button = event.target.closest('button');
            if (button) {
                const headers = {
                    'token': this.token,
                    'id_preseleccion': button.dataset.id_preseleccion
                }
                const nombre = button.dataset.nombre
                // Utiliza el cuadro de diálogo confirm para obtener la confirmación del usuario
                const confirmacion = confirm('¿Realmente desea eliminar la preseleccion de ' + nombre + '?');

                if (confirmacion) {
                    axios.delete('http://localhost/preseleccion/sistemaapi/apirest/preseleccion.php', { headers: headers })
                        .then(response => {
                            // Después de eliminar, vuelve a cargar los datos para actualizar la tabla
                            alert('se ha eliminado la preseleccion de ' + nombre + ' correctamente')
                            this.cargarDatos();
                        })
                        .catch(error => {
                            // Maneja el error aquí
                            console.error(error);
                        });
                }
            }
        },

        updateCollapsed(value) {
            this.isCollapsed = value;
        },
        cargarDatos() {
            let direccion = "http://localhost/preseleccion/sistemaapi/apirest/preseleccion.php?preselecciones=";
            axios.get(direccion).then(datos => {
                // Ordenar los datos por fecha de manera descendente
                this.preseleccionesview = datos.data.sort((a, b) => new Date(b.fecha) - new Date(a.fecha));

            });
        },

        async filtrarPorPeriodo() {
            if (this.periodoSeleccionado) {
                const [fechaInicio, fechaFin] = this.periodoSeleccionado.split(',');

                try {
                    // Realizar una solicitud al servidor con las fechas seleccionadas
                    const direccion = `http://localhost/preseleccion/sistemaapi/apirest/preseleccion.php?preselecciones=&fechaInicio=${fechaInicio}&fechaFin=${fechaFin}`;
                    const response = await axios.get(direccion);

                    // Actualizar this.preseleccionesview con los datos filtrados
                    this.preseleccionesview = response.data;



                } catch (error) {
                    // Manejar errores (puedes ajustarlo según tus necesidades)
                    console.error('Error al filtrar datos:', error);
                }
            }
        },

    },

    watch: {
        $route(to) {
            // Consulta la meta "showSidebar" de la ruta actual
            this.showSidebar = to.meta.showSidebar !== false;

        },
        periodoSeleccionado: {
            handler: 'filtrarPorPeriodo',
            immediate: true, // Para que se ejecute al inicio también
        },
    },

    // mounted: function () {
    //     let preseleccionesview = [];
    //     let direccion = "http://localhost/preseleccion/sistemaapi/apirest/preseleccion.php?preselecciones=&fechaInicio=2023-06-11&fechaFin=2024-01-18";
    //     console.log(direccion);
    //     axios.get(direccion).then(datos => {
    //         this.preseleccionesview = datos.data;
    //         console.log(this.preseleccionesview)
    //     })
    // }
    mounted() {
        // Cargar los datos originales al inicio
        this.cargarDatos();

        let direccion = "http://localhost/preseleccion/sistemaapi/apirest/periodos_academicos.php?page=" + this.pagina;

        axios.get(direccion).then(datos => {
            this.periodos = datos.data;

        })


    },
}
</script>

<style scoped>
@import 'datatables.net-bs5';


.padin {
    padding: 0px;
}

.margen {
    margin-top: 5%;
}

.margen1 {
    margin-left: 8%;

}

.margen2 {
    margin-left: 8%;
    margin-right: 0px;
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

.seleccionar {
    height: calc(-85.5rem + calc(var(--bs-border-width)* 2));
    min-height: calc(-1.5rem + calc(var(--bs-border-width)* 2));
    line-height: 1.25;
}
</style>