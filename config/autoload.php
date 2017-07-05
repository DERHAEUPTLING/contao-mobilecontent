<?php

/**
 * mobilecontent extension for Contao Open Source CMS
 *
 * @author  Kamil Kuzminski <https://github.com/qzminski>
 * @author  derhaeuptling <https://derhaeuptling.com>
 * @author  Martin Schwenzer <mail@derhaeuptling.com>
 * @license LGPL
 */

/**
 * Register PSR-0 namespace
 */
if (class_exists('NamespaceClassLoader')) {
    NamespaceClassLoader::add('Derhaeuptling\MobileContent', 'system/modules/mobilecontent/src');
}

/**
 * Register the templates
 */
if (class_exists('TemplateLoader')) {
    TemplateLoader::addFiles([
        'mod_mobile_switch' => 'system/modules/mobilecontent/templates/modules',
    ]);
}
