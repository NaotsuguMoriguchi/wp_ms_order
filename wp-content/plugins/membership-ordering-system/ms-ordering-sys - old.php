
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
<link href="../wp-content/plugins/membership-ordering-system/assets/css/sb-admin-2.min.css" rel="stylesheet" type="text/css">
<link href="../wp-content/plugins/membership-ordering-system/assets/css/all.css" rel="stylesheet" type="text/css">
<!-- <link href="../wp-content/plugins/membership-ordering-system/assets/css/agency.css" rel="stylesheet"> -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
<style>
    input, select{min-height: 33px}
    [type="number"]::-webkit-inner-spin-button,
    [type="number"]::-webkit-outer-spin-button {
       /*display:none;*/
       padding-right: 5px;
    }
    table tbody tr td{
        word-break: break-word;
    }
    @media screen and (max-width: 1000px){
        .d-none1{
            display: none;
        }
    }
    @media screen and (max-width: 768px){
        .d-none2{
            display: none;
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
    .h_item{
        cursor: pointer;
    }
    .modal-header .close{
        margin-right: 0px !important;
    }
    #modal_table_2{
        z-index: 20000;
    }
    #modal_table_2 .modal-dialog{
        margin: 0px;
        margin-left: 170px;
        max-width: calc(100% - 180px);
    }
    @media only screen and (max-width: 960px){
        #modal_table_2 .modal-dialog{
            margin-left: 36px;
            max-width: calc(100% - 40px);
        }
    }
    @media screen and (max-width: 782px){
        #modal_table_2 .modal-dialog{
            margin-left: 10px;
            max-width: calc(100% - 20px);
        }
    }
</style>
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
<?php
global $wpdb; 
// $clients = $wpdb->get_results("SELECT * FROM wp_ms_client");

$allPosts = $wpdb->get_results("SELECT * FROM wp_ms_invoice_history");
$allcount = count($allPosts);
$rowperpage = 20;
$posts = $wpdb->get_results("SELECT * FROM wp_ms_invoice_history order by `time` desc limit 0, ".$rowperpage);
?>

<div class="mt-4 mb-2" style="display:flex; flex-wrap: wrap">
    <div style="margin-right:5px">
        <div>注文日</div>
        <div>
            <input type="date" id="invoice_date" name="invoice_date" style="width:170px"> - 
            <input type="date" id="invoice_date1" name="invoice_date1" style="width:170px">
        </div>
    </div>

    <div style="margin-right:5px">
        <div>サロン名</div>        
        <div>
            <input type="text" name="client" id="client" data_id=""  style="width:170px" />
            <!-- <datalist id="client_list">  -->
                <?php
                    // foreach($clients as $client){
                ?>
                        <!-- <option
                            data-id="<?php echo $client->id ?>"
                            data-shop="<?php echo $client->shop ?>" 
                            data-address="<?php if(!empty($client->shipping_info))echo $client->shipping_info;else echo $client->address ?>" 
                            value="<?php echo $client->name ?>"><?php echo $client->name ?></option> -->
                <?php
                    // }
                ?>
            <!-- </datalist> -->
            <!-- <select id="shop" name="shop" style="width: 150px; min-height: 34px" onchange="sel_client()"> -->
                <!-- <option value="">代理店を選択</option> -->
            
            <!-- </select> -->
        </div>
    </div>
    <div style="margin-right:5px">
        <div>商品名</div>
        <div>
            <input type="text" name="product_list" list="product_list"  style="width:170px">
            <datalist id="product_list">
             
            </datalist>
            <input type="hidden" name="sel_product_id" id="sel_product_id">
        </div>
    </div>
</div>
<table class="wp-list-table widefat fixed striped table-view-list posts">
    <thead>
        <tr>
            <th scope="col" class="manage-column column-is_in_stock d-none2">No</th>
            <th scope="col" class="manage-column column-is_in_stock d-none2">注文日</th>
            <th scope="col" class="manage-column column-is_in_stock">管理番号</th>
            <th scope="col" class="manage-column column-is_in_stock">サロン名</th>
            <th scope="col" class="manage-column column-is_in_stock">商品名</th>
            <th scope="col" class="manage-column column-is_in_stock">状態</th>
        </tr>
    </thead>
    <tbody id="the-list" class="history_list_body">        
        <?php
            $idx = 0;
            if(count($posts) < 1)
                echo '<tr class="no-item"><td class="colspanchange" colspan="6">...</td></tr>';
            foreach($posts as $post){
                $idx++;
                echo '<tr data-id="'.$post->history_id.'" class="h_item iedit author-self level-0 post-83 type-product status-publish has-post-thumbnail hentry product_cat-uncategorized">';
                echo '<td class="product_tag column-product_tag d-none2">'.$idx.'</td>';
                echo '<td class="product_tag column-product_tag d-none2">'.$post->invoice_date.'</td>';
                echo '<td class="product_tag column-product_tag">'.$post->invoice_num.'</td>';
                echo '<td class="product_tag column-product_tag">'.$post->client.'</td>';
                echo '<td class="product_tag column-product_tag">'.$post->products.'</td>';
                echo '<td class="product_tag column-product_tag">'.$post->state.'</td>';
                echo '</tr>';
            }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th scope="col" class="manage-column column-is_in_stock d-none2">No</th>
            <th scope="col" class="manage-column column-is_in_stock d-none2">注文日</th>
            <th scope="col" class="manage-column column-is_in_stock">管理番号</th>
            <th scope="col" class="manage-column column-is_in_stock">サロン名</th>
            <th scope="col" class="manage-column column-is_in_stock">商品名</th>
            <th scope="col" class="manage-column column-is_in_stock">状態</th>
        </tr>
    </tfoot>
