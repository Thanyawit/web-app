<html>
<head>
</head>

<body>
    <h3>Welcome</h3>
    <!-- start logout -->
    <form action="logout.php">
        <input type="submit" name="logout" value="Logout">
    </form>
    <!-- stop logout -->

    <form name="myForm" action="add_status.php" method="get" onsubmit="return validateForm()">
    Suggestion: <span id="txtHint"></span>
    <table border="1">
        <!-- <tr>
            <td>STATUS ID</td>
            <td><input type="text" name="status_id"></td>
        </tr> -->
        <tr>
            <td>STATUS THAI</td>
            <td><input type="text" name="status_th" id="status_th" onkeyup="showHint(this.value)"></td>
        </tr>
        <tr>
            <td>STATUS ENGLISH</td>
            <td><input type="text" name="status_en"></td>
        </tr>  
        <tr>
            <td colspan="2">
                <input type="submit" value="ADD">
                <input type="button" value="Check Duplicate" onclick="showHint()">
            </td>
        </tr>              
    </table>
    </form>

    <?php
        // ฟอร์มสำหรับการค้นหา
        $txtSearch = "";
        $type = "";

        if(isset($_GET['txtSearch'])) $txtSearch = $_GET['txtSearch'];
        if(isset($_GET['Type']))      $type = $_GET['Type'];    
    ?>
    <!-- Start HTML Form for Search -->
    <table border="1">
        <form>
        <tr>
            <td>ค้นหา: </td>
            <td><input type="text" name="txtSearch" size="14" value="<?php echo $txtSearch?>"></td>
            <td>
                <select name="Type">
                    <option value="1" <?php if($type == 1) echo "selected" ?> > STATUS ID </option>
                    <option value="2" <?php if($type == 2) echo "selected" ?> > STATUS THAI </option>
                    <option value="3" <?php if($type == 3) echo "selected" ?> > STATUS ENGLISH </option>
                </select>
            </td>
            <td><input type="submit" value="Search"></td>
        </tr>
        </form>
    </table>
    <!-- Stop HTML Form for Search -->

    <table border="1">
        <tr>
            <td>STATUS ID</td>
            <td>STATUS THAI</td>
            <td>STATUS ENGLISH</td>
            <td></td>
            <td></td>
        </tr>
        <?php

    // 1. Connect 
    require("sv.php");

    //$sql = "SELECT STATUS_ID, STATUS_TH, STATUS_EN FROM status";
    //$sql = "SELECT * FROM status";
    // $sql = "SELECT * FROM status WHERE STATUS_ID = 9";
    //$sql = "SELECT * FROM status WHERE STATUS_ID = " . $txtSearch;

    // 2. Select SQL
    $sql = "SELECT * FROM status ";

        // 1. STATUS_ID
    if($type == 1) {
        $sql .= "WHERE STATUS_ID LIKE '%" . $txtSearch . "%'";
    }
        // 2. STATUS_TH
    else if($type == 2) {
        $sql .= "WHERE STATUS_TH LIKE '%" . $txtSearch . "%'";
    }
        // 3. STATUS_EN
    else if($type == 3) {
        $sql .= "WHERE STATUS_EN LIKE '%" . $txtSearch . "%'";
    }

    // 3. Execute
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            //echo "id: " . $row["STATUS_ID"]. " - Name: " . $row["STATUS_TH"]. " " . $row["STATUS_EN"]. "<br>";
            echo "<form action='update_status.php' method='get'>";
            echo "<tr>";
                echo "<td><input type='text' name='status_id' size='5' value=" . $row["STATUS_ID"]. " readonly></td>";
                echo "<td><input type='text' name='status_th' size='5' value=" . $row["STATUS_TH"]. " ></td>";
                echo "<td><input type='text' name='status_en' size='5' value=" . $row["STATUS_EN"]. " ></td>"; 
                echo "<td><input type='submit' name='send' value='Delete' onClick='return confirmDelete()'></td>";   
                echo "<td><input type='submit' name='send' value='Edit'></td>";       
            echo "</tr>";
            echo"</form>";
        }
    } else {
        echo "0 results";
    }

    mysqli_close($conn);
?>

    </table>

</body>

</html>