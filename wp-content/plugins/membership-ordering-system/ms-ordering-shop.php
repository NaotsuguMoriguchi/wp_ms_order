<?php
global $wpdb; 
$del = isset( $_POST['del'] ) ? absint( $_POST['del'] ) : 0;
if($del != 0){
	$ids = $_POST['post'];
	$ids_str = implode(',', $ids);
	$wpdb->query($wpdb->prepare("DELETE FROM wp_ms_shop WHERE id in (".$ids_str.")"));
}

$paged = isset( $_GET['paged'] ) ? absint( $_GET['paged'] ) : 1;
$s = isset( $_GET['s'] ) ? $_GET['s'] : '';

$wild = '%';
$like = $wild . $wpdb->esc_like( $s ) . $wild;

$limit = 20; // number of rows in page
if($s != '')
	$total = $wpdb->get_var( $wpdb->prepare("SELECT COUNT(`id`) FROM `wp_ms_shop` where shop_name like %s", $like) );
else
	$total = $wpdb->get_var( "SELECT COUNT(`id`) FROM `wp_ms_shop`" );
$num_of_pages = ceil( $total / $limit );
if($paged > $num_of_pages)
	$paged = $num_of_pages;
$offset = ( $paged - 1 ) * $limit;

if($s != ''){
	$posts = $wpdb->get_results($wpdb->prepare("SELECT * FROM wp_ms_shop where shop_name like %s order by `time` desc LIMIT %d, %d", array($like, $offset, $limit)));
}else
	$posts = $wpdb->get_results($wpdb->prepare("SELECT * FROM wp_ms_shop order by `time` desc LIMIT %d, %d", array($offset, $limit)));


?>
<style type="text/css">
	#search_shop{
		float: right;
	    position: absolute;
	    bottom: 0px;
	    right: 0px;
	}
	.d-none{
		display: none;
	}
	@media screen and (max-width: 481px) {
		#search_shop{
			position: unset !important;
		}
	}
    table tbody tr td{
        word-break: break-word;
    }
    .check-column{
    	width: 5%;
    }
    .column-shop_name{
    	width: 10%;
    }
    .column-address{
    	width: 25%;
    }
    .column-name{
    	width: 10%;
    }
    .column-tel{
    	width: 15%;
    }
    .column-mail{
    	width: 15%;
    }
    .column-invoice_info{
    	width: 20%;
    }
    @media screen and (max-width: 1100px){
        .d-none1{
            display: none;
        }
        .column-address{
	    	width: 35%;
	    }
    }
    @media screen and (max-width: 768px){
        .d-none2{
            display: none;
        }
        .column-shop_name{
	    	width: 40%;
	    }
	    .column-mail{
	    	width: 50%;
	    }
	    .check-column{
	    	width: 10%;
	    }
    }
    [type="number"]::-webkit-inner-spin-button,
    [type="number"]::-webkit-outer-spin-button {
       display:none;
    }
</style>

<div class="wrap" style="position: relative;">
	<h1 class="wp-heading-inline">代理店一覧</h1>	
	<a href="admin.php?page=ms-ordering-shop-add" class="upload-view-toggle page-title-action" role="button" aria-expanded="false"><span class="upload">代理店新規登録</span></a>
	<input placeholder="検索" type="text" id="search_shop" value="<?php echo $s ?>">
</div>

