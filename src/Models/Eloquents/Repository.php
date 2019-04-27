<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: Repository.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace xkamen06\pms\Model\Eloquents;

use xkamen06\pms\Traits\CacheableTrait;
use Illuminate\Support\Facades\DB;

/**
 * Class Repository
 * @package xkamen06\pms\Model
 */
abstract class Repository
{
    use CacheableTrait;

    /**
     * To array
     *
     * @param $objects
     *
     * @return array
     */
    protected function toArray($objects) : array
    {
        $objectsArray = [];
        foreach ($objects as $object)
        {
            $objectsArray[] = $object;
        }
        return $objectsArray;
    }

    /**
     * Returns number of objects
     *
     * @return int|null
     */
    public function getCount() : ?int
    {
        $cacheKey = $this->cacheTags[0] . '.getCount';

        return $this->cache($this->cacheTags, $cacheKey, $this->cacheInterval, function () {
            return DB::table($this->table)->count();
        });
    }
}