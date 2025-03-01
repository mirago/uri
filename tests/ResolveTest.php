<?php

declare(strict_types=1);

namespace Sabre\Uri;

class ResolveTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider resolveData
     */
    public function testResolve($base, $update, $expected)
    {
        $this->assertEquals(
            $expected,
            resolve($base, $update)
        );
    }

    public function resolveData()
    {
        return [
            [
                'http://example.org/foo/baz',
                '/bar',
                'http://example.org/bar',
            ],
            [
                'https://example.org/foo',
                '//example.net/',
                'https://example.net/',
            ],
            [
                'https://example.org/foo',
                '?a=b',
                'https://example.org/foo?a=b',
            ],
            [
                '//example.org/foo',
                '?a=b',
                '//example.org/foo?a=b',
            ],
            // Ports and fragments
            [
                'https://example.org:81/foo#hey',
                '?a=b#c=d',
                'https://example.org:81/foo?a=b#c=d',
            ],
            // Relative.. in-directory paths
            [
                'http://example.org/foo/bar',
                'bar2',
                'http://example.org/foo/bar2',
            ],
            // Now the base path ended with a slash
            [
                'http://example.org/foo/bar/',
                'bar2/bar3',
                'http://example.org/foo/bar/bar2/bar3',
            ],
            // .. and .
            [
                'http://example.org/foo/bar/',
                '../bar2/.././/bar3/',
                'http://example.org/foo//bar3/',
            ],
            // Only updating the fragment
            [
                'https://example.org/foo?a=b',
                '#comments',
                'https://example.org/foo?a=b#comments',
            ],
            // Switching to mailto!
            [
                'https://example.org/foo?a=b',
                'mailto:foo@example.org',
                'mailto:foo@example.org',
            ],
            // Resolving empty path
            [
                'http://www.example.org',
                '#foo',
                'http://www.example.org/#foo',
            ],
            // Another fragment test
            [
                'http://example.org/path.json',
                '#',
                'http://example.org/path.json',
            ],
            [
                'http://www.example.com',
                '#',
                'http://www.example.com/',
            ],
            [
                'http://www.example.org',
                '#foo',
                'http://www.example.org/#foo',
            ],
            // Another fragment test
            [
                'http://example.org/path.json',
                '#',
                'http://example.org/path.json',
            ],
        ];
    }
}
