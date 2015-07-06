<?php

namespace GreenCape\DockerTest;

use Docker\Docker;

class BaseTest extends \PHPUnit_Framework_TestCase
{
	/** @var string */
	private $imageName = 'test/base';

	/** @var  DockerContainer */
	private $container;

	/** @var  DockerImage */
	private $image;

	/**
	 * Constructs a test case with the given name.
	 *
	 * @param string $name
	 * @param array  $data
	 * @param string $dataName
	 */
	public function __construct($name = null, array $data = array(), $dataName = '')
	{
		parent::__construct($name, $data, $dataName);
		$this->image = new DockerImage(str_replace('/tests/', '/', __DIR__), $this->imageName);
	}

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->container = new DockerContainer($this->image);
		$this->container->start();
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{
		$this->container->stop();
	}

	/**
	 * @testdox Image is based on phusion/baseimage
	 */
	public function testImageIsBasedOnPhusionBaseimage()
	{
		$history = $this->image->history();
		$this->assertRegExp('~^phusion/baseimage:.*$~', $history[1]['Tags'][0]);
	}

	public function testNanoEditorIsInstalled()
	{
		$this->assertContains('GNU nano version 2', $this->container->exec('nano --version'));
	}
}
