<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: BaseRepositoryTest.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace PMS\Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;

/**
 * Class BaseRepositoryTest
 * @package PMS\Tests\Unit
 */
abstract class BaseRepositoryTest extends TestCase
{
    /**
     * Sets up tests.
     */
    protected function setUp()
    {
        parent::setUp();
        DB::beginTransaction();
        if (! $this->isRepositoryHelperInstanceOfRepository()) {
            $this->markTestSkipped('all tests in this file are invactive!');
        }
    }

    /**
     * Tear down.
     */
    protected function tearDown()
    {
        DB::rollback();
        parent::tearDown();
    }

    /**
     * Returns if helper returns instance of repository
     *
     * @return bool
     */
    abstract public function isRepositoryHelperInstanceOfRepository(): bool;

    /**
     * Get test object
     *
     * @return mixed
     */
    abstract public function getTestObject();
}