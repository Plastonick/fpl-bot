<?php

namespace Plastonick\FantasyAI\Calculation;

use Plastonick\FantasyAI\Data\FantasyTeam;

class Iterator
{
    private $team;

    private $changes;

    public function __construct(FantasyTeam $team, int $changes)
    {
        $this->team = $team;
        $this->changes = $changes;
    }

    public function iterate()
    {
        // get a few players

        // find better players for the same cost

        //
    }
}
