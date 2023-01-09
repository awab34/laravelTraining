@extends('layouts.app')

@section('content')
{{--  {!!  to allow html tags to show on the screen  !!}  --}}
@php
    $genderArray = ['Male','Female'];
@endphp

<div class="container">
    @if (count($errors) > 0)
        @foreach ($errors->all() as $item)
            <p>{{$item}}</p>
        @endforeach
    @endif
    <form action="{{route('profile.update')}}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ $user->name }}">
          </div>
        <div class="mb-3">
            <label for="Province" class="form-label">Province</label>
            <input type="text" name="province" class="form-control" id="Province" value="{{ $user->profile->province }}">
          </div>
        <div class="mb-3">
          <label for="Facebook" class="form-label">Facebook</label>
          <input type="text" name="facebook" class="form-control" id="Facebook" value="{{ $user->profile->facebook }}">
        </div>
        <div class="mb-3">
            <label for="gender" class="form-label">Gender</label>
            <select id="gender" name="gender" class="form-select">
                @foreach ($genderArray as $item)
                <option value="{{$item}}" {{($user->profile->gender == $item) ? 'selected' : ''}}>{{ $item }}</option>
                @endforeach
              
            </select>
        </div>
        <div class="mb-3">
            <label for="Password" class="form-label">Password</label>
            <input type="text" name="password" class="form-control" id="Password" >
          </div>
          <div class="mb-3">
            <label for="Confirm_Password" class="form-label">Confirm Password</label>
            <input type="text" name="confirm_password" class="form-control" id="Confirm_Password" >
          </div>
        <div class="mb-3">
            <label for="BIO" class="form-label">BIO</label>
            <textarea class="form-control" id="BIO" name="bio" rows="3">{{ $user->profile->bio }}</textarea>
          </div>
        <button type="submit" class="btn btn-primary">Update</button>
      </form>
</div>


@endsection