@extends('layouts.dashboard')
@section('content')
@can('View Sales')
<link rel="stylesheet" type="text/css" href="extensions/filter-control/bootstrap-table-filter-control.css">
<script src="extensions/filter-control/bootstrap-table-filter-control.js"></script>
 <section class="card" style="padding: 15px">
     <div class="container-fluid">
     <div class="row">
        <div class="col-md-7">
           <div class="card">
            <table class=" table" >
              <tbody>
                 <tr>
                    <td scope="row"><i class="mdi mdi-barcode-scan"></i></td>
                    <td>
                      <input type="text" class="form-control" id="barcode">
                    </td>
                    <td><center><p id="particular">-</p></center></td>
                    <td><center><input type="text" id="qty" min="0" value="1" class="form-control"></center></td>
                    <td><center><h5 class="form-control" id="price" >-</h5></center></td>
                    <td><center><p id="total" class="form-control">-</p></center></td>
                    <td><button id="add" class="btn btn-success" style="color: white">Add</button></td>
                 </tr>
                 <tr>
                 </tr>    
              </tbody>
           </table>
           </div>
           <div role="alert" id="errorMsg" class="mt-5" >
             <!-- Error msg  -->
          </div>
          <div class="card" style="padding: 15px">
            <center><strong>Discount Offer</strong></center><br>
            <div class="input-group-prepend">
              <span class="input-group-text">
                <i class="mdi mdi-percent"></i>
              </span>
               <input type="text" id="discount" class="form-control" placeholder="Dicount">
            </div>
            
            <hr>
            <center><strong>Customer Information</strong></center><hr>
              <div class="row">
                  <div class="col-6">
                    <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="mdi mdi-account"></i>
                          </span>
                          <input type="text" name="name" class="form-control" placeholder="Name" id="fillname">
                    </div><br>
                    <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="mdi mdi-cash-multiple"></i>
                          </span>
                          <select class="form-control" id="paymentType">
                             <option>Cash</option>
                             <option>Online</option>
                        </select><br>
                    </div><br>
                  </div>
                  <div class="col-6">
                     <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="mdi mdi-cellphone-android"></i>
                          </span>
                           <input type="text" name="phone" class="form-control" placeholder="Mobile Number" id="fillphone"><br>
                    </div><br>
                     <div id="journalno">
                         <input type="text" class="form-control" placeholder="Journal Number" id="inputJournal">
                     </div>
                  </div>
              </div>
          </div>
        </div>
        <div class="col-md-5">
            <div id="bill" class="card" style="padding: 15px">
                <div class="row">
                    <div class="col-md-6">
                        <strong><span id="branchname">{{ Auth::user()->branch }}</span><br>
                     PH.#00975-7721234<br>
                    </div>
                    <div class="col-md-6">
                        Cashier: <span id="cashiername">{{ Auth::user()->name }}</span><br>
                        BillNo:<span id="billno"></span></strong>
                    </div>
                </div>
                <hr style="border-style: dashed;">
                 Invoice
                 <hr style="border-style: dashed;">
                 <p>Name: <span id="cname">-</span> </p>
                 <p>PH: <span id="cphone">-</span></p>
                 <p>Payment Mode:<span id="pmode"> Cash</span></p>
                 <p>Journal No: - <span id="cjournalno"></span></p>
                 <hr style="border-style: dashed;">
                <table id="receipt_bill" class="table-responsive">
                <thead>
                   <tr>
                      <th>Particulars &nbsp &nbsp &nbsp</th>
                      <th>Quantity &nbsp &nbsp </th>
                      <th class="text-center"> &nbsp &nbsp &nbspAmount</th>
                   </tr>
                </thead>
                <tbody id="new" >
                </tbody>
                <tr>
                   <td></td>
                   <td></td>
                   <td>
                    <hr style="border-style: dashed;">
                    Gross Amt.:Nu. <span id="grandtotal"></span><br><br>
                    Bill Discount: Nu.<span id="cdiscount"></span>
                    <hr style="border-style: dashed;">
                    <strong>Net Amt.:Nu. <span id="netamount"></span></strong>
                    <hr style="border-style: dashed;">
                    </td>
                </tr>
             </table>
             <hr style="border-style: dashed;">
             <strong>TERMS & CONDITION</strong><br>
             <small>We will accept only exchange with valid recipt for one week after purchase & all item just
             <br>be in its original condition & tag. Exchange can be done for same item ONLY.</small>
             <hr style="border-style: dashed;"><br><br>
            </div>
         <hr>
         <input type="button" class="btn btn-danger" value="print" id="print">
        </div>
     </div>
  </section>
  <script type="text/javascript">
    $('#billno').text("nt"+uuidv4())
    $('#journalno').hide()
    $('#cjournalno').hide()
    $(document).on('keypress',function(e) {
      
       if(e.which == 13) {
           const URL = "details";
            const barcode = $('#barcode').val()
            const quantity = $('#qty').val()
             $.ajax({
                url: URL+"/"+barcode,
                type:"GET",
                success: function(res) {
                    console.log(res)
                    $('#particular').text(res.name)
                    $('#price').text(res.selling_price)
                    $('#total').text(res.selling_price * quantity)
                },
                error: function(error) {
                    console.log(error)
              }
            });
        }
    });
      var grandtotal = 0;
      $('#add').on('click',function(){
         var name = $('#particular').text();
         var qty = $('#qty').val();
         var price = $('#price').text();
         var barcode = $('#barcode').val()
         if(qty == 0 )
         {
            var erroMsg =  '<span class="alert alert-danger ml-5">Minimum Qty should be 1 or More than 1</span>';
            $('#errorMsg').html(erroMsg).fadeOut(5000);
         }
         if (name == "-") {
             var erroMsg =  '<span class="alert alert-danger ml-5"> Scan the barcode to add product </span><br><br><br>';
            $('#errorMsg').html(erroMsg).fadeOut(9000);
         }
         else
         {
            billFunction(); // Below Function passing here 
            $('#barcode').val('')
            $('#particular').text('-')
            $('#price').text('-')
            $('#qty').val(1)
         }
          
         function billFunction()
           {
           var total =  price*qty;
           $("#receipt_bill").each(function () {
           var table =   '<tr></td><td><small>'+ name + '</small></td><td hidden>' + barcode + '</td><td><center><small>' + qty + '</small></center></td><td><input type="hidden" id="total" value="'+total+'"><center><small>' +total+ '</small></center><small></td></tr>';

           $('#new').append(table)
         
          });
          grandtotal = grandtotal + total;
         } 
         // Code for Total Payment Amount
            $('#grandtotal').text(grandtotal);
            const discountPercentage = $('#discount').val()
            const damount = grandtotal * (discountPercentage/100)
            $('#cdiscount').text(damount)
            $('#netamount').text(grandtotal-damount)
        });
      $('#print').on('click', function() {
        printBill();
        var productList = "";
        $("#receipt_bill > tbody > tr").each(function () {
               productList = productList + ($(this).find('td').eq(1).text() + " **" + $(this).find('td').eq(2).text()) + "---";
        });
        var branch = $('#branchname').text();
          $.ajax({
                url: "updateStock"+"/"+productList+"&&"+branch,
                type:"GET",
                success: function(res) {
                    console.log(res)
                },
                error: function(error) {
                    console.log(error)
              }
            });
          var saleinfo = $('#cname').text() + "&&&" +$('#cphone').text()+"&&&" +productList + "&&&" + $('#billno').text() + "&&&" + $('#netamount').text() + "&&&" + $('#cdiscount').text() + "&&&" + $('#cjournalno').text() + "&&&" + $('#cashiername').text() + "&&&" + $('#branchname').text();
         if($('#netamount').text() !=""){
          $.ajax({
              url: "addsale"+"/"+saleinfo,
              type:"GET",
              success: function(res) {
                  console.log(res)
              },
              error: function(error) {
                  console.log(error)
            }
          });
         }
      });
      function printBill() {
          // var divToPrint=document.getElementById("bill");
          // newWin= window.open("");
          // newWin.document.write(divToPrint.outerHTML);
          // newWin.print();
          // newWin.close();
          var restorepage = $('body').html();
          var printcontent = $('#bill').clone();
          $('body').empty().html(printcontent);
          window.print();
          $('body').html(restorepage);
      }
      $('#fillname').focusout(function() {
        const cname = $('#fillname').val()
          $('#cname').text(cname)
      })
      $('#fillphone').focusout(function() {
        const cphone = $('#fillphone').val()
          $('#cphone').text(cphone)
      })
      $('#discount').focusout(function() {
          const discountPercentage = $('#discount').val()
          damount = grandtotal * (discountPercentage/100)
          $('#cdiscount').text(damount)
          $('#netamount').text(grandtotal-damount)
      })
      $('#paymentType').change(function() {
          paymentType = $('#paymentType').val()
          if (paymentType == "Online") {
            $('#journalno').show()
            $('#pmode').text(" "+paymentType)
            $('#cjournalno').show()
          }
          else{
            $('#journalno').hide()
            $('#pmode').text(" "+paymentType)
            $('#cjournalno').hide()
          }
      })
      $('#journalno').focusout(function(){
        jno = $('#inputJournal').val()
        $('#cjournalno').text(jno)
      });

      function uuidv4() {
          return 'xxxx'.replace(/[xy]/g, function(c) {
            var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
            return v.toString(16);
          });
    }
  </script>
  @endcan
@endsection
