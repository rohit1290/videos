<?php
elgg_push_breadcrumb(elgg_echo('videos:featured'));

elgg_register_title_button('add', 'object', 'videos');

$offset = (int)get_input('offset', 0);
$options = array(
                                'type' => 'object',
                                'subtype' => 'videos',
                                'full_view' => FALSE,
                                'metadata_name_value_pairs' => array(
                                	"name" => "featured",
                                        "value" => true
                                ),
                        );
$content = elgg_list_entities($options);

$title = elgg_echo('videos:featured');

$body = elgg_view_layout('default', array(
	'filter_context' => 'Featured',
	'content' => $content,
	'title' => $title,
	'filter_override' => elgg_view('videos/nav', array('selected' => $vars['page'])),
	'sidebar' => elgg_view('videos/sidebar'),
));

echo elgg_view_page($title, $body);
