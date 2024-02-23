<!DOCTYPE html>
<html lang="en">

<head>
    <title>Client Profile Management</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
    <!-- You can link additional CSS files here if needed -->
</head>

<body>
    <div class="container">
        <h2>Client Profile Management</h2>
        <form action="profile_update.php" method="post">
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