<?php
$query = "SELECT * FROM products";
$result = mysqli_query($conn, $query);

// FIXME:
$product_count = 30;
$product_low_stock = 2;
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
    </div>

    <!-- TODO: -->
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