<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <title>Login Form</title>
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-300">
  <div class="p-8 max-w-md w-full bg-white rounded shadow">
    <h2 class="text-3xl font-bold mb-6 text-center">Login</h2>
    <form action="signin_page.php" method='post'>
      <div class="mb-6">
        <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
        <input id="email" name="email" type="email" placeholder="Enter your email" class="w-full px-4 py-3 border border-gray-300 rounded focus:outline-none focus:border-indigo-500">
      </div>
      <div class="mb-6">
        <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
        <input name="password" id="password" type="password" placeholder="Enter your password" class="w-full px-4 py-3 border border-gray-300 rounded focus:outline-none focus:border-indigo-500">
      </div>

      <div class="flex flex-col md:flex-row md:justify-between">
      <button type="submit" name="button_login" class="w-full md:w-auto bg-yellow-500 text-white font-bold py-3 px-6 rounded focus:outline-none focus:shadow-outline hover:bg-blue-600">Log In</button>
      <button type="submit" name="button_regist" class="w-full md:w-auto mt-4 md:mt-0 bg-green-500 text-white font-bold py-3 px-6 rounded focus:outline-none focus:shadow-outline hover:bg-green-600">Sign Up</button>
      </div>
    </form>
  </div>
</body>

</html>

<?php
      $_servername = "localhost";
      $_username = "root";
      $_password = "";
      $_dbname = "btec-management";
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      if (isset($_POST['button_login'])) {

        $email = $_POST['email'];
        $password = $_POST['password'];
        $hash_password = password_hash($password, PASSWORD_DEFAULT);
        // Create a connection
        $conn = new mysqli($_servername, $_username, $_password, $_dbname);
        // Check connection
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }
        // Check if the email and password match
        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($query);

        if ($result->num_rows == 1) {
              $row = $result->fetch_assoc();
              $storedHash = $row['password'];
              if (password_verify($password, $storedHash)) {
                header("Location: home_page.php");
                exit();
              } else {
                $error = "Invalid email or password";
              }      
              exit();
        }
        else {
                echo "Fail";
                $error = "Invalid email or password";
        }
        $conn->close();
        exit(); // Make sure to exit after redirecting
      } elseif (isset($_POST['button_regist'])) {
        // Button 2 is clicked, redirect to page2.php
        header("Location: signup_page.php");
        exit(); // Make sure to exit after redirecting
      }
    }
    ?>