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

use Contao\Controller;
use Contao\FilesModel;
use Contao\FrontendTemplate;
use Contao\Template;

class TemplateListener
{
    /**
     * On parse the template
     *
     * @param Template $template
     */
    public function onParse(Template $template)
    {
        if ($template instanceof FrontendTemplate && $GLOBALS['objPage']->isMobile) {
            // Handle the FAQ page module template
            if (strpos($template->getName(), 'mod_faqpage') === 0) {
                $this->handleFaqPage($template);
            } else {
                // Handle the regular template
                $this->handleRegular($template);
            }
        }
    }

    /**
     * Handle the regular template
     *
     * @param Template $template
     */
    private function handleRegular(Template $template)
    {
        if (!$template->mobileImage
            || ($model = FilesModel::findByPk($template->mobileImageSrc)) === null
            || !is_file(TL_ROOT . '/' . $model->path)
        ) {
            return;
        }

        $data = $template->getData();
        $data['singleSRC'] = $model->path;
        $data['size'] = $data['mobileImageSize'];

        Controller::addImageToTemplate($template, $data);
    }

    /**
     * Handle the FAQ page module template
     *
     * @param Template $template
     */
    private function handleFaqPage(Template $template)
    {
        if (!$template->faq) {
            return;
        }

        foreach ($template->faq as $category) {
            foreach ($category['items'] as $faq) {
                // Continue if the mobile image is not selected or does not exist
                if (!$faq->mobileImage
                    || ($model = FilesModel::findByPk($faq->mobileImageSrc)) === null
                    || !is_file(TL_ROOT . '/' . $model->path)
                ) {
                    continue;
                }

                $data = (array) $faq;
                $data['singleSRC'] = $model->path;
                $data['size'] = $data['mobileImageSize'];

                Controller::addImageToTemplate($faq, $data);
            }
        }
    }
}
