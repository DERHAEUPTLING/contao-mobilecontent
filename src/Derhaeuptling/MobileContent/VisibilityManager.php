<?php

namespace Derhaeuptling\MobileContent;

use Contao\Model;
use Contao\PageModel;

class VisibilityManager
{
    /**
     * Return true if the element is visible, false otherwise
     *
     * @param Model     $element
     * @param PageModel $page
     *
     * @return bool
     */
    public static function getElementVisibility(Model $element, PageModel $page = null)
    {
        $isMobile = static::isMobile($page);

        // Hide on mobile
        if ($isMobile && $element->hideOnMobile) {
            return false;
        }

        // Hide on desktop
        if (!$isMobile && $element->hideOnDesktop) {
            return false;
        }

        return true;
    }

    /**
     * Return true if the current page is mobile
     *
     * @param PageModel|null $page
     *
     * @return bool
     */
    public static function isMobile(PageModel $page = null)
    {
        if ($page === null) {
            $page = $GLOBALS['objPage'];
        }

        return $page->isMobile;
    }
}
