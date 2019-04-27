<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: UserInterface.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace xkamen06\pms\Model;

/**
 * Interface UserInterface
 * @package xkamen06\pms\Model
 */
interface UserInterface
{
    /**
     * Gets user id
     *
     * @return int
     */
    public function getUserId() : int;

    /**
     * Gets firstname
     *
     * @return string
     */
    public function getFirstname() : string;

    /**
     * Gets surname
     *
     * @return string
     */
    public function getSurname() : string;

    /**
     * Gets email
     *
     * @return string
     */
    public function getEmail() : string;

    /**
     * Gets role
     *
     * @return string
     */
    public function getRole() : string;

    /**
     * Gets created_at
     *
     * @return string|null
     */
    public function getCreatedAt() : ?string;

    /**
     * Gets updated_at
     *
     * @return string|null
     */
    public function getUpdatedAt() : ?string;

    /**
     * Gets added at
     *
     * @return null|string
     */
    public function getAddedAt() : ?string;
}