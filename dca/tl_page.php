<?php

/**
 * Extend palettes
 */
\Haste\Dca\PaletteManipulator::create()
    ->addField('enableMobileDns', 'dns_legend', \Haste\Dca\PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('root', 'tl_page');

$GLOBALS['TL_DCA']['tl_page']['palettes']['__selector__'][] = 'enableMobileDns';
$GLOBALS['TL_DCA']['tl_page']['subpalettes']['enableMobileDns'] = 'mobileDns';

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
