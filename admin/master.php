<?php

    require "db_config.php";
    require "db_connect.php";

    class master{
        public $link;

        public function openDB(){
            $conn = new Database(HOST, USER, PASS, DB);
            $this->link = $conn->connect();
            if(!$this->link){
                echo "Error connecting database...";
            }
            mysqli_select_db($this->link, DB);
        }

        public function closeDB(){
            $this->link->close();
        }

        public function doRegister($uname, $pass, $fname, $lname, $dob, $addr, $email, $mob){
            $this->openDB();
            $msg = "";
            $dobf = date('y-m-d', strtotime($dob));
            $sql = "INSERT INTO registrations(uname,pass,fname,lname,dob,addr,email,mob) VALUES('$uname','$pass','$fname','$lname','$dobf','$addr','$email','$mob');";
            if(mysqli_query($this->link, $sql)){
                $msg = "done";
            }
            else{
                $msg = "fail";
            }
            $this->closeDB();
            return $msg;
        }
    }

?>
