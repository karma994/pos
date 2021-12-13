@extends('layouts.dashboard')
@section('content')
@can('View Products')
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            #barcode_generate {
                visibility: visible;
                height: 100px;
                position: absolute;
                left: 0;
                top: 0;
            }
        }
    </style>
    <div class="card" style="padding: 15px">
        <div id="productModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-xl">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <strong>Add Product</strong>
                        </h5>
                        <button type="button" onclick="resetModel()" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form action="/stocks" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" id="id" name="id" hidden>
                                    <input type="text" name="name" id="name" placeholder="Item name" class="form-control"
                                        required><br>
                                        <select name="category" id="category" class="form-control" required>
                                            <option>----- Select Category ----</option>

                                            @foreach($categories as $category)
                                                <option value="{{ $category->name }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select><br>
                                        <input type="text" name="quantity" id="quantity" placeholder="Quantity"
                                       class="form-control" required><br>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="cost_price" id="cost_price" placeholder="Cost Price"
                                       class="form-control" required><br>
                                    <select name="branch" id="branch" class="form-control" required>
                                        <option>----- Select Branch ----</option>
                                        @foreach($branches as $branch)
                                            <option value="{{ $branch->name }}">{{ $branch->name }}</option>
                                        @endforeach
                                    </select><br>
                                    <input type="text" name="barcode" id="barcode" class="form-control"
                                               placeholder="Barcode |!|||!||!||!|">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="selling_price" id="selling_price" placeholder="Selling Price"
                                        class="form-control" required><br>
                                    <select name="unit_of_measurement" id="unit_of_measurement" class="form-control" required>
                                        <option>---- Select Unit of Measurement ----</option>
                                        @foreach($uoms as $uom)
                                            <option value="{{ $uom->name }}">{{ $uom->name }}</option>
                                        @endforeach
                                    </select><br>
                                    <input type="button" onclick="generateBarcode()"
                                                class="btn btn btn-outline-success" value="Generate New Barcode">
                                </div>
                                <br>
                            </div>
                            <div id="svgbarcode" hidden style="padding: 15px">
                                   <center><img id="barcode_generate">
                                        <br>
                                        <input type="button" class="btn btn-outline-danger" value="Print Barcode"
                                               onclick="printBarcode()"></center>     
                            </div>
                            <br>
                            <br>
                            <div class="modal-footer">
                                <input type="submit" name="" class="btn btn-success" style="color: whitesmoke">
                                <button type="button" onclick="resetModel()" class="btn btn-danger"
                                        data-dismiss="modal">Close
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <input type="text" class="form-control"  id="myInput" onkeyup="search()" placeholder="Search products..">
        <br>
        <table class="table table-hover" id="myTable">
            <thead style="background-color: #E8F6EF">
            <tr>
                <th><strong></strong></th>
                <th><strong>Particulars</strong></th>
                <th><strong>Quantity</strong></th>
                <th><strong>Cost Price</strong></th>
                <th><strong>Selling Price</strong></th>
                <th><strong>Barcode</strong></th>
                <th><strong>Branch</strong></th>
                <th><strong>Remarks</strong></th>
                <th><strong></strong></th>
            </tr>
            </thead>
            <tbody>
            @foreach($stocks as $product)
                <tr>
                    <td>
                        @can('Edit Products')
                        <a class="text-primary" style="cursor:pointer" onclick="edit({{ $product }})"><i class="mdi mdi-eye menu-icon"></i></a>
                        @endcan
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>{{ $product->cost_price }}</td>
                    <td>{{ $product->selling_price }}</td>
                    <td>{{ $product->barcode }}</td>
                    <td>{{ $product->branch }}</td>
                    @if($product->quantity == 0)
                    <td class="text-danger">Out of Stock</td>
                    @else
                    <td class="text-primary" >Available</td>
                    @endif
                    <td>
                        @can('Delete Products')
                        <a onclick="deletedata({{ $product }})" class="text-danger" style="cursor:pointer"><i class="mdi mdi-delete-empty"></i></a>
                        @endcan
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @can('Create Products')
            <button type="button" class="floatingButton" data-toggle="modal" data-target="#productModal">&nbsp<i
                class="mdi mdi-plus menu-icon">&nbsp</i></button>
        @endcan
    </div>
    <script type="text/javascript"
            src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.3/dist/JsBarcode.all.min.js"></script>
    <script>
        function resetModel() {
            $("#name").val('');
            $("#quantity").val('');
            $("#category").val('');
            $("#cost_price").val('');
            $("#unit_of_measurement").val('');
            $("#selling_price").val('');
            $("#barcode").val('');
            $("#branch").val('');
        }
        function edit(data){
            $('#productModal').modal('show')
            $("#name").val(data.name);
            $("#quantity").val(data.quantity);
            $("#category").val(data.category);
            $("#cost_price").val(data.cost_price);
            $("#selling_price").val(data.selling_price);
            $("#barcode").val(data.barcode);
            $("#branch").val(data.branch);
            $("#unit_of_measurement").val(data.unit_of_measurement);
            $('#id').val(data.id);
        }
        function deletedata(stock){
            let url = "{{ url('deletestock/:id') }}";
            url = url.replace(':id', stock.id);
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
                    swal("Product deleted successfully.", {
                    icon: "success",
                    });
                }
                });
        }
        function generateBarcode() {
            var barcodeValue = uuid();
            document.getElementById('barcode').value = barcodeValue;
            document.getElementById('barcode').dispatchEvent(new Event("input"));
            // document.getElementById('barcode').setAttribute('disabled', 'true');
            document.getElementById('svgbarcode').hidden = false;
            JsBarcode("#barcode_generate", barcodeValue, {
                format: "code128",
                displayValue: true,
                lineColor: "#24292e",
                width: 1.5,
                height: 40,
                fontSize: 20
            });
        }

        function uuid() {
            var dt = new Date().getTime();
            var uuid = 'xxx-xx-4xxx-yx-xxx'.replace(/[xy]/g, function (c) {
                var r = (dt + Math.random() * 16) % 16 | 0;
                dt = Math.floor(dt / 16);
                return (c == 'x' ? r : (r & 0x3 | 0x8)).toString(16);
            });
            return uuid;
        }

        function printBarcode() {
            window.print();
        }
        function search() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];
            td1 = tr[i].getElementsByTagName("td")[5];
            td2 = tr[i].getElementsByTagName("td")[7];
            if (td) {
                txtValue = td.textContent || td.innerText;
                txtValue1 = td1.textContent || td1.innerText;
                txtValue2 = td2.textContent || td2.innerText;
                if ((txtValue.toUpperCase().indexOf(filter) > -1) || (txtValue1.toUpperCase().indexOf(filter) > -1) || (txtValue2.toUpperCase().indexOf(filter) > -1)) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }       
        }
        }
    </script>
@endcan
@endsection
