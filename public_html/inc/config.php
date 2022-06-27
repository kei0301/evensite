<?php
	ini_set( 'session.gc_maxlifetime', 3600);
	if(!isset($_SESSION))
		session_start();
	
	define("DB_SERVER", "localhost");
	define("DB_USER", "eyensite_eyensite");
	define("DB_PASSWORD", "]EBmA%}hh*!Z");
	define("DB_NAME", "eyensite_eyensite");
	
	define("DATE_FORMAT", "M j, Y"); // h:i A
	define("DATETIME_FORMAT", "M j, Y h:i A");
	define("DB_DATE_FORMAT", "Y-m-d H:i:s");

    define("SITE_URL", "https://eyen.site/");
	
	date_default_timezone_set("Asia/Riyadh");
	putenv("TZ=Asia/Riyadh");
	
	require_once("functions.php");
	//require_once("I18N/Arabic.php");
	db_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);
	
	$res = db_query("SELECT * FROM `label`");
	$labels = db_fetch_array($res);
	if(is_array($labels)) foreach ($labels as $label) {
		$GLOBALS["currLabels"][($label['eng'])] = "".$label['arabic'];
	}
	//echo $currLabels[('Actions')];
	//var_dump($currLabels);
	//exit;
	function getArabic($str) {
		if(!isset($GLOBALS["currLabels"][($str)])) return "(.ar)";
		if(empty($GLOBALS["currLabels"][($str)])) return "(ar.)";
    	if(isset($GLOBALS["currLabels"][($str)]) && !empty($GLOBALS["currLabels"][($str)])) {
    		return $GLOBALS["currLabels"][($str)];
    	}
    	return "(ar)";
	}

	$alertMsg = "";
	$alertType = "danger";
	/**
 * config.php
 *
 * Author: pixelcave
 *
 * Configuration file. It contains variables used in the template as well as the primary navigation array from which the navigation is created
 *
 */

/* Template variables */
$template = array(
    'name'              => 'Eainy Dalaa',
    'version'           => '',
    'author'            => '',
    'robots'            => 'noindex, nofollow',
    'title'             => 'Visual Acuity',
    'description'       => 'Eainy Dalaa',
    // true                     enable page preloader
    // false                    disable page preloader
    'page_preloader'    => false,
    // true                     enable main menu auto scrolling when opening a submenu
    // false                    disable main menu auto scrolling when opening a submenu
    'menu_scroll'       => true,
    // 'navbar-default'         for a light header
    // 'navbar-inverse'         for a dark header
    'header_navbar'     => 'navbar-default',
    // ''                       empty for a static layout
    // 'navbar-fixed-top'       for a top fixed header / fixed sidebars
    // 'navbar-fixed-bottom'    for a bottom fixed header / fixed sidebars
    'header'            => '',
    // ''                                               for a full main and alternative sidebar hidden by default (> 991px)
    // 'sidebar-visible-lg'                             for a full main sidebar visible by default (> 991px)
    // 'sidebar-partial'                                for a partial main sidebar which opens on mouse hover, hidden by default (> 991px)
    // 'sidebar-partial sidebar-visible-lg'             for a partial main sidebar which opens on mouse hover, visible by default (> 991px)
    // 'sidebar-mini sidebar-visible-lg-mini'           for a mini main sidebar with a flyout menu, enabled by default (> 991px + Best with static layout)
    // 'sidebar-mini sidebar-visible-lg'                for a mini main sidebar with a flyout menu, disabled by default (> 991px + Best with static layout)
    // 'sidebar-alt-visible-lg'                         for a full alternative sidebar visible by default (> 991px)
    // 'sidebar-alt-partial'                            for a partial alternative sidebar which opens on mouse hover, hidden by default (> 991px)
    // 'sidebar-alt-partial sidebar-alt-visible-lg'     for a partial alternative sidebar which opens on mouse hover, visible by default (> 991px)
    // 'sidebar-partial sidebar-alt-partial'            for both sidebars partial which open on mouse hover, hidden by default (> 991px)
    // 'sidebar-no-animations'                          add this as extra for disabling sidebar animations on large screens (> 991px) - Better performance with heavy pages!
    'sidebar'           => '',
    // ''                       empty for a static footer
    // 'footer-fixed'           for a fixed footer
    'footer'            => '',
    // ''                       empty for default style
    // 'style-alt'              for an alternative main style (affects main page background as well as blocks style)
    'main_style'        => '',
    // ''                           Disable cookies (best for setting an active color theme from the next variable)
    // 'enable-cookies'             Enables cookies for remembering active color theme when changed from the sidebar links (the next color theme variable will be ignored)
    'cookies'           => '',
    // 'night', 'amethyst', 'modern', 'autumn', 'flatie', 'spring', 'fancy', 'fire', 'coral', 'lake',
    // 'forest', 'waterlily', 'emerald', 'blackberry' or '' leave empty for the Default Blue theme
    'theme'             => '',
    // ''                       for default content in header
    // 'horizontal-menu'        for a horizontal menu in header
    // This option is just used for feature demostration and you can remove it if you like. You can keep or alter header's content in page_head.php
    'header_content'    => 'horizontal-menu',
    'active_page'       => basename($_SERVER['PHP_SELF'])
);

/* Primary navigation array (the primary navigation will be created automatically based on this array, up to 3 levels deep) */
$primary_nav = array(
    array(
        'name'  => 'Home',
        'url'   => 'index.php'
    ),
    array(
        'name'  => 'Pages',
        'url'   => 'cont_stp.php'
    ),
    array(
        'name'  => 'Contact messages',
        'url'   => 'contacts.php'
    )
);