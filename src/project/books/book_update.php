<?php
require_once 'php/lib/config.php';
require_once 'php/lib/session.php';
require_once 'php/lib/forms.php';
require_once 'php/lib/utils.php';

startSession();

try {
    $data = [];
    $errors = [];

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method.');
    }

   $data = [
        'title' => $_POST['title'] ?? null,
        'author' => $_POST['author'] ?? null,
        'year' => $_POST['year'] ?? null,
        'isbn' => $_POST['isbn'] ?? null,
        'description' => $_POST['description'] ?? null,
        'image' => $_FILES['image'] ?? null
    ];

    $rules = [
        'title' => 'required|notempty|min:1|max:255',
        'author' => 'required|notempty|min:1|max:255',
        'year' => 'required|notempty|min:4|max:4',
        'isbn' => 'required|notempty|min:13|max:13',
        'description' => 'required|notempty|min:10|max:5000',
        'image' => 'required|file|image|mimes:jpg,jpeg,png|max_file_size:5242880'
    ];

    $validator = new Validator($data, $rules);

    if ($validator->fails()) {
        foreach ($validator->errors() as $field => $fieldErrors) {
            $errors[$field] = $fieldErrors[0];
        }

        throw new Exception('Validation failed.');
    }

    $book = Book::findById($data['id']);
    if (!$book) {
        throw new Exception('Book not found.');
    }

    // // Verify platforms exist
    // foreach ($data['platform_ids'] as $platformId) {
    //     if (!Platform::findById($platformId)) {
    //         throw new Exception('One or more selected platforms do not exist.');
    //     }
    // }

    $cover_filename = null;
    $uploader = new ImageUpload();
    if ($uploader->hasFile('image')) {
        $uploader->deleteImage($book->cover_filename);

        $cover_filename = $uploader->process($_FILES['image']);

        if (!$cover_filename) {
            throw new Exception('Failed to process and save the image.');
        }
    }
    
    $book->title = $data['title'];
    $book->author = $data['author'];
    $book->year = $data['year'];
    $book->isbn = $data['isbn'];
    $book->description = $data['description'];

    $book->save();

    clearFormData();

    clearFormErrors();

    setFlashMessage('success', 'Book updated successfully.');

    redirect('book_view.php?id=' . $book->id);
}
catch (Exception $e) {
    if ($cover_filename) {
        $uploader->deleteImage($cover_filename);
    }

    setFlashMessage('error', 'Error: ' . $e->getMessage());

    setFormData($data);
    setFormErrors($errors);

    if (isset($data['id']) && $data['id']) {
        redirect('book_edit.php?id=' . $data['id']);
    }
    else {
        redirect('index.php');
    }
}
