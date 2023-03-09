<?php
	/**
	 * pjc - PHP Jquery UI chat
	 *
	 * @see https://github.com/coyote333666/pjc The pjc GitHub project
	 *
	 * @author    Vincent Fortier <coyote333666@gmail.com>
	 * @copyright 2022 Vincent Fortier
	 * @license   http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
	 * @note      This program is distributed in the hope that it will be useful - WITHOUT
	 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
	 * FITNESS FOR A PARTICULAR PURPOSE.
	 */

	session_start(); 

	define("FILE_FUNCTION"			, "../pjp/function.php"); 
	define("FILE_BODY"				, "../pjp/body.php");
	define("FILE_FOOTER"			, "../pjp/footer.php");
	define("FILE_LOGIN"				, "login.php");
	define("FILE_INDEX"				, "index.php");
	define("FILE_PORTLET_99"		, "portlet_99.php");
	define("FILE_PORTLET_UPDATE"	, "portlet_update.php");
	define("FILE_HEADER"			, "header.html");
	define("PG_SERVER"				, "localhost");
	define("PG_USERNAME"			, "test");
	define("PG_PASSWORD"			, "test");
	define("PG_DATABASE"			, "test");
	define("PG_PORT"				, "5432");						
	define("DIR_JQUERY_UI"		, "../node_modules/jquery-ui/dist/");
	define("DIR_JQUERY"			, "../node_modules/jquery/dist/");
	define("FILE_JQUERY"			, DIR_JQUERY	. "jquery.min.js");
	define("FILE_JQUERY_UI_JS"	, DIR_JQUERY_UI	. "jquery-ui.min.js");
	define("FILE_JQUERY_UI_CSS"	, DIR_JQUERY_UI	. "themes/smoothness/jquery-ui.min.css");
	define("PARAMETER_REDIRECTOR"	, "page=");
	define("FILE_CHAT_MANAGER"		, "chat_manager.php");
	define("FILE_LOGIN_MANAGER"		, "login_manager.php");
	define("FILE_DIR_CHAT"			, "../chatbox/");	
	define("FILE_CHAT_CSS"			, FILE_DIR_CHAT . "jquery.ui.chatbox.css");	
	define("FILE_CHAT_JS"			, FILE_DIR_CHAT . "jquery.ui.chatbox.js");	
	define("FILE_CHATMGR_JS"		, "chatboxManager.js");	
	define("FILE_JSON_CHAT"			, "json_chat.php");
	define("FILE_JSON_CHAT_UPDATE"	, "json_chat_update.php");

	require_once(FILE_FUNCTION);

	$pageJsonPortlet = false;
	if(isset($_GET["page"]))
	{
		if ((strpos($_GET["page"], 'json') !== false) || (strpos($_GET["page"], '/portlet_') !== false))
		{
			$pageJsonPortlet = true;
		}
	}


	if(isset($_GET["page"]) && ($_GET["page"] == FILE_LOGIN_MANAGER || $_GET["page"] == FILE_LOGIN))
	{		
		require_once($_GET["page"]);
	}
	else
	{
		if(isset($_SESSION["user_id"]))
		{
			if(!$pageJsonPortlet)
			{
				echo('<html>');
		
				require_once(FILE_HEADER);
		
				echo('</head>');
				echo('<body>');

				require(FILE_BODY);

			}
		
			if(isset($_GET["page"]))
			{
				require_once($_GET["page"]);
			}
		
			if(!$pageJsonPortlet)
			{
				require(FILE_FOOTER);	
		
				echo('</body>');
				echo('</html>');
			}
		}
		else
		{
			require_once(FILE_LOGIN);
		}
	}

?>
