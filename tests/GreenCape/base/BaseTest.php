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
	 * @testdox Image is based on Ubuntu 14.04 (LTS)
	 */
	public function testImageIsUbuntu()
	{
		$response = $this->container->run('cat /etc/*-release');
		$this->assertContains('Ubuntu 14.04', implode("\n", $response['output']));
	}

	public function testNanoEditorIsInstalled()
	{
		$this->container->setVerbose(true);
		$response = $this->container->run('nano --version');
		$this->assertContains('GNU nano version 2', implode("\n", $response['output']));
	}

	/**
	 * @testdox Cron daemon is started
	 */
	public function testCron()
	{
		$this->container->setVerbose(true);
		$this->container->runAsDaemon();
		$this->container->exec('wait-for cron');
		$response = $this->container->exec('sv status cron');

		$this->assertContains('run: cron', $response['result']);
	}

	/**
	 * @testdox SSH daemon can be started
	 */
	public function testSsh()
	{
		$this->container->setVerbose(true);
		$this->container->exec('sv up sshd');
		$this->container->exec('wait-for sshd');
		$response = $this->container->exec('sv status sshd');

		$this->assertContains('run: sshd', $response['result']);
	}

	/**
	 * @testdox Syslog daemon is started
	 */
	public function testSyslog()
	{
		$this->container->setVerbose(true);
		$this->container->exec('wait-for syslog-ng');
		$response = $this->container->exec('sv status syslog-ng');

		$this->assertContains('run: syslog-ng', $response['result']);
	}

	/**
	 * @testdox Syslog forwarder is started
	 */
	public function testSyslogForwarder()
	{
		$this->container->setVerbose(true);
		$this->container->exec('wait-for syslog-forwarder');
		$response = $this->container->exec('sv status syslog-forwarder');

		$this->assertContains('run: syslog-forwarder', $response['result']);
	}

	/**
	 * @testdox Container can be removed
	 */
	public function testShutdown()
	{
		$this->container->stop();
		$this->container->remove();
		$this->assertFalse($this->container->exists());
	}
}
