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
 * Table tl_content
 */

// List
$GLOBALS['TL_DCA']['tl_content']['list']['sorting']['child_record_callback'] = array('tl_content_mobilecontent', 'addCteTypeWithMobileVisibility');

// Palettes
foreach($GLOBALS['TL_DCA']['tl_content']['palettes'] as $palette=>$fields)
{
  if (is_string($fields))
  {
    $GLOBALS['TL_DCA']['tl_content']['palettes'][$palette] = str_replace('invisible',  'invisible,showatdevice', $fields);
  }
}

// Fields
// Make the published field smaller
$GLOBALS['TL_DCA']['tl_content']['fields']['invisible']['eval']['tl_class'] .= " w50";
$GLOBALS['TL_DCA']['tl_content']['fields']['showatdevice'] = array
(
  'label'                   => &$GLOBALS['TL_LANG']['tl_content']['showatdevice'],
  'exclude'                 => true,
  'filter'                  => true,
  'inputType'               => 'select',
  'options'                 => array('1','d','m'),
  'reference'               => &$GLOBALS['TL_LANG']['tl_content']['showatdevicelabels'],
  'eval'                    => array('tl_class'=>'w50'),
  'sql'                     => 'char(1) NOT NULL default \'1\''
);

// Class
class tl_content_mobilecontent extends tl_content {
  /**
   * Add the type of content element
   * @param array
   * @return string
   */
  public function addCteTypeWithMobileVisibility($row) {
    $label = parent::addCteType($row);

    if ($row['showatdevice'] != '1') {
      $classaddition = '';
      $addition = '';
      
      if ($row['showatdevice'] == 'd') {
        $classaddition .= ' hiddenonmobiles';
        $addition = $GLOBALS['TL_LANG']['MSC']['hiddenonmobiles'];
      } elseif ($row['showatdevice'] == 'm') {
        $classaddition .= ' hiddenondesktops';
        $addition .= $GLOBALS['TL_LANG']['MSC']['hiddenondesktops'];
      }

      $searchpattern = '@(\s+)<div\ class="cte_type\ ([a-z]*)">(.*)(\(.*\))?</div>@Um';
      $replacement = '$1<div class="cte_type $2' . $classaddition . '">$3 ($4' . $addition . ')</div>';
      $label = preg_replace($searchpattern, $replacement, $label, 1);
    }

    return $label;
  }
  
}
