
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
<link href="<?php echo plugin_dir_url( __FILE__) ?>assets/css/sb-admin-2.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo plugin_dir_url( __FILE__) ?>assets/css/all.css" rel="stylesheet" type="text/css">
<!-- <link href="../wp-content/plugins/membership-ordering-system/assets/css/agency.css" rel="stylesheet"> -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
<style>
    input, select{
        height: 40px !important;
    }
    [type="number"]::-webkit-inner-spin-button,
    [type="number"]::-webkit-outer-spin-button {
       display:none;
       /*padding-right: 5px;*/
    }
    table tbody tr td{
        word-break: break-word;
    }
    .column-no{
        width: 5%;
    }
    .column-date{
        width: 10%;
    }
    .column-num{
        width: 15%;
    }
    .column-client_code{
        width: 15%;
    }
    .column-client{
        width: 15%;
    }
    .column-product{
        width: 25%;
    }
    .column-state{
        width: 15%;
    }
    @media screen and (max-width: 1050px){
        .d-none1{
            display: none !important;
        }
        .column-date{
            width: 11%;
        }
        .column-num{
            width: 16%;
        }
        .column-client_code{
            width: 16%;
        }
        .column-client{
            width: 16%;
        }
        .column-product{
            width: 26%;
        }
    }
    @media screen and (max-width: 768px){
        .d-none2{
            display: none !important;
        }
        .column-num{
            width: 40%;
        }
        .column-client{
            width: 40%;
        }
        .column-state{
            width: 20%;
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
    #search-submit{
        font-size: unset;
        line-height: 2;
        min-height: 30px;
    }
    #product_list{
        font-size: unset;
        line-height: 2;
        min-height: 30px;
    }
    @media screen and (max-width: 782px){
        #search-submit{
            padding: 0 14px;
            line-height: 2.71428571;
            font-size: 14px;
            vertical-align: middle;
            min-height: 40px;
            margin-bottom: 4px;
        }
        #product_list{
            padding: 0 14px;
            line-height: 2.71428571;
            font-size: 14px;
            vertical-align: middle;
            min-height: 40px;
        }
    }
</style>
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
<?php
global $wpdb; 

// var_export(wp_get_current_user());
// $clients = $wpdb->get_results("SELECT * FROM wp_ms_client");
$paged = isset( $_GET['paged'] ) ? absint( $_GET['paged'] ) : 1;
$p = isset( $_GET['p'] ) ? $_GET['p'] : '';
$c = isset( $_GET['c'] ) ? $_GET['c'] : '';
$d1 = isset( $_GET['d1'] ) ? $_GET['d1'] : '';
$d2 = isset( $_GET['d2'] ) ? $_GET['d2'] : '';
$in = isset( $_GET['in'] ) ? $_GET['in'] : '';
$cc = isset( $_GET['cc'] ) ? $_GET['cc'] : '';


$wild = '%';
$p_like = $wild . $wpdb->esc_like( $p ) . $wild;

$c_like = $wild . $wpdb->esc_like( $c ) . $wild;

$cc_like = $wild . $wpdb->esc_like( $cc ) . $wild;

$in_like = $wild . $wpdb->esc_like( $in ) . $wild;

$limit = 20; // number of rows in page

$where = "";
$format = array();
$invoice_date = " 1 ";
$client = " 1 ";
$product = " 1 ";
if($d1 != ''){
    if($d2 == ''){
        $invoice_date = " invoice_date >= %s";
        array_push($format, $d1);
    }else{
        $invoice_date = " invoice_date between %s and %s";
        array_push($format, $d1);
        array_push($format, $d2);
    }
}else{
    if($d2 == ''){
    }else{
        $invoice_date = " invoice_date <= %s";
        array_push($format, $d2);
    }
}

$where = $invoice_date.' and client like %s and products like %s and client_code like %s and invoice_num like %s';
array_push($format, $c_like);
array_push($format, $p_like);
array_push($format, $cc_like);
array_push($format, $in_like);
// echo "SELECT * FROM wp_ms_invoice_history where $where order by `time` desc";
// var_export($format);
$totals = $wpdb->get_results($wpdb->prepare("SELECT * FROM wp_ms_invoice_history where $where order by `time` desc", $format));
// echo $total;
$total = count($totals);
$num_of_pages = ceil( $total / $limit );
if($paged > $num_of_pages)
    $paged = $num_of_pages;
