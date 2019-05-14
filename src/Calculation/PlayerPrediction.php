<?php

namespace Plastonick\FantasyAI\Calculation;

interface PlayerPrediction
{
    public function getPlayerName(): string;

    public function getPlayerCost(): int;

    public function getPlayerPositionId(): int;

    public function getPlayerTeamId(): int;

    public function getPredictedScore(int $gameWeekId): float;
}
