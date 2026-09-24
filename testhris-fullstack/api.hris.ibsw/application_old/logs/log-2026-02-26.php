<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2026-02-26 02:34:55 --> Query error: Illegal mix of collations (utf8mb4_general_ci,IMPLICIT) and (utf8mb3_general_ci,COERCIBLE) for operation 'like' - Invalid query: SELECT *, a.id_employee,
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
				WHERE (lower(a.email) like '€zpbwijkâiitpauukvawŽl@q.gc#uqq.' OR a.nik = 'â€Žmoch.ardiansyah@ibsmulti.com') AND b.password like '419##7#7' and b.is_active <> 0
				ORDER BY a.id_employee DESC
ERROR - 2026-02-26 02:34:55 --> Severity: error --> Exception: Call to a member function result() on bool /var/www/html/api.hris.ibsw/application/models/Mhris_ibsw.php 327
ERROR - 2026-02-26 02:34:55 --> Query error: Illegal mix of collations (utf8mb4_general_ci,IMPLICIT) and (utf8mb3_general_ci,COERCIBLE) for operation 'like' - Invalid query: SELECT *, a.id_employee,
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
				WHERE (lower(a.email) like '€zpbwijkâiitpauukvawŽl@q.gc#uqq.' OR a.nik = 'â€Žmoch.ardiansyah@ibsmulti.com') AND b.password like '419##7#7' and b.is_active <> 0
				ORDER BY a.id_employee DESC
ERROR - 2026-02-26 02:34:55 --> Severity: error --> Exception: Call to a member function result() on bool /var/www/html/api.hris.ibsw/application/models/Mhris_ibsw.php 327
ERROR - 2026-02-26 02:34:55 --> Query error: Illegal mix of collations (utf8mb4_general_ci,IMPLICIT) and (utf8mb3_general_ci,COERCIBLE) for operation 'like' - Invalid query: SELECT *, a.id_employee,
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
				WHERE (lower(a.email) like '€zpbwijkâiitpauukvawŽl@q.gc#uqq.' OR a.nik = 'â€Žmoch.ardiansyah@ibsmulti.com') AND b.password like '419##7#7' and b.is_active <> 0
				ORDER BY a.id_employee DESC
ERROR - 2026-02-26 02:34:55 --> Severity: error --> Exception: Call to a member function result() on bool /var/www/html/api.hris.ibsw/application/models/Mhris_ibsw.php 327
ERROR - 2026-02-26 02:34:55 --> Query error: Illegal mix of collations (utf8mb4_general_ci,IMPLICIT) and (utf8mb3_general_ci,COERCIBLE) for operation 'like' - Invalid query: SELECT *, a.id_employee,
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
				WHERE (lower(a.email) like '€zpbwijkâiitpauukvawŽl@q.gc#uqq.' OR a.nik = 'â€Žmoch.ardiansyah@ibsmulti.com') AND b.password like '419##7#7' and b.is_active <> 0
				ORDER BY a.id_employee DESC
ERROR - 2026-02-26 02:34:55 --> Severity: error --> Exception: Call to a member function result() on bool /var/www/html/api.hris.ibsw/application/models/Mhris_ibsw.php 327
ERROR - 2026-02-26 08:17:29 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo0ai0lt4mv4', NULL)
ERROR - 2026-02-26 09:17:31 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo0ai0lt4mv4', NULL)
ERROR - 2026-02-26 10:10:08 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo0ai0lt4mv4', NULL)
ERROR - 2026-02-26 10:17:32 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo0ai0lt4mv4', NULL)
ERROR - 2026-02-26 10:40:18 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo0ai0lt4mv4', NULL)
ERROR - 2026-02-26 11:17:33 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo0ai0lt4mv4', NULL)
ERROR - 2026-02-26 12:17:33 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo0ai0lt4mv4', NULL)
ERROR - 2026-02-26 12:47:10 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo0ai0lt4mv4', NULL)
ERROR - 2026-02-26 13:17:34 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo0ai0lt4mv4', NULL)
ERROR - 2026-02-26 14:17:35 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo0ai0lt4mv4', NULL)
ERROR - 2026-02-26 15:17:36 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo0ai0lt4mv4', NULL)
ERROR - 2026-02-26 16:17:37 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo0ai0lt4mv4', NULL)
ERROR - 2026-02-26 16:34:54 --> Query error: Illegal mix of collations (utf8mb4_general_ci,IMPLICIT) and (utf8mb3_general_ci,COERCIBLE) for operation 'like' - Invalid query: SELECT *, a.id_employee,
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
				WHERE (lower(a.email) like 'qpawilt#bijk.@q#vqb#wguueq.#xcc#' OR a.nik = 'tiopan.wahyudi@ibsmulti.com') AND b.password like '¾#Ã##q#w' and b.is_active <> 0
				ORDER BY a.id_employee DESC
