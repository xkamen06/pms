<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: DriverRepository.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace xkamen06\pms\Model\Driver;

use Illuminate\Support\Facades\DB;
use xkamen06\pms\Traits\CacheableTrait;
use Cache;

/**
 * Class DriverRepository
 * @package xkamen06\pms\Model\Driver
 */
class DriverRepository implements DriverRepositoryInterface
{
    use CacheableTrait;

    /**
     * How long are data stored in cache
     * @var int
     */
    protected $cacheInterval = 10;

    /**
     * Cached tags
     * @var array
     */
    protected $cacheTags = ['DriverRepository', 'driver'];

    /**
     * Change driver type
     *
     * @param string $driver
     *
     * @return void
     */
    public function changeDriver(string $driver) : void
    {
        DB::table('driver')->where('driverid', '=', 1)->update([
            'type' => $driver
        ]);
    }

    /**
     * Get driver type
     *
     * @return string
     */
    public function getDriver() : string
    {
        $cacheKey = 'DriverRepository.changeDriver';

        $driverType = $this->cache($this->cacheTags, $cacheKey, $this->cacheInterval, function () {
            $driver = DB::table('driver')->where('driverid', '=', 1)->first();
            return $driver->type;
        });

        return $driverType;
    }
}