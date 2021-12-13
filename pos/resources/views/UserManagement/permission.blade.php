@extends('layouts.dashboard')
@section('content')

    <div>
        <form action="/permissions" method="post">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <input type="text" name="permission_name" class="form-control" placeholder="permission_name">
                    <hr>
                    <input type="radio" name="type" value="view"> View
                    <input type="radio" name="type" value="create"> create
                    <input type="radio" name="type" value="edit"> Edit
                    <input type="radio" name="type" value="delete"> delete
                    <button type="submit" class="btn btn-success">
                        Submit
                    </button>
                </div>
            </div>



        </form>
    </div>
@endsection
