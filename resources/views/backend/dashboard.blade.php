@extends('backend.layouts.app')

@section('content')
@if (auth()->user()->can('smtp_settings') &&
env('MAIL_USERNAME') == null &&
env('MAIL_PASSWORD') == null)
<div class="">
    <div class="alert alert-info d-flex align-items-center">
        {{ translate('Please Configure SMTP Setting to work all email sending functionality') }},
        <a class="alert-link ml-2" href="{{ route('smtp_settings.index') }}">{{ translate('Configure Now') }}</a>
    </div>
</div>
@endif
@can('admin_dashboard')


<div class="row">
    <div class="col-md-6">
        <div class="card text-white mb-3 shadow-lg animate-fade-in hover-zoom bg-blur-gradient-orange">
            <div class="card-body d-flex align-items-center">
                <div class="icon-box">
                    <h4 class="display-4 mb-0">{{ $divisions }}</h4>
                </div>
                <!-- Text Content -->
                <div class="ml-4">
                    <p class="h4 font-weight-bold">Divisions</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Districts Box -->
    <div class="col-md-6">
        <div class="card text-white mb-3 shadow-lg animate-fade-in hover-zoom bg-blur-gradient-dark">
            <div class="card-body d-flex align-items-center">
                <!-- Icon on Left -->
                <div class="icon-box">
                    <h4 class="display-4 mb-0">{{ $districts }}</h4>
                </div>
                <!-- Text Content -->
                <div class="ml-4">
                    <p class="h4 font-weight-bold">Districts</p>
                </div>
            </div>
        </div>
    </div>


</div>

<div class="row">
    <!-- Directors Box -->
    <div class="col-md-6">
        <div class="card text-white mb-3 shadow-lg animate-fade-in hover-zoom bg-blur-gradient-primary">
            <div class="card-body d-flex align-items-center">
                <!-- Icon on Left -->
                <div class="icon-box">
                    <i class="las la-user-tie"></i> <!-- Director Icon -->
                </div>
                <!-- Text Content -->
                <div class="ml-4">
                    <h4 class="display-4 mb-0">{{ $d_director }}</h4>
                    <p class="h4 font-weight-bold">Directors</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Organizations Box -->
    <div class="col-md-6">
        <div class="card text-white mb-3 shadow-lg animate-fade-in hover-zoom bg-blur-gradient-success">
            <div class="card-body d-flex align-items-center">
                <!-- Icon on Left -->
                <div class="icon-box">
                    <i class="las la-building"></i> <!-- Organization Icon -->
                </div>
                <!-- Text Content -->
                <div class="ml-4">
                    <h4 class="display-4 mb-0">{{ $organization }}</h4>
                    <p class="h4 font-weight-bold">Organizations</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fadeIn 0.8s ease-in-out;
    }

    .card {
        border: 0px !important;
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease-in-out;
    }

    /* Red-Pink Gradient - Elegant & Bold */
    .bg-blur-gradient-primary {
        background: linear-gradient(135deg, #D50000, #FF1744);
        backdrop-filter: blur(10px);
        border-radius: 15px;
        box-shadow: inset 0 3px 6px rgba(255, 255, 255, 0.2),
            inset 0 -3px 6px rgba(0, 0, 0, 0.2),
            0 10px 25px rgba(255, 23, 68, 0.3);
    }

    /* Teal-Green Gradient - Refreshing & Soft */
    .bg-blur-gradient-success {
        background: linear-gradient(135deg, #00695C, #00BFA5);
        backdrop-filter: blur(10px);
        border-radius: 15px;
        box-shadow: inset 0 3px 6px rgba(255, 255, 255, 0.2),
            inset 0 -3px 6px rgba(0, 0, 0, 0.2),
            0 10px 25px rgba(0, 191, 165, 0.3);
    }

    /* Orange-Red Gradient - Warm & Strong */
    .bg-blur-gradient-orange {
        background: linear-gradient(135deg, #B71C1C, #FF5722);
        backdrop-filter: blur(12px);
        border-radius: 15px;
        box-shadow: inset 0 3px 6px rgba(255, 255, 255, 0.2),
            inset 0 -3px 6px rgba(0, 0, 0, 0.2),
            0 12px 30px rgba(255, 87, 34, 0.3);
    }

    /* Purple Gradient - Royal & Premium */
    .bg-blur-gradient-dark {
        background: linear-gradient(135deg, #4A148C, #D500F9);
        backdrop-filter: blur(12px);
        border-radius: 15px;
        box-shadow: inset 0 3px 6px rgba(255, 255, 255, 0.2),
            inset 0 -3px 6px rgba(0, 0, 0, 0.2),
            0 12px 30px rgba(213, 0, 249, 0.3);
    }

    /* Dark Theme Accent - Modern & Futuristic */
    .bg-blur-gradient-purple {
        background: linear-gradient(135deg, #006a5b, #00af97);        backdrop-filter: blur(12px);
        border-radius: 15px;
        box-shadow: inset 0 3px 6px rgba(255, 255, 255, 0.1),
            inset 0 -3px 6px rgba(0, 0, 0, 0.3),
            0 12px 30px rgba(66, 66, 66, 0.3);
    }


    .icon-box {
        width: 80px;
        height: 80px;
        background: rgba(255, 255, 255, 0);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
        box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.2),
            -5px -5px 15px rgba(255, 255, 255, 0.1);
        transition: all 0.3s ease-in-out;
    }

    .icon-box:hover {
        transform: scale(1.05);
        box-shadow: 10px 10px 20px rgba(0, 0, 0, 0.3),
            -10px -10px 20px rgba(255, 255, 255, 0.2);
    }

    .hover-zoom {
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }

    .hover-zoom:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.25) !important;
    }
</style>





























@endcan

@endsection