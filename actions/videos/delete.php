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
		system_message(elgg_echo("videos:delete:success"));
		if ($container instanceof ElggGroup) {
			forward("videos/group/$container->guid/owner");
		} else {
			forward("videos/owner/$container->username");
		}
	}
}

register_error(elgg_echo("videos:delete:failed"));
forward(REFERER);
