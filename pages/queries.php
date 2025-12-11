<?php
session_start();

include "../includes/header.php";
include "../includes/db.php";

$query = $_GET['q'] ?? '';

function loadSql($key, $defaultSql)
{
    if (isset($_GET['reset'])) {
        unset($_SESSION['userQueries'][$key]);
    }
    if (isset($_SESSION['userQueries'][$key])) {
        return $_SESSION['userQueries'][$key];
    }
    return $defaultSql;
}

function saveSqlIfPosted($key, $redirectQueryName)
{
    if (!empty($_POST['sql-text'])) {
        $_SESSION['userQueries'][$key] = $_POST['sql-text'];
        header("Location: queries.php?q=" . $redirectQueryName);
        exit;
    }
}

function runQuery($pdo, $sql)
{
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function renderSqlForm($queryName, $sql, $key)
{
?>
    <div class="query-card">
        <h2>SQL Editor</h2>
        <form action="queries.php?q=<?= $queryName ?>" method="POST" class="query-form">
            <textarea name="sql-text" class="sql-textarea"><?= $sql ?></textarea>

            <div class="query-buttons">
                <button type="submit" class="submit-query-btn">Run</button>

                <?php if (isset($_SESSION['userQueries'][$key])): ?>
                    <a href="queries.php?q=<?= $queryName ?>&reset=1" class="reset-query-btn">Reset</a>
                <?php endif; ?>
            </div>
        </form>
    </div>
<?php
}

function renderDynamicResult($rows)
{
    echo "<div class='query-results'>";
    echo "<h2>Results</h2>";

    if (empty($rows)) {
        echo "<p>No results found.</p></div>";
        return;
    }

    echo "<table class='table-report'><tr>";

    foreach (array_keys($rows[0]) as $col) {
        echo "<th>" . $col . "</th>";
    }

    echo "</tr>";

    foreach ($rows as $row) {
        echo "<tr>";
        foreach ($row as $val) {
            echo "<td>" . $val . "</td>";
        }
        echo "</tr>";
    }

    echo "</table></div>";
}
?>

<main id="queries-main">

    <div id="query-selector">
        <h1>Queries</h1>
        <form method="GET" action="queries.php">
            <select name="q" onchange="this.form.submit()">
                <option value="">-- Select a Query --</option>
                <option value="most_ordered_items" <?= $query === "most_ordered_items" ? "selected" : "" ?>>Most Ordered Items</option>
                <option value="employees_highest_revenue" <?= $query === "employees_highest_revenue" ? "selected" : "" ?>>Employees Generating Highest Revenue</option>
                <option value="average_order_value" <?= $query === "average_order_value" ? "selected" : "" ?>>Average Order Value</option>
                <option value="menu_item_ingredients" <?= $query === "menu_item_ingredients" ? "selected" : "" ?>>Menu Items with Ingredients</option>
                <option value="menu_items_per_menu" <?= $query === "menu_items_per_menu" ? "selected" : "" ?>>Menu Item Count Per Menu</option>
            </select>
        </form>
    </div>

    <div id="query-content">
        <?php
        switch ($query) {

            case 'most_ordered_items':
                $key = 'most_ordered_items';
                $defaultSql = "SELECT * FROM menu_item";

                $sql = loadSql($key, $defaultSql);
                saveSqlIfPosted($key, 'most_ordered_items');

                echo "<h1>Most Ordered Items</h1>";

                echo "<div class='query-container'>";
                renderSqlForm('most_ordered_items', $sql, $key);

                $rows = runQuery($pdo, $sql);
                renderDynamicResult($rows);
                echo "</div>";
                break;



            case 'employees_highest_revenue':
                $key = 'employees_highest_revenue';
                $defaultSql = "SELECT * FROM employee";

                $sql = loadSql($key, $defaultSql);
                saveSqlIfPosted($key, 'employees_highest_revenue');

                echo "<h1>Employees Generating Highest Revenue</h1>";

                echo "<div class='query-container'>";
                renderSqlForm('employees_highest_revenue', $sql, $key);

                $rows = runQuery($pdo, $sql);
                renderDynamicResult($rows);
                echo "</div>";
                break;



            case 'average_order_value':
                $key = 'average_order_value';
                $defaultSql = "SELECT AVG(customer_order_total_price) AS avg_value FROM customer_order";

                $sql = loadSql($key, $defaultSql);
                saveSqlIfPosted($key, 'average_order_value');

                echo "<h1>Average Order Value</h1>";

                echo "<div class='query-container'>";
                renderSqlForm('average_order_value', $sql, $key);

                $rows = runQuery($pdo, $sql);
                renderDynamicResult($rows);
                echo "</div>";
                break;



            case 'menu_item_ingredients':
                $key = 'menu_item_ingredients';
                $defaultSql = "SELECT * FROM menu_item_ingredient";

                $sql = loadSql($key, $defaultSql);
                saveSqlIfPosted($key, 'menu_item_ingredients');

                echo "<h1>Menu Items With Ingredients</h1>";

                echo "<div class='query-container'>";
                renderSqlForm('menu_item_ingredients', $sql, $key);

                $rows = runQuery($pdo, $sql);
                renderDynamicResult($rows);
                echo "</div>";
                break;



            case 'menu_items_per_menu':
                $key = 'menu_items_per_menu';
                $defaultSql = "SELECT * FROM menu_item";

                $sql = loadSql($key, $defaultSql);
                saveSqlIfPosted($key, 'menu_items_per_menu');

                echo "<h1>Menu Items Per Menu</h1>";

                echo "<div class='query-container'>";
                renderSqlForm('menu_items_per_menu', $sql, $key);

                $rows = runQuery($pdo, $sql);
                renderDynamicResult($rows);
                echo "</div>";
                break;
            default:
                echo "<h1>Select a Query</h1>";
                break;
        }

        ?>
    </div>

</main>

<?php include "../includes/footer.php"; ?>