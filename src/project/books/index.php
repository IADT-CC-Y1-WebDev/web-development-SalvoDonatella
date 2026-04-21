<?php
require_once 'php/lib/config.php';
require_once 'php/lib/utils.php';
require_once 'php/classes/DB.php';
require_once 'php/classes/Book.php';


try {
    $books = Book::findAll();
    $publishers = Publisher::findAll();
    $formats = Format::findAll();

} 
catch (PDOException $e) {
    die("<p>PDO Exception: " . $e->getMessage() . "</p>");
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include 'php/inc/head_content.php'; ?>
        <title>Books</title>

    <style>
        .card.hidden {
	        display: none;
        }
    </style>
    </head>
    <body>
    <div class="container header">
        <div class="width-1"></div>
        <div class="width-10 headItems">
            <h1> Book<span style="color:#059c8e;">Vault</span> </h1>
            <div class="header-button">
                <a href="book_create.php">Add New Book</a>
            </div>
        </div>
    </div>

        <div class="container">
            <div class="width-12">
                <?php require 'php/inc/flash_message.php'; ?>
            </div>
            <form id="filters" class="width-12 filters">
                <div class="input">
                    <div>
                        <input type="text" id="title_filter" name="title_filter" placeholder="Search Books...">
                    </div>
                </div>
            <div class="input">
                <div>
                    <select id="publisher_filter" name="publisher_filter">
                        <option value="">All publishers</option>
                        <?php foreach ($publishers as $publisher): ?>
                            <option value="<?= htmlspecialchars($publisher->id) ?>">
                                <?= htmlspecialchars($publisher->name) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="input">
                <div>
                    <select id="format_filter" name="format_filter">
                        <option value="">All formats</option>
                        <?php foreach ($formats as $format): ?>
                            <option value="<?= htmlspecialchars($format->id) ?>">
                                <?= htmlspecialchars($format->name) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="input">
                <div>
                    <select id="sort_by" name="sort_by">
                        <option value="title_asc">Title A–Z</option>
                        <option value="year_desc">Year (newest first)</option>
                        <option value="year_asc">Year (oldest first)</option>
                    </select>
                </div>
            </div>
            <div class="input">
                <div>
                    <button type="button" id="apply_filters">Apply Filters</button>
                </div>
            </div>
            <div class="input">
                <div>
                    <button type="button" id="clear_filters">Clear Filters</button>
                </div>
            </div>
            
        </form>
        </div>
        <div class="container">
            <?php if (empty($books)) { ?>
                <p>No book found.</p>
            <?php } else { ?>
                <div id="book_cards" class="width-12 cards">
                    <?php foreach ($books as $book) { 
                        $bookFormats = Format::findByBook($book->id);
                        $bookFormatIds = [];
                        foreach ($bookFormats as $format) {
                            $bookFormatIds[] = $format->id;
                        }
                        ?>
                        <div class="card"
                            data-title="<?= htmlspecialchars($book->title) ?>" 
                            data-publisher="<?= htmlspecialchars($book->publisher_id) ?>"
                            data-format="[<?= implode(",", $bookFormatIds) ?>]"
                            data-year="<?= htmlspecialchars($book->year) ?>">

                            <div class="top-content">
                                 <?php 
                                    $limit = 20;
                                    $text = $book->title;
                                    if (strlen($text) > $limit) {
                                        $preview = substr($text, 0, $limit) . "...";
                                    } else {
                                        $preview = $text;
                                    }
                                ?>
                                <h2 class="book-title"><?= $preview ?></h2>
                                <p>By <?= h($book->author) ?></p>
                            </div>
                            <div class="bottom-content">
                                <img src="images/<?= h($book->cover_filename) ?>" alt="Image for <?= h($book->title) ?>" />
                                <div class="actions">
                                    <a href="book_view.php?id=<?= h($book->id) ?>">VIEW</a> |
                                    <a href="book_edit.php?id=<?= h($book->id) ?>">EDIT</a> |
                                    <a href="book_delete.php?id=<?= h($book->id) ?>">DELETE</a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>

        <script src="./js/book_filters.js"></script>
    </body>
</html>