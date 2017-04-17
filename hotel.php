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


//add options to menu
add_action('admin_menu', 'custom_menu');
function custom_menu() {
//  add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
	add_menu_page ('Bookings', 'Bookings', 'read', 'BookingsMenu', 'BookingsMenu', '');

//  add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function ); 
	add_submenu_page ('BookingsMenu', 'submenu one', 'Add Booking', 'manage_options', 'bookingMenu_1', 'bookingMenu_1');

	add_submenu_page ('BookingsMenu', 'submenu two', 'Customers', 'manage_options', 'bookingMenu_2', 'bookingMenu_2');

	/* add_options_page ('Menu Options', 'Menu Options', 'read', 'Bookings-Menu', 'Optionsmenu'); */

	/* add_dashboard_page('custom dashboard', 'WAD dashboard', 'read', 'wadmenu', 'customdashboardmenu'); */

	
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


/*function custom_menu_2(){
	echo '<h1>My Custom menu Page</h1>';

} */




?>