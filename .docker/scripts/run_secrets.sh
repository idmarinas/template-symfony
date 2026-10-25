#!/bin/sh


set -e

# usage: file_env VAR [DEFAULT]
#    ie: file_env 'XYZ_DB_PASSWORD' 'example'
# (will allow for "$XYZ_DB_PASSWORD_FILE" to fill in the value of
#  "$XYZ_DB_PASSWORD" from a file, especially for Docker's secrets feature)
file_env() {
	file_env_var="$1"
	file_env_fileVar="${file_env_var}_FILE"
	file_env_def="${2:-}"

	# Evaluar las variables usando eval para compatibilidad con sh
	eval "file_env_var_value=\${$file_env_var:-}"
	eval "file_env_fileVar_value=\${$file_env_fileVar:-}"

	if [ -n "$file_env_var_value" ] && [ -n "$file_env_fileVar_value" ]; then
		printf >&2 'error: both %s and %s are set (but are exclusive)\n' "$file_env_var" "$file_env_fileVar"
		exit 1
	fi

	file_env_val="$file_env_def"
	if [ -n "$file_env_var_value" ]; then
		file_env_val="$file_env_var_value"
	elif [ -n "$file_env_fileVar_value" ]; then
		if [ -f "$file_env_fileVar_value" ]; then
			file_env_val="$(cat "$file_env_fileVar_value")"
		else
			printf >&2 'error: file %s does not exist\n' "$file_env_fileVar_value"
			exit 1
		fi
	fi

	# Exportar la variable base y eliminar la variable _FILE
	eval "export $file_env_var=\"\$file_env_val\""
	eval "unset $file_env_fileVar"

	# Limpiar variables temporales
	unset file_env_var file_env_fileVar file_env_def file_env_var_value file_env_fileVar_value file_env_val
}

# Obtener todas las variables *_FILE que apunten a /run/secrets y procesarlas
secret_vars_file="$(mktemp)"
printenv > "$secret_vars_file"

while IFS='=' read -r env_name env_value; do
	case "$env_name:$env_value" in
		*_FILE:/run/secrets/*)
			var="${env_name%_FILE}"
			echo "Procesando variable: $var"
			file_env "$var"
			;;
	esac
done < "$secret_vars_file"

rm -f "$secret_vars_file"

docker-php-entrypoint
exec frankenphp run --config '/etc/frankenphp/Caddyfile' "$@"
