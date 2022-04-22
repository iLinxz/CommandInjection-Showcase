<!DOCTYPE html>
<html lang="en">
    <!-- MEDIUM LEVEL -->
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/style.css">
    <title>Command Injection Showcase</title>
</head>
<body>
    <main>
    <?php if ($_SERVER["REQUEST_METHOD"] === "GET") : ?>
        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
            <div>
                <label for="name">Search for locally stored files...</label><br>
                <input type="text" name="query" placeholder="Submit query!" />
            </div>
            <button type="submit">Submit</button>
        </form>
    <?php else : ?>
        <?php
            if (isset($_POST["query"])){
            $str = $_POST["query"];
            $filtered_string = preg_replace("/[^a-zA-Z0-9-_.]/", "", $str);
            if (strval(strlen($filtered_string)) === '0'){
                echo "No input present.";}
            else{
            echo nl2br("SEARCHING FOR $filtered_string --> WHAT DID YOU FIND? \r\n");
            $command = ("/usr/bin/find . -name " . "'*" . $str . "*'" . " -ls 2>/dev/null");
            echo "command is: $command";
            exec("/usr/bin/find . -name" . " '*" . $str . "*'" . " -ls 2>/dev/null", $output);
            foreach($output as $value){
                echo $value."<br />";
            }        }        }
        ?>
    <?php endif ?>
    </main>
</body>
</html>