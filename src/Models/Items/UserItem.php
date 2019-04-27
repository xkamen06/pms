<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: UserItem.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace xkamen06\pms\Model\Items;

use Illuminate\Notifications\Notifiable;
use xkamen06\pms\Model\UserInterface;
use Illuminate\Support\Facades\DB;

/**
 * Class UserItem
 * @package xkamen06\pms\Model\Items
 */
class UserItem implements UserInterface
{
    use Notifiable;

    /**
     * @var string Database table name
     */
    protected $table = 'users';

    /**
     * @var int|null Id of user
     */
    protected $userId;

    /**
     * @var string Firstname of user
     */
    protected $firstname;

    /**
     * @var string Surname of user
     */
    protected $surname;

    /**
     * @var string Email of user
     */
    protected $email;

    /**
     * @var string User role
     */
    protected $role;

    /**
     * @var string|null Created at
     */
    protected $createdAt;

    /**
     * @var string|null Updated at
     */
    protected $updatedAt;

    /**
     * UserItem constructor.
     *
     * @param null $row
     */
    public function __construct($row = null)
    {
        if (isset($row['id'])) {
            $this->userId = $row['id'];
        }
        $this->firstname = $row['firstname'];
        $this->surname = $row['surname'];
        $this->email = $row['email'];
        $this->role = $row['role'];
        if (isset($row['created_at'])) {
            $this->createdAt = $row['created_at'];
        }
        if (isset($row['updated_at'])) {
            $this->updatedAt = $row['updated_at'];
        }
    }

    /**
     * Save user item
     */
    public function save()
    {
        DB::table($this->table)->insert([
            'firstname' => $this->firstname,
            'surname' => $this->surname,
            'email' => $this->email,
            'role' => $this->role,
        ]);
    }

    /**
     * Gets user id
     *
     * @return int
     */
    public function getUserId() : int
    {
        return $this->userId;
    }

    /**
     * Gets firstname
     *
     * @return string
     */
    public function getFirstname() : string
    {
        return $this->firstname;
    }

    /**
     * Gets surname
     *
     * @return string
     */
    public function getSurname() : string
    {
        return $this->surname;
    }

    /**
     * Gets email
     *
     * @return string
     */
    public function getEmail() : string
    {
        return $this->email;
    }

    /**
     * Gets role
     *
     * @return string
     */
    public function getRole() : string
    {
        return $this->role;
    }

    /**
     * Gets created_at
     *
     * @return string|null
     */
    public function getCreatedAt() : ?string
    {
        return $this->createdAt;
    }

    /**
     * Gets updated_at
     *
     * @return string|null
     */
    public function getUpdatedAt() : ?string
    {
        return $this->updatedAt;
    }

    /**
     * Gets added at
     *
     * @return null|string
     */
    public function getAddedAt() : ?string
    {
        if ($this->createdAt) {
            $date =  substr($this->createdAt, 0, 10);
            $year = substr($date, 0, 4);
            $month = substr($date, 5, 2);
            $day = substr($date, 8, 2);
            return $day . '.' . $month . '.' . $year;
        }
        return null;
    }
}