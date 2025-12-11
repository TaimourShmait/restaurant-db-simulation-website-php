<?php
include "../includes/db.php";
include "../includes/header.php";

$report = $_GET['r'] ?? 'employee_roles';

function fetchTable($pdo, $tableName)
{
    $stmt = $pdo->prepare("SELECT * FROM $tableName");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function renderTable($title, $data)
{
    if (empty($data)) {
        echo "<div class='report-card'><h2>$title</h2><p>No data found.</p></div>";
        return;
    }

    echo "<div class='report-card'>";
    echo "<h2>$title</h2>";
    echo "<p class='report-meta'>Total Records: " . count($data) . "</p>";
    echo "<table>";

    echo "<tr>";
    foreach (array_keys($data[0]) as $col) {
        echo "<th>" . $col . "</th>";
    }
    echo "</tr>";

    foreach ($data as $row) {
        echo "<tr>";
        foreach ($row as $val) {
            echo "<td>" . $val . "</td>";
        }
        echo "</tr>";
    }

    echo "</table>";
    echo "</div>";
}

switch ($report) {
    case 'employee_roles':
        $data = fetchTable($pdo, "employee_role");
        $title = "Employee Roles";
        break;

    case 'employees':
        $data = fetchTable($pdo, "employee");
        $title = "Employees";
        break;

    case 'menus':
        $data = fetchTable($pdo, "menu");
        $title = "Menus";
        break;

    case 'menu_items':
        $data = fetchTable($pdo, "menu_item");
        $title = "Menu Items";
        break;

    case 'ingredients':
        $data = fetchTable($pdo, "ingredient");
        $title = "Ingredients";
        break;

    case 'customer_orders':
        $data = fetchTable($pdo, "customer_order");
        $title = "Customer Orders";
        break;

    default:
        $data = [];
        $title = "Unknown Report";
        break;
}
?>

<main id="reports-layout">

    <div id="reports-sidebar">
        <h3>Reports</h3>
        <a href="reports.php?r=employee_roles" class="<?= $report == 'employee_roles' ? 'active' : '' ?>">Employee Roles</a>
        <a href="reports.php?r=employees" class="<?= $report == 'employees' ? 'active' : '' ?>">Employees</a>
        <a href="reports.php?r=menus" class="<?= $report == 'menus' ? 'active' : '' ?>">Menus</a>
        <a href="reports.php?r=menu_items" class="<?= $report == 'menu_items' ? 'active' : '' ?>">Menu Items</a>
        <a href="reports.php?r=ingredients" class="<?= $report == 'ingredients' ? 'active' : '' ?>">Ingredients</a>
        <a href="reports.php?r=customer_orders" class="<?= $report == 'customer_orders' ? 'active' : '' ?>">Customer Orders</a>
    </div>

    <div id="reports-content">
        <?php renderTable($title, $data); ?>
    </div>

</main>

<?php include "../includes/footer.php"; ?>