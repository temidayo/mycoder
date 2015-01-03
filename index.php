<?php
#last updated - 05 Dec 2010 - Temidayo Oluwabusola
/* How to use the DbCodeBuilder and generate DAO's and VO's on the fly [START] */
include('AccessBuilder.class.php');
include('doGenerator.class.php');
//include('DAOFormatter.class.php');
$database = empty($_REQUEST['db'])? 'rim' : trim($_REQUEST['db']);
$builder = new AccessBuilder('localhost','root','',$database);
//'epaynet','mycrud','smscombo','mcc','smshulk','mysy','bankphb_sub_mortgages','eduportal','uniportal'
$builder -> setTables();

$tables = $builder->getTables();
$columns = $builder->getColumnInfo();

$doGenerator = new doGenerator($tables, $columns);
print '&lt?php /* Request is : db ';
print '<br />Database: '.$database.'*/<br />#combined ORM - concept created by Temidayo Oluwabusola 03 December 2010<br />#file Last Updated - '.date('d F Y');
print'<br />';
print $doGenerator -> getOutput();
print' ?>';
/*$daoFormatter = new DAOFormatter($tables, $columns);
print $daoFormatter->getOutput();
*/
/* How to use the DbCodeBuilder and generate DAO's and VO's on the fly [END] */



/*=================DB structure for the sample code below [START]================
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `username` varchar(120) collate utf8_unicode_ci NOT NULL default '',
  `password` varchar(40) collate utf8_unicode_ci NOT NULL default '',
  `rank` int(2) NOT NULL default '99',
  `active` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;
=================DB structure for the sample code below [START]================*/



/* How to use the generated code to create a new record [START] */
//require('User.VO.php');
//require('User.DAO.php');

//$vo = new UserVO();
//$vo->setId(0); //A new record MUST ALWAYS be set to 0.
//$vo->setUsername('a_user_name');
//$vo->setPassword(sha1('a_password'));
//$vo->setRank(99); // A parameter to keep track of user access levels.
//$vo->setActive(0); // A parameter to see if someone registers but doesn't validate registration.

//$link = mysql_connect('host', 'user', 'password');
//mysql_select_db('db', $link);

//$dao = new UserDAO($link);
//$dao->save($vo);
/* How to use the generated code to create a new record [END] */

/* How to use the generated code to update an existing record [START] */
//$vo->setPassword(sha1('a_new_password'));
//$dao->save($vo);
/* How to use the generated code to update an existing record [END] */



/* How to use the generated code to delete an existing record [START] */
//$dao->delete($vo);
/* How to use the generated code to delete an existing record [END] */
?>
