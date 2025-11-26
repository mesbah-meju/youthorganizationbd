@extends('auth.layouts.authentication')

@section('content')
<style>
    .form-control {
        border: none;
        border-bottom: 1px solid #ccc;
        padding: 10px 35px 0px 5px;
        margin: 0px 16px;
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
        margin: -20px 20px 0px 0px;
    }
</style>
<!-- aiz-main-wrapper -->
<div class="aiz-main-wrapper d-flex flex-column justify-content-md-center bg-white">
    <section style="background-image: url('{{ uploaded_asset(get_setting('customer_login_page_image')) }}'); background-size: cover; background-repeat: no-repeat; min-height: 100vh;">
        <div style=" position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(to right, rgba(19, 96, 19, 0.38), rgba(9, 108, 9, 0.56)); z-index: 1;"></div>
        <div class="container position-relative z-5">
            <div class="row">
                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6" style="margin: 100px auto; ">



                    <div class="card shadow" style="border-radius: 7px; padding: 40px 25px;">
                        <div class="row no-gutters">

                            <div class="border-0 col-12 d-flex flex-column justify-content-center border">
                                <!-- Site Icon -->

                                <div
                                    class="card-header p-0 position-relative justify-content-center text-center border-0">
                                    <div class=" m-auto">
                                        <img src="{{ uploaded_asset(get_setting('site_icon')) }}"
                                            alt="{{ translate('Site Icon') }}" class="img-fit mb-3 h-100 size-100px">

                                        <div class="text-center">
                                            <h3 class="mb-4 fs-20 fs-md-24 fw-700 text-primary"
                                                style="text-transform: uppercase;">
                                                {{ translate('Login to your account') }}
                                            </h3>
                                        </div>

                                    </div>
                                </div>

                                <!-- Login form -->
                                <div class="pt-3">
                                    <div class="">
                                        <form class="form-default" role="form" action="{{ route('login') }}"
                                            method="POST">
                                            @csrf

                                            <!-- Email or Phone -->
                                            @if (addon_is_activated('otp_system'))
                                            <div class="form-group phone-form-group mb-1 d-none">

                                                <div class="position-relative mb-3 d-flex">
                                                    <i class="las la-2x la-phone mt-3"></i>
                                                    <input type="tel" id="phone"
                                                        class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }} rounded-0"
                                                        value="{{ old('phone') }}" placeholder="01XXXXXXXXX"
                                                        pattern="[0-9]{11}" maxlength="11" name="phone"
                                                        autocomplete="off">
                                                </div>
                                            </div>
                                            <input type="hidden" name="country_code" value="">

                                            <div class="form-group email-form-group mb-1">

                                                <div class="position-relative mb-3 d-flex">
                                                    <i class="las la-2x la-envelope mt-3"></i>
                                                    <input type="email"
                                                        class="form-control rounded-0 {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                                        value="{{ old('email') }}"
                                                        placeholder="{{ translate('johndoe@example.com') }}"
                                                        name="email" id="email" autocomplete="off">
                                                    @if ($errors->has('email'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group text-right">
                                                <button class="btn btn-link p-0 text-primary fs-12 fw-400"
                                                    type="button"
                                                    onclick="toggleEmailPhone(this)"><i>*{{ translate('Use Phone Number Instead') }}</i></button>
                                            </div>
                                            @else
                                            <div class="form-group">
                                                <div class="position-relative mb-3 d-flex">
                                                    <i class="las la-2x la-envelope mt-3"></i>
                                                    <label for="email"
                                                        class="fs-12 fw-700 text-soft-dark">{{ translate('Email') }}</label>
                                                    <input type="email"
                                                        class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} rounded-0"
                                                        value="{{ old('email') }}"
                                                        placeholder="{{ translate('johndoe@example.com') }}"
                                                        name="email" id="email" autocomplete="off">
                                                    @if ($errors->has('email'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                            @endif

                                            <!-- password -->
                                            <div class="form-group">
                                                <div class="position-relative mb-3 d-flex">
                                                    <i class="las la-2x la-lock mt-3"></i>
                                                    <input type="password"
                                                        class="form-control rounded-0 {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                                        placeholder="{{ translate('Password') }}" name="password"
                                                        id="password">
                                                    <i class="password-toggle las la-2x la-eye"></i>

                                                </div>
                                            </div>

                                            <div class="row mb-2">
                                                <!-- Remember Me -->
                                                <div class="col-6">
                                                    <label class="aiz-checkbox">
                                                        <input type="checkbox" name="remember"
                                                            {{ old('remember') ? 'checked' : '' }}>
                                                        <span
                                                            class="has-transition fs-12 fw-400 text-gray-dark hov-text-primary">{{ translate('Remember Me') }}</span>
                                                        <span class="aiz-square-check"></span>
                                                    </label>
                                                </div>
                                                <!-- Forgot password -->
                                                <div class="col-6 text-right">
                                                    <a href="{{ route('password.request') }}"
                                                        class="text-reset fs-12 fw-400 text-gray-dark hov-text-primary"><u>{{ translate('Forgot password?') }}</u></a>
                                                </div>
                                            </div>

                                            <!-- Submit Button -->
                                            <div class="mb-4 mt-4">
                                                <button type="submit"
                                                    class="btn btn-primary btn-block fw-700 fs-14 rounded-0">{{ translate('Login') }}</button>
                                            </div>
                                        </form>

                                        <!-- DEMO MODE -->
                                        @if (env('DEMO_MODE') == 'On')
                                        <div class="mb-4">
                                            <table class="table table-bordered mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td>{{ translate('Customer Account') }}</td>
                                                        <td class="text-center">
                                                            <button class="btn btn-info btn-sm"
                                                                onclick="autoFillCustomer()">{{ translate('Copy credentials') }}</button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        @endif

                                        <!-- Social Login -->
                                        @if (get_setting('google_login') == 1 ||
                                        get_setting('facebook_login') == 1 ||
                                        get_setting('twitter_login') == 1 ||
                                        get_setting('apple_login') == 1)
                                        <div class="text-center mb-3">
                                            <span
                                                class="bg-white fs-12 text-gray">{{ translate('Or Login With') }}</span>
                                        </div>
                                        <ul class="list-inline social colored text-center mb-4">
                                            @if (get_setting('facebook_login') == 1)
                                            <li class="list-inline-item">
                                                <a href="{{ route('social.login', ['provider' => 'facebook']) }}"
                                                    class="facebook">
                                                    <i class="lab la-facebook-f"></i>
                                                </a>
                                            </li>
                                            @endif
                                            @if (get_setting('google_login') == 1)
                                            <li class="list-inline-item">
                                                <a href="{{ route('social.login', ['provider' => 'google']) }}"
                                                    class="google">
                                                    <i class="lab la-google"></i>
                                                </a>
                                            </li>
                                            @endif
                                            @if (get_setting('twitter_login') == 1)
                                            <li class="list-inline-item">
                                                <a href="{{ route('social.login', ['provider' => 'twitter']) }}"
                                                    class="twitter">
                                                    <i class="lab la-twitter"></i>
                                                </a>
                                            </li>
                                            @endif
                                            @if (get_setting('apple_login') == 1)
                                            <li class="list-inline-item">
                                                <a href="{{ route('social.login', ['provider' => 'apple']) }}"
                                                    class="apple">
                                                    <i class="lab la-apple"></i>
                                                </a>
                                            </li>
                                            @endif
                                        </ul>
                                        @endif
                                    </div>

                                    <!-- Register Now -->
                                    <p class="fs-12 text-gray mb-0">
                                        {{ translate('Dont have an account?') }}
                                        <a href="{{ route('user.registration') }}"
                                            class="ml-2 fs-14 fw-700 animate-underline-primary">{{ translate('Register Now') }}</a>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="container">
                            <div class="row mt-5 justify-content-between align-items-center">
                                <div>
                                    <img src="{{ static_asset('assets/img/first_image.png') }}"
                                        style="width: auto; height: 80px;">
                                </div>
                                <div>
                                    <img src="{{ static_asset('assets/img/second_image.png') }}"
                                        style="width: 100px; height: auto;">
                                </div>
                                <div>
                                    <img src="{{ static_asset('assets/img/third_image.png') }}"
                                        style="width: 130px; height: auto;">
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
</div>
@endsection

@section('script')
<script>
    function autoFillCustomer() {
        $('#email').val('customer@example.com');
        $('#password').val('123456');
    }
</script>
@endsection