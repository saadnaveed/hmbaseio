<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

function startsWith($haystack, $needle)
{
     $length = strlen($needle);
     return (substr($haystack, 0, $length) === $needle);
}

$current_user = wp_get_current_user();
$useragent = $current_user->user_login;
$userID = 0;
$special = '<center><div style="color: white; width: 300px; background-color: rgba(255, 0, 0, 0.6); padding: 5px; font-size: 11px;">'.do_shortcode('[icon agent="fa-exclamation-triangle"]').'<i> We have a new question of the Month: <b>IF you could add a new feature to homebase, what would it be?</b> (<a href="https://docs.google.com/forms/d/e/1FAIpQLSeOuugdw7fVeu9FGwJoylsbAKiIO33OEkRb0NV32T9qkA5mQA/viewform" target="_blank">Submit Form</a>)</i></div></center>';

$table = TablePress::$model_table->load( 4, true, false );

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

echo '<div style="background-color: #8857ac; color: white; padding: 5px;"><strong>'.do_shortcode('[icon agent="fa-search-plus"]').' CS Task Hours</strong></div>';


	/***** CS REPORT This Week ******/
	echo '<div style="padding-left: 30px; margin-top: 0px; padding-top: 10px; padding-bottom: 10px; background-color: #fcf7fc;"><div style="background-color: black; color: white; padding-left: 10px;"><h1>This Week</h1></div>';

	$focusCSSinceThisWeek = $wpdb->get_results( "SELECT * FROM `cs_focus` WHERE YEARWEEK(`shift_date`, 1) = YEARWEEK(CURDATE(), 1)", ARRAY_N);

	$agentInfo = array();

	for ($i = 0; $i < count($focusCSSinceThisWeek); $i++) {
		// Check first to see if agent is already in the array
		if (!in_array($focusCSSinceThisWeek[$i][1], array_column($agentInfo, 'agent'))) {
			$agentInfo[] = array('agent' => $focusCSSinceThisWeek[$i][1],
                           'ICHoursThisWeek' => 0,
                           'IBHoursThisWeek' => 0,
                           'ZDHoursThisWeek' => 0,
                           'HiringHoursThisWeek' => 0,
                           'ACTHoursThisWeek' => 0,
                           'ACTOHoursThisWeek' => 0,
                           'OpenHoursThisWeek' => 0,
                           'OtherHoursThisWeek' => 0,
                           'TrainerHoursThisWeek' => 0,
                           'TraineeHoursThisWeek' => 0,
                           'TCHoursThisWeek' => 0,
                           'TaskHours' => 0,
                         );
		}
	}

  // for ($i = 0; $i < count($focusCSSinceThisWeek); $i++) {
  //   $indexFound = array_search($focusCSSinceThisWeek[$i][1], array_column($agentInfo, 'agent'));
  //   echo $indexFound;
  //     //echo $focusCSSinceThisWeek[$i][1].'='.$agentInfo[$indexFound]['agent'];
  //     for ($j = 0; $j < count($focusCSSinceThisWeek[$i]); $j++) {
  //       for ($z = 4; $z < 16; $z++) {
  //         if (startsWith($focusSinceThisWeek[$i][$z], 'IB/')) {
  //   				//echo $focusToday[$i]."<br />";
  //   				$agentInfo[$focusCSSinceThisWeek[$i][1]]['IBHoursThisWeek']++;
  //   			}
  //       }
  //     }
  // }

  //print_r($focusCSSinceThisWeek[0][1]);
  //$totalCSTaskHours = 0;

  for ($i = 0; $i < count($agentInfo); $i++) {
    for ($j = 0; $j < count($focusCSSinceThisWeek); $j++) {
      if ($agentInfo[$i]['agent'] == $focusCSSinceThisWeek[$j][1]) {
      //  echo $agentInfo[$i]['agent'].' = '.$focusCSSinceThisWeek[$j][1].'<br>';
        for ($z = 4; $z < 16; $z++) {
          if (startsWith($focusCSSinceThisWeek[$j][$z], 'TM') || startsWith($focusCSSinceThisWeek[$j][$z], 'H/') ||
        startsWith($focusCSSinceThisWeek[$j][$z], 'ACT') ||
      startsWith($focusCSSinceThisWeek[$j][$z], 'O') ||
    startsWith($focusCSSinceThisWeek[$j][$z], 'TR') ||
  startsWith($focusCSSinceThisWeek[$j][$z], 'TC')) {
            $agentInfo[$i]['TaskHours']++;
            $totalCSTaskHours++;
          }
        }
      }
    }
  }

  echo '<ul>';
  for ($i = 0; $i < count($agentInfo); $i++) {

    if ($agentInfo[$i]['agent'] == 'jc' || $agentInfo[$i]['agent'] == 'amy' || $agentInfo[$i]['agent'] == 'greg' || $agentInfo[$i]['agent'] == 'alex' || $agentInfo[$i]['agent'] == 'rebecca') {
      continue;
    }

    echo '<li>'.$agentInfo[$i]['agent'].': <h4>'.$agentInfo[$i]['TaskHours'].'</h4></li><br>';
  }

  echo '</ul>';

  echo '<h2>Total CS Task Hours: '.$totalCSTaskHours.'</h2>';

  echo '</div>'


?>
