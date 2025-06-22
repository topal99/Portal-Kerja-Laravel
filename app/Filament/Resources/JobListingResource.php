<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JobListingResource\Pages;
use App\Filament\Resources\JobListingResource\RelationManagers;
use App\Models\JobListing;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;

class JobListingResource extends Resource
{
    protected static ?string $model = JobListing::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            Forms\Components\Select::make('company_profile_id')
                ->relationship('companyProfile', 'company_name') // 'companyProfile' adalah nama relasi di model, 'company_name' adalah kolom yang ingin ditampilkan
                ->searchable()
                ->preload()
                ->required()
                ->label('Perusahaan'),

            Forms\Components\TextInput::make('title')
                ->required()
                ->maxLength(255)
                ->label('Judul Lowongan'),

            // Gunakan RichEditor untuk deskripsi agar bisa formatting
            Forms\Components\RichEditor::make('description')
                ->required()
                ->columnSpanFull() // Agar lebarnya penuh
                ->label('Deskripsi Pekerjaan'),

            Forms\Components\TextInput::make('location')
                ->required()
                ->maxLength(255)
                ->label('Lokasi'),
            
            // Gunakan Select untuk field enum
            Forms\Components\Select::make('job_type')
                ->options([
                    'Full-time' => 'Full-time',
                    'Part-time' => 'Part-time',
                    'Contract' => 'Kontrak',
                    'Internship' => 'Magang',
                ])
                ->required()
                ->label('Tipe Pekerjaan'),

            Forms\Components\TextInput::make('salary_range')
                ->maxLength(255)
                ->label('Rentang Gaji (opsional)'),

            Forms\Components\Select::make('status')
                ->options([
                    'open' => 'Dibuka',
                    'closed' => 'Ditutup',
                ])
                ->required()
                ->default('open'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                ->searchable() // Aktifkan pencarian untuk kolom ini
                ->sortable()   // Aktifkan pengurutan
                ->label('Judul'),
            
                // Tampilkan nama perusahaan melalui relasi
                Tables\Columns\TextColumn::make('companyProfile.company_name')
                    ->searchable()
                    ->sortable()
                    ->label('Perusahaan'),

                Tables\Columns\TextColumn::make('location')
                    ->searchable()
                    ->label('Lokasi'),

                // Gunakan Badge untuk status agar lebih menarik secara visual
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'success' => 'open',
                        'danger' => 'closed',
                    ]),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true), // Sembunyikan default, tapi bisa ditampilkan
            ])
            
            ->filters([
                // Nanti bisa ditambahkan filter di sini
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListJobListings::route('/'),
            'create' => Pages\CreateJobListing::route('/create'),
            'edit' => Pages\EditJobListing::route('/{record}/edit'),
        ];
    }
}
