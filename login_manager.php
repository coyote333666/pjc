<?php
		$sQuery =
		"
		DELETE FROM login_details 
		WHERE user_id = " . $_POST["user_choice"] . "
		AND last_activity::date = now()::date
		";
		$oRsDetails = fncQueryPg($sQuery);

		$sQuery =
		"
		INSERT INTO login_details 
		(user_id) 
		VALUES (" . $_POST["user_choice"] . ")
		RETURNING login_details_id				
		";
		$oRsDetails = fncQueryPg($sQuery);
		$_SESSION["login_details_id"] = $oRsDetails[0]["login_details_id"]["VALUE"];

		$sQuery =
		"
		select user_id
		,first_name
		,last_name
		from chat_user
		where user_id = " . $_POST["user_choice"] . "
		";
		$oRsChatUser = fncQueryPg($sQuery);

		$_SESSION["user_id"]	= $oRsChatUser[0]["user_id"]["VALUE"];
		$_SESSION["first_name"]	= $oRsChatUser[0]["first_name"]["VALUE"];
		$_SESSION["last_name"]	= $oRsChatUser[0]["last_name"]["VALUE"];

?>

<script type='text/javascript'>
	window.location.href = '<?php echo("./"); ?>';
</script>