<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2026-04-21 08:34:11 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo2ai0lt9mv4', NULL)
ERROR - 2026-04-21 09:03:44 --> Query error: Illegal mix of collations (utf8mb4_general_ci,IMPLICIT) and (utf8mb3_general_ci,COERCIBLE) for operation 'like' - Invalid query: SELECT *, a.id_employee,
				case 
					when c.department != '' and c.evaluation_year = '-1' then c.department
				else
					a.department
				end as department, 
				case 
					when c.division != '' and c.evaluation_year = '-1' then c.division
				else
					a.division
				end as division,
				case 
					when c.usrid_long2 != '' and c.evaluation_year = '-1' then c.usrid_long2
				else
					a.usrid_long2
				end as usrid_long2,
				case 
					when c.usrid_long3 != '' and c.evaluation_year = '-1' then c.usrid_long3
				else
					a.usrid_long3
				end as usrid_long3,
				case 
					when c.usrid_long4 != '' and c.evaluation_year = '-1' then c.usrid_long4
				else
					a.usrid_long4
				end as usrid_long4
				FROM
				v_hris_employee_updated a
				LEFT JOIN users b ON a.nik = b.employee_id
				LEFT JOIN employee_update_division_pa as c on a.id_employee = c.id_employee
				WHERE (lower(a.email) like 'iluuwvb#niawgq.#v@q#bvc#.jk#pit#' OR a.nik = 'fathony.adnan@ibsmulti.com') AND b.password like '8#4#078#8#Â#1#¹#' and b.is_active <> 0
				ORDER BY a.id_employee DESC
ERROR - 2026-04-21 09:03:44 --> Severity: error --> Exception: Call to a member function result() on bool /var/www/html/api.hris.ibsw/application/models/Mhris_ibsw.php 327
ERROR - 2026-04-21 09:03:49 --> Query error: Illegal mix of collations (utf8mb4_general_ci,IMPLICIT) and (utf8mb3_general_ci,COERCIBLE) for operation 'like' - Invalid query: SELECT *, a.id_employee,
				case 
					when c.department != '' and c.evaluation_year = '-1' then c.department
				else
					a.department
				end as department, 
				case 
					when c.division != '' and c.evaluation_year = '-1' then c.division
				else
					a.division
				end as division,
				case 
					when c.usrid_long2 != '' and c.evaluation_year = '-1' then c.usrid_long2
				else
					a.usrid_long2
				end as usrid_long2,
				case 
					when c.usrid_long3 != '' and c.evaluation_year = '-1' then c.usrid_long3
				else
					a.usrid_long3
				end as usrid_long3,
				case 
					when c.usrid_long4 != '' and c.evaluation_year = '-1' then c.usrid_long4
				else
					a.usrid_long4
				end as usrid_long4
				FROM
				v_hris_employee_updated a
				LEFT JOIN users b ON a.nik = b.employee_id
				LEFT JOIN employee_update_division_pa as c on a.id_employee = c.id_employee
				WHERE (lower(a.email) like 'iluuwvb#niawgq.#v@q#bvc#.jk#pit#' OR a.nik = 'fathony.adnan@ibsmulti.com') AND b.password like '8#4#078#8#Â#1#¹#' and b.is_active <> 0
				ORDER BY a.id_employee DESC
ERROR - 2026-04-21 09:03:49 --> Severity: error --> Exception: Call to a member function result() on bool /var/www/html/api.hris.ibsw/application/models/Mhris_ibsw.php 327
ERROR - 2026-04-21 09:04:04 --> Query error: Illegal mix of collations (utf8mb4_general_ci,IMPLICIT) and (utf8mb3_general_ci,COERCIBLE) for operation 'like' - Invalid query: SELECT *, a.id_employee,
				case 
					when c.department != '' and c.evaluation_year = '-1' then c.department
				else
					a.department
				end as department, 
				case 
					when c.division != '' and c.evaluation_year = '-1' then c.division
				else
					a.division
				end as division,
				case 
					when c.usrid_long2 != '' and c.evaluation_year = '-1' then c.usrid_long2
				else
					a.usrid_long2
				end as usrid_long2,
				case 
					when c.usrid_long3 != '' and c.evaluation_year = '-1' then c.usrid_long3
				else
					a.usrid_long3
				end as usrid_long3,
				case 
					when c.usrid_long4 != '' and c.evaluation_year = '-1' then c.usrid_long4
				else
					a.usrid_long4
				end as usrid_long4
				FROM
				v_hris_employee_updated a
				LEFT JOIN users b ON a.nik = b.employee_id
				LEFT JOIN employee_update_division_pa as c on a.id_employee = c.id_employee
				WHERE (lower(a.email) like 'iluuwvb#niawgq.#v@q#bvc#.jk#pit#' OR a.nik = 'fathony.adnan@ibsmulti.com') AND b.password like '8#4#078#8#Â#1#¹#' and b.is_active <> 0
				ORDER BY a.id_employee DESC
