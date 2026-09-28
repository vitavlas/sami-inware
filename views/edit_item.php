<?php
/* ===== Preparing data ===== */ 

// Product id
$product_id = (int) ($_GET['product-id'] ?? $_POST['product-id'] ?? 0);

// Product categories
$categories_allowed = [];

$query = "SELECT id, name FROM categories ORDER BY name";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $categories_allowed[] = $row;
}

// Product data
$query = "SELECT p.id, p.name, p.category_id, c.name AS category, p.description, p.quantity, p.price, p.created_at, p.updated_at FROM products AS p JOIN categories AS c ON p.category_id = c.id WHERE p.id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $product_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

// Data after validation
$validated = null;
?>

<?php
/* ===== Product does not exist? ===== */ 

if (mysqli_num_rows($result) === 0) {
    echo "<p>Hakemaasi tuotetta ei löytynyt!</p>";
}
?>

<?php
/* ===== UPDATE product info ===== */ 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate form inputs
         $input_data = [
        'name' => $_POST['product-name'] ?: '',
        'category' => $_POST['product-category'] ?? '',
        'quantity' => $_POST['product-quantity'] ?: '',
        'price' => str_replace(',', '.', $_POST['product-price']) ?: '',
        'desc' => $_POST['product-desc'] ?: '',
    ];

    $patterns = [
        'name' => [
            'label' => 'Tuote',
            'type' => 'regex',
            'rule' => '/^[\p{L}0-9 \-]+$/u',
            'message' => 'Tuotenimi sisältää kiellettyjä merkkejä tai tyhjä',
        ],
        'category' => [
            'label' => 'Kategoria',
            'type' => 'filter',
            'rule' => FILTER_VALIDATE_INT,
            'message' => 'Valittu väärä kategoria',
        ],
        'quantity' => [
            'label' => 'Määrä',
            'type' => 'regex',
            'rule' => '/^[0-9]+$/',
            'message' => 'Määrän tulee olla numero',
        ],
        'price' => [
            'label' => 'Hinta',
            'type' => 'regex',
            'rule' => '/^\d+(?:[.,]\d{1,2})?$/',
            'message' => 'Hinnan tulee olaa numero ',
        ],
        'desc' => [
            'label' => 'Tuotteen kuvaus',
            'type' => 'regex',
            'rule' => '/^(?!\s*$).+/',
            'message' => 'Tuotteen kuvaus puuttuu',
        ],
    ];

    $sanitized = sanitizeInput($input_data);
    $validated = validateInput($patterns, $sanitized);

    if ($validated['isValid']) {
        // Update product
        $product_name = $validated["data"]["name"];
        $product_category = (int) $validated["data"]["category"];
        $product_quantity = (int) $validated["data"]["quantity"];
        $product_price = (float) $validated["data"]["price"];
        $product_desc = $validated["data"]["desc"];

        $query = "UPDATE products SET name = ?, description = ?, category_id = ?, quantity = ?, price = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ssiidi", $product_name, $product_desc, $product_category, $product_quantity, $product_price, $product_id);

        if (mysqli_stmt_execute($stmt)) {
            $success = true;

            // Update product data after UPDATE
            $row['name'] = $product_name;
            $row['category_id'] = $product_category;
            $row['quantity'] = $product_quantity;
            $row['price'] = $product_price;
            $row['description'] = $product_desc;
        } else {
            $success = false;
        }
    }
}
?>

<?php if ($row): ?>


<section>

    <h2 class="section-title"><?= htmlspecialchars($row['name']) ?> [ muokkaus tila ]</h2>

    <?php if ($validated && !$validated['isValid']): ?>

    <!-- Form send status messages -->

    <div class="alert alert-error">
        <div class="alert-inner">
            <?php foreach ($validated['errors'] as $error_msg): ?>
            <p class="alert-message"><i class="fa-solid fa-circle-info"></i> <?= htmlspecialchars($error_msg) ?></p>
            <?php endforeach; ?>
        </div>
    </div>

    <?php endif; ?>

    <?php if ($validated && $success): ?>

        <div class="alert alert-success">
            <p>Tuotetiedot päivitetty!</p>
        </div>

    <?php elseif ($validated && !$success): ?>

        <div class="alert alert-error">
            <p>Tuotteen päivittäminen epäonnistui. Yritä uudelleen.</p>
        </div>

    <?php endif; ?>
    
<!-- Form -->
 
<div class="form-wrapper">
    <form action="<?= htmlspecialchars($_SERVER['SCRIPT_NAME']) ?>?page=update-item&product-id=<?= $product_id ?>" method="POST" name="update_product">
        <div class="form-field">
            <label class="form-label" for="product-name" >Tuote</label>
            <input 
                class="form-input" type="text" id="product-name" name="product-name" 
                value="<?= htmlspecialchars($validated['data']['name'] ?? $row['name']) ?>" 
            >
        </div>

                    <div class="form-field">
                <label class="form-label" for="product-category" >Kategoria</label>

                    <select class="form-input" name="product-category" id="product-category">

                         <option value="" disabled>Valitse kategoria</option>

                         <?php $current_category_id = (int) ($validated['data']['category'] ?? $row['category_id']); ?>

    <?php foreach ($categories_allowed as $category): ?>
        
        <option
            value="<?= $category['id'] ?>"
            <?= $current_category_id === (int) $category['id'] ? 'selected' : '' ?>
        >
            <?= htmlspecialchars($category['name']) ?>
        </option>

    <?php endforeach; ?>

                    </select>

            </div>

            <div class="form-field">
                <label class="form-label" for="product-name" >Määrä</label>
                <input 
                    class="form-input" type="number" min="0" step="1" id="product-quantity" name="product-quantity" 
                    value="<?= htmlspecialchars($validated['data']['quantity'] ?? $row['quantity']) ?>" placeholder="10"
                >
            </div>

            <div class="form-field">
                <label class="form-label" for="product-price" >Hinta</label>
                <input 
                    class="form-input" type="number" min="0" step="0.01" id="product-price" name="product-price" 
                    value="<?= htmlspecialchars($validated['data']['price'] ?? $row['price']) ?>" placeholder="12.50"
                >
            </div>

        <div class="form-field">
            <label class="form-label" for="product-desc" >Tuotteen kuvaus</label>
            <textarea class="form-textarea" id="product-desc" name="product-desc"
            ><?= htmlspecialchars($validated['data']['desc'] ?? $row['description']) ?></textarea>
        </div>

        <input type="hidden" name="product-id" value="<?= $row['id'] ?>">

        <button class="form-button" type="submit" >Päivitä</button>
    </form>
</div>

</section>

<?php endif; ?>
