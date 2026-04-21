<?php
require_once './php/lib/config.php';
require_once './php/lib/session.php';
require_once './php/lib/forms.php';
require_once './php/lib/utils.php';
 
startSession();
 
try {
    $publishers = Publisher::findAll();
    $formats = Format::findAll();
}
catch (Exception $e) {
    echo "Exception: " . $e->getMessage();
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include './php/inc/head_content.php'; ?>
    <title>Add New Book</title>
</head>
<body>

   <div class="container header">
        <div class="width-1"></div>
        <div class="width-10 headItems">
            <h1> Book<span style="color:#059c8e;">Vault</span> </h1>
        </div>
    </div>
    <?php require './php/inc/flash_message.php'; ?>
 
     <div class="container">
        <div class="width-12 instruction">
            <h1>Create Book</h1>
         </div>
            <div class="width-12 inputForm">
                <form class="verticalForm" id="book_form" action="book_store.php" method="POST" enctype="multipart/form-data" novalidate>
                    <div id="error_summary_top" class="error-summary" style="display:none" role="alert"></div>  

                    
                        <label for="title">Book Title</label>
                            <input type="text" id="title" name="title" value="<?= h(old('title')) ?>">
                            <p id="title_error" class="error"><?= error('title') ?></p>
                    

                        <label for="author">Author</label>
                            <input type="text" id="author" name="author" value="<?= h(old('author')) ?>">
                            <p id="author_error" class="error"><?= error('author') ?></p>
                    
                            
                        <label for="publisher_id">Publisher</label>
                            <select id="publisher_id" name="publisher_id">
                                <option value="">-- Select Publisher --</option>
                                <?php foreach ($publishers as $pub): ?>
                                    <option value="<?= $pub->id ?>"
                                        <?= chosen('publisher_id', $pub->id) ? "selected" : "" ?>
                                    >
                                        <?= h($pub->name) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        <p id="publisher_id_error" class="error"><?= error('publisher_id') ?></p>


                        <label for="year">Year</label>
                        <input type="text" id="year" name="year" value="<?= h(old('year')) ?>">
                        <p id="year_error" class="error"><?= error('year') ?></p>
                    

                        <label for="isbn">ISBN</label>
                        <input type="text" id="isbn" name="isbn" value="<?= h(old('isbn')) ?>">
                        <p id="isbn_error" class="error"><?= error('isbn') ?></p>
                    

                        <label>Available Formats</label>
                        <div class="checkbox-group">
                            <?php foreach ($formats as $format): ?>
                                <label class="checkbox-label">
                                    <input type="checkbox"
                                        
                                        name="format_ids[]"
                                        value="<?= $format->id ?>"
                                        <?=chosen('format_ids', $format->id) ? "checked" : "" ?>
                                    >
                                    <?= h($format->name) ?>
                                </label>
                            <?php endforeach; ?>
                        </div>
                        <p id="format_ids_error" class="error"><?= error('format_ids') ?></p>


                        <label for="description">Description</label>
                        <div class="wrapper">
                            <textarea id="description" name="description" rows="5"><?= h(old('description')) ?></textarea>
                        </div>
                        <p id="description_error" class="error"><?= error('description') ?></p>
                    

                        <label for="cover">Book Cover Image (max 2MB)</label>
                        <input type="file" id="cover_filename" name="cover_filename" accept="image/*">
                        <p id="cover_error" class="error"><?= error('cover') ?></p>
            

                        <button id="submit_btn" type="submit">Save Book</button>
                        <button> <a href="index.php">Cancel</a></button>
                    </div>
                </form>
            </div>
         </div>
    <?php 
        clearFormData();
        clearFormErrors();
    ?>

    <script src="./js/book_form.js"></script>
    </body>
</html>