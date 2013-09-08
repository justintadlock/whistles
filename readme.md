## Whistles

This is a tabs, toggle, etc. plugin currently being built as the ultimate tabs plugin.

### The plan:

* Each tab, toggle section, or whatever is considered a "whistle".
* The plugin can display whistles via tab, toggle, etc.
* `whistle` post type. Each whistle is registered as a post.  The whistle content is whatever the users enters into the post editor.
* `whistle_group` taxonomy. Whistles can belong to multiple groups.  We'll use this as a way to create sets of whistles for display on the front end.
* `[whistles group="example" type="tab"]` shortcode for displaying whistles in shortcode areas.
* Whistles widget - option to select the whistle group.

### The reason for doing it this way:

* Allows users to easily manage their whistles with whatever content they want.
* No crazy stuff messing with content filters like we see some themes doing.
* It can be used by any theme.  The theme can dequeue the stylesheet and roll its own.  Its own JavaScript.  Even its own HTML if needed.