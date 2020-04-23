<?php

$pusherConfig = [
	'driver' => 'pusher',
	'key' => env('PUSHER_APP_KEY'),
	'secret' => env('PUSHER_APP_SECRET'),
	'app_id' => env('PUSHER_APP_ID'),
	'options' => [
		'cluster' => env('PUSHER_APP_CLUSTER'),
		'encrypted' => true,
		'scheme' => 'http',
		/*'host' => '127.0.0.1',*/
		'host' => env('MIX_BROADCAST_HOST'),
		/*'port' => 443,*/
		/*'port' => 6001,*/
		'port' => (int)env('MIX_BROADCAST_PORT'),
	],
];

$broadcast_is_ssl = filter_var(env('BROADCAST_IS_SSL'), FILTER_VALIDATE_BOOLEAN);
if ($broadcast_is_ssl) {
	$pusherConfig['options']['useTLS'] = true;
	$pusherConfig['options']['scheme'] = 'https';
	$broadcast_is_verify_peer = filter_var(env('BROADCAST_IS_VERIFY_PEER'), FILTER_VALIDATE_BOOLEAN);
	if (!$broadcast_is_verify_peer) {
		$pusherConfig['options']['curl_options'] = [
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_SSL_VERIFYPEER => 0,
		];
	}	
}

return [

    /*
    |--------------------------------------------------------------------------
    | Default Broadcaster
    |--------------------------------------------------------------------------
    |
    | This option controls the default broadcaster that will be used by the
    | framework when an event needs to be broadcast. You may set this to
    | any of the connections defined in the "connections" array below.
    |
    | Supported: "pusher", "redis", "log", "null"
    |
    */

    'default' => env('BROADCAST_DRIVER', 'null'),

    /*
    |--------------------------------------------------------------------------
    | Broadcast Connections
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the broadcast connections that will be used
    | to broadcast events to other systems or over websockets. Samples of
    | each available type of connection are provided inside this array.
    |
    */

    'connections' => [

        'pusher' => $pusherConfig,

        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
        ],

        'log' => [
            'driver' => 'log',
        ],

        'null' => [
            'driver' => 'null',
        ],

    ],

];
