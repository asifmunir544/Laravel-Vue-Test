@extends('layouts.app')
@section('content')
    @can('comment',\App\Models\Question::class)
        <question-page :question="{{$question}}" ></question-page>
    @endcan
@endsection
