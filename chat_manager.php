<?php
	/*****************************************************************************
		Programmeur		: Vincent Fortier
		Creation		: 2019-10-25
		Modifié			: 
	*****************************************************************************/

	if($_POST["action"] == 'add')
	{
		$sQuery =
		"
			INSERT INTO chat_message 
			(to_user_id
			, from_user_id
			, chat_message) 
			VALUES (  "	. fncSetInt($_POST["to_user_id"])			. "
					, " . fncSetInt($_SESSION["user_id"]) 		. "
					, "	. fncSetString($_POST["chat_message"])		. ")
			
		";
		$oRsChatMessage = fncQueryPg($sQuery);
	}

	if($_POST["action"] == 'close')
	{
		$sQuery =
		"
			UPDATE 	chat_message
			SET 	status = true
			WHERE 	(to_user_id	= " . fncSetInt($_POST["to_user_id"]) . "
						AND	from_user_id = " . fncSetInt($_POST["from_user_id"]) . ")
					OR
					(to_user_id	= " . fncSetInt($_POST["from_user_id"]) . "
						AND	from_user_id = " . fncSetInt($_POST["to_user_id"]) . ")
			AND 	created_at::date =  now()::date
		";
		$oRsChatMessage = fncQueryPg($sQuery);
	}
		
?>
