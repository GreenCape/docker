<?php

require '../vendor/autoload.php';

$argv = $_SERVER['argv'];
array_shift($argv);

$suites = [];
while (!empty($argv))
{
	$arg = array_shift($argv);
	if (strpos($arg, '=') > 0)
	{
		$parts = preg_split('~\s*=\s*~', $arg, 2);
		$arg   = $parts[0];
		array_unshift($argv, $parts[1]);
	}
	if ($arg == '--testsuite')
	{
		$suites[] = strtolower(array_shift($argv));
	}
}

if (empty($suites))
{
	$config = 'phpunit.xml';
	if (!file_exists($config))
	{
		$config = 'phpunit.xml.dist';
	}
	if (file_exists($config))
	{
		// Get all suites from config file
		preg_match_all('~testsuite\s+name="(.*?)"~', file_get_contents($config), $matches);
		$suites = array_map('strtolower', $matches[1]);
	}
	else
	{
		foreach (array_filter(explode("\n", `ls -d ../GreenCape/*/`)) as $dir)
		{
			$suites[] = strtolower(basename($dir));
		}
	}
}

$images        = [];
$updateScripts = [];
$dependencies  = [];
foreach (array_filter(explode("\n", `find .. -name Dockerfile`)) as $dockerFile)
{
	$sourcePath = dirname($dockerFile);
	foreach ($suites as $package)
	{
		$pos = strpos($dockerFile, "/$package/");
		if ($pos > 0)
		{
			$baseImage = preg_replace('~^.*?FROM\s+(\S+).*$~sim', '\1', file_get_contents($dockerFile));
			if (strpos($baseImage, ':') === false)
			{
				$baseImage .= ':latest';
			}

			$basePath                = substr($sourcePath, 0, $pos);
			$vendor                  = strtolower(basename($basePath));
			$updateScripts[$package] = $basePath . "/$package/update.sh";
			$parts                   = explode('/', substr($sourcePath, $pos + 1));
			if (count($parts) == 1)
			{
				$parts[1] = 'latest';
			}
			$repo                = $vendor . '/' . implode(':', $parts);
			$images[$repo]       = $sourcePath;
			$dependencies[$repo] = $baseImage;
			continue;
		}
	}
}

echo "\nBootstrap: Preparing images for test ...\n";

foreach ($updateScripts as $package => $updateScript)
{
	if (file_exists($updateScript))
	{
		echo "- updating $package context(s) ... ";
		exec($updateScript . ' 2>/dev/null');
		echo "ok\n";
	}
}

echo "- resolving dependencies ..";
foreach ($dependencies as $image => $baseImage)
{
	if (!isset($images[$baseImage]))
	{
		// We're not interested in 'external' dependencies
		unset($dependencies[$image]);
	}
}

do
{
	$orderedImages   = [];
	$orderingChanged = false;
	foreach ($images as $image => $path)
	{
		if (isset($dependencies[$image]) && !isset($orderedImages[$dependencies[$image]]))
		{
			$orderedImages[$dependencies[$image]] = $images[$dependencies[$image]];
			$orderingChanged                      = true;
		}
		if (!isset($orderedImages[$image]))
		{
			$orderedImages[$image] = $path;
		}
	}
	$images = $orderedImages;
	echo '.';
} while ($orderingChanged);
echo " ok\n";

foreach ($images as $image => $path)
{
	echo "- building $image ... ";
	$image = new \GreenCape\DockerTest\DockerImage($path, $image);
	$image->build("$path/build.log");
	echo "ok\n";
}
echo "done.\n\n";
