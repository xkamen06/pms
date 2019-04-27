<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: DriverRepositoryInterface.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace xkamen06\pms\Model\Driver;

/**
 * Interface DriverRepositoryInterface
 * @package xkamen06\pms\Model\Driver
 */
interface DriverRepositoryInterface
{
    /**
     * Change driver type
     *
     * @param string $driver
     *
     * @return void
     */
    public function changeDriver(string $driver): void;

    /**
     * Get driver type
     *
     * @return string
     */
    public function getDriver(): string;
}