ERROR - 2026-02-26 16:34:54 --> Severity: error --> Exception: Call to a member function result() on bool /var/www/html/api.hris.ibsw/application/models/Mhris_ibsw.php 327
ERROR - 2026-02-26 16:34:57 --> Query error: Illegal mix of collations (utf8mb4_general_ci,IMPLICIT) and (utf8mb3_general_ci,COERCIBLE) for operation 'like' - Invalid query: SELECT *, a.id_employee,
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
				WHERE (lower(a.email) like 'qpawilt#bijk.@q#vqb#wguueq.#xcc#' OR a.nik = 'tiopan.wahyudi@ibsmulti.com') AND b.password like '¾#Ã##q#w' and b.is_active <> 0
				ORDER BY a.id_employee DESC
ERROR - 2026-02-26 16:34:57 --> Severity: error --> Exception: Call to a member function result() on bool /var/www/html/api.hris.ibsw/application/models/Mhris_ibsw.php 327
ERROR - 2026-02-26 16:35:15 --> Query error: Illegal mix of collations (utf8mb4_general_ci,IMPLICIT) and (utf8mb3_general_ci,COERCIBLE) for operation 'like' - Invalid query: SELECT *, a.id_employee,
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
				WHERE (lower(a.email) like 'qpawilt#bijk.@q#vqb#wguueq.#xcc#' OR a.nik = 'tiopan.wahyudi@ibsmulti.com') AND b.password like '¾#Ã##q#w' and b.is_active <> 0
				ORDER BY a.id_employee DESC
ERROR - 2026-02-26 16:35:15 --> Severity: error --> Exception: Call to a member function result() on bool /var/www/html/api.hris.ibsw/application/models/Mhris_ibsw.php 327
ERROR - 2026-02-26 16:35:18 --> Query error: Illegal mix of collations (utf8mb4_general_ci,IMPLICIT) and (utf8mb3_general_ci,COERCIBLE) for operation 'like' - Invalid query: SELECT *, a.id_employee,
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
				WHERE (lower(a.email) like 'qpawilt#bijk.@q#vqb#wguueq.#xcc#' OR a.nik = 'tiopan.wahyudi@ibsmulti.com') AND b.password like '¾#Ã##q#w' and b.is_active <> 0
				ORDER BY a.id_employee DESC
ERROR - 2026-02-26 16:35:18 --> Severity: error --> Exception: Call to a member function result() on bool /var/www/html/api.hris.ibsw/application/models/Mhris_ibsw.php 327
ERROR - 2026-02-26 16:35:23 --> Query error: Illegal mix of collations (utf8mb4_general_ci,IMPLICIT) and (utf8mb3_general_ci,COERCIBLE) for operation 'like' - Invalid query: SELECT *, a.id_employee,
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
				WHERE (lower(a.email) like 'qpawilt#bijk.@q#vqb#wguueq.#xcc#' OR a.nik = 'tiopan.wahyudi@ibsmulti.com') AND b.password like '¾#Ã##q#w' and b.is_active <> 0
				ORDER BY a.id_employee DESC
ERROR - 2026-02-26 16:35:23 --> Severity: error --> Exception: Call to a member function result() on bool /var/www/html/api.hris.ibsw/application/models/Mhris_ibsw.php 327
ERROR - 2026-02-26 16:35:29 --> Query error: Illegal mix of collations (utf8mb4_general_ci,IMPLICIT) and (utf8mb3_general_ci,COERCIBLE) for operation 'like' - Invalid query: SELECT *, a.id_employee,
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
				WHERE (lower(a.email) like 'qpawilt#bijk.@q#vqb#wguueq.#xcc#' OR a.nik = 'tiopan.wahyudi@ibsmulti.com') AND b.password like '¾#Ã##q#w' and b.is_active <> 0
				ORDER BY a.id_employee DESC
ERROR - 2026-02-26 16:35:29 --> Severity: error --> Exception: Call to a member function result() on bool /var/www/html/api.hris.ibsw/application/models/Mhris_ibsw.php 327
ERROR - 2026-02-26 16:35:34 --> Query error: Illegal mix of collations (utf8mb4_general_ci,IMPLICIT) and (utf8mb3_general_ci,COERCIBLE) for operation 'like' - Invalid query: SELECT *, a.id_employee,
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
				WHERE (lower(a.email) like 'qpawilt#bijk.@q#vqb#wguueq.#xcc#' OR a.nik = 'tiopan.wahyudi@ibsmulti.com') AND b.password like '¾#Ã##q#w' and b.is_active <> 0
				ORDER BY a.id_employee DESC
ERROR - 2026-02-26 16:35:34 --> Severity: error --> Exception: Call to a member function result() on bool /var/www/html/api.hris.ibsw/application/models/Mhris_ibsw.php 327
ERROR - 2026-02-26 16:35:35 --> Query error: Illegal mix of collations (utf8mb4_general_ci,IMPLICIT) and (utf8mb3_general_ci,COERCIBLE) for operation 'like' - Invalid query: SELECT *, a.id_employee,
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
				WHERE (lower(a.email) like 'qpawilt#bijk.@q#vqb#wguueq.#xcc#' OR a.nik = 'tiopan.wahyudi@ibsmulti.com') AND b.password like '¾#Ã##q#w' and b.is_active <> 0
				ORDER BY a.id_employee DESC
ERROR - 2026-02-26 16:35:35 --> Severity: error --> Exception: Call to a member function result() on bool /var/www/html/api.hris.ibsw/application/models/Mhris_ibsw.php 327
