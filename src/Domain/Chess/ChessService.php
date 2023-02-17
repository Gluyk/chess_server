<?php

namespace App\Domain\Chess;

use App\Domain\Chess\Desk\Figure;
use App\Domain\Chess\Desk\Square;
use App\Domain\Chess\Desk\Files;
use App\Domain\Chess\Desk\Ranks;

final class ChessService implements ChessServiceInterface
{
    private Square $startSquare;
    private Square $finisSquare;

    /**
     * @inheritDoc
     */
    public function calculateTheShortestPath(Figure $figure, Square $startSquare, Square $finisSquare): array
    {
        $this->startSquare = $startSquare;
        $this->finisSquare = $finisSquare;

        return match ($figure) {
            Figure::Knight => $this->shortestPathForKnight(),
        };
    }

    private function shortestPathForKnight(): array
    {
        $board = [];
        //TODO first and last position from enum
        for ($ranksAtBoard = Ranks::A->getAsNumber(); $ranksAtBoard <= Ranks::H->getAsNumber(); $ranksAtBoard++) {
            for ($filesAtBoard = Files::One->value; $filesAtBoard <= Files::Eight->value; $filesAtBoard++) {
                $board[$ranksAtBoard][$filesAtBoard] = [-1, -1, false];
            }
        }

        $startRank = $this->startSquare->getRanks()->getAsNumber();
        $startFile = $this->startSquare->getFiles()->value;
        $finisRank = $this->finisSquare->getRanks()->getAsNumber();
        $finisFile  = $this->finisSquare->getFiles()->value;
        $queue = [];
        $queue[] = [$startRank, $startFile];
        $board[$startRank][$startFile] = [-1, -1, true];

        while (count($queue) > 0) {
            $current = array_shift($queue);
            if ($current[0] == $finisRank && $current[1] == $finisFile) {
                break;
            }
            $moves = [
                [2, 1],
                [2, -1],
                [-2, 1],
                [-2, -1],
                [1, 2],
                [1, -2],
                [-1, 2],
                [-1, -2]
            ];
            foreach ($moves as $move) {
                $x = $current[0] + $move[0];
                $y = $current[1] + $move[1];
                //TODO first and last position from enum
                if ($x >= 1 && $x <= 8 && $y >= 1 && $y <= 8 && !$board[$x][$y][2]) {
                    $board[$x][$y] = [$current[0], $current[1], true];
                    $queue[] = [$x, $y];
                }
            }
        }

        $x = $finisRank;
        $y = $finisFile;
        $roadMap[] = [Ranks::getFromNumber($x), Files::from($y)];
        while ($x != $startRank || $y != $startFile) {
            $prev = $board[$x][$y];
            $x = $prev[0];
            $y = $prev[1];
            array_unshift($roadMap, [Ranks::getFromNumber($x), Files::from($y)]);
        }

        //TODO return Square[]
        return $roadMap;
    }
}
