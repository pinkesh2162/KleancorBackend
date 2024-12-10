@extends('layouts.app')

@section('content')



    <!--------------------------------------------->
    <div class="container">
        <div class="row">
            <form action="{{ route('invoice.update') }}" method="post">
                @csrf
                <input type="hidden" name="sid" value="{{ $sales->id }}">
                <div>
                    <div id="car_parent">
                        <div class="row">
                            <div class="col-sm-8">
                                @php $clickCount = 0 @endphp
                                @if ($sales_details)
                                    @foreach ($sales_details as $sd)
                                        @php $clickCount++ @endphp
                                        <div class="row">
                                            <br />
                                            <div class="col-sm-3">
                                                <label>Product Name: </label>
                                                <select id="pdt-{{ $clickCount }}"
                                                    class="select2_single form-control product" tabindex="-1"
                                                    name="product[]">
                                                    <option value="0">Choose Product</option>
                                                    @foreach ($product as $item)
                                                        @if ($sd->pid == $item->id)
                                                            <option value="{{ $item->id }}" selected>{{ $item->title }}
                                                            </option>
                                                        @else
                                                            <option value="{{ $item->id }}">{{ $item->title }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Product Description: </label>
                                                <input id="des-{{ $clickCount }}" type="text" name="des[]"
                                                    value="{{ $sd->description }}" class="form-control">
                                            </div>
                                            <div class="col-sm-1">
                                                <label>Quantity</label>
                                                <input type="text" autocomplete="off"
                                                    value="{{ $sd->original_qty ? $sd->original_qty : $sd->quantity1 }}"
                                                    name="qty[]" id="qty-{{ $clickCount }}" class="all form-control"
                                                    style="padding: 6px 4px" />
                                            </div>
                                            <div class="col-sm-1">
                                                <label>Quantity2</label>
                                                <input type="text" autocomplete="off" value="{{ $sd->quantity2 }}"
                                                    name="qty2[]" id="qtyy-{{ $clickCount }}" class="all form-control"
                                                    style="padding: 6px 4px" />
                                            </div>
                                            <div class="col-sm-2">
                                                <label>Price</label>
                                                <input type="text" autocomplete="off" value="{{ $sd->price }}"
                                                    name="price[]" id="price-{{ $clickCount }}"
                                                    class="all form-control" />
                                            </div>
                                            <div class="col-sm-1"><label>&nbsp;</label><button
                                                    class="btn btn-danger del-field"
                                                    id="del-field-{{ $clickCount }}">Delete</button></div>
                                        </div>
                                    @endforeach
                                @endif
                                <span class="add-more-field"></span>

                                <br />

                                <hr />
                                <hr />


                                @php $i = 1 @endphp
                                @foreach ($service_details as $sd)
                                    <br />
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <label>Service Details: </label>
                                            <input type="text" name="service_details[]" class="form-control"
                                                value="{{ $sd->title }}">
                                        </div>
                                        <div class="col-sm-1">
                                            <label>Qty</label>
                                            <input type="text" autocomplete="off" value="{{ $sd->quantity }}"
                                                name="service_quantity[]" class="all form-control" />
                                        </div>
                                        <div class="col-sm-2">
                                            <label>Service Type</label>
                                            <input type="text" autocomplete="off" value="{{ $sd->type }}"
                                                name="type[]" class="all form-control" />
                                        </div>
                                        <div class="col-sm-2">
                                            <label>Amount</label>
                                            <input type="text" autocomplete="off" value="{{ $sd->amount }}"
                                                name="service_amount[]" class="all form-control" />
                                        </div>
                                        <div class="col-sm-1">
                                            <label>&nbsp;</label><button class="btn btn-danger del-service">Delete</button>
                                        </div>
                                    </div>
                                @endforeach

                                <span class="add-more-service"></span>
                                <br />


                                <div class="row">
                                    <br />
                                    <div class="col-sm-10">
                                        <label>Billing Subject</label>
                                        <textarea name="subject" class="form-control">{{ $sales->subject }}</textarea>

                                        <br />

                                        <label>Service Area/Delivery</label>
                                        <textarea name="address" class="form-control">{{ $sales->address }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <label>Customer: </label>
                                <select class="select2_single form-control product" name="customerid">
                                    @foreach ($customers as $value)
                                        @if ($value->id == $sales->customerid)
                                            <option selected value="{{ $value->id }}">{{ $value->contact_person }} -
                                                {{ $value->company_name }}</option>
                                        @else
                                            <option value="{{ $value->id }}">{{ $value->contact_person }} -
                                                {{ $value->company_name }}</option>
                                        @endif
                                    @endforeach
                                </select><br />

                                <label>Invoice Number: </label>
                                <input type="text" name="invoice_number" value="{{ $sales->invoice_number }}"
                                    class="form-control">
                                <br />

                                <label>Invoice Prefix: </label>
                                <input type="text" name="invoice_prefix" value="{{ $sales->invoice_prefix }}"
                                    class="form-control">
                                <br />

                                <label>Invoice Date: </label>
                                <input type="text" name="invoice_date" id="datepicker" required
                                    value="{{ substr($sales->created_at, 0, 10) }}" class="form-control">
                                <br />

                                <label>Challan No/Date: <span class="label label-success" id="add-challan">Add
                                        More</span></label>
                                <table id="challan_table">
                                    @php
                                        $challan = explode('####', $sales->challan);
                                        $idss = 0;
                                    @endphp
                                    @foreach ($challan as $cha)
                                        @php
                                            $ch = explode('||||', $cha);
                                        @endphp
                                        <tr>
                                            <td><input type="text" name="challan_no[]"
                                                    value="{{ substr($ch[0], 2) }}" required class="form-control"></td>
                                            <td><input type="text" name="challan_date[]" value="{{ $ch[1] }}"
                                                    id="challan_date1" required class="form-control"></td>
                                            @if ($idss)
                                                <td><span class='label label-danger delete-challan'>Delete</span></td>
                                            @else
                                                <td></td>
                                            @endif
                                        </tr>
                                        @php
                                            $idss = 1;
                                        @endphp
                                    @endforeach
                                </table>
                                <br />

                                <label>Work/Purchase Order: </label>
                                <input type="text" name="work_order" value="{{ $sales->work_order }}"
                                    class="form-control">
                                <br />

                                @php
                                    $temp_time =
                                        strtotime($sales->due_date) - strtotime(substr($sales->created_at, 0, 10));
                                    $temp_time = round($temp_time / (60 * 60 * 24));
                                @endphp

                                <label>Payment Terms: </label>
                                <select class="form-control" name="due_date">
                                    @foreach ($payment_term as $pt)
                                        @if ($pt == 0)
                                            <option value="{{ $pt }}">Due On Receipt</option>
                                        @elseif($temp_time == $pt)
                                            <option value="{{ $pt }}" selected="">+{{ $pt }} days
                                            </option>
                                        @else
                                            <option value="{{ $pt }}">+{{ $pt }} days</option>
                                        @endif
                                    @endforeach
                                </select><br />

                                <label>Sales Tax: </label>
                                <select class="form-control" name="tax">
                                    @foreach ($sales_tax as $st)
                                        @if ($st == 0)
                                            <option value="{{ $st }}">None</option>
                                        @elseif($st == $sales->tax)
                                            <option value="{{ $st }}" selected>Sales Tax ({{ $st }}
                                                %)</option>
                                        @else
                                            <option value="{{ $st }}">Sales Tax ({{ $st }} %)
                                            </option>
                                        @endif
                                    @endforeach
                                </select><br />

                                <label>Discount: </label>
                                <input type="number" name="discount" required class="form-control"
                                    value="{{ $sales->discount }}">

                            </div>
                        </div>


                        <div class="col-sm-4 col-sm-offset-1"><br />
                            <button id="clone_btn" class="btn btn-primary">Add new Field</button>
                            <button id="clone_btn_service" class="btn btn-primary">Add new Service</button>
                            <input type="submit" class="btn btn-success" id="nxtbutn" value="Update" />
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

            var clickCount = <?php echo $clickCount; ?>;
            var challanCount = <?php echo count($challan); ?>;

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
                    '<div class="col-sm-1"><label>Quantity</label><input type="text" autocomplete="off" value="" name="qty[]" id="qty-' +
                    clickCount + '" class="all form-control" /></div>';

                html +=
                    '<div class="col-sm-1"><label>Quantity2</label><input type="text" autocomplete="off" value="0" name="qty2[]" id="qty2-' +
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
