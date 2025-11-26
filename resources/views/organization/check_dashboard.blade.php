@extends('organization.layouts.app')

@section('panel_content')

<div class="row mt-5 justify-content-center">
    <div class="col-md-6">
        <style>
            .card {
                background: rgba(255, 255, 255, 0.1);
                /* Transparent white */
                backdrop-filter: blur(4px);
                /* Blurred background effect */
                -webkit-backdrop-filter: blur(4px);
                /* For Safari */
                border-radius: 10px;
                padding: 20px;
                box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            }

            .card-header {
                font-weight: 600;
                text-align: center;
                color: white;
            }

            .reg-box {
                display: flex;
                justify-content: center;
                gap: 15px;
            }

            .reg-option {
                width: 200px;
                padding: 10px;
                text-align: center;
                border-radius: 10px;
                cursor: pointer;
                transition: all 0.3s ease-in-out;
                border: 2px solid transparent;
                font-weight: bold;
                font-size: 18px;
                position: relative;
                line-height: 1.4;
            }

            .reg-option input {
                display: none;
            }

            .reg-option label {
                display: block;
                width: 100%;
                height: 100%;
                cursor: pointer;
                padding: 9px;
                border-radius: 10px;
                word-wrap: break-word;
            }

            /* New Organization (Blue Gradient) */
            .reg-option.registered {
                background: linear-gradient(60deg, #2e294e, rgba(46, 41, 78, 0.88));
                color: white;
            }

            /* Already Registered (Gold Gradient) */
            .reg-option.new {
                background: linear-gradient(60deg, #0abb75, rgba(10, 187, 116, 0.88));
                color: white;
            }

            /* Hover Effects */
            .reg-option:hover {
                opacity: 0.9;
            }

            /* Selected Effect */
            .reg-option label {
                margin-bottom: auto;
                border: 3px solid rgba(0, 0, 0, 0);
            }

            .reg-option input:checked+label {
                border: 3px solid #fff;
                box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            }
        </style>

        <div class="card mt-5">
            <h4 class="card-header text-dark justify-content-center">Select Registration Type</h4>
            <div class="card-body">
                <form method="POST" action="{{ route('organization.register.selection') }}">
                    @csrf
                    <div class="mb-3">
                        <div class="reg-box">
                            <div class="reg-option new">
                                <input type="radio" name="reg_type" value="new" id="new" required>
                                <label for="new"> New Organization</label>
                            </div>

                            <div class="reg-option registered">
                                <input type="radio" name="reg_type" value="registered" id="registered" required>
                                <label for="registered">Already Registered</label>
                            </div>
                        </div>
                        @error('reg_type')
                        <div class="text-danger text-center mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mt-3" style="font-size: 20px; font-weight: bold;">
                        Continue
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
</div>
@endsection