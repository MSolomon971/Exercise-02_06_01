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
                //allows the user to deltet the first message 
                case 'Delete First':
                    array_shift($messageArray);
                    break;   
                //allows the user to delete the last message
                case 'Delete Last':
                    array_shift($messageArray);
                    break; 
                case 'Sort Ascending':
                    sort($messageArray);
                    break; 
                case 'Sort Descending':
                    rsort($messageArray);
                    break;
                //giving the user the chocie to delete a certain messgae
                case 'Delete Message':
                    array_splice($messageArray, $_GET['message'], 1);
                    break;
                //code if the user made the same comment twice, so they can delete the dulpicate code
                case 'Remove Duplicates':
                    $messageArray = array_unique($messageArray);
                    $messageArray = array_values($messageArray);
            }
            //
            if (count($messageArray) > 0) {
                $newMessages = implode($messageArray);
                $fileHandle = fopen("messages.txt", "wb");
                if (!$fileHandle) {
                    echo "There was an error updating the message file.\n"; 
                    $messageArray = array_values($messageArray);
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
        echo "<table style=\"background-color: lightgray\" border=\"1\" width=\"100%\">\n";
        $count = count($messageArray);
        //this create an asscoated array
        for ($i = 0; $i < $count; $i++) {
            $currMsg = explode("~", $messageArray{$i});
            $keyMessageArray[$currMsg[0]] = $currMsg[1] . "~" . $currMsg[2];
        }
        //is going to take all the plus one
        $index =1;
        $key =key($keyMessageArray);
        //this loop all the asoocate array
        foreach ($keyMessageArray as $message){
            $currMsg = explode("~", $message);
            echo "<tr>\n";
            echo "<td width=\"5%\" style=\"text-align: center; font-weight: bold\">" . $index . "</td>\n";
            echo "<td width=\"85%\"><span style=\font-weight: bold\">Subject: </span>" . htmlentities($key) . "<br>\n";
            echo "<span style=\font-weight: bold\">Name: </span>" . htmlentities($currMsg[0]) . "<br>\n";
            echo "<span style=\"text-decoration: underline; font-weight: bold\">Message: </span><br>\n" . htmlentities($currMsg[1]) . "</td>\n";
            //this code allows the user to delete a certain message by choice
            echo "<td width=\"10%\" style=\"text-align: center\">" . "<a href='MessageBoard.php?" . "action=Delete%20Message&" . "message=" . ($index -1) . "'>" . "Delete this message</a></td>\n"; 
            echo "</tr\n";
            ++$index;
            next($keyMessageArray);
            $key = key($keyMessageArray);
        }
        echo "</table>";
    }
    ?>
    <p>
        <!--hyper link ti go back to the postmessage board-->
        <a href="PostMessage.php">Post New Message</a><br>
        <!--tempering with the url        -->
        <a href="MessageBoard.php?action=Delete%20Last">Delete First Message</a><br>
        <a href="MessageBoard.php?action=Sort%20Ascending">Sort Subject A-Z</a><br>
        <a href="MessageBoard.php?action=Sort%20Descending">Sort Subject Z-A</a><br>
        <a href="MessageBoard.php?action=Delete%20Last">Delete Last Message</a><br>
<!--        <a href="MessageBoard.php?action=Remove%20Duplicates">Remove Dulpicates</a><br>-->
        
    </p>
</body>

</html>
