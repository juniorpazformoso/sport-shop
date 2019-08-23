<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Composer\Autoload\ClassLoader;

/**
 * @var ClassLoader $loader
 */
$loader = require __DIR__.'/../vendor/autoload.php';

AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

$loader->add(        
        'PHPExcel', __DIR__.'/../vendor/PHPExcel/Export/ExcelBundle/Library/phpExcel/Classes'        
    );
	
	
return $loader;
