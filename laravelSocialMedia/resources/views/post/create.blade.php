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
<form action="{{route('post.store')}}" method="POST"  enctype="multipart/form-data">
    @csrf
    <div class="form-group"> 
<label class="form-label">Title:</label><input type="text" name="title" class="form-control" />
    </div>

    @foreach ($tags as $item)
    <div class="form-check">
    <input type="checkbox" name="tags[]" class="form-check-input"  value="{{ $item->id }}" /> <label class="form-check-label">{{$item->tag}}</label>
</div>
    @endforeach



<div class="form-group">
<label class="form-label mt-3">Details:</label><textarea name="details"  cols="30" rows="10" class="form-control"></textarea>
</div>
<div class="form-group">
<label class="form-label mt-3">Post Photo:</label><input type="file" name="photo" class="form-control"/>
</div>
<button type="submit" class="btn btn-primary mb-3 mt-3">Submit</button>
</form>

@endsection