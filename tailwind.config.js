/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 21/02/2025, 13:55
 *
 * @project IDMarinas Template Symfony
 * @see https://github.com/idmarinas/template-symfony
 *
 * @file tailwind.config.js
 * @date 21/02/2025
 * @time 14:02
 *
 * @author Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since 1.0.0
 */

/** @type {import('tailwindcss').Config} */
module.exports = {
	content: [
		'./src/**/*.php',
		'./assets/**/*.js',
		'./templates/**/*.html.twig',
		'./vendor/symfony/twig-bridge/Resources/views/Form/*.html.twig',
	],
	theme: {
		extend: {
			keyframes: {
				progressBarAnimation: {
					'0%': {
						opacity: '0.3',
						transform: 'scale(0.1)',
					},
					'100%': {
						opacity: '0',
						transform: 'scale(1)',
					},
				},
				swinging: {
					'0%': {
						transform: 'translateX(-100%)',
					},
					'50%': {
						transform: 'translateX(100%)',
					},
					'100%': {
						transform: 'translateX(-100%)',
					},
				},
			},

			animation: {
				swinging: 'swinging 2s ease infinite',
				'progress-waiting': 'progressBarAnimation 1s linear infinite',
			},
		},
	},
	plugins: [
		require('@tailwindcss/typography'),
		require('@tailwindcss/forms'),
	],
}
