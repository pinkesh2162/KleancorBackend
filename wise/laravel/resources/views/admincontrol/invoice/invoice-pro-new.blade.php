@extends('layouts.app')

@section('content')
    <!--------------------------------------------->
    <div class="container">
        <div class="row">
            <form action="{{ route('invoice-pro.store') }}" method="post">
                @csrf
                <div>
                    <div id="car_parent">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label>Product Name: </label>
                                        <select id="pdt-1" class="select2_single form-control product" tabindex="-1"
                                            name="product[]">
                                            <option value="0">Choose Product</option>
                                            @foreach ($product as $item)
                                                <option value="{{ $item->id }}">{{ $item->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Quantity</label>
                                        <input type="text" autocomplete="off" value="" name="qty[]"
                                            id="qty-1" class="all form-control" />
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Quantity2</label>
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
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>Service Details: </label>
                                        <input type="text" name="service_details1" class="form-control"
                                            value="{{ old('service_details1') }}">
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Quantity</label>
                                        <input type="text" autocomplete="off" value="{{ old('service_quantiry1') }}"
                                            name="service_quantiry1" class="all form-control" />
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Amount</label>
                                        <input type="text" autocomplete="off" value="{{ old('service_amount1') }}"
                                            name="service_amount1" class="all form-control" />
                                    </div>
                                </div>
                                <br />
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>Service Details: </label>
                                        <input type="text" name="service_details2" class="form-control"
                                            value="{{ old('service_details2') }}">
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Quantity</label>
                                        <input type="text" autocomplete="off" value="{{ old('service_quantiry2') }}"
                                            name="service_quantiry2" class="all form-control" />
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Amount</label>
                                        <input type="text" autocomplete="off" value="{{ old('service_amount2') }}"
                                            name="service_amount2" class="all form-control" />
                                    </div>
                                </div>
                                <div class="row">
                                    <br />
                                    <div class="col-sm-10">
                                        <label>Billing Subject</label>
                                        <textarea name="subject" class="form-control">{{ old('subject') }}</textarea>

                                        <br />

                                        <label>Service Area/Delivery</label>
                                        <textarea name="address" class="form-control">{{ old('address') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <label>Project: </label>
                                <select class="select2_single form-control product" name="projectid">
                                    @foreach ($project as $value)
                                        <option value="{{ $value->id }}">{{ $value->project_name }} -
                                            {{ $value->company_name }}</option>
                                    @endforeach
                                </select><br />

                                <label>Invoice Prefix: </label>
                                <input type="text" name="invoice_prefix" value="" class="form-control">
                                <br />

                                <label>Invoice Date: </label>
                                <input type="text" name="invoice_date" id="datepicker" required
                                    value="{{ date('Y-m-d') }}" class="form-control">
                                <br />

                                <label>Challan No: </label>
                                <input type="text" name="challan" value="" class="form-control">
                                <br />

                                <label>Work/Purchase Order: </label>
                                <input type="text" name="work_order" value="" class="form-control">
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
                                </select>

                            </div>
                        </div>


                        <div class="col-sm-4 col-sm-offset-1"><br />
                            <button id="clone_btn" class="btn btn-primary">Add new Field</button>
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
            var clickCount = 1;
            $("body").on("click", "#clone_btn", function() {
                clickCount++;
                var html = "";
                html += '<div class="row"><br /><div class="col-sm-4">';
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
                    '<div class="col-sm-2"><label>Quantity</label><input type="text" autocomplete="off" value="" name="qty[]" id="qty-' +
                    clickCount + '" class="all form-control" /></div>';

                html +=
                    '<div class="col-sm-2"><label>Quantity2</label><input type="text" autocomplete="off" value="0" name="qty2[]" id="qty2-' +
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
            $("#datepicker").datepicker({
                minDate: new Date(2024, 6, 5),
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true,
            });
        });
    </script>
    <!-- Date Picker Script End -->
@endsection