$offset = ( $paged - 1 ) * $limit;

array_push($format, $offset);
array_push($format, $limit);


$posts = $wpdb->get_results($wpdb->prepare("SELECT * FROM wp_ms_invoice_history where $where order by `time` desc LIMIT %d, %d", $format));
// $posts = $wpdb->get_results("SELECT * FROM wp_ms_invoice_history order by `time` desc limit 0, ".$rowperpage);
?>

<div class="mt-4 mb-2" style="display:flex; flex-wrap: wrap">
    <div style="margin-right:5px">
        <div>注文日</div>
        <div>
            <input type="date" id="invoice_date" name="invoice_date" style="width:170px" value="<?php echo $d1 ?>"> - 
            <input type="date" id="invoice_date1" name="invoice_date1" style="width:170px" value="<?php echo $d2 ?>">
        </div>
    </div>
    <div style="margin-right:5px">
        <div>受注番号</div>        
        <div>
            <input type="text" name="invoice_num" id="invoice_num" data_id=""  style="width:170px" value="<?php echo $in ?>"/>
        </div>
    </div>
    <div style="margin-right:5px">
        <div>サロンコード</div>        
        <div>
            <input type="text" name="client_code" id="client_code" data_id=""  style="width:170px" value="<?php echo $cc ?>"/>
        </div>
    </div>
    <div style="margin-right:5px">
        <div>サロン名</div>        
        <div>
            <input type="text" name="client" id="client" data_id=""  style="width:170px" value="<?php echo $c ?>"/>
        </div>
    </div>
    <div style="margin-right:5px">
        <div>商品名</div>
        <div>
            <input type="text" name="product_list" id="product_list" list="product_list"  value="<?php echo $p ?>" style="width:170px">
            <!-- <select name="product_list" id="product_list" style="width:170px"></select> -->
            <input type="hidden" name="sel_product_id" id="sel_product_id">
        </div>
    </div>
    <div class="d-flex align-items-end" style="margin-right:5px;">
        <input type="button" id="search-submit" class="button" value="検索" style="margin-bottom: 0px">
    </div>
