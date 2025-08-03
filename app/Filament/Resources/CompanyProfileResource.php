<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyProfileResource\Pages;
use App\Models\CompanyProfile;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;

class CompanyProfileResource extends Resource
{
    protected static ?string $model = CompanyProfile::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->relationship('user', 'name', modifyQueryUsing: fn (Builder $query) => $query->where('role', 'company'))
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Akun User Perusahaan'),

                TextInput::make('company_name')
                    ->required()
                    ->maxLength(255)
                    ->label('Nama Perusahaan'),

                FileUpload::make('logo')
                    ->image()
                    ->directory('logos')
                    ->imageEditor(),

                TextInput::make('website')
                    ->maxLength(255)
                    ->url()
                    ->label('Situs Web'),

                Textarea::make('address')
                    ->label('Alamat'),

                RichEditor::make('description')
                    ->columnSpanFull()
                    ->label('Deskripsi Perusahaan'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')
                    ->disk('public'), 

                TextColumn::make('company_name')
                    ->searchable()
                    ->label('Nama Perusahaan'),
                
                TextColumn::make('user.name')
                    ->searchable()
                    ->label('User Terhubung'),

                TextColumn::make('website')
                    ->searchable(),
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
            'index' => Pages\ListCompanyProfiles::route('/'),
            'create' => Pages\CreateCompanyProfile::route('/create'),
            'edit' => Pages\EditCompanyProfile::route('/{record}/edit'),
        ];
    }
}