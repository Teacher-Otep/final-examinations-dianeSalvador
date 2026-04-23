<?php
include 'db.php'; // Using your working PDO connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $surname = $_POST['surname'];
    $name = $_POST['name'];
    $middlename = $_POST['middlename'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];

    try {
        $sql = "INSERT INTO students (surname, name, middlename, address, contact_number) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$surname, $name, $middlename, $address, $contact]);

        // Redirect back to index.php after saving
        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>