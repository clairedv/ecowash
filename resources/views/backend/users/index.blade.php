@extends('layouts.backend')

@section('title', 'Users')

@section('content')

    {{-- Resource index header --}}
    @resourceIndexHeader([
    'title' => 'Users',
    'createRoute' => route('admin.user.invitation'),
    'addResourceText' => 'Add a new user'])


    @if ($users->isEmpty())
        <p>There are no users</p>
    @else
        <x-table.table>
            <x-table.head :headings="['Name', 'Email', 'Roles']">
                <x-slot name="after">
                    <x-table.cell type="heading"></x-table.cell>
                    <x-table.cell type="heading"></x-table.cell>
                </x-slot>
            </x-table.head>

            <x-table.body>
                @foreach($users as $user)
                    <x-table.row>
                        <x-table.cell>{{ $user->name }} </x-table.cell>
                        <x-table.cell>{{ $user->email }} </x-table.cell>
                        <x-table.cell>
                            Admin, Super admin
                        </x-table.cell>
                        <x-table.actions :model="$user"></x-table.actions>
                    </x-table.row>
                @endforeach
            </x-table.body>
        </x-table.table>
    @endif

@endSection