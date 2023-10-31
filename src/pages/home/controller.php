<?php

require_once "src/core/auth.php";

class HomeController
{
	use Authenticator; // the key point is to use the trait inside the class

	private function build_view()
	{
		require_once "src/pages/home/view.php";
		exit(0);
	}

	private function login()
	{
		$userid = $_POST['userid'];
		$password = $_POST['password'];

		if (!$this->check_if_user_exists($userid)) {
			echo 'User doesn\'t exist!';
			exit(0);
		}

		if (!$this->check_password($userid, $password)) {
			echo 'Wrong password!';
			exit(0);
		}

		$token = $this->log_user($userid, $password);
		$response = json_encode([
			'success' => true,
			'token' => $token,
			'userid' => $userid
		]);
		header("HX-Trigger: {\"login\": $response}");
		exit(0);
	}

	public function handler()
	{
		match ($_SERVER['REQUEST_METHOD']) {
			'GET' => $this->build_view(),
			'POST' => $this->login(),
			default => http_response_code(400) // bad request :)
		};
	}
}

$home = new HomeController();
$home->handler();
