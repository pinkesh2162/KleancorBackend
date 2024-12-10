<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">


<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
  <title>INVOICE {{ $data['iid'] }}</title>
  <style>

  * { margin: 0; padding: 0; }
  body {
    font: 14px/1.4 Helvetica, Arial, sans-serif;
  }
  #page-wrap { width: 600px; margin: 0 auto; }

  textarea { border: 0; font: 14px Helvetica, Arial, sans-serif; overflow: hidden; resize: none; }
  table { border-collapse: collapse; }
  table td, table th { border: 1px solid black; padding: 5px; }

  #header { height: 15px; width: 100%; margin: 20px 0; background: #222; text-align: center; color: white; font: bold 15px Helvetica, Sans-Serif; text-decoration: uppercase; letter-spacing: 20px; padding: 8px 0px; }

  #address { width: 250px; height: 150px; float: left; }
  #customer { overflow: hidden; }

  #logo { text-align: right; float: right; position: relative; margin-top: 25px; border: 1px solid #fff; max-width: 540px; overflow: hidden; }
  #customer-title { font-size: 20px; font-weight: bold; float: left; }

  #meta { margin-top: 1px; width: 100%; float: right; }
  #meta td { text-align: right;  }
  #meta td.meta-head { text-align: left; background: #eee; width: 120px;}
  #meta td textarea { width: 100%; height: 20px; text-align: right; }

  #items { clear: both; width: 100%; margin: 30px 0 0 0; border: 1px solid black; }
  #items th { background: #eee; }
  #items textarea { width: 80px; height: 50px; }
  #items tr.item-row td {  vertical-align: top; }
  #items td.description { width: 300px; }
  #items td.item-name { width: 175px; }
  #items td.description textarea, #items td.item-name textarea { width: 100%; }
  #items td.total-line { border-right: 0; text-align: right; }
  #items td.total-value { border-left: 0; padding: 10px; }
  #items td.total-value textarea { height: 20px; background: none; }
  #items td.balance { background: #eee; }
  #items td.blank { border: 0; }

  #terms { margin: 15px 0 0 0; text-align: center; }
  #terms h5 { text-transform: capitalize;  text-align: left; font: 14px Helvetica, Sans-Serif; border-bottom: 1px solid black; padding: 0 0 12px 0; margin: 0 0 8px 0; }
  #terms textarea { width: 100%; text-align: center;}



  .delete-wpr { position: relative; }
  .delete { display: block; color: #000; text-decoration: none; position: absolute; background: #EEEEEE; font-weight: bold; padding: 0px 3px; border: 1px solid; top: -6px; left: -22px; font-family: Verdana; font-size: 12px; }

  /* Extra CSS for Print Button*/
  .button {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    overflow: hidden;
    margin-top: 20px;
    padding: 12px 12px;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    -webkit-transition: all 60ms ease-in-out;
    transition: all 60ms ease-in-out;
    text-align: center;
    white-space: nowrap;
    text-decoration: none !important;

    color: #fff;
    border: 0 none;
    border-radius: 4px;
    font-size: 14px;
    font-weight: 500;
    line-height: 1.3;
    -webkit-appearance: none;
    -moz-appearance: none;

    -webkit-box-pack: center;
    -webkit-justify-content: center;
    -ms-flex-pack: center;
    justify-content: center;
    -webkit-box-align: center;
    -webkit-align-items: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-flex: 0;
    -webkit-flex: 0 0 160px;
    -ms-flex: 0 0 160px;
    flex: 0 0 160px;
  }
  .button:hover {
    -webkit-transition: all 60ms ease;
    transition: all 60ms ease;
    opacity: .85;
  }
  .button:active {
    -webkit-transition: all 60ms ease;
    transition: all 60ms ease;
    opacity: .75;
  }
  .button:focus {
    outline: 1px dotted #959595;
    outline-offset: -4px;
  }

  .button.-regular {
    color: #202129;
    background-color: #edeeee;
  }
  .button.-regular:hover {
    color: #202129;
    background-color: #e1e2e2;
    opacity: 1;
  }
  .button.-regular:active {
    background-color: #d5d6d6;
    opacity: 1;
  }

  .button.-dark {
    color: #FFFFFF;
    background: #333030;
  }
  .button.-dark:focus {
    outline: 1px dotted white;
    outline-offset: -4px;
  }

  @media print
  {
    .no-print, .no-print *
    {
      display: none !important;
    }
  }
  #subtotal, .grand_total{
    float: right;
  }
  table.challan{
    width: 100%;
    border-collapse: collapse;
  }
  table.challan tr td{
    border: 1px solid #727272;
  }
  </style>

</head>

