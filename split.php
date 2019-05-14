<?php

use Plastonick\FantasyAI\Data\FantasyTeam;
use Plastonick\FantasyAI\Data\PlayerPrediction;
use Plastonick\FPLClient\Transport\Client;

require_once 'vendor/autoload.php';

ini_set('memory_limit','2048M');
ini_set('xdebug.max_nesting_level', 1000);

$date = date('Y-m-d');
$date = 1;
$date = 'final';

$cacheFile = "/Users/david/fpl-players-{$date}";
$client = new Client();

if (!file_exists($cacheFile)) {
    $players = $client->getAllPlayers();
    file_put_contents($cacheFile, serialize($players));
} else {
    $players = unserialize(file_get_contents($cacheFile));
}


$estimator = new \Plastonick\FantasyAI\Calculation\ScoreEstimator($players);
$predictions = $estimator->getPredictions();

$reqs = [null, 2, 5, 5, 3];
$teams = array_fill(1, 20, 0);
$teamPlayers = [null, [], [], [], []];



$playersByPosition = [null, [], [], [], []];
foreach ($predictions as $playerPrediction) {
    $playersByPosition[$playerPrediction->getPlayerPositionId()][] = $playerPrediction;
}


$min = 30;
$max = 110;

foreach ($reqs as $positionId => $num) {
    if ($positionId === 0) {
        continue;
    }

    $minCost = $min * $num;
    $maxCost = $max * $num;

    $range = range($minCost, $maxCost, 1);
    foreach ($range as $limit) {
        $solver = new \Plastonick\Knapsack\Solver($playersByPosition[$positionId], $limit, $num);

        $solution = $solver->solve();
        $cost = $solution->getWeight();

        // store "best" positions by

        $a = 1;
    }

}


//usort(
//    $predictions,
//    function (PlayerPrediction $a, PlayerPrediction $b) {
//        return $a->getValue() / $a->getWeight() < $b->getValue() / $b->getWeight();
//    }
//);
//
//foreach ($predictions as $playerPrediction) {
//    if (count($teamPlayers[$playerPrediction->getPlayerPositionId()]) >= $reqs[$playerPrediction->getPlayerPositionId()]) {
//        continue;
//    }
//
//    if ($teams[$playerPrediction->getPlayerTeamId()] >= 3) {
//        continue;
//    }
//
//    $teams[$playerPrediction->getPlayerTeamId()]++;
//    $teamPlayers[$playerPrediction->getPlayerPositionId()][] = $playerPrediction;
//}
//
//$ret = [];
//foreach ($teamPlayers as $positionPlayers) {
//    foreach ($positionPlayers as $player) {
//        $ret[] = $player;
//    }
//}
//
//$team = new FantasyTeam($ret);
//
//$team->printInfo();
//
//$iterations = 10;
//$numSwaps = 2;
//
//while ($iterations-- > 0) {
//    $players = [];
//
//    foreach (array_rand($team, $numSwaps) as $index) {
//        $players[] = $team[$index];
//    }
//}

