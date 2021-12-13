@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="/register">
                        @csrf
                        <input type="text" class="form-control" placeholder="Username" name="name"> <br>
                        <input type="email " class="form-control" placeholder="Email" name="email"><br>
                        <input type="text" class="form-control" placeholder="Password" name="password"><br>
                        <input type="text" class="form-control" placeholder="Employee Code" name="employee_code"><br>
                        <input type="text" class="form-control" placeholder="branch" name="branch"><br>
                        <input type="text" class="form-control" placeholder="department" name="department"><br>
                        <input type="text" class="form-control" placeholder="status" name="status"><br>
                        <input type="text" class="form-control" placeholder="cid" name="cid"><br>
                        <input type="text" class="form-control" placeholder="contact_no" name="contact_no"><br>
                        <input type="date" class="form-control" placeholder="date_of_join" name="date_of_join"><br>
                        <input type="date" class="form-control" placeholder="resign_date" name="resign_date"><br>
                        <button type="submit" class="btn-primary">
                            Submit
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
