<?php
require_once 'php/lib/config.php';
require_once 'php/lib/session.php';
require_once 'php/lib/forms.php';
require_once 'php/lib/utils.php';
 
startSession();
// dd($_SESSION);
try {
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        throw new Exception('Invalid request method.');
    }
    if (!array_key_exists('id', $_GET)) {
        throw new Exception('No book ID provided.');
    }
    $id = $_GET['id'];
 
    $book = Book::findById($id);
    if ($book === null) {
        throw new Exception("Book not found.");
    }
 
    $bookFormats = Format::findByBook($id);
    $bookFormatIds = [];
    foreach ($bookFormats as $format) {
        $bookFormatIds[] = $format->id;
    }
 
    $formats = Format::findAll();
    $publishers = Publisher::findAll();
}
catch (PDOException $e) {
    setFlashMessage('error', 'Error: ' . $e->getMessage());
    redirect('/index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include 'php/inc/head_content.php'; ?>
        <title>Edit Book</title>
    </head>
    <body>

    <div class="container header">
        <div class="width-1"></div>
        <div class="width-10 headItems">
            <h1> Book<span style="color:#059c8e;">Vault</span> </h1>
        </div>
    </div>

        <div class="container">
            <div class="width-12 instruction">
                <h1>Edit Book</h1>
            </div>
            <div class="width-12 inputForm">
                <form class="verticalForm" id=book_form action="book_update.php" method="POST" enctype="multipart/form-data" novalidate>
                    <div id="error_summary_top" class="error-summary" style="display:none" role="alert"></div>  

                    <div class="input">
                        <input type="hidden" name="id" value="<?= h($book->id) ?>">
                    </div>
                    <div class="input">
                        <label  for="title">Title</label>
                        <div>
                            <input type="text" id="title" name="title" value="<?= old('title', $book->title) ?>" required>
                            <p  id="title_error" class="error"><?= error('title') ?></p>
                        </div>
                    </div>

                    <div class="input">
                        <label  for="author">Author</label>
                        <div>
                            <input type="text" id="author" name="author" value="<?= old('author', $book->author) ?>" required>
                            <p id="author_error" class="error"><?= error('author') ?></p>
                        </div>
                    </div>

                    <div class="input">
                        <label  for="publisher_id">Publisher</label>
                        <div>
                            <select id="publisher_id" name="publisher_id" required>
                                <?php foreach ($publishers as $publisher) { ?>
                                    <option value="<?= h($publisher->id) ?>" <?= chosen('publisher_id', $publisher->id, $book->id) ? "selected" : "" ?>>
                                        <?= h($publisher->name) ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <p id="publisher_id_error" class="error"><?= error('publisher_id') ?></p>
                        </div>
                    </div>

                    <div class="input">
                        <label  for="year">Year</label>
                        <div>
                            <input type="text" id="year" name="year" value="<?= old('year', $book->year) ?>" required>
                            <p id="year_error" class="error"><?= error('year') ?></p>
                        </div>
                    </div>

                    <div class="input">
                        <label  for="isbn">ISBN</label>
                        <div>
                            <input type="text" id="isbn" name="isbn" value="<?= old('isbn', $book->isbn) ?>" required>
                            <p id="isbn_error" class="error"><?= error('isbn') ?></p>
                        </div>
                    </div>
                    
                    <div class="input">
                        <label>Formats</label>
                        <div class="formats">
                            <?php foreach ($formats as $format) { ?>
                                <div class="format">
                                    <label for="format_<?= h($format->id) ?>"><?= h($format->name) ?></label>
                                    <input type="checkbox"
                                        id="format_<?= h($format->id) ?>"
                                        name="format_ids[]"
                                        value="<?= h($format->id) ?>"
                                        <?= chosen('format_ids', $format->id, $bookFormatIds) ? "checked" : "" ?>
                                    >
                                </div>
                            <?php } ?>
                        <p id="format_ids_error" class="error"><?= error('format_ids') ?></p>
                    </div>
                </div>
                        
                    <div class="input">
                        <label  for="description">Description</label>
                        <div class="wrapper">
                            <textarea id="description" name="description" rows="5" required><?= old('description', $book->description) ?></textarea>
                            <p id="description_error" class="error"><?= error('description') ?></p>
                        </div>
                    </div>
                    <div><img src="images/<?= $book->cover_filename ?>" /></div>

                    <div class="input">
                        <label  for="cover_filename">Image (optional)</label>
                        <div>
                            <input type="file" id="cover_filename" name="cover_filename" accept="image/*">
                        </div>
                    </div>

                    <div class="input" style="display:flex; gap:20px;">
                        <button id="submit_btn" type="submit">Update Book</button>
                        <button> <a href="index.php">Cancel</a></button>
                    </div>
                </form>

                <?php 
                    clearFormData();
                    clearFormErrors();
                ?>
            </div>
            <div class="width-12">
                <?php require 'php/inc/flash_message.php'; ?>
            </div>
        </div>
    

        <script src="./js/book_form.js"></script>
 
    </body>
</html>
