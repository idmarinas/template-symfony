# Guía de Estilo de Código

Esta guía define los principios lógicos y arquitectónicos para el proyecto `IDMarinas Template Symfony`. Los detalles de formato visual están automatizados y se definen en los archivos de configuración correspondientes.

## 1. Fuente de Verdad para el Formato

Todas las reglas de formato visual se encuentran en los archivos `.editorconfig`. Las IAs y editores deben respetar estrictamente estos archivos:

- [`.editorconfig`](file:///k:/template-symfony/.editorconfig) (Raíz del proyecto - **Prioridad Máxima**)
- [`.agent/docs/.editorconfig`](file:///k:/template-symfony/.agent/docs/.editorconfig) (Configuración específica del agente)

> [!IMPORTANT]
> En caso de conflicto entre ambos archivos, prevalece siempre el archivo [`.editorconfig`](file:///k:/template-symfony/.editorconfig) de la raíz del proyecto.

### Reglas básicas de formato

- **PHP y Lenguajes Generales**: Uso de **Tabs** para indentación.
- **YAML, Twig y Markdown**: Uso de **Spaces** (2 o 4 según el archivo) para indentación.
- **Final de línea**: LF.
- **Codificación**: UTF-8.

## 2. Convenciones de Nombrado

- **Clases y Namespaces**: PascalCase (ej. `UserCrudController`).
- **Namespaces Multi-App**: Seguir la estructura de la aplicación (`Core\`, `Admin\`, `Web\`, `Api\`, etc.).
- **Métodos y Variables**: camelCase (ej. `configureFields`, `$userRepository`).
- **Constantes**: UPPER_SNAKE_CASE (ej. `STATUS_ACTIVE`).
- **Archivos de configuración (YAML)**: snake_case (ej. `services.yaml`).

## 3. Mejores Prácticas PHP 8.4 y Symfony 7.4

- **Tipado Estricto**: Todos los archivos PHP deben comenzar con `declare(strict_types=1);`.
- **Tipado Completo**: Es obligatorio tipar propiedades de clase, parámetros de métodos y valores de retorno.
- **Atributos**: Favorecer el uso de **Attributes** nativos de PHP sobre anotaciones PHPDoc (ej. para rutas, ORM, validación).
- **Constructor Property Promotion**: Utilizar para simplificar la inyección de dependencias.
- **Readonly**: Utilizar `readonly` para propiedades y clases que no deban cambiar tras su inicialización.

## 4. Principios de Diseño

- **S.O.L.I.D**: Seguir los principios de diseño orientado a objetos.
- **KISS (Keep It Simple, Stupid)**: Evitar la sobre-ingeniería.
- **DRY (Don't Repeat Yourself)**: Abstraer lógica común en servicios compartidos dentro de `src/` (Core).

## 5. Comentarios y Documentación

- **Código Auto-explicativo**: El código debe ser claro por sí mismo.
- **PHPDoc Mínimo**: Usar PHPDoc solo cuando el tipado nativo de PHP no sea suficiente (ej. arrays de objetos genéricos `Item[]`) o para explicar lógica de negocio compleja.
- **Evitar Ruido**: No añadir bloques de comentarios que solo repitan la firma del método.

## 6. Manejo de Errores

- Utilizar excepciones específicas en lugar de códigos de retorno.
- Capturar solo las excepciones que se pueden manejar de forma efectiva.
