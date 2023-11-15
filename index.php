<?php

class Player {
    private $level;

    public function __construct($initialLevel)
    {
        $this->level = $initialLevel;
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function setLevel($newLevel)
    {
        $this->level = $newLevel;
    }
}

class Encounter {
    const RESULT_WINNER = 1;
    const RESULT_LOSER = -1;
    const RESULT_DRAW = 0;
    const RESULT_POSSIBILITIES = [self::RESULT_WINNER, self::RESULT_LOSER, self::RESULT_DRAW];

    public static function probabilityAgainst(Player $playerOne, Player $playerTwo)
    {
        $levelPlayerOne = $playerOne->getLevel();
        $levelPlayerTwo = $playerTwo->getLevel();
        return 1 / (1 + (10 ** (($levelPlayerTwo - $levelPlayerOne) / 400)));
    }

    public static function setNewLevel(Player $playerOne, Player $playerTwo, int $playerOneResult)
    {
        if (!in_array($playerOneResult, self::RESULT_POSSIBILITIES)) {
            trigger_error(sprintf('Invalid result. Expected %s', implode(' or ', self::RESULT_POSSIBILITIES)));
        }

        $levelPlayerOne = $playerOne->getLevel();
        $levelPlayerTwo = $playerTwo->getLevel();

        $newLevelPlayerOne = $levelPlayerOne + (int)(32 * ($playerOneResult - self::probabilityAgainst($playerOne, $playerTwo)));
        $playerOne->setLevel($newLevelPlayerOne);
    }
}

$greg = new Player(400);
$jade = new Player(800);

echo sprintf(
    'Greg a %.2f%% de chance de gagner face à Jade',
    Encounter::probabilityAgainst($greg, $jade) * 100
);

// Imaginons que Greg l'emporte tout de même.
Encounter::setNewLevel($greg, $jade, Encounter::RESULT_WINNER);
Encounter::setNewLevel($jade, $greg, Encounter::RESULT_LOSER);

echo sprintf(
    'Les niveaux des joueurs ont évolué vers %s pour Greg et %s pour Jade',
    $greg->getLevel(),
    $jade->getLevel()
);
