<?php

/**
 * mobilecontent extension for Contao Open Source CMS
 *
 * @author  Kamil Kuzminski <https://github.com/qzminski>
 * @author  derhaeuptling <https://derhaeuptling.com>
 * @author  Martin Schwenzer <mail@derhaeuptling.com>
 * @license LGPL
 */

namespace Derhaeuptling\MobileContent\EventListener;

use Contao\Environment;
use Contao\PageModel;
use Haste\Util\Url;

class InsertTagsListener
{
    /**
     * On replace the insert tag
     *
     * @param string $tag
     * @param bool   $isCache
     * @param mixed  $value
     * @param array  $flags
     * @param array  $tags
     * @param array  $cache
     * @param int    &$_rit
     * @param int    &$_cnt
     *
     * @return mixed
     */
    public function onReplace($tag, $isCache, $value, array $flags, array $tags, array $cache, &$_rit, &$_cnt)
    {
        $chunks   = trimsplit('::', $tag);
        $isMobile = $GLOBALS['objPage']->isMobile;

        switch ($chunks[0]) {
            case 'mobile':
                return $this->parseMobileTag($chunks, $isMobile);
            case 'ifmobile':
            case 'ifnmobile':
            case 'ifdesktop':
            case 'ifndesktop':
                return $this->parseConditionalTags($chunks, $isMobile, $tags, $_rit, $_cnt);
        }

        return false;
    }

    /**
     * Parse the conditional tags
     *
     * @param array $chunks
     * @param bool  $isMobile
     * @param array $tags
     * @param int   &$_rit
     * @param int   &$_cnt
     *
     * @return mixed
     */
    private function parseConditionalTags(array $chunks, $isMobile, array $tags, &$_rit, &$_cnt)
    {
        if ((in_array($chunks[0], ['ifmobile', 'ifndesktop'], true) && !$isMobile)
            || (in_array($chunks[0], ['ifnmobile', 'ifdesktop'], true) && $isMobile)
        ) {
            for (; $_rit < $_cnt; $_rit += 3) {
                if ($tags[$_rit + 1] === 'end' . $chunks[0]) {
                    break;
                }
            }

            return null;
        }

        return false;
    }

    /**
     * Parse the mobile tags
     *
     * @param array $chunks
     * @param bool  $isMobile
     *
     * @return mixed
     */
    private function parseMobileTag(array $chunks, $isMobile)
    {
        switch ($chunks[1]) {
            // Toggle link
            case 'toggle':
                return sprintf(
                    '<a href="%s" title="%s" class="%s">%s</a>',
                    ampersand($this->getToggleUrl($isMobile)),
                    specialchars($this->getToggleTitle($isMobile)),
                    'toggle_view mobile_toggle '.($isMobile ? 'desktop' : 'mobile'),
                    $this->getToggleText($isMobile)
                );

            // Toggle URL
            case 'toggle_url':
                return ampersand($this->getToggleUrl($isMobile));

            // Toggle text
            case 'toggle_text':
                return $this->getToggleText($isMobile);

            // Toggle title
            case 'toggle_title':
                return $this->getToggleTitle($isMobile);

            // Alternatives
            case 'alternatives':
                $alternatives = trimsplit(':', $chunks[2]);

                return $isMobile ? $alternatives[1] : $alternatives[0];
        }

        return false;
    }

    /**
     * Get the toggle URL
     *
     * @param bool $isMobile
     *
     * @return string
     */
    private function getToggleUrl($isMobile)
    {
        if (($rootPage = PageModel::findByPk($GLOBALS['objPage']->rootId)) !== null && $rootPage->enableMobileDns) {
            $url = preg_replace('@https?://[^/]+@', '', Environment::get('uri'));

            // Add the indicator for JavaScript
            if ($rootPage->mobileDnsAutoRedirect) {
                $url .= '#mobile-toggle';
            }

            return ($rootPage->useSSL ? 'https://' : 'http://') . ($isMobile ? $rootPage->desktopDns : $rootPage->mobileDns) . $url;
        }

        return Url::addQueryString('toggle_view='.($isMobile ? 'desktop' : 'mobile'));
    }

    /**
     * Get the toggle text
     *
     * @param bool $isMobile
     *
     * @return string
     */
    private function getToggleText($isMobile)
    {
        return $isMobile ? $GLOBALS['TL_LANG']['MSC']['toggleDesktop'][0] : $GLOBALS['TL_LANG']['MSC']['toggleMobile'][0];
    }

    /**
     * Get the toggle title
     *
     * @param bool $isMobile
     *
     * @return string
     */
    private function getToggleTitle($isMobile)
    {
        return $isMobile ? $GLOBALS['TL_LANG']['MSC']['toggleDesktop'][1] : $GLOBALS['TL_LANG']['MSC']['toggleMobile'][1];
    }
}
