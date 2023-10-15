@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
                       <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h2>Users Management</h2>

                        </div>
                    </div>
                    <div class="card-body">
                        @include('layouts._messages')
                        @forelse ($users as $user)
                            @include('users.__table')
                        @empty
                            <div class="alert alert-warning">
                                <strong>Sorry</strong> there is no users found.
                            </div>
                        @endforelse

                        {{$users->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
