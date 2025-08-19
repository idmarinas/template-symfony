/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 19/08/2025, 17:38
 *
 * @project IDMarinas Template Symfony
 * @see https://github.com/idmarinas/template-symfony
 *
 * @file app.config.ts
 * @date 02/07/2025
 * @time 19:28
 *
 * @author Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since 1.0.0
 */

export default defineAppConfig({
	header: {
		title: 'IDMarinas Template Symfony',
		logo: {
			light: 'images/logo-light.webp',
			dark: 'images/logo-dark.webp',
		}
	},
	socials: {
		bitly: 'https://bit.ly/m/idmarinas',
		x: 'https://x.com/idmarinas',
		discord: 'https://discord.gg/FXEZqpF',
		reddit: 'https://www.reddit.com/user/idmarinas/',
	},
	toc: {
		// Add a bottom section to the table of contents
		bottom: {
		  links: [{
		    icon: 'i-lucide-github',
		    label: 'GitHub of IDMarinas',
		    to: 'https://github.com/idmarinas',
		    target: '_blank'
		  }]
		}
	},
	github: {
		url: 'https://github.com/idmarinas/template-symfony',
		branch: '1.x',
		rootDir: 'docs'
	},
	ui: {
		colors: {
			primary: 'indigo',
			secondary: 'cyan',
			purple: 'purple',
			orange: 'orange'
		}
	}
})
