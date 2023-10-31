<?php

require_once "src/lib/utils.php";

$path = parse_url($_SERVER['REQUEST_URI'])['path'];

match ($path) {
	'/' => require_once "src/pages/home/controller.php",
	'/signup' => require_once "src/pages/signup/controller.php",
	'/restricted' => require_once "src/pages/restricted/controller.php",
	default => http_response_code(404), // not found
};
