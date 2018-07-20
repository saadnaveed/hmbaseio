<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

function startsWith($haystack, $needle)
{
     $length = strlen($needle);
     return (substr($haystack, 0, $length) === $needle);
}

function processFocus($focusType, &$agentInfoType, $key) {
  $dbCols = 28;
  for ($j = 0; $j < count($focusType); $j++) {
      for ($z = 4; $z < $dbCols; $z++) {
        if ($focusType[$j][$z] != '' && $focusType[$j][$z] != 'LNCH') {
          $agentInfoType[$key]['TotalHours'] += 0.5;
        }

        if (startsWith($focusType[$j][$z], 'IB/')) {
          $agentInfoType[$key]['IBHours'] += 0.5;
        }

        if (startsWith($focusType[$j][$z], 'IC/')) {
          $agentInfoType[$key]['ICHours'] += 0.5;
        }

        if (startsWith($focusType[$j][$z], 'ZD/')) {
          $agentInfoType[$key]['ZDHours'] += 0.5;
        }

        if (startsWith($focusType[$j][$z], 'H/')) {
          $agentInfoType[$key]['HiringHours'] += 0.5;
        }

        if ($focusType[$j][$z] == 'ACT') {
          $agentInfoType[$key]['ACTHours'] += 0.5;
        }

        if ($focusType[$j][$z] == 'ACT/O') {
          $agentInfoType[$key]['ACTOHours'] += 0.5;
        }

        if (startsWith($focusType[$j][$z], 'O')) {
          $agentInfoType[$key]['OpenHours'] += 0.5;
        }

        if (startsWith($focusType[$j][$z], 'TR')) {
          $agentInfoType[$key]['TrainerHours'] += 0.5;
        }

        if (startsWith($focusType[$j][$z], 'TT')) {
          $agentInfoType[$key]['TraineeHours'] += 0.5;
        }

        if (startsWith($focusType[$j][$z], 'TC')) {
          $agentInfoType[$key]['TCHours'] += 0.5;
        }

        if ($focusType[$j][$z] == 'TM') {
          $agentInfoType[$key]['TMHours'] += 0.5;
        }

        if (!startsWith($focusType[$j][$z], 'IC/') && !startsWith($focusType[$j][$z], 'IB/') && !startsWith($focusType[$j][$z], 'ZD/') && $focusType[$j][$z] != '' && $focusType[$j][$z] != 'TM' && $focusType[$j][$z] != 'LNCH' && !startsWith($focusType[$j][$z], 'H/') && !startsWith($focusType[$j][$z], 'ACT/O') && !startsWith($focusType[$j][$z], 'TT') && !startsWith($focusType[$j][$z], 'TR') && $focusType[$j][$z] != 'ACT' && $focusType[$j][$z] != 'O' && $focusType[$j][$z] != 'TC') {
          //echo $focusType[$i]."<br />";
          $agentInfoType[$key]['OtherHours'] += 0.5;
          $otherItemsListThisWeek[] = $focusType[$j][$z];
          $agentInfoType[$key]['OtherHoursList'][] = $focusType[$j][$z];
        }
      }
  }
}

