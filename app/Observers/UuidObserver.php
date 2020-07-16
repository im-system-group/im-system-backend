<?php

namespace App\Observers;

use App\UuidModel;
use Illuminate\Support\Str;

class UuidObserver
{
    public function creating(UuidModel $model)
    {
        $model->{$model->getKeyName()} = Str::orderedUuid();
    }
}
