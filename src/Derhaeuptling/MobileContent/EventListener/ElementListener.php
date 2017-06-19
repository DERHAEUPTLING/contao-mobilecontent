<?php

namespace Derhaeuptling\MobileContent\EventListener;

use Contao\Model;
use Derhaeuptling\MobileContent\VisibilityManager;

class ElementListener
{
    /**
     * Return true if the element is visible
     *
     * @param Model $element
     * @param bool  $visible
     *
     * @return bool
     */
    public function onIsVisibleElement(Model $element, $visible)
    {
        if (TL_MODE === 'FE' && $visible) {
            $visible = VisibilityManager::getElementVisibility($element);
        }

        return $visible;
    }
}
