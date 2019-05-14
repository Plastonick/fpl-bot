<?php

namespace Plastonick\FantasyAI\Data;

use Plastonick\FantasyAI\Calculation\PlayerPrediction as PlayerPredictionInterface;
use Plastonick\FPLClient\Entity\Fixture;
use Plastonick\FPLClient\Entity\Player;
use Plastonick\Knapsack\Item;

class PlayerPrediction implements PlayerPredictionInterface, Item
{
    private $player;

    private $fixture;

    private $expectedScore;

    public function __construct(Player $player, Fixture $fixture, float $expectedScore)
    {
        $this->player = $player;
        $this->fixture = $fixture;
        $this->expectedScore = $expectedScore;
    }

    public function getPlayer(): Player
    {
        return $this->player;
    }

    public function getPlayerName(): string
    {
        return sprintf('%s %s', $this->player->getFirstName(), $this->player->getSecondName());
    }

    public function getPlayerCost(): int
    {
        return $this->player->getNowCost();
    }

    public function getPlayerPositionId(): int
    {
        return $this->player->getPositionId();
    }

    public function getPlayerTeamId(): int
    {
        return $this->player->getTeamId();
    }

    public function getPredictedScore(int $gameWeekId): float
    {
        return $this->expectedScore;
    }

    public function getWeight()
    {
        return $this->getPlayerCost();
    }

    public function getValue()
    {
        return $this->getPredictedScore(0);
    }
}
