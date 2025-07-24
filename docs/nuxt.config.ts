/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 24/07/2025, 16:48
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

	future: {
		compatibilityVersion: 4,
	},

	devtools: {
		enabled: true,
	},
})