</table>
<div class="modal fade" id="modal_table_2" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl justify-content-center">
        <div class="modal-content col-12">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_table_2_title">&nbsp;</h5>
                <button class="close dashicons dashicons-no btn-close"><span class="screen-reader-text">Close details dialog</span></button>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times ml-2" aria-hidden="true"></i></button> -->
            </div>
            <div class="modal-body mx-1">
                <div class="row h-100">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <table  class="wp-list-table widefat fixed striped table-view-list posts" style="margin-top:10px;width: 97%;">
                            <thead>
                                <tr>
                                    <th scope="col" class="manage-column column-is_in_stock d-none2">No</th>
                                    <th scope="col" class="manage-column column-is_in_stock d-none2">注文日</th>
                                    <th scope="col" class="manage-column column-is_in_stock">管理番号</th>
                                    <th scope="col" class="manage-column column-is_in_stock">サロン名</th>
                                    <th scope="col" class="manage-column column-is_in_stock d-none1">配送先住所</th>
                                    <th scope="col" class="manage-column column-is_in_stock">商品名</th>
                                    <th scope="col" class="manage-column column-is_in_stock d-none2">金額</th>
                                    <th scope="col" class="manage-column column-is_in_stock d-none2">数量</th>
                                    <th scope="col" class="manage-column column-is_in_stock d-none1">総額</th>
                                    <th scope="col" class="manage-column column-is_in_stock d-none2">納品希望日時</th>
                                </tr>
                            </thead>
                            <tbody class="details_list_body">

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th scope="col" class="manage-column column-is_in_stock d-none2">No</th>
                                    <th scope="col" class="manage-column column-is_in_stock d-none2">注文日</th>
                                    <th scope="col" class="manage-column column-is_in_stock">管理番号</th>
                                    <th scope="col" class="manage-column column-is_in_stock">サロン名</th>
                                    <th scope="col" class="manage-column column-is_in_stock d-none1">配送先住所</th>
                                    <th scope="col" class="manage-column column-is_in_stock">商品名</th>
                                    <th scope="col" class="manage-column column-is_in_stock d-none2">金額</th>
                                    <th scope="col" class="manage-column column-is_in_stock d-none2">数量</th>
                                    <th scope="col" class="manage-column column-is_in_stock d-none1">総額</th>
                                    <th scope="col" class="manage-column column-is_in_stock d-none2">納品希望日時</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                &nbsp;
                <!-- <input type="submit" class="btn btn-primary" name='submit' value="アップロード"> -->
            </div>
        </div>
    </div>
