<?php

namespace App\Domain\Chess;

use App\Domain\Chess\Desk\Figure;

interface ChessServiceInterface
{
    public function calculateTheShortestPath(Figure $figure): void;
}