<?php defined('SYSPATH') or die('No direct script access.');

return array
(
	'memcache' => array(
		'driver'             => 'memcache',
		'default_expire'     => 3600,
		'compression'        => TRUE,              // Use Zlib compression (can cause issues with integers)
		'servers'            => array(
			'local' => array(
				'host'             => 'localhost',  // Memcache Server
				'port'             => 11211,        // Memcache port number
				'persistent'       => TRUE,        // Persistent connection
				'weight'           => 1,
				'timeout'          => 1,
				'retry_interval'   => 15,
				'status'           => TRUE,
			),
		),
		'instant_death'      => TRUE,               // Take server offline immediately on first fail (no retry)
	),
);
