<?php

if (!function_exists('markdown_file')) {
    function markdown_file($filename)
    {
        $locale = app()->getLocale();
        $text = file_get_contents(resource_path("texts/{$filename}.{$locale}.md"));
        $parser = app('parsedown');
        return $parser->text($text);
    }
}
