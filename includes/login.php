<!DOCTYPE html>
<html lang="fi">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.min.css"
    />
    <link rel="stylesheet" href="main.css" />
    <title>InWare | Kirjaudu palveluun</title>
  </head>
  <body>

<?php
  if ($_SERVER['REQUEST_METHOD'] === 'POST'):
    // Check username and password are correct
     $auth_data = [
        'username' => $_POST['username'],
        'password' => $_POST['password'],
    ];

    $error_msg = '';

    $query = "SELECT username, password, role from users WHERE username = ?";    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $auth_data['username']);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        if (password_verify($auth_data['password'], $user['password'])) {
            $_SESSION['user_name'] = $user['username'];
            $_SESSION['user_role'] = $user['role'];
    
            header('Location: index.php?page=home');
            exit;
        } else {
            $error_msg = 'Virheellinen salasana!';
        }
    } else {
        $error_msg = 'Käyttäjätunnusta ei löytynyt!';
    }


    // $patterns = [
    //     'username' => [
    //         'label' => 'Käyttäjätunnus',
    //         'type' => 'regex',
    //         'rule' => '/^[a-zA-Z0-9 \-]+$/',
    //         'message' => 'Käyttäjätunnus ei kelpaa',
    //     ],
    //     'password' => [
    //         'label' => 'Salasana',
    //         'type' => 'regex',
    //         'rule' => '/^(?!\s*$).+/',
    //         'message' => 'Salasana ei kelpaa',
    //     ],
    // ];

    // $sanitized = sanitizeInput($input_data);
    // $validated = validateInput($patterns, $sanitized);
?>

<?php
    elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_SESSION['user_name'])):
        header('Location: index.php?page=home');
        exit;
?>

<?php endif;?>

    <main class="auth">
        <section class="auth-card">
            <a href="#!" class="logo">
                <!-- FIXME: -->
                <img src="https://placehold.co/220x60?text=InWare" width="220" height="60" alt="InWare">
            </a>

            <h1 class="auth-title">Kirjautuminen</h1>

            <?php if (!empty($error_msg)): ?>

            <div class="alert alert-error">
                <p><i class="fa-solid fa-circle-info"></i> <?= $error_msg ?></p>
            </div>

            <?php endif; ?>

            <form class="form" method="post" action="<?= htmlspecialchars($_SERVER['SCRIPT_NAME']) ?>?page=login" >
                <div class="form-field">
                    <label  class="form-label" for="username">Käyttäjätunnus</label>
                    <input class="form-input" type="text" id="username" name="username" autocomplete="username" required>
                </div>

                <div class="form-field">
                    <label  class="form-label" for="password">Salasana</label>
                    <input class="form-input" type="password" id="password" name="password" autocomplete="current-password" required>
                </div>

                <button class="form-button" type="submit">Kirjaudu sisään</button>
            </form>
        </section>
    </main>

  </body>
</html>