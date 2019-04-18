<?php

return [
	'actions' => [
		'videos/save' => [],
		'videos/delete' => [],
		'videos/toggle_metadata' => [],
	],
	'routes' => [
		'all:object:videos' => [
			'path' => '/videos/all',
			'resource' => 'videos/all',
		],
		'owner:object:videos' => [
			'path' => '/videos/owner/{username}',
			'resource' => 'videos/owner',
		],
		'friends:object:videos' => [
			'path' => '/videos/friends/{username}',
			'resource' => 'videos/friends',
		],
		'playlist:object:videos' => [
			'path' => '/videos/playlist/{id}',
			'resource' => 'videos/playlist',
		],
		'read:object:videos' => [
			'path' => '/videos/read/{guid}',
			'resource' => 'videos/view',
		],
		'view:object:videos' => [
			'path' => '/videos/view/{guid}/{title}',
			'resource' => 'videos/view',
		],
		'add:object:videos' => [
			'path' => '/videos/add/{guid}',
			'resource' => 'videos/add',
		],
		'edit:object:videos' => [
			'path' => '/videos/edit/{guid}',
			'resource' => 'videos/edit',
		],
		'featured:object:videos' => [
			'path' => '/videos/featured/{guid}',
			'resource' => 'videos/featured',
		],
		'youtube:object:videos' => [
			'path' => '/videos/youtube/{guid}',
			'resource' => 'videos/youtube',
		],
		'mostviewed:object:videos' => [
			'path' => '/videos/mostviewed/{guid}',
			'resource' => 'videos/mostviewed',
		],
		'popular:object:videos' => [
			'path' => '/videos/popular/{guid}',
			'resource' => 'videos/popular',
		],
		'group:object:videos' => [
			'path' => '/videos/group/{guid}/owner',
			'resource' => 'videos/owner',
		],
	],
];
