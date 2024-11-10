<?php

function generateNamePart( int $minLength = 5, int $maxLength = 15 ) : string {
	$length     = random_int($minLength, $maxLength);
	$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

	// Ensure the first character is uppercase
	$randomString = $characters[random_int(0, 25)]; // Pick from A-Z for the first character

	// Add the rest of the characters randomly
	for( $i = 1; $i < $length; $i++ ) {
		$randomString .= $characters[random_int(0, strlen($characters) - 1)];
	}

	return $randomString;
}

function generateRandomClassName( int $max = 5, int $min = 2 ) : string {
	$namespaceDepth = random_int($min, $max);
	$classNameParts = [];

	for( $i = 0; $i < $namespaceDepth; $i++ ) {
		$classNameParts[] = generateNamePart();
	}

	return implode('\\', $classNameParts);
}

function generateRandomClasses( int $number ) : Generator {
	$total = 0;
	for( ; ; ) {
		$namespace = generateRandomClassName();


		$currentNs = '';
		$parts     = explode('\\', $namespace);

		foreach( $parts as $part ) {
			$currentNs .= ltrim('\\' . $part, '\\');

			$numberInNamespace = random_int(0, 4);

			for( $j = 0; $j < $numberInNamespace; $j++ ) {
				yield $currentNs . '\\' . generateNamePart();
				$total++;
				if( $total >= $number ) {
					return;
				}
			}
		}
	}
}

function generateClass( string $fqcn ) : string {
	$parts     = explode('\\', $fqcn);
	$className = array_pop($parts);
	$namespace = implode('\\', $parts);

	return <<<PHP
<?php

namespace {$namespace};

class {$className} {

    public static function hello() : string {
        return 'hello world';
    }

}

PHP;
}

function saveClassFile( string $contents, string $fqcn, string $base ) : void {
	// Split the namespace and class name
	$parts         = explode('\\', $fqcn);
	$className     = array_pop($parts);
	$namespacePath = implode(DIRECTORY_SEPARATOR, $parts);

	// Combine the base directory with the namespace path to create the full path
	$directoryPath = rtrim($base, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $namespacePath;

	// Create the directories recursively if they do not exist
	if( !is_dir($directoryPath) ) {
		if( !mkdir($directoryPath, 0777, true) && !is_dir($directoryPath) ) {
			throw new \RuntimeException(sprintf('Directory "%s" was not created', $directoryPath));
		}
	}

	// Define the full path including the class file
	$filePath = $directoryPath . DIRECTORY_SEPARATOR . $className . '.php';

	// Save the contents to the file
	file_put_contents($filePath, $contents);
}
