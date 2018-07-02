<?php

function startsWith($haystack, $needle)
{
     $length = strlen($needle);
     return (substr($haystack, 0, $length) === $needle);
}

$current_user = wp_get_current_user();
$username = $current_user->user_login;
$userID = 0;
$special = '<center><div style="color: white; width: 300px; background-color: rgba(255, 0, 0, 0.6); padding: 5px; font-size: 11px;">'.do_shortcode('[icon name="fa-exclamation-triangle"]').'<i> We have a new question of the Month: <b>IF you could add a new feature to homebase, what would it be?</b> (<a href="https://docs.google.com/forms/d/e/1FAIpQLSeOuugdw7fVeu9FGwJoylsbAKiIO33OEkRb0NV32T9qkA5mQA/viewform" target="_blank">Submit Form</a>)</i></div></center>';

$table = TablePress::$model_table->load( 4, true, false );

$totalAgents = count($table['data']);
$colTimes = count($table['data'][2]);
$colTimesRowStart = $table['data'][2];

for ($i = 3; $i < $totalAgents; $i++) {
	if (strtolower($table['data'][$i][0]) == strtolower($username)) {
		$userID = $i;
	}
}

$date = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
$date->setTimeZone(new DateTimeZone('America/Chicago'));
$currentHour = $date->format('G');
$lastUpdated = $date->format('g:i a');
$dayOfWeek = $date->format('D');

$tableTimes = array (
							'8' => '8a',
							'9' => '9a',
							'10' => '10a',
							'11' => '11a',
							'12' => '12p',
							'13' => '1p',
							'14' => '2p',
							'15' => '3p',
							'16' => '4p',
							'17' => '5p',
							'18' => '6p',
							'19' => '7p',
							'8a' => '8',
							'9a' => '9',
							'10a' => '10',
							'11a' => '11',
							'12p' => '12',
							'1p' => '13',
							'2p' => '14',
							'3p' => '15',
							'4p' => '16',
							'5p' => '17',
							'6p' => '18',
							'7p' => '19',
);

$agentExt = array (
							'saad' => '1000',
							'mariam' => '1004',
							'david' => '1009',
							'ryan' => '1013',
							'cindy' => '1017',
							'ciara' => '1018',
							'alexander' => '1023',
							'chris' => '1024',
							'liza' => '1029',
							'rosvy' => '1031',
							'molly' => '1036',
							'brandon' => '1037',
							'cat' => '1039',
							'doc' => '1041',
							'daveen' => '1042',
							'kyle' => '1045',
							'katarina' => '1046',
							'bridgette' => '1049',
							'connie' => '1051',
							'dexter' => '1053',
							'daniel' => '1054',
							'missy' => '1056',
							'rachel' => '1001',
							'joe' => '1044',
							'ashlee' => '1043',
);

$current_date = $date->format("Y-m-d H:i:s");
$shift_date = $date->format("Y-m-d");

