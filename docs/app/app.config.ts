/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 22/07/2025, 20:14
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
	},
	socials: {
		x: 'https://x.com/idmarinas',
		github: 'https://github.com/idmarinas',
		discord: 'https://discord.gg/FXEZqpF',
		reddit: 'https://www.reddit.com/user/idmarinas/',
	},
	github: {
		url: 'https://github.com/idmarinas/template-symfony',
		branch: '1.x',
		rootDir: 'docs'
	},
	ui: {
		colors: {
			primary: 'indigo',
			secondary: 'cyan'
		}
	}
})
