<?php
/**
 * Process the Elgg views for a matching video URL
*/
function videos_view_filter(\Elgg\Event $event) {

  $returnvalue = $event->getValue();
	$patterns = array(	'/(((https?:\/\/)?)|(^.\/))(((www.)?)|(^.\/))youtube\.com\/watch[?]v=([^\[\]()<.,\s\n\t\r]+)/i',
						'/(((https?:\/\/)?)|(^.\/))(((www.)?)|(^.\/))youtu\.be\/([^\[\]()<.,\s\n\t\r]+)/i',
						'/(https?:\/\/)(www\.)?(vimeo\.com\/groups)(.*)(\/videos\/)([0-9]*)/i',
						'/(https?:\/\/)(www\.)?(vimeo.com\/)([0-9]*)/i',
						'/(https?:\/\/)(www\.)?(metacafe\.com\/watch\/)([0-9a-zA-Z_-]*)(\/[0-9a-zA-Z_-]*)(\/)/i',
						'/(https?:\/\/www\.dailymotion\.com\/.*\/)([0-9a-z]*)/i',
						);
	$regex = "/<a[\s]+[^>]*?href[\s]?=[\s\"\']+"."(.*?)[\"\']+.*?>"."([^<]+|.*?)?<\/a>/";
	if(preg_match_all($regex, $returnvalue, $matches, PREG_SET_ORDER)){
 		foreach($matches as $match){
			foreach ($patterns as $pattern){
				if (preg_match($pattern, strip_tags($match[2])) > 0){
					$returnvalue = str_replace($match[0], videoembed_create_embed_object(strip_tags($match[2]), uniqid('videos_embed_'), 350), $returnvalue);
				}
			}
		}
	}
	return $returnvalue;
}

/**
 * Override the videos url
 *
 * @param ElggObject $entity Page object
 * @return string
 */
function videos_url_handler(\Elgg\Event $event) {
    
	$entity = $event->getEntityParam();

        if ($entity->getSubtype != 'videos') {
                return;
        }

	$title = elgg_get_friendly_title($entity->title);
	return "videos/view/$entity->guid/$title";
}

/**
 * Add a menu item to an ownerblock
 */
function videos_owner_block_menu(\Elgg\Event $event) {

  $return = $event->getValue();
  $params = $event->getParams();
  $entity = elgg_extract('entity', $params);
  
	if ($entity instanceof ElggUser) {
		$url = "videos/owner/{$entity->username}";
		$return[] = new ElggMenuItem('videos', elgg_echo('videos'), $url);
	} else if ($entity instanceof ElggGroup) {
		if ($entity->videos_enable != 'no') {
			$url = "videos/group/{$params['entity']->guid}";
			$return[] = new ElggMenuItem('videos', elgg_echo('videos:group'), $url);
		}
	}
	return $return;
}

/**
 * Returns the body of a notification message
 */
function videos_notify_message(\Elgg\Event $event) {

  $params = $event->getParams();

	$entity = $event->getEntityParam();
	$to_entity = $params['to_entity'];
	$method = $params['method'];
	if (($entity instanceof ElggEntity) && ($entity->getSubtype() == 'videos')) {
		$descr = $entity->description;
		$title = $entity->title;
		global $CONFIG;
		$url = elgg_get_site_url() . "view/" . $entity->guid;
		if ($method == 'sms') {
			$owner = $entity->getOwnerEntity();
			return $owner->name . ' ' . elgg_echo("videos:via") . ': ' . $url . ' (' . $title . ')';
		}
		if ($method == 'email') {
			$owner = $entity->getOwnerEntity();
			return $owner->name . ' ' . elgg_echo("videos:via") . ': ' . $title . "\n\n" . $descr . "\n\n" . $entity->getURL();
		}
		if ($method == 'web') {
			$owner = $entity->getOwnerEntity();
			return $owner->name . ' ' . elgg_echo("videos:via") . ': ' . $title . "\n\n" . $descr . "\n\n" . $entity->getURL();
		}
	}
	return null;
}

function videos_page_menu(\Elgg\Event $event) {

  $return = $event->getValue();
        // only show buttons in videos pages. Changed to videos1 to remove all menus
        //if (elgg_in_context('videos')) {
        if (elgg_in_context('videos')) {
             if (elgg_is_logged_in()) {
                        $user = elgg_get_logged_in_user_entity();
                        $page_owner = elgg_get_page_owner_entity();
                        if (!$page_owner) {
                                $page_owner = elgg_get_logged_in_user_entity();
                        }

                        if ($page_owner != $user) {
                                $usertitle = elgg_echo('videos:user', array($page_owner->name));
                                $return[] = new ElggMenuItem('1user', $usertitle, 'videos/owner/' . $page_owner->username);
                                $friendstitle = elgg_echo('videos:friends', array($page_owner->name));
                                $return[] = new ElggMenuItem('2userfriends', $friendstitle, 'videos/friends/' . $page_owner->username);
                        }

                        $return[] = new ElggMenuItem('1mostviewed', elgg_echo('videos:mostviewed'), 'videos/mostviewed');
                        $return[] = new ElggMenuItem('2featured', elgg_echo('videos:featured'), 'videos/featured');
                        $return[] = new ElggMenuItem('3mine', elgg_echo('videos:mine'), 'videos/owner/' . $user->username);
                        $return[] = new ElggMenuItem('4friends', elgg_echo('videos:friends'), 'videos/friends/' . $user->username);
                 	$return[] = new ElggMenuItem('5all', elgg_echo('videos:everyone'), 'videos/all');

                  }else{
		//$return[] = new ElggMenuItem('1mostviewed', elgg_echo('videos:mostviewed'), 'videos/mostviewed');
                //$return[] = new ElggMenuItem('2featured', elgg_echo('videos:featured'), 'videos/featured');
            }
        return $return;
        }
}

function videos_entity_menu_setup(\Elgg\Event $event) {

  $result = $event->getValue();

	if (elgg_in_context("widgets")) {
    return $result;
  }
  
  $entity = $event->getEntityParam();

  if($entity->getSubtype === "videos") {
     if(elgg_is_admin_logged_in()){
       // feature link
       if(!empty($entity->featured)){
          $text = elgg_echo("videos:toggle:unfeature");
       } else {
          $text = elgg_echo("videos:toggle:feature");
       }

       $options = array(
          "name" => "featured",
          "text" => $text,
          "href" => elgg_get_site_url() . "action/videos/toggle_metadata?guid=" . $entity->guid . "&metadata=featured",
          "is_action" => true,
          "priority" => 175,
          "icon" => 'star'
       );
       $result[] = ElggMenuItem::factory($options);
     }
    }

   return $result;
}