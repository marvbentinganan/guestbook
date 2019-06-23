@extends('layouts.app')

@section('content')
<div class="text-center p-10">
    <h1>Add New Guest</h1>
</div>
<form method="POST" action="{{ route('guest.store', 'backend') }}">
    @csrf
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="first_name">Firstname</label>
            <input type="text" name="first_name" class="@error('first_name') is-invalid @enderror form-control" id="first_name" value="{{ old('first_name') }}" placeholder="Firstname">
            @error('first_name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group col-md-6">
            <label for="last_name">Lastname</label>
            <input type="text" name="last_name" class="@error('last_name') is-invalid @enderror form-control" id="last_name" value="{{ old('last_name') }}" placeholder="Lastname">
            @error('last_name')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="email">Email</label>
            <input type="email" name="email" class="@error('email') is-invalid @enderror form-control" id="email" value="{{ old('email') }}" placeholder="Email">
            @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group col-md-4">
            <label for="phone_number">Phone Number</label>
            <input type="tel" name="phone_number" class="@error('phone_number') is-invalid @enderror form-control" id="phone_number" value="{{ old('phone_number') }}" placeholder="Phone Number">
            @error('phone_number')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group col-md-4">
            <label for="gender">Gender</label>
            <select id="gender" name="gender" class="@error('gender') is-invalid @enderror form-control">
                <option selected value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
            @error('gender')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="address">Address</label>
            <textarea class="@error('address') is-invalid @enderror form-control" name="address" id="address" rows="5">{{ old('address') }}</textarea>
            @error('address')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Add Guest</button>
</form>
@endsection