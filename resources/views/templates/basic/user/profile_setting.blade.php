@extends($activeTemplate.'layouts.master')
@section('content')
    <div class="card custom--card">
        <div class="card-header">
            <h5 class="card-title">@lang('Profile Information')</h5>
        </div>
        <div class="card-body">
            <form class="register" action="" method="post">
                @csrf
                <div class="row gy-3">
                    <div class="form-group col-sm-6">
                        <label for="firstname" class="col-form-label">@lang('First Name'):</label>
                        <input type="text" class="form-control form--control" id="firstname" name="firstname" value="{{$user->firstname}}">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="lastname" class="col-form-label">@lang('Last Name'):</label>
                        <input type="text" class="form-control form--control" id="lastname" name="lastname" value="{{$user->lastname}}" >
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="uname" class="col-form-label">@lang('Username'):</label>
                        <input type="text" class="form-control form--control" id="uname" name="username" value="{{ $user->username }}" readonly>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="email" class="col-form-label">@lang('Email Address'):</label>
                        <input type="text" class="form-control form--control" id="email" name="email" value="{{ $user->email }}" readonly>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="country" class="col-form-label">@lang('Country'):</label>
                        <input class="form-control form--control" name="country" value="{{@$user->address->country}}" readonly>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="phone" class="col-form-label">@lang('Phone'):</label>
                        <input class="form-control form--control" name="mobile" id="phone" value="{{$user->mobile}}" readonly>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="address" class="col-form-label">@lang('Address'):</label>
                        <input type="text" class="form-control form--control" id="address" name="address" value="{{@$user->address->country}}">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="state" class="col-form-label">@lang('State'):</label>
                        <input type="text" class="form-control form--control" id="state" name="state" value="{{@$user->address->state}}">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="zip" class="col-form-label">@lang('Zip Code'):</label>
                        <input type="text" class="form-control form--control" id="zip" name="zip" value="{{@$user->address->zip}}">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="city" class="col-form-label">@lang('City'):</label>
                        <input type="text" class="form-control form--control" id="city" name="city" value="{{@$user->address->city}}">
                    </div>
                </div>
                <div class="form-group  mb-0 mt-3">
                    <button type="submit" class="cmn--btn btn--md mt-2 w-100">@lang('Update Profile')</button>
                </div>
            </form>
        </div>
    </div>
@endsection
