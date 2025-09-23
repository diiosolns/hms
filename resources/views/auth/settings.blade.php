@extends('layouts.app')

@section('content')
    <div class="nk-content">
        <div class="container">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    {{-- Check if the user object exists --}}
                    @if ($user)
                        <div class="nk-block-head">
                            <div class="nk-block-head-between flex-wrap gap g-2 align-items-start">
                                <div class="nk-block-head-content">
                                    <div class="d-flex flex-column flex-md-row align-items-md-center">
                                        <div class="media media-huge media-circle">
                                            {{-- Use a dynamic avatar, or a fallback if none exists --}}
                                            <img src="{{ asset('images/users/def.jpg') }}" class="img-thumbnail" alt="{{ $user->first_name }}">
                                        </div>
                                        <div class="mt-3 mt-md-0 ms-md-3">
                                            {{-- Display the user's full name by combining first and last name --}}
                                            <h3 class="title mb-1">{{ $user->first_name }} {{ $user->last_name }}</h3>
                                            {{-- Display the user's role --}}
                                            <span class="small">{{ ucwords($user->role) }}</span>
                                            <ul class="nk-list-option pt-1">
                                                {{-- Display the user's branch information, if it exists --}}
                                                @if ($user->branch)
                                                    <li><em class="icon ni ni-building"></em><span class="small">{{ $user->branch->name }}</span></li>
                                                @endif
                                                {{-- Display the user's hospital information, if it exists --}}
                                                @if ($user->hospital)
                                                    <li><em class="icon ni ni-building"></em><span class="small">{{ $user->hospital->name }}</span></li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div><!-- .nk-block-head-content -->
                            </div><!-- .nk-block-head-between -->
                        </div><!-- .nk-block-head -->


                        


                        
                        <div class="nk-block">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane show active" id="tab-1" tabindex="0" role="tabpanel">
                                    <div class="card card-gutter-md">
                                        <div class="card-row card-row-lg col-sep col-sep-lg">
                                            <div class="card-aside">
                                                <div class="card-body">
                                                    <div class="bio-block">
                                                        <h4 class="bio-block-title">Details</h4>
                                                        <ul class="list-group list-group-borderless small">
                                                            <li class="list-group-item">
                                                                <span class="title fw-medium w-40 d-inline-block">Account ID:</span>
                                                                {{-- Display the user's ID --}}
                                                                <span class="text">{{ $user->id }}</span>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <span class="title fw-medium w-40 d-inline-block">Room ID:</span>
                                                                {{-- Display the Room ID --}}
                                                                <span class="text"><b>{{ $user->room }}</b></span>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <span class="title fw-medium w-40 d-inline-block">Email:</span>
                                                                {{-- Display the user's email --}}
                                                                <span class="text">{{ $user->email }}</span>
                                                            </li>
                                                            {{-- Add the phone number --}}
                                                            <li class="list-group-item">
                                                                <span class="title fw-medium w-40 d-inline-block">Phone:</span>
                                                                <span class="text">{{ $user->phone ?? 'Not provided' }}</span>
                                                            </li>
                                                            {{-- Add the registration date --}}
                                                            <li class="list-group-item">
                                                                <span class="title fw-medium w-40 d-inline-block">Joining Date:</span>
                                                                <span class="text">{{ $user->created_at ? $user->created_at->format('M d, Y') : 'N/A' }}</span>
                                                            </li>
                                                            {{-- Add more dynamic fields as needed --}}
                                                        </ul>
                                                    </div><!-- .bio-block -->
                                                </div><!-- .card-body -->
                                            </div>
                                            <div class="card-content card-gutter-md">
                                                <div class="card-body">
                                                    <div class="bio-block">
                                                        <h4 class="bio-block-title">Change Password</h4>
                                                        <p>
                                                            To update your password, please enter your current password followed by your new one in the fields below. The new password will take effect the next time you log in.
                                                        </p>

                                                        <!-- Success Message -->
                                                        @if (session('status'))
                                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                                {{ session('status') }}
                                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                            </div>
                                                        @endif

                                                        <!-- Error Message -->
                                                        @if (session('error'))
                                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                                {{ session('error') }}
                                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                            </div>
                                                        @endif

                                                         <!-- General Validation Error List -->
                                                        @if ($errors->any())
                                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                                <ul class="list-disc list-inside">
                                                                    @foreach ($errors->all() as $error)
                                                                        <li>{{ $error }}</li>
                                                                    @endforeach
                                                                </ul>
                                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                            </div>
                                                        @endif
                                                        <form action="{{ route('user.password.update') }}" method="POST">
                                                            @csrf
                                                            
                                                            <!-- Current Password -->
                                                            <div class="form-group mt-2">
                                                                <div class="form-control-wrap">
                                                                    <div class="form-control-icon start"><em class="icon ni ni-lock"></em></div>
                                                                    <input type="password" class="form-control" name="current_password" id="current_password" placeholder="Enter current Password" required>
                                                                </div>
                                                            </div>

                                                            <!-- New Password -->
                                                            <div class="form-group mt-2">
                                                                <div class="form-control-wrap">
                                                                    <div class="form-control-icon start"><em class="icon ni ni-lock-alt"></em></div>
                                                                    <input type="password" class="form-control" name="new_password" id="new_password" placeholder="Enter new password" required>
                                                                </div>
                                                            </div>

                                                            <!-- Re-enter New Password -->
                                                            <div class="form-group mt-2">
                                                                <div class="form-control-wrap">
                                                                    <div class="form-control-icon start"><em class="icon ni ni-lock-alt-fill"></em></div>
                                                                    <input type="password" class="form-control" name="new_password_confirmation" id="confirm_password" placeholder="Re-enter new password" required>
                                                                </div>
                                                            </div>
                                                            
                                                            <!-- Submit Button -->
                                                            <div class="form-group mt-4">
                                                                <button type="submit" class="btn btn-primary">Update Password</button>
                                                            </div>
                                                        </form>

                                                        
                                                        
                                                    </div><!-- .bio-block -->
                                                </div><!-- .card-body -->
                                            </div><!-- .card-content -->
                                        </div><!-- .card-row -->
                                    </div><!-- .card -->
                                </div><!-- .tab-pane -->
                            </div><!-- .tab-content -->
                        </div><!-- .nk-block -->
                    @else
                        {{-- Show a message if the user is not found --}}
                        <div class="alert alert-danger" role="alert">
                            User not found.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
