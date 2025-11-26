@extends('auth.layouts.authentication')

@section('content')
<!-- aiz-main-wrapper -->
<section
    style="background-image: url('{{ uploaded_asset(get_setting('password_reset_page_image')) }}'); background-size: cover; background-repeat: no-repeat; min-height: 100vh;">

    <div style=" position: fixed;
                                top: 0;
                                left: 0;
                                width: 100%;
                                height: 100%;
                                background: linear-gradient(to right, rgba(19, 96, 19, 0.38), rgba(9, 108, 9, 0.56));
                                z-index: 1;">
    </div>

    <div class="container position-relative z-5" style="margin-top: 220px">
        <div class="row justify-content-center">
            <div>
                <div class="z-5 p-4 p-lg-5 d-flex flex-column bg-white rounded justify-content-center border right-content"
                    style="height: auto;">

                    <div class="size-48px mb-3 mx-auto mx-lg-0">
                        <img src="{{ uploaded_asset(get_setting('site_icon')) }}" alt="{{ translate('Site Icon')}}"
                            class="img-fit h-100">


                        <!-- Titles -->
                        <div class="text-center text-lg-left">
                            <h1 class="fs-20 fs-md-20 fw-700 text-primary" style="text-transform: uppercase;">
                                {{ translate('Verify Your Email Address') }}
                            </h1>
                            <h5 class="fs-14 fw-400 text-dark">
                                {{ translate('Before proceeding, please check your email for a verification link. If you did not receive the email.') }}
                            </h5>
                        </div>

                        <!-- Reset password form -->
                        <div class="pt-3">
                            <div class="">
                                <a href="{{ route('verification.resend') }}"
                                    class="btn btn-primary btn-block">{{ translate('Click here to request another') }}</a>
                                @if (session('resent'))
                                <div class="alert alert-success mt-2 mb-0" role="alert">
                                    {{ translate('A fresh verification link has been sent to your email address.') }}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Go Back -->
                    <div class="mt-3 row justify-content-center">
                        <a href="{{ route('logout') }}" class="ml-auto fs-14 fw-700 d-flex align-items-center text-light"
                            style="max-width: fit-content;">
                            <i class="las la-sign-out-alt fs-20 mr-1"></i>
                            {{ translate('Back to Previous Page')}}
                        </a>
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