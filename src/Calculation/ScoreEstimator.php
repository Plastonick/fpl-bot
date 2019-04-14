<?php

namespace Plastonick\FantasyAI\Calculation;

use Plastonick\FPLClient\Entity\Player;

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
