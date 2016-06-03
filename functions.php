<?php

function menu($chatid, $message)
{
  global $API_URL, $username;

  switch($message)
  {
    case "/start":
      //When a user joins the bot, give him a warm welcome :D
      $menua = array("START EATING", "STOP EATING", "PURGE URGE", "BINGE URGE");
      
      if(isset($username)) $welcome_msg = "Hey @$username whats'up. Welcome to eStoppy\nUse /help for commands list";
      elseif(isset($first_name)) $welcome_msg = "Hey $first_name, Welcome to eStoppy\nUse /help for commands list";
      else $welcome_msg = "Hey, Welcome to eStoppy, press one of the buttons below";
      build_keyboard($menua, $welcome_msg, $chatid);
      break;

    case "START EATING":
      //Build keyboard and change action in order to waiting a specific answer in the next step
      $menua = array("Great", "Optimistic", "Sad", "Upset", "Alright", "Anxious", "Nervous");
      build_keyboard($menua, "How are you feeling right now?", $chatid);
      //Action 0 FEELING
      change_action('0', $chatid);
      break;

     default:
      menu_keyboard($chatid, "Wrong choice!");
      break;
   
    case "STOP EATING":
      //Build keyboard and change action in order to waiting a specific answer in the next step
      $menua = array("Do you feel satisfied with your meal?", "Do you feel satiated?", "Did you enjoy your meal?", "Do you feel full?");
      build_keyboard($menua, "How do feel about your meal?", $chatid);
      //Action 0 FEELING
      change_action('0', $chatid);
      break;
     
    
    case "PURGE URGE":
      //Build keyboard and change action in order to waiting a specific answer in the next step
      $menua = array("Take a walk", "Read a book", "Have a shower", "Massage your feet");
      build_keyboard($menua, "Thank you for being brave and using this companion, choose one of the options below", $chatid);
      //Action 0 FEELING
      change_action('0', $chatid);
      break; 


   case "BINGE URGE":
      //Build keyboard and change action in order to waiting a specific answer in the next step
      $menua = array("Watch a movie", "Check out Russell Peter's StandUp Comedy", "Do five situps", "Phone a friend");
      build_keyboard($menua, "Thank you for being brave and using this companion, choose one of the options below", $chatid);
      //Action 0 FEELING
      change_action('0', $chatid);
      break;
   
 }
}

function feeling()
{
  global $API_URL, $message, $chatid;

  switch($message)
  {
    case "Great":
      //Do something
      send_msg($chatid, "Wonderful, your response has been recorded, have a wonderful day");
      return true;
      break;

    case "Optimistic":
      send_msg($chatid, "Awesome! your response has been recorded, have a wonderful day");
      return true;
      break;

    case "Sad":
      send_msg($chatid, "Oh :(, Why are you feeling sad?");
      return true;
      break;

    case "Upset":
      send_msg($chatid, "Oh :(, What happened?");
      return true;
      break;

    case "Alright":
      send_msg($chatid, "That's okay, your response has been recorded, have a wonderful day");
      return true;
      break;

    case "Anxious":
      send_msg($chatid, "Oh :(, Stop & Breathe! ");
      return true;
      break;

    case "Nervous":
      send_msg($chatid, "Oh :(, What are you nervous about?");
      return true;
      break;

     case "Do you feel satisfied with your meal?":
      send_msg($chatid, "Thank you, your response has been recorded");
      return true;
      break;
    
     case "Do you feel satiated?":
      send_msg($chatid, "Thank you, your response has been recorded");
      return true;
      break;

     case "Did you enjoy your meal?":
      send_msg($chatid, "Thank you, your response has been recorded");
      return true;
      break;

     case "Do you feel full?":
      send_msg($chatid, "Thank you, your response has been recorded");
      return true;
      break;
    
    case "Take a walk":
      send_msg($chatid, "Walks are good for your health and you will feel better after this");
      return true;
      break;

    case "Read a book":
      send_msg($chatid, "My recommended reading list has fantastic fiction, The Girl with the Dragon Tattoo by Stieg Larsson");
      return true;
      break;

   case "Have a shower":
      send_msg($chatid, "Baths can be really soothing, throw in some good bath salts and listen to your favourite playlist");
      return true;
      break;

    case "Massage your feet":
      send_msg($chatid, " A pretty manicure and pedicure makes me feel better! Massage your feet for luxurious stress relief ");
      return true;
      break;

   case "Watch a movie":
      send_msg($chatid, "I am watching Game Of Thrones, what are you watching?");
      return true;
      break;
   
   case "Watch standup comedy":
      send_msg($chatid, "Check out Russell Peter on YouTube! Hillarious!");
      return true;
      break;
  
   case "Do five sit-ups":
      send_msg($chatid, "Count to Twenty!");
      return true;
      break;
  
  case "Call a friend":
      send_msg($chatid, "Always a good distraction!");
      return true;
      break;

    default:
      send_msg($chatid, "Wrong choice, please take one from the button menu");
      return false;
      break;
  }
}
     

//$elements is an array of elements for your keyboard, you have to fill it up
function build_keyboard($elements, $message, $chatid)
{
  global $API_URL;

  //Get length of array
  $len = count($elements);
  //Building keyboard
  $keyboard = "{\"keyboard\":[ [\"";
  for($i = 0; $i < $len; ++$i)
  {
    //Paint keyboard 2 btn by 2 btn
    if($i%2 == 0 && $i == $len-1) $keyboard .= $elements[$i]."\"] ]}";
    //When reached last elements of keyboard
    elseif($i%2 == 0) $keyboard .= $elements[$i]."\",\"";
    elseif($i < $len-1) $keyboard .= $elements[$i]."\"],[\"";
    else $keyboard .= $elements[$i]."\"] ]}";
  }

  //send_msg($chatid, $keyboard);

  $url = $API_URL."/sendmessage?chat_id=$chatid&text=".urlencode($message)."&reply_markup=".urlencode($keyboard);
  file_get_contents($url);
}

function yesno_keyboard($chatid, $msg)
{
  global $API_URL;

  $key = "{\"keyboard\":[ [\"YES\"], [\"NO\"] ]}";
  $url = $API_URL."/sendmessage?chat_id=$chatid&text=".urlencode($msg)."&reply_markup=".urlencode($key);
  file_get_contents($url);
}

function menu_keyboard($chatid, $msg)
{
  global $API_URL;

  $key = "{\"keyboard\":[ [\"START EATING\", \"STOP EATING\"], [\"PURGE URGE\", \"BINGE URGE\"] ]}";
  $url = $API_URL."/sendmessage?chat_id=$chatid&text=".urlencode($msg)."&reply_markup=".urlencode($key);
  file_get_contents($url);
}

//change action using user id
function change_action($action, $id)
{
  global $userfolder;

  //send_msg($id, "Please clear your history and start again");
  $file = fopen($userfolder."/".$id, "w");
  fwrite($file, $action);
  fclose($file);
}

//Return current action of user
function get_action($id)
{
  global $userfolder;
  $file = fopen($userfolder."/".$id ,"r");
  $str = fread($file, filesize($userfolder."/".$id));
  fclose($file);
  return $str;
}

function send_msg($chatid, $text)
{
 global $API_URL;

 $url = $API_URL."/sendmessage?chat_id=".$chatid."&text=".urlencode($text);
 file_get_contents($url);
}

?>
