<?php
# Valid import extensions
const EXTENSIONS = ['.php', 'phtml', 'inc'];

/**
 * Load files from a directory recursive
 * */
function __load_recursive(string $path, int $depth = 10) {
	if ($depth < 0)
		return null;
	foreach(scandir($path) as $file) {
		if (is_dir("$path/$file"))
			__load_recursive("$path/$file", $depth - 1);
		elseif (is_file("$path/$file") && __valid_file("$path/$file"))
			require_once "$path/$file";
	}
}

/**
 * Check if the file is valid
 * */
function __valid_file(string $filename): bool {
	foreach (EXTENSIONS as $ext) {
		$fext = substr($filename, -strlen($ext));
		if (strcmp($fext, $ext) === 0)
			return true;
	}
	return false;
}

/**
 * Load files from a directory
 * */
function __load_from_dir(string $path) {
	foreach(scandir($path) as $file) {
		if (is_file("$path/$file") && __valid_file("$path/$file"))
			require_once "$path/$file";
	}
}

/**
 * Autoloader implementation
 * */
spl_autoload_register(function(string $class) {
	$path = str_replace('\\', '/', $class);
	require_once "$path.php";
});
