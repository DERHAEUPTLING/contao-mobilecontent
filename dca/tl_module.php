<?php

/**
 * Load tl_article data container
 */
\Contao\Controller::loadDataContainer('tl_article');
\Contao\System::loadLanguageFile('tl_article');

/**
 * Add operations
 */
$GLOBALS['TL_DCA']['tl_module']['list']['operations']['toggleOnDesktop'] = &$GLOBALS['TL_DCA']['tl_article']['list']['operations']['toggleOnDesktop'];
$GLOBALS['TL_DCA']['tl_module']['list']['operations']['toggleOnMobile'] = &$GLOBALS['TL_DCA']['tl_article']['list']['operations']['toggleOnMobile'];

/**
 * Extend palettes
 */
foreach ($GLOBALS['TL_DCA']['tl_module']['palettes'] as $k => $v) {
    if (is_array($v)) {
        continue;
    }

    \Haste\Dca\PaletteManipulator::create()
        ->addField('hideOnDesktop', 'expert_legend', \Haste\Dca\PaletteManipulator::POSITION_APPEND)
        ->addField('hideOnMobile', 'expert_legend', \Haste\Dca\PaletteManipulator::POSITION_APPEND)
        ->applyToPalette($k, 'tl_module');
}

/**
 * Add fields
 */
$GLOBALS['TL_DCA']['tl_module']['fields']['hideOnDesktop'] = &$GLOBALS['TL_DCA']['tl_article']['fields']['hideOnDesktop'];
$GLOBALS['TL_DCA']['tl_module']['fields']['hideOnMobile'] = &$GLOBALS['TL_DCA']['tl_article']['fields']['hideOnMobile'];
