<?php include 'db.php';?><!DOCTYPE html>
<?php include 'db.php';?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Operations</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar">
        <img src="../images/th.webp" id="logo" alt="Logo">
        <button class="navbarbuttons" onclick="showSection('create')"> Create </button>
        <button class="navbarbuttons" onclick="showSection('read')"> Read </button>
        <button class="navbarbuttons" onclick="showSection('update')"> Update </button>
        <button class="navbarbuttons" onclick="showSection('delete')"> Delete </button>
    </nav>

    <section id="home" class="homecontent"> 
        <h1 class="splash">Welcome to Student Management System</h1>
        <h2 class="splash">A Project in Integrative Programming Technologies</h2>
    </section>
    
    <section id="create" class="content" style="display:none;">
        <h1 class="contenttitle"> Insert New Student </h1>
        <form action="insert.php" method="POST" id="studentForm">
            <label for="surname" class="label">Surname</label>
            <input type="text" name="surname" id="surname" class="field" required><br/>

            <label for="name" class="label">Name</label>
            <input type="text" name="name" id="name" class="field" required><br/>

            <label for="middlename" class="label">Middle name</label>
            <input type="text" name="middlename" id="middlename" class="field"><br/>

            <label for="address" class="label">Address</label>
            <input type="text" name="address" id="address" class="field"><br/>

            <label for="contact" class="label">Mobile Number</label>
            <input type="text" name="contact" id="contact" class="field"><br/>

            <div id="btncontainer">
                <button type="button" id="clrbtn" class="btns">Clear Fields</button><br/>
                <button type="submit" id="savebtn" class="btns">Save</button>
            </div>
        </form>   
    </section>

    <section id="read" class="content" style="display:none;"> 
    <h1 class="contenttitle">View Students</h1>
    <div id="displayRecords">
        <?php
        include 'db.php'; // This connects to your PDO file

        try {
            // Using $pdo because that is the variable name in your db.php
            $stmt = $pdo->query("SELECT * FROM students");
            
            // Start the table
            echo "<table border='1' style='width:100%; border-collapse: collapse;'>";
            echo "<tr><th>ID</th><th>Name</th><th>Surname</th><th>Address</th></tr>";
            
            // Fetch records one by one
            while ($row = $stmt->fetch()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['surname']) . "</td>";
                echo "<td>" . htmlspecialchars($row['address']) . "</td>";
                echo "</tr>";
            }
            echo "</table>";

        } catch (PDOException $e) {
            echo "<p style='color:red;'>Error: Could not connect to database or table is missing.</p>";
        }
        ?>
    </div>
</section>


    <<section id="update" class="content" style="display:none;">
    <h1 class="contenttitle">Update Student Record</h1>
    
    <form action="index.php#update" method="GET" style="margin-bottom: 20px;">
        <label>Enter Student ID to Edit:</label>
        <input type="number" name="update_id" required>
        <button type="submit">Find Student</button>
    </form>

    <?php
    include 'db.php';

    // 2. THE LOGIC TO SAVE CHANGES (POST)
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_update'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $address = $_POST['address'];

        $sql = "UPDATE students SET name = ?, surname = ?, address = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name, $surname, $address, $id]);
        echo "<p style='color:green;'>Record updated successfully!</p>";
    }

    // 3. THE LOGIC TO FETCH AND SHOW THE FORM (GET)
    if (isset($_GET['update_id'])) {
        $id = $_GET['update_id'];
        $stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
        $stmt->execute([$id]);
        $student = $stmt->fetch();

        if ($student) { ?>
            <form action="index.php#update" method="POST">
                <input type="hidden" name="id" value="<?php echo $student['id']; ?>">
                
                <label>First Name:</label>
                <input type="text" name="name" value="<?php echo $student['name']; ?>" required><br>
                
                <label>Surname:</label>
                <input type="text" name="surname" value="<?php echo $student['surname']; ?>" required><br>
                
                <label>Address:</label>
                <input type="text" name="address" value="<?php echo $student['address']; ?>"><br>
                
                <button type="submit" name="save_update">Save Changes</button>
            </form>
        <?php } else {
            echo "<p style='color:red;'>Student ID not found.</p>";
        }
    }
    ?>
</section>

    <section id="delete" class="content" style="display:none;">
    <h1 class="contenttitle">Delete Student Record</h1>

    <?php
    include 'db.php';

    // 1. THE DELETE LOGIC (Runs when the button is clicked)
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_delete'])) {
        $id = $_POST['delete_id'];

        try {
            $sql = "DELETE FROM students WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id]);
            
            echo "<p style='color:green; font-weight:bold;'>Success: Student ID #$id has been removed.</p>";
        } catch (PDOException $e) {
            echo "<p style='color:red;'>Error: " . $e->getMessage() . "</p>";
        }
    }
    ?>

    <div style="background: #f9f9f9; padding: 20px; border: 1px solid #ddd; border-radius: 8px;">
        <form action="index.php#delete" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this student?');">
            <p>Enter the ID of the student you wish to remove:</p>
            
            <label>Student ID:</label>
            <input type="number" name="delete_id" placeholder="e.g. 1" required style="padding: 8px; margin-right: 10px;">
            
            <button type="submit" name="confirm_delete" style="background-color: #ff4d4d; color: white; border: none; padding: 10px 20px; cursor: pointer; border-radius: 4px;">
                Delete Student
            </button>
        </form>
    </div>
</section>

    <div id="success-toast" class="toast-hidden">
        Registration Successful!
    </div>
    

    <script src="script.js"></script>
</body>
</html>