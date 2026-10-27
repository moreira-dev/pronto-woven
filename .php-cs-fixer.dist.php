<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
	->in([__DIR__ . '/src', __DIR__ . '/tests'])
	->append([__FILE__]);

return (new Config())
	->setRules([
		'@PSR12' => true,
		'array_syntax' => ['syntax' => 'short'],
		'no_unused_imports' => true,
		'single_quote' => true,
	])
	->setIndent("\t")
	->setLineEnding("\n")
	->setRiskyAllowed(false)
	->setCacheFile(__DIR__ . '/.php-cs-fixer.cache')
	->setFinder($finder);
