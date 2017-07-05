<?php

/**
 * mobilecontent extension for Contao Open Source CMS
 *
 * @author  Kamil Kuzminski <https://github.com/qzminski>
 * @license LGPL
 */

/**
 * Extend palettes
 */
\Haste\Dca\PaletteManipulator::create()
    ->addField('enableMobileDns', 'dns_legend', \Haste\Dca\PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('root', 'tl_page');

$GLOBALS['TL_DCA']['tl_page']['palettes']['__selector__'][] = 'enableMobileDns';
$GLOBALS['TL_DCA']['tl_page']['subpalettes']['enableMobileDns'] = 'mobileDnsExplanation,mobileDns,mobileDnsAutoRedirect';

/**
 * Add fields
 */
$GLOBALS['TL_DCA']['tl_page']['fields']['enableMobileDns'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_page']['enableMobileDns'],
    'exclude'   => true,
    'inputType' => 'checkbox',
    'eval'      => ['submitOnChange' => true, 'tl_class' => 'clr'],
    'sql'       => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_page']['fields']['mobileDns'] = [
    'label'         => &$GLOBALS['TL_LANG']['tl_page']['mobileDns'],
    'exclude'       => true,
    'inputType'     => 'text',
    'eval'          => [
        'mandatory'      => true,
        'rgxp'           => 'url',
        'decodeEntities' => true,
        'maxlength'      => 255,
        'tl_class'       => 'w50',
    ],
    'save_callback' => [['tl_page', 'checkDns']],
    'sql'           => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_page']['fields']['mobileDnsAutoRedirect'] = [
    'label'         => &$GLOBALS['TL_LANG']['tl_page']['mobileDnsAutoRedirect'],
    'exclude'       => true,
    'inputType'     => 'checkbox',
    'eval'          => ['tl_class' => 'w50 m12'],
    'sql'           => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_page']['fields']['mobileDnsExplanation'] = [
    'exclude'              => true,
    'input_field_callback' => [
        'Derhaeuptling\MobileContent\EventListener\DataContainer\PageListener',
        'generateExplanation',
    ],
];
