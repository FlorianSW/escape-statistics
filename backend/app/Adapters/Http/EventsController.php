<?php

namespace App\Adapters\Http;

use App\Domain\Event;
use App\Domain\EventsRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use InvalidArgumentException;
use Laravel\Lumen\Routing\Controller;

class EventsController extends Controller {
    private EventsRepository $repo;

    public function __construct(EventsRepository $repository)
    {
        $this->repo = $repository;
    }

    public function listMatches(): JsonResponse
    {
        return response()->json($this->repo->findSessions());
    }

    public function trackEvent(Request $request): Response {
        try {
            $event = new Event(
                $request->query('event'),
                date('Y-m-d H:i:s'),
                $request->query('version'),
                $request->query('map'),
                $request->query('mod'),
                $request->query('players'),
                $request->query('end'),
                $request->query('t1',),
                $request->query('t2'),
                $request->query('t3'),
                $request->query('t4'),
                $request->query('time'),
                $request->query('release'),
                $request->query('server', '')
            );
        } catch (InvalidArgumentException $e) {
            return response($e->getMessage(), 400);
        }

        $this->repo->save($event);

        return new Response('', 200);
    }
}
