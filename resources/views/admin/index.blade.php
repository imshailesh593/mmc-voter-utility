@extends('layouts.app')

@section('title', 'Admin — Import Voters')

@section('content')

<nav class="admin-nav">
    <span class="admin-nav-brand">⚡ Admin Panel</span>
    <a href="{{ route('home') }}">← Back to Portal</a>
</nav>

<div class="main-content">
    @livewire('admin-import')
</div>

@endsection
