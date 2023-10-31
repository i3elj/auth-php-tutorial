<?php

require_once "src/core/auth.php";

class RestrictedPageController
{
	use Authenticator;

	private function build_view()
	{
		$token = $_COOKIE['token'];
		$userid = $_COOKIE['userid'];
		$is_logged = $this->is_authenticated($userid, $token);
		require_once "src/pages/restricted/view.php";
		exit(0);
	}

	public function handle()
	{
		match ($_SERVER['REQUEST_METHOD']) {
			'GET' => $this->build_view(),
			default => http_response_code(400),
		};
	}
}

$restricted = new RestrictedPageController();
$restricted->handle();