function displayStats($agentInfoType, $key) {

  $percentInfo = array(
    'ICHoursPercent' => 0,
    'IBHoursPercent' => 0,
    'ZDHoursPercent' => 0,
    'HiringHoursPercent' => 0,
    'ACTHoursPercent' => 0,
    'ACTOHoursPercent' => 0,
    'OpenHoursPercent' => 0,
    'OtherHoursPercent' => 0,
    'TrainerHoursPercent' => 0,
    'TraineeHoursPercent' => 0,
    'TCHoursPercent' => 0,
    'TMHoursPercent' => 0,
    'TaskHoursPercent' => 0,
    'TotalHoursPercent' => 0,
  );

  $percentInfo['ICHoursPercent'] = number_format((float)(($agentInfoType[$key]['ICHours'] / $agentInfoType[$key]['TotalHours']) * 100), 2, '.', '');

  $percentInfo['IBHoursPercent'] = number_format((float)(($agentInfoType[$key]['IBHours'] / $agentInfoType[$key]['TotalHours']) * 100), 2, '.', '');

  $percentInfo['OtherHoursPercent'] = number_format((float)(($agentInfoType[$key]['OtherHours'] / $agentInfoType[$key]['TotalHours']) * 100), 2, '.', '');

  $percentInfo['ZDHoursPercent'] = number_format((float)(($agentInfoType[$key]['ZDHours'] / $agentInfoType[$key]['TotalHours']) * 100), 2, '.', '');

  $percentInfo['ACTHoursPercent'] = number_format((float)(($agentInfoType[$key]['ACTHours'] / $agentInfoType[$key]['TotalHours']) * 100), 2, '.', '');

  $percentInfo['ACTOHoursPercent'] = number_format((float)(($agentInfoType[$key]['ACTOHours'] / $agentInfoType[$key]['TotalHours']) * 100), 2, '.', '');

  $percentInfo['HiringHoursPercent'] = number_format((float)(($agentInfoType[$key]['HiringHours'] / $agentInfoType[$key]['TotalHours']) * 100), 2, '.', '');

  $percentInfo['OpenHoursPercent'] = number_format((float)(($agentInfoType[$key]['OpenHours'] / $agentInfoType[$key]['TotalHours']) * 100), 2, '.', '');

  $percentInfo['TrainerHoursPercent'] = number_format((float)(($agentInfoType[$key]['TrainerHours'] / $agentInfoType[$key]['TotalHours']) * 100), 2, '.', '');

  $percentInfo['TraineeHoursPercent'] = number_format((float)(($agentInfoType[$key]['TraineeHours'] / $agentInfoType[$key]['TotalHours']) * 100), 2, '.', '');

  $percentInfo['TCHoursPercent'] = number_format((float)(($agentInfoType[$key]['TCHours'] / $agentInfoType[$key]['TotalHours']) * 100), 2, '.', '');

  $percentInfo['TMHoursPercent'] = number_format((float)(($agentInfoType[$key]['TMHours'] / $agentInfoType[$key]['TotalHours']) * 100), 2, '.', '');

  if ($agentInfoType[$key]['IBHours'] != 0) {
    echo '<h5>IB ('.$percentInfo['IBHoursPercent'].'%) </h5><span style="color: gray; font-size: 10px;">['.$agentInfoType[$key]['IBHours'].' / '.$agentInfoType[$key]['TotalHours'].' hours]</span><br><br>';
  }

  if ($agentInfoType[$key]['ZDHours'] != 0) {
    echo '<h5>ZD ('.$percentInfo['ZDHoursPercent'].'%) </h5><span style="color: gray; font-size: 10px;">['.$agentInfoType[$key]['ZDHours'].' / '.$agentInfoType[$key]['TotalHours'].' hours]</span><br><br>';
  }

  if ($agentInfoType[$key]['ICHours'] != 0) {
    echo '<h5>IC ('.$percentInfo['ICHoursPercent'].'%) </h5><span style="color: gray; font-size: 10px;">['.$agentInfoType[$key]['ICHours'].' / '.$agentInfoType[$key]['TotalHours'].' hours]</span><br><br>';
  }

  if ($agentInfoType[$key]['HiringHours'] != 0) {
    echo '<h5>Hiring ('.$percentInfo['HiringHoursPercent'].'%) </h5><span style="color: gray; font-size: 10px;">['.$agentInfoType[$key]['HiringHours'].' / '.$agentInfoType[$key]['TotalHours'].' hours]</span><br><br>';
  }

  if ($agentInfoType[$key]['ACTHours'] != 0) {
    echo '<h5>ACT ('.$percentInfo['ACTHoursPercent'].'%) </h5><span style="color: gray; font-size: 10px;">['.$agentInfoType[$key]['ACTHours'].' / '.$agentInfoType[$key]['TotalHours'].' hours]</span><br><br>';
  }

  if ($agentInfoType[$key]['ACTOHours'] != 0) {
    echo '<h5>ACT/O ('.$percentInfo['ACTOHoursPercent'].'%) </h5><span style="color: gray; font-size: 10px;">['.$agentInfoType[$key]['ACTOHours'].' / '.$agentInfoType[$key]['TotalHours'].' hours]</span><br><br>';
  }

  if ($agentInfoType[$key]['OpenHours'] != 0) {
    echo '<h5>Open ('.$percentInfo['OpenHoursPercent'].'%) </h5><span style="color: gray; font-size: 10px;">['.$agentInfoType[$key]['OpenHours'].' / '.$agentInfoType[$key]['TotalHours'].' hours]</span><br><br>';
  }

  if ($agentInfoType[$key]['TrainerHours'] != 0) {
    echo '<h5>Trainer ('.$percentInfo['TrainerHoursPercent'].'%) </h5><span style="color: gray; font-size: 10px;">['.$agentInfoType[$key]['TrainerHours'].' / '.$agentInfoType[$key]['TotalHours'].' hours]</span><br><br>';
  }

  if ($agentInfoType[$key]['TraineeHours'] != 0) {
    echo '<h5>Trainee ('.$percentInfo['TraineeHoursPercent'].'%) </h5><span style="color: gray; font-size: 10px;">['.$agentInfoType[$key]['TraineeHours'].' / '.$agentInfoType[$key]['TotalHours'].' hours]</span><br><br>';
  }

  if ($agentInfoType[$key]['TMHours'] != 0) {
    echo '<h5>Team Meeting ('.$percentInfo['TMHoursPercent'].'%) </h5><span style="color: gray; font-size: 10px;">['.$agentInfoType[$key]['TMHours'].' / '.$agentInfoType[$key]['TotalHours'].' hours]</span><br><br>';
  }

  if ($agentInfoType[$key]['TCHours'] != 0) {
    echo '<h5>Training Call ('.$percentInfo['TCHoursPercent'].'%) </h5><span style="color: gray; font-size: 10px;">['.$agentInfoType[$key]['TCHours'].' / '.$agentInfoType[$key]['TotalHours'].' hours]</span><br><br>';
  }

  if ($agentInfoType[$key]['OtherHours'] != 0) {
    echo '<h5>Other:  ('.$percentInfo['OtherHoursPercent'].'%) </h5><span style="color: gray; font-size: 10px;">['.$agentInfoType[$key]['OtherHours'].' / '.$agentInfoType[$key]['TotalHours'].' hours]</span>';

    echo '<div style="padding-left: 30px; color: gray; font-size: 10px;"><ul>';

    for ($i = 0; $i < count($agentInfoType[$key]['OtherHoursList']); $i++) {
      echo '<li>'.$agentInfoType[$key]['OtherHoursList'][$i].'</li>';
    }

    echo '</ul></div>';
  }
}

