<?php
$owner = elgg_get_page_owner_entity();

elgg_push_collection_breadcrumbs('object', 'videos', $owner, true);

elgg_register_title_button('add', 'object', 'videos');

$title = elgg_echo('videos:friends');

$content = elgg_list_entities_from_relationship(array(
        'type' => 'object',
        'subtype' => 'videos',
        'full_view' => false,
        'relationship' => 'friend',
        'relationship_guid' => $page_owner->guid,
        'relationship_join_on' => 'container_guid',
        'no_results' => elgg_echo('videos:none'),
        'preload_owners' => true,
));


if (!$content) {
	$content = elgg_echo('videos:none');
}

$params = array(
	'filter_context' => 'friends',
	'content' => $content,
	'filter_override' => elgg_view('videos/nav', array('selected' => $vars['page'])),
	'title' => $title,
);

$body = elgg_view_layout('default', $params);

echo elgg_view_page($title, $body);
