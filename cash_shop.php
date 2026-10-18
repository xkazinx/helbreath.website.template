<?php
include("functions.php")
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        PrintCommonHeadProperties();
    ?>
    <title>Helbreath Fury - Cash Shop</title>
</head>
<body>
    <?php
        RenderCommonBody();
    ?>

<div class="card">
        <h2>Cash Shop</h2>
        <form action="" method="post">
            <table style="padding 0; margin: auto;">
                <tr>
                    <td>Character Name:</td>
                    <td><input type="text" maxlength="10"></td>
                </tr>
                <tr>
                    <td>Coins amount:</td>
                    <td><input type="text" maxlength="10"></td>
                </tr>
            </table>
            <br>
            <input type="submit" value="Purchase">
        </form>
    </div>

    </div>
    </section>
    </section>
</body>
</html>