<?php

namespace FantasyAI\Calculation;

use FPL\Entity\Player;

class ScoreEstimator
{
    private $player;

    public function __construct(Player $player)
    {
        $this->player = $player;
    }

    public function estimateFixtures()
    {
    }
}
