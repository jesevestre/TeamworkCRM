<?php

	/**
	 * Detect used web navigator
	 */
	$g_browserName = "Unknown";
	$g_useDateCtl = 1;
	$user_agent = getenv("HTTP_USER_AGENT");
	if (strpos($user_agent, "MSIE") !== false ||
	    (strpos($user_agent, "like Gecko") !== false && strpos($user_agent, "Trident") !== false))
	{
		$g_browserName = "MSIE";
		$g_useDateCtl = 0;
	}
	elseif (strpos($user_agent, "Opera") !== false)
		$g_browserName = "Opera";
	elseif (strpos($user_agent, "Lynx") !== false)
		$g_browserName = "Lynx";
	elseif (strpos($user_agent, "WebTV") !== false)
		$g_browserName = "WebTV";
	elseif (strpos($user_agent, "Konqueror") !== false)
		$g_browserName = "Konqueror";
	elseif (strpos($user_agent, "Safari") !== false)
		$g_browserName = "Safari";
	elseif (strpos($user_agent, "Firefox") !== false)
		$g_browserName = "Firefox";

	/**
	  * Global settings
	  */
	$g_zero_datetime = "1899-12-30T00:00:00.000Z";

	$g_dateFmt = new IntlDateFormatter(
		"fr_FR",
		IntlDateFormatter::FULL,
		IntlDateFormatter::FULL,
		"Europe/Paris",
		IntlDateFormatter::GREGORIAN,
		"dd/MM/yyyy"
	);

	/**
	  * Browser-specific settings
	  */
	$g_dateCtlFmt = "Y-m-d";
	switch ($g_browserName)
	{
		case "Safari":
		case "Firefox":
		case "Chrome":
			$g_dateCtlFmt = "Y-m-d";
			break;
		default:
			$g_dateCtlFmt = "d/m/Y"; //TODO locale-specific
	}

	/**
	 * Limitations de nb de lignes retournées pour des requêtes
	 */
	$g_maxRowsOnPage_Demands = 100000;

	//echo '<p>settings.php : ' . $g_dateFmt->format(0) . '</p>';
?>
