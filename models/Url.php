<?php

namespace ESemenkov\TestTaskKma\models;

/**
 * @property string $url
 * @property int $time
 * @property int $contentLength
 */
class Url
{
    public readonly string $url;

    public readonly int $time;

    public readonly int $contentLength;

    public function __construct($url, $time, $contentLength)
    {
        $this->url = $url;
        $this->time = $time;
        $this->contentLength = $contentLength;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getTime(): string
    {
        return $this->time;
    }

    public function getContentLength(): string
    {
        return $this->contentLength;
    }
}