<?php
$guid = elgg_extract('guid', $vars);

elgg_entity_gatekeeper($guid, 'object', 'videos');

$video = get_entity($guid);

$page_owner = elgg_get_page_owner_entity();

$crumbs_title = $page_owner->name;

if ($page_owner instanceof ElggGroup) {
	elgg_push_breadcrumb($crumbs_title, "videos/group/$page_owner->guid");
} else {
	elgg_push_breadcrumb($crumbs_title, "videos/owner/$page_owner->username");
}

$title = $video->title;

elgg_push_breadcrumb($title);

$content = elgg_view_entity($video, array('full_view' => true));
$content .= elgg_view_comments($video);

$body = elgg_view_layout('default', array(
	'content' => $content,
	'title' => $title,
	'filter_override' => elgg_view('videos/nav', array('selected' => elgg_extract('page', $vars))),
	'header' => '',
));

echo elgg_view_page($title, $body);
