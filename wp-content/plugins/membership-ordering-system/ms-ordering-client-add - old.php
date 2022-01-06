<link href="../wp-content/plugins/membership-ordering-system/assets/css/sb-admin-2.min.css" rel="stylesheet" type="text/css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js"></script>
<?php
// var_export(__DIR__);
function imgUpload($img){        
    // $folderPath = public_path('uploads/agency/'); 
    $folderPath = __DIR__."/assets/client/";
    // var_export(__FILE__);

    $image_parts = explode(";base64,", $img);
    $image_type_aux = explode("image/", $image_parts[0]); 
    $imageName1 = "-----";

    if(count($image_type_aux) > 1){

        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $imageName1 = uniqid() . '.png';
        $imageFullPath = $folderPath.$imageName1;
        file_put_contents($imageFullPath, $image_base64);
    }

    return $imageName1;
}
global $wpdb;
$post = null;
$table = $wpdb->prefix.'ms_client';
if($_REQUEST['action'] == 'createuser'){
	$imageName1 = imgUpload($_REQUEST['photo_base64']);
	
	$data = array('name' => isset($_REQUEST['name']) ? $_REQUEST['name'] : '', 
					'shop' => isset($_REQUEST['shop']) ? $_REQUEST['shop'] : '', 
					'address' => isset($_REQUEST['address']) ? $_REQUEST['address'] : '', 
					'tel' => isset($_REQUEST['tel']) ? $_REQUEST['tel'] : '', 
					'mail' => isset($_REQUEST['mail']) ? $_REQUEST['mail'] : '',  
                    'time' => date('Y-m-d H:i:s'),
					'shipping_info' => isset($_REQUEST['shipping_info']) ? $_REQUEST['shipping_info'] : '');
	if(is_file(__DIR__."/assets/client/".$imageName1)){
        $data['img'] = $imageName1;
    }

	$result = $wpdb->insert($table, $data);
	$my_id = $wpdb->insert_id;
}
if(isset($_REQUEST['id']) && !empty($_REQUEST['id']) && $_REQUEST['action'] == 'update'){
    $data = array('shop' => isset($_REQUEST['shop']) ? $_REQUEST['shop'] : '', 
                    'address' => isset($_REQUEST['address']) ? $_REQUEST['address'] : '', 
                    'name' => isset($_REQUEST['name']) ? $_REQUEST['name'] : '', 
                    'tel' => isset($_REQUEST['tel']) ? $_REQUEST['tel'] : '', 
                    'mail' => isset($_REQUEST['mail']) ? $_REQUEST['mail'] : '',  
                    'time' => date('Y-m-d H:i:s'),
                    'shipping_info' => isset($_REQUEST['shipping_info']) ? $_REQUEST['shipping_info'] : '');
    $imageName1 = imgUpload($_REQUEST['photo_base64']);
    if(is_file(__DIR__."/assets/client/".$imageName1)){
        $data['img'] = $imageName1;
    }
    $result = $wpdb->update($table, $data, array('id'=>$_REQUEST['id']));
    if($result)
        echo '<script type="text/javascript">location.href="admin.php?page=ms-ordering-client"</script>';
}
if(isset($_REQUEST['id']) && !empty($_REQUEST['id']) && $_REQUEST['action'] == 'delete'){
    // $result = $wpdb->delete($table, );
    $result = $wpdb->query($wpdb->prepare("delete from ".$table." where id = %d", $_REQUEST['id']));
    // var_export($result);
    if($result)
        echo '<script type="text/javascript">location.href="admin.php?page=ms-ordering-client"</script>';
}
if(isset($_REQUEST['i']) && !empty($_REQUEST['i'])){
	$posts = $wpdb->get_results("SELECT * FROM wp_ms_client where id = ".intval($_REQUEST['i']));
	$post =$posts[0];
    // echo $post->shop;
}
$shops = $wpdb->get_results("SELECT * FROM wp_ms_shop");
?>
<style type="text/css">
	.preview {
        overflow: hidden;
        width: 120px;
        height: 72px;
        margin: 10px;
        border: 1px solid red;
        float: left;
    }
    .modal-lg {
        max-width: 1000px !important;
    }
    img {
        display: block;
        max-width: 100%;
    }
    .carbon-attachment .carbon-attachment-preview img{
    	margin-top: 0px !important;
    }
    .modal{
        z-index: 20000 !important;
    }
    .errors{
        border: 2px solid red !important;
    }
    #shop{
        width: 25em;
    }
    @media screen and (max-width: 782px){
        #shop{
            width: 100%;
        }
    }
