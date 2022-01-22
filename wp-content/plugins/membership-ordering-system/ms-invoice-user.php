<?php
global $wpdb; 
$user = wp_get_current_user();
// $clients = $wpdb->get_results($wpdb->prepare("SELECT * FROM wp_ms_client where mail = %s", $user->user_email));
$clients = $wpdb->get_results("SELECT * FROM wp_ms_client where mail = 'moon.rider.dev@gmail.com'");
$client = $clients[0];
$products = $wpdb->get_results($wpdb->prepare("SELECT * FROM wp_ms_products where shop_id = %s", isset($client->shop_id) ? $client->shop_id : ''));
$invoices = $wpdb->get_results("SELECT max(invoice_num) as invoice_num FROM wp_ms_invoice");
$invoice_num = 1 + (int)$invoices[0]->invoice_num;
// $client = $clients[0];
// $invoiceLists = $wpdb->get_results("SELECT * FROM wp_ms_invoice where history_id='".$_REQUEST['invoice']."'");
//var_export($invoiceList);
?>
<link href="<?php echo plugin_dir_url( __FILE__) ?>/assets/css/sb-admin-2.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
<style type="text/css">
    button, input[type="text"], select, input[type="button"], input[type="number"]{
        height: 30px !important;
        margin:unset !important;
        line-height: 1 !important;
    }
    table.invoice_list tbody tr td{
        word-break: break-word!important;
        word-wrap: break-word!important;
    }
    @media screen and (max-width: 1200px){
        .d-none1{
            display: none;
        }
    }
    @media screen and (max-width: 768px){
        .d-none2{
            display: none;
        }
    }
    table.invoice_list th{
        background-color:unset !important;
        color: #000 !important;
    }
    .btn-primary {
        color: #fff !important;
        background-color: #4e73df !important;
        border-color: #4e73df !important;
    }
