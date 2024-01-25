<?php

declare(strict_types=1);

namespace Local\Utils;

use JsonException;
use RuntimeException;

final class Assets
{
    private ?string $hot;
    private ?array $manifest;

    /**
     * @throws JsonException
     */
    public function __construct(
        private readonly string $buildDirectory = 'local/build/',
        private readonly string $manifestFile = 'manifest.json'
    ) {
        $this->hot = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/' . $this->buildDirectory . '.hot') ?: null;

        if (!$this->hot) {
            $this->manifest = $this->loadManifest();
        }
    }

    /**
     * @throws JsonException
     */
    public static function init(
        string $buildDirectory = 'local/build/',
        string $manifestFile = 'manifest.json',
    ): Assets {
        $instance = new self($buildDirectory, $manifestFile);

        if ($instance->hot) {
            $instance->renderHmrTag();
        }

        return $instance;
    }

    public function renderHmrTag(): void
    {
        echo $this->makeScriptTag(rtrim($this->hot) . '/' . $this->buildDirectory . '@vite/client');
    }

    public function asset(string $asset): string
    {
        $file = ltrim($asset, '/');

        if ($this->hot) {
            return $this->hotAsset($this->buildDirectory . $file);
        }

        return $this->buildDirectory . '/' . $this->chunk($file)['file'];
    }

    public function renderAssetTag(string $asset): void
    {
        // todo chunk['imports']

        $url = $this->asset($asset);
        echo $this->assetTag($url);
    }

    private function hotAsset($asset): string
    {
        return rtrim($this->hot) . '/' . $asset;
    }

    private function chunk(string $file): array
    {
        return $this->manifest[$file];
    }

    /**
     * @throws JsonException
     */
    private function loadManifest(): array
    {
        $file = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/' . $this->buildDirectory . $this->manifestFile);

        if (!$file) {
            throw new RuntimeException('Manifest file not found!');
        }

        return json_decode(
            $file,
            true,
            512,
            JSON_THROW_ON_ERROR
        );
    }

    private function makeScriptTag(string $url, array $attributes = []): string
    {
        $attributes = $this->buildHtmlAttributes(
            array_merge([
                'type' => 'module',
                'src' => $url,
            ], $attributes),
        );

        return '<script ' . implode(' ', $attributes) . '></script>';
    }

    private function makeStylesheetTag(string $url, array $attributes = []): string
    {
        $attributes = $this->buildHtmlAttributes(
            array_merge([
                'rel' => 'stylesheet',
                'href' => $url,
            ], $attributes),
        );

        return '<link ' . implode(' ', $attributes) . ' />';
    }

    private function buildHtmlAttributes(array $attr): array
    {
        return array_map(static fn($key) => sprintf(
            '%s="%s"',
            htmlspecialchars($key, ENT_QUOTES | ENT_HTML5),
            htmlspecialchars($attr[$key], ENT_QUOTES | ENT_HTML5)
        ), array_keys($attr));
    }

    private function assetTag(string $url): string
    {
        $isCss = preg_match('/\.(css|less|sass|scss|styl|stylus|pcss|postcss)$/', $url) === 1;

        if ($isCss) {
            return $this->makeStylesheetTag($url);
        }

        return $this->makeScriptTag($url);
    }
}
