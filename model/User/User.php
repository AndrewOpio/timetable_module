<?php

namespace model\User;

use model\App;
use model\Auth\Environment;
use model\Auth\JWT;

class User extends App
{

    public function __login($username, $password)
    {
            $query = "SELECT * FROM `tbl_user` WHERE `username`='$username'";
            $query .= " AND `password`='$password'";
            $result = mysqli_work($query);
            if ($result->num_rows > 0) {

                (new Environment('.env'))->load();//loads from index folder

                $row = $result->fetch_assoc();
                extract($row);
                $payload = array(
                    "data" => array(
                        "iat" => time(),
                        "exp" => time() + (60),
                        "user_id" => $id,
                        "role_id" => $role_id,
                        "username" => $username,
                    )
                );

                $token = JWT::encode($payload, getenv('JWT_SECRET'));
                $this->Success = "Login successful";
                return $token;
            }


            $this->Error = "Enter correct username and password";
            return false;
    }
}

?>