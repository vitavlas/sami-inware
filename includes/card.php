<?php
// format date
$date_created = new DateTime($row['created_at']);
$date_updated = new DateTime($row['updated_at']);

$formatted_date_created = $date_created->format('d.m.Y');
$formatted_date_updated = $date_updated->format('d.m.Y');
?>

<article class="card">
    <div class="card-wrapper">
        <div class="card-avatar">
            <img src="https://placehold.co/128x128?text=tuote" width="128" height="128" alt="Tuotekuva">
        </div>
        <div class="card-section">
            <h3 class="card-title"><?= htmlspecialchars($row['name']) ?></h3>
            <p class="card-content"><?= htmlspecialchars($row['description']) ?></p>
            <div class="card-info">
                <div class="info-item">
                    <i class="fa-solid fa-layer-group"></i>
                    <span class="info-label">Kategoria: </span>
                    <span class="info-value"><?= htmlspecialchars($row['category']) ?></span>
                </div>
                <div class="info-item">
                    <i class="fa-solid fa-calculator"></i>
                    <span class="info-label">Määrä: </span>
                    <span class="info-value"><?= htmlspecialchars($row['quantity']) ?></span>
                </div>
                <div class="info-item">
                    <i class="fa-solid fa-money-check-dollar"></i>
                    <span class="info-label">Hinta: </span>
                    <span class="info-value"><?= htmlspecialchars($row['price']) ?></span>
                </div>
                <div class="info-item">
                    <i class="fa-regular fa-calendar"></i>
                    <span class="info-label">Lisätty: </span>
                    <time datetime="<?= htmlspecialchars($formatted_date_created) ?>">
                        <?= htmlspecialchars($formatted_date_created) ?>
                    </time>
                </div>
                <div class="info-item">
                    <i class="fa-regular fa-clock"></i>
                    <span class="info-label">Päivitetty: </span>
                    <time datetime="<?= htmlspecialchars($formatted_date_updated) ?>">
                        <?= htmlspecialchars($formatted_date_updated) ?>
                    </time>
                </div>
            </div>
        </div>

        <?php if (($_SESSION['user_role'] ?? '') === 'admin'): ?>

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

        <?php endif; ?>
    </div>
</article>