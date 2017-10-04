<?php

/**
 * mobilecontent extension for Contao Open Source CMS
 *
 * @author  Kamil Kuzminski <https://github.com/qzminski>
 * @author  derhaeuptling <https://derhaeuptling.com>
 * @author  Martin Schwenzer <mail@derhaeuptling.com>
 * @license LGPL
 */

namespace Derhaeuptling\MobileContent\EventListener\DataContainer;

use Contao\DataContainer;
use Contao\PageModel;
use Haste\Dca\PaletteManipulator;

class PageListener
{
    /**
     * On load callback
     *
     * @param DataContainer $dc
     */
    public function onLoadCallback(DataContainer $dc)
    {
        if (!$dc->id || ($page = PageModel::findByPk($dc->id)) === null || $page->type !== 'root') {
            return;
        }

        // Add the mobile DNS fields
        if ($page->enableMobileDns) {
            PaletteManipulator::create()
                ->addField('mobileDns', 'enableMobileDns', PaletteManipulator::POSITION_AFTER)
                ->addField('mobileDnsExplanation', 'enableMobileDns', PaletteManipulator::POSITION_AFTER)
                ->applyToPalette('root', 'tl_page');
        }

        // Add the breakpoint detection fields
        if ($page->mobileDnsBreakpointDetection) {
            PaletteManipulator::create()
                ->addField('mobileDnsBreakpoint', 'mobileDnsBreakpointDetection', PaletteManipulator::POSITION_AFTER)
                ->applyToPalette('root', 'tl_page');
        }

        // Add the auto redirect field
        if ($page->enableMobileDns || $page->mobileDnsBreakpointDetection) {
            PaletteManipulator::create()
                ->addField('mobileDnsAutoRedirect', 'dns_legend', PaletteManipulator::POSITION_APPEND)
                ->applyToPalette('root', 'tl_page');
        }
    }

    /**
     * Generate the mobile DNS explanation
     */
    public function generateExplanation()
    {
        $buffer = '';

        foreach ($GLOBALS['TL_LANG']['tl_page']['mobileDnsExplanations'] as $message) {
            $buffer .= sprintf('<div class="clr tl_message" style="margin:5px 0;"><p class="tl_info">%s</p></div>', $message);
        }

        return $buffer;
    }
}
