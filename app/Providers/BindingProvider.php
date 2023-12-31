<?php

namespace App\Providers;

use App\Contracts\Game\GameRepositoryInterface;
use App\Contracts\Game\GameServiceInterface;
use App\Contracts\GamePlayer\GamePlayerRepositoryInterface;
use App\Contracts\GamePlayer\GamePlayerServiceInterface;
use App\Contracts\MediaLibrary\MediaLibraryRepositoryInterface;
use App\Contracts\MediaLibrary\MediaLibraryServiceInterface;
use App\Contracts\Player\PlayerRepositoryInterface;
use App\Contracts\Player\PlayerServiceInterface;
use App\Contracts\Season\SeasonRepositoryInterface;
use App\Contracts\Season\SeasonServiceInterface;
use App\Contracts\SeasonTeam\SeasonTeamRepositoryInterface;
use App\Contracts\SeasonTeam\SeasonTeamServiceInterface;
use App\Contracts\Team\TeamRepositoryInterface;
use App\Contracts\Team\TeamServiceInterface;
use App\Contracts\Tournament\TournamentRepositoryInterface;
use App\Contracts\Tournament\TournamentServiceInterface;
use App\Contracts\User\UserRepositoryInterface;
use App\Contracts\User\UserServiceInterface;
use App\Repositories\GamePlayerRepository;
use App\Repositories\GameRepository;
use App\Repositories\MediaLibraryRepository;
use App\Repositories\PlayerRepository;
use App\Repositories\SeasonRepository;
use App\Repositories\SeasonTeamRepository;
use App\Repositories\TeamRepository;
use App\Repositories\TournamentRepository;
use App\Repositories\UserRepository;
use App\Services\GamePlayerService;
use App\Services\GameService;
use App\Services\MediaLibraryService;
use App\Services\PlayerService;
use App\Services\SeasonService;
use App\Services\SeasonTeamService;
use App\Services\TeamService;
use App\Services\TournamentService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class BindingProvider extends ServiceProvider
{
    protected array $services = [
        GamePlayerServiceInterface::class => GamePlayerService::class,
        GameServiceInterface::class => GameService::class,
        MediaLibraryServiceInterface::class => MediaLibraryService::class,
        PlayerServiceInterface::class => PlayerService::class,
        SeasonServiceInterface::class => SeasonService::class,
        SeasonTeamServiceInterface::class => SeasonTeamService::class,
        TeamServiceInterface::class => TeamService::class,
        TournamentServiceInterface::class => TournamentService::class,
        UserServiceInterface::class => UserService::class
    ];
    protected array $repositories = [
        GamePlayerRepositoryInterface::class => GamePlayerRepository::class,
        GameRepositoryInterface::class => GameRepository::class,
        MediaLibraryRepositoryInterface::class => MediaLibraryRepository::class,
        PlayerRepositoryInterface::class => PlayerRepository::class,
        SeasonRepositoryInterface::class => SeasonRepository::class,
        SeasonTeamRepositoryInterface::class => SeasonTeamRepository::class,
        TeamRepositoryInterface::class => TeamRepository::class,
        TournamentRepositoryInterface::class => TournamentRepository::class,
        UserRepositoryInterface::class => UserRepository::class
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        $bindings = $this->services + $this->repositories;
        foreach ($bindings as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
