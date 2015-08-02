<?php

namespace GreenCape\DockerTest;

class DockerContainer
{
	/** @var DockerImage  */
	private $image;

	/** @var string  */
	private $name;

	/** @var string */
	private $id = null;

	use ShellAdapter;

	/**
	 * @param DockerImage                 $image
	 * @param null                        $name
	 */
	public function __construct(DockerImage $image, $name = null)
	{
		if (empty($name))
		{
			$name = preg_replace('~\W+~', '_', (string) $image);
		}
		$this->name = $name;
		$this->image = $image;
	}

	public function create(array $env = array())
	{
		$environment = $this->buildEnvOptions($env);
		$response = $this->shell("docker create --name=" . $this->name . " " . $environment . (string)$this->image);
		$this->id = $response['result'];

		return $this;
	}

	public function runAsDaemon(array $env = array())
	{
		$environment = $this->buildEnvOptions($env);
		$response    = $this->shell("docker run -d --name=" . $this->name . " " . $environment . (string)$this->image);
		$this->id    = $response['result'];

		return $this;
	}

	public function run($command, array $env = array())
	{
		$environment = $this->buildEnvOptions($env);
		$response    = $this->shell("docker run --rm " . $environment . $this->image . " /bin/bash -c \"" . $command . "\"");

		return $response;
	}

	public function exec($command)
	{
		$response = $this->shell("docker exec " . $this->name . " " . $command);

		return $response;
	}

	public function remove()
	{
		$this->shell("docker rm --force " . $this->name);

		return $this;
	}

	public function start()
	{
		$this->shell("docker start " . $this->name);

		return $this;
	}

	public function stop()
	{
		$this->shell("docker stop " . $this->name);

		return $this;
	}

	public function inspect()
	{
		$response = $this->shell("docker inspect " . $this->name);

		$config = json_decode(implode("\n", $response['output']), true);

		return array_shift($config);
	}

	public function logs()
	{
		$response = $this->shell("docker logs " . $this->name);

		return $response;
	}

	/**
	 * @return bool
	 */
	public function exists()
	{
		$response = $this->shell("docker ps -a | grep " . $this->name);
		$pattern  = '^(\w+)\s+' . preg_quote($this->image);
		foreach ($response['output'] as $line)
		{
			if (preg_match("~$pattern~", $line, $match))
			{
				$this->id = $match[1];

				return true;
			}
		}
		$this->id = null;

		return false;
	}

	/**
	 * @param array $env
	 *
	 * @return string
	 */
	private function buildEnvOptions(array $env)
	{
		$environment = '';
		foreach ($env as $key => $value)
		{
			$environment .= "-e $key=" . escapeshellarg($value) . " ";
		}

		return $environment;
	}
}
