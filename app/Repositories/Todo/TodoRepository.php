<?php

namespace App\Repositories\Todo;

use App\Repositories\BaseRepository;
use App\Models\Todo;

class TodoRepository extends BaseRepository implements TodoRepositoryInterface
{
    public function getModel()
    {
        return Todo::class;
    }
}
