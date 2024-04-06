<link rel="stylesheet" href="Update.css">
<?php
$_servername = "localhost";
$_username = "root";
$_password = "";
$_dbname = "btec-management";

// Create connection
$connection = new mysqli($_servername, $_username, $_password, $_dbname);

$id = "";
$fullname = "";
$email = "";
$password = "";
$errorMessage = "";
$successMessage = "";

// Check if ID parameter is provided in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Retrieve student information from the database
    $query = "SELECT * FROM users WHERE id = '$id'";
    $result = $connection->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $fullname = $row['fullname'];
        $email = $row['email'];
    } else {
        $errorMessage = "Student not found with ID: $id";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $check_sql = "SELECT * FROM users WHERE email = '$email' AND id != '$id'";
    $check_result = $connection->query($check_sql);

    if ($check_result->num_rows > 0) {
        $errorMessage = "Error: Email already exists in the system.";
    } else {
        if (empty($id) || empty($fullname) || empty($email)) {
            $errorMessage = "Complete student information is required";
        } else {
            // Update student information in the database
            $sql = "UPDATE users SET fullname = '$fullname', email = '$email'";

            // Update password if provided
            if (!empty($password)) {
                $sql .= ", password = '$hashed_password'";
            }

            $sql .= " WHERE id = '$id'";

            $result = $connection->query($sql);

            if (!$result) {
                $errorMessage = "Invalid query: " . $connection->error;
            } else {
                $id = "";
                $fullname = "";
                $email = "";
                $password = "";
                $successMessage = "Student information updated correctly";
                header("location: /ASM2-SDLC/home_page.php");
                exit;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mx-auto p-4">
        <h2 class="text-4xl font-bold mb-8 text-center">UPDATE STUDENT</h2>
        <form method="POST" action="update.php">
            <div class="mb-4">
                <div class="input-container">
                    <input type="text" name="id" id="input" value="<?php echo htmlspecialchars($id); ?>" required="">
                    <label for="input" class="label">ID student</label>
                    <div class="underline"></div>
                </div>
            </div>

            <div class="mb-4">
                <div class="input-container">
                    <input type="text" name="fullname" id="input" value="<?php echo htmlspecialchars($fullname); ?>" required="">
                    <label for="input" class="label">Full name</label>
                    <div class="underline"></div>
                </div>
            </div>

            <div class="mb-4">
                <div class="input-container">
                    <input type="text" name="email" id="input" value="<?php echo htmlspecialchars($email); ?>" required="">
                    <label for="input" class="label">Email</label>
                    <div class="underline"></div>
                </div>
            </div>

            <div class="mb-4">
            <div class="input-container">
                    <input type="text" name="password" id="input" value="<?php echo htmlspecialchars($password); ?>" required="">
                    <label for="input" class="label">Password</label>
                    <div class="underline"></div>
                </div>
            </div>

            <div class="flex justify-center space-x-4 mt-8" style="display: flex;">
                <div class="OverallAdd">
                    <button class="cssbuttons-io-button">
                        <span>Edit</span>
                    </button>
                </div>
                <div class="OverallCancelAdd">
                    <a href="home_page.php" class="CancelUpdate">
                        <div class=" TextcancelUpdate">Cancel</div>
                    </a>
                </div>
            </div>
        </form>

        <?php
        if (!empty($errorMessage)) {
            echo '<p class="text-red-500 mt-4">' . $errorMessage . '</p>';
        }

        if (!empty($successMessage)) {
            echo '<p class="text-green-500 mt-4">' . $successMessage . '</p>';
        }
        ?>
    </div>
</body>

</html>