<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/display_data.css">
    <title>Student Data</title>
</head>

<body>
<div class="custom-shape-divider-top-1673549831">
        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z" class="shape-fill"></path>
        </svg>
    </div>
    <form method="post" action="display_data.php">
        <div class="select">
            <div class="select_box">
                <label for="Standard">Standard:</label>
                <select id="Standard" name="Standard">
                    <option value="">Select</option>
                    <option value="1st">1st</option>
                    <option value="2nd">2nd</option>
                    <option value="3rd">3rd</option>
                    <option value="4th">4th</option>
                    <option value="5th">5th</option>
                    <option value="6th">6th</option>
                    <option value="7th">7th</option>
                    <option value="8th">8th</option>
                    <option value="9th">9th</option>
                    <option value="10th">10th</option>
                </select>
            </div>
            <div class="select_box">
                <label for="division">Division:</label>
                <select id="division" name="Division">
                    <option value="">Select</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                </select>
            </div>

            <br><br>

        </div>

        <br><br>
        <input type="submit" value="Submit">
    </form>
    <br>
    <?php
    if (isset($_POST['Standard']) && isset($_POST['Division'])) {
        $Standard = $_POST['Standard'];
        $Division = $_POST['Division'];

        $conn = new mysqli('localhost', 'root', '', 'schoolform');
        if ($conn->connect_error) {
            die('Connection Failed: ' . $conn->connect_error);
        } else {
            $stmt = $conn->prepare("SELECT First_name, gender,Gr, Last_name, image_file FROM users WHERE Standard = ? AND Division = ?");
            $stmt->bind_param("ss", $Standard, $Division);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                echo "<table border='1'>";
                echo "<tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>GR Number</th></th>
                    <th>Gender</th>
                    <th>Image</th>
                </tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['First_name'] . "</td>";
                    echo "<td>" . $row['Last_name'] . "</td>";
                    echo "<td>" . $row['Gr'] . "</td>";
                    echo "<td>" . $row['gender'] . "</td>";
                    echo "<td><a href='uploads/" . $row['image_file'] . "' download>Download</a></td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<div class=not_found>No data found for the selected Standard and Division</div>.";
            }
            $stmt->close();
            $conn->close();
        }
    }
    ?>
</body>

</html>