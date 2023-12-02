<?php
declare(strict_types=1);

$filestr = file_get_contents($argv[1]);

$avail = [
    'red'   => 12,
    'green' => 13,
    'blue'  => 14,
];

$total = 0;
$totalPower = 0;

foreach (explode("\n", $filestr) as $game) {
    $minRed = $minGreen = $minBlue = 0;

    list($gameId, $game) = explode(':', $game);
    $gameId = (int)str_replace('Game ', '', $gameId);

    //split game into sets
    $gamesets = explode(';', $game);

    $ok = true;

    //split sets into colors+amt
    foreach ($gamesets as $set) {

        $numColors = explode(',',$set);
        //split colors+amt into two parts
        foreach ($numColors as $nc) {
            $nc = trim($nc);
            list($num, $color) = explode(' ', $nc);
            $num = (int)$num;
            if ($color === 'red') {
                $minRed = max($minRed, $num);
            } elseif ($color === 'blue') {
                $minBlue = max($minBlue, $num);
            } else {
                $minGreen = max($minGreen, $num);
            }

            if ($avail[$color] < $num) {
                $ok = false;
            }
        }
        $setPower = 1;
        $setPower *= $minRed * $minBlue * $minGreen;
    }
    $totalPower += $setPower;

    if ($ok) {
        $total += $gameId;
    }
}

echo "Sum of valid game ids: $total\n";
echo "Sum of power of sets: $totalPower\n";

//echo "$filestr\n";