</div>
<?php
if($num_of_pages > 1){
?>
<div class="tablenav top">
    <div class="tablenav-pages">
        <span class="displaying-num"><?php echo number_format($total); ?> アイテム<!--  items --></span>
        <span class="pagination-links">
            <?php 
                if($paged <= 2){
                    echo '<span class="tablenav-pages-navspan button disabled" aria-hidden="true">«</span>';
                }else{
                    echo '<a class="first-page button" href="admin.php?page=ms-ordering-sys&paged=1&p='.$p.'&c='.$c.'&d1='.$d1.'&d2='.$d2.'&in='.$in.'&cc='.$cc.'">';
                    echo '<span class="screen-reader-text">First page</span><span aria-hidden="true">«</span></a>';
                }
                if($paged <= 1){
                    echo '<span class="tablenav-pages-navspan button disabled" aria-hidden="true" style="margin-left:0.2em">‹</span>';
                }else{
                    echo '<a class="prev-page button" href="admin.php?page=ms-ordering-sys&paged='.($paged - 1).'&p='.$p.'&c='.$c.'&d1='.$d1.'&d2='.$d2.'&in='.$in.'&cc='.$cc.'" style="margin-left:0.2em">';
                    echo '<span class="screen-reader-text">Previous page</span><span aria-hidden="true">‹</span></a>';
                }
            ?>
            <span class="paging-input">
                <label for="current-page-selector" class="screen-reader-text">Current Page</label>
                <input class="current-page" id="current-page-selector" type="number" name="paged" value="<?php echo $paged ?>" aria-describedby="table-paging" style="width: 70px" max="<?php echo $num_of_pages ?>" min="1">
                <span class="tablenav-paging-text"> of <span class="total-pages"><?php echo number_format($num_of_pages); ?></span></span>
            </span>
            <?php                   
                if($paged == $num_of_pages){
                    echo '<span class="tablenav-pages-navspan button disabled" aria-hidden="true">›</span>';
                }else{
                    echo '<a class="prev-page button" href="admin.php?page=ms-ordering-sys&paged='.($paged + 1).'&p='.$p.'&c='.$c.'&d1='.$d1.'&d2='.$d2.'&in='.$in.'&cc='.$cc.'">';
                    echo '<span class="screen-reader-text">Next page</span><span aria-hidden="true">›</span></a>';
                }

                if($paged == $num_of_pages || $paged == ($num_of_pages - 1)){
                    echo '<span class="tablenav-pages-navspan button disabled" aria-hidden="true" style="margin-left:0.2em">»</span>';
                }else{
                    echo '<a class="last-page button" href="admin.php?page=ms-ordering-sys&paged='.$num_of_pages.'&p='.$p.'&c='.$c.'&d1='.$d1.'&d2='.$d2.'&in='.$in.'&cc='.$cc.'" style="margin-left:0.2em">';
                    echo '<span class="screen-reader-text">Last page</span><span aria-hidden="true">»</span></a>';
                }
            ?>
        </span>
    </div>
</div>
<?php
}else{
?>
<div class="tablenav top">
    <div class="tablenav-pages one-page">
        <span class="displaying-num"><?php echo $total ?> アイテム</span>
    </div>
</div>
<?php
}
?>
<table class="wp-list-table widefat fixed striped table-view-list posts">
    <thead>
        <tr>
            <th scope="col" class="manage-column column-no d-none1">No</th>
            <th scope="col" class="manage-column column-date d-none2">注文日</th>
            <th scope="col" class="manage-column column-num">受注番号</th>
            <th scope="col" class="manage-column column-client_code d-none2">サロンコード</th>
            <th scope="col" class="manage-column column-client">サロン名</th>
            <th scope="col" class="manage-column column-product d-none2">商品名</th>
            <th scope="col" class="manage-column column-state">状態</th>
        </tr>
    </thead>
    <tbody id="the-list" class="history_list_body">        
        <?php
            $idx = 0;
            if(!$posts || count($posts) < 1)
                echo '<tr class="no-item"><td class="colspanchange" colspan="7">...</td></tr>';
            else
                foreach($posts as $post){
                    $idx++;
                    echo '<tr data-id="'.$post->history_id.'" data-state="'.$post->state.'" class="h_item iedit author-self level-0 post-83 type-product status-publish has-post-thumbnail hentry product_cat-uncategorized">';
                    echo '<td class="product_tag column-product_tag d-none1" style="display: table-cell;">'.$idx.'</td>';
                    echo '<td class="product_tag column-product_tag d-none2" style="display: table-cell;">'.$post->invoice_date.'</td>';
                    echo '<td class="product_tag column-product_tag" style="display: table-cell;">'.$post->invoice_num.'</td>';
                    echo '<td class="product_tag column-product_tag d-none2" style="display: table-cell;">'.$post->client_code.'</td>';
                    echo '<td class="product_tag column-product_tag" style="display: table-cell;">'.$post->client.'</td>';
                    echo '<td class="product_tag column-product_tag d-none2" style="display: table-cell;">'.$post->products.'</td>';
                    echo '<td class="product_tag column-product_tag" style="display: table-cell;">'.$post->state.'</td>';
                    echo '</tr>';
                }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th scope="col" class="manage-column column-is_in_stock d-none1">No</th>
            <th scope="col" class="manage-column column-is_in_stock d-none2">注文日</th>
            <th scope="col" class="manage-column column-is_in_stock">受注番号</th>
            <th scope="col" class="manage-column column-client_code d-none2">サロンコード</th>
            <th scope="col" class="manage-column column-is_in_stock">サロン名</th>
            <th scope="col" class="manage-column column-is_in_stock d-none2">商品名</th>
            <th scope="col" class="manage-column column-is_in_stock">状態</th>
        </tr>
    </tfoot>
