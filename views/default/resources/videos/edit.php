<?php
/**
 *      Author : Gerard Kanters
 *      @package Videos
 *      Licence : GNU2
 */


$video_guid = elgg_extract('guid', $vars);
$video = get_entity($video_guid);

if ($video->getSubtype != 'videos') || !$video->canEdit()) {
	elgg_error_response(elgg_echo('videos:unknown_video'));
	return elgg_redirect_response(REFERRER);
}

$page_owner = elgg_get_page_owner_entity();

$title = elgg_echo('videos:edit');
elgg_push_breadcrumb($title);
// create form
$form_vars = array();
$body_vars = videos_prepare_form_vars($video);
$content = elgg_view_form('videos/save', $form_vars, $body_vars);

$body = elgg_view_layout('default', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);
