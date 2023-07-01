<?php
/**
 *      Author : Gerard Kanters
 *      @package Videos
 *      Licence : GNU2
 */

$guid = get_input('guid');
$video = get_entity($guid);

if ($video->getSubtype === 'videos' && $video->canEdit()) {
	$container = $video->getContainerEntity();
	if ($video->delete()) {
		elgg_ok_response('', elgg_echo("videos:delete:success"));
		if ($container instanceof ElggGroup) {
			return elgg_redirect_response("videos/group/$container->guid/owner");
		} else {
			return elgg_redirect_response("videos/owner/$container->username");
		}
	}
}

elgg_error_response(elgg_echo("videos:delete:failed"));
return elgg_redirect_response(REFERRER);
