<?php
class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    //Registering User
    public function register($data)
    {
        $this->db->query("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");

        //Bind values
        $this->db->bind(":name", $data['name'], null);
        $this->db->bind(":email", $data['email'], null);
        $this->db->bind(":password", $data['password'], null);

        //Execute query
        if ($this->db->execute()) {
            return true;
        }

        return false;
    }


    //Login User
    public function login($email, $password)
    {
        $this->db->query("SELECT * FROM users WHERE email = :email");
        $this->db->bind(':email', $email, null);

        $row = $this->db->single();
        $hashed_password = $row->password;

        if (password_verify($password, $hashed_password)) {
            return $row;
        } else {
            return false;
        }
    }

    public function fbLogin($email)
    {
        $this->db->query("SELECT * FROM users WHERE email = :email");
        $this->db->bind(':email', $email, null);

        $row = $this->db->single();
        return $row;
    }

    //Find user by email
    public function findUserByEmail($email)
    {
        $this->db->query("SELECT * FROM users WHERE email = :email");
        $this->db->bind(':email', $email, null);

        $row = $this->db->single();

        //Check row
        if ($this->db->rowCount() > 0) {
            return true;
        }

        return false;
    }

    public function changeUserPassword($password, $userId)
    {
        $hashedPass = password_hash($password, PASSWORD_DEFAULT);
        $this->db->query("UPDATE users SET password = :password WHERE users.id = :userId");
        $this->db->bind(":password", $hashedPass, null);
        $this->db->bind(":userId", $userId, null);
        if ($this->db->execute()) {
            return true;
        }

        return false;
    }

    public function resetUserPasswordByEmail($email, $password)
    {
        $this->db->query("UPDATE users SET password = :password WHERE users.email = :email");
        $hashedPass = password_hash($password, PASSWORD_DEFAULT);
        $this->db->bind(":email", $email, null);
        $this->db->bind(":password", $hashedPass, null);
        if ($this->db->execute()) {
            return true;
        }

        return false;
    }
}
