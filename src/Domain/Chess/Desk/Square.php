<?php
// phpcs:ignoreFile
// TODO
// phpcs not supported readonly class from 8.2

namespace App\Domain\Chess\Desk;

readonly class Square
{
    public function __construct(
        private Ranks $ranks,
        private Files $files,
    ) {
    }

    public function getRanks(): Ranks
    {
        return $this->ranks;
    }

    public function getFiles(): Files
    {
        return $this->files;
    }
}
