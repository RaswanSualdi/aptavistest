@extends('index')
@section('content')
<!-- resources/views/klasemen.blade.php -->
<div class="table-responsive">
<table class="table table-bordered mb-0">
    <thead>
    <tr>
        <th>No</th>
        <th>Klub</th>
        <th>Ma</th>
        <th>Me</th>
        <th>S</th>
        <th>K</th>
        <th>GM</th>
        <th>GK</th>
        <th>Point</th>
    </tr>
</thead>
<tbody>
    @foreach($klasemen as $index => $data)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $data['klub'] }}</td>
            <td>{{ $data['Ma'] }}</td>
            <td>{{ $data['Me'] }}</td>
            <td>{{ $data['S'] }}</td>
            <td>{{ $data['K'] }}</td>
            <td>{{ $data['GM'] }}</td>
            <td>{{ $data['GK'] }}</td>
            <td>{{ $data['Point'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>

@endsection