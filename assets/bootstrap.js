/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 08/07/2025, 17:00
 *
 * @project IDMarinas Template Symfony
 * @see https://github.com/idmarinas/template-symfony
 *
 * @file bootstrap.js
 * @date 27/06/2025
 * @time 14:16
 *
 * @author Iván Diaz Marinas (IDMarinas)
 * @license undefined
 *
 * @since 1.0.0
 */

import {startStimulusApp} from '@symfony/stimulus-bundle'
import registerIdmUiBundle from '@idmarinas/ui-bundle'

const app = startStimulusApp()
registerIdmUiBundle(app)

// register any custom, 3rd party controllers here
// app.register('some_controller_name', SomeImportedController);
