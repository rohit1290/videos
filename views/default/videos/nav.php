<?php
/**
 * Videos navigation
 */
if(!elgg_is_logged_in()){
$tabs = array(
         'all' => array(
                'text' => elgg_echo('all'),
                'href' => "videos/all",
         ),
         'featured' => array(
                'text' => elgg_echo('videos:featured'),
                'href' => "videos/featured",
         ),
         'mostviewed' => array(
                'text' => elgg_echo('videos:mostviewed'),
                'href' => "videos/mostviewed",
         ),
         'playlist' => array(
                'text' => elgg_echo('youtube:playlist:tab'),
                'href' => "videos/playlist",
         ),
   );

}else{

$user = elgg_get_logged_in_user_entity();

$tabs = array(
         'all' => array(
                'text' => elgg_echo('all'),
                'href' => "videos/all",
         ),
	'mine' => array(
                'text' => elgg_echo('mine'),
                'href' => "videos/owner/{$user->username}",
                ),
	'friends'  => array(
                'text' => elgg_echo('friends'),
                'href' => "videos/friends/{$user->username}",
                ),
        'featured' => array(
                'text' => elgg_echo('videos:featured'),
                'href' => "videos/featured",
         ),
         'mostviewed' => array(
                'text' => elgg_echo('videos:mostviewed'),
                'href' => "videos/mostviewed",
         ),
         'playlist' => array(
                'text' => elgg_echo('youtube:playlist:tab'),
                'href' => "videos/playlist",
         ),
   );
}

echo elgg_view('navigation/tabs', array('tabs' => $tabs));