</style>
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">  
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <div class="row">
                        <div class="col-md-6">
                            <img id="image" src="https://avatars0.githubusercontent.com/u/3456749">
                        </div>
                        <div class="col-md-6">
                            <div class="preview"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-facebook" data-dismiss="modal">キャンセル</button>
                <button type="button" class="btn btn-facebook" id="crop">切り取り</button>
            </div>
        </div>
    </div>
</div>
<div class="wrap">	
	<h1 id="add-new-user">客先新規登録</h1>
	<form method="post" name="createuser" id="createuser" class="validate" novalidate="novalidate">
		<?php
            if(isset($post) && !empty($post->id))
                echo '<input name="action" id="action" type="hidden" value="update">';
            else
                echo '<input name="action" id="action" type="hidden" value="createuser">';
        ?>    
		<input type="hidden" id="_wpnonce_create-user" name="_wpnonce_create-user" value="a5ca71e08a">
		<input type="hidden" name="id" value="<?php echo isset($post) ? $post->id : '' ?>">	

		<table class="form-table" role="presentation">
			<tbody>
				<tr class="form-field form-required">					
					<th scope="row"><label for="user_login">サロン名</label></th>
					<td><input name="name" type="text" id="name" aria-required="true" autocapitalize="none" autocorrect="off" maxlength="60" value="<?php echo isset($post) ? $post->name : '' ?>"></td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row"><label for="user_login">取扱代理店</label></th>
					<td>
                        <select id="shop" name="shop">
                            <option value=""></option>
                        <?php
                        foreach($shops as $shop){
                            ?>
                            <option value="<?php echo $shop->shop_name ?>"
                                <?php
                                    if(isset($post) && ($post->shop == $shop->shop_name))
                                        echo 'selected';                                    
                                ?>
                                ><?php echo $shop->shop_name ?></option>
                            <?php
                        }
                        ?>
                        </select>
                        <!-- <input name="shop" type="text" id="shop" aria-required="true" autocapitalize="none" autocorrect="off" maxlength="60" value="<?php echo isset($post) ? $post->shop : '' ?>"></td> -->
				</tr>
				<tr class="form-field form-required">
					<th scope="row"><label for="user_login">住所</label></th>
					<td><input name="address" type="text" id="address" aria-required="true" autocapitalize="none" autocorrect="off" maxlength="100" value="<?php echo isset($post) ? $post->address : '' ?>"></td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row"><label for="user_login">電話番号</label></th>
					<td><input name="tel" type="text" id="tel" aria-required="true" autocapitalize="none" autocorrect="off" maxlength="60" value="<?php echo isset($post) ? $post->tel : '' ?>"></td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row"><label for="user_login">E-mail</label></th>
					<td><input name="mail" type="text" id="mail" aria-required="true" autocapitalize="none" autocorrect="off" maxlength="60" value="<?php echo isset($post) ? $post->mail : '' ?>"></td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row"><label for="user_login">配送先住所<br><span class="text-danger">※登録住所と異なる場合のみ</span></label></th>
					<td><input name="shipping_info" type="text" id="shipping_info" aria-required="true" autocapitalize="none" autocorrect="off" maxlength="600" value="<?php echo isset($post) ? $post->shipping_info : '' ?>"></td>
				</tr>
			</tbody>
		</table>
		<div id="carbon_fields_container_cover" style="display: block;">
			<table class="form-table">
				<tbody><tr class="carbon-table-row">
					<th></th>
					<td>
						<fieldset class="container-holder carbon-user-container container-carbon_fields_container_cover carbon-fields-collection" data-profile-role="">
							<div class="carbon-container carbon-container-carbon_fields_container_cover carbon-container-user_meta">
								<input type="hidden" id="carbon_fields_container_cover_nonce" name="carbon_fields_container_cover_nonce" value="1057436d27">
								<div class="carbon-field carbon-image">
									<label for="carbon-field-3">画像</label>
									<div class="field-holder">
										<div class="carbon-attachment">
											<input type="hidden" id="carbon-field-3" name="_user_cover" value="" readonly="">
											<div class="carbon-description 
											<?php 
												if(isset($post) && !empty($post->img) && $post->img != '')
													echo '';
												else
													echo 'hidden';
											?>">
												<div class="carbon-attachment-preview 
												<?php 
													if(isset($post) && !empty($post->img) && $post->img != '')
														echo '';
													else
														echo 'hidden';
												?>">
													<input type="hidden" name="photo_base64" id="photo_base64">
													<img src="<?php echo isset($post) ? "../wp-content/plugins/membership-ordering-system/assets/client/".$post->img : '' ?>" class="thumbnail-image" id="photo">												
													<div class="carbon-file-remove dashicons-before dashicons-no-alt"></div>
												</div>
											</div>
											<input type="file" name="profile_photo_path" id="profile_photo_path" class="d-none">
											<span class="button" id="select_img">画像を選択</span>
										</div>
									</div>
								</div>
							</div>
						</fieldset>
					</td>
				</tr>
			</tbody></table>
		</div>
		<p class="submit">
			<?php
				if(!isset($post) && empty($post->id))
					echo '<input type="button" name="create" id="create" class="button button-primary" value="客先新規登録">';
				else{
					// echo '<input type="hidden" name="action" value="update">';
					echo '<input type="button" name="update" id="update" class="button button-primary mr-1" value="アップデート">';
                    echo '<input type="button" name="delete" id="delete" class="button button-primary" value="削除">';
				}
			?>
		</p>
	</form>
