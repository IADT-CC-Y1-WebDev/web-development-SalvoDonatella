<?php
require_once 'php/lib/config.php';
require_once 'php/lib/session.php';
require_once 'php/lib/forms.php';
require_once 'php/lib/utils.php';

startSession();

try {
    // Initialize form data array
    $data = [];
    // Initialize errors array
    $errors = [];

    // Check if request is POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method.');
    }

    // Get form data
    $data = [
        'title' => $_POST['title'] ?? null,
        'author' => $_POST['author'] ?? null,
        'year' => $_POST['year'] ?? null,
        'isbn' => $_POST['isbn'] ?? null,
        'description' => $_POST['description'] ?? null
    ];

    // Define validation rules
    $rules = [
        'title' => 'required|notempty|min:1|max:255',
        'author' => 'required|notempty|min:1|max:255',
        'year' => 'required|notempty|min:4|max:4',
        'isbn' => 'required|notempty|min:13|max:13',
        'description' => 'required|notempty|min:10|max:5000'
    ];

    // Validate all data (including file)
    $validator = new Validator($data, $rules);

    if ($validator->fails()) {
        // Get first error for each field
        foreach ($validator->errors() as $field => $fieldErrors) {
            $errors[$field] = $fieldErrors[0];
        }

        throw new Exception('Validation failed.');
    }

    // // All validation passed - now process and save
    // // Verify genre exists
    // $genre = Genre::findById($data['genre_id']);
    // if (!$genre) {
    //     throw new Exception('Selected genre does not exist.');
    // }

    // Process the uploaded image (validation already completed)
    // $uploader = new ImageUpload();
    // $imageFilename = $uploader->process($_FILES['image']);

    // if (!$imageFilename) {
    //     throw new Exception('Failed to process and save the image.');
    // }

    //Create new game instance
    $book = new Book();
    $book->title = $data['title'];
    $book->author = $data['author'];
    $book->year = $data['year'];
    $book->isbn = $data['isbn'];
    $book->description = $data['description'];

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

    // Clear any old form data
    clearFormData();
    // Clear any old errors
    clearFormErrors();

    // Set success flash message
    setFlashMessage('success', 'Book stored successfully.');

    // Redirect to book details page
    redirect('book_view.php?id=' . $book->id);
}
catch (Exception $e) {
    // // Error - clean up uploaded image
    // if (isset($imageFilename) && $imageFilename) {
    //     $uploader->deleteImage($imageFilename);
    // }

    // Set error flash message
    setFlashMessage('error', 'Error: ' . $e->getMessage());

    // Store form data and errors in session
    setFormData($data);
    setFormErrors($errors);

    redirect('book_view.php');
 }
