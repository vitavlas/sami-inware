<!DOCTYPE html>
<html lang="fi">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="main.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.min.css"
    />
    <title>InWare</title>
  </head>
  <body>
    <div class="app-layout">

        <?php include_once BASE_PATH . '/includes/sidebar.php'; ?>

      <main class="main">
        <div class="content">
            <?php
                // content
                if (array_key_exists($page, $routes)) {
                    include_once $routes[$page];
                } else {
                    http_response_code(404);
                    echo "Haluamaasi sivua ei löytynyt.";
                }
            ?>
        </div>
      </main>

        <?php include_once BASE_PATH . '/includes/footer.php'; ?>

    </div>
  </body>
</html>
