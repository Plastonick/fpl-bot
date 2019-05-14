<?php

namespace Plastonick\FantasyAI\Calculation;

use Plastonick\FantasyAI\Data\PlayerPrediction;
use Plastonick\FPLClient\Entity\Fixture;
use Plastonick\FPLClient\Entity\Performance;
use Plastonick\FPLClient\Entity\Player;

class ScoreEstimator
{
    private $players;

    public function __construct(array $players)
    {
        $this->players = $players;
    }

    /**
     * @return PlayerPrediction[]
     */
    public function getPredictions()
    {
        $pointDifficultyFactors = [
            2 => 3.50 / 2.95,
            3 => 2.91 / 2.95,
            4 => 2.38 / 2.95,
            5 => 1.67 / 2.95,
        ];

        function getTotalPoints(Player $player)
        {
            $performances = $player->getPerformances();

            return array_reduce(
                $performances,
                function (int $cur, Performance $performance) {
                    return $cur + $performance->getTotalPoints();
                },
                0
            );
        }

        /** @var PlayerPrediction[] $sampleSpace */
        $sampleSpace = [];

        /** @var Player $player */
        foreach ($this->players as $index => $player) {
            $totalPoints = getTotalPoints($player);

            foreach ($player->getPerformances() as $performance) {
                $fixture = $performance->getFixture();

                if ($fixture->getEventId() !== 1) {
                    continue;
                }

                if ($player->getTeamId() === $fixture->getHomeTeamId()) {
                    $difficulty = $fixture->getHomeTeamDifficulty();
                } else {
                    $difficulty = $fixture->getAwayTeamDifficulty();
                }

                $expectedScore = $pointDifficultyFactors[$difficulty] * ($totalPoints / 34);
                $sampleSpace[] = new PlayerPrediction($player, $fixture, $expectedScore);

                break;
            }
        }

        return $sampleSpace;
    }
}
