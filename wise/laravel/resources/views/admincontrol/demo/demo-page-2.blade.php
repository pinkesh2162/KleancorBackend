@extends('layouts.app')

@section('content')



<!--------------------------------------------->
<div class="container">
  <div class="row">
    <form action="{{route('demo')}}" method="get">
      <table class="table table-responsive">
        <tr>
          <td>Product Name</td>
          <td></td>
        </tr>
        <tr>
          <td valign="middle">Test Product 1</td>
          <td>
            <table class="table table-responsive">
              <tr>
                <td>SKU</td>
                <td>Quantity/Unit</td>
                <td>Price</td>
                <td>Total</td>
              </tr>
              <tr>
                <td>REW</td>
                <td>8 Pieces</td>
                <td><input type="text" name="" value="100"</td>
                <td>800</td>
              </tr>
              <tr>
                <td>FRE</td>
                <td>2 Pieces</td>
                <td><input type="text" name="" value="100"</td>
                <td>200</td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td valign="middle">Test Product 2</td>
          <td>
            <table class="table table-responsive">
              <tr>
                <td>SKU</td>
                <td>Quantity/Unit</td>
                <td>Price</td>
                <td>Total</td>
              </tr>
              <tr>
                <td>HYT</td>
                <td>18 Pieces</td>
                <td><input type="text" name="" value="200"</td>
                <td>3600</td>
              </tr>
              <tr>
                <td>REF</td>
                <td>7 Pieces</td>
                <td><input type="text" name="" value="200"</td>
                <td>1400</td>
              </tr>
              <tr>
                <td>HTR</td>
                <td>5 Pieces</td>
                <td><input type="text" name="" value="200"</td>
                <td>400</td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td valign="middle">Test Product 3</td>
          <td>
            <table class="table table-responsive">
              <tr>
                <td>SKU</td>
                <td>Quantity/Unit</td>
                <td>Price</td>
                <td>Total</td>
              </tr>
              <tr>
                <td>BYT</td>
                <td>2 Pieces</td>
                <td><input type="text" name="" value="500"</td>
                <td>1000</td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <center><input class="btn btn-success" type="submit" value="Save" /></center>
      <br /><br />
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

@endsection
