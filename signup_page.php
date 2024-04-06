<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Registration Form</title>
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-300">
    <div class="p-8 max-w-md w-full bg-white rounded shadow">
        <h2 class="text-3xl font-bold mb-6 text-center">Register</h2>
        <form action="signup_page.php" method="post">
            <div class="mb-6">
                <label for="fullname" class="block text-gray-700 text-sm font-bold mb-2">Full Name</label>
                <input id="fullname" name="fullname" type="text" placeholder="Enter your full name" class="w-full px-4 py-3 border border-gray-300 rounded focus:outline-none focus:border-indigo-500">
            </div>
            <div class="mb-6">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input id="email" name="email" type="email" placeholder="Enter your email" class="w-full px-4 py-3 border border-gray-300 rounded focus:outline-none focus:border-indigo-500">
            </div>
            <div class="mb-6">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <input id="password" name="password" type="password" placeholder="Enter your password" class="w-full px-4 py-3 border border-gray-300 rounded focus:outline-none focus:border-indigo-500">
            </div>
            <div class="mb-6">
                <label for="confirm_password" class="block text-gray-700 text-sm font-bold mb-2">Confirm Password</label>
                <input id="confirm_password" name="confirm_password" type="password" placeholder="Confirm your password" class="w-full px-4 py-3 border border-gray-300 rounded focus:outline-none focus:border-indigo-500">
            </div>

            <div class="flex flex-col md:flex-row md:justify-between">
                <button type="submit" name="button_login" class="w-full md:w-auto bg-yellow-500 text-white font-bold py-3 px-6 rounded focus:outline-none focus:shadow-outline hover:bg-yellow-600">Log In</button>
                <button type="submit" name="button_regist" class="w-full md:w-auto mt-4 md:mt-0 bg-green-500 text-white font-bold py-3 px-6 rounded focus:outline-none focus:shadow-outline hover:bg-green-600">Sign Up</button>
            </div>
        </form>
    </div>
</body>

</html>

<?php
// Database connection settings
$_servername = "localhost";
$_username = "root";
$_password = "";
$_dbname = "btec-management";
$conn = new mysqli($_servername, $_username, $_password, $_dbname);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process the submitted data
    if (isset($_POST['button_regist'])) {
        $email = $_POST['email'];
        $fullname = $_POST['fullname'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $hash_password  = password_hash($password, PASSWORD_DEFAULT);
        // Check if the email already exists
        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            echo '<script>alert("Email already exists!");</script>';
        } else {
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Prepare the insert statement
            $stmt = $conn->prepare("INSERT INTO users (fullname, password, email) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $fullname, $hash_password, $email);

            if ($stmt->execute()) {
                echo "New user created successfully!";
                header("Location: signin_page.php");
            } else {
                echo "Error: " . $stmt->error;
            }
            // Close the statement and the database connection
            $stmt->close();
            $conn->close();
        }
    } else
    if (isset($_POST['button_login'])) {
        header("Location: signin_page.php");
        exit(); 
    }
    exit();
}
?>