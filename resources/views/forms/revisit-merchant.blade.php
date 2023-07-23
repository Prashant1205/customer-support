<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
        <meta name="format-detection" content="telephone=no">
        <meta name="msapplication-tap-highlight" content="no">
        <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.css">

        <title>Register Form</title>
        <link rel="stylesheet" href="{{ URL:: to('asset/css/bootstrap.min.css') }}">
 <!-- font-awesome -->
 <link rel="stylesheet" href="{{ URL:: to('asset/css/font-awesome-4.7.0.min.css') }}">
 <!-- open-sans fonts -->
 <link href="{{ URL:: to('asset/css/font-open-sans.css') }}" rel="stylesheet">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="{{ URL:: to('asset/css/style.css') }}">
  <!-- font-awesome -->

  <!-- open-sans fonts -->

  <script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>


<script type="text/javascript" src="{{ URL:: to('app_tracker/adapter.min.js') }}"></script>
<script type="text/javascript" src="{{ URL:: to('app_tracker/vue.min.js') }}"></script>
<script type="text/javascript" src="{{ URL:: to('app_tracker/instascan.min.js') }}"></script>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
    <style>
        .merchant-section label{
            display: block;
            position: relative;
            padding-left: 30px;
            margin-bottom: 10px;
            cursor: pointer;
            font-size: 16px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
        .merchant-section input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }
        .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 20px;
            width: 20px;
            background-color: transparent;
            border: 1px solid #828181;
        }
        .merchant-section input:checked ~ .checkmark {
            background-color: #3a3286;
            border: 1px solid #3a3286;
        }
        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }
        .merchant-section input:checked ~ .checkmark:after {
            display: block;
        }
        .checkmark:after {
            left: 6px;
            top: 2px;
            width: 6px;
            height: 11px;
            border: solid white;
            border-width: 0 2px 2px 0;
            -webkit-transform: rotate(45deg);
            -ms-transform: rotate(45deg);
            transform: rotate(45deg);
        }
        .merchant-section{}
        .merchant-section{}
    </style>
</head>
<body>
<script type="text/javascript">
$(document).ready(function () {
    $('#checkBtn').click(function() {
      checked = $("input[type=checkbox]:checked").length;

      if(!checked) {
        $( "#error" ).html( "You must check at least one checkbox." );
        $( "#error" ).focus();
        return false;
      }

    });
});

