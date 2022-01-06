<?php
global $wpdb; 
$invoiceLists = $wpdb->get_results("SELECT * FROM wp_ms_invoice where history_id='".$_REQUEST['invoice']."'");
//var_export($invoiceList);
?>
<div>
    <table class="invoice_list mb-3" border="1" style="margin-top:10px;width: 100%;">
        <thead>
            <tr>
                <th class="d-none2">No</th>
                <th class="invoice_date">注文日</th>
                <th class="invoice_num">管理番号</th>
                <th class="client">サロン名</th>           
                <th class="address">商品名</th>
                <!-- <th>商品名</th> -->
                <th class="d-none2">金額</th>
                <th class="d-none2">数量</th>
                <th class="d-none1">総額</th>
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
                <td><?=$index?></td>
                <td><?=$invoice->invoice_date?></td>
                <td><?=$invoice->invoice_num?></td>
                <td><?=$invoice->client?></td>            
                <td><?=$invoice->product_list?></td>
                <!-- <th>商品名</th> -->
                <td><?=$invoice->price?></td>
                <td><?=$invoice->cnt?></td>
                <td><?php echo ($invoice->price * $invoice->cnt)?></td>
                <!-- <td><?=$invoice->delivery_date?></td>           -->
            </tr>
        <?php }?>
        </tbody>
    </table>
    <div style="width: 100%">
        <input type="button" class="button" name="confirm_btn" id="confirm_btn" value="確認" style="float:right">
    </div>
</div>
<script type="text/javascript">
    jQuery("body").on("click", "#confirm_btn", function(e) {
        jQuery.ajax( {
          url: "../wp-content/plugins/membership-ordering-system/ajax-shop.php",
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