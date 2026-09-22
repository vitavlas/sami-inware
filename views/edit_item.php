<section>

<?php
/* ===== UPDATE product info ===== */ 

if ($_SERVER['REQUEST_METHOD'] === 'POST'):
    // Validate form inputs
     $input_data = [
        'name' => $_POST['product-name'] ?: '',
        'desc' => $_POST['product-desc'] ?: '',
    ];

    $patterns = [
        'name' => [
            'label' => 'Tuote',
            'type' => 'regex',
            'rule' => '/^[a-zA-Z0-9 \-]+$/',
            'message' => 'Tuotenimi ei voi olla tyhjä',
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

    <h2 class="section-title"><?= htmlspecialchars($validated["data"]["author"]) ?> [ muokkaus tila ]</h2>

<!-- Form send status messages -->
<?php
if($validated['isValid']):
    // Update post
    $product_id = (int) $_POST['product-id'];
    $product_name = $validated["data"]["name"];
    $product_desc = $validated["data"]["desc"];

    $query = "UPDATE products SET name = ?, description = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssi", $product_name, $product_desc, $product_id);

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
        <?php foreach ($validated['errors'] as $error_msg): ?>
        <p><i class="fa-solid fa-circle-info"></i> <?= htmlspecialchars($error_msg) ?></p>
        <?php endforeach; ?>
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
    <form action="<?= htmlspecialchars($_SERVER['SCRIPT_NAME']) ?>?page=update-product&product-id=<?= $product_id ?>" method="POST" name="update_product">
        <div class="form-field">
            <label class="form-label" for="product-name" >Tuote</label>
            <input 
                class="form-input" type="text" id="product-name" name="product-name" 
                value="<?= htmlspecialchars($row['name']) ?>"
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