<?php

/**
   * m_bdd
   * This code is used to initialize the database connection.
   * Global $m_bdd database reference
   */

	/**
	 * DataBase Parameters
	 */
	$dbname = "SQUALPCRM"; /* database name */

	$hostname = "ISOAR-SRV"; /* database host name */
	$username = "MANAGER"; /* database user name */
	$pw = ""; /* database password */
	$bddString = "sqlsrv:Server=".$hostname.";Database=".$dbname; /* SqlServer database */


	/**
	 * DataBase initialisation
	 * Global $m_bdd database reference
	 */
	try
	{
		$m_bdd = new PDO ($bddString, $username, $pw);
		$m_bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch (PDOException $e)
	{
		echo "Failed to get DB handle: " . $e->getMessage() . "\n";
		exit;
	}
?>
