<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate {--output=public/sitemap.xml : Relative path to the sitemap file}';

    protected $description = 'Generate a sitemap.xml for public routes while excluding admin endpoints.';

    private array $ignoredNameFragments = [
        'logout',
        'captcha',
        'callback',
        'notify',
        'tester',
        'cart.count',
        'checkout.get.store',
    ];

    private array $additionalPaths = [
        'faqs',
    ];

    public function handle(): int
    {
        $baseUrl = rtrim(config('app.url') ?? '', '/');

        if (empty($baseUrl)) {
            $this->warn('APP_URL is not set. Falling back to http://localhost');
            $baseUrl = 'http://localhost';
        }

        $urls = $this->collectRoutes()
            ->map(fn (string $uri) => $this->normaliseUrl($baseUrl, $uri))
            ->prepend($baseUrl . '/')
            ->unique()
            ->sort()
            ->values();

        $xml = $this->buildXml($urls);

        $outputPath = base_path($this->option('output'));
        File::ensureDirectoryExists(dirname($outputPath));
        File::put($outputPath, $xml);

        $this->info("Sitemap generated at: {$outputPath}");

        return self::SUCCESS;
    }

    private function collectRoutes(): Collection
    {
        return collect(Route::getRoutes())
            ->filter(function ($route) {
                if (!in_array('GET', $route->methods(), true)) {
                    return false;
                }

                $uri = $route->uri();
                $middlewares = collect($route->gatherMiddleware());
                $name = (string) $route->getName();

                return !Str::startsWith($uri, 'admin')
                    && !Str::startsWith($uri, 'api')
                    && !Str::startsWith($uri, 'broadcasting')
                    && !Str::startsWith($uri, 'sanctum')
                    && !Str::startsWith($uri, '_ignition') // Laravel debug panel
                    && !Str::contains($uri, '{') // skip parameterised routes
                    && $middlewares->doesntContain(fn ($middleware) => Str::contains($middleware, 'auth'))
                    && $name !== ''
                    && !Str::contains($name, $this->ignoredNameFragments);
            })
            ->map(fn ($route) => $route->uri())
            ->merge($this->additionalPaths);
    }

    private function normaliseUrl(string $baseUrl, string $uri): string
    {
        $trimmed = ltrim($uri, '/');

        return $trimmed === '' ? "{$baseUrl}/" : "{$baseUrl}/{$trimmed}";
    }

    private function buildXml(Collection $urls): string
    {
        $lastMod = now()->toDateString();

        $lines = [
            '<?xml version="1.0" encoding="UTF-8"?>',
            '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">',
        ];

        foreach ($urls as $url) {
            $escapedUrl = htmlspecialchars($url, ENT_XML1);
            $lines[] = "  <url>";
            $lines[] = "    <loc>{$escapedUrl}</loc>";
            $lines[] = "    <lastmod>{$lastMod}</lastmod>";
            $lines[] = "    <changefreq>weekly</changefreq>";
            $lines[] = "    <priority>0.5</priority>";
            $lines[] = "  </url>";
        }

        $lines[] = '</urlset>';

        return implode(PHP_EOL, $lines) . PHP_EOL;
    }
}
