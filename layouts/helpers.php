<?php
  function html_headers($title) {
    echo "
      <!doctype html>
      <html lang='en'>
        <head>
          <meta charset='utf-8'>
          <meta name='viewport' content='width=device-width, initial-scale=1'>
          <title>$title</title>
          <!-- Font Awesome -->
          <link
            href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css'
            rel='stylesheet'
          />
          <!-- Google Fonts -->
          <link
            href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap'
            rel='stylesheet'
          />
          <!-- MDB -->
          <link
            href='https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.1/mdb.min.css'
            rel='stylesheet'
          />
          <link href='../index.css' rel='stylesheet'/>
        </head>
        <body>
    ";
  }

  function html_footers() {
    echo "
          <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.1/mdb.min.js'></script>
        </body>
      </html>
    ";
  }

  function test() {
    echo "<div>TEST</div>";
  }

?>