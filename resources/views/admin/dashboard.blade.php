@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
    <div style="padding:1.5rem">
        @livewire('admin.hero-image')
        @livewire('admin.stats')
    </div>
@endsection
