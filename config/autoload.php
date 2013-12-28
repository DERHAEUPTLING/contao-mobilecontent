<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2013 Leo Feyer
 *
 * @package mobilecontent
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
  'complanar',
));

/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
  // Modules
  'complanar\MobileContent' => 'system/modules/mobilecontent/classes/MobileContent.php',
  'complanar\MobileArticle' => 'system/modules/mobilecontent/classes/MobileArticle.php',
  // Insert Tags
  'complanar\MobileInsertTag' => 'system/modules/mobilecontent/classes/MobileInsertTag.php'
));