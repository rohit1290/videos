<?php
$page_owner = elgg_get_page_owner_entity();
$max = (int) $vars['entity']->max_display;

if($page_owner->name !== elgg_get_site_entity()->name){
	$options = array(
	        'type' => 'object',
	        'subtype' => 'videos',
        	'container_guid' => $page_owner->guid,
	        'limit' => $max,
       		'full_view' => FALSE,
        	'pagination' => FALSE,
	);
}else{
	$options = array(
	        'type' => 'object',
        	'subtype' => 'videos',
	       	'limit' => $max,
		'metadata_name_value_pairs' => array(
			"name" => "featured",
			"value" => true
			),
        	'full_view' => FALSE,
	);
}

$content = elgg_list_entities($options);

echo $content;
if ($content) {
	$url = "videos/owner/" . elgg_get_page_owner_entity()->username;
	$more_link = elgg_view('output/url', array(
		'href' => $url,
		'text' => elgg_echo('videos:more'),
	));
	echo "<span class=\"elgg-widget-more\">$more_link</span>";
} else {
	echo elgg_echo('videos:none');
}
