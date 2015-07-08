<?php

namespace GreenCape\DockerTest;

trait ShellAdapter
{
	private $verbose = false;

	/**
	 * @return boolean
	 */
	public function isVerbose()
	{
		return $this->verbose;
	}

	/**
	 * @param boolean $verbose
	 */
	public function setVerbose($verbose)
	{
		$this->verbose = $verbose;
	}

	/**
	 * @param $command
	 *
	 * @return array
	 */
	public function shell($command)
	{
		$output = array();
		$return = 0;
		$result = exec($command, $output, $return);

		$response = array(
			'command' => $command,
			'output'  => $output,
			'result'  => $result,
			'return'  => $return
		);

		if ($this->isVerbose())
		{
			print_r($response);
		}

		return $response;
	}
}