</script>
  <style type="text/css">
    .grayBg{
      border-radius: 6px;
    }
    .form-control{
      font-size: 17px!important;
    }
    .btn{
      width: 200px;
      border: 2px solid;
    }
  </style>
  <style type="text/css">
          .btn-outline-success:hover
          {
          color: #fff;
          background-color: #463e8d;
          border-color: #463e8d;
          }
          .btn-outline-success
          {
          color: #463e8d;
          border-color: #463e8d;
          }
          .clear
          {
          clear: both;
          }
  </style>
  <div class="outer" style="overflow-x: hidden;max-width: 600px;margin: 0px auto;">
    <div class="grayBg">
      <center>
        <img src="{{'../images/1.png'}}" style="height: 25px;margin: 15px 0px 25px 0px;">
      </center>
        <p style="font-size: 20px;text-align: center;margin-bottom: 10px;color: #463e8d;">Top Merchant Revisit</p>
        <p style="color: #68B3C8; text-align: center;">{{ Session::get('message') }} </p>
        @if ($errors->any())
       <p style="color: red; text-align: center;"> {{ 'All Fields Reqired' }}<p>
        @endif
        <p  style="color: red; text-align: center;" id ="error"></p>
        <form action="{{ URL :: to('form/process-merchant-revisit')}}" method="post" name="myForm" >
        <div class="wrapper">
          <div class="container">
            <div class="Qr-ordre-section add-mobile-number">
              <div class="whiteBg ordre-section-qr notification_screen">
                <div class="qr-form-sticker">
                  <div id="add-mobile-number">
                    <div class="new-mobile-number">
                      <div class="inputCustom">

                        <div class="form-group">
                          <label class="qrlabel" style="margin: 15px 15px 10px 0px;">Agent Number<em style="color: red;">*</em></label>
                          <input class="form-control input-txt phone_no border-0 input-focus" name="agentphone" placeholder="Your Mobile Number" required="" maxlength="10" type="tel" id="agentphone" pattern='\d{10}'   autocomplete="off" onkeyup="onlynum(this);">
                        </div>

                        <div class="form-group">
                          <label class="qrlabel" style="margin: 15px 15px 10px 0px;">Merchant Registered Mobile Number<em style="color: red;">*</em></label>
                          <input class="form-control input-txt phone_no border-0 input-focus" name="merchantphone" placeholder="Your Mobile Number" required="" maxlength="10" type="tel" id="merchantphone" pattern='\d{10}'  autocomplete="off" onkeyup="onlynum(this);">
                        </div>

                        <div class="form-group merchant-section">
                          <h5 class="qrlabel" style="margin: 15px 15px 10px 0px;">Merchant Problem<em style="color: red;">*</em></h5>

                          <label><input type="checkbox" name="merchantproblem[]"   value="1"> Next Day Settlement <span class="checkmark"></span></label>
                          <label><input type="checkbox" name="merchantproblem[]"  value="2"> Amount not credited yet <span class="checkmark"></span></label>
                          <label><input type="checkbox" name="merchantproblem[]"  value="3"> QR lost/damaged <span class="checkmark"></span></label>
                          <label><input type="checkbox" name="merchantproblem[]"  value="4"> PhonePe/Paytm team removed QR <span class="checkmark"></span></label>
                          <label><input type="checkbox" name="merchantproblem[]"  value="5"> Transaction message late/not coming <span class="checkmark"></span></label>
                          <label><input type="checkbox" name="merchantproblem[]"  value="6"> Not able to scan QR <span class="checkmark"></span></label>
                          <label><input type="checkbox" name="merchantproblem[]"  value="7"> Low business <span class="checkmark"></span></label>
                          <label><input type="checkbox" name="merchantproblem[]"  value="8"> Customer support <span class="checkmark"></span></label>
                          <label><input type="checkbox" name="merchantproblem[]"  value="9"> Owner not available <span class="checkmark"></span></label>
                          <label><input type="checkbox" name="merchantproblem[]"  value="10"> Cashback Problem (Cashback not credited) <span class="checkmark"></span></label>
                          <label><input type="checkbox" name="merchantproblem[]"  value="11"> Need Cashback <span class="checkmark"></span></label>
                          <label><input type="checkbox" name="merchantproblem[]"  value="12"> Personal Issue <span class="checkmark"></span></label>
                          <label><input type="checkbox" name="merchantproblem[]"  value="13"> No Problem, happy to use <span class="checkmark"></span></label>
                          <label><input type="checkbox" name="merchantproblem[]"  value="14"> Other <span class="checkmark"></span></label>
                      </div>

                    <div class="form-group">
                      <label class="qrlabel" style="margin: 15px 15px 10px 0px;">Loan and cashback explained<em style="color: red;">*</em></label><br>
                      <label><input type="radio" name="loancashback" required="" value="yes"> Yes</label><br>
                      <label><input type="radio" name="loancashback" value="no"> No</label><br>
                    </div>

                    <div class="form-group">
                      <label class="qrlabel" style="margin: 15px 15px 10px 0px;">New app update and it's features explained<em style="color: red;">*</em></label><br>
                      <label><input type="radio" name="appfeature" required="" value="yes"> Yes</label><br>
                      <label><input type="radio" name="appfeature" value="no"> No</label><br>
                    </div>

                    <div class="form-group">
                      <label class="qrlabel" style="margin: 15px 15px 10px 0px;">Merchant satisfied with End of Day settlement<em style="color: red;">*</em></label><br>
                      <label><input type="radio" name="merchantsatisfied" required="" value="yes"> Yes</label><br>
                      <label><input type="radio" name="merchantsatisfied" value="no"> No</label><br>
                    </div>

                    <div class="form-group">
                      <label class="qrlabel" style="margin: 15px 15px 10px 0px;">Merchant ready to accept payments through BharatPe <em style="color: red;">*</em></label><br>
                      <label><input type="radio" name="acceptpayment" required="" value="yes"> Yes</label><br>
                      <label><input type="radio" name="acceptpayment" value="no"> No</label><br>
                    </div>

                    <div class="form-group" required="">
                      <label class="qrlabel"  style="margin: 15px 15px 10px 0px;">Merchant City<em style="color: red;">*</em></label><br>
                      <label><input type="radio" name="merchantcity" required="" value="Bangalore"> Bangalore</label><br>
                      <label><input type="radio" name="merchantcity" value="Delhi"> Delhi</label><br>
                      <label><input type="radio" name="merchantcity" value="Mumbai"> Mumbai</label><br>
                      <label><input type="radio" name="merchantcity" value="Pune"> Pune</label><br>
                    </div>
                    {{ csrf_field() }}
<div class="row">
<div class="col-md-6 col-12">
                    <div class="form-group">
                      <label class="qrlabel" style="margin: 15px 15px 10px 0px;">Scan Qr (App)<em style="color: red;">*</em></label><br>
                      <input type="text" name="scanapp" value="" id="scan_1" required="">
                      <button type="button" style="background-color: grey;" onClick="setvalue('scan_1')" id="firstscan">scan</button>

                    </div>

                    <div class="form-group">
                      <label class="qrlabel" style="margin: 15px 15px 10px 0px;">Scan QR (Sticker)<em style="color: red;">*</em></label>
                      <p style="margin-top: -15px;font-size: 14px;">If no sticker then place order for sticker</p>
                       <input type="text" name="scanqr" value="" id="scan_2" required="">
                      <button type="button" style="background-color: grey;margin-top: 10px;"  onClick="setvalue('scan_2')" id="secondscan">Scan</button>

                    </div>
        </div>
                    <div class="col-md-6 col-12">
                    <div class="preview-container" style="display:none; padding-top: 30px;">
                      <video id="preview" style="max-width: 100%;"></video>
                    </div>
        </div>
                    </div>
        </div>

              <center>
                <button type="submit" id ="checkBtn" class="btn btn-outline-success" style="border-radius: 20px!important;padding: 5px 20px;margin: 20px 0px;" onclick="loadDoc()">Submit</button>
              </center>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
      </div>
    </div>
    <input type="hidden" value="scan_1" id="setvalue">
    <script type="text/javascript" src="{{ URL:: to('app_tracker/app_form.js') }}"></script>

    <script>
    function setvalue(data){

$('#setvalue').val(data);
$('.preview-container').css('display','block');
    }
    </script>
</body>
</html>


