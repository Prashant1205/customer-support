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
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        
        <title>Register Form</title>
        <link rel="stylesheet" href="{{ URL:: to('asset/css/bootstrap.min.css') }}">
 <!-- font-awesome -->
 <link rel="stylesheet" href="{{ URL:: to('asset/css/font-awesome-4.7.0.min.css') }}">
 <!-- open-sans fonts -->
 <link href="{{ URL:: to('asset/css/font-open-sans.css') }}" rel="stylesheet">


  <link rel="stylesheet" href="{{ URL:: to('asset/css/style.css') }}">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">  <!-- font-awesome -->

  <!-- open-sans fonts -->

  <script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>

  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
  $( function() {
    $( "#datepicker" ).datepicker();
    
  } );
  </script>
</head>
<body>
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
        <p style="font-size: 20px;text-align: center;margin-bottom: 10px;color: #463e8d;">Payment Pending Issues</p>
        <p style="color: #68B3C8; text-align: center;">{{ Session::get('message') }} </p>
        <div class="wrapper">
          <form action="{{URL::to('form/process-payment-pending-issue')}}" method="post" enctype="multipart/form-data">
          <div class="container">
            <div class="Qr-ordre-section add-mobile-number">


            </div>


            <div class="whiteBg ordre-section-qr notification_screen">
              <div class="qr-form-sticker">
                <div id="add-mobile-number">
                  <div class="new-mobile-number">
                    <!-- <div class="inputCustom"> -->
                       <div class="form-group" style="margin-bottom: 0px!important;">
<div class="inputCustom">
                                              
                          <label class="qrlabel">Registered No <em style="color:red">*</em></label>
                          <input class="form-control input-txt phone_no border-0 input-focus" pattern='\d{10}' placeholder="Your Mobile Number" maxlength="10" name="phone" type="tel" id="phonenumber" required="" autocomplete="off" onkeyup="onlynum(this);">
                        </div>
                      </div>
                    
                      <div class="form-group" style="margin-bottom: 0px!important;">
                        <label class="qrlabel">Txn History Screenshot <em style="color:red">*</em></label>
                        
                          <div class="form-group" style="margin-top: -25px;">
                            <div class="input-group input-file" name="txn">
                              <input type="text" class="form-control" style="margin-top: 0px;" placeholder='Choose a file...' required=""/>       <span class="input-group-btn">
                                <button class="btn-choose" style="height: 39px;" type="button">Choose</button>
                              </span>
                            </div>
                          </div>
                        
                      </div>
            
                      <div class="clear"></div>

                      <div class="form-group" style="margin-bottom: 0px!important;">
                        <label class="qrlabel">Home Screenshot <em style="color:red">*</em></label> 
                          
                            <div class="form-group" style="margin-top: -25px;">
                              <div class="input-group input-file" name="screenshot">
                                <input type="text" class="form-control" style="margin-top: 0px;" placeholder='Choose a file...' required=""/>      <span class="input-group-btn">
                                        <button class="btn-choose" style="height: 39px;" type="button">Choose</button>
                                      </span>
                              </div>
                            </div>
                          
                      </div>
                    </div>
                  </div>
          
                  <div class="form-group" style="margin-bottom: 0px!important;">
                    <label class="qrlabel">Passbook Photos <em style="color:red">*</em></label>  
                    <div class="form-group" style="margin-top: -25px;">
                      <div class="input-group input-file" name="passbook">
                        <input type="text" class="form-control" style="margin-top: 0px;" placeholder='Choose a file...' required=""/>           
                        <span class="input-group-btn">
                          <button class="btn-choose" style="height: 39px;" type="button">Choose</button>
                        </span>
                      </div>
                    </div>
                  </div>

                  <div class="form-group" style="margin-bottom: 0px!important;">
                        <div class="inputCustom">
                                              
                          <label class="qrlabel">Date of Transaction <em style="color:red">*</em></label><br>
                          <input style="width:100%;" type="text" name="dot" id="datepicker" required="" >
                        </div>
                      </div>


                <div class="form-group" style="margin-bottom: 0px!important;">
                  <label class="qrlabel">Remark <em style="color:red">*</em></label>  
                  <textarea name="remark" required="" class="form-control" rows="5" id="comment"></textarea>
                </div>
                <br><br>
              </div>
                   {{ csrf_field() }}

                   <div class="form-group merchant-section" data-role="page">
                  <div data-role="content">
                    <label><input type="checkbox" name="terms" value="yes" class="cagree" />  By submitting this form ahead you agree to BharatPe terms and condition and Privacy policy<span class="checkmark"></span> </label>
                    
                  </div>
                </div>
                <br><br>
              <center>
              <button disabled type="submit" class="btn btn-outline-success submit" style="border-radius: 20px!important;padding: 5px 20px;margin-bottom: 20px;" onclick="loadDoc()">Submit</button>
              </center>
            </div>
          </div>
                 </form>
        </div>
      </div>      
    </div>
    <script>
  $(".cagree").change (function(e){
if(this.checked){
$(".submit").removeAttr("disabled");
//$('.submit').prop("disabled", false);
} else {
$(".submit").attr("disabled", true);
}
});
</script>
<script src="{{ URL:: to('asset/js/custom.js') }}" type="text/javascript"></script>
<script type="text/javascript">
$("#orderqr_city_category").click(function() {
  if ($("input#state_category").val() !== "") {
    $(".city_tint_bg").fadeIn();
    $(".category_section").animate({bottom: "0%"}, 200);
  } else {
    $("#errorMsg")
      .text("Please selecet state")
      .fadeIn(1000)
      .fadeOut(3000);
  }
});
5

