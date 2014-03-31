<?php
define('START_YEAR', 1900);
define('END_YEAR_OFFSET', 1); // e.g., 1 = current year + 1

function print_year_options($selectedYear = NULL) {
    $endYear = date('Y') + END_YEAR_OFFSET;

    for ($currentYear = $endYear; $currentYear >= START_YEAR; $currentYear --) {
        $selected = isset($selectedYear) && $selectedYear == $currentYear;

        printf('<option value="%d" %s>%d</option>',
            $currentYear, $selected ? ' selected="selected"' : '', $currentYear);
    }
}
