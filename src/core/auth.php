<?php

require_once "src/core/database.php";

trait Authenticator
{
	use DatabaseConnection;

	/**
	 * Check if the user exists in the database
	 *
	 * @param string $userid
	 */
	protected function check_if_user_exists($userid): bool
	{
		$rows = $this->query_return(
			'SELECT 1 FROM user_table WHERE userid = ?;',
			[$userid]
		);

		return sizeof($rows) == 1;
	}

	/**
	 * Check if the password matches the one associated with a certain user
	 *
	 * @param string $userid
	 * @param string $password
	 */
	protected function check_password($userid, $password): bool
	{
		$rows = $this->query_return(
			'SELECT password FROM user_table WHERE userid = ?;',
			[$userid]
		);

		if (sizeof($rows) != 1) return false;

		$db_password = $rows[0]['password'];
		return password_verify(zip($password, $userid), $db_password);
	}

	/**
	 * Use both user id and password to generate an authentication token
	 * that can be used for loging in.
	 *
	 * @param string $userid
	 * @param string $password
	 */
	protected function log_user($userid, $password): string
	{
		$rows = $this->query_return(
			'SELECT username, password
			FROM user_table
			WHERE userid = ?;',
			[$userid]
		);

		$username = $rows[0]['username'];
		return $this->update_token($userid, $username, $password);
	}

	/**
	 * Check if the user id and token, the client sent here, is correct
	 * if it is, the user is currently authenticated and can access
	 * restricted areas.
	 *
	 * @param string $userid
	 * @param string $token
	 */
	protected function is_authenticated($userid, $token): bool
	{
		$rows = $this->query_return(
			'SELECT * FROM user_table
			WHERE userid = ? AND token = ?;',
			[$userid, $token]
		);
		return sizeof($rows) > 0;
	}

	/**
	 * Updates the user's token. This is needed cause if he used the same
	 * token forever, it will come a day where it might get leaked, so we
	 * update it every time the user logs in.
	 *
	 * @param string $userid
	 * @param string $username
	 * @param string $password
	 */
	private function update_token($userid, $username, $password): string
	{
		$date = date('m/d/Y h:i:s a', time());
		$new_token = password_hash(
			zip("$password$userid", "$date$username"),
			PASSWORD_DEFAULT
		);

		$this->query(
			'UPDATE user_table
			SET token = ?
			WHERE userid = ?;',
			[$new_token, $userid]
		);

		return $new_token;
	}
}
