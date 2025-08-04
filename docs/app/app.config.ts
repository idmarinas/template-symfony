/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 04/08/2025, 11:30
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

import {github} from '~~/shared.config'

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
		github: 'https://github.com/idmarinas',
		discord: 'https://discord.gg/FXEZqpF',
		reddit: 'https://www.reddit.com/user/idmarinas/',
	},
	github,
	ui: {
		colors: {
			primary: 'indigo',
			secondary: 'cyan',
			purple: 'purple',
			orange: 'orange'
		}
	}
})
