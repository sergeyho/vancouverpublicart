<?php
require("../utils/auth.php");
// Check if the user is already logged in, if yes then redirect him to welcome page
// if(is_logged_in()){
//   header("location: welcome.php");
//   exit;
// }
// Include config file
require_once "../utils/config.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = $first_name = $last_name = "";
$username_err = $password_err = $confirm_password_err = $first_name_err = $last_name_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

  // Validate first name
  if(empty($_POST["first_name"])){
    $first_name_err = "Please enter a first name.";  
  } else {
    $first_name = $_POST["first_name"];
  }   

  // Validate last name
  if(empty($_POST["last_name"])){
    $last_name_err = "Please enter a last name.";  
  } else {
    $last_name = $_POST["last_name"];
  }
 
  // Validate username
  if(empty(trim($_POST["username"]))){
      $username_err = "Please enter a username.";
  } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
      $username_err = "Username can only contain letters, numbers, and underscores.";
  } else{
      // Prepare a select statement
      $sql = "SELECT id FROM users WHERE username = ?";
      
      if($stmt = mysqli_prepare($link, $sql)){
          // Bind variables to the prepared statement as parameters
          mysqli_stmt_bind_param($stmt, "s", $param_username);
          
          // Set parameters
          $param_username = trim($_POST["username"]);
          
          // Attempt to execute the prepared statement
          if(mysqli_stmt_execute($stmt)){
              /* store result */
              mysqli_stmt_store_result($stmt);
              
              if(mysqli_stmt_num_rows($stmt) == 1){
                  $username_err = "This username is already taken.";
              } else{
                  $username = trim($_POST["username"]);
              }
          } else{
              echo "Oops! Something went wrong. Please try again later.";
          }

          // Close statement
          mysqli_stmt_close($stmt);
      }
  }
    
  // Validate password
  if(empty(trim($_POST["password"]))){
      $password_err = "Please enter a password.";     
  } elseif(strlen(trim($_POST["password"])) < 6){
      $password_err = "Password must have atleast 6 characters.";
  } else{
      $password = trim($_POST["password"]);
  }
  
  // Validate confirm password
  if(empty(trim($_POST["confirm_password"]))){
      $confirm_password_err = "Please confirm password.";     
  } else{
      $confirm_password = trim($_POST["confirm_password"]);
      if(empty($password_err) && ($password != $confirm_password)){
          $confirm_password_err = "Password did not match.";
      }
  }
  
  // Check input errors before inserting in database
  if(empty($first_name_err) && empty($last_name_err) && empty($username_err) && empty($password_err) && empty($confirm_password_err)){
      
      // Prepare an insert statement
      $sql = "INSERT INTO users (username, password, first_name, last_name) VALUES (?, ?, ?, ?)";
        
      if($stmt = mysqli_prepare($link, $sql)){
          // Bind variables to the prepared statement as parameters
          mysqli_stmt_bind_param($stmt, "ssss", $param_username, $param_password, $param_first_name, $param_last_name);
          
          // Set parameters
          $param_username = $username;
          $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
          $param_first_name = $first_name;
          $param_last_name = $last_name;
          
          // Attempt to execute the prepared statement
          if(mysqli_stmt_execute($stmt)){
              // Redirect to login page
              header("location: index.php");
          } else{
              echo "Oops! Something went wrong. Please try again later.";
          }

          // Close statement
          mysqli_stmt_close($stmt);
      }
  }
  
  // Close connection
  mysqli_close($link);
}
require('../layouts/header.php')
?> 

<div id="register-intro" class="bg-image shadow-2-strong">
  <div class="mask d-flex align-items-center h-100" style="background-color: rgba(0, 0, 0, 0.8);">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-xl-5 col-md-8">
          <div class="card">
            <div class="card-body">
            <h5 class="card-title">Sign Up</h5>
            <p class="card-text">Please fill this form to create an account.</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
              <!-- 2 column grid layout with text inputs for the first and last names -->
              <div class="row mb-4">
                <div class="col">
                  <div class="form-outline">
                    <input type="text" id="first_name" name="first_name" class="form-control <?php echo (!empty($first_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $first_name; ?>" />
                    <label class="form-label" for="first_name">First name</label>
                    <span class="invalid-feedback"><?php echo $first_name_err; ?></span>
                  </div>
                </div>
                <div class="col">
                  <div class="form-outline">
                    <input type="text" id="last_name" name="last_name" class="form-control <?php echo (!empty($last_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $last_name; ?>" />
                    <label class="form-label" for="last_name">Last name</label>
                    <span class="invalid-feedback"><?php echo $last_name_err; ?></span>
                  </div>
                </div>
              </div>

              <!-- Email input -->
              <div class="form-outline mb-4">
                <input type="text" id="username" type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>" />
                <label class="form-label" for="username">Username</label>
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
              </div>

              <!-- Password input -->
              <div class="form-outline mb-4">
                <input type="password" id="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>" />
                <label class="form-label" for="password">Password</label>
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
              </div>
              <!-- Password input 2 -->
              <div class="form-outline mb-4">
                <input type="password" id="confirm_password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>" />
                <label class="form-label" for="confirm_password">Confirm Password</label>
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
              </div>

              <!-- Submit button -->
              <button type="submit" class="btn btn-primary btn-block mb-4">Sign up</button>

              <div class="text-center">
                <p>Already a member? <a href="login.php">Login here</a></p>
              </div>

            </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require('../layouts/footer.php') ?>