<?php
$video_guid = elgg_extract('guid', $vars);
elgg_entity_gatekeeper($video_guid, 'object', 'videos', true);

$video = get_entity($video_guid);

elgg_push_entity_breadcrumbs($video);

$content = elgg_view_form('videos/save', [], videos_prepare_form_vars($video));

echo elgg_view_page(elgg_echo('videos:edit'), [
	'filter' => '',
	'content' => $content,
]);
