@extends('layouts.app')

@section('content')
<a href="{{route('tag.create')}}">
    Create new tag
</a>

@if ($tags->count() > 0)
<table>
    <tr>
        <th>
            Tag Name
        </th>
        <th>
            Actions
        </th>
    </tr>
    @foreach ($tags as $item)
        <tr>
            <td>
                {{$item->tag}}
            </td>
            
            <td>
                <a href="{{route('tag.show',['id'=>$item->id])}}">show</a>
                <a href="{{route('tag.delete',['id'=>$item->id])}}">delete</a>
                <a href="{{route('tag.edit',['id'=>$item->id])}}">edit</a>
            </td>
        </tr>    
    @endforeach
</table>
@else
    <p>no tags found</p>
@endif


@endsection