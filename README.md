# Mobile Content (mobilecontent)

Mobile Content Module for Contao 3

This extensions lets you hide specific content elements on mobile or desktop devices.
Additionally it enables some new insert tags:

## Hide Content

This is as easy as it can be. Just activate the wanted checkbox at the content elements edit page and you're done.

## New Insert Tags

### mobile::toggle

Adds a link to toggle between desktop and mobile view. This link carries the classes `mobile_toggle` and `desktop` or 'mobile' corresponding to the destination of the link (not the type of page it is on!).

### mobile::toggle_url

Is replaced by the URL to the currently inactive view mode.

### mobile::toggle_text

Is replaced by the content of the language variable
`$GLOBALS['TL_LANG']['MSC']['toggleDesktop'][0]` or
`$GLOBALS['TL_LANG']['MSC']['toggleMobile'][0]`

This is normally the text of the standard toggle link created by `mobile::toggle`.

### mobile::toggle_title

Is replaced by the content of the language variable
`$GLOBALS['TL_LANG']['MSC']['toggleDesktop'][1]` or
`$GLOBALS['TL_LANG']['MSC']['toggleMobile'][1]`

This is normally the title of the standard toggle link created by ´mobile::toggle´.

### mobile::alternatives::alternative_desktop:alternative_mobile

This insert tags shows only one of the two alternatives `alternative_desktop` or `alternative_mobile` depending on which type of view is currently active.
