<?php

namespace App\Filament\Resources\Shop\Course\CourseCategories\Pages;

use App\Filament\Resources\Shop\Course\CourseCategories\CourseCategoryResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCourseCategory extends ViewRecord
{
    protected static string $resource = CourseCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
