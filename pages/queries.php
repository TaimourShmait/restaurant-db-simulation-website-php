<?php
include "../includes/header.php";
include "../includes/db.php";

$query = $_GET['q'] ?? '';

?>

<main id="queries-main">
    <div id="queries-side-container">
        <h2>Queries</h2>
        <nav id="queries-side-nav">
            <a href="queries.php?q=most_ordered_items">Most Ordered Items</a>
            <a href="queries.php?q=employees_highest_revenue">Employees Generating Highest Revenue</a>
            <a href="queries.php?q=average_order_value">Average Order Value</a>
            <a href="queries.php?q=menu_item_ingredients">Menu Items with their Ingredients</a>
            <a href="queries.php?q=menu_items_per_menu">Menu Item Count Per Menu</a>
        </nav>
    </div>

    <div id="query-container">
        <?php
        switch ($query) {
            case 'most_ordered_items':
                $stmt = $pdo->prepare("SELECT * FROM menu_item");
                $stmt->execute();
                $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
                break;
            case 'employees_highest_revenue':
                echo "Hello, again!";
                break;
            case 'average_order_value':
                echo "Hello!!!";
                break;
            case 'menu_item_ingredients':
                echo "Hello, again!!!";
                break;
            case 'menu_items_per_menu':
                echo "Hello, there!";
                break;
            case '':
                echo "Nothing here!";
                break;
        };
        ?>
    </div>
</main>


<?php
include "../includes/footer.php";
?>