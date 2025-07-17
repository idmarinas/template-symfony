# TODO

* Mirar si se puede agregar la opción de restaurar (en el admin) desde el common-bundle
* Mirar para añadir los campos versioned y un group serializer para los diff-field
* Agregar una opción para restablecer la contraseña desde el panel de administración
	* (Para Admin User, agregar un campo, para generar una contraseña nueva y enviarla por email al usuario a petición)
* Agregar al panel de administración un panel para ver los logs de
  Symfony https://github.com/DennisdeBest/EasyAdminLogViewerBundle
* Crear un Core-Bundle para agregar todos los paquetes, que van a estar si o si en la app (symfony components)
	* De esta forma se reduce el archivo composer.json del proyecto, haciendo que sea más fácil de leer
