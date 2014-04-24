<?php
//
// ZoneMinder HTML interface file, $Date: 2008-09-26 10:47:20 +0100 (Fri, 26 Sep 2008) $, $Revision: 2632 $
// Copyright (C) 2001-2008 Philip Coombes
// 
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.
// 
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// 
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
// 

if ( empty($_COOKIE['zmBandwidth']) )
    $_COOKIE['zmBandwidth'] = "low";

//ini_set( "magic_quotes_gpc", "Off" );

// Uncomment if there are language overrides
if ( $skinLangFile = loadLanguage( ZM_SKIN_PATH ) )
    require_once( $skinLangFile );

foreach ( getSkinIncludes( 'includes/config.php' ) as $includeFile )
    require_once $includeFile;

foreach ( getSkinIncludes( 'includes/functions.php' ) as $includeFile )
    require_once $includeFile;

if ( empty($view) )
    $view = isset($user)?'arc-console':'login';

if ( !isset($user) && ZM_OPT_USE_AUTH )
{
    if ( ZM_AUTH_TYPE == "remote" && !empty( $_SERVER['REMOTE_USER'] ) )
    {
        $view = "postlogin";
        $action = "login";
        $_REQUEST['username'] = $_SERVER['REMOTE_USER'];
    }
    else
    {
        $view = "login";
    }
}

if ( isset($user) )
{
    // Bandwidth Limiter
    if ( !empty($user['MaxBandwidth']) )
    {
        if ( $user['MaxBandwidth'] == "low" )
        {
            $_COOKIE['zmBandwidth'] = "low";
        }
        elseif ( $user['MaxBandwidth'] == "medium" && $_COOKIE['zmBandwidth'] == "high" )
        {
            $_COOKIE['zmBandwidth'] = "medium";
        }
    }
}

// If there are additional actions
foreach ( getSkinIncludes( 'includes/actions.php' ) as $includeFile )
    require_once $includeFile; 

//============================================================
// ARC Console additions

// Enables debug messages to console if enabled.
$ARC_DEBUG_ENABLED = false;

// If true, adds an extra "debug" pane to views that support it.
$ARC_DEBUG_PANE = false;

// Experimental feature, but safe to leave set to 'true' unless your server's IP
// address is on the subnet 192.168.100/255.  See direct-streams.php.
//
$ARC_DIRECT_STREAMS_ALLOWED = true;

?>