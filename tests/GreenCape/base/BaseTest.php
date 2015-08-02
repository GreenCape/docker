<?php

namespace GreenCape\DockerTest;

class BaseTest extends \PHPUnit_Framework_TestCase
{
	/** @var  DockerContainer */
	private $container;

	/** @var  DockerImage */
	private $image;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->image = new DockerImage(str_replace('/tests/', '/', __DIR__), 'greencape/base:latest');
		$this->container = new DockerContainer($this->image);
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{
		if ($this->container->exists())
		{
			$this->container->remove();
		}
	}

	/**
	 * @testdox Image is based on Ubuntu 14.04 (LTS)
	 */
	public function testImageIsUbuntu()
	{
		$response = $this->container->run('cat /etc/*-release');
		$this->assertContains('Ubuntu 14.04', implode("\n", $response['output']));
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
		$response = $this->container->run('ls /etc/service');

		$this->assertContains('cron', $response['output']);
	}

	/**
	 * @testdox SSH daemon is installed
	 */
	public function testSsh()
	{
		$response = $this->container->run('ls /etc/service');

		$this->assertContains('sshd', $response['output']);
	}
}
