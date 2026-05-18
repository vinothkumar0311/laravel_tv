<?php

namespace App\Filament\Resources\EpgProgramResource\Pages;

use App\Filament\Resources\EpgProgramResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEpgProgram extends EditRecord
{
    protected static string $resource = EpgProgramResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
