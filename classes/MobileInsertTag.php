<?php

/**
 * Mobile Content
 * Copyright (C) 2013 Holger Teichert
 *
 * Extension for:
 * Contao Open Source CMS
 * Copyright (C) 2005-2013 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 *
 * @copyright  2013–2014 Holger Teichert
 * @author     Holger Teichert <post@complanar.de>
 * @package    mobilecontent
 * @license    LGPL
 */

/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace complanar;

/**
 * Class MobileInsertTag
 *
 * Provide methods to replace some new insert tags
 * @copyright  2013–2014 Holger Teichert
 * @author     Holger Teichert <post@complanar.de>
 * @package    mobilecontent
 */
class MobileInsertTag extends \Controller
{
  
  public function replaceMobileInsertTags ($strTag, $blnCache, $tagCache, $arrCache, $tags, $flags, &$_rit, &$_cnt, $flag=null)
  {
    global $objPage;
    $return = false;
    
    $strUrl = $this->Environment->request;
    $strGlue = (strpos($strUrl, '?') === false) ? '?' : '&amp;';
    $strUrlMobile = $strUrl . $strGlue . 'toggle_view=mobile';
    $strUrlDesktop = $strUrl . $strGlue . 'toggle_view=desktop';
    
    $flags = explode('|', $strTag);
    $elements = explode('::', array_shift($flags));
    
    switch ($elements[0])
    {
      // Mobile/desktop toggle
      case 'mobile':
        // hide if there is no mobile layout
        if (!$objPage->mobileLayout)
        {
          return false;
        }
        switch ($elements[1])
        {
          case 'toggle':
            if ($objPage->isMobile)
            {
              $return = '<a href="' . $strUrlDesktop . '" title="' . specialchars($GLOBALS['TL_LANG']['MSC']['toggleDesktop'][1]) . '" class="toggle_view mobile_toggle desktop">' . $GLOBALS['TL_LANG']['MSC']['toggleDesktop'][0] . '</a>';
            }
            else
            {
              $return = '<a href="' . $strUrlMobile . '" title="' . specialchars($GLOBALS['TL_LANG']['MSC']['toggleMobile'][1]) . '" class="toggle_view mobile_toggle mobile">' . $GLOBALS['TL_LANG']['MSC']['toggleMobile'][0] . '</a>';
            }
            break;
          
          case 'toggle_url':
            $return = ($objPage->isMobile)? $strUrlDesktop : $strUrlMobile;
            break;
          
          case 'toggle_text':
            $return = ($objPage->isMobile)? $GLOBALS['TL_LANG']['MSC']['toggleDesktop'][0] : $GLOBALS['TL_LANG']['MSC']['toggleMobile'][0];
            break;
          
          case 'toggle_title':
            $return = ($objPage->isMobile)? $GLOBALS['TL_LANG']['MSC']['toggleDesktop'][1] : $GLOBALS['TL_LANG']['MSC']['toggleMobile'][1];
            break;
          
          case 'alternatives':
            $alternatives = explode(':', $elements[2]);
            if (!is_array($alternatives) && count($alternatives) < 2) 
            {
              $return = false;
            } 
            else 
            {
              $return = ($objPage->isMobile)? $alternatives[1] : $alternatives[0];
            }
            break;
        }
        break;
      // Conditional tags (if mobile, ifnmobile, ifdesktop, ifndesktop)
      case 'ifmobile':
      case 'ifnmobile':
      case 'ifdesktop':
      case 'ifndesktop':
        if (in_array($elements[0], array('ifmobile', 'ifndesktop')) && !$objPage->isMobile || 
            in_array($elements[0], array('ifnmobile', 'ifdesktop')) && $objPage->isMobile)
        {
          for (; $_rit<$_cnt; $_rit+=3)
          {
            if ($tags[$_rit+1] == 'end'.$elements[0])
            {
              break;
            }
          }
          // Prevent caching
          $return = null;
        }
        break;
    }
    return $return;
  }
}