<?php

namespace GreenCape\DockerTest;

class BaseTest extends \PHPUnit_Framework_TestCase
{
	/** @var  DockerContainer */
	private $container;

	/** @var  DockerImage */
	private $image;

	/**
	 * This method is called before the first test of this test class is run.
	 */
	public static function setUpBeforeClass()
	{
		$repoPath = str_replace('/tests/', '/', __DIR__);
		$image = new DockerImage(new self, $repoPath, 'test/image');
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
		$repoPath = str_replace('/tests/', '/', __DIR__);
		$this->image = new DockerImage($this, $repoPath, 'test/image');
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
	 */
	public static function tearDownAfterClass()
	{
		$repoPath = str_replace('/tests/', '/', __DIR__);
		$image    = new DockerImage(new self, $repoPath, 'test/image');
		if ($image->exists())
		{
			$image->remove();
		}
	}

	/**
	 * @testdox Image is based on phusion/baseimage
	 */
	public function testImageIsBasedOnPhusionBaseimage()
	{
		$this->assertRegExp('~Phusion~', implode("\n", $this->image->history()));
	}

	public function testNanoEditorIsInstalled()
	{
		$this->assertContains('GNU nano version 2', $this->container->run('nano --version'));
	}

	/**
	 * @testdox Cron daemon is installed
	 */
	public function testCron()
	{
		$this->assertContains('cron', $this->container->getServices());
	}

	/**
	 * @testdox SSH daemon is installed
	 */
	public function testSsh()
	{
		$this->assertContains('sshd', $this->container->getServices());
	}
}
