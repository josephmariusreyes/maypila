import { createApp } from 'vue'
import App from './App.vue'
import router from '@/app/router'

import './style.css'
import 'vue-sonner/style.css'

import { registerAppProviders } from '@/app/providers/app-provider'

const app = createApp(App)

registerAppProviders(app)
app.use(router)

app.mount('#app')
