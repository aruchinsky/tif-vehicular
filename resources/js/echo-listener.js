console.log("Echo listener cargado...");

window.Echo.private('admin.alertas')
    .listen('novedad.creada', (data) => {
        console.log("📢 Evento recibido:", data);
        alert("🔥 Nueva novedad creada para revisión del administrador:\n" +
              "Vehículo: " + data.novedad.vehiculo.patente +
              "\nID: " + data.novedad.id);
    });
