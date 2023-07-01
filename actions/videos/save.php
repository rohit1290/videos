<?php
/**
 *      Author : Gerard Kanters
 *      @package Videos
 *      Licence : GNU2
 */

elgg_gatekeeper();
$title = strip_tags(get_input('title'));
$description = get_input('description');
$access_id = get_input('access_id');
$tags = get_input('tags');
$guid = get_input('guid');
$share = get_input('share');
//set the action type to be embed in GPL Version. This will allow easier upgrade to commercial version
$action_type =  'embed';
$video_url = get_input('video_url');

$video_url = str_replace("feature=player_embedded&amp;", "", $video_url);
$video_url = str_replace("feature=player_detailpage&amp;", "", $video_url);
$video_url = str_replace("http://", "https://", $video_url);
$video_url = str_replace("/v/", "/embed/", $video_url);
$video_url = str_replace("https://youtu.be/", "https://www.youtube.com/embed/", $video_url);

$new = false;
elgg_make_sticky_form('videos');


if (!$title || !$video_url) {
	elgg_error_response(elgg_echo('videos:save:failed'));
	return elgg_redirect_response(REFERRER);
}

if ($guid == 0) {
		$video = new ElggObject;
		$video->setSubtype('videos');
		$video->container_guid = (int)get_input('container_guid', elgg_get_logged_in_user_guid());
		$video->owner_guid = (int)elgg_get_logged_in_user_guid();
		$video->variant = $action_type;
		$new = true;
	} else {
		$video = get_entity($guid);
		if (!$video->canEdit()) {
			elgg_ok_response('', elgg_echo('videos:save:failed'));
			return elgg_redirect_response(REFERRER);
		}
	}
	$tagarray = elgg_string_to_array($tags);
	$video->title = $title;
	$video->description = $description;
	$video->access_id = $access_id;
	$video->tags = $tagarray;
	$video->video_url = $video_url;

if ($video->save()) {
	elgg_clear_sticky_form('videos');
	elgg_ok_response('', elgg_echo('videos:save:success'));
	//add to river only if new
	if ($new) {
		elgg_create_river_item([
     	'view' => 'river/object/videos/create',
      'action_type' => 'create',
     	'subject_guid' => elgg_get_logged_in_user_guid(),
     	'object_guid' => $video->guid,
    ]);
	}
	return elgg_redirect_response($video->getURL());
} else {
	elgg_error_response(elgg_echo('videos:save:failed'));
	return elgg_redirect_response("videos");
}
