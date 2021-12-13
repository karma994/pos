@extends('layouts.dashboard')
@section('content')
@can('View Department') 

    <div class="card" style="padding: 15px">
        <div id="departmentModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <strong>Add Department</strong>
                        </h5>
                        <button type="button" onclick="resetModel()" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form action="/departments" method="post">
                            @csrf
                            <div class="col-md-12">
                                <input type="text" id="name" onkeyup="validatedepartmentname()" name="name" placeholder="Branch name" class="form-control" required>
                                 
                                <small id="departmentname" style="color:red;margin-top: 0px;" hidden>Department name already in use</small>
                            </div>
                            
                            <br>
                            <div class="modal-footer">
                                <input type="submit"  id="submitbtn" name="" class="btn btn-success"  style="color: whitesmoke">
                                <button type="button"  onclick="resetModel()" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <table class="table table-hover">
            <thead style="background-color: #E8F6EF">
            <tr>
                <td><strong>Department Name</strong></td>
                <td><strong>Action</strong></td>
            </tr>
            </thead>
            <tbody>
            @foreach($departments as $department)
                <tr>
                    <td>{{ $department->name }}</td>
                    <td>
                    @can('Edit Department')  
                    <a class="btn btn-xs btn-success" onclick="edit({{ $department }})">
                        <i class="mdi mdi-table-edit"></i>
                    </a>
                    @endcan
                    @can('Delete Department')
                    <a class="btn btn-xs btn-danger" onclick="deleteData({{ $department }})">
                        <i class="mdi mdi-delete-empty"></i>
                    </a>
                    @endcan
                </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @can('Create Department')
        <button type="button" class="floatingButton" data-toggle="modal" data-target="#departmentModal">&nbsp<i class="mdi mdi-plus menu-icon">&nbsp</i></button>
        @endcan
    </div>
    <script>
        function resetModel(){
            $("#name").val('');
        }
        function edit(data){
        $('#departmentModal').modal('show');
        $("#id").val(data.id);
        $("#name").val(data.name);
    }
    function deleteData(department){
        let url = "{{ url('deletedepartment/:id') }}";
        url = url.replace(':id', department.id);
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
                swal("Department deleted successfully.", {
                  icon: "success",
                });
              }
            });
    }
    function validatedepartmentname(){
        var name = $('#name').val();
        $.ajax({
                url: "checkdepartmentname/"+name,
                type:"GET",
                success: function(res) {
                    console.log(res);
                    console.log(res=='yes');
                    if(res=="yes"){
                        console.log('checking')
                        if ($( "#name" ).hasClass('is-invalid')) {
	
                        } else {
                        $( "#name" ).addClass( 'is-invalid');
                        } 
                        $('#departmentname').removeAttr('hidden');
                        document.getElementById("submitbtn").disabled = true;
                    }
                    else{
                        document.getElementById("submitbtn").disabled = false;
                        $( "#name" ).removeClass( 'is-invalid');
                        $('#departmentname').attr('hidden',true);
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

