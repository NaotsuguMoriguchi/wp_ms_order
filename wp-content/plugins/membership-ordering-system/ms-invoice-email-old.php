<?php
global $wpdb; 
$invoiceLists = $wpdb->get_results("SELECT * FROM wp_ms_invoice where history_id='".$_REQUEST['invoice']."'");
//var_export($invoiceList);
?>
<style type="text/css">
    button, input[type="text"], select{
        height: 40px !important;
    }
</style>
<div>
    <div class="w-100 mb-2">
        <div style="display:flex; flex-wrap: wrap">
            <div style="margin-right:5px">
                <div>注文日</div>
                <div><input type="text" id="invoice_date" name="invoice_date" style="width:170px" readonly></div>
            </div>
            <div style="margin-right:5px">
                <div>管理番号</div>
                <div><input id="invoice_num" name="invoice_num" type="text" style="width:170px" readonly></div>
            </div>
            <div style="margin-right:5px">
                <div>サロン名</div>        
                <div>
                    <input type="text" name="client" id="client" data-id=""  style="width:170px">
                </div>
            </div>
            <div style="margin-right:5px">
                <div>配送先住所</div>
                <div>
                    <input type="text" name="address" id="address" readonly style="width:345px">
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
                    <div><input type="number" id="price" name="price" style="width:82.5px" readonly></div>
                </div>
                <div>
                    <div>数量</div>
                    <div><input type="number" id="cnt" name="cnt" style="width:82.5px" min="0" onchange="calc_total()"></div>
                </div>
            </div>
            <div style="margin-right:5px">
                <div>総額</div>
                <div><input type="number" id="money" name="money" style="width:170px" readonly></div>
            </div>
            <div style="margin-right:5px">
                <div>&nbsp;&nbsp;&nbsp;<!-- 納品希望日時 --></div>
                <div>
                    <!-- <input type="datetime-local" id="delivery_date" name="delivery_date" style="width:250px"> -->
                    <input type="button" id="add_product" class="button" value="追加" onclick="add_product()">
                </div>
            </div>
        </div>
    </div>    
    <table class="invoice_list" border="1" style="margin-top:10px;width: 100%;">
        <thead>
            <tr>
                <th class="d-none2">No</th>
                <th class="invoice_date">注文日</th>
                <th class="invoice_num">管理番号</th>
                <th class="client">サロン名</th>           
                <th class="address">商品名</th>
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