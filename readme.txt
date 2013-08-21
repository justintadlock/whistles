===Tabs and Jazz===

This is a tabs, accordions, etc. plugin currently being built as the ultimate tabs plugin.

The plan:

* The plugin can display content via tab, accordion, etc.
* `tab` post type. Each tab is registered as a post.  The tab content is whatever the users enters into the post editor.
* `tab_group` taxonomy. Tabs can belong to multiple groups.  We'll use this as a way to create sets of tabs for display on the front end.
* `[tabs group="example" type="tab"]` shortcode for displaying tabs in shortcode areas.
* Tabs widget - option to select the tab group.

The reason for doing it this way:

* Allows users to easily manage their tabs with whatever content they want.
* No crazy stuff messing with content filters like we see some themes doing.
* It can be used by any theme.  The theme can dequeue the stylesheet and roll its own.  Its own JavaScript.  Even its own HTML if needed.