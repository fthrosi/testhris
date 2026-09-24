<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2026-02-24 07:52:17 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo0ai0lt2mv4', NULL)
ERROR - 2026-02-24 08:52:19 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo0ai0lt2mv4', NULL)
ERROR - 2026-02-24 09:52:20 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo0ai0lt2mv4', NULL)
ERROR - 2026-02-24 09:52:26 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo0ai0lt2mv4', NULL)
ERROR - 2026-02-24 09:58:06 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo0ai0lt2mv4', NULL)
ERROR - 2026-02-24 10:52:20 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo0ai0lt2mv4', NULL)
ERROR - 2026-02-24 11:52:21 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo0ai0lt2mv4', NULL)
ERROR - 2026-02-24 12:52:22 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo0ai0lt2mv4', NULL)
ERROR - 2026-02-24 13:52:23 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo0ai0lt2mv4', NULL)
ERROR - 2026-02-24 14:52:23 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo0ai0lt2mv4', NULL)
ERROR - 2026-02-24 15:52:25 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo0ai0lt2mv4', NULL)
ERROR - 2026-02-24 16:32:41 --> Query error: Illegal mix of collations (utf8mb4_general_ci,IMPLICIT) and (utf8mb3_general_ci,COERCIBLE) for operation 'like' - Invalid query: SELECT *, a.id_employee,
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
ERROR - 2026-02-24 16:32:41 --> Severity: error --> Exception: Call to a member function result() on bool /var/www/html/api.hris.ibsw/application/models/Mhris_ibsw.php 327
ERROR - 2026-02-24 16:32:50 --> Query error: Illegal mix of collations (utf8mb4_general_ci,IMPLICIT) and (utf8mb3_general_ci,COERCIBLE) for operation 'like' - Invalid query: SELECT *, a.id_employee,
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
ERROR - 2026-02-24 16:32:50 --> Severity: error --> Exception: Call to a member function result() on bool /var/www/html/api.hris.ibsw/application/models/Mhris_ibsw.php 327
ERROR - 2026-02-24 16:32:50 --> Query error: Illegal mix of collations (utf8mb4_general_ci,IMPLICIT) and (utf8mb3_general_ci,COERCIBLE) for operation 'like' - Invalid query: SELECT *, a.id_employee,
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
ERROR - 2026-02-24 16:32:50 --> Severity: error --> Exception: Call to a member function result() on bool /var/www/html/api.hris.ibsw/application/models/Mhris_ibsw.php 327
ERROR - 2026-02-24 16:32:50 --> Query error: Illegal mix of collations (utf8mb4_general_ci,IMPLICIT) and (utf8mb3_general_ci,COERCIBLE) for operation 'like' - Invalid query: SELECT *, a.id_employee,
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
ERROR - 2026-02-24 16:32:50 --> Severity: error --> Exception: Call to a member function result() on bool /var/www/html/api.hris.ibsw/application/models/Mhris_ibsw.php 327
ERROR - 2026-02-24 16:32:51 --> Query error: Illegal mix of collations (utf8mb4_general_ci,IMPLICIT) and (utf8mb3_general_ci,COERCIBLE) for operation 'like' - Invalid query: SELECT *, a.id_employee,
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
ERROR - 2026-02-24 16:32:51 --> Severity: error --> Exception: Call to a member function result() on bool /var/www/html/api.hris.ibsw/application/models/Mhris_ibsw.php 327
ERROR - 2026-02-24 16:32:51 --> Query error: Illegal mix of collations (utf8mb4_general_ci,IMPLICIT) and (utf8mb3_general_ci,COERCIBLE) for operation 'like' - Invalid query: SELECT *, a.id_employee,
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
ERROR - 2026-02-24 16:32:51 --> Severity: error --> Exception: Call to a member function result() on bool /var/www/html/api.hris.ibsw/application/models/Mhris_ibsw.php 327
ERROR - 2026-02-24 16:32:51 --> Query error: Illegal mix of collations (utf8mb4_general_ci,IMPLICIT) and (utf8mb3_general_ci,COERCIBLE) for operation 'like' - Invalid query: SELECT *, a.id_employee,
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
ERROR - 2026-02-24 16:32:51 --> Severity: error --> Exception: Call to a member function result() on bool /var/www/html/api.hris.ibsw/application/models/Mhris_ibsw.php 327
ERROR - 2026-02-24 16:32:51 --> Query error: Illegal mix of collations (utf8mb4_general_ci,IMPLICIT) and (utf8mb3_general_ci,COERCIBLE) for operation 'like' - Invalid query: SELECT *, a.id_employee,
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
ERROR - 2026-02-24 16:32:51 --> Severity: error --> Exception: Call to a member function result() on bool /var/www/html/api.hris.ibsw/application/models/Mhris_ibsw.php 327
ERROR - 2026-02-24 16:32:51 --> Query error: Illegal mix of collations (utf8mb4_general_ci,IMPLICIT) and (utf8mb3_general_ci,COERCIBLE) for operation 'like' - Invalid query: SELECT *, a.id_employee,
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
ERROR - 2026-02-24 16:32:51 --> Severity: error --> Exception: Call to a member function result() on bool /var/www/html/api.hris.ibsw/application/models/Mhris_ibsw.php 327
ERROR - 2026-02-24 16:32:51 --> Query error: Illegal mix of collations (utf8mb4_general_ci,IMPLICIT) and (utf8mb3_general_ci,COERCIBLE) for operation 'like' - Invalid query: SELECT *, a.id_employee,
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
ERROR - 2026-02-24 16:32:51 --> Severity: error --> Exception: Call to a member function result() on bool /var/www/html/api.hris.ibsw/application/models/Mhris_ibsw.php 327
ERROR - 2026-02-24 16:32:52 --> Query error: Illegal mix of collations (utf8mb4_general_ci,IMPLICIT) and (utf8mb3_general_ci,COERCIBLE) for operation 'like' - Invalid query: SELECT *, a.id_employee,
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
ERROR - 2026-02-24 16:32:52 --> Severity: error --> Exception: Call to a member function result() on bool /var/www/html/api.hris.ibsw/application/models/Mhris_ibsw.php 327
ERROR - 2026-02-24 16:32:52 --> Query error: Illegal mix of collations (utf8mb4_general_ci,IMPLICIT) and (utf8mb3_general_ci,COERCIBLE) for operation 'like' - Invalid query: SELECT *, a.id_employee,
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
ERROR - 2026-02-24 16:32:52 --> Severity: error --> Exception: Call to a member function result() on bool /var/www/html/api.hris.ibsw/application/models/Mhris_ibsw.php 327
ERROR - 2026-02-24 16:35:17 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo0ai0lt2mv4', NULL)
ERROR - 2026-02-24 16:37:02 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo0ai0lt2mv4', NULL)
ERROR - 2026-02-24 19:30:37 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo0ai0lt2mv4', NULL)
ERROR - 2026-02-24 19:31:13 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo0ai0lt2mv4', NULL)
ERROR - 2026-02-24 19:31:57 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo0ai0lt2mv4', NULL)
ERROR - 2026-02-24 19:32:55 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo0ai0lt2mv4', NULL)
ERROR - 2026-02-24 19:32:55 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo0ai0lt2mv4', NULL)
ERROR - 2026-02-24 19:32:55 --> Query error: Column 'nik' cannot be null - Invalid query: INSERT INTO `tokens_api_absen` (`token`, `nik`) VALUES ('jB8vo8Ii0ii0Xo0ai0lt2mv4', NULL)
