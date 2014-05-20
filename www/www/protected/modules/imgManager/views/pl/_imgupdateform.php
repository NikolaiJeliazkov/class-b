
<!--
/**
* Gallery  Management  _imgupdateform file in Admin Page.
*
* @author Kabasakalis Spiros <kabasakalis@gmail.com>,myspace.com/spiroskabasakalis
* @copyright Copyright &copy; 2011 Spiros Kabasakalis
* @since 1.0
* @license The MIT License
*/
    -->
<div class="image_update">
	<h3>
		<?php echo Yii::t('ImgManagerModule.adminimages', 'Update Image Title And Link' )?>
	</h3>
	<br>
	<h2>
		<?php echo ($_POST['basename'] . $_POST['extension'] ); ?>
	</h2>

	<form id="updateimageform_<?php echo $_POST['file_id'] ?>"
		style="display: block;">
		<div class="input_div">

			<strong><?php echo Yii::t('ImgManagerModule.adminimages', 'Title' )?>:
			</strong><br> <input type="text" size="60"
				value=<?php echo!empty($_POST['title']) ? '"' . $_POST['title'] . '"' : '&nbsp'; ?>
				name=<?php echo '"' . $_POST['file_id'] . '_title_input' . '"'; ?>><br>


			<strong><?php echo Yii::t('ImgManagerModule.adminimages', 'Description' )?>:
			</strong>
			<textarea
				value=<?php echo!empty($_POST['desc']) ? '"' . $_POST['desc'] . '"' : '&nbsp'; ?>
				name=<?php echo '"' . $_POST['file_id'] . '_desc_input' . '"'; ?>>
			</textarea>


			<div class="select_wrapper">
				<strong> <?php echo Yii::t('ImgManagerModule.adminimages', 'Link' )?>:
				</strong><br> <select class="sel2"
					name="<?php echo $_POST['file_id'] ?>_url_select"
					id="<?php echo $_POST['file_id'] ?>_url_select"><?php echo $ops ?>
				</select>
			</div>

			<input type="hidden" name="file_id"
				value=<?php echo '"' . $_POST['file_id'] . '"' ?>>
		</div>

		<div class="thumb_container">
			<?php echo CHtml::image($_POST['path'] . '/tmb/' . $_POST['file_id'] . '_100_100' . '_thumb' . $_POST['extension'], $_POST['title'], array('class' => 'tmb')) ?>
		</div>
		<div class="savebutton_div">
			<button id="jui_update_btn"></button>
		</div>
	</form>
</div>


<script type="text/javascript">


    $(function() {

 $( "#jui_update_btn" ).button({ label: "<?php echo Yii::t('ImgManagerModule.adminimages', 'Save' )?>" }).click(function() { return false; });
 //$( "#jui_update_btn" ).click(function() { return false; })//


        //Fetch Image Info to set  the values of title input and selected option.
        $.ajax({
            type:'POST',
            url: '<?php echo Yii::app()->baseUrl; ?>/imgManager/pl/fetch_image_info',
            data:$('#updateimageform_<?php echo $_POST['file_id']; ?>').serialize(),
            success: function(data){

                img=jQuery.parseJSON(data);

                $("input[name='"+img.file_id+"_title_input']").val(img.title);
                  $("input[name='"+img.file_id+"_tr_title_input']").val(img.tr_title);
                 $("textarea[name='"+img.file_id+"_desc_input']").val(img.desc);
                 $("textarea[name='"+img.file_id+"_tr_desc_input']").val(img.tr_desc);

               var  selected_title= $("#"+img.file_id+"_url_select option[value='"+img.url+"']").text();

                if (img.url !='nolink'  && img.url !=''  &&  img.url !=null ){

                    $(".select_wrapper > input").val(selected_title);
                  $("#"+img.file_id+"_url_select option[value='"+img.url+"']").attr('selected', 'selected');
                }
                else{

                    $("#"+img.file_id+"_url_select option[value='nolink']").attr('selected', 'selected');
                          $(".select_wrapper > input").val("No Link");

                }

            }
        });//ajax

 //autocomplete combobox for links
	$( ".sel2" ).combobox();


        //Update Image Info In Database
        $('#jui_update_btn').click(function(){

            $.ajax({
                type:'POST',
                url: '<?php echo Yii::app()->baseUrl; ?>/imgManager/pl/updateinfo',
                data:$('#updateimageform_<?php echo $_POST['file_id']; ?>').serialize(),
                success: function(res){
                    var imginfo=jQuery.parseJSON(res);
                   // console.log(imginfo,'imginfo res in _imgupdateform');
                    $("#"+imginfo.file_id+"_title").text(imginfo.title);
                    $("#"+imginfo.file_id+"_thumb").attr('alt', imginfo.title);
                    $('#'+imginfo.file_id+' > div').find('a').attr('title',imginfo.desc);
                    $.fancybox.close();

                }
            });

        });
    });
</script>
