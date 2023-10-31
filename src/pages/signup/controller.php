<?php

require_once "src/core/auth.php";
require_once "src/pages/signup/model.php";

class SignupController extends SignupModel
{
	use Authenticator;

	private function build_view()
	{
		require_once "src/pages/signup/view.php";
		exit(0);
	}

	private function signup()
	{
		$name = $_POST['name'];
		$userid = $_POST['userid'];
		$password = $_POST['password'];
		$user_exists = $this->check_if_user_exists($userid);

		if ($user_exists) {
			echo 'User already exists!';
			exit(0);
		}

		$token = $this->sign_user($name, $userid, $password);
		$response = json_encode([
			'success' => true,
			'token' => $token,
			'userid' => $userid,
		]);
		header("HX-Trigger: {\"signup\": $response}");
		exit(0);
	}

	public function handle()
	{
		match ($_SERVER['REQUEST_METHOD']) {
			'GET' => $this->build_view(),
			'POST' => $this->signup(),
			default => null,
		};
	}
}

$signup = new SignupController();
$signup->handle();
