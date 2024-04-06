<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Product List</title>
    <link rel="stylesheet" href="Home.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>

</head>



<body>

    <div class="container my-5">
        <h2 class="text-2xl font-bold mb-4" style="text-transform: uppercase; text-align: center; font-size: 30px">Student management</h2>
        <a href="addstudent_page.php" class="btnAdd">
            <span class="IconContainer">
                <box-icon type='solid' name='user-plus'></box-icon>
            </span>
            <div class="textAdd"> Add student</div>
        </a>


        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th class="border-b">ID</th>
                        <th class="border-b">Fullname</th>
                        <th class="border-b">Email</th>
                        <th class="border-b">Password</th>
                        <th class="border-b"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Database connection settings
                    $_servername = "localhost";
                    $_username = "root";
                    $_password = "";
                    $_dbname = "btec-management";

                    // Create connection;
                    $conn = new mysqli($_servername, $_username, $_password, $_dbname);

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Read all rows from database table
                    $query = "SELECT * FROM users";
                    $result = $conn->query($query);

                    if (!$result) {
                        die("Invalid query: "  .  $conn->error);
                    }

                    // Read data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "
                        <tr>
                            <td style = 'margin-left'>$row[id]</td>
                            <td>$row[fullname]</td>
                            <td>$row[email]</td>
                            <td>$row[password]</td>
                            <td class = 'functions'>
                                        <div class='OverallUpdate'>
                                            <a class='update' href='/ASM2-SDLC/update.php?id=$row[id]'>
                                                    <box-icon class = 'svgIcon' name='edit-alt' type='solid' ></box-icon>
                                            </a>
                                        </div>
                                        <div class='OverallDelete'>
                                            <a class='Delete' href='/ASM2-SDLC/delete_page.php?id=$row[id]'>
                                                <box-icon class = 'svgIcon' name='trash-alt' type='solid' ></box-icon>
                                            </a>
                                        </div>
                            </td>
                        </tr>
                        ";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>