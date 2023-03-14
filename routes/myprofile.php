<?php
  require('../layouts/header.php');
  require_once "../utils/config.php";
  $SITES_PER_PAGE = 25;

  $current_page = isset($_GET['page']) && ceil($_GET['page']) >= 1 ? ceil($_GET['page']) : 1;

  $id = $_SESSION["id"];
  $query = "SELECT * FROM users WHERE id = $id"; 

  $result = mysqli_query($link, $query);

  $user_data = mysqli_fetch_assoc($result);

?>

<div id="sites-intro" class="bg-image shadow-2-strong" style = "height: 4rem;">
  <div class="mask" style="background-color: rgba(0, 0, 0, 0.8); ">
    <div class="container d-flex align-items-center justify-content-center text-center h-100">
      <div class="text-white">
      </div>
    </div>
</div>
</div>



<div class="container emp-profile">
            
    <div class="row">
        <div class="col-md-6">
            <div class="profile-img">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS52y5aInsxSm31CvHOFHWujqUx_wWTS9iM6s7BAm21oEN_RiGoog" alt=""/>
                <div class="file btn btn-lg btn-primary">
                    Change Photo
                    <input type="file" name="file"/>
                </div>
            </div>
        </div>
        
        <div class="col-md-6" style="margin-top:3rem;">
            <div class="profile-head">
                        <h5>
                            <?php  echo $user_data['first_name'] . " " .$user_data['last_name'];  ?>
                        </h5>
                        <h6>
                            <?php echo "status: "; echo $user_data['is_admin'] == 1 ? "Admin" : "User";  ?>
                        </h6>
                        <p class="proile-rating">joined platform : <?php  echo $user_data['created_at'] ?> </p>
                        <a class="btn btn-primary" href="edit-profile.php" role="button">edit profile</a>
            </div>
        </div>


    <div class="d-flex flex-column mb-3" style="padding-left: 5rem;padding-right: 5rem; margin-top: 3rem;">
        <div class="d-flex flex-row mb-2" style="justify-content:space-between"><label>User Id</label><?php  echo $user_data['id'] ?></div>
        <div class="d-flex flex-row mb-2"style="justify-content:space-between"><label>Username</label><?php  echo $user_data['username'] ?></div>
        <div class="d-flex flex-row mb-2"style="justify-content:space-between"><label>something</label><p>something</p></div>
    </div>  
            
    </div>


<style>body{}
    
.emp-profile{
    padding: 3%;
    margin-top: 3%;
    margin-bottom: 3%;
    border-radius: 0.5rem;
    background:#F8F8FF;

    border-color: #0062cc;

    border: 2px solid;
}
.profile-img{
    text-align: center;
}

#personal-info{
    margin-top: 2rem;
}
.profile-img img{
    width: 70%;
    height: 100%;
}
.profile-img .file {
    position: relative;
    overflow: hidden;
    margin-top: -20%;
    width: 70%;
    border: none;
    border-radius: 0;
    font-size: 15px;
    background: #212529b8;
}
.profile-img .file input {
    position: absolute;
    opacity: 0;
    right: 0;
    top: 0;
}
.profile-head h5{
    color: #333;
}
.profile-head h6{
    color: #0062cc;
}
.profile-edit-btn{
    border: none;
    border-radius: 1.5rem;
    width: 7rem;
    padding: 3px;
    font-weight: 400;
    font-size: 20px;
    color: #6c757d;
    cursor: pointer;
}
.proile-rating{
    font-size: 12px;
    color: #818182;
    margin-top: 5%;
}
.proile-rating span{
    color: #495057;
    font-size: 15px;
    font-weight: 600;
}
.profile-head .nav-tabs{
    margin-bottom:5%;
}
.profile-head .nav-tabs .nav-link{
    font-weight:600;
    border: none;
    background-color: transparent; 
}
.profile-head .nav-tabs .nav-link.active{
    border: none;
    border-bottom:2px solid #0062cc;
}
.profile-work{
    padding: 14%;
    margin-top: -15%;
}
.profile-work p{
    font-size: 12px;
    color: #818182;
    font-weight: 600;
    margin-top: 10%;
}
.profile-work a{
    text-decoration: none;
    color: #495057;
    font-weight: 600;
    font-size: 14px;
}
.profile-work ul{
    list-style: none;
}
.profile-tab label{
    font-weight: 600;
}
.profile-tab p{
    font-weight: 600;
    color: #0062cc;
}</style>

<?php
  require('../layouts/footer.php')
?>