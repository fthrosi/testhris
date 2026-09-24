<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2026-01-01 22:35:16 --> Query error: Illegal mix of collations (utf8mb4_general_ci,IMPLICIT) and (utf8mb3_general_ci,COERCIBLE) for operation 'like' - Invalid query: SELECT *, a.id_employee,
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
				WHERE (lower(a.email) like 'vauu.zb#iiawcq.#u@q#lac#ljk#qqt#' OR a.nik = 'andi.mudassir@ibsmulti.com') AND b.password like 'Ãic#Jjc#s#¹9u#t1' and b.is_active <> 0
				ORDER BY a.id_employee DESC
ERROR - 2026-01-01 22:35:16 --> Severity: error --> Exception: Call to a member function result() on bool /var/www/html/api.hris.ibsw/application/models/Mhris_ibsw.php 327
ERROR - 2026-01-01 22:35:19 --> Query error: Illegal mix of collations (utf8mb4_general_ci,IMPLICIT) and (utf8mb3_general_ci,COERCIBLE) for operation 'like' - Invalid query: SELECT *, a.id_employee,
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
				WHERE (lower(a.email) like 'vauu.zb#iiawcq.#u@q#lac#ljk#qqt#' OR a.nik = 'andi.mudassir@ibsmulti.com') AND b.password like 'Ãic#Jjc#s#¹9u#t1' and b.is_active <> 0
				ORDER BY a.id_employee DESC
ERROR - 2026-01-01 22:35:19 --> Severity: error --> Exception: Call to a member function result() on bool /var/www/html/api.hris.ibsw/application/models/Mhris_ibsw.php 327
ERROR - 2026-01-01 22:35:21 --> Query error: Illegal mix of collations (utf8mb4_general_ci,IMPLICIT) and (utf8mb3_general_ci,COERCIBLE) for operation 'like' - Invalid query: SELECT *, a.id_employee,
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
				WHERE (lower(a.email) like 'vauu.zb#iiawcq.#u@q#lac#ljk#qqt#' OR a.nik = 'andi.mudassir@ibsmulti.com') AND b.password like 'Ãic#Jjc#s#¹9u#t1' and b.is_active <> 0
				ORDER BY a.id_employee DESC
ERROR - 2026-01-01 22:35:21 --> Severity: error --> Exception: Call to a member function result() on bool /var/www/html/api.hris.ibsw/application/models/Mhris_ibsw.php 327
