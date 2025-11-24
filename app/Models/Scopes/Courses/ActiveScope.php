<?php

namespace App\Models\Scopes\Courses;

use App\Enums\Api\V1\CourseCommentStatus;
use App\Enums\Api\V1\CourseStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ActiveScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $builder->where('status', CourseStatus::ACTIVE);
    }
}
