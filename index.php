<?php
require "includes/db.php";
require "includes/header.php";
?>

<main id="index-main">
    <h1>Database Systems Lab Expo Project</h1>
    <p>An interactive restaurant simulation system built for the Fall 2025–2026 Database Systems Lab.</p>

    <div id="index-cards">

        <div class="index-card">
            <h2>Simulation</h2>
            <p>Run the full ordering workflow: choose cashier, build an order, and submit it to the database.</p>
        </div>

        <div class="index-card">
            <h2>Reports</h2>
            <p>View the database records through read-only structured tables for inspection and verification.</p>
        </div>

        <div class="index-card">
            <h2>Queries</h2>
            <p>Explore analytical SQL queries such as most-ordered items, revenue summaries, and staff activity.</p>
        </div>

        <div class="index-card">
            <h2>CRUD Forms</h2>
            <p>Manage core data (Menu, Items, Employees, Ingredients) through simple create/edit/delete forms.</p>
        </div>
    </div>

    <p class="team">Developed by: Maher Abou Farraj, Pascal Ayoub, Tarek Hajjar, and Taimour Shmait</p>

</main>


<?php
require "includes/footer.php";
?>