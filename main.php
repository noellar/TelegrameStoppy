<?php

 ini_set('error_reporting', E_ALL);

	include("functions.php");

 $BOT_TOKEN = "235524062:AAHLClo3BhzUbPRWOFN5JhijWmzxcP0_8MI"; 
 $API_URL = "https://api.telegram.org/bot".$BOT_TOKEN;

 $update = file_get_contents("php://input");
 $update = json_decode($update, TRUE);

 $chatid = $update["message"]["chat"]["id"];
 $message = $update["message"]["text"];
 $userfolder = "users/";
 
/*open_keyboard($chatid, "Choose one");
switch ($message)
{
    case "/name":
       send_msg($chatid, "I am eStoppy, nice to meet you ");
       break;
     case "/hi":
       send_msg($chatid, "hey there!");
       break;
    
    /* case "/start":
      //When a user joins the bot, give him a warm welcome :D
      $menua = array("START EATING", "STOP EATING", "PURGE URGE", "BINGE URGE");
      
      if(isset($username)) $welcome_msg = "Hey @$username whats'up. Welcome to eStoppy\nUse /help for commands list";
      elseif(isset($first_name)) $welcome_msg = "Hey $first_name, Welcome to eStoppy\nUse /help for commands list";
      else $welcome_msg = "Hey, Welcome to eStoppy, press one of the buttons below";
      build_keyboard($menua, $welcome_msg, $chatid);
      break;        

     default:
	//send_msg($chatId, "Wrong command");
	break;
}*/

//if user file exists continue with program
 if(file_exists($userfolder."/".$chatid))
 {
  /*
  Action -1 needs to show main menu!
  I suppose 10 action for each Button pressed
  First action of every command is the main menu of the action (0, 10, 20, 30, etc...)
  START EATING action 0 to 9
  STOP EATING action 10 to 19
  etc etc
  */
  switch(get_action($chatid))
  {
    //Main menu for action 0 START EATING
    //Here I will show to the user main menu
    case '-1':
     // send_msg($chatid, "Action -1, main menu");
      menu($chatid, $message);
      break;

    //Case 0 expect feeling now!
    case '0':
      //send_msg($chatid, "Action 0, Available Options");

      //If return from feeling is true proceed
      if(feeling())
      {
        menu_keyboard($chatid, $message);
        change_action(-1, $chatid);
      }
      //Else user will should be repeat right answer
      //else change_action(0, $chatid);
      break;
  
  }
}
//Else create his personal file and continue with program
else
{
  //create file for user
  $file = fopen("users/$chatid", "w");
  fclose($file);

  //Set his action to 0 = main action
  change_action(-1, $chatid);

}

?>
