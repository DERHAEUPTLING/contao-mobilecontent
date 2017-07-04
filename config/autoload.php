<?php

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
