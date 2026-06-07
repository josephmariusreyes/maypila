import type { App as VueApp } from 'vue';
import { createPinia } from 'pinia';

export function registerAppProviders(app: VueApp) {
	const pinia = createPinia()
	app.use(pinia)
}