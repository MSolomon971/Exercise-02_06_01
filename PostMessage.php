<!doctype html>

<!--
Author: Michael Solomon
Date: October 19, 2018
PostMessage.php
-->

<html>

<head>
    <title>Post New Message</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0">
    <script src="modernizr.custom.65897.js"></script>
</head>

<body>
    <?php
    //entry poin for user
    //to send data? yes - process. No - display formed
    if (isset($_POST['submit'])) {
        $subject = stripslashes($_POST['subject']);
        $name = stripslashes($_POST['name']);
        $message = stripslashes($_POST['message']);
        //to replace a word so the user wont be able to use it 
        $subject = str_replace("~", "-", $subject);
        $message = str_replace("~", "-", $message);
        $name = str_replace("~", "-", $name);
        $messageRecord = "$subject~$name~$message\n";
        $fileHandle = fopen("messages.txt", "ab");
        //creating a succecs or failure if the message was able to be save or not
        if (!$fileHandle) {
            echo "There was an error saving your message!\n";
        }
        else { 
            fwrite($fileHandle, $messageRecord);
            fclose($fileHandle);
            echo "Your message has been saved.\n";
        }
        
        
        
    }
    ?>
        <!--Html form to sunmbit-->
    <h1>Post New Message</h1>
    <hr>
    <form action="PostMessage.php" method="post">
    <span style="font-weight: bold">Subject: <input type="text" name="subject"></span>
    <span style="font-weight: bold">Name: <input type="text" name="name"></span><br>
    <textarea name="message" rows="6" cols="80" style="margin: 10px 5px 5px"></textarea><br>
    <input type="reset" name="reset" value="Reset Form">
    <input type="submit" name="submit" value="Post Message">
    </form>
    <hr>
    <p>
        <a href="MessageBoard.php">View Messages</a>
    </p>
</body>

</html>
