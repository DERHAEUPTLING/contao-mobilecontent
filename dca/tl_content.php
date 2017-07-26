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
foreach ($GLOBALS['TL_DCA']['tl_content']['palettes'] as $k => $v) {
    if (is_array($v)) {
        continue;
    }

    \Haste\Dca\PaletteManipulator::create()
        ->addField('hideOnDesktop', 'publish_legend', \Haste\Dca\PaletteManipulator::POSITION_APPEND)
        ->addField('hideOnMobile', 'publish_legend', \Haste\Dca\PaletteManipulator::POSITION_APPEND)
        ->applyToPalette($k, 'tl_content');
}

/**
 * Add fields
 */
$GLOBALS['TL_DCA']['tl_content']['fields']['hideOnDesktop'] = &$GLOBALS['TL_DCA']['tl_article']['fields']['hideOnDesktop'];
$GLOBALS['TL_DCA']['tl_content']['fields']['hideOnMobile'] = &$GLOBALS['TL_DCA']['tl_article']['fields']['hideOnMobile'];
