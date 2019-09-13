<?php 
require_once '../models/db.php';
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
$db = new DB();
$mem_id = $_SESSION['mem_id'];
$name = $_SESSION['full_name'];
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
	 	<p id="name"><?php echo $name; ?></p>
	 	<button id="logout" onclick="window.location.href='logout.php'">logout</button>
	 </div>
	 <div id="posts">
	 	<?php include 'posts.php' ?>
	 	<button id="show_post_form">Post</button>
	 	<div id="create_post">
	 		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="form-horizontal"> 
	 			<textarea name="post_content" class="form-control" rows="3"></textarea>
	 			<input type="submit" value="create_post" name="action">
	 		</form>
	 	</div>
	 </div>
	 <div id="friends">
	 	<?php include 'friends.php' ?>
	 </div>
</body>
</html>
<?php 
	switch ($_POST['action']) {
		case 'create_post':
			if (isset($_POST['post_content'])) {
				$content = $_POST['post_content']; 
				$result = $db->insert('posts', "'$content', $mem_id");
				if ($result['status']) {
					$db->db_close();
					header("location:index.php");
				}
			} else {
				echo "Please enter post content";
			}
			break;
		case 'delete_post':
			if (isset($_POST['post_id'])) {
				$del_post_id = $_POST['post_id'];
				$result = $db->delete('posts', "id = $del_post_id");
				if ($result) {
					$db->db_close();
					header("location:index.php");
				}
			}else{
				echo "Can't delete";
			}
			break;
	}
 ?>

