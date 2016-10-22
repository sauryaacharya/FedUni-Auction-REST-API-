function getAllItems(sort_by)
{
    sort_by = sort_by || "";
    if(sort_by)
    {
        sort_by = "/sorting/"+sort_by;
    }
    var item_list = $("#item_list");
    $.ajax({
        type: "GET",
        url: "http://localhost/auction/rest/api/v1/items"+sort_by,
        beforeSend: function(){
            $("#ajax_list_loader").html("<img src='http://localhost/auction/apps/frontend/public/images/ajax_loader.gif'/><br/><span style='font-family:Arial;font-size:13px;color:#4d4d4d;'>Loading</span>");
        },
        success: function(data){
            $("#ajax_list_loader").html("");
            item_list.html(getItemListHtml(data));
            
        }
        
    });
}

function getItemListHtml(json_arr)
{
    var i;
    var arr_length = json_arr.items.length;
    var html = "";
    for(i = 0; i < arr_length; i++)
    {
        var desc = json_arr.items[i].description;
        html += '<div class="each_item">';
        html += '<div class="item_cont" style="text-align:justify;">';
        html += '<h4 style="font-family:Arial;"><a href="http://localhost/auction/item/view/'+json_arr.items[i].id+'">'+json_arr.items[i].name+'</a></h4>';
        html += '<span class="desc_cont">'+desc.substring(0, 400)+'....'+'</span>';
        html += '</div>';
        html += '<img width="120" height="120" src="http://localhost/auction/apps/frontend/public/'+json_arr.items[i].image_url+'" style="vertical-align:middle;" alt="'+json_arr.items[i].name+'"/>';
        html += '</div>';
        
    }
    return html;
}

function getBiddings(item_id)
{
    $.ajax({
        type: "GET",
        url: "http://localhost/auction/rest/api/v1/items/"+item_id,
        beforeSend: function(){
           $("#ajax_loader").html("<img src='http://localhost/auction/apps/frontend/public/images/ajax_loader.gif'/><br/><span style='font-family:Arial;font-size:13px;color:#4d4d4d;'>Loading</span>"); 
        },
        success: function(data){
            //alert(data.items[0].biddings);
            if(data.items[0].biddings == "null")
            {
                $("#user_biddings").html("<span style='font-family:Arial;font-size:14px;color:#595959;'>No biddings yet.</span>");
            }
            else
            {
            $("#user_biddings").html(getBiddingHtml(data));
        }
            $("#ajax_loader").html("");
        }   
    });
}

function getBiddingHtml(json_arr)
{
    var i;
    var html = "";
    var arr_length = json_arr.items[0].biddings.length;
    for(i = 0; i < arr_length; i++)
    {
        html += '<div class="each_bidding">';
        html += '<div class="bidder_name" style="font-family:Arial;font-weight:bold;color:#006680;font-size:14px;padding-bottom:4px;">'+json_arr.items[0].biddings[i].bidder_name+'</div>';
        html += '<div class="amount"><span style="font-family:Arial;color:#4d4d4d;font-weight:bold;font-size:13px;">Bid Amount:</span><span style="font-family:Arial;color:#595959;font-size:13px;">$'+json_arr.items[0].biddings[i].bid_amount+'</span></div>';
        html += '<div class="bidding_cont" style="font-family:Arial;font-size:13px;color:#595959;">'+json_arr.items[0].biddings[i].details+'</div>';
        html += '</div>';
    }
    return html;
}