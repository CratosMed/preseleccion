
import { createRouter, createWebHistory } from 'vue-router';
import HomeView from '../views/HomeView.vue';
import EditarVue from '../views/EditarVue.vue';
import NuevoVue from '../views/NuevoVue.vue';
import ParticipantesVue from '../views/ParticipantesVue.vue';
import UsuariosVue from '../views/UsuariosVue.vue';
import UsuaNuev from '../views/UsuaNuev.vue';
import EditarUsuario from '../views/EditarUsuario.vue';
import FormPreseleccion from '../views/FormPreseleccion.vue';
import GraficosPreseleccion from '../views/GraficosPreseleccion.vue';
import PreseleccionesView from '../views/PreseleccionesView.vue';
import Dashboard from '../views/Dashboard.vue';
import sobreNosotros from '../views/sobreNosotros.vue';
import RecuperarClave from '../views/RecuperarClave.vue';
import RecuperarClavepaso2 from '../views/RecuperarClavepaso2.vue';


/* eslint-disable */
export default createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
      meta: { showSidebar: false, requiresAuth: true },

    },
    {
      path: '/inicio',
      name: 'inicio',
      component: Dashboard,
      meta: { showSidebar: true, requiresAuth: true },
      beforeEnter: (to, from, next) => {
        const isAuthenticated = localStorage.token; // Puedes ajustar esto según cómo almacenas la información de autenticación

        // Verifica si la ruta requiere autenticación
        if (to.matched.some(record => record.meta.requiresAuth)) {
          // Redirige a la página de inicio de sesión si no está autenticado
          if (!isAuthenticated) {
            next('/'); // Puedes cambiar '/' por la ruta de tu página de inicio o login
          } else {
            // Continúa con la navegación si está autenticado
            next();
          }
        } else {
          // Continúa con la navegación para rutas que no requieren autenticación
          next();
        }
      },
    },



    {
      path: '/editar/:id',
      name: 'EditarVue',
      component: EditarVue,
      meta: { showSidebar: true }
    },
    {
      path: '/nuevo',
      name: 'NuevoVue',
      component: NuevoVue,
      meta: { showSidebar: true }
    },
    {
      path: '/participantes',
      name: 'ParticipantesVue',
      component: ParticipantesVue,
      meta: { showSidebar: true }
    },
    {
      path: '/usuarios',
      name: 'usuariosVue',
      component: UsuariosVue,
      meta: { showSidebar: true }
    },
    {
      path: '/usuaNuev',
      name: 'UsuaNuev',
      component: UsuaNuev,
      meta: { showSidebar: true }
    },
    {
      path: '/EditarUsuario/:id',
      name: 'EditarUsuario',
      component: EditarUsuario,
      meta: { showSidebar: true }
    },
    {
      path: '/preseleccion/:cedula',
      name: 'FormPreseleccion',
      component: FormPreseleccion,
      meta: { showSidebar: false }
    },
    {
      path: '/cursos',
      name: 'Cursos',
      component: GraficosPreseleccion,
      meta: { showSidebar: true }
    }, {
      path: '/graficos',
      name: 'GraficosPreseleccion',
      component: GraficosPreseleccion,
      meta: { showSidebar: true }
    },
    {
      path: '/preselecciones',
      name: 'preselecionesView',
      component: PreseleccionesView,
      meta: { showSidebar: true }
    },
    {
      path: '/sobreNosotros',
      name: 'sobreNosotros',
      component: sobreNosotros,
      meta: { showSidebar: true }
    },
    {
      path: '/recuperarclave',
      name: 'RecuperarClave',
      component: RecuperarClave,
      meta: { showSidebar: true }
    },
    {
      path: '/recuperarclavepaso2',
      name: 'RecuperarClavepaso2',
      component: RecuperarClavepaso2,
      meta: { showSidebar: true }
    },
  ],
})


