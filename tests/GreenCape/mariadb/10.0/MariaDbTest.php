<?php

namespace GreenCape\DockerTest;

class Mariadb_10_0Test extends MariadbCommon
{
	/** @var string  */
	protected $version = '10.0';

	/** @var string */
	protected $imageName = 'greencape/mariadb:10.0';

	/**
	 * @return string
	 */
	protected function getRepoPath()
	{
		return str_replace('/tests/', '/', __DIR__);
	}

	/**
	 * @testdox Test uses the GreenCape/mariadb/10.0 repository
	 */
	public function testTestUsesTheCorrectRepository()
	{
		$this->assertRegExp('~/GreenCape/mariadb/10.0$~', $this->getRepoPath());
	}
}
