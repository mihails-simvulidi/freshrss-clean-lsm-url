<?php

declare(strict_types=1);

final class CleanLsmUrlExtension extends Minz_Extension
{
    public function init(): void
    {
        $this->registerHook('entry_before_insert', [self::class, 'cleanLsmUrl']);
    }

    public static function cleanLsmUrl(FreshRSS_Entry $entry): FreshRSS_Entry
    {
        $link = $entry->link(true);
        $url = parse_url($link);
        if (is_array($url) &&
            isset($url['scheme']) &&
            $url['scheme'] === 'https' &&
            !isset($url['user']) &&
            !isset($url['pass']) &&
            isset($url['host']) &&
            str_ends_with($url['host'], '.lsm.lv') &&
            !isset($url['port']) &&
            isset($url['path']))
        {
            $entry->_link($url['scheme'] . '://' . $url['host'] . $url['path']);
        }
        return $entry;
    }
}
