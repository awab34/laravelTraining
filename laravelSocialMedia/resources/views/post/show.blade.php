@extends('layouts.app')

@section('content')
<h1>{{$post->title}}</h1>
<br>
<p>{{$post->details}}</p>
<br>

@foreach ($post->tags as $tag)
        <p>{{$tag->tag}}</p>
        <br>
    @endforeach
    
<img src="{{URL::asset($post->photo)}}" alt="{{$post->photo}}" class="img-thumbnail" width="100" height="100"/>
@endsection