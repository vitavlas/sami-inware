<section>

<?php
/* ===== DELETE product ===== */ 

if ($_SERVER['REQUEST_METHOD'] === 'POST'):
    $product_id = (int) $_POST['product-id'];

    $query = "DELETE FROM products WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $product_id);

    if (mysqli_stmt_execute($stmt)):
?>

    <div class="alert alert-success">
        <p>Tuote poistettu.</p>
    </div>

    <?php else: ?>

    <div class="alert alert-error">
        <p>Tuotteen poistaminen epäonnistui. Yritä uudelleen.</p>
    </div>

    <?php endif; ?>
    <?php endif; ?>


<?php
/* ===== DISPLAY alert message before delete ===== */ 

if ($_SERVER['REQUEST_METHOD'] === 'GET'):
// Get requested post data
$product_id = (int) $_GET['product-id'];

$query = "SELECT id, name FROM products WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $product_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0):
    $row = mysqli_fetch_assoc($result);
?>

    <h2 class="section-title"><?= htmlspecialchars($row['name']) ?> [ Poistaminen ]</h2>

    <!-- Form -->
    <div class="form-wrapper">
        <form action="<?= htmlspecialchars($_SERVER['SCRIPT_NAME']) ?>?page=delete-item&product-id=<?= $product_id ?>" method="POST" name="delete_product">
            <p>Poistetaan tuotteen <strong><?= $row['name'] ?></strong>? Toimintoa ei voi perua.</p>

            <input type="hidden" name="product-id" value="<?= htmlspecialchars($product_id) ?>">

            <button class="form-button form-button--alert" type="submit" >Poista</button>
        </form>
    </div>

    <?php
        else:
            echo "<p>Hakemaasi tuotetta ei löytynyt!</p>";
        endif;
    ?>

    <?php endif; ?>

</section>