<?php

namespace App\Repositories;

use App\Contracts\Season\SeasonRepositoryInterface;
use App\DTOs\Season\SeasonDTO;
use App\DTOs\Season\SeasonParametersDTO;
use App\Models\Season;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class SeasonRepository implements SeasonRepositoryInterface
{
    public function get(SeasonParametersDTO $parameters = new SeasonParametersDTO()): Collection
    {
        return Season::query()
            ->when(
                value: $parameters->order_by,
                callback: fn(Builder $builder) => $builder->orderBy($parameters->order_by->column, $parameters->order_by->direction)
            )
            ->get();
    }

    public function create(SeasonDTO $payload): Season
    {
        $season = new Season($payload->toArray());
        $season->save();

        return $season;
    }

    public function update(Season $season, SeasonDTO $payload): Season
    {
        $season->fill($payload->toArray());
        $season->save();

        return $season;
    }
}