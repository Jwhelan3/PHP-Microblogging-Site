<?php

$msg_display = "";

if($error == 1)
{
    $msg_display =' <tr>
    <td colspan="2">'.$error_msg.'</td>
</tr>';
}

?>

<div id="container">
	<h1>Edit Post</h1>
    <form id="addPost" name="addPost" method="post">
	<div id="body">
		<p><?=$error_msg?></p>
        <table class="formTable" width="80%" position="center">
            <thead>
            <tr>
                <th colspan="2">Edit a post</th>
            </tr>
            </thead>
            <tbody>
            <?=$msg_display?>
            <tr>
                <td>Title: </td>
                <td><input type="text" id="title" name="title" value="<?=$title?>"></td>
            </tr>
            <tr>
                <td>Content: </td>
                <td><textarea rows="10" cols="45" id="content" name="content" value="<?=$body?>"></textarea></td>
            </tr>
            <tr>
                <td colspan="2>"><input type="submit"></td>
            </tr>
            </tbody>
        </table>
        <p></p>
	</div>
    </form>
</div>