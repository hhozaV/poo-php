<?php

declare(strict_types=1);

namespace App\MatchMaker\Player;

class QueuingPlayer extends Player implements InLobbyPlayerInterface
{
    public function __construct(PlayerInterface $player, protected int $range = 1)
    {
        parent::__construct($player->getName(), $player->getRatio());
    }

    public function getRange(): int
    {
        return $this->range;
    }

    public function upgradeRange(): void
    {
        $this->range = min($this->range + 1, 40);
    }
}