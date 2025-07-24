<!---
  - Copyright 2025 (C) IDMarinas - All Rights Reserved
  -
  - Last modified by "IDMarinas" on 24/07/2025, 17:22
  -
  - @project IDMarinas Template Symfony
  - @see https://github.com/idmarinas/template-symfony
  -
  - @file DocLabel.vue
  - @date 23/07/2025
  - @time 19:41
  -
  - @author Iván Diaz Marinas (IDMarinas)
  - @license BSD 3-Clause License
  -
  - @since 1.0.0
  -->


<template>
	<ULink v-if="label.link" :to="label.link">
		<UTooltip :text="label.description" :color="label.color" :delay-duration="0">
			<UBadge :icon="label.icon" :variant="label.variant" :size="label.size">{{ label.name }}</UBadge>
		</UTooltip>
	</ULink>
	<UTooltip v-else :text="label.description" :color="label.color" :delay-duration="0">
		<UBadge :icon="label.icon" :variant="label.variant" :size="label.size">{{ label.name }}</UBadge>
	</UTooltip>
</template>

<script setup lang="ts">
	interface Props {
		name: string
	}

	interface Label {
		name?: string,
		description?: string,
		// "error" | "primary" | "secondary" | "success" | "info" | "warning" | "neutral"
		color: string,
		icon?: string,
		variant?: 'solid' | 'outline' | 'soft' | 'subtle',
		size?: 'sm' | 'md' | 'lg' | 'xl' | 'xs',
		link?: string,
	}

	const props = defineProps<Props>()

	const labels: Record<string, Label> = {
		beta: {
			name: 'β',
			description: 'This feature is in beta stage',
			color: 'orange',
			variant: 'outline',
		},
		wip: {
			name: 'WIP',
			description: 'This feature is a work in progress',
			color: 'purple',
			variant: 'outline',
		},
		'last-version': {
			name: '1.0.0',
			description: 'This is the last version',
			color: 'success',
			icon: 'i-lucide-check-circle',
		},
		'1.0.0': {
			name: '1.0.0',
			description: 'New in version 1.0.0',
			color: 'info',
		},
	}

	const defaultLabel: Label = {
		// Default label style
		color: 'info',
		variant: 'subtle',
	}

	const notFoundLabel: Label = {
		description: `Label [${props.name}] not found`,
		variant: 'soft',
		color: 'neutral',
		icon: 'i-lucide-triangle-alert'
	}

	const label: Label = Object.assign({}, defaultLabel, labels[props.name] || notFoundLabel)
</script>
