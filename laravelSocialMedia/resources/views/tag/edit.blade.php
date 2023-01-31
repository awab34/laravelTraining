@extends('layouts.app')

@section('content')
@if (count($errors) > 0)
    <ul>
        @foreach ($errors->all() as $item)
        <li>
            {{$item}}
        </li>
        @endforeach
        
    </ul>
@endif
<form action="{{route('tag.update',['id'=>$tag->id])}}" method="POST"  enctype="multipart/form-data">
    @csrf
    @method('PUT')
<label class="form-label">Tag Name:</label><input type="text" name="tag" class="form-control" value="{{$tag->tag}}"/>
<button type="submit" class="btn btn-primary mb-3 mt-3">Submit</button>
</form>

@endsection