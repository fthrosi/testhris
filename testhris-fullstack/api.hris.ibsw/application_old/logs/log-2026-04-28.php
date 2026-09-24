<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2026-04-28 06:28:27 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo2ai0lt6mv4', NULL)
ERROR - 2026-04-28 07:28:28 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo2ai0lt6mv4', NULL)
ERROR - 2026-04-28 08:28:29 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo2ai0lt6mv4', NULL)
ERROR - 2026-04-28 09:28:29 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo2ai0lt6mv4', NULL)
ERROR - 2026-04-28 10:28:30 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo2ai0lt6mv4', NULL)
ERROR - 2026-04-28 10:48:11 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo2ai0lt6mv4', NULL)
ERROR - 2026-04-28 11:28:31 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo2ai0lt6mv4', NULL)
ERROR - 2026-04-28 12:28:32 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo2ai0lt6mv4', NULL)
ERROR - 2026-04-28 13:28:33 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo2ai0lt6mv4', NULL)
ERROR - 2026-04-28 13:57:58 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo2ai0lt6mv4', NULL)
ERROR - 2026-04-28 14:28:34 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo2ai0lt6mv4', NULL)
ERROR - 2026-04-28 15:28:35 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo2ai0lt6mv4', NULL)
ERROR - 2026-04-28 16:28:36 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo2ai0lt6mv4', NULL)
ERROR - 2026-04-28 17:28:36 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo2ai0lt6mv4', NULL)
ERROR - 2026-04-28 17:54:40 --> Query error: Illegal mix of collations (utf8mb4_general_ci,IMPLICIT) and (utf8mb3_general_ci,COERCIBLE) for operation 'like' - Invalid query: SELECT *, a.id_employee,
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
				WHERE (lower(a.email) like 'iluuwvb#niawgq.#v@q#bvc#.jk#pit#' OR a.nik = 'fathony.adnan@ibsmulti.com') AND b.password like '87‚#01∞#Å#9#8#4#' and b.is_active <> 0
				ORDER BY a.id_employee DESC
ERROR - 2026-04-28 17:54:40 --> Severity: error --> Exception: Call to a member function result() on bool /var/www/html/api.hris.ibsw/application/models/Mhris_ibsw.php 327