<div class="wrap">
	<form method="post" name="shop_form" id="shop_form">
		<?php
		if($num_of_pages > 1){
		?>
		<div class="tablenav top">
			<div class="alignleft actions bulkactions">			
				<input type="button" id="item_delete" class="button action" value="削除">
			</div>
			<div class="tablenav-pages">
				<span class="displaying-num"><?php echo number_format($total); ?> アイテム<!--  items --></span>
				<span class="pagination-links">
					<?php 
						if($paged <= 2){
							echo '<span class="tablenav-pages-navspan button disabled" aria-hidden="true">«</span>';
						}else{
							echo '<a class="first-page button" href="admin.php?page=ms-ordering-shop&paged=1&s='.$s.'">';
							echo '<span class="screen-reader-text">First page</span><span aria-hidden="true">«</span></a>';
						}
						if($paged <= 1){
							echo '<span class="tablenav-pages-navspan button disabled" aria-hidden="true" style="margin-left:0.2em">‹</span>';
						}else{
							echo '<a class="prev-page button" href="admin.php?page=ms-ordering-shop&paged='.($paged - 1).'&s='.$s.'" style="margin-left:0.2em">';
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
							echo '<a class="prev-page button" href="admin.php?page=ms-ordering-shop&paged='.($paged + 1).'&s='.$s.'">';
							echo '<span class="screen-reader-text">Next page</span><span aria-hidden="true">›</span></a>';
						}

						if($paged == $num_of_pages || $paged == ($num_of_pages - 1)){
							echo '<span class="tablenav-pages-navspan button disabled" aria-hidden="true" style="margin-left:0.2em">»</span>';
						}else{
							echo '<a class="last-page button" href="admin.php?page=ms-ordering-shop&paged='.$num_of_pages.'&s='.$s.'" style="margin-left:0.2em">';
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
			<div class="alignleft actions bulkactions">
				<input type="button" class="button action item_delete" value="削除">
			</div>
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
		        	<td id="cb" class="manage-column column-cb check-column"><input id="cb-select-all-1" type="checkbox"></td>
		            <!-- <th scope="col" class="manage-column column-is_in_stock d-none1" style="width: 5%">No</th> -->
		            <th scope="col" class="manage-column column-shop_name">代理店名</th>
		            <th scope="col" class="manage-column column-address d-none2">住所</th>
		            <th scope="col" class="manage-column column-name d-none1">御担当者名</th>
		            <th scope="col" class="manage-column column-tel d-none2">電話番号</th>
		            <th scope="col" class="manage-column column-mail">E-mail</th>
		            <th scope="col" class="manage-column column-invoice_info d-none2">請求書、納品書送付先情報</th>
		        </tr>
		    </thead>
		    <tbody id="the-shop-list" class="shop_list_body"> 
		    	<?php        
			        $idx = 0;
			        if(!$posts || count($posts) < 1){
		                echo '<tr class="no-item"><td class="colspanchange" colspan="7">...</td></tr>';
			        }else
				        foreach($posts as $post){
				        	$idx++; 
				        	echo '<tr data-id="'.$post->id.'" class="h_item iedit author-self level-0 post-'.$post->id.' type-product status-publish has-post-thumbnail hentry product_cat-uncategorized">';
				        	echo '<th scope="row" class="check-column"><input class="shop_select" type="checkbox" name="post[]" value="'.$post->id.'"></th>';
			                // echo '<td class="product_tag column-product_tag d-none1">'.$idx.'</td>';
			                echo '<td class="product_tag column-product_tag">';
			                echo '<strong><a href="admin.php?page=ms-ordering-shop-add&i='.$post->id.'">'.$post->shop_name.'</a><strong>';
			                echo '</td>';
			                echo '<td class="product_tag column-product_tag d-none2">'.$post->shop_pref.'&nbsp;&nbsp;'.$post->shop_city.'&nbsp;&nbsp;'.$post->shop_address.'</td>';
			                echo '<td class="product_tag column-product_tag d-none1">'.$post->name.'</td>';
			                echo '<td class="product_tag column-product_tag d-none2">'.$post->tel.'</td>';
			                echo '<td class="product_tag column-product_tag">';
			                echo '<a href="mailto:'.$post->mail.'">'.$post->mail.'</a>';
			                echo '</td>';
			                echo '<td class="product_tag column-product_tag d-none2">'.$post->invoice_info.'</td>';
			                echo '</tr>';
				        }
		        ?>
		    </tbody>
		    <tfoot>
		        <tr>
		        	<td id="cb" class="manage-column column-cb check-column"><input id="cb-select-all-1" type="checkbox"></td>
		            <!-- <th scope="col" class="manage-column column-is_in_stock d-none1">No</th> -->
		            <th scope="col" class="manage-column column-is_in_stock">代理店名</th>
		            <th scope="col" class="manage-column column-is_in_stock d-none2">住所</th>
		            <th scope="col" class="manage-column column-is_in_stock d-none1">御担当者名</th>
		            <th scope="col" class="manage-column column-is_in_stock d-none2">電話番号</th>
		            <th scope="col" class="manage-column column-is_in_stock">E-mail</th>
		            <th scope="col" class="manage-column column-is_in_stock d-none2">請求書、納品書送付先情報</th>
		        </tr>
		    </tfoot>
		</table>
		<?php
		if($num_of_pages > 1){
		?>
		<div class="tablenav bottom">
			<div class="alignleft actions bulkactions">			
				<input type="button" class="button action item_delete" value="削除">
			</div>
			<div class="tablenav-pages">
				<span class="displaying-num"><?php echo number_format($total); ?> アイテム<!--  items --></span>
				<span class="pagination-links">
					<?php 
						if($paged <= 2){
							echo '<span class="tablenav-pages-navspan button disabled" aria-hidden="true">«</span>';
						}else{
							echo '<a class="first-page button" href="admin.php?page=ms-ordering-shop&paged=1&s='.$s.'">';
							echo '<span class="screen-reader-text">First page</span><span aria-hidden="true">«</span></a>';
						}
						if($paged <= 1){
							echo '<span class="tablenav-pages-navspan button disabled" aria-hidden="true" style="margin-left:0.2em">‹</span>';
						}else{
							echo '<a class="prev-page button" href="admin.php?page=ms-ordering-shop&paged='.($paged - 1).'&s='.$s.'" style="margin-left:0.2em">';
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
							echo '<a class="prev-page button" href="admin.php?page=ms-ordering-shop&paged='.($paged + 1).'&s='.$s.'">';
							echo '<span class="screen-reader-text">Next page</span><span aria-hidden="true">›</span></a>';
						}

						if($paged == $num_of_pages || $paged == ($num_of_pages - 1)){
							echo '<span class="tablenav-pages-navspan button disabled" aria-hidden="true" style="margin-left:0.2em">»</span>';
						}else{
							echo '<a class="last-page button" href="admin.php?page=ms-ordering-shop&paged='.$num_of_pages.'&s='.$s.'" style="margin-left:0.2em">';
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
			<div class="alignleft actions bulkactions">			
				<input type="button" class="button action item_delete" value="削除">
			</div>
			<div class="tablenav-pages one-page">
				<span class="displaying-num"><?php echo $total ?> アイテム</span>
			</div>
		</div>
		<?php 
		}
		?>
		<input type="hidden" id="del" name="del" value="0">
	</form>
</div>
<input type="hidden" id="row" value="0">
<script type="text/javascript">
	var searchText="";
	jQuery(document).ready(function () {

		jQuery("body").on("keypress", ".current-page", function(e) {
			if(e.keyCode == 13){
				location.href = "admin.php?page=ms-ordering-shop&paged="+jQuery(this).val()+"&s="+jQuery('#search_shop').val();
			}
		});
		jQuery("body").on("keypress", "#search_shop", function(e) {
			if(e.keyCode != 13)
				return;
			var search = jQuery(this).val();
			location.href = "admin.php?page=ms-ordering-shop&s="+jQuery(this).val();
		});
		jQuery("body").on("click", ".item_delete", function(e) {
			var _select = 0;
			jQuery('.shop_select').each(function(){
				console.log(jQuery(this).prop('checked'));
				if(jQuery(this).prop('checked'))
					_select = 1;
			});
			if(_select == 0)
				return;
			if(confirm('削除しますか?')){
				jQuery('#del').val(1);
				jQuery('#shop_form').submit();
			}
		});
	});
</script>