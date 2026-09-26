<section>
    <h2 class="section-title"> Tuotetiedot</h2>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET'):

    // Get requested product data
    $product_id = (int) $_GET['product-id'];
    
    $query = "SELECT p.id, p.name, c.name AS category, p.description, p.quantity, p.price, p.created_at, p.updated_at FROM products AS p JOIN categories AS c ON p.category_id = c.id WHERE p.id = ?";
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