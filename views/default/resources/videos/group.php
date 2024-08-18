<?php
elgg_group_tool_gatekeeper('videos');

$group = elgg_get_page_owner_entity();

elgg_register_title_button('add', 'object', 'videos');

elgg_push_collection_breadcrumbs('object', 'videos', $group);

$title = elgg_echo('videos:owner', [$group->getDisplayName()]);

$offset = (int)get_input('offset', 0);
$content = elgg_list_entities([
	'type' => 'object',
	'subtype' => 'videos',
	'container_guid' => $group->guid,
	'limit' => 20,
	'offset' => $offset,
	'full_view' => false,
	'view_toggle_type' => false,
	'no_results' => elgg_echo('videos:none'),
]);

echo elgg_view_page($title, [
	'content' => $content,
	'sidebar' => elgg_view('videos/sidebar', [
		'page' => 'group',
		'entity' => $group,
	]),
	'filter_id' => 'videos/group',
	'filter_value' => ($group->guid == elgg_get_logged_in_user_guid()) ? 'mine' : "",
]);