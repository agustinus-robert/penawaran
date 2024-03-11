@extends('layouts.app')

@section('konten')
<div class="container-fluid px-4">
    <h1 class="mt-4">{{__('global.dashboard')}}</h1>
    <div class="mb-4"></div>
        

    <div class="card shadow mb-12">
        <div class="card-body">          
             <p>{{__('global.welcome_dashboard')}}</p>
            </div>
        </div>
    </div>
</main>

@endsection