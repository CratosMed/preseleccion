
import App from './App.vue'
import { createApp } from 'vue';
import axios from 'axios';
import VueAxios from 'vue-axios';
import router from './router'

import 'bootstrap/dist/css/bootstrap.css'
import '../node_modules/bootstrap-icons/font/bootstrap-icons.css'
axios.defaults.baseURL = 'http://localhost/preseleccion/sistemaapi/apirest/'
import 'bootstrap/dist/js/bootstrap.js'

createApp(App).use(router).use(VueAxios, axios).mount('#app')