/* Store Updated Focus Data into database */
/* TODO: make it not execute on every request lol */
for ($i = 3; $i < $totalAgents; $i++) {

  // First check to see if there is already an entry for the day
  $focus = $wpdb->get_row( "SELECT * FROM cs_focus WHERE agent_name = '". $table['data'][$i][0]."' AND shift_date = '". $shift_date ." 00:00:00'");

  // Insert into DB if brand new day
  if ($table['data'][$i][0] != '' && $table['data'][$i][1] != '' && !$focus) {
    $wpdb->insert('cs_focus', array(
      'agent_name' => strtolower($table['data'][$i][0]),
      'shift_date' => $shift_date,
      'shift_time' => $table['data'][$i][1],
      'focus_8am' => $table['data'][$i][3],
      'focus_9am' => $table['data'][$i][4],
      'focus_10am' => $table['data'][$i][5],
      'focus_11am' => $table['data'][$i][6],
      'focus_12pm' => $table['data'][$i][7],
      'focus_1pm' => $table['data'][$i][8],
      'focus_2pm' => $table['data'][$i][9],
      'focus_3pm' => $table['data'][$i][10],
      'focus_4pm' => $table['data'][$i][11],
      'focus_5pm' => $table['data'][$i][12],
      'focus_6pm' => $table['data'][$i][13],
      'focus_7pm' => $table['data'][$i][14],
      'date_created' => $current_date,
      'updated' => 0,
    ));
  }
  //TODO: only update every x minutes
  else if ($focus && $focus->agent_name == strtolower($table['data'][$i][0])) {
    $wpdb->query("UPDATE cs_focus SET
    focus_8am = '".$table['data'][$i][3]."',
    focus_9am = '".$table['data'][$i][4]."',
    focus_10am = '".$table['data'][$i][5]."',
    focus_11am = '".$table['data'][$i][6]."',
    focus_12pm = '".$table['data'][$i][7]."',
    focus_1pm = '".$table['data'][$i][8]."',
    focus_2pm = '".$table['data'][$i][9]."',
    focus_3pm = '".$table['data'][$i][10]."',
    focus_4pm = '".$table['data'][$i][11]."',
    focus_5pm = '".$table['data'][$i][12]."',
    focus_6pm = '".$table['data'][$i][13]."',
    focus_7pm = '".$table['data'][$i][14]."',
    updated = '1'
    WHERE agent_name = '". $table['data'][$i][0]."' AND shift_date = '". $shift_date ." 00:00:00'");
  }

}

if ($userID != 0) {

	echo '<div style="background-color: #8857ac; color: white; padding: 5px;"><strong>'.do_shortcode('[icon name="fa-sun-o"]').' How\'s my day looking? '. $table['data'][$userID][1] .'pm</strong></div>';

	echo '<div style="padding-left: 20px; padding-top: 10px; margin-top: 0px; margin-bottom: 10px; background-color: #fcf7fc"><h3>Hi, ' .$username. '! Welcome back :) </h3><br />';

	//print("<pre>".print_r($table['data'][$userID],true)."</pre>");
	//print_r(array_count_values($table['data'][$userID]));

	// Print Today's Shift Time
	//echo "Today you're working from: ";
	//echo $table['data'][$userID][1] .'pm <br />';

	// Print Current Focus

	$currentFocus = '';
	$upcomingFocus = '';

	for ($i = 3; $i < $colTimes; $i++) {
		if ($colTimesRowStart[$i] == $tableTimes[$currentHour]) {
			$currentFocus = $table['data'][$userID][$i];
			$upcomingFocus = $table['data'][$userID][$i+1];
		}
	}

	if ($currentFocus == "LNCH") {
		echo '<center><h2><strong>Hooray, it\'s lunch time!</strong></h2></center><br />';
	}
	else if ($currentFocus == "TM") {
		echo '<center><h2><strong>Hurry up, you have a team meeting right now!</strong></h2></center><br />';
	}
	else if ($currentFocus != '') {
		echo '<center><h2>'. do_shortcode('[icon name="fa-arrow-circle-right"]'). ' Your Current Focus: <strong>'.$currentFocus. '</strong></h2></center>';

		if (strpos($currentFocus, 'IB') !== false || $username == "Saad") {
			echo $special;
		}

		echo '<br />';
	}
	else {
		echo '<center><h2>Zzzzzzz...</h2></center><br />';
	}

	// Print Upcoming Focus
	if ($upcomingFocus != '' && $upcomingFocus != 'LNCH' && upcomingFocus != 'TM') {
		echo ''.do_shortcode('[icon name="fa-level-up"]').' Your Upcoming Focus: <strong>'. $upcomingFocus. '</strong><br />';
	}
	else if ($upcomingFocus == "LNCH") {
		echo 'It\'s almost time for your lunch break! :)<br />';
	}
	else if ($upcomingFocus == "TM") {
		echo 'Get ready! You\'re about to have an awesome team meeting!<br />';
	}
	else if ($currentFocus != '' && $upcomingFocus == '') {
		echo ''.do_shortcode('[icon name="fa-check"]').' Great job! You\'re almost done for the day! Don\'t forget to fill out your <a href="https://docs.google.com/spreadsheets/u/2/d/1Spu8BRAPDjOr1F3iQ_pMqWnxIJB4_kZIB5eIcGDPeGg/edit#gid=317380563" target="_blank">task hours</a>!<br />';
	}

	echo '<br />';

	// Print Lunch
	$lunchKey = array_search('LNCH', $table['data'][$userID]);


	if ($lunchKey != 0 && $currentHour < $tableTimes[$colTimesRowStart[$lunchKey]]) {
		echo 'Your Lunch Time: <strong>'.$colTimesRowStart[$lunchKey]. '</strong><br /><br />';
	}

	$teamMeetingKey = array_search('TM', $table['data'][$userID]);

	if ($teamMeetingKey != '' && $currentHour < $tableTimes[$colTimesRowStart[$teamMeetingKey]]) {
		echo '<span style="color: red">*Don\'t forget, you have a team meeting today at <strong>'.$colTimesRowStart[$teamMeetingKey].'</strong></span><br /><br />';

		if ($dayOfWeek == 'Fri') {
			echo '<span style="color: red">** Please fill out the <a href="https://docs.google.com/spreadsheets/u/2/d/1sYEUpfr-xXhEK58b6ns5MTMgbQry-oXN9zkvqfvRqSw/edit?ouid=104196470359843284937&usp=sheets_home&ths=true" target="_blank">Friday-Wrap Up</a> before the meeting as well :)</span><br /><br />';
		}
	}

	echo '<br /><center><p><i><span style="color: black; font-size: 11px;">Page Last Updated: '. $lastUpdated .'</span></i></p></center><br />';

	echo '</div>';

}

echo '<div style="background-color: #8857ac; color: white; padding: 5px;"><strong>'.do_shortcode('[icon name="fa-search-plus"]').' CS Quick Glance</strong></div>';

// Total number of people currently on Inbound
$totalIB = 0;

for ($i = 3; $i < $totalAgents; $i++) {
	for ($j = 0; $j < $colTimes; $j++) {
		if (startsWith($table['data'][$i][$j], 'IB/') && $colTimesRowStart[$j] == $tableTimes[$currentHour]) {
			$totalIB++;
		}
	}
}

echo '<div style="padding-left: 30px; margin-top: 0px; padding-top: 10px; padding-bottom: 10px; background-color: #fcf7fc;"><ul><li>'.do_shortcode('[icon name="fa-phone"]').' Agents currently on IB: <strong>'. $totalIB. '</strong>';


if ($totalIB > 0) {
	echo '<ol>';
	for ($i = 3; $i < $totalAgents; $i++) {
		for ($j = 0; $j < $colTimes; $j++) {
			if (startsWith($table['data'][$i][$j], 'IB/') && $colTimesRowStart[$j] == $tableTimes[$currentHour]) {
				echo '<li>'. $table['data'][$i][0].' <span style="font-size: 9px;"><i>(x'.$agentExt[strtolower($table['data'][$i][0])].')</i></span></li>';
			}
		}
	}
	echo '</ol>';

}
echo '</li><br />';

// Total number of people currently on Zendesk
$totalZD = 0;

for ($i = 0; $i <= $totalAgents; $i++) {
	for ($j = 0; $j < $colTimes; $j++) {
		if (startsWith($table['data'][$i][$j], 'ZD/') && $colTimesRowStart[$j] == $tableTimes[$currentHour]) {
			$totalZD++;
		}
	}
}

echo '<li>'.do_shortcode('[icon name="fa-envelope"]').' Agents currently on ZD: <strong>'. $totalZD. '</strong>';

if ($totalZD > 0) {
	echo '<ol>';
	for ($i = 3; $i < $totalAgents; $i++) {
		for ($j = 0; $j < $colTimes; $j++) {
			if (startsWith($table['data'][$i][$j], 'ZD/') && $colTimesRowStart[$j] == $tableTimes[$currentHour]) {
				echo '<li>'. $table['data'][$i][0].'</li>';
			}
		}
	}
	echo '</ol>';

}
echo '</li><br />';

// Total number of people currently on Intercom
$totalIC = 0;

for ($i = 3; $i < $totalAgents; $i++) {
	for ($j = 0; $j < $colTimes; $j++) {
		if (startsWith($table['data'][$i][$j], 'IC/') && $colTimesRowStart[$j] == $tableTimes[$currentHour]) {
			$totalIC++;
		}
	}
}

echo '<li>'.do_shortcode('[icon name="fa-comment"]').' Agents currently on IC: <strong>'. $totalIC. '</strong>';

if ($totalIC > 0) {
	echo '<ol>';
	for ($i = 3; $i < $totalAgents; $i++) {
		for ($j = 0; $j < $colTimes; $j++) {
			if (startsWith($table['data'][$i][$j], 'IC/') && $colTimesRowStart[$j] == $tableTimes[$currentHour]) {
				echo '<li>'. $table['data'][$i][0].'</li>';
			}
		}
	}
	echo '</ol>';

}
echo '</li><br />';

// Total number of people currently on Hiring
$totalHiring = 0;

for ($i = 3; $i < $totalAgents; $i++) {
	for ($j = 0; $j < $colTimes; $j++) {
		if (startsWith($table['data'][$i][$j], 'H/') && $colTimesRowStart[$j] == $tableTimes[$currentHour]) {
			$totalHiring++;
		}
	}
}

echo '<li>'.do_shortcode('[icon name="fa-globe"]').' Agents currently on Hiring: <strong>'. $totalHiring. '</strong>';

if ($totalHiring > 0) {
	echo '<ol>';
	for ($i = 3; $i < $totalAgents; $i++) {
		for ($j = 0; $j < $colTimes; $j++) {
			if (startsWith($table['data'][$i][$j], 'H/') && $colTimesRowStart[$j] == $tableTimes[$currentHour]) {
				echo '<li>'. $table['data'][$i][0].'</li>';
			}
		}
	}
	echo '</ol>';

}
echo '</li><br />';

// Total number of people currently on Activation
$totalACT = 0;

for ($i = 3; $i < $totalAgents; $i++) {
	for ($j = 0; $j < $colTimes; $j++) {
		if (startsWith($table['data'][$i][$j], 'ACT') && $colTimesRowStart[$j] == $tableTimes[$currentHour]) {
			$totalACT++;
		}
	}
}

echo '<li>'.do_shortcode('[icon name="fa-handshake-o"]').' Agents currently on ACT: <strong>'. $totalACT. '</strong>';

if ($totalACT > 0) {
	echo '<ol>';
	for ($i = 3; $i < $totalAgents; $i++) {
		for ($j = 0; $j < $colTimes; $j++) {
			if (startsWith($table['data'][$i][$j], 'ACT') && $colTimesRowStart[$j] == $tableTimes[$currentHour]) {
				echo '<li>'. $table['data'][$i][0].'</li>';
			}
		}
	}
	echo '</ol>';

}
echo '</li><br />';

// Total number of people currently on break
$totalLNCH = 0;

for ($i = 3; $i < $totalAgents; $i++) {
	for ($j = 0; $j < $colTimes; $j++) {
		if (startsWith($table['data'][$i][$j], 'LNCH') && $colTimesRowStart[$j] == $tableTimes[$currentHour]) {
			$totalLNCH++;
		}
	}
}

echo '<li>'.do_shortcode('[icon name="fa-cutlery"]').' Agents currently on Lunch: <strong>'. $totalLNCH. '</strong>';

if ($totalLNCH > 0) {
	echo '<ol>';
	for ($i = 0; $i <= $totalAgents; $i++) {
		for ($j = 0; $j < $colTimes; $j++) {
			if (startsWith($table['data'][$i][$j], 'LNCH') && $colTimesRowStart[$j] == $tableTimes[$currentHour]) {
				echo '<li>'. $table['data'][$i][0].'</li>';
			}
		}
	}
	echo '</ol>';

}
echo '</li></ul></div><br /><br /><br /><br /><br /><br />';

/* if (strtolower($username) == 'saad') { */
echo '<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />';
	echo do_shortcode('[table id=4 /]');


?>
