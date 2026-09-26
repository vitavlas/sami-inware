<?php
// FIXME: create DB table!
$categories_allowed = [
    'Metallimateriaalit',
    'Rakennustarvikkeet',
    'Työturvallisuus',
    'Toimistotekniikka',
    'Toimisto',
];
?>

<section>

<?php
/* ===== UPDATE product info ===== */ 

if ($_SERVER['REQUEST_METHOD'] === 'POST'):
    // Validate form inputs
      $input_data = [
        'name' => $_POST['product-name'] ?: '',
        'category' => $_POST['product-category'] ?? '',
        'quantity' => (int) $_POST['product-quantity'] ?: '',
        'price' => (float) str_replace(',', '.', $_POST['product-price']) ?: '',
        'desc' => $_POST['product-desc'] ?: '',
    ];

    $patterns = [
        'name' => [
            'label' => 'Tuote',
            'type' => 'regex',
            'rule' => '/^[\p{L}0-9 \-]+$/u',
            'message' => 'Tuotenimi ei voi olla tyhjä',
        ],
        'category' => [
            'label' => 'Kategoria',
            'type' => 'in_array',
            'rule' => $categories_allowed,
            'message' => 'Väärä kategoria',
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
?>

    <h2 class="section-title"><?= htmlspecialchars($validated["data"]["name"]) ?> [ muokkaus tila ]</h2>

<!-- Form send status messages -->

<?php
if($validated['isValid']):
    // Update post
    $product_id = (int) $_POST['product-id'];
    $product_name = $validated["data"]["name"];
    $product_category = $validated["data"]["category"];
    $product_quantity = $validated["data"]["quantity"];
    $product_price = $validated["data"]["price"];
    $product_desc = $validated["data"]["desc"];

    $query = "UPDATE products SET name = ?, description = ?, category = ?, quantity = ?, price = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sssidi", $product_name, $product_desc, $product_category, $product_quantity, $product_price, $product_id);

    if (mysqli_stmt_execute($stmt)):
        $_POST = [];
?>

    <div class="alert alert-success">
        <p>Tuotetiedot päivitetty!</p>
    </div>

    <?php else: ?>

    <div class="alert alert-error">
        <p>Tuotteen päivittäminen epäonnistui. Yritä uudelleen.</p>
    </div>

    <?php endif; ?>

<?php else: ?>

    <?php if (!empty($validated['errors'])): ?>

    <div class="alert alert-error">
        <div class="alert-inner">
            <?php foreach ($validated['errors'] as $error_msg): ?>
            <p class="alert-message"><i class="fa-solid fa-circle-info"></i> <?= htmlspecialchars($error_msg) ?></p>
            <?php endforeach; ?>
        </div>
    </div>

    <?php endif; ?>
    
<?php endif; ?>
<?php endif; ?>

<?php
/* ===== DISPLAY product info ===== */ 

if ($_SERVER['REQUEST_METHOD'] === 'GET'):
    // Get requested post data
    $product_id = (int) $_GET['product-id'];
    
    $query = "SELECT * FROM products WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $product_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($row = mysqli_fetch_assoc($result)):
?>

    <h2 class="section-title"><?= htmlspecialchars($row['name']) ?> [ muokkaus tila ]</h2>

<!-- Form -->
 
<div class="form-wrapper">
    <form action="<?= htmlspecialchars($_SERVER['SCRIPT_NAME']) ?>?page=update-item&product-id=<?= $product_id ?>" method="POST" name="update_product">
        <div class="form-field">
            <label class="form-label" for="product-name" >Tuote</label>
            <input 
                class="form-input" type="text" id="product-name" name="product-name" 
                value="<?= htmlspecialchars($row['name']) ?>" 
            >
        </div>

                    <div class="form-field">
                <label class="form-label" for="product-category" >Kategoria</label>

                <?php if (in_array($row['category'], $categories_allowed)): ?>
                
                    <select class="form-input" name="product-category" id="product-category">

                         <option value="" disabled>Valitse kategoria</option>

    <?php foreach ($categories_allowed as $category): ?>

        <option
            value="<?= htmlspecialchars($category) ?>"
            <?= $row['category'] === $category ? 'selected' : '' ?>
        >
            <?= htmlspecialchars($category) ?>
        </option>

    <?php endforeach; ?>

                    </select>
                <?php endif; ?>

            </div>

            <div class="form-field">
                <label class="form-label" for="product-name" >Määrä</label>
                <input 
                    class="form-input" type="number" min="0" step="1" id="product-quantity" name="product-quantity" 
                    value="<?= htmlspecialchars($row['quantity']) ?>" placeholder="10"
                >
            </div>

            <div class="form-field">
                <label class="form-label" for="product-price" >Hinta</label>
                <input 
                    class="form-input" type="number" min="0" step="0.01" id="product-price" name="product-price" 
                    value="<?= htmlspecialchars($row['price']) ?>" placeholder="12.50"
                >
            </div>

        <div class="form-field">
            <label class="form-label" for="product-desc" >Tuotteen kuvaus</label>
            <textarea class="form-textarea" id="product-desc" name="product-desc"
            ><?= htmlspecialchars($row['description']) ?></textarea>
        </div>

        <input type="hidden" name="product-id" value="<?= htmlspecialchars($row['id']) ?>">

        <button class="form-button" type="submit" >Päivitä</button>
    </form>
</div>

<?php
    else:
        echo "<p>Hakemaasi tuotetta ei löytynyt!</p>";
    endif;
endif;
?>

</section>