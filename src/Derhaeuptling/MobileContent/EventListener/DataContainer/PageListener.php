<?php

namespace Derhaeuptling\MobileContent\EventListener\DataContainer;

class PageListener
{
    /**
     * Generate the mobile DNS explanation
     */
    public function generateExplanation()
    {
        return sprintf(
            '<div class="clr tl_message" style="margin-left:0;margin-right:0;"><p class="tl_info">%s</p></div>',
            $GLOBALS['TL_LANG']['tl_page']['mobileDnsExplanation']
        );
    }
}
