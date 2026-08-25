import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import PrimeVue from 'primevue/config';
import Aura from '@primeuix/themes/aura';
import ToastService from 'primevue/toastservice';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(ToastService)
            .use(PrimeVue, {
                theme: {
                    preset: Aura,
                    options: {
                        darkModeSelector: 'light',
                    }
                },
                license: 'eyJpZCI6IjM5MDBkZDlhLWIwNTItNDIxNi1iZGQ3LTM5NzIwNzFkZDEwYiIsInByb2R1Y3QiOiJwcmltZXVpIiwidGllciI6ImNvbW11bml0eSIsInR5cGUiOiJkZXYiLCJpYXQiOjE3ODc1OTQ1MzIsImV4cCI6MTgxOTEzMDUzMn0.I23dzHDDStQ8GodY8Ee1GRKolBiO__BIyFQHTcnfKj-Sj5fHaOFS2ZK64r2Gg-JySTlGsofXG8jSvyEI_L0JCA'
            }).mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
