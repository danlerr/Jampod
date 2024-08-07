<?php
class EUser {

    //attributes 
    /**
    * @var int|null $user_id The ID of the user. Auto-incremented by the database.
    */
    private  $username; 
    private  $email; 
    private  $password; 
    private  $user_id;
    private   $balance;
    private $is_admin = false;
    protected $ban = false;

    //constructor

    public function __construct($email, $password, $username)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $this->username = $username;
        $this->email = $email;
        $this->password = $hashedPassword;
        $this->balance = 0.0;
    }

    //methods
    /**
     * Get the value of class name
     *
     * @return string'EUser'
     */
    public static function getEClass(){
        return 'EUser';
    }

    /**
     * Get the value of password
     *
     * @return string $password
     */
    public function getPassword(){
        return $this->password;
    }

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
    public function getId(){
        return $this->user_id;
    }

    /**
     * Set the value of balance
     *
     * @param $balance
     */
    public function setBalance($balance)
    {
        $this->balance = $balance;
    }

    /**
     * Set the value of user_id
     *
     * @param $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }
    public function isAdmin()
    {
        return $this->is_admin;
    }

    public function isBanned()
    {
        return $this->ban;

    }
    public function getUsername()
    {
        return $this->username;
    }

    public function getEmail()
    {
        return $this->email;
    }
    
    public function setUsername( $username )
    {
        $this->username = $username;
    }
   
    public function setEmail( $email )
    {
        $this->email = $email;
    }
   
    public function setPassword( $password )
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $this->password = $hashedPassword;
    }

    public function setHashedPassword($hashedPassword){
        $this->password = $hashedPassword;
    }

    public function setAdmin(bool $admin) {
        $this->is_admin = $admin;
    }
    
    public function setBan(bool $ban) {
        $this->ban = $ban;
    }
}

