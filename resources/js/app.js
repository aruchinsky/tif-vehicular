// ========================================================
//  BOOTSTRAP DE LARAVEL
// ========================================================
import './bootstrap';

import Echo from 'laravel-echo';

console.log("Echo cargado correctamente con Reverb…");

// ========================================================
//  SOLO ADMIN O SUPER SE SUSCRIBEN
// ========================================================
const roles = window.appRoles || [];

if (roles.some(r => ['ADMINISTRADOR', 'SUPERUSUARIO'].includes(r))) {

    console.log('%cSuscribiendo a canal admin.alertas…', 'color:#38bdf8');

    window.Echo.private("admin.alertas")
        .listen(".novedad.creada", (data) => {

            console.log("⚡ NOVEDAD RECIBIDA EN REAL TIME:", data);

            const n = data.novedad;

            const payload = {
                uid: Date.now() + Math.random(),
                id: n.id,
                tipo: n.tipo_novedad,
                dominio: n.vehiculo?.dominio ?? "—",
                conductor: n.vehiculo?.conductor?.nombre_apellido ?? "—",
                hora: new Date().toLocaleTimeString(),
            };

            // ✔ Se pasa al store global unificado
            window.NotificacionesStore.push(payload);
        });

} else {
    console.log('%cEste usuario no se suscribe a admin.alertas (no es admin/super).', 'color:#9ca3af');
}

console.log("%cSistema de Alertas ACTIVADO", "color: #22c55e; font-weight: bold;");
