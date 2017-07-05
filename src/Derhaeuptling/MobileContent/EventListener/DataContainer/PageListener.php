<?php

namespace Derhaeuptling\MobileContent\EventListener\DataContainer;

class PageListener
{
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
