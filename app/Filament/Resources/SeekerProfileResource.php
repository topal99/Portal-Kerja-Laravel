<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SeekerProfileResource\Pages;
use App\Models\SeekerProfile;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;

class SeekerProfileResource extends Resource
{
    protected static ?string $model = SeekerProfile::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->relationship('user', 'name', modifyQueryUsing: fn (Builder $query) => $query->where('role', 'seeker'))
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Akun User Pencari Kerja'),

                TextInput::make('full_name')
                    ->required()
                    ->maxLength(255)
                    ->label('Nama Lengkap'),
                
                FileUpload::make('photo')
                    ->image()
                    ->directory('photos')
                    ->imageEditor()
                    ->label('Foto Profil'),

                FileUpload::make('resume_path')
                    ->directory('resumes')
                    ->acceptedFileTypes(['application/pdf'])
                    ->label('CV (PDF)'),

                TextInput::make('phone_number')
                    ->tel()
                    ->label('Nomor Telepon'),

                TagsInput::make('skills')
                    ->label('Keahlian'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo')->label('Foto'),

                TextColumn::make('full_name')
                    ->searchable()
                    ->label('Nama Lengkap'),

                TextColumn::make('user.email')
                    ->searchable()
                    ->label('Email'),
                
                TextColumn::make('phone_number')
                    ->searchable()
                    ->label('Telepon'),

                TextColumn::make('skills')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListSeekerProfiles::route('/'),
            'create' => Pages\CreateSeekerProfile::route('/create'),
            'edit' => Pages\EditSeekerProfile::route('/{record}/edit'),
        ];
    }
}