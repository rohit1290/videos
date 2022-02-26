<?php
require_once __DIR__ . '/vendors/Mobile_Detect.php';
require_once __DIR__ . '/lib/videos.php';
require_once __DIR__ . '/lib/embed_video.php';
require_once __DIR__ . '/lib/hooks.php';

return [
	'plugin' => [
		'name' => 'Videos',
		'version' => '4.1',
		'dependencies' => [],
	],
	'bootstrap' => Videos::class,
	'entities' => [
		[
			'type' => 'object',
			'subtype' => 'videos',
			'capabilities' => [
				'searchable' => true,
			],
		],
	],
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
		'group_all:object:videos' => [
			'path' => '/videos/group/{guid}/all',
			'resource' => 'videos/owner',
		],
		'group_owner:object:videos' => [
			'path' => '/videos/group/{guid}/owner',
			'resource' => 'videos/owner',
		],
	],
	'widgets' => [
		'videos' => [
			'context' => ['dashboard', 'profile', 'main', 'index'],
		],
	],
];
