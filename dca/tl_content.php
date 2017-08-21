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
 * Load tl_article data container
 */
\Contao\Controller::loadDataContainer('tl_article');
\Contao\System::loadLanguageFile('tl_article');

/**
 * Add operations
 */
array_insert($GLOBALS['TL_DCA']['tl_content']['list']['operations'], 5, [
    'toggleOnDesktop' => &$GLOBALS['TL_DCA']['tl_article']['list']['operations']['toggleOnDesktop'],
    'toggleOnMobile' => &$GLOBALS['TL_DCA']['tl_article']['list']['operations']['toggleOnMobile'],
]);

/**
 * Extend palettes
 */
$GLOBALS['TL_DCA']['tl_content']['palettes']['__selector__'][] = 'mobileImage';
$GLOBALS['TL_DCA']['tl_content']['subpalettes']['mobileImage'] = 'mobileImageSrc,mobileImageSize';

foreach ($GLOBALS['TL_DCA']['tl_content']['palettes'] as $k => $v) {
    if (is_array($v)) {
        continue;
    }

    \Haste\Dca\PaletteManipulator::create()
        ->addField('hideOnDesktop', 'publish_legend', \Haste\Dca\PaletteManipulator::POSITION_APPEND)
        ->addField('hideOnMobile', 'publish_legend', \Haste\Dca\PaletteManipulator::POSITION_APPEND)
        ->applyToPalette($k, 'tl_content');
}

\Haste\Dca\PaletteManipulator::create()
    ->addField('mobileImage', 'singleSRC', \Haste\Dca\PaletteManipulator::POSITION_AFTER)
    ->applyToPalette('image', 'tl_content')
    ->applyToSubpalette('addImage', 'tl_content')
    ->applyToSubpalette('useImage', 'tl_content');

/**
 * Add fields
 */
$GLOBALS['TL_DCA']['tl_content']['fields']['hideOnDesktop'] = &$GLOBALS['TL_DCA']['tl_article']['fields']['hideOnDesktop'];
$GLOBALS['TL_DCA']['tl_content']['fields']['hideOnMobile'] = &$GLOBALS['TL_DCA']['tl_article']['fields']['hideOnMobile'];

$GLOBALS['TL_DCA']['tl_content']['fields']['mobileImage'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['mobileImage'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => ['submitOnChange' => true, 'tl_class' => 'clr'],
    'sql' => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['mobileImageSrc'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['mobileImageSrc'],
    'exclude' => true,
    'inputType' => 'fileTree',
    'eval' => [
        'filesOnly' => true,
        'fieldType' => 'radio',
        'mandatory' => true,
        'extensions' => Config::get('validImageTypes'),
        'tl_class' => 'clr',
    ],
    'sql' => "binary(16) NULL",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['mobileImageSize'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['mobileImageSize'],
    'exclude' => true,
    'inputType' => 'imageSize',
    'options' => System::getImageSizes(),
    'reference' => &$GLOBALS['TL_LANG']['MSC'],
    'eval' => [
        'rgxp' => 'natural',
        'includeBlankOption' => true,
        'nospace' => true,
        'helpwizard' => true,
        'tl_class' => 'clr',
    ],
    'sql' => "varchar(64) NOT NULL default ''",
];
