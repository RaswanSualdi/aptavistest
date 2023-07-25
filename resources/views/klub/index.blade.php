@extends('index')
@section('content')
    <!-- resources/views/klub/index.blade.php -->
<form method="POST" action="{{ route('klub.store') }}">
    @csrf
    <label for="nama_klub">Nama Klub:</label>
    <input type="text" id="nama_klub" name="nama_klub" required>
    
    <label for="kota_klub">Kota Klub:</label>
    <input type="text" id="kota_klub" name="kota_klub" required>
    
    <button type="submit">Save</button>
</form>

@if(session('success'))
    <p>{{ session('success') }}</p>
@endif

<h2>Data Klub:</h2>
<ul>
    @foreach($klubs as $klub)
        <li>{{ $klub->nama_klub }} - {{ $klub->kota_klub }}</li>
    @endforeach
</ul>

@endsection