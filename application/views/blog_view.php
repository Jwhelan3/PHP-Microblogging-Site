<?php

//Is the user logged in?
if ($loggedIn) {
    //Create the navigation bar for a logged in user
    //Is the user an administrator?
    
    if($admin) {
        //This user type has a different navigation bar
        $navBar = '<div id="container" align="center">
        <p>'.$myEmail.' - Administrator</p>
        <p><a href="index.php/NewPost">New Post</a> | <a href="index.php/Users">User Management</a> | <a href="index.php/Logout">Logout</a></p>
    </div>';
    }

    else {
        $navBar = '<div id="container" align="center">
        <p>'.$myEmail.' - Logged in user</p>
    <p><a href="index.php/NewPost">New Post</a> | <a href="index.php/Logout">Logout</a></p>
</div>';
    }
}

else {
    //Create the navigation bar for a guest
    $navBar = '<div id="container" align="center">
    <p><a href="index.php/Login">Login</a> | <a href="index.php/Register">Register</a></p>
</div>';
}

//Parse the blog data

?>

<div id="body" align="center">
    <?=$navBar?>
</div>

<div id="body">
    <?php

        foreach($posts as $row) {
            if ($admin == true || $row->user_id == $userID)
            {
                echo '<div id="container">
            <div id="body">
                <h2><p>'.$row->name.'</p></h2>
                <p>'.$row->date.'</p>
                <p>'.$row->body.'</p>
                <p></p>
                <p>Author ID: '.$row->user_id.'</p>
                <p align="right"><a href="EditPost/index/'.$row->id.'">Edit</a> | <a href="DeletePost/index/'.$row->id.'">Delete</a></p>
            </div>
        </div>';
            }

            else
            {
            echo '<div id="container">
            <div id="body">
                <h2><p>'.$row->name.'</p></h2>
                <p>'.$row->date.'</p>
                <p>'.$row->body.'</p>
                <p></p>
                <p>Author: '.$row->user_id.'</p>
            </div>
        </div>';
            }
        }

    ?>
</div>