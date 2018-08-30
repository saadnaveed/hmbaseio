<?php

function startsWith($haystack, $needle)
{
     $length = strlen($needle);
     return (substr($haystack, 0, $length) === $needle);
}

/* Returns true if the time is in range of the focus or equals it */
function checkFocusTimes($currentTime, $focusTime, $nextFocusTime) {
  return (strtotime($focusTime) < strtotime($currentTime) && strtotime($currentTime) < strtotime($nextFocusTime) || strtotime($focusTime) == strtotime($currentTime));
}

$current_user = wp_get_current_user();
$username = $current_user->user_login;
$userID = 0;

$metrics_Cat = TablePress::$model_table->load( 14, true, false );
$metrics_Cindy = TablePress::$model_table->load( 15, true, false );

$date = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
$date->setTimeZone(new DateTimeZone('America/Chicago'));
$currentHour = $date->format('g:i a');
$lastUpdated = $date->format('g:i a');
$dayOfWeek = $date->format('D');

$current_date = $date->format("Y-m-d H:i:s");
$shift_date = $date->format("Y-m-d");

echo '<div style="background-color: #8857ac; color: white; padding: 5px;"><strong>'.do_shortcode('[icon name="fa-search-plus"]').' CS Leaderboard</strong></div>';

// $agentNamesArray = array();
// // Total number of people currently on Inbound
// $totalIB = 0;
//
// for ($i = 3; $i < $totalAgents; $i++) {
// 	//for ($j = 0; $j < $colTimes; $j++) {
//
//     $agentNamesArray[] = array('name' => $table['data'][$i][0],
//                         'IBHoursToday' => 0,
//                         'ICHoursToday' => 0,
//                         'ZDHoursToday' => 0,
//                         'ACTHoursToday' => 0,
//                         'HiringHoursToday' => 0,
//                       );
// //	}
// }
//
// for ($z = 0; $z < count($agentNamesArray); $z++) {
//   for ($i = 0; $i <= $totalAgents; $i++) {
//   	for ($j = 0; $j < $colTimes; $j++) {
//   		if (startsWith($table['data'][$i][$j], 'IB/') && $agentNamesArray[$z]['name'] == $table['data'][$i][0]) {
//   			$agentNamesArray[$z]['IBHoursToday'] += 0.5;
//   		}
//       else if (startsWith($table['data'][$i][$j], 'IC/') && $agentNamesArray[$z]['name'] == $table['data'][$i][0]) {
//   			$agentNamesArray[$z]['ICHoursToday'] += 0.5;
//   		}
//       else if (startsWith($table['data'][$i][$j], 'ZD/') && $agentNamesArray[$z]['name'] == $table['data'][$i][0]) {
//   			$agentNamesArray[$z]['ZDHoursToday'] += 0.5;
//   		}
//       else if (startsWith($table['data'][$i][$j], 'H/') && $agentNamesArray[$z]['name'] == $table['data'][$i][0]) {
//   			$agentNamesArray[$z]['HiringHoursToday'] += 0.5;
//   		}
//       else if (startsWith($table['data'][$i][$j], 'ACT') && $agentNamesArray[$z]['name'] == $table['data'][$i][0]) {
//   			$agentNamesArray[$z]['ACTHoursToday'] += 0.5;
//   		}
//   	}
//   }
// }
//
// $mostIBHours1 = array('name' => 'Blank', 'hours' => 0);
// $mostIBHours2 = array('name' => 'Blank', 'hours' => 0);
// $mostIBHours3 = array('name' => 'Blank', 'hours' => 0);
//
// $mostZDHours1 = array('name' => 'Blank', 'hours' => 0);
// $mostZDHours2 = array('name' => 'Blank', 'hours' => 0);
// $mostZDHours3 = array('name' => 'Blank', 'hours' => 0);
//
// for ($z = 0; $z < count($agentNamesArray); $z++) {
//   if ($agentNamesArray[$z]['IBHoursToday'] > $mostIBHours1['hours']) {
//     $mostIBHours3['hours'] = $mostIBHours2['hours'];
//     $mostIBHours3['name'] = $mostIBHours2['name'];
//
//     $mostIBHours2['hours'] = $mostIBHours1['hours'];
//     $mostIBHours2['name'] = $mostIBHours1['name'];
//
//     $mostIBHours1['hours'] = $agentNamesArray[$z]['IBHoursToday'];
//     $mostIBHours1['name'] = $agentNamesArray[$z]['name'];
//   }
// }
//
// for ($z = 0; $z < count($agentNamesArray); $z++) {
//   if ($agentNamesArray[$z]['ZDHoursToday'] > $mostZDHours1['hours']) {
//     $mostZDHours3['hours'] = $mostZDHours2['hours'];
//     $mostZDHours3['name'] = $mostZDHours2['name'];
//
//     $mostZDHours2['hours'] = $mostZDHours1['hours'];
//     $mostZDHours2['name'] = $mostZDHours1['name'];
//
//     $mostZDHours1['hours'] = $agentNamesArray[$z]['ZDHoursToday'];
//     $mostZDHours1['name'] = $agentNamesArray[$z]['name'];
//   }
// }
//
// echo '<div style="padding-left: 30px; margin-top: 0px; padding-top: 10px; padding-bottom: 10px; background-color: #fcf7fc;"><ul><li>'.do_shortcode('[icon name="fa-phone"]').' Agents with most IB Hours:';
//
// echo '<ol>';
// echo '<li>'.$mostIBHours1['name'].'<span style="font-size: 9px;"><i> ('.$mostIBHours1['hours'].' hours)</i></span></li>';
// echo '<li>'.$mostIBHours2['name'].'<span style="font-size: 9px;"><i> ('.$mostIBHours2['hours'].' hours)</i></span></li>';
// echo '<li>'.$mostIBHours3['name'].'<span style="font-size: 9px;"><i> ('.$mostIBHours3['hours'].' hours)</i></span></li>';
// echo '</ol>';
//
// echo '<br>';
//
// echo '<li>'.do_shortcode('[icon name="fa-envelope"]').' Agents with most ZD Hours:';
//
// echo '<ol>';
// echo '<li>'.$mostZDHours1['name'].'<span style="font-size: 9px;"><i> ('.$mostZDHours1['hours'].' hours)</i></span></li>';
// echo '<li>'.$mostZDHours2['name'].'<span style="font-size: 9px;"><i> ('.$mostZDHours2['hours'].' hours)</i></span></li>';
// echo '<li>'.$mostZDHours3['name'].'<span style="font-size: 9px;"><i> ('.$mostZDHours3['hours'].' hours)</i></span></li>';
// echo '</ol>';
echo '<div style="padding-left: 40px; margin-top: 0px; padding-top: 10px; padding-bottom: 10px; background-color: #fcf7fc;">';

