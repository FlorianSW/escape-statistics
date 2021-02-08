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
                $this->requireQuery($request, 'event'),
                date('Y-m-d H:i:s'),
                $this->requireQuery($request, 'version'),
                $this->requireQuery($request, 'map'),
                $this->requireQuery($request, 'mod'),
                $request->query('players'),
                $request->query('end'),
                $request->query('t1'),
                $request->query('t2'),
                $request->query('t3'),
                $request->query('t4'),
                $request->query('time'),
                $this->requireQuery($request, 'release'),
                $this->requireQuery($request, 'server', '')
            );
        } catch (InvalidArgumentException $e) {
            return response($e->getMessage(), 400);
        }

        $this->repo->save($event);

        return new Response('', 200);
    }

    private function requireQuery(Request $request, $key, ?string $default = null): null|array|string
    {
        $value = $request->query($key, $default);
        if ($value === null) {
            throw new InvalidArgumentException('You are not ArmA, are you? :) (' . $key . ', ' . $request->query($key, $default) . ')');
        }
        return $value;
    }
}
