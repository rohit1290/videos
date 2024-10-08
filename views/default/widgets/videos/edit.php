<?php
/**
 * Elgg video widget edit view
 *	@package Elgg-videos
 * 	Plugin info : Upload/ Embed videos. Save uploaded videos in youtube and save your bandwidth and server space
 *	Licence : GNU2
 */

// set default value
if (!isset($vars['entity']->max_display)) {
	$vars['entity']->max_display = 4;
}

echo elgg_view_field([
	'#type' => 'select',
	'name' => 'params[max_display]',
	'value' => $vars['entity']->max_display,
	'options' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10),
	"#label" => elgg_echo('videos:numbertodisplay'),
]);

?>