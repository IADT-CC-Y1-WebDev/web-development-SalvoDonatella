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
        'publisher_id' => $_POST['publisher_id'] ?? null,
        'year' => $_POST['year'] ?? null,
        'isbn' => $_POST['isbn'] ?? null,
        'description' => $_POST['description'] ?? null,
        'cover_filename' => $_FILES['cover_filename'] ?? null
    ];

    $rules = [
        'title' => 'required|notempty|min:1|max:255',
        'author' => 'required|notempty|min:1|max:255',
        'publisher_id' => 'required|notempty|integer',
        'year' => 'required|notempty|min:4|max:4',
        'isbn' => 'required|notempty|min:13|max:14',
        'description' => 'required|notempty|min:10|max:5000',
        'cover_filename' => 'required|file|image|mimes:jpg,jpeg,png|max_file_size:5242880'
    ];

    $validator = new Validator($data, $rules);

    if ($validator->fails()) {
        foreach ($validator->errors() as $field => $fieldErrors) {
            $errors[$field] = $fieldErrors[0];
        }

        throw new Exception('Validation failed.');
    }

    $uploader = new ImageUpload();
    $cover_filename = $uploader->process($_FILES['cover_filename']);

    if (!$cover_filename) {
        throw new Exception('Failed to process and save the image.');
    }

    $book = new Book();
    $book->title = $data['title'];
    $book->author = $data['author'];
    $book->year = $data['year'];
    $book->isbn = $data['isbn'];
    $book->description = $data['description'];
    $book->cover_filename = $cover_filename;

    // Save to database
    $book->save();
    // Create platform associations
    // if (!empty($data['platform_ids']) && is_array($data['platform_ids'])) {
    //     foreach ($data['platform_ids'] as $platformId) {
    //         // Verify platform exists before creating relationship
    //         if (Platform::findById($platformId)) {
    //             GamePlatform::create($game->id, $platformId);
    //         }
    //     }
    // }

    clearFormData();
    clearFormErrors();

    setFlashMessage('success', 'Book stored successfully.');

    redirect('book_view.php?id=' . $book->id);
}
catch (Exception $e) {
    if (isset($cover_filename)) {
        $uploader->deleteImage($cover_filename);
    }

    setFlashMessage('error', 'Error: ' . $e->getMessage());

    setFormData($data);
    setFormErrors($errors);

    redirect('book_create.php');
 }
