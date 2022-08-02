<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>myLSU | Home</title>
    <link rel="stylesheet" href="./css/style.css" />
    <script src="./fontawesome/js/all.js"></script>
  </head>
  <body>
    <main class="main-container">
      <div class="main-content">
        <?php
          require_once './includes/dbh.inc.php';
          include_once './left-panel.php';
          include_once './center-panel.php';
          include_once './right-panel.php';
        ?>
      </div>
    </main>
    <?php
      include_once './settings-panel.php';
    ?>
    <!-- <script type="module" src="./js/main.js"></script> -->
  </body>
</html>
