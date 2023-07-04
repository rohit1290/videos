<?php
require_once __DIR__ . '/vendors/MobileDetect.php';
require_once __DIR__ . '/lib/videos.php';
require_once __DIR__ . '/lib/embed_video.php';
require_once __DIR__ . '/lib/hooks.php';

return [
	'plugin' => [
		'name' => 'Videos',
		'version' => '5.0',
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
		'default:object:videos' => [
			'path' => '/videos/all',
			'resource' => 'videos/all',
		],
		'collection:object:videos:all' => [
			'path' => '/videos/all',
			'resource' => 'videos/all',
		],
		'collection:object:videos:owner' => [
			'path' => '/videos/owner/{username}',
			'resource' => 'videos/owner',
			'middleware' => [
				\Elgg\Router\Middleware\UserPageOwnerGatekeeper::class,
			],
		],
		'collection:object:videos:friends' => [
			'path' => '/videos/friends/{username}',
			'resource' => 'videos/friends',
			'required_plugins' => [
				'friends',
			],
			'middleware' => [
				\Elgg\Router\Middleware\UserPageOwnerGatekeeper::class,
			],
		],
		'collection:object:videos:group' => [
			'path' => '/videos/group/{guid}',
			'resource' => 'videos/group',
			'required_plugins' => [
				'groups',
			],
			'middleware' => [
				\Elgg\Router\Middleware\GroupPageOwnerGatekeeper::class,
			],
		],
		'add:object:videos' => [
			'path' => '/videos/add/{guid}',
			'resource' => 'videos/add',
			'middleware' => [
				\Elgg\Router\Middleware\Gatekeeper::class,
				\Elgg\Router\Middleware\PageOwnerGatekeeper::class,
			],
		],
		'edit:object:videos' => [
			'path' => '/videos/edit/{guid}',
			'resource' => 'videos/edit',
			'middleware' => [
				\Elgg\Router\Middleware\Gatekeeper::class,
			],
		],
		'view:object:videos' => [
			'path' => '/videos/view/{guid}/{title}',
			'resource' => 'videos/view',
		],

		'playlist:object:videos' => [
			'path' => '/videos/playlist/{id}',
			'resource' => 'videos/playlist',
		],
		'read:object:videos' => [
			'path' => '/videos/read/{guid}',
			'resource' => 'videos/view',
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
	],
	'widgets' => [
		'videos' => [
			'context' => ['dashboard', 'profile', 'main', 'index'],
		],
	],
];
