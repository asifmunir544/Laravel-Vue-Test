@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h2>Post a Feedback</h2>
                            <div>
                                <a href="{{route('questions.index')}}" class="btn btn-outline-secondary">Back to all Feedbacks</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{route('questions.store')}}" method="POST">
                            @include('questions._form', ['buttonText' => "Post This Feedback"])
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
