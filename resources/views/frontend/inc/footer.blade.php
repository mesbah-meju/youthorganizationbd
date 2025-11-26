<!-- FOOTER -->
<footer class="pt-3 pb-7 pb-xl-3 bg-black text-soft-light">
    <div class="container">
        <div class="row align-items-center py-3">
            <!-- Copyright -->
            <div class="col-lg-6 order-1 order-lg-0">
                <div class="text-center text-lg-left fs-14" current-verison="{{get_setting("current_version")}}">
                    {!! get_setting('frontend_copyright_text', null, App::getLocale()) !!}
                </div>
            </div>

            <!-- Payment Method Images -->
            {{-- <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="text-center text-lg-right">
                    <ul class="list-inline mb-0">
                        @if (get_setting('payment_method_images') != null)
                            @foreach (explode(',', get_setting('payment_method_images')) as $key => $value)
                                <li class="list-inline-item mr-3">
                                    <img src="{{ uploaded_asset($value) }}" height="20" class="mw-100 h-auto"
                                        style="max-height: 20px" alt="{{ translate('payment_method') }}">
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div> --}}
            <div class="mt-3 mb-md-4 mr-4 mr-md-0">
                <a href="{{ url()->previous() }}" class="ml-auto fs-14 fw-700 d-flex align-items-center text-primary"
                    style="max-width: fit-content;">
                    <i class="las la-arrow-left fs-20 mr-1"></i>
                    {{ translate('Back to Previous Page')}}
                </a>
            </div>
        </div>
    </div>

</footer>