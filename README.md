# Trabajo-Integrador-Final

**Comisión:** [2.1]
**Integrantes:** [Liza Rodriguez]
**Docente:** [Facundo Veron]
**Fecha:** [24/11/2025]

#  Descripción

Este sistema fue desarrollado para digitalizar y optimizar los controles vehiculares y poblacionales en ruta realizados por la Policía Federal Argentina – División Formosa. Permite registrar conductores, vehículos, acompañantes, novedades e infracciones, así como gestionar operativos y generar reportes exportables en PDF y Excel.

---

## Funcionalidades principales

- Registro de conductores, vehículos y acompañantes.
- Gestión de operativos (fecha, lugar, personal asignado).
- Registro de novedades e infracciones.
- Control de acceso por roles (Administrador / Policía).
- Exportación de reportes a PDF y Excel.
- Pipeline CI/CD con pruebas automatizadas.
- Auditoría básica y PoC de notificaciones por WhatsApp.

---

## Tecnologías utilizadas

| Componente         | Tecnología / Herramienta         |
|--------------------|----------------------------------|
| Backend            | Laravel 12 (PHP 8.3)             |
| Frontend           | Blade + Tailwind CSS             |
| Autenticación      | Jetstream + Livewire             |
| Base de datos      | MySQL (local) / SQLite (CI)      |
| CI/CD              | GitHub Actions                   |
| Control de versiones | Git + GitHub (Git Flow)        |
| Gestión ágil       | Trello (Scrum adaptado)          |

---

## Instalación local

1. Clonar el repositorio:

## git clone https://github.com/Liza88-prog/Trabajo-Integrador-Final
## cd Trabajo-Integrador-Final

2. 	Instalar dependencias:
composer install
npm install && npm run dev


3. 	Configurar entorno:

cp .env.example .env
php artisan key:generate

4. 	Configurar base de datos .env 

5. 	Ejecutar migraciones y seeders:

php artisan migrate --seed

6. 	Iniciar servidor:

php artisan serve


## Acceder desde el navegador

## Testing e integración continua
• 	Las pruebas automatizadas se ejecutan con PHPUnit.
• 	El pipeline CI/CD 
• 	Se utiliza SQLite en memoria para pruebas en entorno CI.
• 	Validación automática en cada push o pull request a  o .

## Estructura del repositorio

├── app/               # Lógica de negocio (Modelos, Controladores)
├── resources/views/   # Vistas Blade
├── routes/web.php     # Rutas del sistema
├── tests/             # Pruebas automatizadas
├── .env.example       # Variables de entorno de ejemplo
├── .github/workflows/ci.yml  # Pipeline CI
├── docs/              # Evidencias (capturas, métricas, tableros)
└── README.md

## Seguridad y buenas prácticas
• 	Validación de formularios y sanitización de entradas.
• 	Protección CSRF en todos los formularios.
• 	Manejo seguro de credenciales mediante .
• 	Estilo de código validado con PHP_CodeSniffer (PSR-12).
• 	Commits con convención 

## Mejoras futuras
• 	Integración real con WhatsApp API.
• 	Despliegue en contenedores Docker.
• 	Reportes analíticos avanzados por agente y jornada.
• 	Implementación de tests E2E y cobertura extendida.


 ## Enlaces útiles
[Repositorio GitHub](https://github.com/Liza88-prog/Trabajo-Integrador-Final/actions/workflows/ci.yml)

[pulls requests](https://github.com/Liza88-prog/Trabajo-Integrador-Final/pulls)

[test] (https://github.com/Liza88-prog/Trabajo-Integrador-Final/actions/runs/19278106984/job/55122726655)




## Lecciones aprendidas
• 	Aplicación práctica de Scrum en un entorno individual.
• 	Automatización de pruebas y validación continua con GitHub Actions.
• 	Importancia de la trazabilidad, documentación y control de versiones en proyectos reales.