</div>
<script src="../wp-content/plugins/membership-ordering-system/assets/js/bootstrap.bundle.min.js"></script>
<!-- <script src="../wp-content/plugins/membership-ordering-system/assets/js/jquery.easing.min.js"></script> -->
<script src="../wp-content/plugins/membership-ordering-system/assets/js/sb-admin-2.min.js"></script>
<!-- <script src="../wp-content/plugins/membership-ordering-system/assets/js/jquery.autosize.min.js"></script> -->
<script type="text/javascript">
	var $modal = jQuery('#modal');

    var cropper;
    
    var sel_img = "breeder_base64";
    var pre_img = "breeder_preview";

    jQuery('#profile_photo_path').on('change', function(e) {
       
        sel_img = "breeder_base64";
        pre_img = "breeder_preview";
        var files = e.target.files;
        var done = function(url) {
            image.src = url;
            jQuery('#modal').modal('show');
        };
        var reader;
        var file;
        var url;
        if (files && files.length > 0) {
            file = files[0];
            if (URL) {
                done(URL.createObjectURL(file));
            } else if (FileReader) {
                reader = new FileReader();
                reader.onload = function(e) {
                    done(reader.result);
                };
                reader.readAsDataURL(file);
            }
        }
    });
    $modal.on('shown.bs.modal', function() {
        cropper = new Cropper(image, {
            aspectRatio: 5/3,
            viewMode: 3,
            preview: '.preview'
        });
    }).on('hidden.bs.modal', function() {
        cropper.destroy();
        cropper = null;
    });

    jQuery("#crop").click(function() {
        canvas = cropper.getCroppedCanvas({
            width: 500,
            height: 300,
        });
        canvas.toBlob(function(blob) {
            url = URL.createObjectURL(blob);
            var reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = function() {
                jQuery("#photo_base64").val(reader.result);
                jQuery("#photo").attr("src", reader.result);
                $modal.modal('hide');
                jQuery('.carbon-description').removeClass('hidden');
                jQuery('.carbon-description .carbon-attachment-preview').removeClass('hidden');
            }
        });
    });

    jQuery("body").on("click", "#select_img", function (e) {
        jQuery("#profile_photo_path").trigger("click");
    });

    jQuery("body").on("click", ".carbon-file-remove", function (e) {
		jQuery('.carbon-description').addClass('hidden');
        jQuery('.carbon-description .carbon-attachment-preview').addClass('hidden');
        jQuery('#photo').attr('src', '');
        jQuery('#photo_base64').val('');
	});
    jQuery("body").on("click", "#create, #update", function (e) {
        if(jQuery.trim(jQuery('#name').val()) == ''){
            jQuery('#name').addClass('errors');
            return;
        }
        if(jQuery.trim(jQuery('#shop').val()) == ''){
            jQuery('#shop').addClass('errors');
            return;
        }
        if(jQuery.trim(jQuery('#address').val()) == ''){
            jQuery('#address').addClass('errors');
            return;
        }
        if(jQuery.trim(jQuery('#tel').val()) == ''){
            jQuery('#tel').addClass('errors');
            return;
        }
        if(jQuery.trim(jQuery('#mail').val()) == ''){
            jQuery('#mail').addClass('errors');
            return;
        }
        if(jQuery.trim(jQuery('#shipping_info').val()) == ''){
            jQuery('#shipping_info').addClass('errors');
            return;
        }
        if(!isEmail(jQuery.trim(jQuery('#mail').val()))){
            jQuery('#mail').select();
            jQuery('#mail').addClass('errors');
            return;
        }
        jQuery('#createuser').submit();
    });
    jQuery("body").on("focus", "#shop, #name, #address, #tel, #mail, #shipping_info", function (e) {
        jQuery(this).removeClass('errors');
    });
    jQuery("body").on("click", "#delete", function (e) {
        jQuery('#action').val('delete');
        var id = jQuery('#id').val();
        if(id == '')
            return;
        jQuery('#createuser').submit();
    });
    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }
</script>