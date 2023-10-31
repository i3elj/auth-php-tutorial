<?php

/**
 * Let's create a function that merges two strings together, it will be our
 * special salt technique!
 *
 * Example:
 * ```
 * zip("no", "yes") // outputs: nyoes
 * zip("harry", "potter") // outputs: hpaortrtyer
 * ```
 */
function zip(string $str1, string $str2)
{
	$result = "";
	for ($i = 0; $i < strlen($str1) + strlen($str2); $i++) {
		if ($i < strlen($str1)) $result .= $str1[$i];
		if ($i < strlen($str2)) $result .= $str2[$i];
	}
	return $result;
}

/**
 * dump and die :)
 */
function dd(...$args)
{
	echo "<pre style='font-family: monospace'>";
	var_dump($args);
	echo "</pre>";
	die();
}