$current_user = wp_get_current_user();
$useragent = $current_user->user_login;
$userID = 0;
$special = '<center><div style="color: white; width: 300px; background-color: rgba(255, 0, 0, 0.6); padding: 5px; font-size: 11px;">'.do_shortcode('[icon agent="fa-exclamation-triangle"]').'<i> We have a new question of the Month: <b>IF you could add a new feature to homebase, what would it be?</b> (<a href="https://docs.google.com/forms/d/e/1FAIpQLSeOuugdw7fVeu9FGwJoylsbAKiIO33OEkRb0NV32T9qkA5mQA/viewform" target="_blank">Submit Form</a>)</i></div></center>';

$table = TablePress::$model_table->load( 12, true, false );

$totalAgents = count($table['data']);
$colTimes = count($table['data'][2]);
$colTimesRowStart = $table['data'][2];

for ($i = 3; $i < $totalAgents; $i++) {
	if (strtolower($table['data'][$i][0]) == strtolower($useragent)) {
		$userID = $i;
	}
}

$date = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
$date->setTimeZone(new DateTimeZone('America/Chicago'));
$currentHour = $date->format('G');
$lastUpdated = $date->format('g:i a');
$dayOfWeek = $date->format('D');

$current_date = $date->format("Y-m-d H:i:s");
$shift_date = $date->format("Y-m-d");

//if ($userID != 0) {

// Make sure only administrators can access this page

if (!current_user_can( 'administrator')) {
  echo 'Sorry, you need to be an administrator to access this page.';
  return;
}

