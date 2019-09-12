<?php
    class DB {
        protected $conn;
        function __construct(){
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

        function update($table_name, $set_cloumns,$ser_condition){
            if (empty($set_cloumns) || empty($ser_condition)){
                return false;
            } else {
                $update_at = date("Y-m-d h:i:s");
                $sql = "UPDATE $table_name SET $set_cloumns, update_at = to_timestamp('$update_at', 'yyyy-mm-dd hh24:mi:ss:ff2') WHERE $ser_condition";
            }
            $stid = oci_parse($this->conn, $sql);
            if (oci_execute($stid)){
                return true;
            }else{
                $e = oci_error($stid); 
                echo htmlentities($e['message']);
                echo "<pre>";
                echo htmlentities($e['sqltext']);
                printf("\n%".($e['offset']+1)."s", "^");
                echo "</pre>";
            }
        }

        function delete($table_name, $condition){
            if (empty($condition)){
                return false;
            } else {
                $delete_at = date("Y-m-d h:i:s");
                $sql = "UPDATE $table_name SET delete_at = to_timestamp('$delete_at', 'yyyy-mm-dd hh24:mi:ss:ff2') WHERE $condition";
            }
            $stid = oci_parse($this->conn, $sql);
            if (oci_execute($stid)){
                return true;
            }else{
                $e = oci_error($stid); 
                echo htmlentities($e['message']);
                echo "<pre>";
                echo htmlentities($e['sqltext']);
                printf("\n%".($e['offset']+1)."s", "^");
                echo "</pre>";
            }
        }

        function select($table_name, $cloumns = null, $condition = null, $order = null){
            $cloumns = empty($cloumns) ? '*': $cloumns;
            if(empty($condition)){
                $sql = "SELECT $cloumns FROM $table_name WHERE delete_at is null";
            } else {
                $sql = "SELECT $cloumns FROM $table_name WHERE $condition AND delete_at is null";
            }
            if(isset($order)){
                $sql = $sql." ORDER BY $order";
            }
            $stid = oci_parse($this->conn, $sql);
            
            if (oci_execute($stid)){
                if (($nrows = oci_fetch_all($stid, $results, null, null, OCI_FETCHSTATEMENT_BY_ROW)) != false) {
                    oci_free_statement($stid);
                    return array("rows"=>$nrows, "results"=>$results);
                } else {
                    return array("rows"=>null, "results"=>null);
                }
            }else{
                $e = oci_error($stid);
                echo htmlentities($e['message']);
                echo "<pre>";
                echo htmlentities($e['sqltext']);
                printf("\n%".($e['offset']+1)."s", "^");
                echo "</pre>";
            }
        }

        function join_select($table_name, $joint_table, $joint_key, $cloumns = null, $condition = null, $order = null){
            $cloumns = empty($cloumns) ? '*': $cloumns;
            if(empty($condition)){
                $sql = "SELECT $cloumns FROM $table_name JOIN $joint_table ON $stable_name.id = $joint_table.$joint_key WHERE $table_name.delete_at is null";
            }else{
                $sql = "SELECT $cloumns FROM $table_name JOIN $joint_table ON $stable_name.id = $joint_table.$joint_key WHERE $condition AND $table_name.delete_at is null";
            }
            if(isset($order)){
                $sql = $sql." ORDER BY $order";
            }
            $stid = oci_parse($this->conn, $sql);

            if (oci_execute($stid)){
                if (($nrows = oci_fetch_all($stid, $results, null, null, OCI_FETCHSTATEMENT_BY_ROW)) != false) {
                    oci_free_statement($stid);
                    return array("rows"=>$nrows, "results"=>$results);
                } else {
                    return array("rows"=>null, "results"=>null);
                }
            }else{
                $e = oci_error($stid);
                echo htmlentities($e['message']);
                echo "<pre>";
                echo htmlentities($e['sqltext']);
                printf("\n%".($e['offset']+1)."s", "^");
                echo "</pre>";
            }
        }

        function insert($table_name, $data){
            $count = oci_parse($this->conn, "SELECT COUNT(*) AS NUM FROM $table_name");
            oci_define_by_name($count, 'NUM', $num);
            oci_execute($count);
            if(oci_fetch($count)){
                $num += 1;
            } else {
                return false;
            }
            oci_free_statement($count);
            $create_at = date("Y-m-d h:i:s");
            $sql = "INSERT INTO $table_name VALUES ($num, $data, to_timestamp('$create_at', 'yyyy-mm-dd hh24:mi:ss:ff2'), to_timestamp('$create_at', 'yyyy-mm-dd hh24:mi:ss:ff2'), null)";
            $stid = oci_parse($this->conn, $sql);
            if (oci_execute($stid)){
                return array("status"=>true, "id"=>$num);
            }else{
                $e = oci_error($stid); 
                echo htmlentities($e['message']);
                echo "<pre>";
                echo htmlentities($e['sqltext']);
                printf("\n%".($e['offset']+1)."s", "^");
                echo "</pre>";
            }
        }

        function db_close(){
            oci_close($this->conn);
        }

    }
    
?>