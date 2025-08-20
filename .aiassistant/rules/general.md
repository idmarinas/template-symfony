---
apply: always
---

# Reglas Generales del Proyecto

## Estructura del Proyecto

- Seguir la estructura estándar de Symfony 7.3
- Mantener separación clara entre capas (controllers, services, entities)
- Crear directorios con nombres en singular (Controller, Entity, etc.)
- El proyecto sigue el modelo de Multiple-APP de Symfony

## Control de Versiones

- Commits atómicos con mensajes claros
- Seguir Conventional Commits (feat:, fix:, docs:, etc.)
- Pull requests para cambios significativos
- No hacer commit de archivos de configuración local (.env.local)

## Seguridad

- No exponer datos sensibles (credenciales, tokens, etc.)
- Validar toda entrada de usuario
- Utilizar CSRF protection en formularios
- Implementar autenticación y autorización apropiadas

## Información técnica del proyecto

- Symfony 7.3.*
- PHP 8.4
- Doctrine ORM 3.5.0
- MariaDB database
- PHPUnit 12 para testing
