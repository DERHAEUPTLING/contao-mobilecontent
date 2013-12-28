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
 * Table tl_article
 */

// List
$GLOBALS['TL_DCA']['tl_article']['list']['label']['label_callback'] = array('tl_article_mobilecontent', 'articleLabelWithMobileVisibility');

// Palettes
foreach($GLOBALS['TL_DCA']['tl_article']['palettes'] as $palette=>$fields)
{
  if (is_string($fields))
  {
    /*echo '<pre>foreach-start\n';
    var_dump($palette, $fields);
    echo '</pre>';*/
    $GLOBALS['TL_DCA']['tl_article']['palettes'][$palette] = str_replace(';{publish_legend',  ';{mobilecontent_legend:hide},hideonmobiles,hideondesktops;{publish_legend', $fields);
  }
}

// Fields
$GLOBALS['TL_DCA']['tl_article']['fields']['hideondesktops'] = array
(
  'label'                   => &$GLOBALS['TL_LANG']['tl_article']['hideondesktops'],
  'exclude'                 => true,
  'filter'                  => true,
  'inputType'               => 'checkbox',
  'eval'                    => array('tl_class'=>'w50'),
  'sql'                     => 'char(1) NOT NULL default \'\''
);


$GLOBALS['TL_DCA']['tl_article']['fields']['hideonmobiles'] = array
(
  'label'                   => &$GLOBALS['TL_LANG']['tl_article']['hideonmobiles'],
  'exclude'                 => true,
  'filter'                  => true,
  'inputType'               => 'checkbox',
  'eval'                    => array('tl_class'=>'w50'),
  'sql'                     => 'char(1) NOT NULL default \'\''
);

// Class

class tl_article_mobilecontent extends tl_article {
  /**
   * Add a hint to mobile content visibility to each label
   * @param array
   * @param string
   * @return string
   */
  public function articleLabelWithMobileVisibility($row, $label)
  {
    $label = $this->addIcon($row, $label);
    if ($row['hideonmobiles'] || $row['hideondesktops']) {
      $classaddition = '';
      $addition = '';
      
      if ($row['hideonmobiles']) {
        $classaddition .= ' hiddenonmobiles';
        if ($row['hideondesktops']) {
          $classaddition .= ' hiddenondesktops';
          $classaddition .= ' hiddenonmobilesanddesktops';
          $addition .= $GLOBALS['TL_LANG']['MSC']['hiddenonmobilesanddesktops'];
        } else {
          $addition .= $GLOBALS['TL_LANG']['MSC']['hiddenonmobiles'];
        }
      } else if ($row['hideondesktops']) {
        $classaddition .= ' hiddenondesktops';
        $addition .= $GLOBALS['TL_LANG']['MSC']['hiddenondesktops'];
      }
      $label .= '<span class="' . ltrim($classaddition) . '" style="padding-left:3px">(' . $addition . ')</span>';
    }

    return $label;
  }
}
