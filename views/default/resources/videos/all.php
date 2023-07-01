<?php
/**
 *      Author : Gerard Kanters
 *      @package Videos
 *      Licence : GNU2
 */

elgg_push_breadcrumb(elgg_echo('videos'), 'videos/featured');

elgg_register_title_button('add', 'object', 'videos');

$offset = (int)get_input('offset', 0);
$content = elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'videos',
	'limit' => 10,
	'offset' => $offset,
	'full_view' => false,
	'view_toggle_type' => false
));

$title = elgg_echo('videos:everyone');

$body = elgg_view_layout('default', array(
	'filter_context' => 'all',
	'content' => $content,
	'title' => $title,
	'filter_override' => elgg_view('videos/nav', array('selected' => elgg_extract('page',$vars))),
	'sidebar' => elgg_view('videos/sidebar'),
));

echo elgg_view_page($title, $body);
