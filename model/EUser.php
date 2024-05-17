<?php
class EUser extends EPerson{

    //attributes 
    /**
    * @var int|null $user_id The ID of the user. Auto-incremented by the database.
    */
    private $user_id;

    private  float $balance;

    //constructor

    public function __construct($name, $surname, $email, $password, $username)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->user_id = null;
        $this->balance = 0;
    }

    //methods

    /**
     * Get the value of balance
     *
     * @return $balance
     */
    public function getBalance(){
        return $this->balance;
    }

    /**
     * Get the value of user_id
     *
     * @return $user_id
     */
    public function getUserId(){
        return $this->user_id;
    }
}
