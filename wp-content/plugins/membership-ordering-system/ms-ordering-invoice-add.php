<link href="../wp-content/plugins/membership-ordering-system/assets/css/sb-admin-2.min.css" rel="stylesheet" type="text/css">
<link href="../wp-content/plugins/membership-ordering-system/assets/css/agency.css" rel="stylesheet">
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
<style>
    input, select{min-height: 33px}
    [type="number"]::-webkit-inner-spin-button,
    [type="number"]::-webkit-outer-spin-button {
       /*display:none;*/
       padding-right: 5px;
    }
    table tbody tr td{
        word-break: break-word!important;
        word-wrap: break-word!important;
    }
    .no_items1{
        display: table-row;
    }
    .no_items2, .no_items3{
        display: none;
    }
    @media screen and (max-width: 1000px){
        .d-none1{
            display: none;
        }
        .no_items1, .no_items3{
            display: none;
        }
        .no_items2{
            display: table-row;
        }
    }
    @media screen and (max-width: 768px){
        .d-none2{
            display: none;
        }
        .no_items1, .no_items2{
            display: none;
        }
        .no_items3{
            display: table-row;
        }
    }
    .ui-autocomplete-loading {
        background: white url("images/ui-anim_basic_16x16.gif") right center no-repeat;
    }
    .ui-widget.ui-widget-content{
        height: 200px;
        overflow: auto;
    }
    #wpcontent{
        padding-right: 20px;
    }
    #add_product, #product_list{
        font-size: unset;
        line-height: 2;
        min-height: 30px;
    }
    .confirm_button{
        width: 100%;
    }
    .confirm_button input{
        margin-left: calc(25vw - 80px) !important; 
        margin-top: 150px;
    }
    @media screen and (max-width: 782px){
        #add_product, #product_list{
            padding: 0 14px;
            line-height: 2.71428571;
            font-size: 14px;
            vertical-align: middle;
            min-height: 40px;
            margin-bottom: 4px;
        }
        .confirm_button input{
            margin-right: auto !important;
            margin-left: auto !important;
            margin-top: 50px;
        }
    }
</style>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.js"></script> -->
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
<?php
// global $wpdb; 
// $clients = $wpdb->get_results("SELECT * FROM wp_ms_client");
?>

<div class="wrap" style="position: relative;">
	<h1 class="wp-heading-inline">ご発注フォーム</h1>	
	<!-- <input type="button" disabled="disabled" href="#" id="saveProduct" onclick="save_product()" class="upload-view-toggle page-title-action" role="button" aria-expanded="false" value="ご発注確定"> -->
    <!-- <span class="upload">納品書作成</span></button> -->
	<div style="float: right;display: flex;">
		
	</div>
</div>
<div style="display:flex; flex-wrap: wrap">
    <div style="margin-right:5px">
        <div>注文日</div>
        <div><input type="date" id="invoice_date" name="invoice_date" style="width:170px"></div>
    </div>
    <div style="margin-right:5px">
        <div>管理番号</div>
        <div><input id="invoice_num" name="invoice_num" type="text" style="width:170px"></div>
    </div>
    <div style="margin-right:5px">
        <div>サロン名</div>        
        <div>
            <input type="text" name="client" id="client" data-id="" list="client_list"  style="width:170px" onchange="">
        </div>
    </div>
    <div style="margin-right:5px">
        <div>配送先住所</div>
        <div>
            <input type="text" name="address" id="address" readonly style="width:345px" onchange="">
        </div>
    </div>
    <div style="margin-right:5px">
        <div>商品名</div>
        <div>
            <select name="product_list" id="product_list" style="width:170px"></select>
        </div>
    </div>
    <div style="margin-right:5px; display: flex;">
        <div style="margin-right:5px">
            <div>金額</div>
            <div><input type="number" id="price" name="price" style="width:82.5px" readonly="readonly"></div>
        </div>
        <div>
            <div>数量</div>
            <div><input type="number" id="cnt" name="cnt" style="width:82.5px" min="0" onchange="calc_total()"></div>
        </div>
    </div>
    <div style="margin-right:5px">
        <div>総額</div>
        <div><input type="number" id="money" name="money" style="width:170px" readonly="readonly"></div>
    </div>
    <div style="margin-right:5px">
        <div>&nbsp;&nbsp;&nbsp;<!-- 納品希望日時 --></div>
        <div>
            <!-- <input type="datetime-local" id="delivery_date" name="delivery_date" style="width:250px"> -->
            <input type="button" id="add_product" class="button" value="追加" onclick="add_product()">
        </div>
    </div>
</div>

