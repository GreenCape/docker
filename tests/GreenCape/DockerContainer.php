<?php

namespace GreenCape\DockerTest;

use Docker\Container;
use Docker\Docker;
use Docker\Exception\UnexpectedStatusCodeException;

class DockerContainer
{
	/** @var Docker  */
	private $docker;

	/** @var Container  */
	private $container;

	/**
	 * @param DockerImage $image
	 *
	 * @throws UnexpectedStatusCodeException
	 *
	 */
	public function __construct(DockerImage $image)
	{
		$this->docker = new Docker();

		$this->container = new Container(['Image' => (string) $image]);
		$this->docker->getContainerManager()->create($this->container);
	}

	public function __destruct()
	{
		$this->docker->getContainerManager()->remove($this->container);
	}

	public function start()
	{
		$this->docker->getContainerManager()->start($this->container);
	}

	public function exec($commands)
	{
		if (is_string($commands))
		{
			$commands = explode(';', $commands);
		}

		$containerManager = $this->docker->getContainerManager();

		$contents = '';

		foreach ($commands as $command)
		{
			$commandId = $containerManager->exec($this->container, explode(' ', trim($command)));
			$response  = $containerManager->execstart($commandId);
			$contents .= $response->getBody()->getContents();
		}

		return $contents;
	}

	public function restart()
	{
		$this->docker->getContainerManager()->restart($this->container);
	}

	public function stop()
	{
		$this->docker->getContainerManager()->stop($this->container);
	}
}
