<!---
  - Copyright 2025 (C) IDMarinas - All Rights Reserved
  -
  - Last modified by "IDMarinas" on 23/07/2025, 21:03
  -
  - @project IDMarinas Template Symfony
  - @see https://github.com/idmarinas/template-symfony
  -
  - @file DocTerm.vue
  - @date 23/07/2025
  - @time 19:41
  -
  - @author Iván Diaz Marinas (IDMarinas)
  - @license BSD 3-Clause License
  -
  - @since 1.0.0
  -->

<template>
	<UTooltip arrow :delay-duration="0" :text="term.text">
		<span>{{ term.abbr }}</span>
	</UTooltip>

</template>

<script setup lang="ts">
	interface Props {
		name: string
	}

	interface Term {
		abbr: string
		text: string
	}

	const props = defineProps<Props>()

	const terms: Record<string, Term> = {
		gui: {
			abbr: 'GUI',
			text: 'Graphical User Interface'
		},
		http: {
			abbr: 'HTTP',
			text: 'Hypertext Transfer Protocol'
		},
		https: {
			abbr: 'HTTPS',
			text: 'Hypertext Transfer Protocol Secure'
		},
	}

	// Calcular el valor a mostrar
	const term: Term = computed(() => {
	  const value = terms[props.name]
	  return value || { abbr: props.name, text: `([${props.name}] not found)`}
	})
</script>

<style scoped>
	span {
		text-decoration: dotted underline;
	}
</style>
