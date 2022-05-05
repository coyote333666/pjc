<?php
	$sQuery =
	"
		SELECT header
		FROM portlet
		WHERE portlet_name = 'portlet_99'
	";
	
	$oRecordset = fncQueryPg($sQuery);
	$header ='';
	if(sizeof($oRecordset) > 0)
	{
		$header = $oRecordset[0]["header"]["VALUE"];
	}
	echo("<div class='portlet' id='portlet_99'>");
	
	$pageJsonPortlet = false;
	if(isset($_GET["page"]))
	{
		if ((strpos($_GET["page"], 'json') !== false) || (strpos($_GET["page"], '/portlet_') !== false))
		{
			$pageJsonPortlet = true;
		}
	}

	if(!$pageJsonPortlet)
	{
		echo("<div class='portlet-header' id='portlet-header-99'>" . $header . "</div>	");
	}
?>
		<div class="portlet-content" id="portlet-content-99">
			<div class="table-responsive">
				<div id="user_details">
					<?php
					$sQuery =
					"
					SELECT DISTINCT u.first_name || ' ' || u.last_name 			AS \"Users\"
							, 	(SELECT MAX('<h4 style =''background-color:yellow''>'
								|| to_char(c.created_at, 'YYYY-MM-DD  -  HH24:MI:SS')
								|| '</h4>' 
								|| '<button type=''button'' class=''btn btn-info btn-xs close_chat'' data-touserid=''' || u.user_id 
								|| ''' data-fromuserid=''' || " . fncSetInt($_SESSION["user_id"]) . "
								|| '''>Close</button>')
								FROM chat_message c
								WHERE c.to_user_id = " . fncSetInt($_SESSION["user_id"]) . "
								AND c.from_user_id = u.user_id
								AND c.created_at::date =  now()::date
								AND status = false) 	AS \"Last message\"
							, 	'<button type=''button'' class=''btn btn-info btn-xs start_chat'' data-touserid=''' || u.user_id 
								|| ''' data-touserfirstname=''' || u.first_name 
								|| ''' data-touserlastname=''' || u.last_name 
								|| ''' data-fromuserid=''' || " . fncSetInt($_SESSION["user_id"]) . "
								|| ''' data-fromuserlastname=' || " . fncSetString($_SESSION["last_name"]) . "
								|| ' data-fromuserfirstname=' || " . fncSetString($_SESSION["first_name"]) . "
								|| '>Start</button>' AS \"Actions\"
					FROM login_details l
					LEFT JOIN chat_user u ON l.user_id = u.user_id
					WHERE l.user_id != " . fncSetInt($_SESSION["user_id"]) . "
					AND l.last_activity::date = now()::date
					ORDER BY \"Last message\",\"Users\" NULLS LAST
					";
					/* echo('<pre>' . $sQuery . '<\pre>'); */
					$oRsLoginDetails = fncQueryPg($sQuery);
					fncEchoArray($oRsLoginDetails);			
					?>
				</div>
				<div id="log"></div>
			</div>
		</div>
	</div>

    <script type="text/javascript">
    $(document).ready(function(){

		var counter = 0;
		var idList = new Array();
		
		$(document).on('click', '.start_chat', function(event, ui){
			counter ++;
			var to_user_id = $(this).data('touserid');
			var to_user_last_name = $(this).data('touserlastname');
			var to_user_first_name = $(this).data('touserfirstname');
			var from_user_id = $(this).data('fromuserid');
			var from_user_last_name = $(this).data('fromuserlastname');
			var from_user_first_name = $(this).data('fromuserfirstname');
			var id = "box_" + to_user_first_name;
			idList.push(id);
			chatboxManager.addBox(id, 
										{dest:"dest" + counter, // not used in demo
										title:"box" + counter,
										first_name:to_user_first_name,
										last_name:to_user_last_name,
										user_id:to_user_id,
										first_name_from:from_user_first_name,
										last_name_from:from_user_last_name + ' ' + counter,
										user_id_from:from_user_id,
										url: "<?php echo('?' . PARAMETER_REDIRECTOR . FILE_CHAT_MANAGER); ?>",
										action: "add",
										url_json: "<?php echo('?' . PARAMETER_REDIRECTOR . FILE_JSON_CHAT); ?>"
										//you can add your own options too
										});			
			setInterval(function(){
				$.get(
					"<?php echo('?' . PARAMETER_REDIRECTOR . FILE_JSON_CHAT_UPDATE); ?>", 
					{ id_from: to_user_id, id_to: from_user_id }, 
					function( data ) {
						for (var i = 0; i < data.length; i++){
							chatboxManager.dispatch(id,{first_name:data[i].users},data[i].messages);										
						}
					}, 'json'
				);							
			}, 5000);
			event.preventDefault();
		});
		$(document).on('click', '.close_chat', function(event, ui){
			var to_user_id = $(this).data('touserid');
			var from_user_id = $(this).data('fromuserid');
			$.post( "<?php echo('?' . PARAMETER_REDIRECTOR . FILE_CHAT_MANAGER); ?>"
				, { to_user_id: to_user_id, from_user_id: from_user_id, action: "close" })
				.done(function() {location.reload();
				});	
		});
    });
    </script>
<?php
	echo("<a href='?" . PARAMETER_REDIRECTOR . FILE_LOGIN . "'>Quit session</a>");

?>
