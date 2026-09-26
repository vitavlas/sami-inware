<section>
    <h2 class="section-title">Uusi tuote</h2>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST'):
    // FIXME: create DB table!
    // Product categories
    $categories_allowed = [
        'Metallimateriaalit',
        'Rakennustarvikkeet',
        'Työturvallisuus',
        'Toimistotekniikka',
        'Toimisto',
    ];
    
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

<!-- Form send status messages -->

<?php
if($validated['isValid']):
    // Add new product to the database
    $product_name = $validated["data"]["name"];
    $product_category = $validated["data"]["category"];
    $product_quantity = $validated["data"]["quantity"];
    $product_price = $validated["data"]["price"];
    $product_desc = $validated["data"]["desc"];

    $query = "INSERT INTO products (name, description, category, quantity, price) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sssid", $product_name, $product_desc, $product_category, $product_quantity, $product_price);

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
        <div class="alert-inner">
            <?php foreach ($validated['errors'] as $error_msg): ?>
            <p class="alert-message"><i class="fa-solid fa-circle-info"></i> <?= htmlspecialchars($error_msg) ?></p>
            <?php endforeach; ?>
        </div>
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
                    value="<?= htmlspecialchars($_POST['product-name'] ?? '') ?>" placeholder="Uusi tuote" required
                >
            </div>

            <div class="form-field">
                <label class="form-label" for="product-category" >Kategoria</label>
                <select class="form-input" name="product-category" id="product-category" required>
                    <option value="" selected disabled>Valitse kategoria</option>
                    <option value="Metallimateriaalit">Metallimateriaalit</option>
                    <option value="Rakennustarvikkeet">Rakennustarvikkeet</option>
                    <option value="Työturvallisuus">Työturvallisuus</option>
                    <option value="Toimistotekniikka">Toimistotekniikka</option>
                    <option value="Toimisto">Toimisto</option>
                </select>
            </div>

            <div class="form-field">
                <label class="form-label" for="product-name" >Määrä</label>
                <input 
                    class="form-input" type="number" min="0" step="1" id="product-quantity" name="product-quantity" 
                    value="<?= htmlspecialchars($_POST['product-quantity'] ?? '') ?>" placeholder="10" required
                >
            </div>

            <div class="form-field">
                <label class="form-label" for="product-price" >Hinta</label>
                <input 
                    class="form-input" type="number" min="0" step="0.01" id="product-price" name="product-price" 
                    value="<?= htmlspecialchars($_POST['product-price'] ?? '') ?>" placeholder="12.50" required
                >
            </div>
    
            <div class="form-field">
                <label class="form-label" for="product-desc" >Tuotteen kuvaus</label>
                <textarea class="form-textarea" id="product-desc" name="product-desc" placeholder="Kuvaa tuotetta..." required
                ><?= htmlspecialchars($_POST['product-desc'] ?? '') ?></textarea>
            </div>
    
            <button class="form-button" type="submit" >Tallenna</button>
        </form>
    </div>

</section>