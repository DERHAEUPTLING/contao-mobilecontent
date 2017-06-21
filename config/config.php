<?php 

/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['getPageLayout'][] = ['Derhaeuptling\MobileContent\EventListener\PageListener', 'onGetPageLayout'];
$GLOBALS['TL_HOOKS']['getRootPageFromUrl'][] = ['Derhaeuptling\MobileContent\EventListener\PageListener', 'onGetRootPageFromUrl'];
$GLOBALS['TL_HOOKS']['isVisibleElement'][] = ['Derhaeuptling\MobileContent\EventListener\ElementListener', 'onIsVisibleElement'];
$GLOBALS['TL_HOOKS']['replaceInsertTags'][] = ['Derhaeuptling\MobileContent\EventListener\InsertTagsListener', 'onReplace'];
