@extends('layouts.app')

@section('content')
<a href="{{route('post.create')}}">
    Create new post
</a>
@if ($posts->count() > 0)
<table>
    <tr>
        <th>
            Title
        </th>
        <th>
            user
        </th>
        <th>
            Photo
        </th>
        <th>
            Actions
        </th>
    </tr>
    @foreach ($posts as $item)
        <tr>
            <td>
                {{$item->title}}
            </td>
            <td>
                {{$item->user->name}}
            </td>
            <td>
                <img src="{{URL::asset($item->photo)}}" alt="{{$item->photo}}" class="img-thumbnail" width="100" height="100"/>
            </td>
            <td>
                <a href="{{route('post.show',['slug'=>$item->slug])}}">show</a>
                @if ($item->user_id === Auth::id())
                <a href="{{route('post.soft.delete',['id'=>$item->id])}}">delete</a>
                <a href="{{route('post.edit',['id'=>$item->id])}}">edit</a>
                @endif
                
            </td>
        </tr>    
    @endforeach
</table>
@else
    <p>no posts found</p>
@endif


@endsection