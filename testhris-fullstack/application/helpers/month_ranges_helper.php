<?php
defined('BASEPATH') OR exit('No direct script access allowed');


    function getMonthRanges($start, $end)
	{
		$timeStart = strtotime($start);
		$timeEnd   = strtotime($end);
		$timeEnd   = $timeEnd + 1;
		$out       = [];

		$milestones[] = $timeStart;
		// $timeEndMonth = strtotime('first day of next month midnight', $timeStart);
		$timeEndMonth = strtotime('+2 weeks', $timeStart);
		while ($timeEndMonth < $timeEnd) {
			$milestones[] = $timeEndMonth;
			// $timeEndMonth = strtotime('+1 month', $timeEndMonth);
			$timeEndMonth = strtotime('+2 weeks', $timeEndMonth);
		}
		$milestones[] = $timeEnd;

		$count = count($milestones);
		for ($i = 1; $i < $count; $i++) {
			$out[] = [
				'start' => date('Y-m-d', $milestones[$i - 1]),
				'end'   => date('Y-m-d', $milestones[$i] - 1)
			];
		}

		return $out;
	}