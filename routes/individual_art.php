<?php
  require('../layouts/header.php');
  require_once "../utils/config.php";
  $SITES_PER_PAGE = 25;

  $current_page = isset($_GET['page']) && ceil($_GET['page']) >= 1 ? ceil($_GET['page']) : 1;
  $art_id = $_GET['artdata'];

  $query = "SELECT * FROM public_art WHERE RegistryID = $art_id"; 

  $result = mysqli_query($link, $query);

  $art_data = mysqli_fetch_assoc($result);

?>

<div id="sites-intro" class="bg-image shadow-2-strong" style = "height: 4rem;">
  <div class="mask" style="background-color: rgba(0, 0, 0, 0.8); ">
    <div class="container d-flex align-items-center justify-content-center text-center h-100">
      <div class="text-white">
      </div>
    </div>
</div>
</div>


<div class="row">
<div class="col-md-7" style="margin-top:2rem;">

    <div class="d-flex flex-column mb-3">
         <div class="p-2">
            <h1> Public Art № <?php echo $art_data['RegistryID']?> </h1>
        </div>
        <div class="p-2">
            <img src="<?php echo $art_data['PhotoURL']; ?>" class="img-fluid" width="1000px" height = "400px"/>
        </div>
        <div class="p-2"><h3> Description Of Work </h3><?php echo $art_data['DescriptionOfwork']?></div>
        <div class="p-2"><h3> Artist Statement </h3><?php echo $art_data['ArtistProjectStatement']?></div>
    </div>

  </div>

  <div class="col-md-3" style = "margin-left:10rem;margin-top:7rem;">
  <h2> More Details: </h2>
  <ul class="list-group list-group-light">
  <li class="list-group-item"><strong>Year of Installation:</strong> <?php echo $art_data['YearOfInstallation']?></li>
  <li class="list-group-item"><strong>Type:</strong> <?php echo $art_data['Type']?></li>
  <li class="list-group-item"><strong>Primary Material:</strong> <?php echo $art_data['PrimaryMaterial']?></li>
  <li class="list-group-item"><strong>Ownership:</strong> <?php echo $art_data['Ownership']?></li>
  <li class="list-group-item"><strong>Status:</strong> <?php echo $art_data['Status']?></li>
  <li class="list-group-item"><strong>Site Name:</strong> <?php echo $art_data['SiteName']?></li>
  <li class="list-group-item"><strong>Location On Site:</strong>  <?php echo $art_data['LocationOnsite']?></li>
  <li class="list-group-item"></li>
  <li class="list-group-item"></li>
  <li class="list-group-item"></li>
  <li class="list-group-item"></li>
  <li class="list-group-item"></li>
</ul>
  </div>
</div>






<?php
  require('../layouts/footer.php')
?>