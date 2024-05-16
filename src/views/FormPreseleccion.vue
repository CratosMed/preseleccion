<template>
    <div class="full-width ">

        <!-- Section: Design Block -->
        <section class="background-radial-gradient overflow-hidden ">
            <div class="custom-image">
                <img class="custom-image" :src="require('@/assets/logo5.png')" />
            </div>
            <div class="container px-1 py-1 px-md-5 text-center text-lg-start">
                <div class="row gx-lg-5 align-items-center mb-5">
                    <div class="col-lg-6 mb-5 mb-lg-0" style="z-index: 10 ">
                        <h1 class="my-5 display-5 fw-bold ls-tight margen" style="color: hsl(218, 81%, 95%)">
                            Preparándote para el Próximo Semestre! <br />
                            <span class="texto" style="color: hsl(218, 81%, 75%)"> Registro Anticipado de
                                Materias</span>
                        </h1>
                        <p class="mb-4 opacity-70" style="color: hsl(218, 81%, 85%)">
                            "Tu contribución es esencial. Cada curso que elijas influye es la configuración final de la
                            oferta académica.
                            Te animamos a elegir con discernimiento, inscribiendo solo las materias que realmente deseas
                            ver
                            el próximo semestre"</p>
                        <div class="top d-none d-lg-block">
                        </div>

                    </div>

                    <div class="col-lg-6 mb-5 mb-lg-0 position-relative ">
                        <div id="radius-shape-1" class="position-absolute rounded-circle shadow-5-strong"></div>
                        <div id="radius-shape-2" class="position-absolute shadow-5-strong"></div>

                        <div class="card bg-glass ">
                            <div class="card-body px-4 py-5 px-md-5">
                                <form @submit.prevent="submitDatosPersonales" v-if="section === 'datosPersonales'">
                                    <h4 class="text-center"><strong>Sistema de Preselección de Cursos UNESR</strong>
                                    </h4>
                                    <h5 class="text-center">DatosPersonales</h5>
                                    <div>
                                        <div class=" form-group mb-3">
                                            <input type="text" class="form-control" id="nombre" v-model="form.nombre"
                                                placeholder="Nombre" readonly />
                                        </div>
                                        <div class="form-group mb-3">
                                            <input type="text" class="form-control" id="apellido"
                                                v-model="form.apellido" placeholder="Apellido" readonly />
                                        </div>
                                        <div class="form-grou mb-3">
                                            <input type="text" class="form-control" id="cedula" v-model="form.cedula"
                                                placeholder="Cédula" readonly />
                                        </div>
                                        <div class="form-group mb-3">
                                            <input type="date" class="form-control" id="fecha_nacimiento"
                                                v-model="form.fecha_nacimiento" placeholder="Fecha de Nacimiento"
                                                readonly />
                                        </div>
                                        <div class="form-group mb-3">
                                            <input type="text" class="form-control" id="telefono"
                                                v-model="form.telefono" placeholder="Teléfono" readonly />
                                        </div>
                                        <div class="form-group mb-3">
                                            <input type="text" class="form-control" id="direccion"
                                                v-model="form.direccion" placeholder="Dirección" readonly />
                                        </div>
                                        <div class="form-group mb-3">
                                            <input type="text" class="form-control" id="carrera" v-model="form.carrera"
                                                placeholder="Carrera" readonly />
                                        </div>
                                        <div class="form-group mb-3">
                                            <input type="text" class="form-control" id="u_c_acumuladas"
                                                v-model="form.u_c_acumuladas"
                                                placeholder="Unidades de Crédito Acumuladas" readonly />
                                        </div>
                                        <div class="form-group mb-3">
                                            <input class="form-control" id="sexo" v-model="form.sexo" placeholder="Sexo"
                                                readonly />
                                        </div>
                                        <div class="form-group mb-3">
                                            <input type="email" class="form-control" id="correo" v-model="form.correo"
                                                placeholder="Correo Electrónico" readonly />
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <button type=" button" class="btn btn-primary"
                                            @click="irAPreseleccion">Siguiente</button>
                                    </div>

                                </form>
                                <form v-else-if="section !== 'tabla'">

                                    <br>
                                    <h3 class="text-center"><strong>Preselección </strong></h3>
                                    <div class="text-center">
                                        <strong>
                                            <p>{{ currentDate }}</p>
                                        </strong>
                                    </div>
                                    <br>
                                    <div class="input-group mb-3">

                                        <select v-model="form2.estatus_participante" class="form-select"
                                            aria-label="Default select example">
                                            <option selected disabled>Estatus</option>
                                            <option value="Regular">Regular</option>
                                            <option value="Terminal">Terminal</option>
                                        </select>
                                        <select v-model="form2.plataforma" class="form-select"
                                            aria-label="Default select example">
                                            <option selected disabled> Plataforma</option>
                                            <option value="Siace">Siace</option>
                                            <option value="SGA">SGA</option>
                                        </select>
                                        <select v-model="form2.turno" class="form-select"
                                            aria-label="Default select example">
                                            <option selected disabled>Turno</option>
                                            <option value="Mañana">Mañana</option>
                                            <option value="Tarde">Tarde</option>
                                            <option value="Noche">Noche</option>
                                        </select>

                                    </div>

                                    <div v-show="materia" class="input-group mb-3 ">
                                        <div>
                                            <br>


                                            <label class="typo__label">
                                                <strong>Elige tus Cursos</strong>
                                            </label>
                                            <VueMultiselect v-model="value" tag-placeholder="Add this as new tag"
                                                placeholder="Busca o Agrega" label="name" track-by="code"
                                                :options="myOptions" :multiple="true" :taggable="true" @tag="addTag">
                                            </VueMultiselect>
                                        </div>
                                    </div>

                                    <div class="text-end">
                                        <div class="form-group mb-3">
                                            <input type="text" class="form-control" v-model="form2.t_u_c"
                                                placeholder="Total U/C" readonly />

                                        </div>
                                        <br>


                                        <button type="button" class="btn btn-primary "
                                            @click="irADatosPersonales">Anterior</button>
                                        <button type="button" @click="guardar()"
                                            class="btn btn-primary ms-2">Finalizar</button>
                                        <br>
                                    </div>
                                </form>
                                <div class="col-lg-12 mb-5 mb-lg-0">
                                    <form v-if="section === 'tabla'">
                                        <div class="row">
                                            <label class="typo__label">

                                                <h3 class="col-12  centrar"> <strong>Detalles de tu
                                                        Preselección</strong>
                                                </h3>
                                            </label>
                                        </div>
                                        <br>
                                        <br>
                                        <div class=" row table-container">
                                            <table v-if="this.detallePreseleccion" class="table">
                                                <tbody>
                                                    <tr>
                                                        <td>Fecha:</td>
                                                        <td>{{ this.detallePreseleccion.fecha }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Nombre:</td>
                                                        <td>{{ this.form.nombre }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Apellido:</td>
                                                        <td>{{ this.form.apellido }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Cédula:</td>
                                                        <td>{{ this.form.cedula }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Cursos Preseleccionados:</td>
                                                        <td>{{ this.detallePreseleccion.curso }}, {{
                    this.detallePreseleccion.curso_dos }}, {{
                    this.detallePreseleccion.curso_tres }}, {{
                    this.detallePreseleccion.curso_cuatro }}, {{
                    this.detallePreseleccion.curso_cinco }}, {{
                    this.detallePreseleccion.curso_seis }} </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Estatus:</td>
                                                        <td>{{ this.detallePreseleccion.estatus_participante }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Turno:</td>
                                                        <td>{{ this.detallePreseleccion.turno }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Total U/C Detalle:</td>
                                                        <td>{{ this.detallePreseleccion.t_u_c }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <div v-else class="text-center">Cargando datos...</div>
                                        </div>
                                    </form>
                                </div>
                                <!-- Agrega más campos de entrada aquí para la preselección de cursos -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>
</template>


<script>

import axios from 'axios';
//import Select2 from 'vue3-select2-component';
import VueMultiselect from 'vue-multiselect'



export default {
    name: "FormPreseleccion",
    components: {
        //Select2
        VueMultiselect
    },
    data: function () {
        return {
            toast: "null",
            detallePreseleccion: [],

            value: [],
            options: [],
            myValue: 'Seleccione el curso',
            myOptions: [],
            pagina: 1,
            cursos: null,
            section: 'datosPersonales', // Inicializar en la sección de Datos Personales
            // Otros datos...

            materia: true,
            materia2: false,
            materia3: false,
            materia4: false,
            materia5: false,
            materia6: false,
            materia7: false,
            form2: {
                "token": "",
                "seccion": "",
                //"fecha": "2023-06-09",
                "participante_id": "",
                "curso": "",
                "curso_dos": "",
                "curso_tres": "",
                "curso_cuatro": "",
                "curso_cinco": "",
                "curso_seis": "",
                "t_u_c": "",
                estatus_participante: 'Estatus',     // Valor por defecto para estatus
                plataforma: 'Plataforma',  // Valor por defecto para plataforma
                turno: 'Turno',// Valor por defecto para turno
                currentDate: ''
            },
            form: {

                "cedula": "",
                "nombre": "",
                "apellido": "",
                "fecha_nacimiento": "",
                "telefono": "",
                "direccion": "",
                "carrera": "",
                "u_c_acumuladas": "",
                "sexo": "",
                "correo": "",
                "token": "",
                "nombre_curso": "",
                "id_curso": "",
                "search": "",
                "prueba": "",
                "u_c": "",
                guardar: false,
                editar: true,

            }
        }
    },

    methods: {
        sumarUC() {
            let suma = 0;
            for (let i = 0; i < this.value.length; i++) {
                suma += parseInt(this.value[i].u_c);
            }
            this.form2.t_u_c = suma;
            return suma;
        },
        guardar() {
            const cursosSeleccionados = this.value;
            const nombresCursos = ['', '_dos', '_tres', '_cuatro', '_cinco', '_seis']; // Array con los nombres de los cursos

            for (let i = 0; i < cursosSeleccionados.length; i++) {
                const curso = cursosSeleccionados[i];
                // Asigna el nombre del curso al campo correspondiente (curso, curso_dos, curso_tres, etc.)
                this.form2[`curso${nombresCursos[i]}`] = curso.name;
            }

            const fechaActual = new Date().toISOString().split('T')[0];
            this.form2.fecha = fechaActual;
            /* eslint-disable */
            this.form2.token = localStorage.getItem("token");
            console.log(this.form2);
            axios
                .post("http://localhost/preseleccion/sistemaapi/apirest/preseleccion.php", this.form2)
                .then(data => {
                    console.log(data);
                    console.log("estoy aqui")
                }).catch(error => {
                    console.log(error);
                    this.makeToast("error", "error al guardar", "error");
                })
            this.mostrarTablaDespuesDeGuardar();
        },
        mostrarTablaDespuesDeGuardar() {
            this.section = 'tabla';
            const id_participante = this.form.id_participante

            let direccion = "http://localhost/preseleccion/sistemaapi/apirest/preseleccion.php?id_participante=" + id_participante;
            axios.get(direccion).then(datos => {
                this.detallePreseleccion = datos.data.sort((a, b) => new Date(b.fecha) - new Date(a.fecha))[0];
                console.log(this.detallePreseleccion);
            })
                .catch(error => {
                    console.error('Error al cargar los datos:', error);
                });;

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

        myChangeEvent(val) {
            console.log(val);
        },
        mySelectEvent({ id, text }) {
            console.log({ id, text })
        },
        fillFields() {
            const selectedCodigo = this.form.nombre_curso;
            const selectedData = this.cursos.find(item => item.nombre === selectedCodigo);

            if (selectedData) {
                this.form.id_curso = selectedData.id_curso;
                this.form.u_c = selectedData.u_c;
            }
        },
        salir() {
            this.$router.push("/Participantes");

        },
        eliminar() {

            var enviar = {
                "id_participante": this.form.id_participante,
                "token": this.form.token
            };

            axios.delete("http://localhost/preseleccion/sistemaapi/apirest/participantes.php", { headers: enviar })
                .then(datos => {
                    this.$router.push("/Participantes");
                    console.log(datos);
                });
        },
        // search() {

        //     axios.get("http://localhost/preseleccion/sistemaapi/apirest/cursos.php?id=" + this.form.search)
        //         .then(data => {
        //             this.form.id_curso = data.data[0].id_curso;
        //             this.form.prueba = data.data[0].nombre;
        //             this.form.u_c = data.data[0].u_c;
        //             this.form.token = localStorage.getItem("token");
        //             console.log(this.form.id_curso);
        //             console.log(data);



        //         })
        //         .catch(e => console.error(e))
        // },
        irADatosPersonales() {
            this.section = 'datosPersonales';
        },
        irAPreseleccion() {
            this.section = 'preseleccion';
        },
        addTag(newTag) {
            const tag = {
                name: newTag,
                code: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
            }
            this.taggingOptions.push(tag)
            this.taggingSelected.push(tag)
        },
        updateDate() {
            const now = new Date();
            const day = String(now.getDate()).padStart(2, '0');
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const year = now.getFullYear();
            this.currentDate = `${day}-${month}-${year}`;
        },

    },
    mounted: function () {
        setInterval(this.updateDate, 1000);
        //obtener cursos
        let direccion = "http://localhost/preseleccion/sistemaapi/apirest/cursos.php?page=" + this.pagina;

        axios.get(direccion).then(datos => {
            this.cursos = datos.data;


            for (let index = 0; index < this.cursos.length; index++) {
                this.myOptions.push({
                    name: this.cursos[index].nombre,
                    code: this.cursos[index].id_curso,
                    u_c: this.cursos[index].u_c

                })

            }

        })
        this.form.cedula = this.$route.params.cedula;
        //obtener participantes
        axios.get("http://localhost/preseleccion/sistemaapi/apirest/participantes.php?cedula=" + this.form.cedula + "&_sort=fecha&_order=desc&_limit=1")
            .then(data => {
                this.form.id_participante = data.data[0].id_participante;
                this.form2.participante_id = data.data[0].id_participante;
                this.form.cedula = data.data[0].cedula;
                this.form.nombre = data.data[0].nombre;
                this.form.apellido = data.data[0].apellido;
                this.form.fecha_nacimiento = data.data[0].fecha_nacimiento;
                this.form.telefono = data.data[0].telefono;
                this.form.direccion = data.data[0].direccion;
                this.form.carrera = data.data[0].carrera;
                this.form.u_c_acumuladas = data.data[0].u_c_acumuladas;
                this.form.sexo = data.data[0].sexo;
                this.form.correo = data.data[0].correo;
                this.form.token = localStorage.getItem("token");

                console.log(data)
            })
            .catch(e => console.error(e))
    },
    watch: {
        value: {
            handler() {
                this.form2.t_u_c = this.sumarUC();
            },
            deep: true,
        },
    },

}


</script>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>
<style scoped>
.table-container {
    display: flex;
    justify-content: center;
    align-items: center;
    /* Centra verticalmente el contenido */
    height: 100%;
    /* Ajusta la altura del contenedor */
    background-color: rgba(255, 255, 255, 0.2);
    /* Color de fondo semitransparente */
    padding: 10px;
    /* Ajusta el relleno según sea necesario */
}

.table {
    max-width: 100%;
    background-color: transparent;
    /* Hace que el fondo de la tabla sea transparente */
    border-collapse: collapse;
    /* Fusiona las líneas de borde de la tabla */
    /* Ajusta otros estilos de la tabla según sea necesario */
}

.table td {
    background-color: transparent;
}

.custom-image {
    height: 100px;
    margin-top: 1%;
    padding-right: 100%;
    margin-left: 2%;
}

.full-width {
    width: 100%;
    margin: 0 !important;
    padding: 0
}

.top {
    margin-top: 60%;
}

.centrar {
    padding-left: 15%;
}

.btn-primary {
    background-color: #041B2D;
    color: white;
}

&:hover {
    background-color: white;
    /* Cambia al color de fondo deseado al hacer hover */
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

.position-relative {
    height: 1024px;
}

#radius-shape-1 {
    height: 220px;
    width: 220px;
    top: -60px;
    left: -130px;
    background: radial-gradient(#44006b, #ad1fff);
    overflow: hidden;
}

#radius-shape-2 {
    border-radius: 38% 62% 63% 37% / 70% 33% 67% 30%;
    bottom: 100px;
    right: -110px;
    width: 300px;
    height: 300px;
    background: radial-gradient(#44006b, #ad1fff);
    overflow: hidden;
}

.bg-glass {
    background-color: hsla(0, 0%, 100%, 0.9) !important;
    backdrop-filter: saturate(200%) blur(25px);
}

.texto {
    font-size: 70%;
}

.small-input {
    width: 10px;
    /* Ajusta este valor según tus necesidades */
}
</style>