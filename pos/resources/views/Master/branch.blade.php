
@extends('layouts.dashboard')
@section('content')
@can('View Branch')
<div class="card" style="padding: 15px">
    <div id="branchModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <strong>Add Branch</strong>
                    </h5>
                    <button type="button" onclick="resetModel()" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="/branches" method="post">
                        @csrf
                        <div class="col-md-12">
                            <input type="text"  onkeyup="validatebranchname()" name="name" id="name" placeholder="Branch name" class="form-control" required>
                            <small id="branchname" style="color:red;margin-top: 0px;" hidden>Branch name already in use</small>
                        </div>
                        <br>
                        <div class="col-md-12">
                            <input type="text" id="contact" class="form-control" name="contact" placeholder="Contact Number" required>
                        </div>
                        <input type="text" id="id" name="id" hidden>
                        <br>
                        <div class="modal-footer">
                            <input type="submit" id="submitbtn" name="" class="btn btn-success"  style="color: whitesmoke">
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
               <td><strong>Branch Name</strong></td>
               <td><strong>Contact Number</strong></td>
               <td><strong>Action</strong></td>
           </tr>
       </thead>
        <tbody>
        @foreach($branches as $branch)
            <tr>
                <td>{{ $branch->name }}</td>
                <td>{{ $branch->contact }}</td>
                <td>
                @can('Edit Branch')
                    <a class="btn btn-xs btn-success" onclick="edit({{ $branch }})">
                        <i class="mdi mdi-table-edit"></i>
                    </a>
                @endcan
                @can('Delete Branch')
                    <a class="btn btn-xs btn-danger" onclick="deleteData({{ $branch }})">
                        <i class="mdi mdi-delete-empty"></i>
                    </a>
                @endcan
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @can('Create Branch')
    <button type="button" class="floatingButton" data-toggle="modal" data-target="#branchModal">&nbsp<i class="mdi mdi-plus menu-icon">&nbsp</i></button>
    @endcan
</div>
<script>
    function resetModel(){
        $("#name").val('');
        $("#contact").val('');
    }
    function edit(data){
        $('#branchModal').modal('show');
        $("#id").val(data.id);
        $("#name").val(data.name);
        $("#contact").val(data.contact);
    }
    function deleteData(branch){
        let url = "{{ url('deletebranch/:id') }}";
        url = url.replace(':id', branch.id);
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
                swal("Branch deleted successfully.", {
                  icon: "success",
                });
              }
            });
    }

    function validatebranchname(){
        var name = $('#name').val();
        $.ajax({
                url: "checkbranchname/"+name,
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
                        $('#branchname').removeAttr('hidden');
                        document.getElementById("submitbtn").disabled = true;
                    }
                    else{
                        document.getElementById("submitbtn").disabled = false;
                        $( "#name" ).removeClass( 'is-invalid');
                        $('#branchname').attr('hidden',true);
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

