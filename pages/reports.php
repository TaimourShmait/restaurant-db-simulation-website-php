<?php
include "../includes/db.php";

$stmt = $pdo->prepare("SELECT * FROM employee_role");
$stmt->execute();
$employee_roles = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT * FROM employee");
$stmt->execute();
$employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT * FROM menu");
$stmt->execute();
$menus = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT * FROM menu_item");
$stmt->execute();
$menu_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT * FROM ingredient");
$stmt->execute();
$ingredients = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT * FROM customer_order");
$stmt->execute();
$customer_orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

include "../includes/header.php";
?>

<main id="reports-main">

    <nav id="report-nav">
        <a href="#employee-role-report">Employee Roles</a>
        <a href="#employee-report">Employees</a>
        <a href="#menu-report">Menus</a>
        <a href="#menu-item-report">Menu Items</a>
        <a href="#ingredient-report">Ingredients</a>
        <a href="#customer-order-report">Customer Orders</a>
    </nav>

    <div id="employee-role-report" class="table-report">
        <h2>Employee Roles</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Role Name</th>
            </tr>
            <?php foreach ($employee_roles as $role): ?>
                <tr>
                    <td><?= $role['employee_role_id'] ?></td>
                    <td><?= $role['employee_role_name'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <div id="employee-report" class="table-report">
        <h2>Employees</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Role ID</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Manager ID</th>
            </tr>
            <?php foreach ($employees as $employee): ?>
                <tr>
                    <td><?= $employee['employee_id'] ?></td>
                    <td><?= $employee['employee_firstname'] ?></td>
                    <td><?= $employee['employee_lastname'] ?></td>
                    <td><?= $employee['employee_role_id'] ?></td>
                    <td><?= $employee['employee_phone'] ?></td>
                    <td><?= $employee['employee_email'] ?></td>
                    <td><?= $employee['employee_manager_id'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <div id="menu-report" class="table-report">
        <h2>Menus</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Menu Name</th>
            </tr>
            <?php foreach ($menus as $menu): ?>
                <tr>
                    <td><?= $menu['menu_id'] ?></td>
                    <td><?= $menu['menu_name'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <div id="menu-item-report" class="table-report">
        <h2>Menu Items</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Menu ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
            </tr>
            <?php foreach ($menu_items as $item): ?>
                <tr>
                    <td><?= $item['menu_item_id'] ?></td>
                    <td><?= $item['menu_id'] ?></td>
                    <td><?= $item['menu_item_name'] ?></td>
                    <td><?= $item['menu_item_description'] ?></td>
                    <td><?= number_format($item['menu_item_price'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <div id="ingredient-report" class="table-report">
        <h2>Ingredients</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
            </tr>
            <?php foreach ($ingredients as $ingredient): ?>
                <tr>
                    <td><?= $ingredient['ingredient_id'] ?></td>
                    <td><?= $ingredient['ingredient_name'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <div id="customer-order-report" class="table-report">
        <h2>Customer Orders</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Employee ID</th>
                <th>Date</th>
                <th>Total Price</th>
            </tr>
            <?php foreach ($customer_orders as $order): ?>
                <tr>
                    <td><?= $order['customer_order_id'] ?></td>
                    <td><?= $order['employee_id'] ?></td>
                    <td><?= $order['customer_order_datetime'] ?></td>
                    <td><?= number_format($order['customer_order_total_price'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

</main>

<?php include "../includes/footer.php"; ?>