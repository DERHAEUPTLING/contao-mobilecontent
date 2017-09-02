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
 * Fields
 */
$GLOBALS['TL_LANG']['tl_page']['enableMobileDns'] = ['Enable mobile DNS', 'Enable a different DNS settings for mobile devices.'];
$GLOBALS['TL_LANG']['tl_page']['mobileDns'] = ['Mobile domain name', 'Please enter the domain name for mobile devices.'];
$GLOBALS['TL_LANG']['tl_page']['mobileDnsAutoRedirect'] = ['Auto redirect to correct version', 'Auto redirect the visitors to the correct version (e.g. mobile visitor will be redirected to mobile domain).'];
$GLOBALS['TL_LANG']['tl_page']['mobileDnsBreakpointDetection'] = ['Use breakpoint to detect mobile device', 'Use the breakpoint in pixels to detect the mobile device instead of regular Contao User-Agent detection. For this to work the mobile/desktop switch front end module must be added the the page layout.'];
$GLOBALS['TL_LANG']['tl_page']['mobileDnsBreakpoint'] = ['Mobile device breakpoint (px)', 'Please enter the breakpoint of maximum width in pixels for the mobile devices. For example <em>600</em> translates to media query <em>(max-width:600px)</em>'];

/**
 * Miscellaneous
 */
$GLOBALS['TL_LANG']['tl_page']['mobileDnsExplanations'] = [
    'Please make sure that you enter the regular domain name in the DNS settings above in order the feature to work correctly.',
    'You should also consider adding the mobile/desktop switch front end module to the page layout.'
];
