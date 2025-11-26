@extends('organization.layouts.app')

@section('panel_content')
<div class="text-center mx-lg-5 mx-md-auto">
    <h4 class="bg-success text-white rounded py-3 px-2 mx-lg-5 mx-md-auto shadow-lg">
        Welcome to Youth Organization Database, Bangladesh
    </h4>
</div>

<div class="container bg-white border shadow rounded px-5 pt-4 my-5 fw-600">
    <h5 class="text-center text-decoration-underlined">ব্যাংকের তথ্য (Bank Details)</h5>
    <form class="pt-4" action="{{ route('organization.banks.store') }}" method="POST">
        @csrf
        <div class="row d-flex">
            <div class="col-md-12 mt-4 d-flex justify-content-center align-items-center">
                <a id="addBankButton" class="btn btn-primary text-white"><i class="las la-plus"></i> Add Bank</a>
            </div>
        </div>

        <div id="bankContainerList">
            @foreach($banks as $index => $bank)
            <div class="row d-flex pb-4 mt-4 rounded border bank-container position-relative">
                <button type="button" class="btn btn-danger btn-sm position-absolute" style="top: -10px; right: -10px;" onclick="this.parentElement.remove()">X</button>

                <div class="col-md-3 mt-4">
                    <label for="bank_name" class="form-label badge badge-danger w-auto">ব্যাংকের নাম (Bank Name)</label>
                    <input type="text" class="form-control" name="bank_name[]" placeholder="ব্যাংকের নাম (Bank Name)" value="{{ old('bank_name.' . $index, $bank->bank_name ?? '') }}" required>
                </div>
                <div class="col-md-3 mt-4">
                    <label for="branch_name" class="form-label">শাখার নাম (Branch Name)</label>
                    <input type="text" class="form-control" name="branch_name[]" placeholder="শাখার নাম (Branch Name)" value="{{ old('branch_name.' . $index, $bank->branch_name ?? '') }}" required>
                </div>
                <div class="col-md-3 mt-4">
                    <label for="account_name" class="form-label">হিসাব নাম (Account Name)</label>
                    <input type="text" class="form-control" name="account_name[]" placeholder="হিসাব নাম (Account Name)" value="{{ old('account_name.' . $index, $bank->account_name ?? '') }}" required>
                </div>
                <div class="col-md-3 mt-4">
                    <label for="account_number" class="form-label">হিসাব নং (Account Number)</label>
                    <input type="text" class="form-control" name="account_number[]" placeholder="হিসাব নম্বর (Account Number)" value="{{ old('account_number.' . $index, $bank->account_number ?? '') }}" required>
                </div>
            </div>
            @endforeach
        </div>

        <div class="row mt-3 justify-content-between">
            <div class="my-3">
                <a class="btn btn-danger" href="{{ route('organization.members.create') }}"> Previous </a>
            </div>
            <div class="my-3">
                <button type="submit" class="btn btn-primary">Save & Go Next</button>
            </div>
        </div>
    </form>
</div>
@endsection

@section('script')
<script>
    document.getElementById('addBankButton').addEventListener('click', function () {
        const bankContainerList = document.getElementById('bankContainerList');
        const newBankRow = document.createElement('div');
        newBankRow.classList.add('row', 'd-flex', 'pb-4', 'mt-4', 'rounded', 'border', 'bank-container', 'position-relative');

        newBankRow.innerHTML = `
            <button type="button" class="btn btn-danger btn-sm position-absolute" style="top: -10px; right: -10px;" onclick="this.parentElement.remove()">X</button>

            <div class="col-md-3 mt-4">
                <label for="bank_name" class="form-label badge badge-danger w-auto">ব্যাংকের নাম (Bank Name)</label>
                <input type="text" class="form-control" name="bank_name[]" placeholder="ব্যাংকের নাম (Bank Name)" required>
            </div>
            <div class="col-md-3 mt-4">
                <label for="branch_name" class="form-label">শাখার নাম (Branch Name)</label>
                <input type="text" class="form-control" name="branch_name[]" placeholder="শাখার নাম (Branch Name)" required>
            </div>
            <div class="col-md-3 mt-4">
                <label for="account_name" class="form-label">হিসাব নাম (Account Name)</label>
                <input type="text" class="form-control" name="account_name[]" placeholder="হিসাব নাম (Account Name)" required>
            </div>
            <div class="col-md-3 mt-4">
                <label for="account_number" class="form-label">হিসাব নং (Account Number)</label>
                <input type="text" class="form-control" name="account_number[]" placeholder="হিসাব নম্বর (Account Number)" required>
            </div>
        `;

        bankContainerList.appendChild(newBankRow);
    });
</script>
@endsection