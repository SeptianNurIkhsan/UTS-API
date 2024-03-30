@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('User Profile') }}</div>

                    <div class="card-body">
                        <div>
                            <p><strong>Username:</strong> {{ Auth::user()->username }}</p>
                            <!-- Add more user profile information as needed -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
