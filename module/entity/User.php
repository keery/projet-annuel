<?php
/**
 * Created by PhpStorm.
 * User: MSI-HASSAN
 * Date: 03/04/2018
 * Time: 14:29
 */

namespace Module\Entity;

use Module\Bdd\BaseSql;
use Module\Bdd\SqlManager;



class User extends BaseSql
{
    protected $id = null;
    protected $firstName;
    protected $lastName;
    protected $email;
    protected $role;
    protected $password;
    protected $token;
    protected $dateInserted;
    protected $dateUpdated;
    protected $status;


    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }
    public function getDateupdated()
    {
        return $this->dateUpdated;
    }
    public function getDateinserted()
    {
        return $this->dateInserted;
    }

    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setStatus($status)
    {
        $this->status = trim(($status));
    }
    public function setDateInserted(){
        $this->dateInserted = date("Ymd");
    }
    public function setDateUpdated(){
        $this->dateUpdated = date("Ymd");
    }


    /**
     * @param mixed $name
     */
    public function setFirstName($firstName)
    {
        $this->firstName = ucfirst(strtolower(trim($firstName)));
    }

    /**
     * @param mixed $fullName
     */
    public function setLastName($lastName)
    {
        $this->lastName = strtoupper(trim($lastName));
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = strtolower(trim($email));
    }

    /**
     * @param mixed $password
     */
    /**
     * @param mixed $password
     */
    public function setPassword($pwd)
    {
        $this->password = password_hash($pwd, PASSWORD_DEFAULT);
    }

    /**
     * @param mixed $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }



}