/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 28/07/2025, 21:07
 *
 * @project IDMarinas Template Symfony
 * @see https://github.com/idmarinas/template-symfony
 *
 * @file nuxt.config.ts
 * @date 10/07/2025
 * @time 16:30
 *
 * @author Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since 1.0.0
 */

export default defineNuxtConfig({
	extends: [
		'docus',
		'github:idmarinas/nuxt-layers/docs-versioning#master'
	],
	site: {
		name: 'IDMarinas Template Symfony'
	},
	llms: {
		domain: 'https://your-site.com', // Change me
	},
	ui: {
		theme: {
			colors: [
				'primary',
				'secondary',
				'info',
				'success',
				'warning',
				'error',
				'purple',
				'orange'
			]
		}
	},

	devtools: {
		enabled: true,
	},
})