$(document).on(
  "click",
  ".state_category_section .radio_cover label",
  function() {
    console.log('state click');
    $(".state_tint_bg").fadeOut();
    var labeltext = $(this)
      .text()
      .trim();
    $("input#state_category").val(labeltext);



    $(".city_category_section #category_form").empty();
    for (var i = 0; i < cities[labeltext].length; i++) {
      $(".city_category_section #category_form").append(
        "<label><input type='radio' name='radio' value='" +
          cities[labeltext][i] +
          "'><span class='custom_radio'></span>" +
          cities[labeltext][i] +
          "</label>"
      );
    }
  }
);
var cities = {
  "Andhra Pradesh": [
    "Guntur",
    "Hyderabad",
    "Tirupati",
    "Vijayawada",
    "Visakhapatnam"
  ],
  "Arunachal Pradesh": [],
  Assam: ["Guwahati"],
  Bihar: ["Patna"],
  Chhattisgarh: ["Raipur"],
  Delhi: ["Delhi NCR"],
  Goa: ["Goa"],
  Gujarat: ["Ahmedabad", "Rajkot", "Surat", "Vadodara"],
  Haryana: [],
  "Himachal Pradesh": ["Dharamshala", "Manali", "Shimla"],
  "Jammu and Kashmir": ["Jammu", "Srinagar"],
  Jharkhand: ["Jamshedpur"],
  Karnataka: [
    "Bengaluru",
    "Manipal",
    "Mangalore",
    "Mysore",
    "Ooty",
    "Udupi"
  ],
  Kerala: ["Alappuzha", "Kochi", "Palakkad", "Thrissur", "Trivandrum"],
  "Madhya Pradesh": ["Bhopal", "Gwalior", "Indore", "Jabalpur"],
  Maharashtra: [
    "Aurangabad",
    "Goa",
    "Kolhapur",
    "Mumbai",
    "Nagpur",
    "Nashik",
    "Pune"
  ],
  Manipur: [],
  Meghalaya: [],
  Mizoram: [],
  Nagaland: [],
  Odisha: ["Bhubaneswar", "Cuttack"],
  Punjab: ["Amritsar", "Chandigarh", "Jalandhar", "Ludhiana", "Patiala"],
  Rajasthan: [
    "Ajmer",
    "Jaipur",
    "Jodhpur",
    "Kota",
    "Neemrana",
    "Pushkar",
    "Udaipur"
  ],
  Sikkim: [],
  "Tamil Nadu": [
    "Chennai",
    "Coimbatore",
    "Madurai",
    "Salem",
    "Trichy",
    "Vellore"
  ],
  Telangana: [],
  Tripura: [],
  "Uttar Pradesh": [
    "Agra",
    "Allahabad",
    "Gorakhpur",
    "Jhansi",
    "Kanpur",
    "Lucknow",
    "Meerut",
    "Varanasi"
  ],
  Uttarakhand: [
    "Dehradun",
    "Haridwar",
    "Mussoorie",
    "Nainital",
    "Rishikesh"
  ],
  "West Bengal": ["Darjeeling", "Kolkata", "Siliguri"]
};

