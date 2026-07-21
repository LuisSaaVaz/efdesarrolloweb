<?php
    function numrandom(){
        $num = rand(0, 255);

        return $num;
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
        for ($i=1; $i < 13; $i++) { 
            $r = numrandom();
            $g = numrandom();
            $b = numrandom();
            // echo "($r, $g, $b)";

            echo "<font color=rgb($r, $g, $b) >Color $i</font><br>";
        }
        echo "<br><br>";
        for ($i=1; $i < 16; $i++) { 
            echo "<input type='text' name='dato_$i' placeholder='Dato $i' ><br>";
        }
    ?>
</body>

</html>