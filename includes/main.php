<!DOCTYPE html>
<html lang="fi">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="main.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.min.css"
    />
    <title>InWare</title>
  </head>
  <body>
    <div class="app-layout">

        <?php include_once BASE_PATH . '/includes/sidebar.php'; ?>

        <div class="content">
            <main class="main">
                <?php
                // content
                if (array_key_exists($page, $routes)) {
                    include_once $routes[$page];
                } else {
                    http_response_code(404);
                    echo "Haluamaasi sivua ei löytynyt.";
                }
            ?>
            </main>
      
            <?php include_once BASE_PATH . '/includes/footer.php'; ?>
      
        </div>
    </div>
  </body>
</html>