<table class="invoice_list my-3 wp-list-table widefat fixed striped table-view-list posts">
    <thead>
        <tr>
            <th scope="col" class="manage-column column-is_in_stock d-none2">No</th>
            <th scope="col" class="manage-column column-is_in_stock invoice_date">注文日</th>
            <th scope="col" class="manage-column column-is_in_stock invoice_num">管理番号</th>
            <th scope="col" class="manage-column column-is_in_stock client">サロン名</th>
            <th scope="col" class="manage-column column-is_in_stock d-none1">配送先住所</th>
            <th scope="col" class="manage-column column-is_in_stock address">商品名</th>
            <!-- <th>商品名</th> -->
            <th scope="col" class="manage-column column-is_in_stock d-none2">金額</th>
            <th scope="col" class="manage-column column-is_in_stock d-none2">数量</th>
            <th scope="col" class="manage-column column-is_in_stock d-none1">総額</th>
            <!-- <th scope="col" class="manage-column column-is_in_stock d-none2">納品希望日時</th>           -->
        </tr>
    </thead>
    <tbody>
        <tr class="no-items no_items1"><td class="colspanchange" colspan="9">...</td></tr>
        <tr class="no-items no_items2"><td class="colspanchange" colspan="7">...</td></tr>
        <tr class="no-items no_items3"><td class="colspanchange" colspan="4">...</td></tr>
    </tbody>
    <tfoot>
        <tr>
            <th scope="col" class="manage-column column-is_in_stock d-none2">No</th>
            <th scope="col" class="manage-column column-is_in_stock invoice_date">注文日</th>
            <th scope="col" class="manage-column column-is_in_stock invoice_num">管理番号</th>
            <th scope="col" class="manage-column column-is_in_stock client">サロン名</th>
            <th scope="col" class="manage-column column-is_in_stock d-none1">配送先住所</th>
            <th scope="col" class="manage-column column-is_in_stock address">商品名</th>
            <!-- <th>商品名</th> -->
            <th scope="col" class="manage-column column-is_in_stock d-none2">金額</th>
            <th scope="col" class="manage-column column-is_in_stock d-none2">数量</th>
            <th scope="col" class="manage-column column-is_in_stock d-none1">総額</th>
            <!-- <th scope="col" class="manage-column column-is_in_stock d-none2">納品希望日時</th>           -->
        </tr>
    </tfoot>
</table>
<div class="text-dark font-weight-bolder" style="width: 97%; display: flex; justify-content: flex-end;">
    発注総額 &nbsp;&nbsp;:&nbsp;&nbsp;<span class="total_money">0円</span>
</div>
<div class="wrap d-flex justify-content-start confirm_button">
    <input type="button" disabled="disabled" href="#" id="saveProduct" onclick="save_product()" class="upload-view-toggle page-title-action" role="button" aria-expanded="false" value="ご発注確定">
