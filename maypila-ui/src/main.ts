import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import router from '@/app/router'

import { registerAppProviders } from '@/app/providers/app-provider'

const app = createApp(App)

registerAppProviders(app)
app.use(router)

app.mount('#app')
