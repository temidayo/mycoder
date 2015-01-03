<?php
/**
 * A class to generate data objects from database tables(PHP 4 compliant data objects).
 * 
 * @author O. Joseph Temidayo, temidayo@expertfingers.com
 * @version 0.1
 *change history
 - single code around keys in array data i.e data['key'] instead of data[key] 28 April 2009
 - stopped generating variables(cos it's actually not necessary fo the data Objects) 17 August 2009
 * Copyright (C) 2008  Temidayo
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
class doGenerator
{
	/**
	 * The String variable to store all the generated code.
	 *
	 * @var String
	 */
	private $output;
	
	
	public function __construct($tables, $columns)
	{
		$this -> generate($tables, $columns);
	}
	
	
	
	/**
	 * Master method to produce workable data Objects.
	 *
	 * @param Array $tables array of the tables in the db.
	 * @param Array $columns recursive array containing all column information.
	 */
	private function generate($tables, $columns)
	{
		for ($i = 0; $i < sizeOf($tables); $i++)
		{
			$this -> output .= '/*============ ' . $tables[$i] . '.class.php[BEGIN]============*/<br><br>';
			$this -> output .= 'class ' . ucfirst($tables[$i]) . ' extends DataObjectParent<br>{<br>';
			//$this -> generateVariables($i, $columns);
			$this -> generateConstructor($tables[$i],$columns[$i][0]['Field']);
			$this -> generateSetters($i, $columns);
			//$this -> generateGetters($i, $columns);
			$this -> output .= '}<br>';
			$this -> output .= '/*============ ' . $tables[$i] . '.class.php[END] ============*/<br><br>';
		}
	}
	/** 17 Dec 2009
	 * A method to generate code for the contructor.
	 *
	 * @param String $tableName Name of current table.
	 * @param String $primaryKey .
	 */	
	private function generateConstructor($tableName,$primaryKey){
		$this -> output .= 'function ' . ucfirst($tableName) . '()<br>';
		$this -> output .= '{<br>';
		$this -> output .= 'parent::DataObjectParent();<br>';
		$this -> output .= '$this->primaryKey = \'' . $primaryKey . '\';<br>';
		$this -> output .= '$this->tableName = \'' . $tableName . '\';<br>';
		$this -> output .= '$this->className = \'' . ucfirst($tableName) . '\';<br>';
		//$this -> output .= '$this->error = 0;<br>';
		$this -> output .= '}<br><br>';
	}
	
	/**
	 * A method to generate code for the needed variables.
	 *
	 * @param Integer $i keeps track of which table for which we are constructing a VO.
	 * @param Array $columns recursive array containing all column information.
	 */
	private function generateVariables($i, $columns)
	{
		for ($j = 0; $j < sizeOf($columns[$i]); $j++)
		{
			$this -> output .= '/**<br>';
			//$this -> output .= ' * Enter description here...<br>';
			//$this -> output .= ' *<br>';
			$this -> output .= ' * @var ' .$columns[$i][$j]['Type'] . '<br>';
			$this -> output .= ' */<br>';

			$this -> output .= 'var $' .$columns[$i][$j]['Field'] .';<br><br>';
		}
		$this -> output .= '<br><br>';
	}
	
	
	
	/**
	 * Method to generate the 'setter' methods.
	 *
	 * @param Integer $i keeps track of which table for which we are constructing a VO.
	 * @param Array $columns recursive array containing all column information.
	 */
	private function generateSetters($i, $columns)
	{
		for ($j = 0; $j < sizeOf($columns[$i]); $j++)
		{
			$this -> output .= '/**<br>';
			//$this -> output .= ' * Enter description here...<br>';
			$this -> output .= ' *<br>';
			$this -> output .= ' * @param ' .$columns[$i][$j]['Type'] . ' $' .$columns[$i][$j]['Field'] . '<br>';
			$this -> output .= ' */<br>';
			$this -> output .= 'function set' . ucfirst($columns[$i][$j]['Field']) . '($' . $columns[$i][$j]['Field'] . ')<br>';
			$this -> output .= '{<br>';
			//$this -> output .= '$this -> ' . $columns[$i][$j]['Field'] . ' = $' . $columns[$i][$j]['Field'] . ';<br>';
			$this -> output .= '$this->data[\''.$columns[$i][$j]['Field'].'\'] = $' . $columns[$i][$j]['Field'] . ';<br>';
			$this -> output .= '$this->changedFields[] = \''.$columns[$i][$j]['Field'].'\';<br>';
			$this -> output .= '}<br><br>';
		}
	}
	
	
	
	/**
	 * Method to generate the 'getter' methods.
	 *
	 * @param Integer $i keeps track of which table for which we are constructing a VO.
	 * @param Array $columns recursive array containing all column information.
	 */
	private function generateGetters($i, $columns)
	{
		for ($j = 0; $j < sizeOf($columns[$i]); $j++)
		{
			$this -> output .= '/**<br>';
	 		$this -> output .= '* Enter description here...<br>';
			$this -> output .= ' *<br>';
			$this -> output .= ' * @return ' .$columns[$i][$j]['Type'] . '<br>';
			$this -> output .= ' */<br>';
			$this -> output .= 'public function get' . ucfirst($columns[$i][$j]['Field']) . '()<br>';
			$this -> output .= '{<br>';
			$this -> output .= 'return $this -> ' . $columns[$i][$j]['Field'] . ';<br>';
			$this -> output .= '}<br><br><br><br>';
		}
	}
	
	
	
	/**
	 * Method to get the generated code.
	 *
	 * @return String the generated VO(s).
	 */
		public function getOutput()
	{
		return $this -> output;
	}
}
?>