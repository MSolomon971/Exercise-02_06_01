<!doctype html>
<!--
Author: Michael Solomon
Date: October 24, 2018
PostMessage.php
-->

<html>

<head>
    <title>Post Guest</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0">
    <script src="modernizr.custom.65897.js"></script>
</head>

<body>
    <?php
    //entry poin for user
     if (isset($_POST['submit'])) {
        $email = stripslashes($_POST['email']);
        $name = stripslashes($_POST['name']);
        //to replace a word so the user wont be able to use it 
        $email = str_replace("~", "-", $email);
        $name = str_replace("~", "-", $name);
        $existingSubjects = array();
        if (file_exists("Guest.txt") && filesize("Guest.txt") > 0) {
            $messageArray = file("Guest.txt");
            $count = count($messageArray);
            for ($i = 0; $i < $count; $i++) {
                $currMsg = explode("~", $messageArray[$i]);
                $existingSubjects[] = $currMsg[0];
            }
        } 
        if (in_array($email, $existingSubjects)) {
            echo "<p>The subject <em>\"$email\"</em> you enetered alreaedy existed!<br>\n";
            echo "Please enter a new subject and try again.<br>\n";
            echo "Your message was not saved.</p>";
            $subject = "";
        }
        else {
             $messageRecord = "$name~$email\n";
            $fileHandle = fopen("messages.txt", "ab");
            //creating a succecs or failure if the message was able to be save or not
            if (!$fileHandle) {
                echo "There was an error saving your message!\n";
            }
            else { 
                fwrite($fileHandle, $messageRecord);
                fclose($fileHandle);
                echo "Your message has been saved.\n";
                $name = "";
                $email = "";
            }
        }
    }
    else {
        $name = "";
        $email = "";
    }
    ?>
        <h1 style="text-align : center">Post Your message</h1>
        <!--HtmL Form to submit-->
        <form action="PostGuest.php" action="post">
            <!--Need input varaibels-->
            <span>Name:<input type="text" name="name" value="<?php echo $name ?>"></span><br>
            <span>Email:<input type="text" name="email" value="<?php echo $email  ?>"></span><br>

            <!--Submit buttons-->
            <input type="submit" name="submit" value="Post Message">
            <input type="reset" name="reset" value="Reest">
        </form>
        <!--Link to the php file to view message -->
    <a href="GuestBook.php">View Messages</a>
</body>
                                <!--style sheet-->
<style>
    html {
        background: rgb(209, 148, 247);
    }
    
    body {
        text-align: center;
        background-color: blanchedalmond;
        margin-left: auto;
        margin-right: auto;
        width: auto;
    }
</style>
</html>

