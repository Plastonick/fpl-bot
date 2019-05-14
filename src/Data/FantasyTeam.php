<?php

namespace Plastonick\FantasyAI\Data;

use function count;

class FantasyTeam
{
    private $players;

    private $positionCounts = [0, 2, 5, 5, 3];

    /**
     * @param PlayerPrediction[] $players
     */
    public function __construct(array $players)
    {
        $this->players = $players;
    }

    public function isValid()
    {
        $playersByPosition = $this->getPlayersByPosition();
        foreach ($playersByPosition as $position => $players) {
            if (count($players) !== $this->positionCounts[$position]) {
                return false;
            }
        }

        $playersByTeam = $this->getPlayersByTeam();
        foreach ($playersByTeam as $position => $players) {
            if (count($players) > 3) {
                return false;
            }
        }

        return true;
    }

    public function printInfo()
    {
        if (!$this->isValid()) {
            echo "Invalid team!\n";
        }

        $expScore = 0;
        $cost = 0;

        $playersByPosition = $this->getPlayersByPosition();

        foreach ($playersByPosition as $posId => $position) {
            echo "Position: {$posId}\n";

            /** @var PlayerPrediction $player */
            foreach ($position as $player) {
                echo sprintf("%s with expected score: %.02f\n", $player->getPlayerName(), $player->getValue());
                $expScore += $player->getValue();
                $cost += $player->getWeight() / 10;
            }
            echo "\n";
        }
        echo sprintf("Total exp. score: %.02f\n", $expScore);
        echo "Total cost: {$cost}\n";
    }

    /**
     * @return PlayerPrediction[]
     */
    private function getPlayersByPosition(): array
    {
        $playersByPosition = [];

        foreach ($this->players as $player) {
            $playersByPosition[$player->getPlayerPositionId()][] = $player;
        }

        return $playersByPosition;
    }

    /**
     * @return PlayerPrediction[]
     */
    private function getPlayersByTeam(): array
    {
        $playersByTeam = [];

        foreach ($this->players as $player) {
            $playersByTeam[$player->getPlayerTeamId()][] = $player;
        }

        return $playersByTeam;
    }
}
