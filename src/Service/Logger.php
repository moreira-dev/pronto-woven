<?php

namespace ProntoWoven\Service;

class Logger
{
	private static bool $initialized = false;

	public static function reset(): void
	{
		if (!defined('LOG_FILE')) {
			return;
		}

		$directory = dirname(LOG_FILE);
		if (!is_dir($directory) && !mkdir($directory, 0777, true) && !is_dir($directory)) {
			throw new \RuntimeException("Failed to create log directory: $directory");
		}

		if (file_put_contents(LOG_FILE, '', LOCK_EX) === false) {
			throw new \RuntimeException('Failed to reset debug log: ' . LOG_FILE);
		}

		self::$initialized = true;
	}

	public static function log(string $message): void
	{
		if (!defined('LOG_FILE')) {
			return;
		}

		if (!self::$initialized) {
			self::reset();
		}

		if (file_put_contents(LOG_FILE, $message, FILE_APPEND | LOCK_EX) === false) {
			throw new \RuntimeException('Failed to write debug log: ' . LOG_FILE);
		}
	}
}
