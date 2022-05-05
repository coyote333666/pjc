<?php
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