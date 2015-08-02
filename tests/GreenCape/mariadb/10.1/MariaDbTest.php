<?php

namespace GreenCape\DockerTest;

class Mariadb_10_1Test extends MariadbCommon
{
	/** @var string  */
	protected $version = '10.1';

	/** @var string */
	protected $imageName = 'greencape/mariadb:10.1';

	/**
	 * @return string
	 */
	protected function getRepoPath()
	{
		return str_replace('/tests/', '/', __DIR__);
	}

	/**
	 * @testdox Test uses the GreenCape/mariadb/10.1 repository
	 */
	public function testTestUsesTheCorrectRepository()
	{
		$this->assertRegExp('~/GreenCape/mariadb/10.1$~', $this->getRepoPath());
	}
}
