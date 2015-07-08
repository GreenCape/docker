<?php

namespace GreenCape\DockerTest;

class DockerContainerTest extends \PHPUnit_Framework_TestCase
{
	/** @var string */
	private $imageName = 'test/image';

	/** @var  DockerContainer */
	private $container;

	/** @var  DockerImage */
	private $image;

	/**
	 * This method is called before the first test of this test class is run.
	 *
	 * @since Method available since Release 3.4.0
	 */
	public static function setUpBeforeClass()
	{
		$image = new DockerImage(new self, getcwd() . '/GreenCape/base', 'test/image');
		if ($image->exists())
		{
			$image->remove();
		}
		$image->build();
	}

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->image = new DockerImage($this, getcwd() . '/GreenCape/base', $this->imageName);
		$this->container = new DockerContainer($this, $this->image);
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{
	}

	/**
	 * This method is called after the last test of this test class is run.
	 *
	 * @since Method available since Release 3.4.0
	 */
	public static function tearDownAfterClass()
	{
		$image = new DockerImage(new self, getcwd() . '/GreenCape/base', 'test/image');
		if ($image->exists())
		{
			$image->remove();
		}
	}

	public function testRunCommand()
	{
		$response = $this->container->run('uname');

		$this->assertEquals('Linux', $response['result']);
	}

	public function testExecCommand()
	{
		$this->container->create();
		$this->container->start();
		$response = $this->container->exec('uname');
		$this->container->stop();
		$this->container->remove();

		$this->assertEquals('Linux', $response['result']);
	}
}
