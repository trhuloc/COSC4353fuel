<?php
// Validate and process form data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $fullName = $_POST['fullName'];
    $address1 = $_POST['address1'];
    $address2 = $_POST['address2'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zipcode = $_POST['zipcode'];

    // Perform validation
    $isValid = true;

    if (empty($fullName)) {
        echo "Full Name is required.";
        $isValid = false;
    } elseif (strlen($fullName) > 50) {
        echo "Full Name should not exceed 50 characters.";
        $isValid = false;
    }

    if (empty($address1)) {
        echo "Address 1 is required.";
        $isValid = false;
    } elseif (strlen($address1) > 100) {
        echo "Address 1 should not exceed 100 characters.";
        $isValid = false;
    }

    if (strlen($address2) > 100) {
        echo "Address 2 should not exceed 100 characters.";
        $isValid = false;
    }

    if (empty($city)) {
        echo "City is required.";
        $isValid = false;
    } elseif (strlen($city) > 100) {
        echo "City should not exceed 100 characters.";
        $isValid = false;
    }

    if (empty($state)) {
        echo "State is required.";
        $isValid = false;
    } elseif (strlen($state) !== 2) {
        echo "Invalid State format.";
        $isValid = false;
    }

    if (empty($zipcode)) {
        echo "Zipcode is required.";
        $isValid = false;
    } elseif (!preg_match('/^[0-9]{5,9}$/', $zipcode)) {
        echo "Invalid Zipcode format.";
        $isValid = false;
    }

    // If the form data is valid, prepare data for persistence
    if ($isValid) {
        // Prepare data for database persistence
        $data = [
            'fullName' => $fullName,
            'address1' => $address1,
            'address2' => $address2,
            'city' => $city,
            'state' => $state,
            'zipcode' => $zipcode
        ];

        // TODO: Persist data to the database

        // Redirect to a success page
        header("Location: profile_success.html");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Client Profile Management</title>
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
        <a href="dashboard.html" class="taskbar-button">Dashboard</a>
        <a href="fuel_quote_form.html" class="taskbar-button">Fuel Quote Form</a>
        <a href="quote_history.html" class="taskbar-button">Fuel Quote History</a>
        <a href="profile_management.php" class="taskbar-button">Profile Management</a>
        <a href="logout.php" class="taskbar-button">Logout</a>
    </div>
    <div class="container">
        <h2>Client Profile Management</h2>
        <form action="profile_management.php" method="post">
            <label for="fullName">Full Name:</label><br>
            <input type="text" id="fullName" name="fullName" maxlength="50" required><br>

            <label for="address1">Address 1:</label><br>
            <input type="text" id="address1" name="address1" maxlength="100" required><br>

            <label for="address2">Address 2:</label><br>
            <input type="text" id="address2" name="address2" maxlength="100"><br>

            <label for="city">City:</label><br>
            <input type="text" id="city" name="city" maxlength="100" required><br>

            <label for="state">State:</label><br>
            <select id="state" name="state" required>
                <option value="">Select State</option>
                <option value="AL">Alabama</option>
                <option value="AK">Alaska</option>
                <option value="AZ">Arizona</option>
                <option value="AR">Arkansas</option>
                <option value="CA">California</option>
                <option value="CO">Colorado</option>
                <option value="CT">Connecticut</option>
                <option value="DE">Delaware</option>
                <option value="FL">Florida</option>
                <option value="GA">Georgia</option>
                <option value="HI">Hawaii</option>
                <option value="ID">Idaho</option>
                <option value="IL">Illinois</option>
                <option value="IN">Indiana</option>
                <option value="IA">Iowa</option>
                <option value="KS">Kansas</option>
                <option value="KY">Kentucky</option>
                <option value="LA">Louisiana</option>
                <option value="ME">Maine</option>
                <option value="MD">Maryland</option>
                <option value="MA">Massachusetts</option>
                <option value="MI">Michigan</option>
                <option value="MN">Minnesota</option>
                <option value="MS">Mississippi</option>
                <option value="MO">Missouri</option>
                <option value="MT">Montana</option>
                <option value="NE">Nebraska</option>
                <option value="NV">Nevada</option>
                <option value="NH">New Hampshire</option>
                <option value="NJ">New Jersey</option>
                <option value="NM">New Mexico</option>
                <option value="NY">New York</option>
                <option value="NC">North Carolina</option>
                <option value="ND">North Dakota</option>
                <option value="OH">Ohio</option>
                <option value="OK">Oklahoma</option>
                <option value="OR">Oregon</option>
                <option value="PA">Pennsylvania</option>
                <option value="RI">Rhode Island</option>
                <option value="SC">South Carolina</option>
                <option value="SD">South Dakota</option>
                <option value="TN">Tennessee</option>
                <option value="TX">Texas</option>
                <option value="UT">Utah</option>
                <option value="VT">Vermont</option>
                <option value="VA">Virginia</option>
                <option value="WA">Washington</option>
                <option value="WV">West Virginia</option>
                <option value="WI">Wisconsin</option>
                <option value="WY">Wyoming</option>
            </select><br>

            <label for="zipcode">Zipcode:</label><br>
            <input type="text" id="zipcode" name="zipcode" maxlength="9" pattern="[0-9]{5,9}" required ><br>

            <input type="submit" value="Update Profile">
        </form>
    </div>
</body>

</html>