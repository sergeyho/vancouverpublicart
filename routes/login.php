<?php
// Initialize the session
session_start();
require_once "../utils/auth.php";
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(is_logged_in()){
    header("location: welcome.php");
    exit;
}
 
// Include config file
require_once "../utils/config.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password, first_name, last_name, is_admin FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result(
                      $stmt, 
                      $id, 
                      $username, 
                      $hashed_password, 
                      $first_name,
                      $last_name,
                      $is_admin
                    );
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION['first_name'] = $first_name;
                            $_SESSION['last_name'] = $last_name;
                            $_SESSION['is_admin'] = $is_admin;                            
                            
                            // Redirect user to welcome page
                            header("location: index.php");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
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
<div id="login-intro" class="bg-image shadow-2-strong">
  <div class="mask d-flex align-items-center h-100" style="background-color: rgba(0, 0, 0, 0.8);">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-xl-5 col-md-8">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Login</h5>
              <p class="card-text">Please fill in your credentials to login.</p>
              <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <!-- Email input -->
                <div class="form-outline mb-4">
                  <input type="text" name="username" id='username' class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                  <label class="form-label" for="username">Username</label>
                  <span class="invalid-feedback"><?php echo $username_err; ?></span>
                  <!-- <input type="email" id="form2Example1" class="form-control" /> -->
                </div>

                <!-- Password input -->
                <div class="form-outline mb-4">
                  <input type="password" name="password" id="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                  <label class="form-label" for="password">Password</label>
                  <span class="invalid-feedback"><?php echo $password_err; ?></span>
                </div>

                <?php 
                  if(!empty($login_err)){
                      echo '<div class="alert alert-danger">' . $login_err . '</div>';
                  }        
                ?>

                <!-- Submit button -->
                <button type="submit" class="btn btn-primary btn-block mb-4">Sign in</button>

                <!-- Register buttons -->
                <div class="text-center">
                  <p>Not a member? <a href="register.php">Sign up now</a></p>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
  require('../layouts/footer.php')
?>