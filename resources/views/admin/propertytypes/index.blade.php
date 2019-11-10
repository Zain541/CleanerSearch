@extends('layouts.app')

@section('content')
<table class="table table-bordered">
    <thead>
      <tr>
        <th>No</th>
        <th>Name</th>
        <th>Edit</th>
      </tr>
    </thead>
    <tbody>
     @foreach($propertytypes as $key => $propertytypes)
     <tr>
       <td>{{ $key+1 }}</td>
       <td>{{ $propertytypes->name }}</td>
       <td><a href="{{ route('propertytypes.edit', $propertytypes->id) }}">
        <button class="btn btn-primary">Edit</button>
       </a></td>
     </tr>
     @endforeach
    </tbody>
  </table>

@endsection


