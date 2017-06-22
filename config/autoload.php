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
        'mobile_content' => 'system/modules/mobilecontent/templates'
    ]);
}