</table>
<?php
if($num_of_pages > 1){
?>
<div class="tablenav bottom">
    <div class="tablenav-pages">
        <span class="displaying-num"><?php echo number_format($total); ?> アイテム<!--  items --></span>
        <span class="pagination-links">
            <?php 
                if($paged <= 2){
                    echo '<span class="tablenav-pages-navspan button disabled" aria-hidden="true">«</span>';
                }else{
                    echo '<a class="first-page button" href="admin.php?page=ms-ordering-sys&paged=1&p='.$p.'&c='.$c.'&d1='.$d1.'&d2='.$d2.'&in='.$in.'&cc='.$cc.'">';
                    echo '<span class="screen-reader-text">First page</span><span aria-hidden="true">«</span></a>';
                }
                if($paged <= 1){
                    echo '<span class="tablenav-pages-navspan button disabled" aria-hidden="true" style="margin-left:0.2em">‹</span>';
                }else{
                    echo '<a class="prev-page button" href="admin.php?page=ms-ordering-sys&paged='.($paged - 1).'&p='.$p.'&c='.$c.'&d1='.$d1.'&d2='.$d2.'&in='.$in.'&cc='.$cc.'" style="margin-left:0.2em">';
                    echo '<span class="screen-reader-text">Previous page</span><span aria-hidden="true">‹</span></a>';
                }
            ?>
            <span class="paging-input">
                <label for="current-page-selector" class="screen-reader-text">Current Page</label>
                <input class="current-page" id="current-page-selector" type="number" name="paged" value="<?php echo $paged ?>" aria-describedby="table-paging" style="width: 70px" max="<?php echo $num_of_pages ?>" min="1">
                <span class="tablenav-paging-text"> of <span class="total-pages"><?php echo number_format($num_of_pages); ?></span></span>
            </span>
            <?php                   
                if($paged == $num_of_pages){
                    echo '<span class="tablenav-pages-navspan button disabled" aria-hidden="true">›</span>';
                }else{
                    echo '<a class="prev-page button" href="admin.php?page=ms-ordering-sys&paged='.($paged + 1).'&p='.$p.'&c='.$c.'&d1='.$d1.'&d2='.$d2.'&in='.$in.'&cc='.$cc.'">';
                    echo '<span class="screen-reader-text">Next page</span><span aria-hidden="true">›</span></a>';
                }

                if($paged == $num_of_pages || $paged == ($num_of_pages - 1)){
                    echo '<span class="tablenav-pages-navspan button disabled" aria-hidden="true" style="margin-left:0.2em">»</span>';
                }else{
                    echo '<a class="last-page button" href="admin.php?page=ms-ordering-sys&paged='.$num_of_pages.'&p='.$p.'&c='.$c.'&d1='.$d1.'&d2='.$d2.'&in='.$in.'&cc='.$cc.'" style="margin-left:0.2em">';
                    echo '<span class="screen-reader-text">Last page</span><span aria-hidden="true">»</span></a>';
                }
            ?>
        </span>
    </div>
</div>
<?php
}else{
?>
<div class="tablenav bottom">
    <div class="tablenav-pages one-page">
        <span class="displaying-num"><?php echo $total ?> アイテム</span>
    </div>
</div>
<?php 
}
?>
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
                    <div class="col-12 align-items-center justify-content-center">
                        <table  class="wp-list-table widefat fixed striped table-view-list posts w-100" style="margin-top:10px;">
                            <thead>
                                <tr>
                                    <th scope="col" class="manage-column column-is_in_stock d-none1" style="width:5%">No</th>
                                    <th scope="col" class="manage-column column-is_in_stock d-none2">注文日</th>
                                    <th scope="col" class="manage-column column-is_in_stock">受注番号</th>
                                    <th scope="col" class="manage-column column-is_in_stock d-none2">サロンコード</th>
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
                                    <th scope="col" class="manage-column column-is_in_stock d-none1" style="width:5%">No</th>
                                    <th scope="col" class="manage-column column-is_in_stock d-none2">注文日</th>
                                    <th scope="col" class="manage-column column-is_in_stock">受注番号</th>
                                    <th scope="col" class="manage-column column-is_in_stock d-none2">サロンコード</th>
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
                        <div class="text-right mt-2">
                            <input type="button" id="agree_btn" data-id="" class="button" value="確定" style="margin-bottom: 0px">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                &nbsp;
            </div>
        </div>
    </div>
