<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Season\SeasonServiceInterface;
use App\Contracts\Tournament\TournamentServiceInterface;
use App\DTOs\Season\OrderParameterDTO;
use App\DTOs\Season\SeasonParametersDTO;
use App\Enums\FromRoute;
use App\Http\Controllers\Controller;
use App\Http\Requests\Season\StoreRequest;
use App\Http\Requests\Season\UpdateRequest;
use App\Http\Resources\SeasonResource;
use App\Models\Season;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\RedirectResponse;

class SeasonController extends Controller
{
    public function __construct(
        private readonly SeasonServiceInterface     $seasonService,
        private readonly TournamentServiceInterface $tournamentService
    )
    {
        $this->middleware('check_role:admin')->except(['index', 'show', 'showJson']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $seasons = $this->seasonService->getListLastFirstWithCache(
            filter: SeasonParametersDTO::make(
                order_by: OrderParameterDTO::make(
                    column: 'started_at',
                    direction: 'desc'
                ),
                relations: ['tournament']
            )
        );

        return view('admin.season.index', compact('seasons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.season.create', [
            'tournaments' => $this->tournamentService->getWithCache()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $season = $this->seasonService->createAndClearCache($request->toDto());

        return to_route('admin.season.show', $season->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Season $season): View
    {
        $season = $season->load([
            'seasonTeams' => fn(HasMany $hasMany) => $hasMany
                ->with('team')
                ->orderByDesc('points')
                ->orderByDesc('victory')
                ->orderByDesc('draw')
                ->orderBy('defeat')
                ->orderByRaw('(goals_scored - goals_conceded) DESC'),
            'tournament',
            'games.home.team.logo',
            'games.away.team.logo'
        ]);

        return view(
            view: $season->tournament->type->isPoints()
                ? 'admin.season.points-show'
                : 'admin.season.elimination-show',
            data: compact('season')
        );
    }

    public function showJson(Season $season): SeasonResource
    {
        $season = $season->load(['tournament', 'seasonTeams.team']);

        return SeasonResource::make($season);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Season $season): View
    {
        return view('admin.season.edit', [
            'season' => $season,
            'tournaments' => $this->tournamentService->getWithCache()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Season $season): RedirectResponse
    {
        $this->seasonService->updateAndClearCache($season, $request->toDto());

        $route = FromRoute::tryFrom($request->query('from', FromRoute::SEASON_LIST->value))->getRouteName();

        $id = $request->query('id');

        return to_rroute($route->name, [$route->variable => $id]);
    }
}
