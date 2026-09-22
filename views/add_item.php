<section class="post-form">
    <h2 class="section-title">Uusi tuote</h2>

<?php
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

<!-- Form send status messages -->
<?php
if($validated['isValid']):
    // Add new product in database
    $product_name = $validated["data"]["name"];
    $product_desc = $validated["data"]["desc"];

    $query = "INSERT INTO products (name, description) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ss", $product_name, $product_desc);

    if (mysqli_stmt_execute($stmt)):
        $_POST = [];
?>

    <div class="alert alert-success">
        <p>Tuote lisätty onnistuneesti.</p>
    </div>

    <?php else: ?>

    <div class="alert alert-error">
        <p>Tuotteen lisääminen epäonnistui. Yritä uudelleen.</p>
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

<!-- Form -->
    <div class="form-wrapper">
        <form action="<?= htmlspecialchars($_SERVER['SCRIPT_NAME']) ?>?page=add-item" method="POST" name="add_product">
            <div class="form-field">
                <label class="form-label" for="product-name" >Tuote</label>
                <input 
                    class="form-input" type="text" id="product-name" name="product-name" 
                    value="<?= htmlspecialchars($_POST['product-name'] ?? '') ?>" placeholder="Uusi tuote"
                >
            </div>
    
            <div class="form-field">
                <label class="form-label" for="product-desc" >Tuotteen kuvaus</label>
                <textarea class="form-textarea" id="product-desc" name="product-desc" placeholder="Kuvaa tuotetta..."
                ><?= htmlspecialchars($_POST['product-desc'] ?? '') ?></textarea>
            </div>
    
            <button class="form-button" type="submit" >Tallenna</button>
        </form>
    </div>

</section>