$(document).ready(function(){
    $("#bid_amount").keydown(function(e){
        var value = String.fromCharCode(e.keyCode);
        if(isNaN(value) && e.keyCode != 8 && e.keyCode != 190)
        {
            return false;
        }
        return true;
    });
    
   $("#post_bid_btn").click(function(){
      var bidder_name = $("#name").val();
      var bidding_amount = $("#bid_amount").val();
      var details = $("#details").val();
      var item_id = $("#item_id").val();
      if(isFormValid() == true)
      {
          postBidding(bidder_name, bidding_amount, details, item_id);
      }
      else
      {
          
      }
   });
   
   $("#bidding_form input").keydown(function(event){
      if(event.keyCode == 13)
      {
         var bidder_name = $("#name").val();
      var bidding_amount = $("#bid_amount").val();
      var details = $("#details").val();
      var item_id = $("#item_id").val();
      if(isFormValid() == true)
      {
          postBidding(bidder_name, bidding_amount, details, item_id);
      }
      else
      {
          
      } 
      }
   });
});

function postBidding(bidder_name, bidding_amount, details, item_id)
{
    $.ajax({
        type: "POST",
        url: "http://localhost/auction/rest/api/v1/biddings",
        data: {item_id: item_id, details: details, bid_amount: bidding_amount, name: bidder_name},
        beforeSend: function(){
           $("#post_loader").html("<img src='http://localhost/auction/apps/frontend/public/images/ajax_loader.gif' style='vertical-align:middle;'/>"); 
        },
        success: function(data){
            $("#post_loader").html("");
        }   
    });
}

function isFormValid()
{
      var bidder_name = $("#name").val();
      var bidding_amount = $("#bid_amount").val();
      var details = $("#details").val();
      var error_free = true;
      if(bidder_name == "")
      {
          $("#name_msg").css({"font-family":"Arial", "font-size":"12px", "color":"#e60000"});
          $("#name_msg").html("Please enter your name.");
          $("#name").css("border", "2px solid #e60000");
          error_free = false;
      }
      else
      {
          $("#name_msg").html("");
          $("#name").css("border", "2px solid #B8B8B8");
      }
      if(bidding_amount == "")
      {
          $("#amt_msg").css({"font-family":"Arial", "font-size":"12px", "color":"#e60000"});
          $("#amt_msg").html("Please enter the bidding amount.");
          $("#bid_amount").css("border", "2px solid #e60000");
          error_free = false;
      }
      else
      {
          $("#amt_msg").html("");
          $("#bid_amount").css("border", "2px solid #B8B8B8");
      }
      if(details == "")
      {
          $("#details_msg").css({"font-family":"Arial", "font-size":"12px", "color":"#e60000"});
          $("#details_msg").html("Please enter the details.");
          $("#details").css("border", "2px solid #e60000");
          error_free = false;
      }
      else
      {
          $("#details_msg").html("");
          $("#details").css("border", "2px solid #B8B8B8");
      }
      return error_free;
}