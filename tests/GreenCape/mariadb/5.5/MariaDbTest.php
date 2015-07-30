<?php

namespace GreenCape\DockerTest;

class Mariadb_5_5Test extends \PHPUnit_Framework_TestCase
{
	protected static $version = "5.5";

	/** @var string */
	private $imageName = 'test/image';

	/** @var  DockerContainer */
	private $container;

	/** @var  DockerImage */
	private $image;

	/**
	 * This method is called before the first test of this test class is run.
	 */
	public static function setUpBeforeClass()
	{
		$repoPath = self::getRepoPath();
		$image    = new DockerImage(new self, $repoPath, 'test/image');
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
		$repoPath = self::getRepoPath();
		$this->image = new DockerImage($this, $repoPath, $this->imageName);
		$this->image->setVerbose(true);
		$this->container = new DockerContainer($this, $this->image);
		$this->container->setVerbose(true);
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
		$repoPath = self::getRepoPath();
		$image    = new DockerImage(new self, $repoPath, 'test/image');
		if ($image->exists())
		{
			$image->remove();
		}
	}

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
		$this->assertContains('mysqld', $this->container->getServices());
	}

	/**
	 * @testdox MySQL daemon gets started by runit
	 */
	public function testMysqlDaemonGetsStarted()
	{
		$response = $this->container->run(
			'/sbin/my_init -- /sbin/wait-for-mysqld 2>/dev/null',
			array(
				'MYSQL_ALLOW_EMPTY_PASSWORD' => true
			)
		);
		$this->assertContains('run: mysqld:', $response['result']);
	}

	/**
	 * @return string
	 */
	private static function getRepoPath()
	{
		return str_replace('/tests/', '/', dirname(__DIR__)) . '/' . self::$version;
	}
}
