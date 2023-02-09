<?php

namespace App\Domain\Chess\Desk;

enum Ranks: string
{
    case A = 'a';
    case B = 'b';
    case C = 'c';
    case D = 'd';
    case E = 'e';
    case F = 'f';
    case G = 'g';
    case H = 'h';

    public function getAsNumber(): int
    {
        return ord($this->value) - 96;
    }

    public static function getFromNumber(int $position): Ranks
    {
        return match ($position) {
            1 => self::A,
            2 => self::B,
            3 => self::C,
            4 => self::D,
            5 => self::E,
            6 => self::F,
            7 => self::G,
            8 => self::H,
        };
    }
}