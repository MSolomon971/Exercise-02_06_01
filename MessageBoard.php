<!doctype html>

<!--
Author: Michael Solomon
Date: October 19, 2018
MessageBoard.php
-->

<html>

<head>
    <title>Post New Message</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0">
    <script src="modernizr.custom.65897.js"></script>
</head>

<body>
        <!--Html form to sunmbit-->
    <h1>Message Board</h1>
    <?php 
    //if the user got here by datt attach by the url
    if (isset($_GET['action'])){
        //to test the exitence of the file size
        if (file_exists("messages.txt") && filesize("messages.txt") != 0) {
            $messageArray = file("messages.txt");
            switch ($_GET['action']) {
                case 'Delete First':
                    array_shift($messageArray);
                    break;   
                case 'Delete Last':
                    array_shift($messageArray);
                    break;
                case 'Delete Message':
                    array_splice($messageArray, $_GET['message'], 1);
                    break;
            }
            if (count($messageArray) > 0) {
                $newMessages = implode($messageArray);
                $fileHandle = fopen("messages.txt", "wb");
                if (!$fileHandle) {
//                    echo "There was an error updating the message file.\n"; 
                    $index = $_GET['message'];
                    unset($messageArray[$index]);
                }
                else {
                fwrite($fileHandle, $newMessages);
                fclose($fileHandle);
              
            }
        }
        else {
            unlink("messages.txt");
            }
        }
    }
  
    //succes or failure
    if (!file_exists("messages.txt") || filesize("messages.txt") == 0) {
        echo "<p>there are no message posted.</p>";
    }
    else {
        $messageArray = file("messages.txt");
        //debug
//    echo "<pre>\n";
//    print_r($messageArray);
//    echo "</pre>\n";
        echo "<table style=\"background-color: lightgray\" border=\"1\" width=\"100%\">\n";
        $count = count($messageArray);
        //a loop to count to see all messages
        for ($i = 0; $i < $count; $i++){
            $currMsg = explode("~", $messageArray[$i]);
            echo "<tr>\n";
            echo "<td width=\"5%\" style=\"text-align: center; font-weight: bold\">" . ($i + 1) . "</td>\n";
            echo "<td width=\"85%\"><span style=\font-weight: bold\">Subject: </span>" . htmlentities($currMsg[0]) . "<br>\n";
            echo "<span style=\font-weight: bold\">Name: </span>" . htmlentities($currMsg[1]) . "<br>\n";
            echo "<span style=\"text-decoration: underline; font-weight: bold\">Message: </span><br>\n" . htmlentities($currMsg[2]) . "</td>\n";
            echo "<td width=\"10%\" style=\"text-align: center\">" . "<a href='MessageBoard.php?" . "action=Delete%20msg&" . "message=$i'>" . "Delete this message</a></td>\n"; 
            echo "</tr\n";
        }
        echo "</table>";
    }
    ?>
    <p>
        <!--hyper link ti go back to the postmessage board-->
        <a href="PostMessage.php">Post New Message</a><br>
        <!--tempering with the url        -->
        <a href="MessageBoard.php?action=Delete%20Last">Delete First Message</a><br>
        <a href="MessageBoard.php?action=Delete%20Last">Delete Last Message</a><br>
        
    </p>
</body>

</html>
