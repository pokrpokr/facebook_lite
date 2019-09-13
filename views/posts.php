<?php 
require_once '../models/db.php';
if (empty($_SESSION['mem_id'])) {
    header("location:login.php");
}
$temp_id = $_SESSION['mem_id'];
$temp_name = $_SESSION['full_name'];
session_destroy();
session_start();
$_SESSION['mem_id'] = $temp_id;
$_SESSION['full_name'] = $temp_name;

$db = new DB();
$posts = $db->select("posts", "id, content", "members_id = $temp_id", "create_at");
echo "<table calss='table'>\n";
foreach ($posts["results"] as $data) {
	$post_id = $data["ID"];
	$likes = $db->select('likes', 'COUNT(*)', "posts_id = $post_id");
	var_dump($likes);
	echo "<tr id='".$data["ID"]."'><td>".$data["CONTENT"]."</td><td><form method='post' action='index.php'><input type='hidden' name='post_id' value='".$data["ID"]."'><input type='radio' name='like' value='like'><input type='submit' value='delete_post' name='action'></form></td><td><B>Likes: </B>".$likes['results']["COUNT(*)"]."</td></tr>\n";
}
echo "</table>\n";

?>
