<?php

namespace GreenCape\DockerTest;

class Mariadb_5_5Test extends MariadbCommon
{
	/** @var string  */
	protected $version = '5.5';

	/** @var string */
	protected $imageName = 'greencape/mariadb:5.5';

	/**
	 * @return string
	 */
	protected function getRepoPath()
	{
		return str_replace('/tests/', '/', __DIR__);
	}

	/**
	 * @testdox Test uses the GreenCape/mariadb/5.5 repository
	 */
	public function testTestUsesTheCorrectRepository()
	{
		$this->assertRegExp('~/GreenCape/mariadb/5.5$~', $this->getRepoPath());
	}
}
