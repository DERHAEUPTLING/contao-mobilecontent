<?php 

/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['isVisibleElement'][] = ['Derhaeuptling\MobileContent\EventListener\ElementListener', 'onIsVisibleElement'];
$GLOBALS['TL_HOOKS']['replaceInsertTags'][] = ['Derhaeuptling\MobileContent\EventListener\InsertTagsListener', 'onReplace'];
