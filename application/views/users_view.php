<div id="body">
    <?php

        foreach($users as $row) {
            if ($row->admin == true)
            {
            echo '<div id="container">
            <div id="body">
                <h2><p>'.$row->id.' - '.$row->email.'</p></h2>
                <p>Date registered: '.$row->date_created.'</p>
                <p>Administrator</p>
                <p><a href="DeleteUser/index/'.$row->id.'">Delete user</a></p>
            </div>
        </div>';
            }

            else
            {
            echo '<div id="container">
            <div id="body">
            <h2><p>'.$row->id.' - '.$row->email.'</p></h2>
            <p>Date registered: '.$row->date_created.'</p>
            <p>Contributor</p>
            <p><a href="DeleteUser/index/'.$row->id.'">Delete user</a></p>
        </div>
        </div>';
            }
        }

    ?>
</div>