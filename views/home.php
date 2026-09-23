<?php

// Product count
$query = "SELECT COUNT(*) AS product_count FROM products";
$result = mysqli_query($conn, $query);
$product_count = mysqli_fetch_assoc($result)['product_count'];

// Category count
$query = "SELECT COUNT(DISTINCT category) AS category_count FROM products";
$result = mysqli_query($conn, $query);
$category_count = mysqli_fetch_assoc($result)['category_count'];

// Low stock
$query = "SELECT COUNT(*) AS product_low_stock FROM products WHERE quantity <= 10";
$result = mysqli_query($conn, $query);
$product_low_stock = mysqli_fetch_assoc($result)['product_low_stock'];

// All products from DB
$query = "SELECT * FROM products";
$result = mysqli_query($conn, $query);

?>

<section>
    <h2 class="section-title"> Varastossa</h2>

    <div class="stats">
        <div class="stat">
            <span class="stat-label">Tuotteet:</span>
            <strong class="stat-value"><?= $product_count ?></strong>
        </div>

        <div class="stat">
            <span class="stat-label">Vähissä:</span>
            <strong class="stat-value"><?= $product_low_stock ?></strong>
        </div>

        <div class="stat">
            <span class="stat-label">Kategoriat:</span>
            <strong class="stat-value"><?= $category_count ?></strong>
        </div>
    </div>

    <h2 class="section-title"> Kaikki tuotteet</h2>


    <div class="table-wrapper">
        <table class="table">
            <thead>
                <tr class="table-row">
                    <th class="table-header">Tuote</th>
                    <th class="table-header">Kategoria</th>
                    <th class="table-header">Määrä</th>
                    <th class="table-header">Hinta</th>
                    <th class="table-header"></th>
                </tr>
            </thead>

            <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr class="table-row">
                    <td class="table-column"><?= htmlspecialchars($row['name']) ?></td>
                    <td class="table-column"><?= htmlspecialchars($row['category']) ?></td>
                    <td class="table-column"><span class="status"><?= htmlspecialchars($row['quantity']) ?></span></td>
                    <td class="table-column">&euro; <?= htmlspecialchars($row['price']) ?></td>
                    <td class="table-column"><a href="index.php?page=view-product&product-id=<?= htmlspecialchars($row['id']) ?>" class="action-link">Näytä</a></td>
                </tr>
            <?php endwhile; ?>
            <?php else: ?>
                <tr class="table-row">
                    <td class="table-column">Tuotelista on tyhjä</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>

    </div>
</section>