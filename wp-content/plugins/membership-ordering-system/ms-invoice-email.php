<?php
global $wpdb; 
$invoice_num = empty($_REQUEST['invoice']) ? '' : $_REQUEST['invoice'];
$invoiceLists = $wpdb->get_results("SELECT * FROM wp_ms_invoice where history_id='".$invoice_num."'");
?>
<link href="<?php echo plugin_dir_url( __FILE__) ?>/assets/css/sb-admin-2.min.css" rel="stylesheet" type="text/css">
<style type="text/css">
    button, input[type="text"], select, input[type="button"]{
        height: 35px !important;
        margin:unset !important;
        line-height: 1 !important;
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
</style>
<div>    
    <table class="invoice_list" border="1" style="margin-top:10px;width: 100%;margin-bottom: 10px">
        <thead>
            <tr>
                <th class="d-none2 py-2 pl-1">No</th>
                <th class="invoice_date py-2 pl-1">注文日</th>
                <th class="invoice_num py-2 pl-1">管理番号</th>
                <th class="client py-2 pl-1">サロン名</th>           
                <th class="address py-2 pl-1">商品名</th>
                <th class="d-none2 py-2 pl-1">金額</th>
                <th class="d-none2 py-2 pl-1">数量</th>
                <th class="d-none1 py-2 pl-1">総額</th>
                <!-- <th class="d-none2">納品希望日時</th>           -->
            </tr>
        </thead>
        <tbody>

        <?php
        $index = 0;
        foreach($invoiceLists as $invoice){
            $index++;
        ?>
            <tr>
                <td class="d-none2 py-2 pl-1"><?=$index?></td>
                <td class=" py-2 pl-1"><?=$invoice->invoice_date?></td>
                <td class=" py-2 pl-1"><?=$invoice->invoice_num?></td>
                <td class=" py-2 pl-1"><?=$invoice->client?></td>            
                <td class=" py-2 pl-1"><?=$invoice->product_list?></td>
                <!-- <th>商品名</th> -->
                <td class="d-none2 py-2 pl-1"><?=$invoice->price?></td>
                <td class="d-none2 py-2 pl-1"><?=$invoice->cnt?></td>
                <td class="d-none1 py-2 pl-1"><?php echo ($invoice->price * $invoice->cnt)?></td>
                <!-- <td><?=$invoice->delivery_date?></td>           -->
            </tr>
        <?php }?>
        </tbody>
    </table>
    <div style="width: 100%">
        <input type="button" class="btn btn-primary mt-2 px-3" name="confirm_btn" id="confirm_btn" value="確認" style="float:right;font-size: 16px">
    </div>
</div>
<script type="text/javascript">
    jQuery("body").on("click", "#confirm_btn", function(e) {
        jQuery.ajax( {
          url: "<?php echo plugin_dir_url( __FILE__) ?>/ajax-shop.php",
          type: "get",
          data: {
            invoice:'<?php echo $_REQUEST['invoice']; ?>',
            to:'confirm'
          },
          success: function( data ) {
            if(jQuery.trim(data) == 'ok'){
                location.href = '<?php echo get_bloginfo('url') ?>';
            }
          }
        } );
    });
</script>