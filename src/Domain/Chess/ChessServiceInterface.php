<?php

namespace App\Domain\Chess;

use App\Domain\Chess\Desk\Figure;
use App\Domain\Chess\Desk\Square;

interface ChessServiceInterface
{
    /**
     * @param Figure $figure
     * @param Square $startSquare
     * @param Square $finisSquare
     * @return array
     */
    public function calculateTheShortestPath(Figure $figure, Square $startSquare, Square $finisSquare): array;
}
