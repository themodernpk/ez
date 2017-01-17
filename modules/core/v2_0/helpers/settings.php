<?php

/* ****** Code Completed till 10th april */
/* #################################
 * We pass id's of user in the setting array which are exception
 * These are setting defined for handling Exceptions
 * Exception Example: we dont want to delete the admin
 * So before deleting anyrhing Check this is Exceptionl case or not
 * First create a blank array then insert your setting in this
 * @Config::set('arg1','arg2') function set the setting
 * @arg1 is name of setting , @arg2 is variable to set
 * #################################
 */
$settings = array();
$settings['groups']['exceptions'] = array(1);
$settings['permissions']['exceptions'] = array();
$settings['users']['exceptions'] = array(1);
$settings['rows_to_display'] = 25;

Config::set('core.settings', $settings);

/* ******\ Code Completed till 10th april */