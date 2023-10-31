<?php

trait DatabaseConnection
{
	private function connect()
	{
		$pdo = new \PDO("sqlite:database.sql");
		$pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
		$pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);

		return $pdo;
	}

	/**
	 * It's a wrapper function to realize queries without worrying if it
	 * will fail or not
	 *
	 * @param string $query_string
	 * @param array $values
	 */
	protected function query($query_string, $values = []): void
	{
		$statement = $this->connect()->prepare($query_string);
		$succeeded = $statement->execute($values);

		if (!$succeeded) {
			printf("Prepare statement error: $statement");
			$statement = null;
			exit(1);
		}
	}

	/**
	 * It's a wrapper function to realize queries without worrying if it
	 * will fail or not. It returns the result of the query.
	 *
	 * @param string $query_string
	 * @param array $values
	 */
	protected function query_return($query_string, $values = []): array
	{
		$statement = $this->connect()->prepare($query_string);
		$succeeded = $statement->execute($values);

		if (!$succeeded) {
			printf("Prepare statement error: $statement");
			$statement = null;
			exit(1);
		}

		return $statement->fetchAll();
	}
}
