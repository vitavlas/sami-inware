<?php
// formatted post time
$date = new DateTime($row['created_at']);
$formatted_date = $date->format('d.m.Y');
$formatted_time = $date->format('H:i');
?>

<article class="card">
    <div class="card-wrapper">
        <div class="card-avatar">
            <img src="https://placehold.co/64x64?text=tuote" width="64" height="64" alt="User profile avatar">
        </div>
        <div class="card-section">
            <h3 class="card-title"><?= htmlspecialchars($row['name']) ?></h3>
            <p class="card-content"><?= htmlspecialchars($row['description']) ?></p>
            <div class="card-info">
                <div class="info-item">
                    <i class="fa-regular fa-calendar"></i>
                    <span class="info-label">Kategoria: </span>
                    <span class="info-value"><?= htmlspecialchars($row['category']) ?></span>
                </div>
                <div class="info-item">
                    <i class="fa-regular fa-calendar"></i>
                    <span class="info-label">Määrä: </span>
                    <span class="info-value"><?= htmlspecialchars($row['quantity']) ?></span>
                </div>
                <div class="info-item">
                    <i class="fa-regular fa-calendar"></i>
                    <span class="info-label">Hinta: </span>
                    <span class="info-value"><?= htmlspecialchars($row['price']) ?></span>
                </div>
                <div class="info-item">
                    <i class="fa-regular fa-calendar"></i>
                    <span class="info-label">Lisätty: </span>
                    <time datetime="<?= htmlspecialchars($row['created_at']) ?>">
                        <?= htmlspecialchars($row['created_at']) ?>
                    </time>
                </div>
                <div class="info-item">
                    <i class="fa-regular fa-clock"></i>
                    <span class="info-label">Päivitetty: </span>
                    <time datetime="<?= htmlspecialchars($row['updated_at']) ?>">
                        <?= htmlspecialchars($row['updated_at']) ?>
                    </time>
                </div>
            </div>
        </div>
        <div class="card-actions">
            <a class="action-link" href="index.php?page=update-item&product-id=<?= htmlspecialchars($row['id']) ?>">
                <i class="fa-regular fa-pen-to-square"></i>
                 Muokkaa
            </a>
            <a class="action-link action-link--alert" href="index.php?page=delete-item&product-id=<?= htmlspecialchars($row['id']) ?>">
                <i class="fa-regular fa-trash-can"></i>
                 Poista
            </a>
        </div>
    </div>
</article>