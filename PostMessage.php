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
        $existingSubjects = array();
        if (file_exists("messages.txt") && filesize("messages.txt") > 0) {
            $messageArray = file("messages.txt");
            $count = count($messageArray);
            for ($i = 0; $i < $count; $i++) {
                $currMsg = explode("~", $messageArray[$i]);
                $existingSubjects[] = $currMsg[0];
            }
        } 
        if (in_array($subject, $existingSubjects)) {
            echo "<p>The subject <em>\"$subject\"</em> you enetered alreaedy existed!<br>\n";
            echo "Please enter a new subject and try again.<br>\n";
            echo "Your message was not saved.</p>";
            $subject = "";
        }
        else {
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
                $subject = "";
                $name = "";
                $message = "";
            }
        }
    }
    else {
        $subject = "";
        $name = "";
        $message = "";
    }
    ?>
        <!--Html form to sunmbit-->
    <h1>Post New Message</h1>
    <hr>
    <form action="PostMessage.php" method="post">
    <span style="font-weight: bold">Subject: <input type="text" name="subject" value="<?php echo $subject; ?>"></span>
    <span style="font-weight: bold">Name: <input type="text" name="name" value="<?php echo $name; ?>"></span><br>
    <textarea name="message" rows="6" cols="80" style="margin: 10px 5px 5px"><?php echo $message; ?></textarea><br>
    <input type="reset" name="reset" value="Reset Form">
    <input type="submit" name="submit" value="Post Message">
    </form>
    <hr>
    <p>
        <a href="MessageBoard.php">View Messages</a>
    </p>
</body>

    <style>
        html {
            background: rgb(209, 148, 247);
        }
        
        span {
            text-align: center;
        }
    </style>
</html>
