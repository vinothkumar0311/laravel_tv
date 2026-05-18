<?php

namespace App\Filament\Resources\EpgProgramResource\Pages;

use App\Filament\Resources\EpgProgramResource;
use Filament\Resources\Pages\ListRecords;

class ListEpgPrograms extends ListRecords
{
    protected static string $resource = EpgProgramResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\CreateAction::make(),
        ];
    }
}
