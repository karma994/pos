@extends('layouts.dashboard')
@section('content')
@can('View User')
    <div class="card">
        <div class="row">
            <div class="col-md-9" style="padding: 25px">
                <div class="border border-success" style="padding: 15px">
                   <input type="text" class="form-control"  id="myInput" onkeyup="search()" placeholder="Search for users..">
                    <table class="table" id="myTable">
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Employee Code</th>
                            <th>Department</th>
                            <th>Branch</th>
                            <th>Action</th>
                        </tr>
                        @foreach($users as $user)
                            <tr>
                                <td>
                                    @can('Edit User')
                                    <center><a class="primary" style="cursor:pointer" onclick="edit({{ $user }})"><i class="mdi mdi-account-edit"></i></a></center>
                                    @endcan
                                </td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->employee_code }}</td>
                                <td>{{ $user->department }}</td>
                                <td>{{ $user->branch }}</td>
                                
                                <td>
                                    @can('Delete User')
                                    <center><a class="text-danger" style="cursor:pointer;" onclick="deletedata({{ $user }})"><i class="mdi mdi-delete"></i></a></center>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            <div class="col-md-3" style="padding: 25px">
                <div class="border border-dark" style="padding: 15px">
                    <center><Strong>New Users</Strong></center>
                    <hr>
                    @foreach($users as $user)
                        <div class="row">
                            <div class="col-md-8">
                                <li>{{ $user->name }}</li>
                            </div>
                        </div>
                    @endforeach
                    <br><br>
                    {!! $users->links() !!}
                </div>
            </div>
        </div>
        <div id="userModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-xl">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <strong>Add User</strong>
                        </h5>
                        <button type="button" onclick="resetModel()" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form action="/users" method="post">
                            @csrf
                            <div class="row" style="padding: 15px">
                                <div class="col-md-6">
                                    <input type="text" name="name" class="form-control" placeholder="Full Name" required id="name"><br>
                                    <input type="text" name="cid" class="form-control" id="cid" placeholder="Citiozenship Identity [ CID ]" required onfocusout="employeecode()"><br>
                                    <select name="gender" class="form-control" required id="gender">
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="others">Others</option>
                                    </select><br>
                                    <select name="role" class="form-control" required id="role">
                                        <option>------ Choose Role ---------</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select><br>
                                    <input type="text" class="form-control" name="contact_no" placeholder="Contact number" required id="contact"><br>
                                </div>
                                <div class="col-md-6">
                                     
                                    <input type="email" name="email" class="form-control" placeholder="E-mail" required id="email"   onfocusout="validateemail()">
                                    <small id="useremail" style="color:red;margin-top: 0px;" hidden>Email is already in use</small><br>
                                    <!-- @if ($errors->has('email'))
                                        <span class="invalid feedback"role="alert">
                                             <strong>{{ $errors->first('email') }}.</strong>
                                        </span>
                                    @endif -->


                                    <input type="text" name="password" class="form-control" placeholder="Password" required id="password"><br>
                                    <select name="branch" class="form-control" required id="branch">
                                        <option>------ Choose branch ---------</option>
                                        @foreach($branches as $branch)
                                            <option value="{{ $branch->name }}">{{ $branch->name }}</option>
                                        @endforeach
                                    </select><br>
                                    <select name="department" class="form-control" required id="department">
                                        <option>------ Choose Department ---------</option>
                                        @foreach($departments as $department)
                                            <option value="{{ $department->name }}">{{ $department->name }}</option>
                                        @endforeach
                                    </select><br>
                                    <input type="date" name="date_of_join" class="form-control" required id="dateofjoin">
                                    <input type="text" name="id" id="id" hidden>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" id="submitbtn" name="" class="btn btn-success"  style="color: whitesmoke">
                        <button type="button" onclick="resetModel()" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        @can('Create User')
        <button type="button" class="floatingButton" data-toggle="modal" data-target="#userModal">&nbsp<i class="mdi mdi-plus menu-icon">&nbsp</i></button>
        @endcan
    </div>
    <script>
        function resetModel(data){
            $('#name').val('')
            $('#email').val('')
            $('#cid').val('')
            $('#password').val('')
            $("#branch").val('')
            $("#department").val('')
            $('#gender').val('')
            $('#role').val('')
            $('#contact').val('')
            $('#dateofjoin').val('')
            $("#id").val('')
        }
        function edit(data){
            $('#userModal').modal('show')
            $('#name').val(data.name)
            $('#email').val(data.email)
            $('#cid').val(data.cid)
            $('#password').val(data.password)
            $("#branch").val(data.branch)
            $("#department").val(data.department)
            $('#gender').val(data.gender)
            $('#role').val(data.role)
            $('#contact').val(data.contact_no)
            $('#dateofjoin').val(data.date_of_join)
            $("#id").val(data.id);
        }
        function deletedata(user){
        let url = "{{ url('deleteuser/:id') }}";
        url = url.replace(':id', user.id);
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
                swal("User deleted successfully.", {
                  icon: "success",
                });
              }
            });
    }
    function search() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[1];
        td1 =  tr[i].getElementsByTagName("td")[2];
        if (td) {
        txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }       
    }
    }

    function validateemail(){
        var email = $('#email').val();
        console.log(email);
        $.ajax({
                url: "checkuser/"+email,
                type:"GET",
                success: function(res) {
                    console.log(res);
                    console.log(res=='yes');
                    if(res=="yes"){
                        console.log('checking')
                        if ($( "#email" ).hasClass('is-invalid')) {
	
                        } else {
                        $( "#email" ).addClass( 'is-invalid');
                        } 
                        $('#useremail').removeAttr('hidden');
                        document.getElementById("submitbtn").disabled = true;
                    }
                    else{
                        document.getElementById("submitbtn").disabled = false;
                        $( "#email" ).removeClass( 'is-invalid');
                        $('#useremail').attr('hidden',true);

                    }
                },
                error: function(error) {
                    console.log(error)
                    
              }
            });
    }
    </script>
@endcan
@endsection
