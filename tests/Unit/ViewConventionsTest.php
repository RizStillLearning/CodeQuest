<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

/**
 * Project convention: views use @extends layouts and @include partials,
 * not Blade components (<x-...>, @props, $slot).
 */
class ViewConventionsTest extends TestCase
{
    public function test_views_use_extends_and_include_instead_of_components(): void
    {
        $viewsPath = dirname(__DIR__, 2).'/resources/views';
        $offenders = [];

        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($viewsPath, RecursiveDirectoryIterator::SKIP_DOTS));

        foreach ($files as $file) {
            if (! str_ends_with($file->getFilename(), '.blade.php')) {
                continue;
            }

            // Blade comments may mention these words; only check real markup.
            $contents = preg_replace('/\{\{--.*?--\}\}/s', '', file_get_contents($file->getPathname()));

            if (preg_match('/<x-[\w.:-]+|@props\b|\$slot\b/', $contents, $match)) {
                $offenders[] = substr($file->getPathname(), strlen($viewsPath) + 1).' uses '.$match[0];
            }
        }

        $this->assertSame([], $offenders, "Use @extends/@section and @include instead:\n".implode("\n", $offenders));
        $this->assertDirectoryDoesNotExist($viewsPath.'/components');
    }
}
