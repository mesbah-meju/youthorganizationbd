<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('24 Bulk SMS Credential') }}</h5>
        </div>
        <div class="card-body">
            <!-- Start of the Form -->
            <form class="form-horizontal" action="{{ route('update_credentials') }}" method="POST">
                <!-- CSRF Token -->
                @csrf
                <!-- Hidden Field for OTP Method -->
                <input type="hidden" name="otp_method" value="bulk24sms">

                <!-- API Key Field -->
                <div class="form-group row">
                    <div class="col-lg-4">
                        <label for="bulk24sms_api_key" class="col-form-label">
                            {{ translate('BULK24SMS_API_KEY') }}
                        </label>
                    </div>
                    <div class="col-lg-8">
                        <input type="text" id="bulk24sms_api_key" class="form-control" name="BULK24SMS_API_KEY"
                            value="{{ env('BULK24SMS_API_KEY') }}" placeholder="Enter BULK24SMS API Key" required>
                        <input type="hidden" name="types[]" value="BULK24SMS_API_KEY">
                    </div>
                </div>

                <!-- Sender ID Field -->
                <div class="form-group row">
                    <div class="col-lg-4">
                        <label for="bulk24sms_sender_id" class="col-form-label">
                            {{ translate('BULK24SMS_SENDER_ID') }}
                        </label>
                    </div>
                    <div class="col-lg-8">
                        <input type="text" id="bulk24sms_sender_id" class="form-control" name="BULK24SMS_SENDER_ID"
                            value="{{ env('BULK24SMS_SENDER_ID') }}" placeholder="Enter BULK24SMS Sender ID" required>
                        <input type="hidden" name="types[]" value="BULK24SMS_SENDER_ID">
                    </div>
                </div>

                <!-- Email ID Field -->
                <div class="form-group row">
                    <div class="col-lg-4">
                        <label for="bulk24sms_email_id" class="col-form-label">
                            {{ translate('BULK24SMS_EMAIL_ID') }}
                        </label>
                    </div>
                    <div class="col-lg-8">
                        <input type="email" id="bulk24sms_email_id" class="form-control" name="BULK24SMS_EMAIL_ID"
                            value="{{ env('BULK24SMS_EMAIL_ID') }}" placeholder="Enter BULK24SMS Email ID" required>
                        <input type="hidden" name="types[]" value="BULK24SMS_EMAIL_ID">
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="form-group mb-0 text-right">
                    <button type="submit" class="btn btn-sm btn-primary">
                        {{ translate('Save') }}
                    </button>
                </div>
            </form>
            <!-- End of the Form -->
        </div>
    </div>
</div>
