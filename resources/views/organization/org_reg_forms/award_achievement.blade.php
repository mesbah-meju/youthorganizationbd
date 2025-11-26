@extends('organization.layouts.app')

@section('panel_content')
<div class="text-center mx-lg-5 mx-md-auto">
    <h4 class="bg-success text-white rounded py-3 px-2 mx-lg-5 mx-md-auto shadow-lg">
        Welcome to Youth Organization Database, Bangladesh
    </h4>
</div>

<div class="container border bg-white shadow rounded px-5 pt-4 my-5 fw-600">
    <h5 class="text-center text-decoration-underlined">পুরষ্কার এবং অর্জনসমূহ (Awards & Achievements)</h5>
    <form class="pt-4" action="{{ route('organization.awards.store') }}" method="POST">
        @csrf

        <div id="organizationAwardsList">
            <!-- Initial Award Field -->
            @if($organization_award->isEmpty())
            <div class="row d-flex pb-4 mt-4 rounded border award-container position-relative">
                <button type="button" class="btn btn-danger btn-sm position-absolute" style="top: -10px; right: -10px;" onclick="this.parentElement.remove()">X</button>

                <div class="col-md-3 mt-4">
                    <label for="type" class="form-label">Type</label>
                    <select class="form-control" name="type[]" required>
                        <option value="">Select Type</option>
                        <option value="award">Award</option>
                        <option value="achievement">Achievement</option>
                    </select>
                </div>
                <div class="col-md-3 mt-4">
                    <label for="awardTittle" class="form-label">Award Title</label>
                    <input type="text" class="form-control" name="award_tittle[]" placeholder="Award Title" required>
                </div>
                <div class="col-md-3 mt-4">
                    <label for="fromOrganization" class="form-label">From Organization</label>
                    <input type="text" class="form-control" name="from_organization[]" placeholder="From Organization" required>
                </div>
                <div class="col-md-3 mt-4">
                    <label for="recieveDate" class="form-label">Receive Date</label>
                    <input type="date" class="form-control" name="recieve_date[]" required>
                </div>
            </div>
            @else
            @foreach($organization_award as $index => $award)
            <div class="row d-flex pb-4 mt-4 rounded border award-container position-relative">
                <button type="button" class="btn btn-danger btn-sm position-absolute" style="top: -10px; right: -10px;" onclick="this.parentElement.remove()">X</button>

                <div class="col-md-3 mt-4">
                    <label for="type" class="form-label">Type</label>
                    <select class="form-control" name="type[]" required>
                        <option value="">Select Type</option>
                        <option value="award" {{ $award->type == 'award' ? 'selected' : '' }}>Award</option>
                        <option value="achievement" {{ $award->type == 'achievement' ? 'selected' : '' }}>Achievement</option>
                    </select>
                </div>
                <div class="col-md-3 mt-4">
                    <label for="awardTittle" class="form-label">Award Title</label>
                    <input type="text" class="form-control" name="award_tittle[]" placeholder="Award Title" value="{{ $award->award_tittle }}" required>
                </div>
                <div class="col-md-3 mt-4">
                    <label for="fromOrganization" class="form-label">From Organization</label>
                    <input type="text" class="form-control" name="from_organization[]" placeholder="From Organization" value="{{ $award->from_organization }}" required>
                </div>
                <div class="col-md-3 mt-4">
                    <label for="recieveDate" class="form-label">Receive Date</label>
                    <input type="date" class="form-control" name="recieve_date[]" value="{{ $award->recieve_date }}" required>
                </div>
            </div>
            @endforeach
            @endif
        </div>

        <!-- Add More Button -->
        <div class="row mt-4">
            <div class="col-md-12 d-flex justify-content-end">
                <button type="button" id="addAwardButton" class="btn btn-primary">
                    <i class="las la-plus"></i> Add More
                </button>
            </div>
        </div>

        <div class="row justify-content-between">
            <div class="my-4">
                <a class="btn btn-danger" href="{{ route('organization.activity.create') }}"> Previous </a>
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
    // Add More Awards
    document.getElementById('addAwardButton').addEventListener('click', function () {
        const awardsList = document.getElementById('organizationAwardsList');
        const newAwardRow = document.createElement('div');
        newAwardRow.classList.add('row', 'd-flex', 'pb-4', 'mt-4', 'rounded', 'border', 'award-container', 'position-relative');

        newAwardRow.innerHTML = `
            <button type="button" class="btn btn-danger btn-sm position-absolute" style="top: -10px; right: -10px;" onclick="this.parentElement.remove()">X</button>

            <div class="col-md-3 mt-4">
                <label for="type" class="form-label">Type</label>
                <select class="form-control" name="type[]" required>
                    <option value="">Select Type</option>
                    <option value="award">Award</option>
                    <option value="achievement">Achievement</option>
                </select>
            </div>
            <div class="col-md-3 mt-4">
                <label for="awardTittle" class="form-label">Award Title</label>
                <input type="text" class="form-control" name="award_tittle[]" placeholder="Award Title" required>
            </div>
            <div class="col-md-3 mt-4">
                <label for="fromOrganization" class="form-label">From Organization</label>
                <input type="text" class="form-control" name="from_organization[]" placeholder="From Organization" required>
            </div>
            <div class="col-md-3 mt-4">
                <label for="recieveDate" class="form-label">Receive Date</label>
                <input type="date" class="form-control" name="recieve_date[]" required>
            </div>
        `;

        awardsList.appendChild(newAwardRow);
    });
</script>
@endsection