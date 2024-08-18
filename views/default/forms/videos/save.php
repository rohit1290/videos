<?php
// once elgg_view stops throwing all sorts of junk into $vars, we can use extract()
$title = elgg_extract('title', $vars, '');
$desc = elgg_extract('description', $vars, '');
$tags = elgg_extract('tags', $vars, '');
$video_url =  elgg_extract('video_url', $vars, '');
$access_id = elgg_extract('access_id', $vars, ACCESS_DEFAULT);
$container_guid = elgg_extract('container_guid', $vars);
$guid = elgg_extract('guid', $vars, null);

echo elgg_view_field([
   '#type' => 'text',
   '#label' => elgg_echo('title'),
   'required' => true,
   'name' => 'title',
   'value' => $title,
]);
echo elgg_view_field([
   '#type' => 'text',
   '#label' => elgg_echo('videos:embedurl'),
   'required' => true,
   'name' => 'video_url',
   'value' => $video_url,
]);
echo elgg_view_field([
   '#type' => 'longtext',
   '#label' => elgg_echo('description'),
   'name' => 'description',
   'value' => $desc,
]);
echo elgg_view_field([
   '#type' => 'tags',
   '#label' => elgg_echo('tags'),
   'name' => 'tags',
   'value' => $tags,
]);

$categories = elgg_view('input/categories', $vars);
if ($categories) {
	echo $categories;
}

echo elgg_view_field([
   '#type' => 'access',
   '#label' => elgg_echo('access'),
   'name' => 'access_id',
   'value' => $access_id,
]);

echo elgg_view_field([
   '#type' => 'hidden',
   'name' => 'container_guid',
   'value' => $container_guid,
]);
if ($guid) {
	echo elgg_view_field([
	   '#type' => 'hidden',
	   'name' => 'guid',
	   'value' => $guid,
	]);
}
echo elgg_view_field([
	'#type' => 'submit',
	'text' => elgg_echo("save"),
]);


?>