<?php

namespace Derhaeuptling\MobileContent\EventListener;

use Contao\Config;
use Contao\Database;
use Contao\Date;
use Contao\Environment;
use Contao\FrontendTemplate;
use Contao\Input;
use Contao\LayoutModel;
use Contao\PageModel;
use Haste\Util\Debug;

class PageListener
{
    /**
     * Set the mobile layout if the domain is mobile
     *
     * @param PageModel   $page
     * @param LayoutModel &$layout
     */
    public function onGetPageLayout(PageModel $page, LayoutModel &$layout)
    {
        if (($rootPage = PageModel::findByPk($page->rootId)) === null || !$rootPage->enableMobileDns) {
            return;
        }

        $page->isMobile = Environment::get('host') === $rootPage->mobileDns;

        // Set the correct layout if it's not set already
        if ($page->isMobile && $page->mobileLayout && (int) $page->mobileLayout !== (int) $layout->id) {
            $layout = LayoutModel::findByPk($page->mobileLayout);
        } elseif (!$page->isMobile && $page->layout && (int) $page->layout !== (int) $layout->id) {
            $layout = LayoutModel::findByPk($page->layout);
        }

        $this->addSwitchBar($rootPage);
    }

    /**
     * Adds the switch bar to the page
     *
     * @param PageModel $rootPage
     */
    private function addSwitchBar(PageModel $rootPage)
    {
        $url = preg_replace('@https?://[^/]+@', '', Environment::get('uri'));

        $template = new FrontendTemplate('mobile_content');
        $template->desktopUrl = ($rootPage->useSSL ? 'https://' : 'http://') . $rootPage->desktopDns . $url;
        $template->mobileUrl = ($rootPage->useSSL ? 'https://' : 'http://') . $rootPage->mobileDns . $url;

        $GLOBALS['TL_CSS'][] = Debug::uncompressedFile('system/modules/mobilecontent/assets/styles.min.css');
        $GLOBALS['TL_JAVASCRIPT'][] = Debug::uncompressedFile('system/modules/mobilecontent/assets/scripts.min.js');
        $GLOBALS['TL_BODY'][] = $template->parse();
    }

    /**
     * On initialize the system
     */
    public function onInitializeSystem()
    {
        if (TL_MODE !== 'FE' || ($page = $this->getCurrentRootPage()) === null || Environment::get('host') !== $page->mobileDns) {
            return;
        }

        // Override the domain name for mobile pages to avoid 404 error
        $page->desktopDns = $page->dns;
        $page->dns = $page->mobileDns;
    }

    /**
     * Check if there is a mobile domain for this URL
     *
     * @return PageModel|null
     */
    public function onGetRootPageFromUrl()
    {
        return $this->getCurrentRootPage();
    }

    /**
     * Get the current root page
     *
     * @return PageModel|null
     */
    private function getCurrentRootPage()
    {
        // Determine the language
        if (Config::get('addLanguageToUrl') && !empty($_GET['language'])) {
            $language = Input::get('language');
        } else {
            $language = Environment::get('httpAcceptLanguage');

            // Always load the language fall back root if "doNotRedirectEmpty" is enabled
            if (Config::get('addLanguageToUrl') && Config::get('doNotRedirectEmpty')) {
                $language = '-';
            }
        }

        return $this->findRootPage(Environment::get('host'), $language);
    }

    /**
     * Find the root page
     *
     * @param string $host
     * @param string $language
     *
     * @return PageModel|null
     */
    private function findRootPage($host, $language)
    {
        $t  = PageModel::getTable();
        $db = Database::getInstance();

        if (is_array($language)) {
            $columns = ["$t.type='root' AND $t.enableMobileDns=1 AND ($t.mobileDns=? OR $t.mobileDns='')"];

            if (!empty($language)) {
                $columns[] = "($t.language IN('".implode("','", $language)."') OR $t.fallback='1')";
            } else {
                $columns[] = "$t.fallback='1'";
            }

            if (!isset($options['order'])) {
                $options['order'] = "$t.dns DESC".(!empty($language) ? ", ".$db->findInSet("$t.language", array_reverse($language))." DESC" : "").", $t.sorting";
            }

            if (!BE_USER_LOGGED_IN) {
                $time      = Date::floorToMinute();
                $columns[] = "($t.start='' OR $t.start<='$time') AND ($t.stop='' OR $t.stop>'".($time + 60)."') AND $t.published='1'";
            }

            return PageModel::findOneBy($columns, $host, $options);
        } else {
            $columns = ["$t.type='root' AND $t.enableMobileDns=1 AND ($t.mobileDns=? OR $t.mobileDns='') AND ($t.language=? OR $t.fallback='1')"];
            $values  = [$host, $language];

            if (!isset($options['order'])) {
                $options['order'] = "$t.dns DESC, $t.fallback";
            }

            if (!BE_USER_LOGGED_IN) {
                $time      = Date::floorToMinute();
                $columns[] = "($t.start='' OR $t.start<='$time') AND ($t.stop='' OR $t.stop>'".($time + 60)."') AND $t.published='1'";
            }

            return PageModel::findOneBy($columns, $values, $options);
        }
    }
}
