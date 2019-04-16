<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: CacheableTrait.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace xkamen06\pms\Traits;

use Cache;

/**
 * Trait CacheableTrait
 * @package xkamen06\pms\Traits
 */
trait CacheableTrait
{
    /**
     * Get data from cache or take it from DB and store it to cache
     *
     * @param array $cacheTags
     *
     * @param string $cacheKey
     *
     * @param int $cacheInterval
     *
     * @param \Closure $callback
     *
     * @return mixed
     */
    public function cache(array $cacheTags, string $cacheKey, int $cacheInterval, \Closure $callback)
    {
        return config('app.debug', false)
            ? $callback()
            : Cache::tags($cacheTags)->remember($cacheKey, $cacheInterval, $callback);
    }
}