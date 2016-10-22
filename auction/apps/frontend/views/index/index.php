<script type="text/javascript" src="http://localhost/auction/apps/frontend/public/js/main.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
       getAllItems();
    });
</script>
<div style="float:right;">
    <span style="font-family:Arial;font-weight:bold;font-size:14px;color:#333;">Sort Item By:</span>
    <select id="item_sort" onchange="getAllItems(this.value);">
    <option value="">Sort Item By</option>
    <option value="name"> Name (A - Z)</option>
    <option value="bidding"> Bidding (High - Low)</option>
</select>
</div>
<h2 style="font-family:Arial;color:#4d4d4d;">Items Available At The Auction</h2>
<hr/>
<div id="item_list">
    <div style="text-align:center;"><span id="ajax_list_loader"></span></div>
</div>