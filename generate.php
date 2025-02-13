<?php

require __DIR__ . '/shared.php';

$rootClassmap = __DIR__ . '/classmap';
$rootPsr4     = __DIR__ . '/psr4';

$srcClassmap = $rootClassmap . '/src';
$srcPsr4     = $rootPsr4 . '/src';

$benchmarkClassmap = $rootClassmap . '/benchmark.php';
$benchmarkPsr4     = $rootPsr4 . '/benchmark.php';

$classnames = generateRandomClasses(10000);

$head = <<<'PHP'
<?php

$beforeLoad = microtime(true);

require __DIR__ . '/vendor/autoload.php';

$afterLoad = microtime(true);

PHP;

file_put_contents($benchmarkClassmap, $head);
file_put_contents($benchmarkPsr4, $head);

foreach( $classnames as $fqcn ) {
	$data = generateClass($fqcn);

	saveClassFile($data, $fqcn, $srcPsr4);

	$line = "assert({$fqcn}::hello() === 'hello world');" . PHP_EOL;

	file_put_contents($benchmarkClassmap, $line, FILE_APPEND);
	file_put_contents($benchmarkPsr4, $line, FILE_APPEND);

	$classMapFile = generateRandomClassName();

	saveClassFile($data, $classMapFile, $srcClassmap);
}



file_put_contents($benchmarkClassmap, <<<'PHP'
echo "```" . PHP_EOL;
printf("Classmap - total: %.8f exec: %.8f\n", microtime(true) - $beforeLoad, microtime(true) - $afterLoad);
echo "```" . PHP_EOL;
PHP
 . PHP_EOL, FILE_APPEND);
file_put_contents($benchmarkPsr4, <<<'PHP'
echo "```" . PHP_EOL;
printf("PSR-4    - total: %.8f exec: %.8f\n", microtime(true) - $beforeLoad, microtime(true) - $afterLoad);
echo "```" . PHP_EOL;
PHP
 . PHP_EOL, FILE_APPEND);
