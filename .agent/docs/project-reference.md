# Project Reference - IDMarinas Template Symfony

Este documento sirve como referencia técnica para el proyecto basado en la plantilla Symfony de IDMarinas. Está diseñado para ser utilizado como base en la creación de nuevos proyectos, tanto de aplicación única como multi-aplicación.

## Descripción General

Esta plantilla proporciona una estructura robusta y pre-configurada para desarrollar aplicaciones Symfony modernas, con soporte nativo para múltiples aplicaciones dentro del mismo repositorio compartiendo un núcleo común.

## Arquitectura de Aplicaciones

El proyecto sigue una arquitectura multi-aplicación:

- **`apps/`**: Contiene las diferentes aplicaciones del proyecto (ej: `admin`, `api`, `web`). Cada una tiene su propia configuración, controladores y plantillas.
- **`src/`**: Contiene el **Core** del sistema. Aquí se ubican las entidades Doctrine, repositorios y servicios compartidos que son utilizados por todas las aplicaciones en `apps/`.
- **`AbstractKernel.php` & `Kernel.php`**: Implementan la lógica para manejar la carga de configuraciones y rutas específicas según la aplicación ejecutada.

## Stack Tecnológico

### Backend

- **PHP**: `^8.4`
- **Symfony**: `7.4.*`
- **Base de Datos**: MariaDB (gestionada vía Docker)
- **ORM**: Doctrine ORM `^3.4`
- **Admin**: EasyAdmin Bundle `^4.24`

### Frontend

- **AssetMapper**: Gestión de assets sin necesidad de Node.js (Symfony nativo).
- **Tailwind CSS**: `^4.0` para estilos.
- **Stimulus**: `^2.26` para interactividad JavaScript.
- **Turbo**: `^2.26` para navegación rápida tipo SPA.

## Estructura de Directorios Clave

- `.aiassistant/rules/`: Reglas personalizadas para asistentes de IA.
- `.docker/`: Configuraciones y scripts para el entorno Docker.
- `apps/`: Directorio de aplicaciones individuales.
- `config/`: Configuraciones globales de Symfony.
- `migrations/`: Migraciones de base de datos Doctrine.
- `public/`: Directorio raíz web público.
- `src/`: Lógica compartida (Core).
- `tests/`: Pruebas automatizadas globales.

## Flujo de Desarrollo

### Personalización de la Plantilla

Al crear un nuevo proyecto desde esta plantilla, se debe ejecutar:

```shell
composer install
composer idm:customize:app
```

Este comando permite configurar el nombre del proyecto, el espacio de nombres (Namespace) y otros parámetros iniciales.

### Entorno Docker

El proyecto incluye configuración de Docker Compose (`compose.yaml`, `compose.override.yaml`) para levantar rápidamente un entorno de desarrollo con:

- Servidor web (Caddy/Nginx vía imagen personalizada).
- Base de datos MariaDB.

### Comandos Útiles

- `composer test:fixtures:load`: Limpia y carga fixtures en el entorno de test.
- `composer dev:fixtures:load`: Limpia y carga fixtures en el entorno de desarrollo.
- `composer idm:customize:app`: Personaliza el proyecto.

## CI/CD y Calidad de Código

- **GitHub Actions**: Workflows configurados para ejecución de tests y análisis.
- **PHPStan**: Análisis estático de código (`phpstan.dist.neon`).
- **Rector**: Herramienta para actualizaciones automáticas de PHP/Symfony (`rector.php`).
- **Deployer**: Configuración para despliegues automatizados (`deploy.php`).
