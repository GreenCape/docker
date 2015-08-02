<?php

namespace GreenCape\DockerTest;

abstract class MariadbCommon extends \PHPUnit_Framework_TestCase
{
	/** @var string */
	protected $version = 'x.y';

	/** @var string */
	protected $imageName = 'greencape/mariadb';

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
		$this->image = new DockerImage($this->getRepoPath(), $this->imageName);
		#$this->image->setVerbose(true);
		$this->container = new DockerContainer($this->image);
		#$this->container->setVerbose(true);
	}

	/**
	 * @return string
	 * @throws \ErrorException
	 */
	abstract protected function getRepoPath();

	/**
	 * @testdox MySQL daemon is installed
	 */
	public function testMysqlDaemonIsInstalled()
	{
		$response = $this->container->run('which mysqld');
		$this->assertEquals('/usr/sbin/mysqld', $response['result']);
	}

	/**
	 * @testdox MySQL daemon is visible to runit
	 */
	public function testMysqlDaemonIsVisibleToRunit()
	{
		$response = $this->container->run('ls /etc/service');

		$this->assertContains('mysqld', $response['output']);
	}

	/**
	 * @testdox MySQL daemon gets started by runit
	 */
	public function testMysqlDaemonGetsStarted()
	{
		$this->container->runAsDaemon([
			'MYSQL_ROOT_PASSWORD' => 'root',
			'MYSQL_DATABASE'      => 'db_name',
			'MYSQL_USER'          => 'db_user',
			'MYSQL_PASSWORD'      => 'db_pass'
		]);

		$response = $this->container->logs();
		$this->assertEquals(0, $response['return']);

		$response = $this->container->exec('/sbin/wait-for-mysqld');
		$this->assertContains('run: mysqld:', $response['result']);
	}

	/**
	 * @testdox Image uses the intended MariaDB version
	 */
	public function testInspect()
	{
		$config = $this->container->inspect();
		$this->assertContains("MARIADB_MAJOR={$this->version}", $config['Config']['Env'], "Environment variable MARIADB_MAJOR is not set to {$this->version}");

		$this->container->stop();
		$this->container->remove();

	}
}
