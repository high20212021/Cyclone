<?php

if(!defined('LEVELDB_ZLIB_RAW_COMPRESSION')){
	//leveldb might not be loaded
	define('LEVELDB_ZLIB_RAW_COMPRESSION', 4);
}

//opcache breaks PHPStan when dynamic reflection is used - see https://github.com/phpstan/phpstan-src/pull/801#issuecomment-978431013
ini_set('opcache.enable', 'off');
define('pocketmine\START_TIME', microtime(true));
define('pocketmine\DEBUG', true);
