<?php

/**
 * Project Build Script
 */

$theme_directory = './web/app/themes/attractmode'; // './web/app/themes/themedir/'
$theme_directory_cd = "cd $theme_directory";

if (!$theme_directory){
	throw new Exception('$theme_directory must be defined!');
}

$commands = array(
	'composer install',
	"$theme_directory_cd && npm install",
	"$theme_directory_cd && bower install",
	"$theme_directory_cd && gulp build"
);

if ($commands){
	foreach ($commands as $command){
		echo shell_exec($command);
	}
}