ERROR - 2026-04-21 09:04:04 --> Severity: error --> Exception: Call to a member function result() on bool /var/www/html/api.hris.ibsw/application/models/Mhris_ibsw.php 327
ERROR - 2026-04-21 09:04:23 --> Query error: Illegal mix of collations (utf8mb4_general_ci,IMPLICIT) and (utf8mb3_general_ci,COERCIBLE) for operation 'like' - Invalid query: SELECT *, a.id_employee,
				case 
					when c.department != '' and c.evaluation_year = '-1' then c.department
				else
					a.department
				end as department, 
				case 
					when c.division != '' and c.evaluation_year = '-1' then c.division
				else
					a.division
				end as division,
				case 
					when c.usrid_long2 != '' and c.evaluation_year = '-1' then c.usrid_long2
				else
					a.usrid_long2
				end as usrid_long2,
				case 
					when c.usrid_long3 != '' and c.evaluation_year = '-1' then c.usrid_long3
				else
					a.usrid_long3
				end as usrid_long3,
				case 
					when c.usrid_long4 != '' and c.evaluation_year = '-1' then c.usrid_long4
				else
					a.usrid_long4
				end as usrid_long4
				FROM
				v_hris_employee_updated a
				LEFT JOIN users b ON a.nik = b.employee_id
				LEFT JOIN employee_update_division_pa as c on a.id_employee = c.id_employee
				WHERE (lower(a.email) like 'iluuwvb#niawgq.#v@q#bvc#.jk#pit#' OR a.nik = 'fathony.adnan@ibsmulti.com') AND b.password like '8#4#078#8#Â#1#¹#' and b.is_active <> 0
				ORDER BY a.id_employee DESC
ERROR - 2026-04-21 09:04:23 --> Severity: error --> Exception: Call to a member function result() on bool /var/www/html/api.hris.ibsw/application/models/Mhris_ibsw.php 327
ERROR - 2026-04-21 09:16:38 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo2ai0lt9mv4', NULL)
ERROR - 2026-04-21 09:51:47 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo2ai0lt9mv4', NULL)
ERROR - 2026-04-21 09:52:10 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo2ai0lt9mv4', NULL)
ERROR - 2026-04-21 09:52:38 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo2ai0lt9mv4', NULL)
ERROR - 2026-04-21 09:53:06 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo2ai0lt9mv4', NULL)
ERROR - 2026-04-21 09:53:07 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo2ai0lt9mv4', NULL)
ERROR - 2026-04-21 09:53:07 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo2ai0lt9mv4', NULL)
ERROR - 2026-04-21 10:06:38 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo2ai0lt9mv4', NULL)
ERROR - 2026-04-21 10:07:11 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo2ai0lt9mv4', NULL)
ERROR - 2026-04-21 10:07:35 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo2ai0lt9mv4', NULL)
ERROR - 2026-04-21 10:11:12 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo2ai0lt9mv4', NULL)
ERROR - 2026-04-21 10:11:27 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo2ai0lt9mv4', NULL)
ERROR - 2026-04-21 10:11:41 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo2ai0lt9mv4', NULL)
ERROR - 2026-04-21 15:46:05 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo2ai0lt9mv4', NULL)
ERROR - 2026-04-21 15:54:49 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo2ai0lt9mv4', NULL)
ERROR - 2026-04-21 16:04:28 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo2ai0lt9mv4', NULL)
ERROR - 2026-04-21 16:28:21 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo2ai0lt9mv4', NULL)
