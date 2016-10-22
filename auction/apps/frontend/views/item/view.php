<script type="text/javascript" src="http://localhost/auction/apps/frontend/public/js/main.js"></script>
<script type="text/javascript" src="http://localhost/auction/apps/frontend/public/js/validation.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
       var item_id = $("#item_id").val();
       getBiddings(item_id);
       setInterval(getBiddings, 1000, item_id);
    });
</script>
<h2 style="font-family:Arial;color:#4d4d4d;"><?php echo $title; ?></h2>
<hr/>
<div id="item_content">
    <?php foreach($item_details as $detail): ?>
    <img src="http://localhost/auction/apps/frontend/public/<?php echo $detail["image_url"]; ?>" alt="<?php echo $detail["name"]; ?>" style="width:600px;border:1px solid #eee;"/>
    <br/><br/>
    <h3 style="font-family:Arial;color:#333;">Description</h3>
    <hr/>
    <span style="font-family:Arial;color:#4d4d4d;font-size:14px;"><?php echo $detail["description"]; ?></span>
    <input type="hidden" value="<?php echo $detail["id"]; ?>" id="item_id"/>
    <?php endforeach; ?>
    <br/><br/>
    <h3 style="font-family:Arial;color:#333;">Biddings</h3>
    <hr/>
    <!--<input type="button" value="Post Your Bidding" style="float:right;" id="bidding_link"/>-->
    <div id="user_biddings">
        <div style="text-align:center;"><span id="ajax_loader"></span></div>
    </div>
    <div id="bidding_form">
        <span style="font-family:Arial;font-size:17px;color:#333;font-weight:bold;">Bidding Form.</span><span style="font-family:Arial;font-size:13px;color:#4d4d4d;"> All fields required.</span>
        <hr/>
        <label for="name">Your Name: </label><span id="name_msg"></span><input type="text" placeholder="Your Name" id="name"/>
        <label for="bid_amount">Bidding Amount: </label><span id="amt_msg"></span><input type="text" placeholder="Bidding Amount" id="bid_amount"/>
        <label for="details">Details: </label><span id="details_msg"></span><textarea placeholder="Details" id="details"></textarea>
        <input type="button" id="post_bid_btn" value="Bid Item"/>
        <span id="post_loader"></span>
    </div>
</div>