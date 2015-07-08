<?php

namespace GreenCape\DockerTest;

/**
 * Class DockerImage
 *
 * @package GreenCape\DockerTest
 */
class DockerImage
{
	/** @var \PHPUnit_Framework_TestCase */
	private $testCase;

	/** @var string */
	private $path;

	/** @var mixed */
	private $repository;

	/** @var string */
	private $tag;

	/** @var string */
	private $id = null;

	use ShellAdapter;

	/**
	 * @param \PHPUnit_Framework_TestCase $testCase
	 * @param string                      $path
	 * @param string                      $repository
	 */
	public function __construct(\PHPUnit_Framework_TestCase $testCase, $path, $repository)
	{
		$this->testCase = $testCase;
		$this->path       = $path;
		$this->setRepository($repository);
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->repository . ':' . $this->tag;
	}

	/**
	 * @return mixed
	 */
	public function getRepository()
	{
		return $this->repository;
	}

	/**
	 * @param mixed $repository
	 */
	public function setRepository($repository)
	{
		$tmp              = explode(':', $repository);
		$this->repository = array_shift($tmp);
		$this->tag        = array_shift($tmp);

		if (empty($this->tag))
		{
			$this->tag = 'latest';
		}
	}

	/**
	 * @return string
	 */
	public function getTag()
	{
		return $this->tag;
	}

	/**
	 * @param string $tag
	 */
	public function setTag($tag)
	{
		$this->tag = $tag;
	}

	/**
	 * @return string
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param string $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * @return string The image id
	 */
	public function build()
	{
		$response = $this->shell("docker build --force-rm --tag=" . $this->repository . " \"$this->path\"");
		$this->id = str_replace('Successfully built ', '', $response['result']);

		return $this->id;
	}

	/**
	 * @return int
	 */
	public function remove()
	{
		$response = $this->shell("docker rmi --force " . $this->id);
		$this->id = null;

		return $response['return'];
	}

	/**
	 * @return array
	 */
	public function history()
	{
		$response = $this->shell("docker history " . $this->repository);

		return $response['output'];
	}

	/**
	 * @return bool
	 */
	public function exists()
	{
		if (empty($this->id))
		{
			return false;
		}

		$response = $this->shell("docker images | grep " . $this->repository);
		$pattern = '^' . preg_quote($this->repository) . '\s+' . preg_quote($this->tag) . '\s+' . preg_quote($this->id);
		foreach ($response['output'] as $line)
		{
			if (preg_match("~$pattern~", $line))
			{
				return true;
			}
		}
		return false;
	}
}
