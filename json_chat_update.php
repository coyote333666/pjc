<?php
	header("Content-type: application/json");
	
	/*****************************************************************************
		Programmeur	:	Vincent Fortier
		Créé 		:	2019-10-25
		Modifié		:	2020-04-09 VF
		Description	:	Retourne un objet json
	*****************************************************************************/
	
    $id_from 		= $_GET['id_from'];
    $id_to 			= $_GET['id_to'];
	$return_array 	= array();

	$sQuery =

	"
	SELECT c.chat_message 					AS messages
		,u.first_name						AS users
	FROM chat_message c
	LEFT JOIN chat_user u 		ON c.from_user_id = u.user_id
	WHERE 	c.from_user_id 	= " . fncSetInt($id_from) 	. "
	AND 	c.to_user_id 	= " . fncSetInt($id_to) . "
	AND c.created_at >  now() - interval '5 seconds'
	ORDER BY created_at ASC
	";
	
	$result = fncQueryPg($sQuery);


	for($y=0; $y<sizeof($result); $y++)
		{
			$row['messages'] 		= $result[$y]['messages']["VALUE"];
			$row['users'] 	= $result[$y]['users']["VALUE"];
			$return_array[] 		=  $row;
		}

   echo json_encode($return_array, JSON_UNESCAPED_UNICODE); 
   
?>
