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
 * @copyright  Holger Teichert 2013
 * @author     Holger Teichert <post@complanar.de>
 * @package    mobilecontent
 * @license    LGPL
 */

/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace complanar;

/**
 * Class MobileArticle
 *
 * Provide methods to handle an additional mobile content
 * @copyright  Holger Teichert 2013
 * @author     Holger Teichert <post@complanar.de>
 * @package    mobilecontent
 */
class MobileArticle extends \PageRegular
{ 
  /**
   * Filter article by visibility for desktop or mobile devices
   * 
   * @access public
   * @param Database_Result
   * @return void
   */
  public function filterByMobility(&$objArticle)
  {
    if ( TL_MODE != 'BE')
    {
      global $objPage;
      $hide = false;
      switch($objArticle->showatdevice) {
        case 'd':
          $hide = ($objPage->isMobile);
          break;
        case 'm':
          $hide = !($objPage->isMobile);
          break;
      }
      if ($hide) {
        $objArticle->id = 0;
      }
    }
  }
}