<?php

namespace App\Controller;

use App\Domain\Chess\ChessServiceInterface;
use App\Domain\Chess\Desk\Figure;
use App\Domain\Chess\Desk\Files;
use App\Domain\Chess\Desk\Ranks;
use App\Domain\Chess\Desk\Square;
use App\Infrastructure\Mapper\RequestMapperInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

class ChessController extends AbstractController
{
    public function __construct(
        private readonly RequestMapperInterface $requestMapper,
        private readonly ChessServiceInterface $chessService,
    ) {
    }

    //TODO Description
    #[OA\Post(
        operationId: 'search',
        requestBody: new OA\RequestBody(
            content: [
                new OA\MediaType(
                    mediaType: 'application/json',
                    schema: new OA\Schema(
                        ref: new Model(type: ShortestPathRequest::class)
                    )
                ),
            ]
        ),
        tags: ['Chess'],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: 'Description.',
                content: new Model(type: ShortestPathResponse::class),
            ),
        ]
    )]
    #[Route('calculate-the-shortest-path', name: 'calculate_the_shortest_path', methods: ['POST'])]
    public function calculateTheShortestPath(): JsonResponse
    {
        $shortestPathRequest = $this->requestMapper->mapAndValidate(ShortestPathRequest::class);

        $figure = Figure::from($shortestPathRequest->figure);
        $startSquare = new Square(
            Ranks::from(substr($shortestPathRequest->startPosition, 0, 1)),
            Files::from(substr($shortestPathRequest->startPosition, -1))
        );
        $finisSquare = new Square(
            Ranks::from(substr($shortestPathRequest->finisPosition, 0, 1)),
            Files::from(substr($shortestPathRequest->finisPosition, -1))
        );
        $results = $this->chessService->calculateTheShortestPath($figure, $startSquare, $finisSquare);

        $response = new ShortestPathResponse();
        foreach ($results as $result) {
            $step = new Step();
            $step->step = $result[0]->value . $result[1]->value;
            $response->steps[] = $step;
        }

        return $this->json($response);
    }
}
