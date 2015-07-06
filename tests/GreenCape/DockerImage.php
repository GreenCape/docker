<?php

namespace GreenCape\DockerTest;

use Docker\Context\Context;
use Docker\Docker;
use Docker\Exception\APIException;
use Docker\Exception\UnexpectedStatusCodeException;
use Docker\Image;

class DockerImage
{
	private $docker;

	private $image;

	/**
	 * @param string $path
	 * @param string $imageName
	 *
	 * @throws UnexpectedStatusCodeException
	 */
	public function __construct($path, $imageName)
	{
		$this->image = new Image($imageName);

		$this->docker = new Docker();

		if ($this->docker->build(new Context($path), $this->image)->getStatusCode() != 200)
		{
			throw new UnexpectedStatusCodeException("Unable to build an image for " . $this->image);
		}
	}

	/**
	 * @throws UnexpectedStatusCodeException
	 */
	public function __destruct()
	{
		try
		{
			$this->docker->getImageManager()->remove($this->image, true);
		}
		catch (APIException $e)
		{
			// Image has already gone.
		}
	}

	public function __toString()
	{
		return (string) $this->image;
	}

	public function history()
	{
		return $this->docker->getImageManager()->history($this->image);
	}
}
