<?php
$user = elgg_get_page_owner_entity();

elgg_push_collection_breadcrumbs('object', 'videos', $user);

elgg_register_title_button('add', 'object', 'videos');

$title = elgg_echo('videos:owner', [$user->getDisplayName()]);

$offset = (int)get_input('offset', 0);
$content = elgg_list_entities([
	'type' => 'object',
	'subtype' => 'videos',
	'container_guid' => $user->guid,
	'limit' => 20,
	'offset' => $offset,
	'full_view' => false,
	'view_toggle_type' => false,
	'no_results' => elgg_echo('videos:none'),
]);

$filter_context = '';
if ($user->guid == elgg_get_logged_in_user_guid()) {
	$filter_context = 'mine';
}

$vars = array(
	'filter_context' => $filter_context,
	'content' => $content,
	'title' => $title,
	'filter_override' => elgg_view('videos/nav'),
	'sidebar' => elgg_view('videos/sidebar'),
);

// don't show filter if out of filter context
if ($user instanceof ElggGroup) {
	$vars['filter'] = false;
}

$body = elgg_view_layout('default', $vars);

echo elgg_view_page($title, $body);