</div>
<script src="<?php echo plugin_dir_url( __FILE__) ?>assets/js/bootstrap.bundle.min.js"></script>
<script>
var myModal = null;
    jQuery( function() {
        jQuery("body").on("click", "#agree_btn", function(e) {
            var invoice = jQuery(this).data('id');
            if(invoice == '')
                return;
            jQuery.ajax( {
              url: "<?php echo plugin_dir_url( __FILE__) ?>ajax-shop.php",
              type: "get",
              data: {
                invoice:invoice,
                to:'delivery'
              },
              success: function( data ) {
                if(jQuery.trim(data) == 'ok')
                    location.href = "admin.php?page=ms-ordering-sys";
              }
            } );
        });
        jQuery("body").on("click", "#search-submit", function (e) {
            location.href = "admin.php?page=ms-ordering-sys&p="+jQuery('#product_list').val()+"&c="+jQuery('#client').val()+"&d1="+jQuery('#invoice_date').val()+"&d2="+jQuery('#invoice_date1').val()+"&in="+jQuery('#invoice_num').val()+"&cc="+jQuery("#client_code").val();
        });

        jQuery("body").on("click", "#modal_table_2 .btn-close", function (e) {
            myModal.hide();
            myModal = null;
        });

        jQuery("body").on("keypress", ".current-page", function(e) {
            if(e.keyCode == 13){
                location.href = "admin.php?page=ms-ordering-sys&paged="+jQuery(this).val()+"&p="+jQuery('#product_list').val()+"&c="+jQuery('#client').val()+"&d1="+jQuery('#invoice_date').val()+"&d2="+jQuery('#invoice_date1').val()+"&in="+jQuery('#invoice_num').val()+"&cc="+jQuery("#client_code").val();
            }
        });
        jQuery("body").on("click", ".h_item", function(e) {
            jQuery('.details_list_body').html('');
            var id = jQuery(this).data('id');
            var state = jQuery(this).data('state');
            jQuery.ajax({
                url: "<?php echo plugin_dir_url( __FILE__) ?>ajax-shop.php",
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
                        s += '<tr data-id="'+dList[i].history_id+'" class="iedit author-self level-0 post-83 type-product status-publish has-post-thumbnail hentry product_cat-uncategorized">';
                        s += '<td class="product_tag column-product_tag d-none1" style="display: table-cell;">'+(i+1)+'</td>';
                        s += '<td class="product_tag column-product_tag d-none2" style="display: table-cell;">'+dList[i].invoice_date+'</td>';
                        s += '<td class="product_tag column-product_tag" style="display: table-cell;">'+dList[i].invoice_num+'</td>';
                        s += '<td class="product_tag column-product_tag d-none2" style="display: table-cell;">'+dList[i].client_code+'</td>';
                        s += '<td class="product_tag column-product_tag" style="display: table-cell;">'+dList[i].client+'</td>';
                        s += '<td class="product_tag column-product_tag d-none1" style="display: table-cell;">'+dList[i].address+'</td>';
                        s += '<td class="product_tag column-product_tag" style="display: table-cell;">'+dList[i].product_list+'</td>';
                        s += '<td class="product_tag column-product_tag d-none2" style="display: table-cell;">'+parseFloat(dList[i].price).toLocaleString()+'円</td>';
                        s += '<td class="product_tag column-product_tag d-none2" style="display: table-cell;">'+parseFloat(dList[i].cnt).toLocaleString()+'</td>';
                        s += '<td class="product_tag column-product_tag d-none1" style="display: table-cell;">'+parseFloat(dList[i].money).toLocaleString()+'円</td>';
                        s += '<td class="product_tag column-product_tag d-none2" style="display: table-cell;">'+dList[i].delivery_date+'</td>';
                        s += '</tr>';
                    }
                    jQuery('.details_list_body').append(s);
                    myModal.show();
                    if(state == '請求中'){
                        jQuery('#agree_btn').attr('data-id', id);
                        jQuery('#agree_btn').prop('disabled', false);
                    }else{
                        jQuery('#agree_btn').attr('data-id', '');
                        jQuery('#agree_btn').prop('disabled', true);
                    }
                },
                error: function (data, textStatus, errorThrown) {
                    console.log(data);
                },
            });
        });
  } );
function get_products(shop){
    jQuery.ajax({
        url: "<?php echo plugin_dir_url( __FILE__) ?>ajax-shop.php",
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
                    pTagList += '<option value="'+pList[i].name+'" data-price="'+pList[i].sale+'" >'+pList[i].name+'</option>';
                else
                    pTagList += '<option value="'+pList[i].name+'" data-price="'+pList[i].regular+'" >'+pList[i].name+'</option>';
            }

            jQuery("#product_list").html(pTagList);
        },
        error: function (data, textStatus, errorThrown) {
            console.log(data);
        },
    });
}
function agree(){

}
</script>