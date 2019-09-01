<?php
    class DB {
        protected $conn;
        function _constrct(){
            $username = 's3766925';
            $password = '9394azpokr';
            $servername = 'talsprddb01.int.its.rmit.edu.au';
            $servicename = 'CSAMPR1.ITS.RMIT.EDU.AU';
            $connection = $servername."/".$servicename;

            $conn = oci_connect($username, $password, $connection);
            if(!$conn)
            {
                $e = oci_error();
                trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
            }
            else
            {
                $this->conn = $conn;
            }
        }
        function select(){
            
        }

        function db_close($conn){
            oci_close($conn);
        }

    }
    
?>