@extends('layouts.app')

@section('content')



<!--------------------------------------------->
<div class="container">
  <div class="row">
    <form action="{{route('sales.create')}}" method="post">
      @csrf
    <div>
      <div id="car_parent">
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Product Name</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select id="pdt-1" class="select2_single form-control product" tabindex="-1" name="product">
                  @foreach ($product as $item)
                  <option value="{{ $item->id }}">{{ $item->title }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>

          <div class="col-sm-6">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Quantity</label>
            <input type="text" autocomplete="off" value=""  name="qty" id="qty-1" class="all" />
          </div>
        </div>
        <br />
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Product Name</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select id="pdt-1" class="select2_single form-control product" tabindex="-1" name="product">
                  @foreach ($product as $item)
                  <option value="{{ $item->id }}">{{ $item->title }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>

          <div class="col-sm-6">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Quantity</label>
            <input type="text" autocomplete="off" value=""  name="qty" id="qty-1" class="all" />
          </div>
        </div>
        <br />
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Product Name</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select id="pdt-1" class="select2_single form-control product" tabindex="-1" name="product">
                  @foreach ($product as $item)
                  <option value="{{ $item->id }}">{{ $item->title }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>

          <div class="col-sm-6">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Quantity</label>
            <input type="text" autocomplete="off" value=""  name="qty" id="qty-1" class="all" />
          </div>
        </div>
        <br />
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Product Name</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select id="pdt-1" class="select2_single form-control product" tabindex="-1" name="product">
                  @foreach ($product as $item)
                  <option value="{{ $item->id }}">{{ $item->title }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>

          <div class="col-sm-6">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Quantity</label>
            <input type="text" autocomplete="off" value=""  name="qty" id="qty-1" class="all" />
          </div>
        </div>
        <span class="add-more-field"></span>
        <div class="col-sm-4 col-sm-offset-1"><br />
          <button id="clone_btn" class="btn btn-primary">ADD MORE</button>
          <input type="submit" class="btn btn-success" id="nxtbutn" value="Next" />
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




<!-- Date Picker Script Start -->

<script>
  $(document).ready(function () {
    var clickCount = 1;
    $("body").on("click", "#clone_btn", function () {
      clickCount++;
      var html = "";
      html += '<br /><div class="row"><div class="col-sm-6">';
      html += '<label class="control-label col-md-3 col-sm-3 col-xs-12">Product Name</label><div class="col-md-6 col-sm-6 col-xs-12">';
      html += '<select class="select2_single form-control product" id="pdt-' + clickCount + '" tabindex="-1" name="product[]">';
<?php
foreach ($product as $item) {
  ?>
        html += "<option value='<?php echo $item->id ?>'><?php echo $item->title ?></option>";
  <?php
}
?>
      html += "</select>";
      html += "</div></div>";
      html += '<div class="col-sm-6">';
      html += '<label class="control-label col-md-3 col-sm-3 col-xs-12">Quantity</label><input type="text" autocomplete="off" value="" name="qty" id="qty-' + clickCount + '" class="all" />';
      html += "</div>";
      html += "</div>";

      $(".add-more-field").before(html);

      return false;
      e.preventDefault();
    });

    $("body").on("blur", ".all", function () {
      var qid = $(this).attr("id");
      qid = parseInt(qid.substr(4));
      //alert($("#pdt-" + qid).val() + "---" + $("#qty-" + qid).val());
      var qty = $("#qty-" + qid).val();
      //alert(qty);
    });

    $("body").on("change", ".product", function () {
      var pid = $(this).attr("id");
      pid = parseInt(pid.substr(4));
      // alert($("#pdt-" + pid).val() + "---" + $("#qty-" + pid).val());
      var pdtid = $("#pdt-" + pid).val();
      //alert(pdtid);
    });



  });

</script>



<!-- Date Picker Script End -->




@endsection
