@extends('layouts.app')

@section('vue_script')
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}?v={{ Str::random(40) }}" defer></script>
@endsection

@section('content')
<div class="container" id="app">


</div>
@endsection