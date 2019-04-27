<?php
/**
 * Project: PMS - Project Management System
 *          Bacheolor Thesis - FIT VUT Brno
 * File: UserEloquent.php
 * Author: Zdenek Kamensky
 * Date: 2018
 */

namespace xkamen06\pms\Model\Eloquents;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use xkamen06\pms\Model\UserInterface;

/**
 * Class UserEloquent
 * @package xkamen06\pms\Model\Eloquents
 */
class UserEloquent extends Model implements UserInterface
{
    use Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Fillable
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'firstname',
        'surname',
        'email',
        'role',
        'created_at',
        'updated_at'
    ];

    /**
     * Gets user id
     *
     * @return int
     */
    public function getUserId() : int
    {
        return $this->id;
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
        return $this->created_at;
    }

    /**
     * Gets updated_at
     *
     * @return string|null
     */
    public function getUpdatedAt() : ?string
    {
        return $this->updated_at;
    }

    /**
     * Gets added at
     *
     * @return null|string
     */
    public function getAddedAt() : ?string
    {
        if ($this->created_at) {
            $date =  substr($this->created_at, 0, 10);
            $year = substr($date, 0, 4);
            $month = substr($date, 5, 2);
            $day = substr($date, 8, 2);
            return $day . '.' . $month . '.' . $year;
        }
        return null;
    }
}