@extends('layouts.app')

@section('content')
<table class="table table-bordered">
    <thead>
      <tr>
        <th>No</th>
        <th>Name</th>
        <th>Email</th>
        <th>View</th>
      </tr>
    </thead>
    <tbody>
     @foreach($customers as $key => $customer)
     <tr>
       <td>{{ $key+1 }}</td>
       <td>{{ $customer->name }}</td>
       <td>{{ $customer->email }}</td>
       <td><a href="{{ route('customers.show', $customer->id) }}" style="color: #3588c3">View Customer</a></td>
     </tr>
     @endforeach
    </tbody>
  </table>

@endsection