</div>
<script src="../wp-content/plugins/membership-ordering-system/assets/js/bootstrap.bundle.min.js"></script>
<script>
var myModal = null;
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
                console.log(data.length);
                if(data.length < 1)
                    jQuery("#client").attr('data_id', '');
                    // jQuery("#client").attr('data-id', '');
                response( data );
              }
            } );
          },
          minLength: 1,
          select: function( event, ui ) {
            jQuery("#client").attr('data_id', ui.item.id);
            // get_products(ui.item.shop);
            // get_products('');
            getHistory();
            // console.log( "Selected: " + ui.item.value + " aka " + ui.item.id );
          }
        } );
        jQuery("body").on("keyup", "input[name='product_list']", function (e) {
            var s = jQuery(this).val();
            if(s == ''){
                jQuery("#sel_product_id").val('');
                getHistory();
            }
        });
        jQuery("body").on("keyup", "#client", function (e) {
            var s = jQuery(this).val();
            if(s == ''){
                jQuery("#client").attr('data_id', '');
                getHistory();
            }
        });
        jQuery("body").on("click", "#modal_table_2 .btn-close", function (e) {
            myModal.hide();
            myModal = null;
        });
        jQuery("body").on("change", "#invoice_date, #invoice_date1", function (e) {
            getHistory();
        });
        jQuery("body").on("click", ".h_item", function(e) {
            jQuery('.details_list_body').html('');
            var id = jQuery(this).data('id');
            jQuery.ajax({
                url: "../wp-content/plugins/membership-ordering-system/ajax-shop.php",
                type: "post",
                data: {
                    id:id,
                    to:'details'
                },
                /* remind that 'data' is the response of the AjaxController */
                success: function (data) {
                    if(data == 'no'){
                        jQuery('.details_list_body').html('');
                        return;
                    }
                    var dList = JSON.parse(data);
                    if(myModal)
                        myModal.hide();
                    myModal = null;
                    myModal = new bootstrap.Modal(
                        document.getElementById("modal_table_2"), {
                        keyboard: false,
                    });
                    var s = "";
                    for(var i=0;i<dList.length;i++){
                        s += '<tr data-id="'+dList[i].history_id+'" class="h_item iedit author-self level-0 post-83 type-product status-publish has-post-thumbnail hentry product_cat-uncategorized">';
                        s += '<td class="product_tag column-product_tag d-none2">'+(i+1)+'</td>';
                        s += '<td class="product_tag column-product_tag d-none2">'+dList[i].invoice_date+'</td>';
                        s += '<td class="product_tag column-product_tag">'+dList[i].invoice_num+'</td>';
                        s += '<td class="product_tag column-product_tag">'+dList[i].client+'</td>';
                        s += '<td class="product_tag column-product_tag d-none1">'+dList[i].address+'</td>';
                        s += '<td class="product_tag column-product_tag">'+dList[i].product_list+'</td>';
                        s += '<td class="product_tag column-product_tag d-none2">'+dList[i].price+'</td>';
                        s += '<td class="product_tag column-product_tag d-none2">'+dList[i].cnt+'</td>';
                        s += '<td class="product_tag column-product_tag d-none1">'+dList[i].money+'</td>';
                        s += '<td class="product_tag column-product_tag d-none2">'+dList[i].delivery_date+'</td>';
                        s += '</tr>';
                    }
                    jQuery('.details_list_body').append(s);
                    myModal.show();
                },
                error: function (data, textStatus, errorThrown) {
                    console.log(data);
                },
            });
        });
        get_products('');
  } );

    jQuery("input[name='product_list']").on('input', function(e){
        var inputValue = jQuery(this).val();

        var options = document.querySelectorAll('#product_list option');
       
        for(var i = 0; i < options.length; i++) {
            var option = options[i];

            if(option.innerText === inputValue) {
                jQuery("#sel_product_id").val(option.getAttribute('data-value'));
                getHistory();
                return;
            }
        }
        jQuery("#sel_product_id").val('');
        getHistory();
    });
    function get_products(shop){

        jQuery.ajax({
            url: "../wp-content/plugins/membership-ordering-system/ajax-shop.php",
            type: "post",
            data: {
                search:'',
                shop:shop,
                ajax:'ajax',
                to:'product'
            },
            /* remind that 'data' is the response of the AjaxController */
            success: function (data) {
                //alert(data);
                var pList = JSON.parse(data);
                var pTagList = "";
               
                for(var i = 0; i < pList.length; i++){         
                    if(pList[i].sale != 0)    
                        pTagList += '<option data-value="'+pList[i].id+'" price-value="'+pList[i].sale+'" >'+pList[i].name+'</option>';
                    else
                        pTagList += '<option data-value="'+pList[i].id+'" price-value="'+pList[i].regular+'" >'+pList[i].name+'</option>';
                }

                jQuery("#product_list").html(pTagList);
            },
            error: function (data, textStatus, errorThrown) {
                console.log(data);
            },
        });
    }
    function getHistory(){
        jQuery.ajax({
            url: "../wp-content/plugins/membership-ordering-system/ajax-shop.php",
            type: "post",
            data: {
                invoice_date:jQuery("#invoice_date").val(),
                invoice_date1:jQuery("#invoice_date1").val(),
                // client:jQuery('#client').data('id'),
                client:jQuery('#client').attr('data_id'),
                product:jQuery("#sel_product_id").val(),
                to:'history'
            },
            /* remind that 'data' is the response of the AjaxController */
            success: function (data) {
                if(data == 'no'){
                    return;
                }
                var dList = JSON.parse(data);
                var s = "";
                jQuery('.history_list_body').html('');
                if(dList.length < 1)
                    s += '<tr class="no-items"><td class="colspanchange" colspan="6">...</td></tr>';
                // 
                for(var i=0;i<dList.length;i++){
                    s += '<tr data-id="'+dList[i].history_id+'" class="h_item iedit author-self level-0 post-83 type-product status-publish has-post-thumbnail hentry product_cat-uncategorized">';
                    s += '<td class="product_tag column-product_tag d-none2">'+(i+1)+'</td>';
                    s += '<td class="product_tag column-product_tag d-none2">'+dList[i].invoice_date+'</td>';
                    s += '<td class="product_tag column-product_tag">'+dList[i].invoice_num+'</td>';
                    s += '<td class="product_tag column-product_tag">'+dList[i].client+'</td>';
                    s += '<td class="product_tag column-product_tag">'+dList[i].products+'</td>';
                    s += '<td class="product_tag column-product_tag">'+dList[i].state+'</td>';
                    s += '</tr>';
                }
                jQuery('.history_list_body').append(s);
            },
            error: function (data, textStatus, errorThrown) {
                console.log(data);
            },
        });
    }
</script>