# Sistema de Control Vehicular y Poblacional en Ruta  
**Trabajo Integrador Final — Tecnicatura en Desarrollo de Software**

**Comisión:** 2.1  
**Integrante:** Liza Rodríguez  
**Docente:** Facundo Verón  
**Fecha:** 24/11/2025  

---

# 🚓 Descripción General

Este sistema digitaliza y moderniza el registro de **controles vehiculares y poblacionales en ruta**, utilizado por el **Personal Policial**.  
La plataforma reemplaza completamente las planillas manuales utilizadas en los operativos, permitiendo un flujo de trabajo más rápido, íntegro y trazable.

El sistema fue rediseñado con una **arquitectura moderna**, **roles y permisos reales**, **notificaciones en tiempo real** para administradores, y una **experiencia mobile-first** pensada para el personal policial en campo.

---

# 🌟 Funcionalidades Principales

### 🛂 **Gestión de personas y vehículos**
- Registro de **conductores**, **vehículos** y **acompañantes**.
- Autocompletado inteligente basado en datos existentes.
- Relación automática entre entidades dentro del operativo.

### 🚨 **Controles policiales**
- Creación de operativos (fecha, zona, grupo policial asignado).
- Carga asistida para cada vehículo detenido.
- Estructura por **turnos** y **grupo de 4 por turno**.

### 📝 **Novedades y alertas**
- Registro de novedades desde el Operador.
- Notificaciones **en tiempo real** para Administradores/Superusuarios mediante:
  - Laravel Echo
  - Reverb (WebSockets)
  - Toaster unificado
  - Campana con contador y lista histórica

### 👮‍♂️ **Gestión de personal policial**
- Alta de personal
- Gestión de **cargos policiales**
- Asignación de personal a operativos
- Control total para SUPERUSUARIO

### 📊 **Productividad**
- Productividad por turno
- Productividad por agente
- Conteos automáticos:
  - Conductores
  - Vehículos
  - Acompañantes
  - Novedades por tipo

### ✔ **Roles y seguridad (Spatie)**
- **SUPERUSUARIO**
- **ADMINISTRADOR**
- **OPERADOR**
- Acceso dinámico al menú y módulos según el rol.

### 📱 **Diseño mobile-first**
- Versión responsiva optimizada para móviles.
- Menú lateral deslizante moderno.
- Controles simples y de alta legibilidad para trabajo en ruta.

### 📄 **Reportes**
- Exportación a PDF de cada operativo.
- Descarga de listado general.

---

# 🛠 Tecnologías Utilizadas

| Componente           | Tecnología / Herramienta           |
|----------------------|------------------------------------|
| Backend              | Laravel 12 (PHP 8.3)               |
| Frontend             | Blade + Alpine.js + Tailwind CSS   |
| Autenticación        | Jetstream                          |
| Roles & Permisos     | Spatie Laravel Permission           |
| WebSockets           | Laravel Echo + Reverb               |
| Base de datos        | MySQL / MariaDB                    |
| Versionado           | Git + GitHub                       |
| Despliegue local     | Artisan Serve / XAMPP / Laragon    |
| CI/CD (opcional)     | GitHub Actions                     |

---

# 🔐 Cuentas por defecto (Seeder)

### 👑 SUPERUSUARIO
Email: super@demo.com  
Contraseña: password123  
Rol: SUPERUSUARIO

### 🛡 ADMINISTRADOR
Email: admin@demo.com  
Contraseña: password123  
Rol: ADMINISTRADOR

### 👮 OPERADOR
Email: operador@demo.com  
Contraseña: password123  
Rol: OPERADOR

---

# 🚀 Instalación Local

### 1️⃣ Clonar el repositorio
git clone https://github.com/Liza88-prog/Trabajo-Integrador-Final  
cd Trabajo-Integrador-Final

### 2️⃣ Instalar dependencias
composer install  
npm install  
npm run dev

### 3️⃣ Configurar entorno
cp .env.example .env  
php artisan key:generate

Editar conexión MySQL en .env

### 4️⃣ Migraciones + seeders
php artisan migrate --seed

### 5️⃣ Iniciar servidor
composer run dev 
➡ http://localhost:8000/

---

# 🧩 Arquitectura del Sistema

app/ → Modelos, controladores, eventos  
resources/views/ → Vistas Blade  
routes/web.php → Rutas  
public/js/app.js → Echo + Reverb  
database/migrations → Tablas  
database/seeders → Roles, usuarios y datos base  
README.md → Documentación

---

# 🛡 Seguridad

✔ Validación completa  
✔ CSRF habilitado  
✔ Roles Spatie  
✔ Filtrado de inputs  
✔ Restricción por vistas y rutas  

---

# 🔮 Mejoras Futuras

- Reportes avanzados
- Dashboards en tiempo real
- Sincronización offline→online
- Aplicación PWA
- Infracciones digitalizadas

---

# 🔗 Enlaces

Repositorio: https://github.com/Liza88-prog/Trabajo-Integrador-Final  
Pull Requests: https://github.com/Liza88-prog/Trabajo-Integrador-Final/pulls  
Actions: https://github.com/Liza88-prog/Trabajo-Integrador-Final/actions  

---

# 🎓 Lecciones aprendidas

- Scrum aplicado en proyecto real  
- Uso profesional de control de versiones  
- Integración de WebSockets  
- Mobile-first para trabajo policial  
