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
                $this->updateImage($template->getData(), $template);
            }
        }
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
                $this->updateImage((array) $faq, $faq);
            }
        }
    }

    /**
     * Update the image data
     *
     * @param array  $data
     * @param object $object
     */
    private function updateImage(array $data, $object)
    {
        if (!$data['mobileImage']
            || ($model = FilesModel::findByPk($data['mobileImageSrc'])) === null
            || !is_file(TL_ROOT . '/' . $model->path)
        ) {
            return;
        }

        $data['singleSRC'] = $model->path;
        $size = deserialize($data['mobileImageSize'], true);

        // Set the size only if it was selected
        if ($size[2]) {
            $data['size'] = $size;
        }

        Controller::addImageToTemplate($object, $data);
    }
}
