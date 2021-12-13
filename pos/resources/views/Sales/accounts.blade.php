@extends('layouts.dashboard')
@section('content')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    
@php
  $amount = 0;
  for($i=0; $i<count($cs); $i++){
    $amount = $amount + $cs[$i]->amount;
  }
  $number
@endphp
<div class="card" style="padding: 15px;">
    <div class="row">
        <div class="col-md-3">
            <!-- <p>From: </p> -->
            
            <input type="date" value="from" class="form-control" id="sdate" style="width: 200px; "><br>
                        
        </div>
        <div class="col-md-3">
            <!-- <p>To: </p> -->
            <input type="date" class="form-control" id="sdate" style="width: 200px;"><br>
                        
        </div>


        <div class="col-md-3" >
        <select id="sbranch" class="form-control" style="padding:15px;width: 200px;" >
            <option value="">-----Select Branch-------</option>
            @foreach($branches as $b)
                <option value="{{ $b->name }}">{{ $b->name }}</option>    
            @endforeach
        </select><br>
        </div>
        <!-- <div class="col-md-3">
        
           </div> -->
        <div class="col-md-3">
            <br>
            <center>
                <a class="dropdown-item" id="btnExport" value="Export" onclick="Export()" style="cursor:pointer; width: 200px; ">
                    <i class="mdi mdi-file-pdf text-primary" ></i>
                    Dowload Report
                </a><br>
            </center><br>
        </div>
    </div>
    
    <table class="table" id="myTable">
        <tr>
            <th>Date</th>
            <th>Invoice No</th>
            <th>Branch</th>
            <th>Cashier</th>
            <th>Journal No</th>
            <th>Amount</th>
        </tr>
        @foreach($cs as $s)
        @if($s->amount != 0)
        <tr>
            <td><?php echo date('20y-m-d', strtotime($s->created_at)); ?></td>
            
            <td>{{ $s->billno }}</td>
            <td>{{ $s->branch }}</td>
            <td>{{ $s->cashier }}</td>
            <td>
                @if($s->journalno == "")
                ------ cash ------
                @else
                {{ $s->journalno }}
                @endif
            </td>
            <td>{{ $s->amount }}</td>
        </tr>
        @endif
        @endforeach
        <tr>
            <th><strong>Total Amount: </strong></th>
            <th></th>
            <th></th>
            <th></th>
            <th></td>
            <th>
                <strong>Nu.<span id="amount"><?php echo number_format($amount) ?></span> </strong>
            </th>
        </tr>
    </table>
</div>
<script>
    function Export() {
        var date = $('#sdate').val();
        var branch = $('#sbranch').val();
        html2canvas(document.getElementById('myTable'), {
            onrendered: function (canvas) {
                var data = canvas.toDataURL();
                var docDefinition = {
                    content: [{
                        image: data,
                        width: 500
                    }]
                };
                if(date == "" && branch == ""){
                    pdfMake.createPdf(docDefinition).download("OverallReport.pdf");   
                }
                else{
                    if(branch == "" && date !=""){
                        pdfMake.createPdf(docDefinition).download(date+".pdf");
                    }
                    if(date == "" && branch != ""){
                        pdfMake.createPdf(docDefinition).download(branch+".pdf");
                    }
                    if(date != "" && branch != ""){
                        pdfMake.createPdf(docDefinition).download(date+"_"+branch+".pdf");
                    }
                    
                }
            }
        });
    }
    function search(date) {
            var filter, table, tr, td, i, txtValue;
            var tamt = 0;
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                td1 = tr[i].getElementsByTagName("td")[5];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    txtValue1 = td1.textContent || td1.innerText;
                    if (txtValue.indexOf(date) > -1) {
                        tr[i].style.display = "";
                        tamt = tamt + parseFloat(txtValue1);
                    } else {
                        tr[i].style.display = "none";
                    }
                }       
            }
            $('#amount').text(tamt.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","))
        }
        $('#sdate').change(function() {
            var date = $(this).val();
            search(date);
            $('#sbranch').val("")
        });
        
        $('#sbranch').change(function() {
            var sbranch = $(this).val();
            var date = $('#sdate').val();
            var filter, table, tr, td, i, txtValue;
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");
            var tamt = 0;
            if(date == ""){
                for (i = 0; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName("td")[2];
                    tdamount = tr[i].getElementsByTagName("td")[5];
                    if (td) {
                        txtValue = td.innerText;
                        amount = tdamount.textContent;
                        if (txtValue == sbranch) {
                            tr[i].style.display = "";
                            tamt = tamt + parseFloat(amount);
                        } else {
                            tr[i].style.display = "none";
                        }
                    }       
                }
                $('#amount').text(tamt.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","))
            }
            else{
                for (i = 0; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName("td")[2];
                    tdamount = tr[i].getElementsByTagName("td")[5];
                    tddate = tr[i].getElementsByTagName("td")[0];
                    if (td) {
                        txtValue = td.innerText;
                        amount = tdamount.textContent;
                        datefromtdd = tddate.textContent;
                        if ((txtValue == sbranch) && (datefromtdd == date)) {
                            tr[i].style.display = "";
                            tamt = tamt + parseFloat(amount);
                        } else {
                            tr[i].style.display = "none";
                        }
                    }       
                }
                $('#amount').text(tamt.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","))
            }
            
        });
       
</script>
@endsection