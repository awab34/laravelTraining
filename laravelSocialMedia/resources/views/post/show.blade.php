@extends('layouts.app')

@section('content')
<h1>{{$post->title}}</h1>
<p>{{$post->details}}</p>
<img src="{{URL::asset($post->photo)}}" alt="{{$post->photo}}" class="img-thumbnail" width="100" height="100"/>
@endsection