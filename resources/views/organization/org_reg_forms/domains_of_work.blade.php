@extends('organization.layouts.app')

@section('panel_content')
<div class="text-center mx-lg-5 mx-md-auto">
    <h4 class="bg-success text-white rounded py-3 px-2 mx-lg-5 mx-md-auto shadow-lg">
        Welcome to Youth Organization Database, Bangladesh
    </h4>
</div>

<div class="container border bg-white shadow rounded px-5 pt-4 my-5 fw-600">
    <h5 class="text-center text-decoration-underlined">কাজের ক্ষেত্র সমুহ (Domains Of Work)</h5>
    <form class="pt-4" action="{{ route('organization.domains.store') }}" method="POST">
        @csrf

        <div class="row container my-5 mx-auto">
            @foreach($domains as $domain)
            <div class="col-md-4 my-1">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="org_domains[]" id="org_domain_{{$domain->id}}" value="{{$domain->id}}"
                        @if(in_array($domain->id, $domains_id)) checked @endif>
                    <label class="form-check-label" for="org_domain_{{$domain->id}}">{{$domain->name}}</label>
                </div>
            </div>
            @endforeach
            <!-- Others Option -->
            <div class="col-md-4 my-1">
                <div class="form-check form-switch">
                    <input class="form-check-input" id="org_other" type="checkbox" @if($other) checked @endif>
                    <label class="form-check-label" for="org_other">Others</label>
                </div>
                <div class="my-1" id="other_domain_div" @if(!$other) style="display: none;" @endif>
                    <input type="text" class="form-control" name="other_domain" id="other_domain" placeholder="Enter other domain" value="{{ old('other_domain', $other ?? '') }}">
                </div>
            </div>
        </div>

        <div class="row justify-content-between">
            <div class="my-4">
                @if($check_details && $org_details->reg_type == 'registered')
                <a class="btn btn-danger" href="{{ route('organization.grants.create') }}"> Previous </a>
                @else
                <a class="btn btn-danger" href="{{ route('organization.activity.create') }}"> Previous </a>
                @endif
            </div>
            <div class="my-4">
                <button type="submit" class="btn btn-primary">Save & Go Next</button>
            </div>
        </div>
    </form>
</div>
@endsection

@section('script')
<script>
    document.getElementById('org_other').addEventListener('change', function() {
        let otherDomainDiv = document.getElementById('other_domain_div');
        if (this.checked) {
            otherDomainDiv.style.display = 'block';
        } else {
            otherDomainDiv.style.display = 'none';
        }
    });
</script>
@endsection