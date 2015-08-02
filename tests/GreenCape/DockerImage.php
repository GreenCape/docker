<?php

namespace GreenCape\DockerTest;

/**
 * Class DockerImage
 *
 * @package GreenCape\DockerTest
 */
class DockerImage
{
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
	 * @param string                      $path
	 * @param string                      $repository
	 */
	public function __construct($path, $repository)
	{
		if (!file_exists("$path/Dockerfile"))
		{
			throw new \InvalidArgumentException("$path/Dockerfile does not exist");
		}
		$this->path     = $path;
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
	public function build($log = null)
	{
		$response = $this->shell("docker build --force-rm --tag=" . (string)$this . " \"$this->path\"");
		if (!empty($log))
		{
			file_put_contents($log, implode("\n", $response['output']));
		}
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
		$response = $this->shell("docker images | grep " . $this->repository);
		$pattern  = '^' . preg_quote($this->repository) . '\s+' . preg_quote($this->tag) . '\s+(\w+)';
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
}
