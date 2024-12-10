@extends('layouts.app')

@section('content')
    <!--------------------------------------------->
    <div class="container">
        <div class="row">
            <form action="{{ route('invoice.store') }}" method="post">
                @csrf
                <div>
                    <div id="car_parent">
                        <div class="row">
                            <div class="col-sm-8">
                                @if (session('msg'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('msg') }}
                                    </div>
                                @endif
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label>Product Name: </label>
                                        <select id="pdt-1" class="select2_single form-control product" tabindex="-1"
                                            name="product[]">
                                            <option value="0">Choose Product</option>
                                            @foreach ($product as $item)
                                                <option value="{{ $item->id }}">{{ $item->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Product Description: </label>
                                        <input id="des-1" name="des[]" class="form-control">
                                    </div>
                                    <div class="col-sm-1">
                                        <label>Qty</label>
                                        <input type="text" autocomplete="off" value="" name="qty[]"
                                            id="qty-1" class="all form-control" />
                                    </div>
                                    <div class="col-sm-1">
                                        <label>Qty2</label>
                                        <input type="text" autocomplete="off" value="0" name="qty2[]"
                                            id="qtyy-1" class="all form-control" />
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Price</label>
                                        <input type="text" autocomplete="off" value="0" name="price[]"
                                            id="price-1" class="all form-control" />
                                    </div>
                                </div>
                                <span class="add-more-field"></span>
                                <br />

                                <hr />
                                <hr />

                                <div class="row">
                                    <br />
                                    <div class="col-sm-5">
                                        <label>Service Details: </label>
                                        <input type="text" name="service_details[]" class="form-control">
                                    </div>
                                    <div class="col-sm-1">
                                        <label>Qty</label>
                                        <input type="text" name="service_quantity[]" class="form-control" />
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Service Type</label>
                                        <input type="text" placeholder="job, sft." name="type[]" class="form-control" />
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Amount</label>
                                        <input type="text" autocomplete="off" name="service_amount[]"
                                            class="all form-control" />
                                    </div>
                                </div>
                                <span class="add-more-service"></span>
                                <br />

                                <div class="row">
                                    <br />
                                    <div class="col-sm-10">
                                        <label>Billing Subject</label>
                                        <textarea name="subject" class="form-control">Repair & Maintenance Work.</textarea>

                                        <br />

                                        <label>Service Area/Delivery</label>
                                        <textarea name="address" class="form-control">{{ old('address') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <label>Customer: </label>
                                <select class="select2_single form-control product" name="customerid">
                                    @foreach ($customers as $value)
                                        <option value="{{ $value->id }}">{{ $value->contact_person }} -
                                            {{ $value->company_name }}</option>
                                    @endforeach
                                </select><br />

                                <label>Invoice Number: </label>
                                <input type="text" name="invoice_number" value="" class="form-control">
                                <br />

                                <label>Invoice Prefix: </label>
                                <input type="text" name="invoice_prefix" value="" class="form-control">
                                <br />

                                <label>Challan No/Date: <span class="label label-success" id="add-challan">Add
                                        More</span></label>
                                <table id="challan_table">
                                    <tr>
                                        <td><input type="text" name="challan_no[]" required class="form-control"></td>
                                        <td><input type="text" autocomplete="off" name="challan_date[]"
                                                id="challan_date1" required class="form-control"></td>
                                        <td></td>
                                    </tr>
                                </table>
                                <br />

                                <label>Work/Purchase Order: </label>
                                <input type="text" name="work_order" value="" class="form-control">
                                <br />

                                <label>Invoice Date: </label>
                                <input type="text" name="invoice_date" id="datepicker" required
                                    value="{{ date('Y-m-d') }}" class="form-control">
                                <br />

                                <label>Payment Terms: </label>
                                <select class="form-control" name="due_date">
                                    @foreach ($payment_term as $pt)
                                        @if ($pt == 0)
                                            <option value="{{ $pt }}" selected="">Due On Receipt</option>
                                        @else
                                            <option value="{{ $pt }}">+{{ $pt }} days</option>
                                        @endif
                                    @endforeach
                                </select><br />

                                <label>Sales Tax: </label>
                                <select class="form-control" name="tax">
                                    @foreach ($sales_tax as $st)
                                        @if ($st == 0)
                                            <option value="{{ $st }}" selected="">None</option>
                                        @else
                                            <option value="{{ $st }}">Sales Tax ({{ $st }} %)
                                            </option>
                                        @endif
                                    @endforeach
                                </select><br />

                                <label>Discount: </label>
                                <input type="number" name="discount" required value="0" class="form-control">
                            </div>
                        </div>


                        <div class="col-sm-4 col-sm-offset-1"><br />
                            <button id="clone_btn" class="btn btn-primary">Add new Field</button>
                            <button id="clone_btn_service" class="btn btn-primary">Add new Service</button>
                            <input type="submit" class="btn btn-success" id="nxtbutn" value="Save" />
                        </div>
                        <br /><br /><br />
                    </div>
                </div>
            </form>

        </div>
    </div>



    <!----------------------------------------->
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"></div>
                <div class="card-body">
                </div>
            </div>
        </div>
    </div>
    </div>





    <script>
        $(document).ready(function() {
            $("body").on('change', '.product', function(event) {
                event.preventDefault();
                var pdtid = parseInt($(this).val());
                var id = $(this).attr('id');
                id = parseInt(id.substr(4));

                if (pdtid) {
                    $.ajax({
                        type: 'POST',
                        data: {
                            "_token": $("meta[name='csrf-token']").attr("content"),
                            "pdtid": pdtid
                        },
                        url: "{{ route('invoice.get_product_description') }}",
                        success: function(data) {
                            $("#des-" + id).val(data);
                        }
                    });
                }
            });

            var clickCount = 1;
            var clickServiceCount = 1;
            var challanCount = 1;

            $("body").on("click", "#add-challan", function() {
                challanCount++;
                var html = ""
                html += "<tr>";
                html += "<td><input type='text' name='challan_no[]' required class='form-control'></td>";
                html += "<td><input type='text' name='challan_date[]' required id='challan_date" +
                    challanCount + "' class='form-control'></td>";
                html += "<td><span class='label label-danger delete-challan'>Delete</span></td>";
                html += "</tr>";
                $("#challan_table").append(html);

                $(function() {
                    $("#challan_date" + challanCount).datepicker({
                        minDate: new Date(2024, 6, 5),
                        dateFormat: "yy-mm-dd",
                        changeMonth: true,
                        changeYear: true,
                    });
                });
            });

            $("body").on("click", ".delete-challan", function(e) {
                e.preventDefault();
                $(this).parent().parent().remove();
            });

            $("body").on("click", "#clone_btn_service", function() {
                var html = "";
                html += '<div class="row"><br />';

                html += '<div class="col-sm-5">'
                html += '<label>Service Details: </label>';
                html += '<input type="text" name="service_details[]" class="form-control">';
                html += '</div>';

                html += '<div class="col-sm-1">'
                html += '<label>Qty: </label>';
                html += '<input type="text" name="service_quantity[]" class="form-control">';
                html += '</div>';

                html += '<div class="col-sm-2">'
                html += '<label>Service Type: </label>';
                html += '<input type="text" placeholder="job, sft." name="type[]" class="form-control">';
                html += '</div>';

                html += '<div class="col-sm-2">'
                html += '<label>Amount: </label>';
                html += '<input type="text" name="service_amount[]" class="form-control">';
                html += '</div>';

                html +=
                    '<div class="col-sm-1"><label>&nbsp;</label><button class="btn btn-danger del-service">Delete</button></div>';
                html += "</div>";

                $(".add-more-service").before(html);
                return false;
                e.preventDefault();
            });


            $("body").on("click", "#clone_btn", function() {
                clickCount++;
                var html = "";
                html += '<div class="row"><br /><div class="col-sm-3">';
                html += '<label>Product Name</label>';
                html += '<select class="select2_single form-control product" id="pdt-' + clickCount +
                    '" tabindex="-1" name="product[]">';
                html += "<option value='0'>Choose Product</option>";
                <?php
    foreach ($product as $item) {
      ?>
                html += "<option value='<?php echo $item->id; ?>'><?php echo $item->title; ?></option>";
                <?php
    }
    ?>
                html += "</select>";
                html += "</div>";
                html +=
                    '<div class="col-sm-3"><label>Product Description</label><input type="text" autocomplete="off" value="" name="des[]" id="des-' +
                    clickCount + '" class="all form-control" /></div>';
                html +=
                    '<div class="col-sm-1"><label>Qty</label><input type="text" autocomplete="off" value="" name="qty[]" id="qty-' +
                    clickCount + '" class="all form-control" /></div>';

                html +=
                    '<div class="col-sm-1"><label>Qty2</label><input type="text" autocomplete="off" value="0" name="qty2[]" id="qty2-' +
                    clickCount + '" class="all form-control" /></div>';

                html +=
                    '<div class="col-sm-2"><label>Price</label><input type="text" autocomplete="off" value="0" name="price[]" id="price-' +
                    clickCount + '" class="all form-control" /></div>';
                html +=
                    '<div class="col-sm-1"><label>&nbsp;</label><button class="btn btn-danger del-field" id="del-field-' +
                    clickCount + '">Delete</button></div>';

                html += "</div>";

                $(".add-more-field").before(html);

                return false;
                e.preventDefault();
            });

            $("body").on("click", ".del-field", function(e) {
                e.preventDefault();
                $("#" + $(this).attr("id")).parent().parent().remove();
            });

            $("body").on("click", ".del-service", function(e) {
                e.preventDefault();
                $(this).parent().parent().remove();
            });


            $("body").on("blur", ".all", function() {
                var qid = $(this).attr("id");
                qid = parseInt(qid.substr(4));
                //alert($("#pdt-" + qid).val() + "---" + $("#qty-" + qid).val());
                var qty = $("#qty-" + qid).val();
                //alert(qty);
            });

            $("body").on("change", ".product", function() {
                var pid = $(this).attr("id");
                pid = parseInt(pid.substr(4));
                // alert($("#pdt-" + pid).val() + "---" + $("#qty-" + pid).val());
                var pdtid = $("#pdt-" + pid).val();
                //alert(pdtid);
            });



        });
    </script>


    <!-- Date Picker Script Start -->
    <script>
        $(function() {
            $("#datepicker, #challan_date1").datepicker({
                minDate: new Date(2024, 6, 5),
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true,
            });
        });
    </script>
    <!-- Date Picker Script End -->
@endsection
