@extends('layouts.dashboard')
@section('content')
@can('View Role')
    <div>
        <form action="/roles" method="post">
            @csrf
            <div class="card" style="padding: 25px">
                <div class="row">
                    <div class="col-md-8 border border-success">
                        <br>
                        <div class="row">
                            <div class="col-md-3">
                            @can('Create Role')
                                <input type="text" name="role_name" class="form-control" placeholder="Role Name">
                            @endcan
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-3" style="padding: 15px">
                                <strong>Create</strong><br>
                                <hr>
                                @foreach($permissions as $permission)
                                    @if($permission->type == "create")
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}">&nbsp {{ $permission->name }}
                                        <br>
                                    @endif
                                @endforeach
                            </div>
                            <div class="col-md-3" style="padding: 15px">
                                <strong>View</strong><br>
                                <hr>
                                @foreach($permissions as $permission)
                                    @if($permission->type == "view")
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}">&nbsp {{ $permission->name }}
                                        <br>
                                    @endif
                                @endforeach
                            </div>
                            <div class="col-md-3" style="padding: 15px">
                                <strong>Edit</strong><br>
                                <hr>
                                @foreach($permissions as $permission)
                                    @if($permission->type == "edit")
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}">&nbsp {{ $permission->name }}
                                        <br>
                                    @endif
                                @endforeach
                            </div>
                            <div class="col-md-3" style="padding: 15px">
                                <strong>Delete</strong><br>
                                <hr>
                                @foreach($permissions as $permission)
                                    @if($permission->type == "delete")
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}">&nbsp {{ $permission->name }}
                                        <br>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-2">
                            @can('Create Role')
                                <button type="submit" class="btn btn-success">
                                    <a style="color: whitesmoke">Create Role</a>
                                </button>
                            @endcan
                            </div>
                        </div>
                        <br>
                    </div>
                    <div class="col-md-4">
                        <div class="border border-dark" style="padding: 15px">
                            <br>
                            <center>
                                <strong style="letter-spacing: 5px">ROLE</strong>
                                <hr>
                            </center>
                                <ul>
                                    @foreach($roles as $role)
                                        <div class="row">
                                            <div class="col-md-8">
                                                <li>{{ $role->name }} &nbsp &nbsp </li>
                                            </div>
                                            @can('Delete Role')
                                            <a style="cursor:pointer;" class="danger"onclick="deleteData({{ $role }})">
                                                <i class="mdi mdi-delete"></i>
                                            </a>
                                            @endcan
                                        </div>
                                    @endforeach
                                </ul>

                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script>
    function deleteData(role){
        let url = "{{ url('deleterole/:id') }}";
        url = url.replace(':id', role.id);
        // document.location.href=url;
        swal({
              title: "Are you sure?",
              text: "You won't be able to revert this!",
              icon: "warning",
              buttons: true,
              dangerMode: true,
            })
            .then((willDelete) => {
              if (willDelete) {
                document.location.href=url;
                swal("Role deleted successfully.", {
                  icon: "success",
                });
              }
            });
    }
    </script>
@endcan
@endsection