echo '<div style="background-color: #8857ac; color: white; padding: 5px;"><strong>'.do_shortcode('[icon agent="fa-search-plus"]').' CS Manager Reports</strong></div>';

	/***** CS REPORT This Week ******/
	echo '<div style="padding-left: 30px; margin-top: 0px; padding-top: 10px; padding-bottom: 10px; background-color: #fcf7fc;">';

  $agentNamesArray = $wpdb->get_results( "select DISTINCT agent_name from cs_focus_new", ARRAY_N);

	$agentInfoThisWeek = array();
  $agentInfoLastWeek = array();
  $agentInfoToday = array();
  $agentInfoAllTime = array();

	for ($i = 0; $i < count($agentNamesArray); $i++) {
			$agentInfoThisWeek[] = array('agent' => $agentNamesArray[$i][0],
                           'ICHours' => 0,
                           'IBHours' => 0,
                           'ZDHours' => 0,
                           'HiringHours' => 0,
                           'ACTHours' => 0,
                           'ACTOHours' => 0,
                           'OpenHours' => 0,
                           'OtherHours' => 0,
                           'TrainerHours' => 0,
                           'TraineeHours' => 0,
                           'TCHours' => 0,
                           'TMHours' => 0,
                           'TaskHours' => 0,
                           'TotalHours' => 0,
                           'OtherHoursList' => array(),
                         );

       $agentInfoLastWeek[] = array('agent' => $agentNamesArray[$i][0],
                            'ICHours' => 0,
                            'IBHours' => 0,
                            'ZDHours' => 0,
                            'HiringHours' => 0,
                            'ACTHours' => 0,
                            'ACTOHours' => 0,
                            'OpenHours' => 0,
                            'OtherHours' => 0,
                            'TrainerHours' => 0,
                            'TraineeHours' => 0,
                            'TCHours' => 0,
                            'TMHours' => 0,
                            'TaskHours' => 0,
                            'TotalHours' => 0,
                            'OtherHoursList' => array(),
                          );

      $agentInfoToday[] = array('agent' => $agentNamesArray[$i][0],
                           'ICHours' => 0,
                           'IBHours' => 0,
                           'ZDHours' => 0,
                           'HiringHours' => 0,
                           'ACTHours' => 0,
                           'ACTOHours' => 0,
                           'OpenHours' => 0,
                           'OtherHours' => 0,
                           'TrainerHours' => 0,
                           'TraineeHours' => 0,
                           'TCHours' => 0,
                           'TMHours' => 0,
                           'TaskHours' => 0,
                           'TotalHours' => 0,
                           'OtherHoursList' => array(),
                         );

       $agentInfoAllTime[] = array('agent' => $agentNamesArray[$i][0],
                            'ICHours' => 0,
                            'IBHours' => 0,
                            'ZDHours' => 0,
                            'HiringHours' => 0,
                            'ACTHours' => 0,
                            'ACTOHours' => 0,
                            'OpenHours' => 0,
                            'OtherHours' => 0,
                            'TrainerHours' => 0,
                            'TraineeHours' => 0,
                            'TCHours' => 0,
                            'TMHours' => 0,
                            'TaskHours' => 0,
                            'TotalHours' => 0,
                            'OtherHoursList' => array(),
                          );
	}

  // for ($i = 0; $i < count($focusCSSinceThisWeek); $i++) {
  //   $indexFound = array_search($focusCSSinceThisWeek[$i][1], array_column($agentInfo, 'agent'));
  //   echo $indexFound;
  //     //echo $focusCSSinceThisWeek[$i][1].'='.$agentInfo[$indexFound]['agent'];
  //     for ($j = 0; $j < count($focusCSSinceThisWeek[$i]); $j++) {
  //       for ($z = 4; $z < $dbCols; $z++) {
  //         if (startsWith($focusSinceThisWeek[$i][$z], 'IB/')) {
  //   				//echo $focusToday[$i]."<br />";
  //   				$agentInfo[$focusCSSinceThisWeek[$i][1]]['IBHoursThisWeek'] += 0.5;
  //   			}
  //       }
  //     }
  // }

  //print_r($focusCSSinceThisWeek[0][1]);
  //$totalCSTaskHours = 0;

  echo '<form method="post" action="/manager-reports">
    <select name="agentName">';

    sort($agentNamesArray);

