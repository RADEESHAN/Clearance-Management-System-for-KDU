<?php

namespace App\Repositories;

use App\Interfaces\ApplicationRepositoryInterface;
use App\Models\Application;

class ApplicationRepository extends BaseRepository implements ApplicationRepositoryInterface
{
    public function __construct(Application $application)
    {
        parent::__construct($application);
    }
}