</style>
<div class="" style="width: 100% !important;font-size: 16px">
    <div class="w-100 mb-2">
        <div style="display:flex; flex-wrap: wrap">
            <div style="padding-right:5px; width: 18%;min-width: 150px">
                <div>注文日</div>
                <div><input type="text" class="p-1" id="invoice_date" name="invoice_date" value="<?php echo date('Y-m-d'); ?>" style="width:100%" readonly></div>
                <input type="hidden" name="invoice_num" id="invoice_num" value="<?php echo isset($invoice_num) ? $invoice_num : '' ?>">
                <input type="hidden" name="client_code" id="client_code" value="<?php echo isset($client) ? $client->client_code : '' ?>">
                <input type="hidden" name="client" id="client" value="<?php echo $client->name ?>">
                <input type="hidden" name="client_id" id="client_id" value="<?php echo $client->id ?>">
                <input type="hidden" name="address" id="address" value="<?php echo isset($client) ? ($client->shipping_info == '' ? $client->client_pref.'  '.$client->client_city.'  '.$client->address : $client->shipping_info) : '';  ?>">
            </div>
            <div style="padding-right:5px; width: 18%;min-width: 150px">
                <div>商品名</div>
                <div>
                    <select name="product_list" id="product_list" class="p-1" style="width:100%">
                        <option value=""></option>
                        <?php
                            foreach ($products as $product) {
                                echo '<option value="'.$product->id.'" data-price="'.($product->sale != 0 ? $product->sale : $product->regular).'">'.$product->name.'</option>';
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div style="padding-right:5px; width: 18%;min-width: 150px">
                <div>金額</div>
                <div><input type="number" id="price" name="price" class="p-1" style="width:100%" readonly></div>
            </div>
            <div style="padding-right:5px; width: 18%;min-width: 150px">
                <div>数量</div>
                <div><input type="number" id="cnt" name="cnt" class="p-1" style="width:100%" min="0" onchange="calc_total()"></div>
            </div>
            <!-- <div style="margin-right:5px; display: flex;">
                <div style="margin-right:5px">
                    <div>金額</div>
                    <div><input type="number" id="price" name="price" class="p-1" style="width:82.5px" readonly></div>
                </div>
                <div>
                    <div>数量</div>
                    <div><input type="number" id="cnt" name="cnt" class="p-1" style="width:82.5px" min="0" onchange="calc_total()"></div>
                </div>
            </div> -->
            <div style="padding-right:5px; width: 18%;min-width: 150px">
                <div>総額</div>
                <div><input type="number" id="money" name="money" class="p-1" style="width:100%" readonly></div>
            </div>
            <div style="; width: 10%;min-width: 45px; text-align: right;">
                <div>&nbsp;&nbsp;&nbsp;<!-- 納品希望日時 --></div>
                <div>
                    <!-- <input type="datetime-local" id="delivery_date" name="delivery_date" style="width:250px"> -->
                    <input type="button" id="add_product" class="btn btn-primary py-1 px-0" style="font-size: 16px; width: 100%;" value="追加" onclick="add_product()">
                </div>
            </div>
        </div>
    </div>    
    <table class="invoice_list" border="1" style="margin-top:10px;width: 100%;">
        <thead>
            <tr>
                <th class="d-none1 py-2 pl-1" style="width: 10%">受注番号</th>
                <th class="invoice_date py-2 pl-1" style="width: 20%">注文日</th>    
                <th class="product py-2 pl-1" style="width: 25%">商品名</th>
                <th class="moneys py-2 pl-1" style="width: 15%">金額</th>
                <th class="cnts py-2 pl-1" style="width: 15%">数量</th>
                <th class="totals d-none1 py-2 pl-1" style="width: 15%">総額</th>
                <!-- <th class="d-none2">納品希望日時</th>           -->
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
    <div class="text-right mt-5">
        発注総額 &nbsp;&nbsp;:&nbsp;&nbsp;<span class="total_money">0</span>円
    </div>
    <div class="d-flex">
        <input type="button" class="btn btn-primary px-2 py-1" name="confirm_btn" id="confirm_btn" style="font-size: 16px" onclick="save_product()" value="ご発注確定">
    </div>
</div>
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
<script type="text/javascript">
    // jQuery("body").on("click", "#confirm_btn", function(e) {
    //     jQuery.ajax( {
    //       url: "../wp-content/plugins/membership-ordering-system/ajax-shop.php",
    //       type: "get",
    //       data: {
    //         invoice:'<?php //echo $_REQUEST['invoice']; ?>',
    //         to:'confirm'
    //       },
    //       success: function( data ) {
    //         if(jQuery.trim(data) == 'ok'){
    //             location.href = '<?php //echo get_bloginfo('url') ?>';
    //         }
    //       }
    //     } );
    // });
    jQuery(function(){     
        // jQuery("#client").autocomplete({
        //     source: function(request, response){
        //         jQuery.ajax( {
        //             url: "../wp-content/plugins/membership-ordering-system/ajax-shop.php",
        //             dataType: "json",
        //             data: {
        //                 search: request.term,
        //                 shop:'',
        //                 ajax:'ajax',
        //                 to:'clients'
        //             },
        //             success: function( data ) {
        //                 response(data);
        //             }
        //         });
        //     },
        //     minLength: 1,
        //     select: function( event, ui ) {
        //         jQuery(this).attr('data-id', ui.item.id);
        //         jQuery("#address").val(ui.item.address);
        //         jQuery('#address').attr('title', ui.item.address);
        //         get_products(ui.item.shop);
        //     }
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
    });
    var json_arry = new Array();
    function save_product(){
        jQuery.ajax({
            url: "<?php echo plugin_dir_url( __FILE__) ?>/ajax-shop.php",
            type: "post",
            data: {
                search:'',
                shop:json_arry,
                ajax:'ajax',
                fromClient : 1,
                to:'save_product'
            },
            /* remind that 'data' is the response of the AjaxController */
            success: function (data) {
                if(jQuery.trim(data) == 'ok')
                    location.href = "";
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
        if(jQuery("#product_list").val() == ""){
            return false;
        }
        if(jQuery("#price").val() == ""){
            return false;
        }
        if(jQuery("#cnt").val() == ""){
            return false;
        }
        if(jQuery("#money").val() == ""){
            return false;
        }
        var row_arry = {
            "invoice_date": jQuery("#invoice_date").val(), 
            "client_code": jQuery("#client_code").val(), 
            "client": jQuery("#client").val(), 
            "client_id" : jQuery("#client_id").val(),
            "address": jQuery("#address").val(), 
            "product_list": jQuery("#product_list option[value="+jQuery("#product_list").val()+"]").html(), 
            "sel_product_id": jQuery("#product_list").val(),
            "price": jQuery("#price").val(), 
            "cnt": jQuery("#cnt").val(), 
            "money": jQuery("#money").val(), 
            // "delivery_date": jQuery("#delivery_date").val(),
        
        };
        json_arry.push(row_arry);

        var markup = "<tr><td class='d-none1 py-2 pl-1'>"+jQuery('#invoice_num').val()+"</td><td class='py-2 pl-1'>" + jQuery("#invoice_date").val() + "</td><td class='py-2 pl-1'>" + jQuery("#product_list option[value="+jQuery("#product_list").val()+"]").html() +
                    "</td><td class='py-2 pl-1'>" + parseFloat(jQuery("#price").val()).toLocaleString() + 
                    "円</td><td class='py-2 pl-1'>" + parseFloat(jQuery("#cnt").val()).toLocaleString() + "</td>" + "<td class='d-none1 py-2 pl-1'>" + parseFloat(jQuery("#money").val()).toLocaleString() + "円<span class='money' style='display:none'>"+jQuery("#money").val()+"</span></td>";
            markup += "</tr>";
        jQuery("table tbody").append(markup);
        var t_m = 0;
        jQuery('.money').each(function(){
            var m = Number(jQuery.trim(jQuery(this).html()));
            t_m += m;
        });
        jQuery('.total_money').html(t_m.toLocaleString());
        jQuery('#saveProduct').prop('disabled', false);
    }
    function calc_total(){
        
        var m = jQuery("#price").val() * jQuery("#cnt").val();    
        jQuery("#money").val(m);

    }
    // function get_products(shop){

    //     jQuery.ajax({
    //         url: "../wp-content/plugins/membership-ordering-system/ajax-shop.php",
    //         type: "post",
    //         data: {
    //             search:'',
    //             shop:shop,
    //             ajax:'ajax',
    //             to:'products'
    //         },
    //         /* remind that 'data' is the response of the AjaxController */
    //         success: function (data) {
    //             //alert(data);
    //             var pList = JSON.parse(data);
    //             var pTagList = "<option value=''></option>";
               
    //             for(var i = 0; i < pList.length; i++){         
    //                 if(pList[i].sale != 0)    
    //                     pTagList += '<option value="'+pList[i].id+'" data-price="'+pList[i].sale+'" >'+pList[i].name+'</option>';
    //                 else
    //                     pTagList += '<option value="'+pList[i].id+'" data-price="'+pList[i].regular+'" >'+pList[i].name+'</option>';
    //             }

    //             jQuery("#product_list").html(pTagList);
    //         },
    //         error: function (data, textStatus, errorThrown) {
    //             console.log(data);
    //         },
    //     });
    // }
</script>