$namesAndTables = array('cat' => 14,
                        'cindy' => 15,
                        'alexander' => 16,
                        'ashlee' => 17,
                        'brandon' => 18,
                        'bridgette' => 19,
                        'chris' => 20,
                        'daniel' => 21,
                        'david' => 22,
                        'dexter' => 23,
                        'joe' => 24,
                        'katarina' => 25,
                        'kyle' => 26,
                        'molly' => 27,
                        'rachel' => 28,
                        'ryan' => 29);

$metricsJulyWeek1 = array();
$metricsJulyWeek1TotalTickets = array();
$metricsJulyWeek1MostGoodRatings = array();

// Week 1 August
$ticketPerHourCell = 'K127';
$totalTicketsCell = 'K123';
$mostGoodRatingsCell = 'K136';

// Week 2 August
// $ticketPerHourCell = 'L127';
// $totalTicketsCell = 'L123';
// $mostGoodRatingsCell = 'L136';
//
// // Week 3 August
// $ticketPerHourCell = 'M127';
// $totalTicketsCell = 'M123';
// $mostGoodRatingsCell = 'M136';
//
// // Week 4 August
// $ticketPerHourCell = 'N127';
// $totalTicketsCell = 'N123';
// $mostGoodRatingsCell = 'N136';

foreach($namesAndTables as $name => $table_id) {
    $metricsJulyWeek1[$name] = do_shortcode('[table-cell id='.$table_id.' cell='.$ticketPerHourCell.' /]');
    $metricsJulyWeek1TotalTickets[$name] = do_shortcode('[table-cell id='.$table_id.' cell='.$totalTicketsCell.' /]');
    $metricsJulyWeek1MostGoodRatings[$name] = do_shortcode('[table-cell id='.$table_id.' cell='.$mostGoodRatingsCell.' /]');
}

