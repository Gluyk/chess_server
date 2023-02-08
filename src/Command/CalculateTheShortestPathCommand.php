<?php

namespace App\Command;

use App\Domain\Chess\ChessServiceInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Domain\Chess\Desk\Figure;
use Webmozart\Assert\Assert;


//TODO description, examples
/**
 * php bin/console app:calculate-the-shortest-path knight 2 3
 */
#[AsCommand(
    name: 'app:calculate-the-shortest-path',
    description: 'Add a short description for your command',
)]
class CalculateTheShortestPathCommand extends Command
{

    public function __construct(
        private readonly ChessServiceInterface $chessService,
        string $name = null,
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->addArgument('figure', InputArgument::REQUIRED, 'figure')
            ->addArgument('start_position', InputArgument::REQUIRED, 'start_position')
            ->addArgument('finis_position', InputArgument::REQUIRED, 'finis_position')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $figure = Figure::from($input->getArgument('figure'));
        $startPosition = $input->getArgument('start_position');
        $finisPosition = $input->getArgument('finis_position');

        Assert::length(
            $startPosition,
            2,
            'Start position should contain contain %2$s characters. Got: %s'
        );
        Assert::length(
            $finisPosition,
            2,
            'Finis position should contain contain %2$s characters. Got: %s'
        );


//        $this->chessService->calculateTheShortestPath($figure, );

//        $io->success('array to string with position');

        return Command::SUCCESS;
    }
}
