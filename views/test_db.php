<?php 
require '../models/db.php';
// Test DB API
$db = new DB();
$time = date('Y-m-d', time());
$status_arr = array("offline", "online", "cloaking");
$visibility_level_arr = array("public", "friend_only", "self_only");
$gender_arr = array("male", "female", "other");
$data = "'test1@gmail.com', 'chai', to_date('1993-09-01', 'yyyy-mm-dd'), '$gender_arr[0]', '$status_arr[1]', 'Melbourne', '$visibility_level_arr[0]'";
$condition = "email = 'test@gmail.com'";
// $db->insert('members', $data);
// $db->update('members', "full_name = 'Kai'", "email = 'test1@gmail.com'");
// $a = $db->select('members', 'email, full_name, update_at', null, "create_at");
$db->select('friends INNER JOIN members ON friends.members_id = members.id', "members.id, members.full_name", "members.id = firends.members_id OR members.id = friends.friend_id");
var_dump($a);
// if ($a['rows'] > 0) {
// 	echo "<table border=\"1\">\n";
//    echo "<tr>\n";
//    foreach ($a['results'] as $key => $val) {
//       echo "<th>$key</th>\n";
//    }
//    echo "</tr>\n";

//    for ($i = 0; $i < $a['rows']; $i++) {
//       echo "<tr>\n";
//       foreach ($a['results'] as $data) {
//          echo "<td>$data[$i]</td>\n";
//       }
//       echo "</tr>\n";
//    }
//    echo "</table>\n";
// }
// $db->delete('members', "email = 'test2@gmail.com'");
$db->db_close();
 ?>