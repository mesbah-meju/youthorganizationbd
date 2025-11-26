@extends('backend.layouts.app')

@section('content')

    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">{{ translate('Organizations List') }}</h1>
            </div>
        </div>
    </div>
    <div class="card">
        <form id="filter" action="{{ route('organization_list_report.index') }}" method="GET">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="division_id" class="col-xxl-4 col-form-label">{{ translate('Division') }}</label>
                            <div class="col-xxl-8">
                                <select name="division_id" id="division_id" class="form-control aiz-selectpicker"
                                    onchange="divisionWiseDistrictForSchoolCreate(this.value)">
                                    <option value="">Select Division</option>
                                    @foreach($divisions as $division)
                                        <option value="{{ $division->id }}">{{ $division->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="district_id" class="col-xxl-4 col-form-label">{{ translate('District') }}</label>
                            <div class="col-xxl-8">
                                <select name="district_id" id="district_id" class="form-control aiz-selectpicker"
                                    onchange="districtWiseUpazilaForSchoolCreate(this.value)">
                                    <option value="">Select District</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="upazila_id" class="col-xxl-4 col-form-label">{{ translate('Upazila') }}</label>
                            <div class="col-xxl-8">
                                <select name="upazila_id" id="upazila_id" class="form-control aiz-selectpicker">
                                    <option value="">Select Upazila</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="container">
                            <div class="row">
                                @foreach($domains as $domain)
                                    <div class="col-md-3 my-1">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="org_domains[]"
                                                id="org_domain_{{$domain->id}}" value="{{$domain->id}}">
                                            <label class="form-check-label"
                                                for="org_domain_{{$domain->id}}">{{$domain->name}}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 d-flex justify-content-end align-items-end">
                        <div class="form-group row">
                            <div class="col-xxl-12 text-left">
                                <button type="submit" class="btn btn-primary">{{ translate('Filter') }}</button>
                                <button class="btn btn-md btn-info mr-2" onclick="printDiv()"
                                    type="button">{{ translate('Print') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div class="card-body printArea">
            <div class="row pb-3 align-items-center">
                <div class="col-md-3">
                    @if(get_setting('system_logo_white') != null)
                        <img src="{{ uploaded_asset(get_setting('system_logo_white')) }}" class="brand-icon"
                            alt="{{ get_setting('site_name') }}" style="width: 60px;">
                    @else
                        <img src="{{ static_asset('assets/img/logo.png') }}" class="brand-icon"
                            alt="{{ get_setting('site_name') }}" style="width: 60px;">
                    @endif
                </div>
                <div class="col-md-6 text-center">
                    <h4><strong class="">Youth Organization</strong><br></h4>
                </div>
                <div class="col-md-3 text-right">
                    <div class="pull-right">
                        <b>
                            <label class="font-weight-600 mb-0">{{ translate('date') }}</label> : {{ date('d/m/Y') }}
                        </b>
                    </div>
                </div>
            </div>

            <div class="row pb-3 voucher-center align-items-center">
                <div class="col-md-12 text-center">
                    <strong><u class="pt-4">{{ translate('Organization List Report') }}</u></strong>
                </div>
            </div>

            <div class="table-responsive">
                <table class="datatable table table-striped table-hover" cellpadding="6" cellspacing="1">
                    <thead>
                        <tr>
                            <th>{{ translate('SL') }}</th>
                            <th>{{ translate('Name') }}</th>
                            <th>{{ translate('Email') }}</th>
                            <th>{{ translate('Phone') }}</th>
                            <th>{{ translate('Division') }}</th>
                            <th>{{ translate('District') }}</th>
                            <th>{{ translate('Upazila') }}</th>
                            <th>{{ translate('President Name') }}</th>
                            <th>{{ translate('Approved By') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($organization as $org)
                                            <tr>
                                                <td>1</td>
                                                <td>{{ $org->org_name_en }}</td>
                                                <td>{{ $org->email }}</td>
                                                <td>{{ $org->phone }}</td>
                                                <td>@php
                                                    $division = App\Models\Division::where('id', $org->division_id)->first();
                                                @endphp
                                                    {{ $division->name }}
                                                </td>
                                                <td>@php
                                                    $district = App\Models\District::where('id', $org->district_id)->first();
                                                @endphp
                                                    {{ $district->name }}
                                                </td>
                                                <td>@php
                                                    $upazila = App\Models\Upazila::where('id', $org->upazila_id)->first();
                                                @endphp
                                                    {{ $upazila->name }}
                                                </td>
                                                <td>{{ $org->name_en }}</td>
                                                <td>@if($org->approvedBy)
                                                    {{ $org->approvedBy->name }}
                                                @else
                                                    'N/A'
                                                @endif
                                                </td>
                                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('script')

    <script type="text/javascript">
        function printDiv() {
            var printContents = document.querySelector('.printArea').innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }

        function countryWiseDivisionForSchoolCreate(country_id) {
            $.ajax({
                type: "GET",
                url: "{{ route('country-wise-division', '') }}/" + country_id,
                success: function (response) {
                    $('#division_id').html(response);
                }
            });
        }

        function divisionWiseDistrictForSchoolCreate(division_id) {
            $.ajax({
                type: "GET",
                url: "{{ route('division-wise-district', '') }}/" + division_id,
                success: function (response) {
                    $('#district_id').html(response);

                }
            });
        }

        function districtWiseUpazilaForSchoolCreate(district_id) {
            $.ajax({
                type: "GET",
                url: "{{ route('district-wise-upazila', '') }}/" + district_id,
                success: function (response) {
                    $('#upazila_id').html(response);
                }
            });
        }
    </script>

@endsection