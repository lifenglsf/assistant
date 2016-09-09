<?php  if ( ! defined('ROOT_PATH')) exit('No direct script access allowed'); ?>

[2016-09-08 14:30:40] SQLERR, SQL: SELECT SQL_CALC_FOUND_ROWS *
WHERE `username` = 'admin'
1064,  You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'WHERE `username` = 'admin'' at line 2
[2016-09-08 14:33:10] SQLERR, SQL: SELECT SQL_CALC_FOUND_ROWS *
FROM `tb_account`
WHERE `username` = 'admin'
1054,  Unknown column 'username' in 'where clause'
[2016-09-09 10:33:37] SQLERR, SQL: SELECT SQL_CALC_FOUND_ROWS *
 LIMIT 15
1096,  No tables used
