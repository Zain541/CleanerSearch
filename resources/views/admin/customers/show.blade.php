@extends('layouts.app')

@section('content')
<div class="row">
  <div class="container">
    <h5>Name</h5>
    <p>{{ $customer->name }}</p>
    </div>
</div>

<div class="row">
  <div class="container">
    <h5>Email</h5>
    <p>{{ $customer->email }}</p>
    </div>
</div>


<div class="row">
  <div class="container">
    <h5>Phone Number</h5>
    <p>{{ $customer->phone_number }}</p>
    </div>
</div>

<div class="row">
  <div class="container">
    <h5>Postal Code</h5>
    <p>{{ $customer->postal_code }}</p>
    </div>
</div>

<div class="row">
  <div class="container">
    <h5>Address</h5>
    <p>{{ $customer->address }}</p>
    </div>
</div>

<div class="row">
  <div class="container">
    <h5>Preferred Method to Contact</h5>
    <p>{{ $customer->preferred_method_to_contact }}</p>
    </div>
</div>

<div class="row">
  <div class="container">
    <a href="{{ route('customers.index') }}" class="btn btn-primary">View all Customers</a>
    </div>
</div>

@endsection


