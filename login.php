<?php
// clean variables session
$_SESSION = array();
?>

<form action='<?php echo("?" . PARAMETER_REDIRECTOR . FILE_LOGIN_MANAGER); ?>' method='post' class='login'>


<label for="user_choice">Choose a user:</label>

<select name="user_choice" id="user_choice">
    <option value="1">John Smith</option>
    <option value="2">Pierre Tremblay</option>
</select>

<input type='submit' value='Submit'>

</form>
