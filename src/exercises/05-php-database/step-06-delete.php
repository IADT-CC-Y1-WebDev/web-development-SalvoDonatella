<?php
require_once __DIR__ . '/lib/config.php';
// =============================================================================
// Create PDO connection
// =============================================================================
try {
    $db = new PDO(DB_DSN, DB_USER, DB_PASS, DB_OPTIONS);
} 
catch (PDOException $e) {
    echo "<p class='error'>Connection failed: " . $e->getMessage() . "</p>";
    exit();
}
// =============================================================================
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include __DIR__ . '/inc/head_content.php'; ?>
    <title>Exercise 6: DELETE Operations - PHP Database</title>
</head>
<body>
    <div class="container">
        <div class="back-link">
            <a href="index.php">&larr; Back to Database Access</a>
            <a href="/examples/05-php-database/step-06-delete.php">View Example &rarr;</a>
        </div>

        <h1>Exercise 6: DELETE Operations</h1>

        <h2>Task</h2>
        <p>Create a temporary book and then delete it.</p>

        <h3>Requirements:</h3>
        <ol>
            <li>Insert a new temporary book</li>
            <li>Display the book's ID</li>
            <li>Delete the book using a prepared statement</li>
            <li>Verify the deletion by trying to fetch it again</li>
        </ol>

        <h3>Your Solution:</h3>
        <div class="output">
            <?php
            // TODO: Write your solution here
            // 1. INSERT a temporary book
            // 2. Get the new ID
            // 3. Display "Created book with ID: X"
            // 4. DELETE FROM books WHERE id = :id
            // 5. Check rowCount()
            // 6. Try to fetch the book again to verify deletion
            $stmt = $db->prepare("
                INSERT INTO books (title, author, year, description)
                VALUES (:title, :author, :year, :description)
            ");

            $stmt->execute([
                'title' => 'Temp Book',
                'author' => 'Temp Name',
                'year' => '2024',
                'description' => 'Temporary book'
            ]);

            $newId = $db->lastInsertId();    
            echo "Temporary Book with ID: " . $newId;
            $stmt = $db->query("SELECT * FROM books WHERE id = $newId");
            $books = $stmt->fetchAll();
            ?>
            <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Year</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($books as $book): ?>
                <tr>
                    <td><?= $book['id'] ?></td>
                    <td><?= htmlspecialchars($book['title']) ?></td>
                    <td><?= htmlspecialchars($book['author']) ?></td>
                    <td><?= $book['year'] ?></td>
                    <td><?= htmlspecialchars(substr($book['description'], 0, 100)) ?></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <?php 
            $stmt = $db->prepare("DELETE FROM books WHERE id = :id");
            $stmt->execute(['id' => $newId]);

            $deleted = $stmt->rowCount();

            if ($deleted > 0) {
                echo "Deleted $deleted book(s)";
            } else {
                echo "No books found to delete";
            }
            ?>

            <?php
            $stmt = $db->query("SELECT * FROM books WHERE id = $newId");
            $books = $stmt->fetchAll();
            ?>
            <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Year</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($books as $book): ?>
                <tr>
                    <td><?= $book['id'] ?></td>
                    <td><?= htmlspecialchars($book['title']) ?></td>
                    <td><?= htmlspecialchars($book['author']) ?></td>
                    <td><?= $book['year'] ?></td>
                    <td><?= htmlspecialchars(substr($book['description'], 0, 100)) ?></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>
</body>
</html>