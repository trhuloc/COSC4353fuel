<!DOCTYPE html>
<html lang="en">
<head>
    <title>Fuel Quote History</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
    <style>
        .taskbar {
            background-color: #333;
            overflow: hidden;
        }

        .taskbar-button {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        .taskbar-button:hover {
            background-color: #ddd;
            color: black;
        }

        .container {
            margin-top: 50px;
        }
    </style>
</head>

<body>
    <div class="taskbar">
        <a href="dashboard.php" class="taskbar-button">Dashboard</a>
        <a href="fuel_quote_form.html" class="taskbar-button">Fuel Quote Form</a>
        <a href="quote_history.php" class="taskbar-button">Fuel Quote History</a>
        <a href="profile_management.php" class="taskbar-button">Profile Management</a>
        <a href="logout.php" class="taskbar-button">Logout</a>
    </div>
    <div class="container">
        <h2>Fuel Quote History</h2>
        <table>
            <thead>
                <tr>
                    <th>Quote ID</th>
                    <th>User ID</th>
                    <th>Gallons Requested</th>
                    <th>Delivery   Date</th>
                    <th>Suggested Price / Gallon</th>
                    <th>Total Amount Due</th>
                </tr>
            </thead>
            <tbody>
            <?php
                require_once 'Pricing.php';
                require_once 'db.php';
                if (session_status() === PHP_SESSION_NONE) {
                    @session_start();
                }
                if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
                    header("Location: login.php");
                }
                else {
                    $username = $_SESSION['username'];
                }
                if(!isset($_SESSION['username']))
                {
                    $username = "testuser";
                }

                // Retrieve UserID corresponding to the username from the usercredential table
                $stmt = $mysqli->prepare("SELECT UserID FROM usercredentials WHERE Username = ?");
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $stmt->store_result();

                // Check if a row is returned
                if ($stmt->num_rows > 0) {
                    // Bind the result variables
                    $stmt->bind_result($userID);
                    // Fetch the result
                    $stmt->fetch();
                    // Close the statement
                    $stmt->close();

                    // SQL query to fetch fuel quote history for the specific user
                    $query = "SELECT QuoteID, UserID, GallonsRequested, DeliveryDate, SuggestedPricePerGallon, TotalAmountDue FROM fuelquote WHERE UserID = ?";

                    // Prepare the query
                    $stmt = $mysqli->prepare($query);
                    // Bind parameters
                    $stmt->bind_param("i", $userID);
                    // Execute the query
                    $stmt->execute();
                    // Get the result
                    $result = $stmt->get_result();

                    // Check if there are any rows returned
                    if ($result->num_rows > 0) {
                        // Loop through each row and display data in table rows
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['QuoteID'] . "</td>";
                            echo "<td>" . $row['UserID'] . "</td>";
                            echo "<td>" . $row['GallonsRequested'] . "</td>";
                            echo "<td>" . $row['DeliveryDate'] . "</td>";
                            echo "<td>$" . $row['SuggestedPricePerGallon'] . "</td>";
                            echo "<td>$" . $row['TotalAmountDue'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        // If no data found, display a message
                        echo "<tr><td colspan='6'>No fuel quote history found for this user</td></tr>";
                    }

                    // Close the statement
                    $stmt->close();
                } else {
                    // If no user found with the given username, display an error message
                    echo "User not found";
                }

                // Close the database connection
                $mysqli->close();
                ?>

            </tbody>
        </table>
    </div>
</body>
</html>
