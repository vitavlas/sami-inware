<section>
    <h2 class="section-title"> Tuotetiedot</h2>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET'):

    // Get requested product data
    $product_id = (int) $_GET['product-id'];
    
    $query = "SELECT * FROM products WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $product_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($row = mysqli_fetch_assoc($result)):
        include_once BASE_PATH . '/includes/card.php';
    else:
        echo "<p>Tuotetta ei löytynyt.</p>";
    endif;

endif;
?>

</section>