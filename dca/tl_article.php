<?php

/**
 * Add operations
 */
$GLOBALS['TL_DCA']['tl_article']['list']['operations']['toggleOnDesktop'] = [
    'label'                => &$GLOBALS['TL_LANG']['tl_article']['toggleOnDesktop'],
    'attributes'           => 'onclick="Backend.getScrollOffset();"',
    'haste_ajax_operation' => [
        'field'   => 'hideOnDesktop',
        'options' => [
            ['value' => '', 'icon' => 'system/modules/mobilecontent/assets/desktop-visible.svg'],
            ['value' => '1', 'icon' => 'system/modules/mobilecontent/assets/desktop-invisible.svg'],
        ],
    ],
];

$GLOBALS['TL_DCA']['tl_article']['list']['operations']['toggleOnMobile'] = [
    'label'                => &$GLOBALS['TL_LANG']['tl_article']['toggleOnMobile'],
    'attributes'           => 'onclick="Backend.getScrollOffset();"',
    'haste_ajax_operation' => [
        'field'   => 'hideOnMobile',
        'options' => [
            ['value' => '', 'icon' => 'system/modules/mobilecontent/assets/mobile-visible.svg'],
            ['value' => '1', 'icon' => 'system/modules/mobilecontent/assets/mobile-invisible.svg'],
        ],
    ],
];

/**
 * Extend palettes
 */
\Haste\Dca\PaletteManipulator::create()
    ->addField('hideOnDesktop', 'publish_legend', \Haste\Dca\PaletteManipulator::POSITION_APPEND)
    ->addField('hideOnMobile', 'publish_legend', \Haste\Dca\PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('default', 'tl_article');

/**
 * Add fields
 */
$GLOBALS['TL_DCA']['tl_article']['fields']['hideOnDesktop'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_article']['hideOnDesktop'],
    'exclude'   => true,
    'filter'    => true,
    'inputType' => 'checkbox',
    'eval'      => ['tl_class' => 'w50'],
    'sql'       => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_article']['fields']['hideOnMobile'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_article']['hideOnMobile'],
    'exclude'   => true,
    'filter'    => true,
    'inputType' => 'checkbox',
    'eval'      => ['tl_class' => 'w50'],
    'sql'       => "char(1) NOT NULL default ''",
];
