@extends('auth.layouts.authentication')

@section('content')
<style>
    .form-control {
        border: none;
        border-bottom: 1px solid #ccc;
        padding: 10px 35px 0px 5px;
        margin: 0px 16px;
    }

    @media (max-width: 768px) {
        .form-control {
            margin: 0px 5px;
        }
    }

    .aiz-selectpicker {
        border: none;
        border-bottom: 1px solid #ccc;
        border-radius: 0px;
    }

    .info {
        display: flex;
        align-items: center;
        margin: 15px 0px;
    }

    .icon-info {
        margin: 0px 25px 0px 10px;
    }

    .material-icons {
        font-size: 45px;
    }

    .password-toggle {
        margin-right: 20px;
    }

    .btn-link {
        margin: 20px 0px 0px;
    }

    .card {
        border-radius: 0px 0px 7px 7px;
        margin-bottom: 30px;
        padding: 40px 25px;
        border: none;
        box-shadow: none;
    }

    .nav-item {
        border-bottom: none;
        width: 50%;
    }

    .nav-dd {
        border-radius: 7px 0px 0px 0px !important;
        border: none !important;
        box-shadow: none !important;
    }

    .nav_org {
        border-radius: 0px 7px 0px 0px !important;
        border: none !important;
        box-shadow: none !important;
    }

    .nav-link.active {
        color: #13723a !important;
        background-color: rgb(255, 255, 255) !important;
    }

    .nav-link {
        color: rgb(255, 255, 255) !important;
        background-color: #13723a !important;
        font-size: 20px;
        font-weight: 600;
        text-align: center;
    }

    .custom-card {
        position: relative;
        padding: 10px 30px;
        border-radius: 7px;
        overflow: hidden;
        backdrop-filter: blur(15px);
        background: rgba(255, 255, 255, 0.1);
        box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: space-between;
        text-align: center;
        gap: 15px;
    }

    .custom-card:hover {
        transform: translateY(-5px);
        box-shadow: 0px 15px 40px rgba(0, 255, 150, 0.3);
    }

    .custom-card img {
        transition: transform 0.3s ease, filter 0.3s ease;
    }

    .custom-card img:hover {
        transform: scale(1.2);
        filter: drop-shadow(0px 5px 15px rgba(0, 255, 150, 0.4));
    }

    .custom-card span {
        font-size: 1rem;
        font-weight: 600;
        color: #fff;
        white-space: nowrap;
        overflow: hidden;
        display: inline-block;
        border-right: 2px solid transparent;
    }
</style>

