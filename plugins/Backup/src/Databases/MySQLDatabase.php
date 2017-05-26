<?php

namespace Backup\Databases;

use Mini\Support\Facades\Config;

use Backup\Console;


class MySQLDatabase implements DatabaseInterface
{
	protected $console;
	protected $database;
	protected $user;
	protected $password;
	protected $host;
	protected $port;

	public function __construct(Console $console, $database, $user, $password, $host, $port)
	{
		$this->console  = $console;
		$this->database = $database;
		$this->user	 = $user;
		$this->password = $password;
		$this->host	 = $host;
		$this->port	 = $port;
	}

	public function dump($destinationFile)
	{
		$command = sprintf('%s --user=%s --password=%s --host=%s --port=%s %s > %s',
			$this->getDumpCommandPath(),
			escapeshellarg($this->user),
			escapeshellarg($this->password),
			escapeshellarg($this->host),
			escapeshellarg($this->port),
			escapeshellarg($this->database),
			escapeshellarg($destinationFile)
		);

		return $this->console->run($command);
	}

	public function restore($sourceFile)
	{
		$command = sprintf('% --user=%s --password=%s --host=%s --port=%s %s < %s',
			$this->getRestoreCommandPath(),
			escapeshellarg($this->user),
			escapeshellarg($this->password),
			escapeshellarg($this->host),
			escapeshellarg($this->port),
			escapeshellarg($this->database),
			escapeshellarg($sourceFile)
		);

		return $this->console->run($command);
	}

	public function getDatabase()
	{
		return $this->database;
	}

	public function getFileExtension()
	{
		return 'sql';
	}

	protected function getDumpCommandPath()
	{
		return Config::get('backup::config.mysql.dumpCommandPath');
	}

	protected function getRestoreCommandPath()
	{
		return Config::get('backup::config.mysql.restoreCommandPath');
	}
}
