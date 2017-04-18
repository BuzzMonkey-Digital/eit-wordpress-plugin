<?php
/**
 * @package EIT Bookings Assignment
 * @version 1.0
 */
/*
Plugin Name: EIT Bookings Assignment
Plugin URI: http://www.eit.ac.nz
Description: Online reservations and bookings. WAD Assignment 2.
Author: Lance Wagg & Michael Magrian
Version: 1.0
Author URI: http://www.eit.ac.nz
*/

// ########################################## MENUS ##############################################
//add options to menu
add_action('admin_menu', 'custom_menu');
function custom_menu() {
//  add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
	add_menu_page ('Bookings', 'Bookings', 'read', 'BookingsMenu', 'BookingsMenu', '');

//  add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function ); 
	add_submenu_page ('BookingsMenu', 'submenu one', 'Add Booking', 'manage_options', 'bookingMenu_1', 'bookingMenu_1');

	add_submenu_page ('BookingsMenu', 'submenu two', 'Customers', 'manage_options', 'bookingMenu_2', 'bookingMenu_2');
}


function BookingsMenu(){
	echo '<h1>Bookings Calendar Overview</h1>';
}

function bookingMenu_1() {
	echo '<h1>Add Booking</h1>';
}


function bookingMenu_2() {
	echo '<h1>Client Details</h1>';
}

// ########################################### CALENDAR ###########################################

// Queue the WADcalendar.css stylesheet
add_action( 'wp_enqueue_scripts', 'CALENDAR_scripts' );
function CALENDAR_scripts() {
    wp_enqueue_style( 'calendarStyle', plugins_url('css/WADcalendar.css',__FILE__));
}

//-------------------------------------------------------------------------
 add_shortcode('calShortCode','aCalendar');
function aCalendar($shortcodeattributes) {
	//days of the week used for headings. This particular method is not particulary multilanguage friendly.
	$weekdays = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
	extract(shortcode_atts(array('year' => '-', 'month' => '-'), $shortcodeattributes));	

	//default to the current month and year
    if ($month == '-') $month = date('m');	
    if ($year == '-') $year = date('Y');	

//get the previous month's days - used to fill in the blank days at the start.	
    //make sure we roll over to december in the case of $month being January	
	if ($month == 1) //January?
	   $prevmonth = 12; //December
    else 
	   $prevmonth = $month; 
//shortend, harder to read, version of the if ...else... above   
	$prevmonth = ($month == 1)?12:$month; 
	$prevdays = date('t',mktime(0,0,1,$prevmonth,1,$year));	//days in the previous month	
	
//calculate a few date values for the current/selected month & year	
	$dow = date('w',mktime(0,0,1,$month,1,$year)); //day of the week
	$days = date('t',mktime(0,0,1,$month,1,$year));	//days in the month
	$lastblankdays = 7-(($dow+$days) % 7); //remaining days in the last week
	$lastblankdays = ($lastblankdays==7)?0:$lastblankdays;

//calendar heading - note we are using flexbox for the styling
    $thedate = date('F Y',mktime(0,0,1,$month,1,$year));
	echo '<main id="calendar"><div>'.$thedate.'</div><div class="th">';
	
//HEADING ROW: print out the week names	
	foreach ($weekdays as $wd) {
	  echo '<span>'.$wd.'</span>';
	}		
	echo '</div>';
	
//CALENDAR WEEKS: generate the calendar body
	//starting day of the previous month, used to fill the blank day slots
     $startday = $prevdays - ($dow-1); //calculate the number of days required from the prev month
	//PART 1: first week with initial blank days (cells) or previous month
    echo '<div class="week">';
  	for ($i=0; $i < $dow; $i++) 
		//refer to lines 43-53 in the WADcalendar.css for information regarding the data-date styling
		echo '<div data-date="'.$startday++.'"></div>';//!! this increments $startday AFTER the value has been used
	
	//PART 2: main calendar calendar body
	for ($i=0; $i < $days; $i++) {
	   
		//check for the week boundary - % returns the remainder of a division
		if (($i+$dow) % 7 == 0) { //no remainder means end of the week
		  echo '</div><div class="week">';
		}
		
//print the actual day (cell) with events
		echo '<div data-date="'.($i+1).'">'; //add 1 to the for loop variable as it starts at zero not one
		//..... insert your event code and such here
		echo '</div>';
	}
	
	//PART 3: last week with blank days (cells) or couple of days from next month
	$j = 1; //counter for next months days used to fill in the blank days at the end
  	for ($i=0; $i < $lastblankdays; $i++) 
		echo '<div data-date="'.$j++.'"></div>'; //!! this increments $j AFTER the value has been used
//close off the calendar	
	echo '</div></main>';
}



?>