<section
    style="background-image: url('{{ uploaded_asset(get_setting('customer_register_page_image')) }}'); background-size: cover; background-repeat: no-repeat; min-height: 100vh;">

    <div
        style=" position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(to right, rgba(19, 96, 19, 0.38), rgba(9, 108, 9, 0.56)); z-index: 1;">
    </div>
    <div class="container position-relative z-5">

        <div class="row">


            <div class="col-xxl-9 col-xl-9 col-lg-9 col-md-9 col-sm-6 mx-auto py-lg-4" style="margin-top: 80px;">
                <div class="col-md-12 d-flex justify-content-center mb-4">
                    <img src="{{ uploaded_asset(get_setting('site_icon')) }}"
                        alt="{{ translate('Site Icon') }}" class="img-fit h-100 size-140px">
                </div>

                <ul class="nav nav-tabs" id="regTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link nav-dd" id="director-tab" data-toggle="tab" href="#director" role="tab"
                            aria-controls="director" aria-selected="true">Authority Registration</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link nav_org active" id="organization-tab" data-toggle="tab" href="#organization"
                            role="tab" aria-controls="organization" aria-selected="false">Organization Registration</a>
                    </li>
                </ul>

                <div class="tab-content" id="regTabContent">
                    <div class="tab-pane fade" id="director" role="tabpanel" aria-labelledby="director-tab">
                        <div class="card">
                            <div class="card-header p-0 position-relative justify-content-center text-center border-0">
                                <div class=" m-auto">
                                    <!-- <img src="{{ uploaded_asset(get_setting('site_icon')) }}"
                                            alt="{{ translate('Site Icon') }}" class="img-fit h-100 size-100px"> -->
                                    <div class="text-center">
                                        <h1 class="mt-3 fs-20 fs-md-24 fw-700 text-primary"
                                            style="text-transform: uppercase;">DYD User Registration form</h1>
                                    </div>
                                </div>
                            </div>

                            <div class="border-0 p-lg-5 d-flex flex-column justify-content-center border right-content mt-5"
                                style="height: auto;">
                                <!-- Register form -->
                                <div class="card-content">
                                    <form id="reg-form" class="form-default" role="form"
                                        action="{{ route('directors.register') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <!-- Name & Role -->
                                            <div class="row">
                                                <div class="col-md-6 position-relative mb-3 d-flex">
                                                    <i class="las la-2x la-user mt-3"></i>
                                                    <input type="text"
                                                        class="form-control rounded-0{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                                        value="{{ old('name') }}" placeholder="{{  translate('Name') }}"
                                                        name="name" pattern="[A-Za-z\s]+">
                                                    @if ($errors->has('name'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('name') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                                <div class="col-md-6 position-relative mb-3 d-flex">
                                                    <i class="las la-2x la-address-book mt-3"></i>
                                                    <select class="form-control aiz-selectpicker" name="role_id"
                                                        id="role_id" required>
                                                        <option value="">Select Designation</option>
                                                        @foreach($roles as $role)
                                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Division, District & Upazila -->
                                            <div class="row mb-3">
                                                <div class="col-md-12 d-flex">
                                                    <i class="las la-2x la-map-marker mt-3"></i>
                                                    <select name="division_id" id="division_id"
                                                        class="form-control aiz-selectpicker"
                                                        onchange="divisionWiseDistrictForSchoolCreate(this.value)"
                                                        required>
                                                        <option value="">Select Division</option>
                                                        @foreach($divisions as $division)
                                                        <option value="{{ $division->id }}">{{ $division->name }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    <select name="district_id" id="district_id"
                                                        class="form-control aiz-selectpicker"
                                                        onchange="districtWiseUpazilaForSchoolCreate(this.value)">
                                                        <option value="">Select District</option>
                                                    </select>
                                                    <select name="upazila_id" id="upazila_id"
                                                        class="form-control aiz-selectpicker">
                                                        <option value="">Select Upazila</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Email or Phone -->
                                            @if (addon_is_activated('otp_system'))
                                            <div class="form-group phone-form-group mb-1">
                                                <div class="position-relative mb-3 d-flex">
                                                    <i class="las la-2x la-phone mt-3"></i>
                                                    <input type="text"
                                                        class="form-control rounded-0{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                                        pattern="[0-9]{11}" maxlength="11" value="{{ old('phone') }}"
                                                        placeholder="01xxxxxxxxx" name="phone" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="form-group email-form-group mb-1">
                                                <div class="position-relative mb-3 d-flex">
                                                    <i class="las la-2x la-envelope mt-3"></i>
                                                    <input type="email"
                                                        class="form-control rounded-0 {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                                        value="{{ old('email') }}"
                                                        placeholder="{{  translate('Email') }}" name="email"
                                                        autocomplete="off">
                                                    @if ($errors->has('email'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                            @else
                                            <div class="form-group">
                                                <div class="position-relative mb-3 d-flex">
                                                    <i class="las la-2x la-envelope mt-3"></i>
                                                    <input type="email"
                                                        class="form-control rounded-0{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                                        value="{{ old('email') }}"
                                                        placeholder="{{  translate('Email') }}" name="email">
                                                    @if ($errors->has('email'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                            @endif

                                            <!-- Password -->
                                            <div class="form-group mb-0">
                                                <div class="position-relative d-flex">
                                                    <i class="las la-2x la-lock mt-3"></i>
                                                    <input type="password"
                                                        class="form-control rounded-0{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                                        placeholder="{{  translate('Password') }}" name="password">
                                                    <i class="password-toggle las la-2x la-eye"></i>
                                                </div>
                                                <div class="text-right ">
                                                    <span
                                                        class="fs-12 fw-400 text-gray-dark mr-3">{{ translate('Password must contain at least 6 digits') }}</span>
                                                </div>
                                                @if ($errors->has('password'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                                @endif
                                            </div>

                                            <!-- Password Confirm -->
                                            <div class="form-group">
                                                <div class="position-relative mb-3 d-flex">
                                                    <i class="las la-2x la-lock icon mt-3"></i>
                                                    <input type="password" class="form-control rounded-0"
                                                        placeholder="{{  translate('Confirm Password') }}"
                                                        name="password_confirmation">
                                                    <i class="password-toggle las la-2x la-eye"></i>
                                                </div>
                                            </div>

                                            <!-- Recaptcha -->
                                            @if(get_setting('google_recaptcha') == 1)
                                            <div class="form-group">
                                                <div class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_KEY') }}"></div>
                                            </div>
                                            @if ($errors->has('g-recaptcha-response'))
                                            <span class="invalid-feedback" role="alert" style="display: block;">
                                                <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                            </span>
                                            @endif
                                            @endif
                                            <!-- Submit Button -->
                                            <div class="mb-4 mt-4">
                                                <button type="submit"
                                                    class="btn btn-primary btn-block fw-600 rounded-0">{{ translate('Create Account') }}</button>
                                            </div>
                                    </form>
                                </div>

                                <!-- Log In -->
                                <p class="fs-12 text-gray mb-0">
                                    {{ translate('Already have an account?')}}
                                    <a href="{{ route('user.login') }}"
                                        class="ml-2 fs-14 fw-700 animate-underline-primary">{{ translate('Log In')}}</a>
                                </p>
                            </div>
                        </div>
                        <div class="container">
                            <div class="row mt-3 px-5 justify-content-between align-items-center">
                                <div>
                                    <img src="{{ static_asset('assets/img/first_image.png') }}" style="width: auto; height: 80px;">
                                </div>
                                <div>
                                    <img src="{{ static_asset('assets/img/second_image.png') }}" style="width: 100px; height: auto;">
                                </div>
                                <div>
                                    <img src="{{ static_asset('assets/img/third_image.png') }}" style="width: 130px; height: auto;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- user -->
                <div class="tab-pane fade show active" id="organization" role="tabpanel" aria-labelledby="organization-tab">
                    <div class="card">
                        <div class="card-header p-0 position-relative justify-content-center text-center border-0">
                            <div class=" m-auto">
                                <!-- <img src="{{ uploaded_asset(get_setting('site_icon')) }}"
                                        alt="{{ translate('Site Icon') }}" class="img-fit h-100 size-100px"> -->

                                <div class="text-center">
                                    <h1 class="mt-3 fs-20 fs-md-24 fw-700 text-primary"
                                        style="text-transform: uppercase;">Youth Organization Registration Form</h1>
                                </div>
                            </div>
                        </div>

                        <div class="row no-gutters">
                            <!-- Left Side Image-->
                            <div class="border-0 col-lg-6 m-auto p-lg-5 d-flex flex-column justify-content-center border right-content"
                                style="height: auto;">
                                <div class="card-content">
                                    <img src="{{ static_asset('assets/img/register_image.jpg') }}" class="img-fluid mb-4"
                                        style="border-radius: 7px; box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);">
                                    {{-- <div class="info info-horizontal">
                                        <div class="icon-info"><i class="material-icons text-danger">timeline</i></div>
                                        <div class="description">
                                            <h4 class="info-title">Youth-led</h4>
                                            <p class="description">Lorem ipsum dolor sit amet, consectetur adipiscing
                                                elit, sed do eiusmod tempor...</p>
                                        </div>
                                    </div> --}}

                                    {{-- <div class="info info-horizontal">
                                        <div class="icon-info"><i class="material-icons text-primary">code</i></div>
                                        <div class="description">
                                            <h4 class="info-title">National Database of the Youth Organizations of Bangladesh</h4>
                                            <p class="description">Lorem ipsum dolor sit amet, consectetur adipiscing
                                                elit, sed do eiusmod tempor...</p>
                                        </div>
                                    </div> --}}

                                    {{-- <div class="info info-horizontal">
                                        <div class="icon-info"><i class="material-icons text-success">group</i></div>
                                        <div class="description">
                                            <h4 class="info-title">Organizations of Bangladesh</h4>
                                            <p class="description">Lorem ipsum dolor sit amet, consectetur adipiscing
                                                elit, sed do eiusmod tempor...</p>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>

                            <!-- Right Side -->
                            <div class="border-0 col-lg-6 m-auto p-lg-5 d-flex flex-column justify-content-center border right-content"
                                style="height: auto;">
                                <!-- Register form -->
                                <div class="card-content">
                                    <form id="reg-form" class="form-default" role="form"
                                        action="{{ route('register') }}" method="POST">
                                        @csrf
                                        <!-- Name -->
                                        <div class="form-group">
                                            <div class="position-relative mb-3 d-flex">
                                                <i class="las la-2x la-home mt-3"></i>
                                                <!-- <label for="name" class="fs-12 fw-700 text-soft-dark">{{ translate('Organization Name') }}</label> -->
                                                <input type="text"
                                                    class="form-control rounded-0{{ $errors->has('organization_name') ? ' is-invalid' : '' }}"
                                                    value="{{ old('organization_name') }}"
                                                    placeholder="{{  translate('Organization Name') }}"
                                                    name="organization_name" required>
                                                @if ($errors->has('organization_name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('organization_name') }}</strong>
                                                </span>
                                                @endif
                                            </div>

                                            <div class="position-relative mb-3 d-flex">
                                                <i class="las la-2x la-user mt-3"></i>
                                                <input type="text"
                                                    class="form-control rounded-0{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                                    value="{{ old('name') }}"
                                                    placeholder="{{  translate('Concerned Official') }}"
                                                    pattern="[A-Za-z\s]+" name="name" required>
                                            </div>
                                            @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                            @endif


                                            <div class="position-relative mb-3 d-flex">
                                                <i class="las la-2x la-address-book mt-3"></i>
                                                <!-- <label for="designation" class="fs-12 fw-700 text-soft-dark">{{ translate('Designation') }}</label> -->
                                                <input type="text"
                                                    class="form-control rounded-0{{ $errors->has('designation') ? ' is-invalid' : '' }}"
                                                    value="{{ old('designation') }}"
                                                    placeholder="{{  translate('Designation') }}" name="designation">
                                                @if ($errors->has('designation'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('designation') }}</strong>
                                                </span>
                                                @endif
                                            </div>

                                            <!-- Email or Phone -->
                                            @if (addon_is_activated('otp_system'))
                                            <div class="form-group phone-form-group mb-1">
                                                <div class="position-relative mb-3 d-flex">
                                                    <i class="las la-2x la-phone mt-3"></i>
                                                    <input type="text"
                                                        class="form-control rounded-0{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                                        value="{{ old('phone') }}" pattern="[0-9]{11}" maxlength="11"
                                                        placeholder="01xxxxxxxxx" name="phone" autocomplete="off">
                                                </div>
                                            </div>

                                            <!-- <input type="hidden" name="country_code" value=""> -->

                                            <div class="form-group email-form-group mb-1">

                                                <div class="position-relative mb-3 d-flex">
                                                    <i class="las la-2x la-envelope mt-3"></i>
                                                    <input type="email"
                                                        class="form-control rounded-0 {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                                        value="{{ old('email') }}"
                                                        placeholder="{{  translate('Email') }}" name="email"
                                                        autocomplete="off">
                                                    @if ($errors->has('email'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>


                                            @else
                                            <div class="form-group">

                                                <div class="position-relative mb-3 d-flex">
                                                    <i class="las la-2x la-envelope mt-3"></i>
                                                    <input type="email"
                                                        class="form-control rounded-0{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                                        value="{{ old('email') }}"
                                                        placeholder="{{  translate('Email') }}" name="email">
                                                    @if ($errors->has('email'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>

                                            </div>
                                            @endif

                                            <!-- password -->
                                            <div class="form-group mb-0">

                                                <div class="position-relative d-flex">
                                                    <i class="las la-2x la-lock mt-3"></i>
                                                    <input type="password"
                                                        class="form-control rounded-0{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                                        placeholder="{{  translate('Password') }}" name="password">
                                                    <i class="password-toggle las la-2x la-eye"></i>
                                                </div>
                                                <div class="text-right ">
                                                    <span
                                                        class="fs-12 fw-400 text-gray-dark mr-3">{{ translate('Password must contain at least 6 digits') }}</span>
                                                </div>
                                                @if ($errors->has('password'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                                @endif
                                            </div>

                                            <!-- password Confirm -->
                                            <div class="form-group">
                                                <!-- <label for="password_confirmation" class="fs-12 fw-700 text-soft-dark">{{ translate('Confirm Password') }}</label> -->
                                                <div class="position-relative mb-3 d-flex">
                                                    <i class="las la-2x la-lock icon mt-3"></i>
                                                    <input type="password" class="form-control rounded-0"
                                                        placeholder="{{  translate('Confirm Password') }}"
                                                        name="password_confirmation">
                                                    <i class="password-toggle las la-2x la-eye"></i>
                                                </div>
                                            </div>

                                            <!-- Recaptcha -->
                                            @if(get_setting('google_recaptcha') == 1)
                                            <div class="form-group">
                                                <div class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_KEY') }}"></div>
                                            </div>
                                            @if ($errors->has('g-recaptcha-response'))
                                            <span class="invalid-feedback" role="alert" style="display: block;">
                                                <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                            </span>
                                            @endif
                                            @endif



                                            <!-- Submit Button -->
                                            <div class="mb-4 mt-4">
                                                <button type="submit"
                                                    class="btn btn-primary btn-block fw-600 rounded-0">{{ translate('Create Account') }}</button>
                                            </div>
                                    </form>

                                </div>

                                <!-- Log In -->
                                <p class="fs-12 text-gray mb-0">
                                    {{ translate('Already have an account?')}}
                                    <a href="{{ route('user.login') }}"
                                        class="ml-2 fs-14 fw-700 animate-underline-primary">{{ translate('Log In')}}</a>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="row mt-3 px-5 justify-content-between align-items-center">
                            <div>
                                <img src="{{ static_asset('assets/img/first_image.png') }}" style="width: auto; height: 80px;">
                            </div>
                            <div>
                                <img src="{{ static_asset('assets/img/second_image.png') }}" style="width: 100px; height: auto;">
                            </div>
                            <div>
                                <img src="{{ static_asset('assets/img/third_image.png') }}" style="width: 130px; height: auto;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="container mt-4">
        <div class="col-md-12 text-center" style="position: relative; z-index: 2;">
            <div class="text-white py-2 row justify-content-between align-items-center">
                <span class="me-2">Copyright © 2025 Youth Organization</span>
                <span>Design and Development by
                    <a href="#"
                        class="text-decoration-none fw-bold"
                        style="transition: all 0.3s ease;">
                        <span>
                            Mumble
                        </span>
                    </a>
                    <span> & </span>
                    <a href="https://fouraxiz.com/"
                        class="text-decoration-none fw-bold"
                        style="transition: all 0.3s ease;">
                        <span>
                            4axiz IT Ltd
                        </span>
                    </a>
                </span>
            </div>
        </div>
    </div>
    </div>
</section>

@endsection

@section('script')
@if(get_setting('google_recaptcha') == 1)
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endif

<script type="text/javascript">
    @if(get_setting('google_recaptcha') == 1)
    // making the CAPTCHA  a required field for form submission
    $(document).ready(function() {
        $("#reg-form").on("submit", function(evt) {
            var response = grecaptcha.getResponse();
            if (response.length == 0) {
                //reCaptcha not verified
                alert("please verify you are human!");
                evt.preventDefault();
                return false;
            }
            //captcha verified
            //do the rest of your validations here
            $("#reg-form").submit();
        });
    });
    @endif


    function countryWiseDivisionForSchoolCreate(country_id) {
        $.ajax({
            type: "GET",
            url: "{{ route('country-wise-division', '') }}/" + country_id,
            success: function(response) {
                $('#division_id').html(response);
            }
        });
    }

    function divisionWiseDistrictForSchoolCreate(division_id) {
        $.ajax({
            type: "GET",
            url: "{{ route('division-wise-district', '') }}/" + division_id,
            success: function(response) {
                $('#district_id').html(response);

            }
        });
    }

    function districtWiseUpazilaForSchoolCreate(district_id) {
        $.ajax({
            type: "GET",
            url: "{{ route('district-wise-upazila', '') }}/" + district_id,
            success: function(response) {
                $('#upazila_id').html(response);
            }
        });
    }
</script>

<script>
    $(document).ready(function() {
        function toggleDistrictUpazila() {
            const selectedRoleId = $('#role_id').val();
            if (selectedRoleId === '4') {
                $('#district_id').prop('disabled', true).closest('.bootstrap-select');
                $('#upazila_id').prop('disabled', true).closest('.bootstrap-select');
                $('#district_id, #upazila_id').val('');
            } else {
                $('#district_id').prop('disabled', false).closest('.bootstrap-select');
                $('#upazila_id').prop('disabled', false).closest('.bootstrap-select');
                $('#district_id, #upazila_id').val('');
            }
        }

        $('#role_id').on('change', toggleDistrictUpazila);

        // Trigger on page load (if role is pre-selected)
        toggleDistrictUpazila();
    });
</script>



<!-- 
<script>
    const textElement = document.getElementById("typing-text");
    const texts = ["4axiz IT Ltd", "Mumble Bangladesh"];
    let textIndex = 0;
    let charIndex = 0;
    let isDeleting = false;

    function typeEffect() {
        let currentText = texts[textIndex];
        let displayedText = isDeleting ?
            currentText.substring(0, charIndex--) :
            currentText.substring(0, charIndex++);

        textElement.innerHTML = displayedText + '<span style="border-right: 2px solid #fff"></span>';

        if (!isDeleting && charIndex === currentText.length + 1) {
            setTimeout(() => isDeleting = true, 1000);
        } else if (isDeleting && charIndex === 0) {
            isDeleting = false;
            textIndex = (textIndex + 1) % texts.length;
        }

        setTimeout(typeEffect, isDeleting ? 100 : 150);
    }

    typeEffect();
</script> -->
@endsection