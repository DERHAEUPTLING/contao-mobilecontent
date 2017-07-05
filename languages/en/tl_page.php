<?php

/**
 * mobilecontent extension for Contao Open Source CMS
 *
 * @author  Kamil Kuzminski <https://github.com/qzminski>
 * @license LGPL
 */

/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_page']['enableMobileDns'] = ['Enable mobile DNS', 'Enable a different DNS settings for mobile devices.'];
$GLOBALS['TL_LANG']['tl_page']['mobileDns'] = ['Mobile domain name', 'Please enter the domain name for mobile devices.'];
$GLOBALS['TL_LANG']['tl_page']['mobileDnsAutoRedirect'] = ['Auto redirect to correct version', 'Auto redirect the visitors to the correct version (e.g. mobile visitor will be redirected to mobile domain).'];

/**
 * Miscellaneous
 */
$GLOBALS['TL_LANG']['tl_page']['mobileDnsExplanations'] = [
    'Please make sure that you enter the regular domain name in the DNS settings above in order the feature to work correctly.',
    'You should also consider adding the mobile/desktop switch front end module to the page layout.'
];
