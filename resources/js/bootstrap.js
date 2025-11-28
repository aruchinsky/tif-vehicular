import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// ------------------------------------------------------
// 🔥 Laravel Echo + Reverb (SIN PUSHER)
// ------------------------------------------------------
import './bootstrap';

import Echo from 'laravel-echo';

window.Echo = new Echo({
    broadcaster: 'reverb',

    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT,
    wssPort: import.meta.env.VITE_REVERB_PORT,
    forceTLS: import.meta.env.VITE_REVERB_SCHEME === 'https',
    enabledTransports: ['ws', 'wss'],
});

console.log("Echo cargado correctamente.");

// 🔔 LISTENER DEL EVENTO
window.Echo.private('admin.alertas')
    .listen('.novedad.creada', (data) => {

        console.log("📢 Evento recibido:", data);

        // 🔥 Dispara alerta global
        window.dispatchEvent(new CustomEvent('novedad-alerta', {
            detail: {
                mensaje: "Nueva novedad",
                vehiculo: data.novedad.vehiculo.dominio,
                id: data.novedad.id
            }
        }));
    });
