---
apply: off
---

# Reglas Generales de PHP/Symfony

## Estándares de Código

- Seguir PSR-12 para formato de código
- Utilizar PHP 8.4 features (typed properties, union types, etc.)
- Usar tipado estricto (declare(strict_types=1))
- Limitar líneas a 120 caracteres máximo

## Mejores Prácticas Symfony

- Utilizar Dependency Injection siempre que sea posible
- Configurar servicios como private por defecto
- Usar attributes en lugar de anotaciones (PHP 8+)
- Implementar interfaces para abstracciones

## Manejo de Errores

- Usar excepciones específicas (InvalidArgumentException, etc.)
- Logging adecuado con Monolog (monolog/monolog:3.9.0)
- Capturar y manejar excepciones en el nivel apropiado
- Evitar silenciar errores (@)

## Performance

- Implementar caché cuando sea apropiado
- Optimizar consultas de base de datos
- Utilizar lazy loading cuando sea posible
- Evitar N+1 queries problem

## Actualizaciones

- Mantener dependencias actualizadas
- Revisar regularmente vulnerabilidades con composer audit
- Seguir recomendaciones de seguridad de Symfony
- Actualizar a nuevas versiones de Symfony siguiendo el roadmap