<body>

  <div id="page-wrap">

    <table width="100%">
      <tr>
        <td style="border: 0;  text-align: left" width="45%">
          <a href="{{ route("dashboard") }}"><img id="image" src="{{ url('images/logo.png') }}" alt="logo" /></a>
          <br><br>
          <span style="font-size: 18px; color: #2f4f4f"><strong>INVOICE # {{ $data['selected']->invoice_prefix }}</strong></span>
        </td>
        <td style="border: 0;  text-align: right" width="55%"><div id="logo">
          <p>TA-134/A, (2nd Floor) Boishakhi Shoroni,</p>
          <p>Gulshan-Badda Link Road, Gulshan-1, Dhaka-1212</p>
          <p>Tel: +8802-8833936, +8802-8833937</p>
          <p>E-mail: wise.trade10@gmail.com</p>
          <p>Web: www.wisetradebd.com</p>
        </div>
      </td>
    </tr>
  </table>

  <hr>
  <br>

    <table id="meta">
      <tr>
        <td rowspan="7" style="color: #000; border: 1px solid white; border-right: 1px solid black; text-align: left" width="55%" valign="top">
          <h4>Invoice To</h4>
          <p>{{ $data['selected']->company_name }}</p>
          <p>{{ $data['selected']->caddress }}</p>
          <p>Attention: <b>{{ $data['selected']->contact_person }}</b></p>
          <p>Phone: {{ $data['selected']->contact_number }}</p>
          <p>Email:{{ $data['selected']->email }}</p>
          <br /><br />

        </td>
        <td class="meta-head">INVOICE #</td>
        <td>{{ $data['selected']->invoice_prefix }} <br />{{ $data['selected']->address }}</td>
      </tr>
      <tr>
        <td class="meta-head">INVOICE Date</td>
        <td>{{ $data['selected']->created_at }}</td>
      </tr>
      <tr>
        <td class="meta-head">Challan no. & Date</td>
        <td>
          @php
          $challan = explode("####", $data['selected']->challan);
          @endphp
          <table class="challan">
            @foreach ($challan as $cha)
              @php
              $cha_details = explode("||||", $cha);
              @endphp
              <tr>
                <td style="padding: 5px;">{{ substr($cha_details[0], 2) }}</td>
                <td style="padding: 5px;">{{ $cha_details[1] }}</td>
              </tr>
            @endforeach
          </table>
        </td>
      </tr>
      <tr>
        <td class="meta-head">Status</td>
        <td>{{ ($data['selected']->status)?"Paid":"Unpaid" }}</td>
      </tr>
      <tr>

        <td class="meta-head">Invoice Date</td>
        <td>{{ $data['selected']->created_at }}</td>
      </tr>
      <tr>
        <td class="meta-head">Due Date</td>
        <td>{{ $data['selected']->due_date }}</td>
      </tr>

      <tr>
        <td class="meta-head">Work/Purchase Order:</td>
        <td>{{ $data['selected']->work_order }}</td>
      </tr>



      <tr>
        <td style="border: none"><b style="font-size: 18px; color: #2f4f4f; text-align: left; float: left;">Subject: {{$data['selected']->subject}}</b></td>
        <td class="meta-head">Amount Due</td>
        <td><div class="due">Tk {{  number_format(($data['selected']->amount + ($data['selected']->amount * $data['selected']->tax)/100), 2) }}</div></td>
      </tr>

    </table>


  <table id="items">
    <tr>
      <th width="65%">Item</th>
      <th align="right">Price</th>
      <th align="right">Qty</th>
      <th align="right">Total</th>
    </tr>

    @php $sTotal = 0 @endphp
    @if($data['details'])
      @foreach ($data['details'] as $key => $value)
        <tr class="item-row">
          <td class="description">{{ $value->title }}{!! ($value->ssd_description)?" $value->ssd_description":"" !!}.</td>
          <td style="text-align:right; width: 100px">Tk {{ number_format(($value->price), 2) }}</td>
          <td style="text-align:right; width: 100px">{{ ($value->totalSale != ceil($value->totalSale))?number_format($value->totalSale, 2):$value->totalSale }} {{ $value->uname }}</td>
          <td style="text-align:right;  width: 120px">Tk {{ number_format(($value->price * $value->totalSale), 2) }}</td>
        </tr>
        @php $sTotal += ($value->price * $value->totalSale) @endphp
      @endforeach
    @endif

    @if($data['allService'])
      @foreach ($data['allService'] as $key => $value)
        <tr class="item-row">
          <td class="description">{{ $value->title }}</td>
          <td style="text-align:right">Tk {{ number_format(($value->amount), 2) }}</td>
          <td style="text-align:right">{{ $value->quantity }} {{ $value->type }}</td>
          <td style="text-align:right">Tk {{ number_format(($value->amount * $value->quantity), 2) }}</td>
        </tr>
        @php $sTotal += ($value->amount * $value->quantity) @endphp
      @endforeach
    @endif

    <tr>
      <td class="blank"> </td>
      <td colspan="3" class="total-line">Sub Total:&nbsp;&nbsp;&nbsp; <div id="subtotal">TK. {{ number_format(($sTotal), 2) }}</div></td>
    </tr>

    <tr>
      <td class="blank"> </td>
      <td colspan="3" class="total-line balance">Grand Total:&nbsp;&nbsp;&nbsp; <div class="grand_total">Tk {{ number_format(round($sTotal + ($sTotal * $data['selected']->tax )/100), 2) }}</div></td>
    </tr>

  </table>

  <!--    related transactions -->


  <!--    end related transactions -->

  <div id="terms">
    <h5><span style='text-transform: none'>In-words</span>: Taka {{ ucwords(convertNumberToWord(round($sTotal + ($sTotal * $data['selected']->tax )/100))) }} only. </h5>
    <p>Delivery/Location: {{ $data['selected']->address }}</p>

    <p><br></p><p><br></p><p><strong>"Please pay the amount through Cheque/P.O./cash in favour
      of WISE TRADE".</strong></p>        </div>


      <button class='button -dark center no-print'  onClick="window.print();">Click Here to Print</button>
      <a href="{{ route("invoice.print", 145) }}?download=1" class='button -dark center no-print'>Download</button>
      </div>

    </body>

    </html>
