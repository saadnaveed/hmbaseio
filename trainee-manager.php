<?php

echo '<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">';

error_reporting(E_ALL);
ini_set('display_errors', 1);

function startsWith($haystack, $needle)
{
     $length = strlen($needle);
     return (substr($haystack, 0, $length) === $needle);
}

$current_user = wp_get_current_user();
$username = $current_user->user_login;

$date = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
$date->setTimeZone(new DateTimeZone('America/Chicago'));
$currentHour = $date->format('G');
$lastUpdated = $date->format('g:i a');
$dayOfWeek = $date->format('D');

$current_date = $date->format("Y-m-d H:i:s");
$shift_date = $date->format("Y-m-d");

$quizzes = array(
  array(
    'name' => 'Orientation',
    'link' => 'https://docs.google.com/forms/d/e/1FAIpQLSfTwaxqmt8qk0jlfgJg7p8KhjKcd6flTSQm9x8oM1kmGu7HIQ/viewform?usp=pp_url&entry.1256900990=Orientation',
  ),
  array(
    'name' => 'Intro to Homebase Webinar',
    'link' => 'https://docs.google.com/forms/d/e/1FAIpQLSdUL1ImDTSJmVNkDOWhVtibrVRKucXuzW3gKzchkpCOOR-niA/viewform?usp=pp_url&entry.1188325884=Intro+to+Homebase+Webinar',
  ),
  array(
    'name' => 'Mastering Timesheets & Time Tracking Webinar',
    'link' => 'https://docs.google.com/forms/d/e/1FAIpQLSd5p_SJgpYqWk2_YwXC2832WDFBU4germJSBo5oWc5ZMapWqg/viewform?usp=pp_url&entry.678263372=Mastering+Timesheets+%26+Time+Tracking+Webinar',
  ),
  array(
    'name' => 'Advanced Scheduling Webinar',
    'link' => 'https://docs.google.com/forms/d/e/1FAIpQLSf9EaYJklQaqAeELe5VDUc7LiC7l-OsicaapAjUsDULXb_-bQ/viewform?usp=pp_url&entry.1189437806=Advanced+Scheduling+Webinar',
  ),
  array(
    'name' => 'Plans & Pricing',
    'link' => 'https://docs.google.com/forms/d/e/1FAIpQLScWuukXwnSnVQr3Fnt78YKCZ_PHJPRWe3TTpklh34jAcX0uTA/viewform?usp=pp_url&entry.1118034404=Plans+%26+Pricing',
  ),
  array(
    'name' => 'Intro to Admin',
    'link' => 'https://docs.google.com/forms/d/e/1FAIpQLSecTxpOgBHWEnrPVRv_6Sx0MWf8cy57J1cWhTCvgf6ndTcRaQ/viewform?usp=pp_url&entry.1087459502=Intro+to+Admin',
  ),
  array(
    'name' => 'Mobile App',
    'link' => 'https://docs.google.com/forms/d/e/1FAIpQLSenBrs-NEt5F3FAtbRV_3PSuLnPbNOAXBLHHQ6-0sk6c_UZLg/viewform?usp=pp_url&entry.1422225535=Mobile+App',
  ),
  array(
    'name' => 'Intro to ZD',
    'link' => 'https://docs.google.com/forms/d/e/1FAIpQLSecPVAWq_r1MGmY-dY_XR0i4w1d5aPWBD8XBHSE4ej1dt-WQA/viewform?usp=pp_url&entry.605042203=Intro+to+ZD',
  ),
  array(
    'name' => 'Intro to IC',
    'link' => 'https://docs.google.com/forms/d/e/1FAIpQLSc9cVJnSh0tlKK8VVrnQzMg3PKHmDxc4xhOtwwKvThZB-waWA/viewform?usp=pp_url&entry.2090905928=Intro+to+IC',
  ),
  array(
    'name' => 'CS Plans & Merchants',
    'link' => 'https://docs.google.com/forms/d/e/1FAIpQLSeku5JygYWPX_osG1l8v0fkcZb9bC5IQ7U8XJZSs01h9kHTMQ/viewform?usp=pp_url&entry.2085626076=CS+Plans+%26+Merchants',
  ),
  array(
    'name' => 'Hiring',
    'link' => 'https://docs.google.com/forms/d/e/1FAIpQLSenENyk_XNwUeIWpGyaVMPOWDnK_uR8HCRuap7NpEs1x5YgSA/viewform?usp=pp_url&entry.2108337842=Hiring',
  ),
);

