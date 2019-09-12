<?php 
require '../models/db.php';
session_start();
if (empty($_SESSION['mem_id'])) {
	header("location:login.php");
}
$temp_id = $_SESSION['mem_id'];
$temp_name = $_SESSION['full_name'];
session_destroy();
session_start();
$_SESSION['mem_id'] = $temp_id;
$_SESSION['full_name'] = $temp_name;
var_dump($_SESSION['full_name']);
ob_start();
?>
<html>
<head>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" integrity="sha384-xrRywqdh3PHs8keKZN+8zzc5TX0GRTLCcmivcbNJWm2rs5C8PRhcEn3czEjhAO9o" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="/node_modules/bootstrap/dist/css/bootstrap.min.css" charset="utf-8">
  <title>
    Welcome Facebooklite
  </title>
</head>
<body>
	 <p>Welcome Facebooklite</p>
	 <div id="info">
	 	<label id="mem_name"><?php $name ?></label>
	 	<button id="logout" onclick="window.location.href='logout.php'">logout</button>
	 </div>
	 <div id="posts">
	 	<?php include 'posts.php' ?>
	 </div>
	 <div id="friends">
	 	<?php include 'friends.php' ?>
	 </div>
</body>
</html>
<?php 
	$db = new DB();
	$id = $_SESSION['mem_id'];
	$name = $_SESSION['full_name'];
	// $posts = $db->select('posts', "id, content, members_id", "members_id = '$id'");

	function create_post($db){

	}
?>
