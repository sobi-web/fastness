<?php

namespace App\Filament\Resources\Shop\Course\CourseCategories;

use App\Filament\Resources\Shop\Course\CourseCategories\Pages\CreateCourseCategory;
use App\Filament\Resources\Shop\Course\CourseCategories\Pages\EditCourseCategory;
use App\Filament\Resources\Shop\Course\CourseCategories\Pages\ListCourseCategories;
use App\Filament\Resources\Shop\Course\CourseCategories\Pages\ViewCourseCategory;
use App\Filament\Resources\Shop\Course\CourseCategories\Schemas\CourseCategoryForm;
use App\Filament\Resources\Shop\Course\CourseCategories\Schemas\CourseCategoryInfolist;
use App\Filament\Resources\Shop\Course\CourseCategories\Tables\CourseCategoriesTable;
use App\Models\Shop\Course\CourseCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CourseCategoryResource extends Resource
{
    protected static ?string $model = CourseCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Category';

    public static function form(Schema $schema): Schema
    {
        return CourseCategoryForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CourseCategoryInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CourseCategoriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCourseCategories::route('/'),
            'create' => CreateCourseCategory::route('/create'),
            'view' => ViewCourseCategory::route('/{record}'),
            'edit' => EditCourseCategory::route('/{record}/edit'),
        ];
    }
}
