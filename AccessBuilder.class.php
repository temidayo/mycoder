<?php
/**
 * A class to retrieve info about database tables.
 * 
 * @author Christian Velin, christian.velin@conjurer.org
 * @version 0.2
 * @since 0.1 Added phpdoc tags to each generated variable and method.
 * @package DbCodeBuilder
 * 
 * Copyright (C) 2007  Christian Velin
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 * 
 * http://www.gnu.org/copyleft/gpl.html
 */
class AccessBuilder
{
	/**
	 * Variable to hold the db connection.
	 *
	 * @var unknown_type
	 */
	private $link;
	
	/**
	 * An array to store all the tables in the selected db.
	 *
	 * @var Array
	 */
	private $tables = array();
	
	/**
	 * A recursive array to hold all the column info for each of the tables.
	 *
	 * @var Array
	 */
	private $tableInfo = array();
	
	
	
	public function __construct($host, $user, $pass, $db)
	{
		$this -> link = mysql_connect($host, $user, $pass);
		mysql_select_db($db);
	}
	
	
	
	/**
	 * A method to discover what tables are stored in the selected db and to store that information.
	 *
	 */
	public function setTables()
	{
		$result = mysql_query("SHOW tables", $this -> link); 
		while($row = mysql_fetch_row($result)) 
		{ 
			$this -> setColumnInfo($row[0]); 
			array_push($this -> tables, $row[0]);
		}
	}
	
	
	
	/**
	 * A method to get and store all information about the columns in each table.
	 *
	 * @param unknown_type $table
	 */
	private function setColumnInfo($table)
	{
		$result = mysql_query("SHOW COLUMNS FROM " . $table) OR die('ERROR: '.mysql_error());

		if (mysql_num_rows($result) > 0)
		{
			$info = array();
		    while ($row = mysql_fetch_assoc($result))
		    {
		        array_push($info, $row);
		    }
		    array_push($this -> tableInfo, $info);
		}
	}
	
	
	
	/**
	 * Method that returns the table information.
	 *
	 * @return Array an array with all available tables.
	 */
	public function getTables()
	{
		return $this -> tables;
	}
	
	
	
	
	/**
	 * Method that returns the column information.
	 *
	 * @return unknown
	 */
	public function getColumnInfo()
	{
		return $this -> tableInfo;
	}
}


?>