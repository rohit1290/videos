<?php 

use Elgg\DefaultPluginBootstrap;

class Videos extends DefaultPluginBootstrap {
	
	/**
	 * {@inheritDoc}
	 * @see \Elgg\DefaultPluginBootstrap::init()
	 */
	public function init() {
    // add a site navigation item
    $options = array(
      "name" => "videos",
      "text" => elgg_echo('videos'),
      "href" => elgg_get_site_url() . 'videos/all',
      "icon" => 'video-camera'
    );
    $item = ElggMenuItem::factory($options);
    elgg_register_menu_item('site', $item);

  	// require_once __DIR__ . '/lib/youtube_functions.php';

  	//extend owner block menu
  	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'videos_owner_block_menu');

  	//Add menu's in sidebar
  	elgg_register_plugin_hook_handler('register', 'menu:page', 'videos_page_menu');

  	$context =  elgg_get_context();
  	$contexts = elgg_get_plugin_setting('search_contexts','videos');
  	$contexts = explode(",", $contexts);

    if(in_array($context, $contexts))  {
      elgg_extend_view('page/elements/sidebar', 'page/elements/search','400');
    }

  	// get items in video menu
    elgg_register_plugin_hook_handler("register", "menu:entity", "videos_entity_menu_setup");

  	elgg_extend_view('css/elgg', 'videos/css');

  	if (function_exists('elgg_get_release')) {
      elgg_register_notification_event('object', 'videos');
    } else {
      elgg_register_notification_event('object', 'videos', array('create'));
    }

  	elgg_register_plugin_hook_handler('notify:entity:message', 'object', 'videos_notify_message');

    // Register a URL handler for video posts
  	elgg_register_plugin_hook_handler('entity:url', 'object', 'videos_url_handler');

  	elgg_register_entity_type('object', 'videos');

    elgg()->group_tools->register('videos', [
  		'default_on' => true,
  		'label' => elgg_echo('videos:enablevideos'),
  	]);

    $views = array('output/longtext','output/plaintext');
  	foreach($views as $view){
  		elgg_register_plugin_hook_handler("view", $view, "videos_view_filter", 500);
  	}
  }
	
	public function activate() {
    if(elgg_get_plugin_setting('video_width_river', 'videos') == null){
			elgg_get_plugin_from_id('videos')->setSetting('video_width_river', '70');
    }
    if(elgg_get_plugin_setting('video_width_summary', 'videos') == null){
			elgg_get_plugin_from_id('videos')->setSetting('video_width_summary', '130');
    }
    if(elgg_get_plugin_setting('video_width_full', 'videos') == null){
			elgg_get_plugin_from_id('videos')->setSetting('video_width_full', '450');
    }
    if(elgg_get_plugin_setting('video_width_full_mob', 'videos') == null){
			elgg_get_plugin_from_id('videos')->setSetting('video_width_full_mob', '280');
    }
  }

}
 ?>