<?php

require_once "src/core/database.php";

class SignupModel
{
	use DatabaseConnection;

	protected function sign_user($name, $userid, $password): string
	{
		$encrypted_password = password_hash(zip($password, $userid), PASSWORD_DEFAULT);
		$date = date('m/d/Y h:i:s a', time());
		$token = password_hash(zip("$password$userid", "$date$name"), PASSWORD_DEFAULT);

		$this->query(
			'INSERT INTO user_table
			(username, userid, password, token)
			VALUES (?, ?, ?, ?)',
			[$name, $userid, $encrypted_password, $token]
		);

		return $token;
	}
}
