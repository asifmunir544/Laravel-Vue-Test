@extends('layouts.app')
@section('content')
    <!--update Answers For the questions-->
    <div class="container">
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h1>Editing answer for question: <strong>{{ $question->title}}</strong></h1>
                        </div>
                        <hr>
                        <form action="{{route('questions.answers.update', [$question->id, $answer->id])}}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <textarea class="form-control @error('body') is-invalid @enderror" name="body"  cols="30" rows="7">{{old('body', $answer->body)}}</textarea>
                                @error('body')
                                    <div class="invalid-feedback">
                                        <strong>{{$message}}</strong>
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mt-3">
                                <button type="submit" class="btn btn-lg btn-outline-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
