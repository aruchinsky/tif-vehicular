import './bootstrap';
import './echo-listener';

console.log("Echo cargado en app.js...");

window.Echo.private('admin.alertas')
    .listen('novedad.creada', (data) => {
        console.log("📢 Evento recibido:", data);

        // Alerta visual estilo Jetstream
        window.dispatchEvent(new CustomEvent('novedad-alerta', {
            detail: {
                mensaje: "🔥 Nueva novedad creada",
                vehiculo: data.novedad.vehiculo.patente,
                id: data.novedad.id
            }
        }));
    });