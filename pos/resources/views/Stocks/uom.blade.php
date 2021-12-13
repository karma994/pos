@extends('layouts.dashboard')
@section('content')
@can('View UOM')
    <div class="card" style="padding: 15px">
        <div id="umoModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <strong>Add Unit of Measurement</strong>
                        </h5>
                        <button type="button" onclick="resetModel()" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form action="/uom" method="post">
                            @csrf
                            <div class="col-md-12">
                                 
                                <input type="text" onkeyup="validateunitname()" name="name" id="name" placeholder="Unit of Measurement" class="form-control" required>
                                <small id="unitname" style="color:red;margin-top: 0px;" hidden>Unit name already in use</small>
                            </div>
                            <br>
                            <br>
                            <div class="modal-footer">
                                <input type="submit" id="submitbtn" name="" class="btn btn-success"  style="color: whitesmoke">
                                <button type="button"  id="submitbtn" onclick="resetModel()" class="btn btn-danger" data-dismiss="modal">Close</button>
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
                <td><strong>Unit of Measurement</strong></td>
                <td><strong></strong></td>
            </tr>
            </thead>
            <tbody>
            @foreach($uoms as $uom)
                <tr>
                    <td>
                        @can('Edit UOM')
                        <a onclick="edit({{ $uom }})" class="text-primary" style="cursor:pointer"><i class="mdi mdi-table-edit"></i></a>
                        @endcan
                    </td>
                    <td>{{ $uom->name }}</td>
                    <td>
                        @can('Delete UOM')
                        <a onclick="deletedata({{ $uom }})" class="text-danger" style="cursor:pointer"><i class="mdi mdi-delete-empty"></i></a>
                        @endcan
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @can('Create UOM')
        <button type="button" class="floatingButton" data-toggle="modal" data-target="#umoModal">&nbsp<i class="mdi mdi-plus menu-icon">&nbsp</i></button>
        @endcan
    </div>
    <script>
        function resetModel(){
            $("#name").val('');
        }
        function edit(data){
            $('#umoModal').modal('show')
            $('#name').val(data.name)
            $('#id').val(data.id)
        }
        function deletedata(umo){
        let url = "{{ url('deleteumo/:id') }}";
        url = url.replace(':id', umo.id);
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
                swal("UOM deleted successfully.", {
                  icon: "success",
                });
              }
            });
    }
    function validateunitname(){
        var name = $('#name').val();
        $.ajax({
                url: "checkunitname/"+name,
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
                        $('#unitname').removeAttr('hidden');
                        document.getElementById("submitbtn").disabled = true;
                    }
                    else{
                        document.getElementById("submitbtn").disabled = false;
                        $( "#name" ).removeClass( 'is-invalid');
                        $('#unitname').attr('hidden',true);
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
