<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

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
 * Table tl_page
 */

// List
$GLOBALS['TL_DCA']['tl_content']['list']['sorting']['child_record_callback'] = array('tl_content_mobilecontent', 'addCteTypeWithMobileVisibility');

// Palettes
foreach($GLOBALS['TL_DCA']['tl_content']['palettes'] as $palette=>$fields)
{
  if (is_string($fields))
  {
    $GLOBALS['TL_DCA']['tl_content']['palettes'][$palette] = $fields . ',hideonmobiles,hideondesktops';
  }
}

// Fields
$GLOBALS['TL_DCA']['tl_content']['fields']['hideondesktops'] = array
(
  'label'                   => &$GLOBALS['TL_LANG']['tl_content']['hideondesktops'],
  'exclude'                 => true,
  'filter'                  => true,
  'inputType'               => 'checkbox',
  'eval'                    => array('tl_class'=>'w50')
);


$GLOBALS['TL_DCA']['tl_content']['fields']['hideonmobiles'] = array
(
  'label'                   => &$GLOBALS['TL_LANG']['tl_content']['hideonmobiles'],
  'exclude'                 => true,
  'filter'                  => true,
  'inputType'               => 'checkbox',
  'eval'                    => array('tl_class'=>'w50')
);

// Class

class tl_content_mobilecontent extends tl_content {
  /**
   * Add the type of content element
   * @param array
   * @return string
   */
  public function addCteTypeWithMobileVisibility($arrRow) {
    $str = parent::addCteType($arrRow);

    if ($arrRow['hideonmobiles'] || $arrRow['hideondesktops']) {
      $addition = '';
      
      if ($arrRow['hideonmobiles']) {
        $addition .= $GLOBALS['TL_LANG']['MSC']['hiddenonmobiles'];
      }
      if ($arrRow['hideondesktops']) {
        $addition .= empty($addition) ? '' : ', ';
        $addition .= $GLOBALS['TL_LANG']['MSC']['hiddenondesktops'];
      }

      if (strpos($str, ")</div>\n") != -1) {
        $str = str_replace(")</div>\n", ', ' . $addition . ")</div>\n", $str);
      } else {
        $str = str_replace("</div>\n", ' (' . $addition . ")</div>\n", $str);
      }
    }

    return $str;
  }
  
}
