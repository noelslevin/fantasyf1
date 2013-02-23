<?php

/*
Plugin Name: Fantasy F1
Plugin URI: http://www.noelinho.org
Description: Noelinho's plugin for WordPress for self-hosting GridBids.
Version: 0.1
Author: Noelinho
Author URI: http://www.noelinho.org
License: None. No permission granted for use outside of Noelinho.org
*/

add_action('admin_menu', 'fantasyf1_menu');
add_action('admin_menu', 'fantasyf1_admin');

function fantasyf1_menu() {
	add_menu_page('Fantasy F1', 'Fantasy F1', 'read', 'fantasyf1', 'fantasyf1'); // This is a general info page
	add_submenu_page('fantasyf1', 'Make Your Picks', 'Make Your Picks', 'read', 'fantasyf1_picks', 'fantasyf1_picks'); // For making picks
/*	add_submenu_page('fantasyf1', 'Fantasy F1 Profile', 'Fantasy F1 Profile', 'read', 'fantasyf1_profile', 'fantasyf1_profile'); // Profile options
	add_submenu_page('fantasyf1', 'Results', 'Results', 'read', 'fantasyf1_results', 'fantasyf1_results'); // Latest results*/
}

function fantasyf1_admin() {
	add_menu_page('Fantasy Admin', 'Fantasy Admin', 'administrator', 'fantasy_admin', 'fantasy_admin');
	add_submenu_page('fantasy_admin', 'Submit Results', 'Submit Results', 'administrator', 'fantasyf1_submitresults', 'fantasyf1_submitresults');
	add_submenu_page('fantasy_admin', 'Global Options', 'Global Options', 'administrator', 'fantasyf1_globaloptions', 'fantasyf1_globaloptions');
	add_submenu_page('fantasy_admin', 'Raw Data', 'Raw Data', 'administrator', 'fantasyf1_f1data', 'fantasyf1_f1data');
	add_submenu_page('fantasy_admin', 'Race Entries', 'Race Entries', 'administrator', 'fantasyf1_race_entries', 'fantasyf1_race_entries');
	add_submenu_page('fantasy_admin', 'Driver Values', 'Driver Values', 'administrator', 'fantasyf1_driver_values', 'fantasyf1_driver_values');
	add_submenu_page('fantasy_admin', 'Fantasy Data', 'Fantasy Data', 'administrator', 'fantasyf1_fantasy_data', 'fantasyf1_fantasy_data');
	add_submenu_page('fantasy_admin', 'Fantasy Results', 'Fantasy Results', 'administrator'
, 'fantasyf1_fantasy_results', 'fantasyf1_fantasy_results');
add_submenu_page('fantasy_admin', 'Fantasy Standings', 'Fantasy Standings', 'administrator'
, 'fantasyf1_fantasy_standings', 'fantasyf1_fantasy_standings');
}

function fantasyf1() {
	include 'introduction.php';
	}
	
function fantasyf1_picks() {
	include 'picks.php';
	}

function fantasyf1_profile() {
	include 'user_profile.php';
	}
	
function fantasyf1_results() {
	include 'fantasy_results.php';
	}
	
function fantasyf1_submitresults() {
	include 'submit_race_results.php';
	}

function fantasy_admin() {
	include 'fantasy_admin.php';
	}

function fantasyf1_globaloptions() {
	// Needs to be able to pull active race ID.

	// Need to add a new column in races to control whether picks are active or not. This file then needs to activate on this criteria.
	
	include 'fantasy_global_options.php';
	}

function fantasyf1_f1data() {
	include 'raw_data.php';
	}

function fantasyf1_race_entries() {
	include 'race_entries.php';
	}

function fantasyf1_driver_values() {
	include 'driver_values.php';
	}

function fantasyf1_fantasy_data() {
	include 'fantasy_data/index.php';
	}

function fantasyf1_fantasy_results() {
	include 'fantasy_results.php';
	}

function fantasyf1_fantasy_standings() {
	include 'fantasy_standings.php';
	}

?>
