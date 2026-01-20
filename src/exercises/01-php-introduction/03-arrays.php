<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arrays Exercises - PHP Introduction</title>
    <link rel="stylesheet" href="/exercises/css/style.css">
</head>
<body>
    <div class="back-link">
        <a href="index.php">&larr; Back to PHP Introduction</a>
        <a href="/examples/01-php-introduction/03-arrays.php">View Example &rarr;</a>
    </div>

    <h1>Arrays Exercises</h1>

    <!-- Exercise 1 -->
    <h2>Exercise 1: Favorite Movies</h2>
    <p>
        <strong>Task:</strong> 
        Create an indexed array with 5 of your favorite movies. Use a for 
        loop to display each movie with its position (e.g., "Movie 1: 
        The Matrix").
    </p>

    <p class="output-label">Output:</p>
    <div class="output">
        <?php
        $movies = ['movie', 'hello', 'again', 'p', 'like'];
        for($i = 0; $i < count($movies); $i++) {
            echo "<li> Movie $i, $movies[$i]";
        }
        ?>
    </div>

    <!-- Exercise 2 -->
    <h2>Exercise 2: Student Record</h2>
    <p>
        <strong>Task:</strong> 
        Create an associative array for a student with keys: name, studentId, 
        course, and grade. Display this information in a formatted sentence.
    </p>

    <p class="output-label">Output:</p>
    <div class="output">
        <?php
    $student = [
        "name" => "Jim Human",
        "studentId" => "N001234567",
        "course" => "Medicine",
        "grade" => "B"
    ];

    $text = 
        "{$student['name']} or {$student['studentId']} does {$student['course']} and got a {$student['grade']}.";

    print("<p>$text</p>");
        ?>
    </div>

    <!-- Exercise 3 -->
    <h2>Exercise 3: Country Capitals</h2>
    <p>
        <strong>Task:</strong> 
        Create an associative array with at least 5 countries as keys and their 
        capitals as values. Use foreach to display each country and capital 
        in the format "The capital of [country] is [capital]."
    </p>

    <p class="output-label">Output:</p>
    <div class="output">
        <?php
    $countries = [
        "Ireland" => "Dublin",
        "Italy" => "Rome",
        "England" => "London",
        "Australia" => "Perth",
        "Portugal" => "Lisbon"
    ];

    echo "<ul>";
        foreach ($countries as $country => $capital) {
        echo "<li>The capital of $country is $capital.</li>";
    }
    echo "</ul>";
        ?>
    </div>

    <!-- Exercise 4 -->
    <h2>Exercise 4: Menu Categories</h2>
    <p>
        <strong>Task:</strong> 
        Create a nested array representing a restaurant menu with at least 
        2 categories (e.g., "Starters", "Main Course"). Each category should 
        have at least 3 items with prices. Display the menu in an organized 
        format.
    </p>

    <p class="output-label">Output:</p>
    <div class="output">
        <?php
        $menu = [
            'starters' => [
                'Bread' => "€2",
                'Olives' => "€3",
                'Tomatoes' => "€4",
            ],
            'mains' => [
                'Pizza' => "€10",
                'Pasta' => "€7",
                'Pasta 2' => "€9",
            ],
        ];

        foreach ($menu as $course => $items) {
            echo "<p>" . ucfirst($course) . " products:</p>";
            echo "<ul>";
            foreach ($items as $item => $price) {
                echo "<li>$item - $price</li>";
        }
        echo "</ul>";
    }
        ?>
    </div>

</body>
</html>