echo '<div style="background-color: #8857ac; color: white; padding: 5px;"><strong>'.do_shortcode('[icon agent="fa-search-plus"]').' [MGMT] CS Trainees</strong></div>';

	echo '<div style="padding-left: 30px; margin-top: 0px; padding-top: 10px; padding-bottom: 10px; background-color: #fcf7fc;">';

  echo '<form method="post" action="/trainee-manager">
  <div class="form-group">
  <label for="txtTraineeName">Trainee Name</label>
    <select class="form-control" id="txtTraineeName" name="trainee_name">';
    //echo '<option value="Today">Today</option>';

    $args = array(
      'role'    => 'Trainee',
      'orderby' => 'user_nicename',
      'order'   => 'ASC'
    );
    $users = get_users( $args );

    foreach ( $users as $user ) {
      echo "<option ".selected($_POST['trainee_name'], $user->user_login)."value=".$user->user_login.">".$user->user_login."</option>";
    }

/* New Feature
How Something Currently Works
Format
Permissions
Exports
Other */

    echo '</div>
    <div class="form-group">
    </select>
    <input class="btn btn-primary" style="margin-top: 10px; margin-bottom: 20px;" type="submit" value="Go!"/>
  </form><br>';

     $option = isset($_POST['trainee_name']) ? $_POST['trainee_name'] : -1;
     if ($option != -1) {
       echo '<div style="padding-left: 30px; margin-top: 0px; padding-top: 10px; padding-bottom: 10px; background-color: #fcf7fc;"><div style="background-color: black; color: white; padding-left: 10px;"><h1>Quiz Progress</h1></div>';

       $quizProgress = array();
       $username = $_POST['trainee_name'];

       for ($i = 0; $i < count($quizzes); $i++) {
         $quiz = $wpdb->get_row( "SELECT * FROM cs_quizzes WHERE quiz_name LIKE '%".$quizzes[$i]['name']."%' AND trainee_name LIKE '%". $username ."%'", ARRAY_N);

         if (!empty($quiz)) {
           $quizProgress[] = array('name' => $quizzes[$i]['name'], 'completed' => 1, 'score' => $quiz[4], 'date_completed' => $quiz[3]);
         } else {
           $quizProgress[] = array('name' => $quizzes[$i]['name'], 'completed' => 0, 'score' => $quiz[4], 'date_completed' => $quiz[3]);
         }
       }

       echo '<ol>';
       for ($i = 0; $i < count($quizProgress); $i++) {
         if ($quizProgress[$i]['completed']) {
           echo '<li style="color: green;">'.do_shortcode('[icon name="fa-check"]').' '.$quizProgress[$i]['name'].'</li>';
           echo '<div style="margin-left: 30px;">';
           echo '<ul style="font-size: 10px">';
           echo '<li><b>Completed:</b> '.$quizProgress[$i]['date_completed'].'</li>';
           echo '<li><b>Score:</b> '.$quizProgress[$i]['score'].'</li>';
           echo '</ul>';
           echo '</div>';
         }
         else if (!$quizProgress[$i]['completed'] && $quizProgress[$i-1]['completed'] || $i == 0) {
           $index = 0;
           for ($j = 0; $j < count($quizzes); $j++) {
             if ($quizzes[$j]['name'] == $quizProgress[$i]['name']) {
               $index = $j;
             }
           }

           $url = $quizzes[$index]['link'];
           echo '<a href="'.$url.'" target="_blank"><li style="color: red;">'.do_shortcode('[icon name="fa-unlock"]').' '.$quizProgress[$i]['name'].'</li></a>';
         } else {
           echo '<li style="color: gray;">'.do_shortcode('[icon name="fa-lock"]').' '.$quizProgress[$i]['name'].'</li>';
         }
       }
       echo '</ol>';

     } else {
       echo "Please select a trainee to view their quiz progress.";
     }

  echo '</div>'


?>
