<?php

namespace GreenCape\DockerTest;

use Docker\Docker;
use Docker\Exception\ImageNotFoundException;

class DockerImageTest extends \PHPUnit_Framework_TestCase
{
	protected $repository = 'test/image';

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{
	}

	public function testImageIsCreatedByConstructorAndRemovedByDestructor()
	{
		$docker = new Docker();
		$imageManager = $docker->getImageManager();

		try
		{
			$image = $imageManager->find($this->repository);
			$this->fail("There should not be a '$this->repository' image. Remove '$image' and retry!");
		}
		catch (ImageNotFoundException $e)
		{
			$this->addToAssertionCount(1);
		}

		$image = new DockerImage(str_replace('/tests/', '/', __DIR__) . '/base', $this->repository);

		try
		{
			$imageManager->find($this->repository);
			$this->addToAssertionCount(1);
		}
		catch (ImageNotFoundException $e)
		{
			$this->fail("Image '$this->repository' was not created");
		}

		unset($image);

		try
		{
			$image = $imageManager->find($this->repository);
			$this->fail("The '$image' image was not removed");
		} catch (ImageNotFoundException $e)
		{
			$this->addToAssertionCount(1);
		}
	}

	/**
	 * @testdox String representation is 'repository:tag'
	 */
	public function testStringRepresentationIsRepositoryColonTag()
	{
		$image = new DockerImage(str_replace('/tests/', '/', __DIR__) . '/base', $this->repository);

		$this->assertEquals($this->repository . ':latest', (string) $image);
	}
}
