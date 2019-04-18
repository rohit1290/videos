<?php
/**
 * New videos river entry
 *	Licence : GNU2
 */

$item = elgg_extract('item', $vars);
if (!$item instanceof ElggRiverItem) {
	return;
}

$object = $item->getObjectEntity();
$excerpt = 

$video_url = $object->video_url;
$video_url = str_replace("feature=player_embedded&amp;", "", $video_url);
$video_url = str_replace("feature=player_detailpage&amp;", "", $video_url);
$video_url = str_replace("http://youtu.be","https://www.youtube.be",$video_url);

$guid = $object->guid;


$vars['message'] = elgg_get_excerpt($object->description);
$vars['attachments'] = videoembed_create_embed_object($video_url, $guid,130);

echo elgg_view('river/elements/layout', $vars);