</div>
<script>

    jQuery( function() {
     
        jQuery( "#client" ).autocomplete({
          source: function( request, response ) {
            jQuery.ajax( {
              url: "../wp-content/plugins/membership-ordering-system/ajax-shop.php",
              dataType: "json",
              data: {
                search: request.term,
                shop:'',
                ajax:'ajax',
                to:'clients'
              },
              success: function( data ) {
                response( data );
              }
            } );
          },
          minLength: 1,
          select: function( event, ui ) {
            jQuery(this).attr('data-id', ui.item.id);
            jQuery("#address").val(ui.item.address);
            jQuery('#address').attr('title', ui.item.address);
            get_products(ui.item.shop);
            // get_products('');
            // console.log( "Selected: " + ui.item.value + " aka " + ui.item.id );
          }
        } );
  } );

    // jQuery("body").on("input", "#client", function (e) {
    //     var inputValue = jQuery(this).val();
    //     if(inputValue == '')
    //         return;

    //     var options = document.querySelectorAll('#client_list option');
       
    //     for(var i = 0; i < options.length; i++) {
    //         var option = options[i];
    //         if(option.innerText === inputValue) {
    //             var address = option.getAttribute('data-address');
    //             var id = option.getAttribute('data-id');
    //             jQuery(this).attr('data-id', id);
    //             jQuery("#address").val(address);
    //             jQuery('#address').attr('title', address);
    //             get_products(option.getAttribute('data-shop'));
    //             return;
    //         }
    //     }
    //     jQuery("#address").val('');
    // });
    jQuery("body").on("change", "#product_list", function(e) {
        if(jQuery.trim(jQuery(this).val()) == ''){
            jQuery("#price").val('');
            jQuery("#money").val('');
            return;
        }
        var v = jQuery.trim(jQuery(this).val());
        jQuery("#price").val(jQuery('#product_list option[value='+v+']').data('price'));
        jQuery("#money").val(jQuery("#price").val() * jQuery("#cnt").val());
    });

    // jQuery("input[name='product_list']").on('input', function(e){
    //     var inputValue = jQuery(this).val();

    //     var options = document.querySelectorAll('#product_list option');
       
    //     for(var i = 0; i < options.length; i++) {
    //         var option = options[i];

    //         if(jQuery.trim(option.innerText) === jQuery.trim(inputValue)) {
    //             jQuery("#price").val(option.getAttribute('price-value'));
    //             jQuery("#money").val(jQuery("#price").val() *jQuery("#cnt").val());
    //             jQuery("#sel_product_id").val(option.getAttribute('data-value'));
    //             return;
    //         }
    //     }
    //     jQuery("#price").val('');
    //     jQuery("#money").val('');
    //     jQuery("#sel_product_id").val('');
    // });
    var json_arry = new Array();
    function save_product(){

        jQuery.ajax({
            url: "../wp-content/plugins/membership-ordering-system/ajax-shop.php",
            type: "post",
            data: {
                search:'',
                shop:json_arry,
                ajax:'ajax',
                to:'save_product'
            },
            /* remind that 'data' is the response of the AjaxController */
            success: function (data) {
                // if(jQuery.trim(data) == 'ok')
                //     location.href = "";
            },
            error: function (data, textStatus, errorThrown) {
                console.log(data);
            },
        });
    }
    
    function add_product(){
        jQuery("table tbody tr.no-items").addClass('d-none');
        if(jQuery("#invoice_date").val() == ""){
            return false;
        }
        if(jQuery("#invoice_num").val() == ""){
            return false;
        }
        // if(jQuery("#shop").val() == ""){
        //     return false;
        // }
        if(jQuery("#client").val() == ""){
            return false;
        }
        if(jQuery("#product_list").val() == ""){
            return false;
        }
        // if(jQuery("#sel_product_id").val() == ""){
        //     return false;
        // }
        if(jQuery("#price").val() == ""){
            return false;
        }
        if(jQuery("#cnt").val() == ""){
            return false;
        }
        if(jQuery("#money").val() == ""){
            return false;
        }
        // if(jQuery("#delivery_date").val() == ""){
        //     return false;
        // }
        var row_arry = { 
            "invoice_date": jQuery("#invoice_date").val(), 
            "invoice_num": jQuery("#invoice_num").val(), 
            "client": jQuery("#client").val(), 
            "client": jQuery("#client").val(),
            "client_id" : jQuery("#client").data('id'),
            "address": jQuery("#address").val(), 
            "product_list": jQuery("#product_list option[value="+jQuery("#product_list").val()+"]").html(), 
            "sel_product_id": jQuery("#product_list").val(),
            "price": jQuery("#price").val(), 
            "cnt": jQuery("#cnt").val(), 
            "money": jQuery("#money").val(), 
            // "delivery_date": jQuery("#delivery_date").val(),
        
        };
        json_arry.push(row_arry);

        var markup = "<tr><td class='d-none2'>"+(jQuery('table tbody tr').length)+"</td><td>" + jQuery("#invoice_date").val() + "</td><td>" + jQuery("#invoice_num").val() + "</td><td>" + jQuery("#client").val() + 
                    "</td><td class='d-none1'>" + jQuery("#address").val() + "</td>"+ "<td>" + jQuery("#product_list option[value="+jQuery("#product_list").val()+"]").html() +
                    "</td><td class='d-none2'>" + parseFloat(jQuery("#price").val()).toLocaleString() + 
                    "円</td><td class='d-none2'>" + parseFloat(jQuery("#cnt").val()).toLocaleString() + "</td>" + "<td class='d-none1'>" + parseFloat(jQuery("#money").val()).toLocaleString() + "円<span class='money' style='display:none'>"+jQuery("#money").val()+"</span></td>";
            // markup += "<td class='d-none2'>" + jQuery("#delivery_date").val() + "</td>";
            markup += "</tr>";
        jQuery("table tbody").append(markup);
        var t_m = 0;
        jQuery('.money').each(function(){
            var m = Number(jQuery.trim(jQuery(this).html()));
            t_m += m;
        });
        jQuery('.total_money').html(t_m.toLocaleString()+'円');
        jQuery('#saveProduct').prop('disabled', false);
    }
    function calc_total(){
        
        var m = jQuery("#price").val() * jQuery("#cnt").val();    
        jQuery("#money").val(m);

    }
    function get_products(shop){

        jQuery.ajax({
            url: "../wp-content/plugins/membership-ordering-system/ajax-shop.php",
            type: "post",
            data: {
                search:'',
                shop:shop,
                ajax:'ajax',
                to:'products'
            },
            /* remind that 'data' is the response of the AjaxController */
            success: function (data) {
                //alert(data);
                var pList = JSON.parse(data);
                var pTagList = "<option value=''></option>";
               
                for(var i = 0; i < pList.length; i++){         
                    if(pList[i].sale != 0)    
                        pTagList += '<option value="'+pList[i].id+'" data-price="'+pList[i].sale+'" >'+pList[i].name+'</option>';
                    else
                        pTagList += '<option value="'+pList[i].id+'" data-price="'+pList[i].regular+'" >'+pList[i].name+'</option>';
                }

                jQuery("#product_list").html(pTagList);
            },
            error: function (data, textStatus, errorThrown) {
                console.log(data);
            },
        });
    }
</script>