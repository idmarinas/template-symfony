<!---
  - Copyright 2025 (C) IDMarinas - All Rights Reserved
  -
  - Last modified by "IDMarinas" on 01/08/2025, 17:22
  -
  - @project IDMarinas Template Symfony
  - @see https://github.com/idmarinas/template-symfony
  -
  - @file DocVar.vue
  - @date 22/07/2025
  - @time 19:48
  -
  - @author Iván Diaz Marinas (IDMarinas)
  - @license BSD 3-Clause License
  -
  - @since 1.0.0
  -->

<template>
  <span>{{ displayValue }}</span>
</template>

<script setup lang="ts">
	interface Props {
		name: string
	}

	const props = defineProps<Props>()

	// Global variables
	const globalVars: Record<string, string|Record<string,string>> = {
		project: 'IDMarinas Template Symfony',
		last_version: '1.0.0',
		repository: {
			user: 'idmarinas',
			name: 'template-symfony',
			url:  'https://github.com/idmarinas/template-symfony',
			branch: '1.x',
		},
	}

	// Calcular el valor a mostrar
	const displayValue = getNestedValue(props.name) || `([${props.name}] not found)`

	function getNestedValue(path: string): object {
		return path.split('.').reduce((acc: Record<string, any>, key: string) => acc?.[key], globalVars)
	}

</script>
