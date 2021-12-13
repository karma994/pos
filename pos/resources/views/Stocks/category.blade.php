@extends('layouts.dashboard')
@section('content')
@can('View Category')
<div class="card" style="padding: 15px">
    <div id="categoryModal" class="modal fade" role="dialog">
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
                    <form action="/categories" method="post">
                        @csrf
                        <div class="col-md-12">
                             
                            <input type="text" name="category_name"  onkeyup="validatecatname()" id="name" placeholder="Category name" class="form-control" required>
                            <small id="categoryname" style="color:red;margin-top: 0px;" hidden>Category name already in use</small>
                        </div>
                        <br>
                        <br>
                        <div class="modal-footer">
                            <input type="submit" id="submitbtn" name="" class="btn btn-success"  style="color: whitesmoke">
                            <button type="button" onclick="resetModel()" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <table class="table table-hover">
        <thead style="background-color: #E8F6EF">
        <tr>
            <td></td>
            <td><strong>Category</strong></td>
            <td><strong>Action</strong></td>
        </tr>
        </thead>
        <tbody>
        @foreach($categories as $category)
            <tr>
            <td>
                @can('Edit Category')
                <a onclick="edit({{ $category }})" class="text-primary" style="cursor:pointer"><i class="mdi mdi-table-edit"></i></a>
                @endcan
            </td>
            <td>{{ $category->name }}</td>
            <td>
                @can('Delete Category')
                <a onclick="deletedata({{ $category }})" class="text-danger" style="cursor:pointer"><i class="mdi mdi-delete-empty"></i></a>
                @endcan
            </td>    
            </tr>
        @endforeach
        </tbody>
    </table>
    @can('Create Category')
    <button type="button" class="floatingButton" data-toggle="modal" data-target="#categoryModal">&nbsp<i class="mdi mdi-plus menu-icon">&nbsp</i></button>
    @endcan
</div>
<script>
    function resetModel(){
        $("#name").val('');
    }
    function edit(data){
            $('#categoryModal').modal('show')
            $('#name').val(data.name)
            $('#id').val(data.id)
        }
        function deletedata(category){
        let url = "{{ url('deletecategory/:id') }}";
        url = url.replace(':id', category.id);
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
                swal("Category deleted successfully.", {
                  icon: "success",
                });
              }
            });
    }

    function validatecatname(){
        var name = $('#name').val();
        $.ajax({
                url: "checkcatname/"+name,
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
                        $('#categoryname').removeAttr('hidden');
                        document.getElementById("submitbtn").disabled = true;
                    }
                    else{
                        document.getElementById("submitbtn").disabled = false;
                        $( "#name" ).removeClass( 'is-invalid');
                        $('#categoryname').attr('hidden',true);
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