$(document).on(
  "click",
  ".city_category_section .radio_cover label",
  function() {

    var labeltext = $(this)
      .text()
      .trim();
    $("input#city_category").val(labeltext);
    $("input#orderqr_city_category").val(labeltext);
    $(".city_tint_bg").fadeOut();
    outer :
    for(var state in cities) {

        for(var i = 0; i < cities[state].length; i++) {

            if(cities[state][i] == labeltext) {
                $('body').find("#regstate").val(state);

                break outer;
            }
        }
    }
  }
);


/*======= state_category ======*/
$("#state_category").click(function() {
  $(".state_tint_bg").fadeIn();
  $(".category_section").animate({bottom: "0%"}, 200);
  $("input#orderqr_city_category").val("");
  var states = [
    "Andhra Pradesh",
    "Arunachal Pradesh",
    "Assam",
    "Bihar",
    "Chhattisgarh",
    "Delhi",
    "Goa",
    "Gujarat",
    "Haryana",
    "Himachal Pradesh",
    "Jammu and Kashmir",
    "Jharkhand",
    "Karnataka",
    "Kerala",
    "Madhya Pradesh",
    "Maharashtra",
    "Manipur",
    "Meghalaya",
    "Mizoram",
    "Nagaland",
    "Odisha",
    "Punjab",
    "Rajasthan",
    "Sikkim",
    "Tamil Nadu",
    "Telangana",
    "Tripura",
    "Uttar Pradesh",
    "Uttarakhand",
    "West Bengal"
  ];

  for (var i = 0; i < states.length; i++) {
    $(".state_category_section #category_form").append(
      "<label><input type='radio' name='radio' value='" +
        states[i] +
        "'><span class='custom_radio'></span>" +
        states[i] +
        "</label>"
    );
  }
});
$("input [type=radio]").on('click',function(){
    $(".tint_bg").hide();
})
$(".tint_bg_cover").click(function() {
  $(this).parent().fadeOut();
  // $('.Qr-ordre-section .whiteBg, .Qr-ordre-section .whiteBg2, .profile-numbr-screen .whiteBg').css('z-index','999');
});
$(".tint_bg").click(function() {
  $(this).fadeOut();
  $(".category_section").animate({bottom: "-80%"}, 200);
  $(".Qr-ordre-section .whiteBg, .Qr-ordre-section .whiteBg2").css(
    "z-index",
    "99"
  );
});
</script>
<script type="text/javascript">
    function bs_input_file() {
    $(".input-file").before(
        function() {
            if ( ! $(this).prev().hasClass('input-ghost') ) {
                var element = $("<input type='file' class='input-ghost' style='visibility:hidden; height:0'>");
                element.attr("name",$(this).attr("name"));
                element.change(function(){
                    element.next(element).find('input').val((element.val()).split('\\').pop());
                });
                $(this).find("button.btn-choose").click(function(){
                    element.click();
                });
                $(this).find("button.btn-reset").click(function(){
                    element.val(null);
                    $(this).parents(".input-file").find('input').val('');
                });
                $(this).find('input').css("cursor","pointer");
                $(this).find('input').mousedown(function() {
                    $(this).parents('.input-file').prev().click();
                    return false;
                });
                return element;
            }
        }
    );
}
$(function() {
    bs_input_file();
});
</script>
</body>
</html>
