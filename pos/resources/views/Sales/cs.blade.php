@extends('layouts.dashboard')
@section('content')
@can('View Customer-Management')
<div class="card" style="padding:15px">
    <input type="text" id="myInput" class="form-control" placeholder="search ....." onkeyup="search()"><br>
    <table class="table table-hover" id="myTable">
        <tr>
            <th>Date</th>
            <th><strong>BillNo</strong></th>
            <th><strong>Branch</strong></th>
            <th><strong>Cashier</strong></th>
            <th><strong>Customer Name</strong></th>
            <th><strong>Phone Number</strong></th>
            <th><strong>Product & Quantity</strong></th>
            <th>Discount</th>
            <th><strong>Amount</strong></th>
            <!-- <th><strong>Discount</strong></th> -->
            <!-- <th><strong>JournalNo</strong></th> -->   
        </tr>
        @foreach($cs as $s)
        @if(($s->branch == Auth::user()->branch) && ($s->amount != 0))
            <tr>
                <td><?php echo date('d-m-Y', strtotime($s->created_at)); ?></td>
                <td>{{ $s->billno }}</td>
                <td id="branchname">{{ $s->branch }}</td>
                <td>{{ $s->cashier }}</td>
                <td>{{ $s->name }}</td>
                <td>{{ $s->phoneno }}</td>
                <?php $product = explode('---', $s->productQuantity);  ?>
                <td>
                    <?php 
                        $counter = 0;
                        for ($i=0; $i < count($product)-2; $i++) { 
                            $details = explode('**',$product[$i]);
                            $barcode = strval($details[0]);
                            $qty = $details[1];
                            $discountper = ($s->discount/($s->discount + $s->amount) * 100);
                            $counter = $counter + 1;
                            ?><br>
                            <center><p><a onclick="getdata('{{ $s->id }}','{{ $barcode }}','{{ $discountper }}', '{{ $qty }}')" style="cursor:pointer"><i class="mdi mdi-eye"></i></a> &nbsp &nbsp<span style="background-color: #FDF5CA; border-radius: 55px; padding:3px"><small>&nbsp {{ $qty }}</small></span></p><br></center>
                        <?php
                        }
                    ?>
                </td>
                <td>{{ $s->discount }}</td>
                <td><strong>Nu. {{ $s->amount }}</strong></td>
            </tr>
        @endif
        @endforeach
    </table>
</div>

<script>
    function search() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            td1 = tr[i].getElementsByTagName("td")[1];
            td2 = tr[i].getElementsByTagName("td")[5];
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
        function getdata(id,barcode,discount,qty){
            $.ajax({
              url: "details"+"/"+barcode,
              type:"GET",
              success: function(res) {
                var discountamount = (parseInt(discount)/100) * (res.selling_price * qty);
                var amount = ((res.selling_price * qty) - discountamount);
                swal({
                title: res.name,
                text: "Nu."+ amount +" /-",
                buttons: {
                    cancel: "cancel",
                    confirm: "Refund"
                },
                }).then((Refund) => {
                if (Refund) {
                    var branch = $("#branchname").text();
                    var product = id + "_" +barcode + "**" +qty+"---" +"&"+amount +"!"+discountamount + "@" + branch;
                    $.ajax({
                    url: "refund/"+product,
                    success: function(res){
                        location.reload();
                        // console.log(res)
                    },
                    });
                    }
                })
              },
              error: function(error) {
                  console.log(error)
            }
          });
        }
</script>
@endcan
@endsection