arsort($metricsJulyWeek1);
arsort($metricsJulyWeek1TotalTickets);
arsort($metricsJulyWeek1MostGoodRatings);

//print_r($metricsJulyWeek1TotalTickets);

$totalTickets = array_slice($metricsJulyWeek1TotalTickets, 0, 1);
$agentTotalTicketsName = key($totalTickets);
$agentTotalTickets = current($totalTickets);

$totalGoodRatings = array_slice($metricsJulyWeek1MostGoodRatings, 0, 1);
$agentTotalGoodRatingsName = key($totalGoodRatings);
$agentTotalGoodRatings = current($totalGoodRatings);

echo '<ol>';
$counter = 0;
foreach($metricsJulyWeek1 as $name => $ticketsPerHour) {
  $counter++;

    if ($counter == 1 || $counter == 2 || $counter == 3) {
      echo '<li><h2>'.$name.'</h2>'.do_shortcode('[icon name="fa-trophy"]').' <strong><font color="red">('.$ticketsPerHour.' tickets/hr)</font></strong></li>';
      echo '<br>';
      if ($agentTotalTicketsName == $name) {
        echo '<br>';
        echo '<span style="color: green;"><strong>'.do_shortcode('[icon name="fa-trophy"]').'Weekly Ticket Master: '.$agentTotalTickets.' tickets closed</strong></span>';
        echo '<br>';
        echo '<br>';
      }
      if ($agentTotalGoodRatingsName == $name) {
        echo '<span style="color: green;"><strong>'.do_shortcode('[icon name="fa-trophy"]').'Weekly Customer Champ: '.$agentTotalGoodRatings.' good ratings</strong></span>';
        echo '<br>';
        echo '<br>';
      }
    }
    else {
    echo '<li><h3>'.$name.'</h3></li>';
    echo '<strong>('.$ticketsPerHour.' tickets/hr)</strong>';
    echo '<br>';
    echo '<br>';
    if ($agentTotalTicketsName == $name) {
      echo '<span style="color: green;"><strong>'.do_shortcode('[icon name="fa-trophy"]').'Weekly Ticket Master: '.$agentTotalTickets.' tickets closed</strong></span>';
      echo '<br>';
      echo '<br>';
    }
    if ($agentTotalGoodRatingsName == $name) {
      echo '<span style="color: green;"><strong>'.do_shortcode('[icon name="fa-trophy"]').'Weekly Customer Champ: '.$agentTotalGoodRatings.' good ratings</strong></span>';
      echo '<br>';
      echo '<br>';
    }

    }
}
echo '</ol>';

$weeklyJulyWeek1Avg = 0;
$sum = 0;

foreach($metricsJulyWeek1 as $name => $ticketsPerHour) {
  $sum += $ticketsPerHour;
}

$weeklyJulyWeek1Avg = $sum / count($metricsJulyWeek1);

echo '<h1>Weekly CS Tickets/Hr Avg: <strong>'.$weeklyJulyWeek1Avg.'</strong></h1>';


echo '</div>';

?>
