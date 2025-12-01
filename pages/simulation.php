<?php
session_start();
require "../includes/db.php";

// Initialize session variables
if (!isset($_SESSION['currentOrder']))
    $_SESSION['currentOrder'] = [];

if (!isset($_SESSION['selectedCashier']))
    $_SESSION['selectedCashier'] = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Select cashier
    if (isset($_POST['action']) && $_POST['action'] === 'select_cashier') {
        $_SESSION['selectedCashier'] = $_POST['employee_id'];
        header("Location: /sqlGrill-Website/pages/simulation.php");
        exit;
    }

    // Add to order
    if (isset($_POST['action']) && $_POST['action'] === 'add_to_order') {
        $menuItemId = (int)$_POST['menu_item_id'];

        $found = false;

        foreach ($_SESSION['currentOrder'] as &$item) {
            if ($item['menu_item_id'] == $menuItemId) {
                $item['quantity']++;
                $found = true;
                break;
            }
        }
        unset($item);

        if (!$found) {
            $_SESSION['currentOrder'][] = [
                'menu_item_id' => $menuItemId,
                'quantity' => 1
            ];
        }

        header("Location: /sqlGrill-Website/pages/simulation.php");
        exit;
    }

    // Increase quantity
    if (isset($_POST['action']) && $_POST['action'] == 'increase_qty') {
        $orderItemId = (int)$_POST['menu_item_id'];

        foreach ($_SESSION['currentOrder'] as &$item) {
            if ($item['menu_item_id'] == $orderItemId) {
                $item['quantity']++;
                break;
            }
        }
        unset($item);

        header("Location: /sqlGrill-Website/pages/simulation.php");
        exit;
    }

    // Decrease quantity
    if (isset($_POST['action']) && $_POST['action'] == 'decrease_qty') {
        $orderItemId = (int)$_POST['menu_item_id'];

        foreach ($_SESSION['currentOrder'] as $key => &$item) {
            if ($item['menu_item_id'] == $orderItemId) {
                $item['quantity']--;
                if ($item['quantity'] <= 0)
                    unset($_SESSION['currentOrder'][$key]);
                break;
            }
        }
        unset($item);

        header("Location: /sqlGrill-Website/pages/simulation.php");
        exit;
    }

    // Remove item
    if (isset($_POST['action']) && $_POST['action'] == 'remove_item') {
        $orderItemId = (int)$_POST['menu_item_id'];

        foreach ($_SESSION['currentOrder'] as $key => $item) {
            if ($item['menu_item_id'] == $orderItemId) {
                unset($_SESSION['currentOrder'][$key]);
                break;
            }
        }

        header("Location: /sqlGrill-Website/pages/simulation.php");
        exit;
    }

    // Submit order
    if (isset($_POST['action']) && $_POST['action'] === 'submit_order') {

        if ($_SESSION['selectedCashier'] === null || empty($_SESSION['currentOrder'])) {
            header("Location: /sqlGrill-Website/pages/simulation.php");
            exit;
        }

        try {
            // Calculate total price
            $totalPrice = 0;
            foreach ($_SESSION['currentOrder'] as $item) {
                $stmt = $pdo->prepare("SELECT menu_item_price FROM menu_item WHERE menu_item_id = ?");
                $stmt->execute([$item['menu_item_id']]);
                $price = $stmt->fetchColumn();
                $totalPrice += ($price * $item['quantity']);
            }

            // Insert customer order
            $stmt = $pdo->prepare("INSERT INTO customer_order (employee_id, customer_order_total_price) VALUES (?, ?)");
            $stmt->execute([$_SESSION['selectedCashier'], $totalPrice]);
            $customerOrderId = $pdo->lastInsertId();

            // Insert items
            $stmt = $pdo->prepare("INSERT INTO order_item (customer_order_id, menu_item_id, order_item_quantity) VALUES (?, ?, ?)");
            foreach ($_SESSION['currentOrder'] as $item)
                $stmt->execute([$customerOrderId, $item['menu_item_id'], $item['quantity']]);

            // Clear order/session
            $_SESSION['currentOrder'] = [];
            $_SESSION['selectedCashier'] = null;

            header("Location: /sqlGrill-Website/pages/simulation.php");
            exit;
        } catch (PDOException $e) {
            die("Error submitting order: " . $e->getMessage());
        }
    }
}

require "../includes/header.php";

