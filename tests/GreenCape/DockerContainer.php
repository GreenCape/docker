<?php

namespace GreenCape\DockerTest;

class DockerContainer
{
	/** @var \PHPUnit_Framework_TestCase  */
	private $testCase;

	/** @var DockerImage  */
	private $image;

	/** @var string  */
	private $name;

	/** @var string */
	private $id = null;

	use ShellAdapter;

	/**
	 * @param \PHPUnit_Framework_TestCase $testCase
	 * @param DockerImage                 $image
	 * @param null                        $name
	 */
	public function __construct(\PHPUnit_Framework_TestCase $testCase, DockerImage $image, $name = null)
	{
		$this->testCase = $testCase;

		if (empty($name))
		{
			$name = preg_replace('~\W+~', '_', (string) $image);
		}
		$this->name = $name;
		$this->image = $image;
	}

	public function create()
	{
		$response = $this->shell("docker create --name=" . $this->name . " " . (string)$this->image);
		$this->id = $response['result'];

		return $this;
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

	public function exec($command)
	{
		$response = $this->shell("docker exec " . $this->name . " /bin/bash -c \"" . $command . "\"");

		return $response;
	}

	public function run($command, array $env = array())
	{
		$environment = $this->buildEnvOptions($env);
		$response = $this->shell("docker run --rm " . $environment . $this->image . " /bin/bash -c \"" . $command . "\"");

		return $response;
	}

	public function getServices()
	{
		$command = 'ls /etc/service';
		$response = empty($this->id) ? $this->run($command) : $this->exec($command);

		return $response['output'];
	}

	private function guardContainerIsRunning()
	{
		if (empty($this->id))
		{
			$this->testCase->fail("Container $this->name ($this->image) is not running.");
		}
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
