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
<form action="{{route('post.update',['id'=>$post->id])}}" method="POST"  enctype="multipart/form-data">
    @csrf
    @method('PUT')
<label class="form-label">Title:</label><input type="text" name="title" class="form-control" value="{{$post->title}}"/>
@foreach ($tags as $item)
    <div class="form-check">
    <input type="checkbox" name="tags[]" class="form-check-input"  value="{{ $item->id }}" @foreach ($post->tags as $tag)
        @if ($item->id == $tag->id)
        {{ 'checked' }}
        @endif
    @endforeach /> <label class="form-check-label">{{$item->tag}}</label>
</div>
    @endforeach
<label class="form-label mt-3">Details:</label><textarea name="details"  cols="30" rows="10" class="form-control">{{$post->details}}</textarea>
<label class="form-label mt-3">Post Photo:</label><input type="file" name="photo" class="form-control"/>
<button type="submit" class="btn btn-primary mb-3 mt-3">Submit</button>
</form>

@endsection