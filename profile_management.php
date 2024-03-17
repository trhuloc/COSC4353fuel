<?php 
session_start(); 

// Check if session already exists
if(!isset($_SESSION['obj'])) {
    $_SESSION['obj'] = array();
} 

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitize inputs
    if (!empty($_POST['fullName'])) {
        $_SESSION['obj']['fullName'] = filter_input(
            INPUT_POST,
            'fullName',
            FILTER_SANITIZE_FULL_SPECIAL_CHARS
        );
    }
    else {
        $_SESSION['obj']['fullName'] = '';
    }

    if (!empty($_POST['address1'])) {
        $_SESSION['obj']['address1'] = filter_input(
            INPUT_POST,
            'address1',
            FILTER_SANITIZE_FULL_SPECIAL_CHARS
        );
    }
    else {
        $_SESSION['obj']['address1'] = '';
    }

    if (!empty($_POST['address2'])) {
        $_SESSION['obj']['address2'] = filter_input(
            INPUT_POST,
            'address2',
            FILTER_SANITIZE_FULL_SPECIAL_CHARS
        );
    }
    else {
        $_SESSION['obj']['address2'] = '';
    }

    if (!empty($_POST['city'])) {
        $_SESSION['obj']['city'] = filter_input(
            INPUT_POST,
            'city',
            FILTER_SANITIZE_FULL_SPECIAL_CHARS
        );
    }
    else {
        $_SESSION['obj']['city'] = '';
    }
    
    $state = $_POST['state'];

    if (!empty($_POST['zipcode'])) {
        $_SESSION['obj']['zipcode'] = filter_input(
            INPUT_POST,
            'zipcode',
            FILTER_SANITIZE_NUMBER_INT
        );
    }
    else {
        $_SESSION['obj']['zipcode'] = '';
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
        <?php 
        if (isset($_SESSION['obj']['fullName'])) {
            echo "Hello " . $_SESSION['obj']['fullName'];
        }
        ?>
        <h2>Client Profile Management</h2>
        <form action="profile_management.php" method="post">
            <label for="fullName">Full Name:</label><br>
            <input type="text" id="fullName" name="fullName" maxlength="50" required value="<?php echo isset($_SESSION['obj']['fullName']) ? $_SESSION['obj']['fullName'] : ''; ?>"><br>

            <label for="address1">Address 1:</label><br>
            <input type="text" id="address1" name="address1" maxlength="100" required value="<?php echo isset($_SESSION['obj']['address1']) ? $_SESSION['obj']['address1'] : ''; ?>"><br>

            <label for="address2">Address 2:</label><br>
            <input type="text" id="address2" name="address2" maxlength="100" value="<?php echo isset($_SESSION['obj']['address2']) ? $_SESSION['obj']['address2'] : ''; ?>"><br>

            <label for="city">City:</label><br>
            <input type="text" id="city" name="city" maxlength="100" required value="<?php echo isset($_SESSION['obj']['city']) ? $_SESSION['obj']['city'] : ''; ?>"><br>
            
            <label for="state">State:</label><br>
            <select id="state" name="state" required>
                <option value="">Select State</option>
                <option value="AL" <?php echo isset($state) && $state == 'AL' ? 'selected' : ''; ?>>Alabama</option>
                <option value="AK" <?php echo isset($state) && $state == 'AK' ? 'selected' : ''; ?>>Alaska</option>
                <option value="AZ" <?php echo isset($state) && $state == 'AZ' ? 'selected' : ''; ?>>Arizona</option>
                <option value="AR" <?php echo isset($state) && $state == 'AR' ? 'selected' : ''; ?>>Arkansas</option>
                <option value="CA" <?php echo isset($state) && $state == 'CA' ? 'selected' : ''; ?>>California</option>
                <option value="CO" <?php echo isset($state) && $state == 'CO' ? 'selected' : ''; ?>>Colorado</option>
                <option value="CT" <?php echo isset($state) && $state == 'CT' ? 'selected' : ''; ?>>Connecticut</option>
                <option value="DE" <?php echo isset($state) && $state == 'DE' ? 'selected' : ''; ?>>Delaware</option>
                <option value="FL" <?php echo isset($state) && $state == 'FL' ? 'selected' : ''; ?>>Florida</option>
                <option value="GA" <?php echo isset($state) && $state == 'GA' ? 'selected' : ''; ?>>Georgia</option>
                <option value="HI" <?php echo isset($state) && $state == 'HI' ? 'selected' : ''; ?>>Hawaii</option>
                <option value="ID" <?php echo isset($state) && $state == 'ID' ? 'selected' : ''; ?>>Idaho</option>
                <option value="IL" <?php echo isset($state) && $state == 'IL' ? 'selected' : ''; ?>>Illinois</option>
                <option value="IN" <?php echo isset($state) && $state == 'IN' ? 'selected' : ''; ?>>Indiana</option>
                <option value="IA" <?php echo isset($state) && $state == 'IA' ? 'selected' : ''; ?>>Iowa</option>
                <option value="KS" <?php echo isset($state) && $state == 'KS' ? 'selected' : ''; ?>>Kansas</option>
                <option value="KY" <?php echo isset($state) && $state == 'KY' ? 'selected' : ''; ?>>Kentucky</option>
                <option value="LA" <?php echo isset($state) && $state == 'LA' ? 'selected' : ''; ?>>Louisiana</option>
                <option value="ME" <?php echo isset($state) && $state == 'ME' ? 'selected' : ''; ?>>Maine</option>
                <option value="MD" <?php echo isset($state) && $state == 'MD' ? 'selected' : ''; ?>>Maryland</option>
                <option value="MA" <?php echo isset($state) && $state == 'MA' ? 'selected' : ''; ?>>Massachusetts</option>
                <option value="MI" <?php echo isset($state) && $state == 'MI' ? 'selected' : ''; ?>>Michigan</option>
                <option value="MN" <?php echo isset($state) && $state == 'MN' ? 'selected' : ''; ?>>Minnesota</option>
                <option value="MS" <?php echo isset($state) && $state == 'MS' ? 'selected' : ''; ?>>Mississippi</option>
                <option value="MO" <?php echo isset($state) && $state == 'MO' ? 'selected' : ''; ?>>Missouri</option>
                <option value="MT" <?php echo isset($state) && $state == 'MT' ? 'selected' : ''; ?>>Montana</option>
                <option value="NE" <?php echo isset($state) && $state == 'NE' ? 'selected' : ''; ?>>Nebraska</option>
                <option value="NV" <?php echo isset($state) && $state == 'NV' ? 'selected' : ''; ?>>Nevada</option>
                <option value="NH" <?php echo isset($state) && $state == 'NH' ? 'selected' : ''; ?>>New Hampshire</option>
                <option value="NJ" <?php echo isset($state) && $state == 'NJ' ? 'selected' : ''; ?>>New Jersey</option>
                <option value="NM" <?php echo isset($state) && $state == 'NM' ? 'selected' : ''; ?>>New Mexico</option>
                <option value="NY" <?php echo isset($state) && $state == 'NY' ? 'selected' : ''; ?>>New York</option>
                <option value="NC" <?php echo isset($state) && $state == 'NC' ? 'selected' : ''; ?>>North Carolina</option>
                <option value="ND" <?php echo isset($state) && $state == 'ND' ? 'selected' : ''; ?>>North Dakota</option>
                <option value="OH" <?php echo isset($state) && $state == 'OH' ? 'selected' : ''; ?>>Ohio</option>
                <option value="OK" <?php echo isset($state) && $state == 'OK' ? 'selected' : ''; ?>>Oklahoma</option>
                <option value="OR" <?php echo isset($state) && $state == 'OR' ? 'selected' : ''; ?>>Oregon</option>
                <option value="PA" <?php echo isset($state) && $state == 'PA' ? 'selected' : ''; ?>>Pennsylvania</option>
                <option value="RI" <?php echo isset($state) && $state == 'RI' ? 'selected' : ''; ?>>Rhode Island</option>
                <option value="SC" <?php echo isset($state) && $state == 'SC' ? 'selected' : ''; ?>>South Carolina</option>
                <option value="SD" <?php echo isset($state) && $state == 'SD' ? 'selected' : ''; ?>>South Dakota</option>
                <option value="TN" <?php echo isset($state) && $state == 'TN' ? 'selected' : ''; ?>>Tennessee</option>
                <option value="TX" <?php echo isset($state) && $state == 'TX' ? 'selected' : ''; ?>>Texas</option>
                <option value="UT" <?php echo isset($state) && $state == 'UT' ? 'selected' : ''; ?>>Utah</option>
                <option value="VT" <?php echo isset($state) && $state == 'VT' ? 'selected' : ''; ?>>Vermont</option>
                <option value="VA" <?php echo isset($state) && $state == 'VA' ? 'selected' : ''; ?>>Virginia</option>
                <option value="WA" <?php echo isset($state) && $state == 'WA' ? 'selected' : ''; ?>>Washington</option>
                <option value="WV" <?php echo isset($state) && $state == 'WV' ? 'selected' : ''; ?>>West Virginia</option>
                <option value="WI" <?php echo isset($state) && $state == 'WI' ? 'selected' : ''; ?>>Wisconsin</option>
                <option value="WY" <?php echo isset($state) && $state == 'WY' ? 'selected' : ''; ?>>Wyoming</option>
            </select><br>
            
            <label for="zipcode">Zipcode:</label><br>
            <input type="text" id="zipcode" name="zipcode" maxlength="9" pattern="[0-9]{5,9}" required value="<?php echo isset($_SESSION['obj']['zipcode']) ? $_SESSION['obj']['zipcode'] : ''; ?>"><br>

            <input type="submit" value="Update Profile">
        </form>
    </div>
</body>

</html>