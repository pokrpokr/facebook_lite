<?php
    class DB {
        protected $conn;
        function _constrct(){
            $doc = new DOMDocument();
            $doc->load('/config/config.xml');
            $db = $doc->getElementsByTagName("db");
            $username = $db->getElementsByTagName("user_name");
            $password = $db->getElementsByTagName("pass_word");
            $servername = $db->getElementsByTagName("server_name");
            $servicename = $db->getElementsByTagName("service_name");
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