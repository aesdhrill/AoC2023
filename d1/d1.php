<?php

$filestr = trim(file_get_contents($argv[1])) or die();

$valTable = [
    'one'   => 1,
    'two'   => 2,
    'three' => 3,
    'four'  => 4,
    'five'  => 5,
    'six'   => 6,
    'seven' => 7,
    'eight' => 8,
    'nine'  => 9,
    'zero'  => 0,
];

$total = 0;

function matchSlice(string $slice): int
{
    global $valTable;
    foreach ($valTable as $str => $val) {
        if (!strncmp($str, $slice, strlen($str))) {
            return $val;
        }
    }
    return -1;
}


foreach (explode("\n", $filestr) as $line) {
    $line = trim($line);

    $left   = -1;
    $right  = -1;

    foreach (str_split($line,1) as $idx => $char) {
        if (is_numeric($char)) {
            if ($left === -1) {
                $left = (int)$char;
            }
            $right = (int) $char;
        }
        else {
            $match = matchSlice(substr($line, $idx));
            if ($match !== -1) {
                if ($left === -1) {
                    $left = $match;
                }
                $right = $match;
            }
        }
    }
    $lineVal = $left * 10 + $right;
    $total += $lineVal;
}
echo "$total\n";
