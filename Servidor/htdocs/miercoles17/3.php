<?php
    $casa = array("cocina", "salón", "habitación", "baño", "habitación", "trastero");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table border="1">
        <tr>
            <?php
                for ($i=0; $i < count($casa); $i++) { 
                    echo "<td>$casa[$i]</td>";
                }
            ?>
        </tr>
    </table>
    <br>
    <table border="1">
        <tr>
            <?php
                for ($i=count($casa) -1; $i > 1; $i--) { 
                    echo "<td>".strtoupper($casa[$i])."</td>";
                }
            ?>
        </tr>
    </table>
    <br>
    <table border="1">
        <?php
            for ($i=0; $i < 2; $i++) { 
                echo "<tr>";
                for ($j=count($casa) -1; $j >2 ; $j--) { 
                    echo "<td>$casa[$j]</td>";
                }
                echo "</tr>";
                echo "<tr>";
                for ($k=0; $k < 3; $k++) { 
                    echo "<td>$casa[$k]</td>";
                }
                echo "</tr>";
            }
        ?>
    </table>
    <br>
    <table border="1">
        <?php
            for ($i=1; $i < 4; $i++) { 
                echo "<tr><td>$i</td><td>$i</td><td>$i</td></tr>";
            }
        ?>
    </table>
    <br>
    <table border="1">
        <?php
            for ($i=1; $i < 4; $i++) { 
                echo "<tr>";
                for ($j=0; $j < 3; $j++) { 
                    echo "<td>$i</td>";
                }
                echo "</tr>";
            }
        ?>
    </table>
    <br>
    <table border="1">
        <?php
            for ($i=0; $i < 3; $i++) { 
                echo "<tr>";
                for ($j=1; $j < 4; $j++) { 
                    echo "<td>$j</td>";
                }
                echo "</tr>";
            }
        ?>
    </table>
</body>
</html>