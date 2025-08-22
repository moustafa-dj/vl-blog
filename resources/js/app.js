import './bootstrap';
import { createApp } from 'vue'
import router from './router';
import App from './App.vue'
import Toast from 'vue-toastification'
import 'vue-toastification/dist/index.css'
import './styles/global.css'

createApp(App)
.use(router)
.use(
    Toast, {
        position: 'top-right',
        timeout: 3000,
        closeOnClick: true,
        pauseOnHover: true,
        draggable: true,
        showCloseButtonOnHover: false,
        hideProgressBar: false,
        icon: true,
    }
)
.mount('#app')
