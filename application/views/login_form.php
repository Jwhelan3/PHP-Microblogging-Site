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
	<h1>Login</h1>
    <form id="login" name="login" method="post">
	<div id="body">
		<p><?=$error_msg?></p>
        <table class="formTable" width="80%" position="center">
            <thead>
            <tr>
                <th colspan="2">Login</th>
            </tr>
            </thead>
            <tbody>
            <?=$msg_display?>
            <tr>
                <td>Email: </td>
                <td><input type="text" id="email" name="email"></td>
            </tr>
            <tr>
                <td>Password: </td>
                <td><input type="password" id="password" name="password"></td>
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