for ($i = 0; $i < count($agentNamesArray); $i++) {
  //echo "<option value=".$agentNamesArray[$i][0].">".$agentNamesArray[$i][0]."</option>";
  echo "<option ".selected($_POST['agentName'], $agentNamesArray[$i][0])."value=".$agentNamesArray[$i][0].">".$agentNamesArray[$i][0]."</option>";

}
    echo '</select>
    <select name="type">
    <option '.selected($_POST['type'], 'Today').'value="Today">Today</option>
    <option '.selected($_POST['type'], 'This Week').'value="This Week">This Week</option>
    <option '.selected($_POST['type'], 'Last Week').'value="Last Week">Last Week</option>
    <option '.selected($_POST['type'], 'All Time').'value="All Time">All Time</option>
    <input type="submit" value="View Reports"/>
  </form><br>';

     $option = isset($_POST['agentName']) ? $_POST['agentName'] : -1;
     if ($option != -1) {

       echo '<div style="background-color: black; color: white; padding-left: 10px;"><h1>'.$_POST['type'].'</h1></div>';

       if ($_POST['type'] == 'This Week') {

         $focus = $wpdb->get_results( "SELECT * FROM `cs_focus_new` WHERE agent_name = '".$_POST['agentName']."' AND YEARWEEK(`shift_date`, 1) = YEARWEEK(CURDATE(), 1)", ARRAY_N);

         $key = array_search($_POST['agentName'], array_column($agentInfoThisWeek, 'agent'));

          processFocus($focus, $agentInfoThisWeek, $key);
          displayStats($agentInfoThisWeek, $key);
          //print_r($agentInfoThisWeek[$_POST['agentName']]);
          //echo htmlentities($_POST['agentName'], ENT_QUOTES, "UTF-8");
        }
        else if ($_POST['type'] == 'Today') {

          $focus = $wpdb->get_results( "SELECT * FROM `cs_focus_new` WHERE agent_name = '".$_POST['agentName']."' AND shift_date = '". $shift_date ." 00:00:00'", ARRAY_N);

          //print_r($focus);
          $key = array_search($_POST['agentName'], array_column($agentInfoToday, 'agent'));

           processFocus($focus, $agentInfoToday, $key);
           displayStats($agentInfoToday, $key);
           //print_r($agentInfoThisWeek[$_POST['agentName']]);
           //echo htmlentities($_POST['agentName'], ENT_QUOTES, "UTF-8");
         }
         else if ($_POST['type'] == 'Last Week') {

           $focus = $wpdb->get_results( "SELECT * FROM `cs_focus_new` WHERE agent_name = '".$_POST['agentName']."' AND shift_date >= curdate() - INTERVAL DAYOFWEEK(curdate())+5 DAY AND shift_date <= curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY", ARRAY_N);

           //print_r($focus);
           $key = array_search($_POST['agentName'], array_column($agentInfoLastWeek, 'agent'));

            processFocus($focus, $agentInfoLastWeek, $key);
            displayStats($agentInfoLastWeek, $key);
            //print_r($agentInfoThisWeek[$_POST['agentName']]);
            //echo htmlentities($_POST['agentName'], ENT_QUOTES, "UTF-8");
          }
          else if ($_POST['type'] == 'All Time') {

            $focus = $wpdb->get_results( "SELECT * FROM `cs_focus_new` WHERE agent_name = '".$_POST['agentName']."' AND shift_date <= '". $shift_date ." 00:00:00'", ARRAY_N);

            //print_r($focus);
            $key = array_search($_POST['agentName'], array_column($agentInfoAllTime, 'agent'));

             processFocus($focus, $agentInfoAllTime, $key);
             displayStats($agentInfoAllTime, $key);
             //print_r($agentInfoThisWeek[$_POST['agentName']]);
             //echo htmlentities($_POST['agentName'], ENT_QUOTES, "UTF-8");
           }
     } else {
       echo "Please select an agent to view their reports.";
     }

  echo '</div>'


?>
