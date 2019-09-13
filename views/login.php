<?php 
  session_start();
  if (isset($_SESSION['mem_id'])) {
    header("location:index.php");
  }
  session_destroy();
  session_start();
  ob_start();
?>
<!DOCTYPE html >
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
  <div></div>  
  <div class = "container">
    <div class="row ">
      <div class="col-xs-6 col-md-8 center-block"> 
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="form-horizontal">
          <div class="form-group">
            <label for="inputEmail">Email address</label>
            <input type="email" class="form-control" id="inputEmail" placeholder="Email" name="mem_email">
          </div>
          <div class="form-group">
            <label for="inputPassword">Password</label>
            <input type="password" class="form-control" id="inputPassword" placeholder="Password" name="mem_pass">
            <input type="password" class="form-control signin_param" id="confirmPassword" placeholder="Confirm Password" name="con_mem_pass">
          </div>
          <div class="form-group signin_param">
            <label for="inputFullName">Full Name</label>
            <input type="text" class="form-control signin_param" id="inputFullName" placeholder="FUll Name" name="full_name">
          </div>
          <div class="form-group signin_param">
            <label>Birth</label>
            <div class="row">
              <div class="col">
                <div class="form-group">

                  <select class="form-control" name="selectday">
                    <?php
                    for($i=1; $i<=31; $i++){
                      if ($i < 10) {
                        echo '<option value="'.'0'.$i .'">'. $i .'</option>';
                      }else{
                        echo '<option value="'.$i .'">'. $i .'</option>';
                      }
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  <select class="form-control" name="selectmonth">
                    <?php
                    echo '<option value="01">January</option>';
                    echo '<option value="02">February</option>';
                    echo '<option value="03">March</option>';
                    echo '<option value="04">April</option>';
                    echo '<option value="05">May</option>';
                    echo '<option value="06">June</option>';
                    echo '<option value="07">July</option>';
                    echo '<option value="08">August</option>';
                    echo '<option value="09">September</option>';
                    echo '<option value="10">October</option>';
                    echo '<option value="11">November</option>';
                    echo '<option value="12">December</option>';
                    ?>
                  </select>
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  <select name="selectyear" class="form-control">
                    <?php
                    for($i=2018; $i>=1900; $i--){
                      echo '<option value="'. $i .'">'. $i .'</option>';
                    }
                    ?>
                  </select>
                </div>
              </div>
          </div>
          <div class="form-group signin_param">
            <label for="inputLocation">Location</label>
            <input type="text" class="form-control signin_param" id="inputLocation" placeholder="City" name="location">
          </div>
          <div class="row signin_param ">
            <div class="radio col-md-1">
              <label>
                Male
                <input type="radio" name="gender" id="op_male" value="male" checked>
              </label>
            </div>
            <div class="radio col-md-1">
              <label>
                Female
                <input type="radio" name="gender" id="op_female" value="female">
              </label>
            </div>
            <div class="col-md-1">
              <label>
                Other
                <input type="radio" name="gender" id="op_other" value="other">
              </label>
            </div>
          </div>
          <input type="submit" value="log_in" name="action"><input type="submit" value="sign_up" name="action">
        </form>
      </div>
    </div>
  </div>
</body>
</html>
<?php
require_once '../models/db.php';
$db = new DB();
$visibility_level_arr = array("public", "friend_only", "self_only");
$status_arr = array("offline", "online", "cloaking");
$email = $name = $password = $con_password = $gender = $location = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  switch ($_POST["action"]) {
    case "log_in":
      if (empty($_POST["mem_email"])) { 
        $passErr = "Please enter the password!";
        break; 
      }
      if (empty($_POST["mem_pass"])) { 
        $passErr = "Please enter the password!";
        break; 
      }
      $email = test_input($_POST["mem_email"]);
      $password = test_input($_POST["mem_pass"]);

      $result = $db->select('members', "id, password, full_name", "email = '$email'");
        if(isset($result["rows"])){
            $verify_pass = $result["results"][0]["PASSWORD"];
            if (hash_equals($verify_pass, crypt($password, 'password'))){
              $_SESSION['mem_id'] = $result["results"][0]["ID"];
              $_SESSION['full_name'] = $result["results"][0]["FULL_NAME"];
              $db->db_close();
              header("location:index.php");
            }else{
              $passErr = "Wrong Password";
              break;
            }
        }else{
            $emailErr = "Wrong Emali Name";
            break;
        }
      break;
    case "sign_up":
      $name = test_input($_POST["full_name"]);
      $email = test_input($_POST["mem_email"]);
      $password = test_input($_POST["mem_pass"]);
      $con_password = test_input($_POST["con_mem_pass"]);
      $location = test_input($_POST["location"]);
      $gender = test_input($_POST["gender"]);
      $birth_day = test_input($_POST["selectday"]);
      $birth_mon = test_input($_POST["selectmonth"]);
      $birth_year = test_input($_POST["selectyear"]);
      $birth = $birth_year."-".$birth_mon."-".$birth_day;

      $password = crypt($password, 'password');
      if (hash_equals($password, crypt($con_password, 'password'))){
        $data = "'$password', '$email', '$name', to_date('$birth', 'yyyy-mm-dd'), '$gender', '$status_arr[1]', '$location', '$visibility_level_arr[0]'";
        $results = $db->insert('members', $data);
        if($results["status"]){
          $_SESSION['mem_id'] = $results["id"];
          $_SESSION['full_name'] = $name;
          $db->db_close();
          header("location:index.php");
        }
      }else{
        echo "Running Here";
        echo $password."\n".crypt($con_password);
      }

      break;
  }
}

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

?>




