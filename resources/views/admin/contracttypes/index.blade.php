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
     @foreach($contracttypes as $key => $contracttype)
     <tr>
       <td>{{ $key+1 }}</td>
       <td>{{ $contracttype->name }}</td>
       <td><a href="{{ route('contracttypes.edit', $contracttype->id) }}">
        <button class="btn btn-primary">Edit</button>
       </a></td>
     </tr>
     @endforeach
    </tbody>
  </table>

@endsection


