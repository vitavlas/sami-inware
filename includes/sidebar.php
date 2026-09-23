<aside class="sidebar">
    <header class="sidebar-header">
        <a href="index.php" class="logo">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" id="warehouse"><polygon fill="#801b5d" points="16 1.9 2 8.36 2 30 30 30 30 8.36 16 1.9"></polygon><rect width="20" height="6" x="6" y="24" fill="#fff"></rect><rect width="20" height="6" x="6" y="18" fill="#d9dce1"></rect><rect width="20" height="6" x="6" y="12" fill="#fff"></rect></svg>
            <span>InWare</span>
        </a>
    </header>
    
  <nav class="sidebar-navigation">
    <ul class="navigation">
      <li>
        <a href="index.php?page=home" class="navigation-link">Aloitus</a>
      </li>
      <li>
        <a href="index.php?page=add-item" class="navigation-link"
          >Lisää tuote</a
        >
      </li>
    </ul>
  </nav>

  <?php if (!empty($_SESSION['user_name'])): ?>

  <div class="sidebar-footer">
    <form class="logout-form" action="<?= htmlspecialchars($_SERVER['SCRIPT_NAME']) ?>?page=logout" method="POST" name="form-logout">
        <p>Kirjautunut: <?= $_SESSION['user_name'] ?></p>
        <button class="action-button" type="submit">Kirjaudu ulos</button>
    </form>
  </div>

  <?php endif; ?>

</aside>
