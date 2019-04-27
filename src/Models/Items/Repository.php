<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: Repository.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace xkamen06\pms\Model\Items;

use Illuminate\Support\Facades\DB;
use xkamen06\pms\Traits\CacheableTrait;

/**
 * Class Repository
 * @package xkamen06\pms\Model
 */
abstract class Repository
{
    use CacheableTrait;
    
    /**
     * Gets DB:: guery
     *
     * @return mixed
     */
    protected function getQuery()
    {
        return DB::table($this->table);
    }

    /**
     * Fetched rows from database to array of items
     *
     * @param $fetchedRows
     *
     * @return array
     */
    protected function toItems($fetchedRows) : array
    {
        $items = [];
        if ($fetchedRows !== null) {
            foreach ($fetchedRows as $row) {
                $items[] = $this->toItem($row);
            }
        }
        return $items;
    }

    /**
     * Get items per page
     *
     * @param null|array $skippedIds
     *
     * @param int $perPage
     *
     * @param int $page
     *
     * @return array
     */
    public function getItemsPerPage(?array $skippedIds, int $perPage, int $page) : array
    {
        $cacheKey = $this->cacheTags[0] . '.getItemsPerPage' . $page;
        
        if ($skippedIds) {
            if ($this->table === 'users') {
                $column = 'id';
            } else {
                $column = $this->table . 'id';
            }
            return $this->cache($this->cacheTags, $cacheKey, $this->cacheInterval, function () use ($column, $perPage, $skippedIds, $page) {
                return $this->toItems($this->getQuery()->whereNotIn($column, $skippedIds)->take($perPage)
                    ->skip(($page - 1) * $perPage)->get());
            });
        }
        return $this->cache($this->cacheTags, $cacheKey, $this->cacheInterval, function () use ($perPage, $page) {
            return $this->toItems($this->getQuery()->take($perPage)->skip(($page - 1) * $perPage)->get());
        });
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
            return $this->getQuery()->count();
        });
    }
}