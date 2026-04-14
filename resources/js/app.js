import './bootstrap';
import { createApp } from 'vue'
import router from './router';
import App from './App.vue'
import Toast from 'vue-toastification'
import 'vue-toastification/dist/index.css'
import './styles/global.css'
import 'mosha-vue-toastify/dist/style.css'

createApp(App)
.use(router)
.mount('#app')
