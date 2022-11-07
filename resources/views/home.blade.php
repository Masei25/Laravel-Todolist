@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="flex justify-end">
                <button data-bs-toggle="modal" data-bs-target="#addTaskModal"
                    class="p-2 text-xs font-semibold rounded bg-gray-100 border border-black hover:bg-gray-300 px-4 cursor-pointer">
                    Add New Task
                </button>
            </div>

            @foreach ($errors->all() as $error)
                <div class="text-red-400">{{ $error }}</div>
            @endforeach

            <livewire:tasks />

        </div>

    </div>
@endsection
