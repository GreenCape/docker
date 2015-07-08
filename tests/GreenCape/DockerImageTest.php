<?php

namespace GreenCape\DockerTest;

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

	public function testImageCanBeBuiltAndRemoved()
	{
		$image = new DockerImage($this, getcwd() . '/GreenCape/base', $this->repository);

		$this->assertFalse($image->exists(), "Image $this->repository already exists. Remove it and try again!");

		$image->build();

		$this->assertTrue($image->exists(), "Image $this->repository could not be built");

		$image->remove();

		$this->assertFalse($image->exists(), "Image $this->repository could not be removed");
	}

	/**
	 * @testdox String representation is 'repository:tag'
	 */
	public function testStringRepresentationIsRepositoryColonTag()
	{
		$image = new DockerImage($this, null, $this->repository);

		$this->assertEquals($this->repository . ':latest', (string) $image);
	}
}
