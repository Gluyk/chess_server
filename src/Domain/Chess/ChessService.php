<?php

namespace App\Domain\Chess;

use App\Domain\Chess\Desk\Figure;

class ChessService implements ChessServiceInterface
{
    public function calculateTheShortestPath(Figure $figure): void
    {
        match ($figure) {
            Figure::Knight => $this->shortestPathForKnight(),
        };
    }

    private function shortestPathForKnight(): void
    {
    }
}
