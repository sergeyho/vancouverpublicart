<?php
  require('../layouts/header.php');
  require_once "../utils/config.php";
  $SITES_PER_PAGE = 25;

  $current_page = isset($_GET['page']) && ceil($_GET['page']) >= 1 ? ceil($_GET['page']) : 1;
?>

<div id="sites-intro" class="bg-image shadow-2-strong">
  <div class="mask" style="background-color: rgba(0, 0, 0, 0.8);">
    <div class="container d-flex align-items-center justify-content-center text-center h-100">
      <div class="text-white">
        <h1>Vancouver's Public Art Sites</h1>
      </div>
    </div>
  </div>
</div>

<div id='sites-container' class='p-4'>
  <div class='row'>
    <div class='col-12 col-md-6 col-lg-4'>
      <div class="input-group">
        <div class="form-outline">
          <input id="search-focus" type="search" id="form1" class="form-control" />
          <label class="form-label" for="form1">Search</label>
        </div>
        <button type="button" class="btn btn-primary">
          <i class="fas fa-search"></i>
        </button>
      </div>
    </div>
  </div>
  <div class='row mt-4'>
    <?php 
      $sql = "SELECT count(RegistryID) FROM public_art;";
      $sql .= "SELECT RegistryID, SiteName, ArtistProjectStatement, PhotoURL FROM public_art" 
        . " LIMIT $SITES_PER_PAGE"
        . " OFFSET " . ($current_page - 1) * $SITES_PER_PAGE;

      if (mysqli_multi_query($link, $sql)) {
        // store first result set
        if ($result = mysqli_store_result($link)) {
          $count = mysqli_fetch_row($result)[0];
          mysqli_free_result($result);
        }

        $pages_count = ceil($count / $SITES_PER_PAGE);
        $enable_previous = $current_page > 1 ? '' : 'disabled';
        $enable_next = $current_page < $pages_count ? '' : 'disabled';
        $previous_page = $current_page - 1;
        $next_page = $current_page + 1;
        
        // Create pagination
        echo '<nav class="mb-4 p-0"><ul class="pagination">';
        echo "
          <li class='page-item $enable_previous'>
            <a class='page-link' href='sites.php?page=$previous_page'>Previous</a>
          </li>
        ";
        for($i = 1; $i < 4; $i++) {
          $active = $current_page == $i ? 'active' : '';
          echo "
            <li class='page-item $active'>
              <a class='page-link' href='sites.php?page=$i'>${i}</a>
            </li>
          ";
        }
        if($pages_count > 6 && $current_page > 4) {
          echo "
            <li class='page-item disabled'>
              <a class='page-link'>...</a>
            </li>
          ";
        }
        if($current_page > 3 && $current_page < $pages_count - 2) {
          echo "
            <li class='page-item active'>
              <a class='page-link'>{$current_page}</a>
            </li>
          ";
        }
        if($pages_count > 6 && $current_page < $pages_count - 3) {
          echo "
            <li class='page-item disabled'>
              <a class='page-link'>...</a>
            </li>
          ";
        }
        for($i = $pages_count - 2; $i < $pages_count + 1; $i++) {
          $active = $current_page == $i ? 'active' : '';
          echo "
            <li class='page-item $active'>
              <a class='page-link' href='sites.php?page=$i'>${i}</a>
            </li>
          ";
        }
        echo "
          <li class='page-item $enable_next'>
            <a class='page-link' href='sites.php?page=$next_page'>Next</a>
          </li>
        ";
        echo '</ul></nav>';

        mysqli_next_result($link);
        $result = mysqli_store_result($link);
        if (mysqli_num_rows($result) > 0) {
          // output data of each row
          while($row = mysqli_fetch_assoc($result)) {
            $title = isset($row['SiteName']) ? $row['SiteName'] : 'No Title';
            echo "
              <div class='col-12 col-md-4 col-lg-3 mb-4 site'>
                <div class='card'>
                  <div class='bg-image hover-overlay ripple ratio ratio-4x3' data-mdb-ripple-color='light'>
                    <img width='100%' src='{$row['PhotoURL']}' class='img-fluid'/>
                    <a href='#!'>
                      <div class='mask' style='background-color: rgba(251, 251, 251, 0.15);'></div>
                    </a>
                  </div>
                  <div class='card-body'>
                    <h5 class='card-title'>Public Art # $row[RegistryID] at $title</h5>
                    <p>{$row['ArtistProjectStatement']}</p>
                    <div class='d-flex justify-content-center'>
                      <a href='individual_art.php?artdata={$row['RegistryID']}' class='btn btn-primary btn-block'>Open</a>
                    </div>
                  </div>
                </div>
              </div>
            ";
          }
        } else {
          // echo "0 results";
        }
      }
      // echo "COUNT: $count"
    ?>
  </div>
</div>

<?php
  require('../layouts/footer.php')
?>