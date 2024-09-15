<?php

echo elgg_view_field([
	'#type' => 'select',
  'name' => 'params[youtube]',
  'options_values'=> array( '0' => '  ', '1'=>'Yes','2'=>'No'),
  'value'=> $vars['entity']->youtube,
  '#label' => elgg_echo('youtube:question1'),
]);

echo elgg_view_field([
  '#type' => 'text',
  'name'=>'params[search_contexts]',
  'value'=> $vars['entity']->search_contexts,
  '#label' => elgg_echo('youtube:question2'),
]);

echo elgg_view_field([
  '#type' => 'text',
  'name'=>'params[developer_key]',
  'value'=> $vars['entity']->developer_key,
  '#label' => elgg_echo('youtube:question3'),
]);

echo elgg_view_field([
	'#type' => 'text',
  'name'=>'params[client_id]',
  'value'=> $vars['entity']->client_id,
  '#label' => elgg_echo('youtube:question4'),
]);

echo elgg_view_field([
	'#type' => 'text',
  'name'=>'params[client_secret]',
  'value'=> $vars['entity']->client_secret,
  '#label' => elgg_echo('youtube:question5'),
]);

echo elgg_view_field([
	'#type' => 'text',
  'name'=>'params[video_width_river]',
  'value'=> $vars['entity']->video_width_river,
  '#label' => elgg_echo('youtube:question6'),
]);

echo elgg_view_field([
	'#type' => 'text',
  'name'=>'params[video_width_summary]',
  'value'=> $vars['entity']->video_width_summary,
  '#label' => elgg_echo('youtube:question7'),
]);

echo elgg_view_field([
	'#type' => 'text',
  'name'=>'params[video_width_full]',
  'value'=> $vars['entity']->video_width_full,
  '#label' => elgg_echo('youtube:question8'),
]);

echo elgg_view_field([
	'#type' => 'text',
  'name'=>'params[video_width_full_mob]',
  'value'=> $vars['entity']->video_width_full_mob,
  '#label' => elgg_echo('youtube:question9'),
]);