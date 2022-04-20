<!DOCTYPE html>
<html lang="en">
<!-- EASIEST TO CRACK -->
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/style.css">
    <title>Command Injection Showcase</title>
</head>
<body>
    <main>
    <?php if ($_SERVER["REQUEST_METHOD"] == "GET") : ?>
        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
            <div>
                <label for="name">Search for locally stored files...</label><br>
                <input type="text" name="query" required="required" placeholder="Submit query!" />
            </div>
            <button type="submit">Submit</button>
        </form>
    <?php else : ?>
        <?php
            if (isset($_POST['query'])){
            $str = $_POST['query'];
            echo nl2br("SEARCHING FOR $str --> WHAT DID YOU FIND? \r\n");
            exec("/usr/bin/find . -name $str -ls 2>/dev/null || /usr/bin/find . -name '$str*' -ls 2>/dev/null", $output);
            foreach($output as $value){
                echo $value."<br />";
            }
        }
            else{
                echo("No input parameter present.");
            }
        ?>
    <?php endif ?>
    </main>
</body>
</html>