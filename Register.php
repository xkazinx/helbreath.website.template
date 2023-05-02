<?php
include("functions.php")
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        PrintCommonHeadProperties();
    ?>
    <title>Helbreath Fury - Register</title>
</head>
<body>
    <?php
        RenderCommonBody();
    ?>

    <div class="card">
        <h2>Register</h2>
        <form action="" method="post">
            <table style="padding 0; margin: auto;">
                <tr>
                    <td>Account:</td>
                    <td><input type="text" maxlength="10"></td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td><input type="password" maxlength="10"></td>
                </tr>
                <tr>
                    <td>Quiz:</td>
                    <td><input type="text" maxlength="50"></td>
                </tr>
                <tr>
                    <td>Answer:</td>
                    <td><input type="text" maxlength="50"></td>
                </tr>
            </table>
            <br>
            <input type="submit" value="Create Account">
        </form>
    </div>
    
    </div>
    </section>
    </section>
</body>
</html>