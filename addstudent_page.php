<?php
$_servername = "localhost";
$_username = "root";
$_password = "";
$_dbname = "btec-management";

// Create connection
$connection = new mysqli($_servername, $_username, $_password, $_dbname);

$id = "";
$fullname = "";
$masv = "";
$email = "";
$password = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $check_sql = "SELECT * FROM users WHERE email = '$email'";
    $check_result = $connection->query($check_sql);

    if ($check_result->num_rows > 0) {
        $errorMessage = "Error: Email already exists in the system.";
    } else {
        if (empty($id) || empty($fullname) || empty($email) || empty($password)) {
            $errorMessage = "Complete student information is required";
        } else {
            // Add new student to the database
            $stmt = $connection->prepare("INSERT INTO users (id, fullname, email, password) VALUES (?,?,?, ?)");
            $stmt->bind_param("ssss", $id, $fullname, $email, $hashed_password);

            if ($stmt->execute()) {
                $id = "";
                $fullname = "";
                $email = "";
                $password = "";
                $successMessage = "Student added correctly";
                header("location: /ASM2-SDLC/home_page.php");

                // header("location: /ASM2-SDLC/home_page.php");
                exit;
            } else {
                $errorMessage = "Error executing query: " . $stmt->error;
            }

            $stmt->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="Add.css">
</head>

<body>
    <div class="container mx-auto p-4">
        <h2 class="text-2xl font-bold mb-4" style="text-align: center;">ADD STUDENT</h2>
        <form method="POST" action="addstudent_page.php">
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

            <div class="mb-4" style="display: flex;">
                    <div class="OverallAdd">
                        <button class="cssbuttons-io-button">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                <path fill="none" d="M0 0h24v24H0z"></path>
                                <path fill="currentColor" d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z"></path>
                            </svg>
                            <span>Add</span>
                        </button>
                    </div>
                <!-- <input type="submit" value="Add Student" class="btn btn-custom"> -->
                <div class="OverallCancelAdd">
                    <a href="home_page.php" class="CancelAdd">

                        <div class=" TextcancelAdd">Cancel</div>
                    </a>
                </div>
            </div>
        </form>

        <?php
        if (!empty($errorMessage)) {
            echo '<p class="text-danger mt-4">' . $errorMessage . '</p>';
        }

        if (!empty($successMessage)) {
            echo '<p class="text-success mt-4">' . $successMessage . '</p>';
        }
        ?>
    </div>
</body>

</html>