<?php
$guid = (int) elgg_extract('guid', $vars);
elgg_entity_gatekeeper($guid, 'object', 'videos');
$entity = get_entity($guid);

elgg_push_entity_breadcrumbs($entity);

echo elgg_view_page("", [
	'content' => elgg_view_entity($entity),
	'entity' => $entity,
	'filter_id' => 'videos/view',
]);