// Fetch cashiers
$stmt = $pdo->prepare("SELECT employee_id, employee_firstname, employee_lastname FROM employee WHERE employee_role_id = 2");
$stmt->execute();
$cashiers = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch menu items
$stmt = $pdo->prepare("
    SELECT 
        MI.menu_item_id,
        MI.menu_item_name,
        MI.menu_item_description,
        MI.menu_item_price,
        MI.menu_item_image_url,
        M.menu_name
    FROM menu_item MI 
    JOIN menu M ON MI.menu_id = M.menu_id
    ORDER BY M.menu_id, MI.menu_item_name
");
$stmt->execute();
$menuItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get cashier name safely
$orderCashier = null;
if (!empty($_SESSION['selectedCashier'])) {
    $stmt = $pdo->prepare("SELECT employee_firstname, employee_lastname FROM employee WHERE employee_id = ?");
    $stmt->execute([$_SESSION['selectedCashier']]);
    $orderCashier = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Order summary build
$orderItems = [];
$orderTotal = 0;

if (!empty($_SESSION['currentOrder'])) {
    foreach ($_SESSION['currentOrder'] as $item) {
        $stmt = $pdo->prepare("SELECT menu_item_name, menu_item_price FROM menu_item WHERE menu_item_id = ?");
        $stmt->execute([$item['menu_item_id']]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $subtotal = $row['menu_item_price'] * $item['quantity'];

            $orderItems[] = [
                'menu_item_id' => $item['menu_item_id'],
                'menu_item_name' => $row['menu_item_name'],
                'menu_item_price' => $row['menu_item_price'],
                'quantity' => $item['quantity'],
                'subtotal' => $subtotal,
            ];

            $orderTotal += $subtotal;
        }
    }
}
?>

<main id="simulation-main">

    <!-- TOP ROW: CASHIER + ORDER -->
    <div id="top-row">

        <div id="cashier-container">
            <h1>Select Cashier</h1>
            <div id="cashier-cards">
                <?php foreach ($cashiers as $cashier): ?>
                    <form method="POST" class="cashier-card">
                        <img class="cashier-image" src="../assets/images/cashier.png" alt="Cashier Image">
                        <input type="hidden" name="action" value="select_cashier">
                        <input type="hidden" name="employee_id" value="<?= $cashier['employee_id'] ?>">
                        <button
                            type="submit"
                            class="cashier-card-btn <?= $_SESSION['selectedCashier'] == $cashier['employee_id'] ? 'selected' : '' ?>">
                            <strong><?= $cashier['employee_firstname'] ?> <?= $cashier['employee_lastname'] ?></strong>
                        </button>
                    </form>
                <?php endforeach; ?>
            </div>
        </div>

        <div id="order-container" class="<?= empty($orderCashier) ? 'hidden' : '' ?>">
            <h2 id="order-title">
                Current Order
                <?php if ($orderCashier): ?>
                    - Cashier: <?= $orderCashier['employee_firstname'] . " " . $orderCashier['employee_lastname'] ?>
                <?php endif; ?>
            </h2>

            <?php if (!empty($orderItems)): ?>
                <?php foreach ($orderItems as $item): ?>
                    <div class="order-item">
                        <p><?= $item['menu_item_name'] ?></p>

                        <div class="order-crud">

                            <div class="order-main-crud">
                                <form method="POST" class="qty-form">
                                    <input type="hidden" name="action" value="decrease_qty">
                                    <input type="hidden" name="menu_item_id" value="<?= $item['menu_item_id'] ?>">
                                    <button type="submit" class="decrement-order-item-btn">-</button>
                                </form>

                                <span class="qty"><?= $item['quantity'] ?></span>

                                <form method="POST" class="qty-form">
                                    <input type="hidden" name="action" value="increase_qty">
                                    <input type="hidden" name="menu_item_id" value="<?= $item['menu_item_id'] ?>">
                                    <button type="submit" class="add-order-item-btn">+</button>
                                </form>
                            </div>

                            <div class="order-subtotal">
                                <p>$<?= number_format($item['subtotal'], 2) ?></p>

                                <form method="POST" class="remove-item-form">
                                    <input type="hidden" name="action" value="remove_item">
                                    <input type="hidden" name="menu_item_id" value="<?= $item['menu_item_id'] ?>">
                                    <button type="submit" class="remove-order-item-btn">x</button>
                                </form>
                            </div>

                        </div>
                    </div>

                <?php endforeach; ?>

                <p id="total"><strong>Total: $<?= number_format($orderTotal, 2) ?></strong></p>

                <form method="POST">
                    <input type="hidden" name="action" value="submit_order">
                    <button type="submit" id="submit-order-btn">Submit Order</button>
                </form>

            <?php else: ?>
                <p>No items in order.</p>
            <?php endif; ?>
        </div>

    </div> <!-- /top-row -->

    <!-- FULL-WIDTH MENU BELOW -->
    <div id="menu-container">
        <h1>Menu</h1>
        <?php
        $currentMenuName = null;
        foreach ($menuItems as $item):

            if ($currentMenuName !== $item['menu_name']):
                if ($currentMenuName !== null) echo '</div>'; // Close previous category
                $currentMenuName = $item['menu_name'];
        ?>
                <h2 class="menu-name"><?= $currentMenuName ?></h2>
                <div class="menu-category">
                <?php endif; ?>

                <div class="menu-item-card">
                    <img src="/sqlGrill-Website/uploads/<?= $item['menu_item_image_url'] ?>" alt="<?= $item['menu_item_name'] ?>">
                    <h3><?= $item['menu_item_name'] ?></h3>
                    <p class="price">$<?= number_format($item['menu_item_price'], 2) ?></p>
                    <form method="POST">
                        <input type="hidden" name="action" value="add_to_order">
                        <input type="hidden" name="menu_item_id" value="<?= $item['menu_item_id'] ?>">
                        <button type="submit" class="add-to-order-btn">+ Add to Order</button>
                    </form>
                </div>

            <?php endforeach; ?>
                </div> <!-- FINAL CATEGORY CLOSE -->
    </div>

</main>


<?php
require "../includes/footer.php";
?>