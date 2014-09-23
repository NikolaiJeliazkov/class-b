<?php

/**
 * Gallery Manager- Module's main view file .
 *
 * @author Spiros Kabasakalis <kabasakalis@gmail.com>,myspace.com/spiroskabasakalis
 * @copyright Copyright &copy; 2011 Spiros Kabasakalis
 * @since 1.0
 * @license The MIT License
 */
//this is for tab selection persistence,after a page refresh.
YiiUtil::registerJs('imgManager.extensions.jqui1819','development-bundle/external/jquery.cookies.2.2.0.js');
?>

<h1><?php echo (isset($this->currentGallery))?$this->currentGallery->title:Yii::t('ImgManagerModule.adminimages','No Gallery selected'); ?></h1>

<div>
	<div id="desc_wrapper">
		<?php echo (isset($this->currentGallery))?$this->currentGallery->g_desc:''?>
	</div>
	<div class="content-box-content well">
		<div id="galselectwrapper">
			<?php
			$ses= Yii::app()->session;
			$gals=Gal::model()->findAll();

			echo CHtml::dropDownList('gal_name', ($_POST['galid']!=null && $_POST['galid']!='')?$_POST['galid']:$ses->get('s_galid','no_gal_selected'),
					CHtml::listData($gals, 'id', 'title'),
					array('empty' =>array('no_gal_selected'=>Yii::t('ImgManagerModule.adminimages','---Please Select A Gallery---')),
							'submit'=>'',
							'csrf'=>true,
							'params' => array('galid'=>'js:$(this).val()'),
					)
			);
			?>
		</div>
		<div class="noteswrap">
			<div id="success-note" class="notification success png_bg" style="display: none;">
				<div></div>
			</div>

			<div id="error-note" class="notification errorshow png_bg" style="display: none;">
				<div></div>
			</div>
		</div>
		<div id="slidertabs">

			<ul>
				<li><a href="#gallery"><?php echo Yii::t('ImgManagerModule.adminslider','Uploaded Images') ?>
				</a></li>
				<li><a href="#pluploader"><?php echo  Yii::t('ImgManagerModule.adminslider','Image Uploader')  ?>
				</a></li>
				<li><a href="#admingalleries"><?php echo Yii::t('ImgManagerModule.adminimages','Gallery Administration')   ?>
				</a></li>
			</ul>


			<div id="gallery">


				<?php
				//messages
				$del_msg=Yii::t('ImgManagerModule.adminimages','Are you sure you want to delete this image?');
				$del_title_image=Yii::t('ImgManagerModule.adminimages','Image Delete Confirmation');
				$tit=Yii::t('ImgManagerModule.adminimages','Title');
				$or=Yii::t('ImgManagerModule.adminimages','Original Filename');
				$del=Yii::t('ImgManagerModule.adminimages','Delete');
				$cncl=Yii::t('ImgManagerModule.adminimages','Cancel');
				?>

				<div class="gallery-container">

					<div class="black-text">
						<?php if(!empty($gals)&&!empty($this->picItems)) echo Yii::t('ImgManagerModule.adminimages','Click on thumbnails to see full images.Click And Drag to rearrange the order of images.');?>
					</div>
					<?php

					if($this->galid != 'no_gal_selected'  && !empty($gals) && (count($this->picItems))){
						$this->widget('zii.widgets.jui.CJuiSortable', array(
								'items'=>$this->picItems,
								'id'=>'container_sortable',
								'theme'=>'base',
								'options'=>array(
										'delay'=>'300',

										'stop' => "js: function(){
										//var ids = new Object();
										var ids = new Array();
										var wrappers = $(this).find('div.thumb_item');
										var galid=$(this).find('.gal').attr('id');
										// console.log(galid);
										$(wrappers).each(function(){
										var fileid = $(this).attr('id');
										var title=$(this).children('.tit').attr('id');

										//console.log(title);
										//ids[fileid]=title;
										ids.push(fileid);
					});
										norder=JSON.stringify(ids);
										//console.log(ids,'ids');

										$.post('$this->pageUrl', {'newImgOrder':ids.toString(),'galid':galid});
					}"
								),
						));

					}
					else
					{

						if (empty($gals)) echo '<br><div class="black-text">'.Yii::t('ImgManagerModule.adminimages', 'No galleries created yet.') .'</div>';
						else
							if( $this->galid != 'no_gal_selected'){
							echo '<div class="black-text">'.Yii::t('ImgManagerModule.adminimages', 'No images uploaded yet.') .'</div>' ;
						}else  echo '<div class="black-text">'.Yii::t('ImgManagerModule.adminimages', 'Please select a gallery.')  .'</div>' ;
					}

					?>


				</div>

				<div id="msg" class="clear"></div>

			</div>
			<!--gallery-->

			<div id="pluploader">


				<div id="pl">


					<?php
					if (($this->galid !='no_gal_selected') &&  (!empty($gals))){
						$this->widget('imgManager.extensions.plupload.PluploadWidget', array(
								'config' => array(
										'runtimes' => 'gears,flash,silverlight,browserplus,html5',
										'multipart_params'=>  array(),
										'url' => $this->createUrl('/imgManager/pl/upload/'),
										'max_file_size' => $this->module->max_file_size,
										'chunk_size' => '1mb',
										'unique_names' => true,
										'filters' => array(
												array('title' => Yii::t('app', 'Images files'), 'extensions' => 'jpg,jpeg,gif,png'),
										),
										'language' => Yii::app()->language,
										'max_file_number' => $this->module->max_file_number,
										'autostart' => false,
										'jquery_ui' => false,
										'reset_after_upload' => true,
								),
								//the following callback function will generate  for every image uploaded :a title input ,a link select control,
								//and an thumbnail image ,then it will append them to the images_form form.
								//It will also populate the javascript array unique_ids with the unique file ids of the newly uploaded images.

								'callbacks' => array(
										'UploadComplete' => 'function(uploader,files){

										uploader.refresh();
					}',
										'FileUploaded' => 'function(up,file,response){


										var res=response.response;
										var resobj=jQuery.parseJSON(res);
										var links=new Object();

										//console.log("RESPONSE RESPONSE: "+res);
										// console.log("ORNAME: "+resobj.filename);

										$(\'#uploaded_images\').show();
										$("#image_inputs").prepend("<div id=\'"+ resobj.file_id +
										"\' class=\'span-6 griditem imgupload\'><a  rel=\'just_uploaded\'   href=" + resobj.upload_path +"/"+resobj.file_id + resobj.file_ext +
										"  target=\'_blank\'> <img   src=\'"+resobj.upload_path +"/tmb/"   +resobj.file_id  +"_100_100"+"_thumb" + resobj.file_ext +"\' border=\'0\'><br>" + resobj.filename + "</a><br><br>(Size: " + resobj.file_size + ") <span></span><br><br>"
										+"<strong>'.Yii::t('ImgManagerModule.adminimages', 'Title' ).': <strong><input  size=\'30\'  type=\'text\' name=\'title_"+resobj.file_id+"\'value=\'\'  /><br /><br/>"
										+"<strong>'.Yii::t('ImgManagerModule.adminimages', 'Description' ).': <strong><textarea  rows=\'5\'  cols=\'2\' name=\'desc_"+resobj.file_id+"\'value=\'\'  /><br /><br/>"
										+"   <label for=\'link_image\'>'.Yii::t('ImgManagerModule.adminimages', 'Link' ).'</label>  "+
										" <input type=\'checkbox\' value=\'1\' id=\'link_image\' name=\'link_image\'  onclick=$(\'#select_div_"+resobj.file_id+"\').toggle();> "+
										"<div  id=\'select_div_"+resobj.file_id+"\'  style=\'display: none;\'><select class=\'sel\' id=\'url_select_"+resobj.file_id+"\' name=\'url_select_"+resobj.file_id+"\'>"+op+"</select></div>"+
										"</div>"

								);
										$( ".sel" ).combobox();
										$(\"a[rel^=\'just_uploaded\']\").prettyPhoto({theme: "dark_rounded",
										slideshow:5000,
										autoplay_slideshow:false,
										deeplinking: false,
										social_tools:false
					});
										unique_ids.push(resobj.file_id);
										//console.log("FILES_UNIQUE IDS: "+ unique_ids);
					}',

								),
								'id' => 'uploader'
						));
					}
					else {

						if (empty($gals)) echo '<br><div class="black-text">'.Yii::t('ImgManagerModule.adminimages', 'No galleries found.You have to create and select a gallery first.').'</div>';
						else echo '<div class="black-text">'.Yii::t('ImgManagerModule.adminimages', 'You have to select a gallery before you upload any images.').'</div>' ;
					}

					?>

				</div>


				<div id="uploaded_images">

					<form id="images_form" action="">
						<div id="image_inputs" class="container"></div>
						<input type="hidden" name="galid"
							value="<?php  echo $this->galid ?>">
						<div id="sub_btn_div">
							<button id="sub_btn"></button>
						</div>
					</form>
					<div id="status"></div>
				</div>

			</div>
			<!-- div uploader -->


			<div id="admingalleries">


				<div class="floatright">
					<?php
					$iconfolder = YiiBase::getPathOfAlias('imgManager.images.icons');
					$iconbaseUrl = Yii::app()->assetManager->publish($iconfolder);

					echo CHtml::link(CHtml::image($iconbaseUrl . '/add.png',
							'Add',
							array('id'=>'addbutton')),
							'#',
							array(  'id' =>'galcreate',
									'title'=>   Yii::t('ImgManagerModule.adminimages','Add Gallery') )

					);
					?>
				</div>



				<?php
				//ajax messages
				$del_con=Yii::t('ImgManagerModule.adminimages','Are you sure you want to delete this gallery?');
				$del_title=Yii::t('ImgManagerModule.adminimages','Gallery Delete Confirmation');
				$del=Yii::t('ImgManagerModule.adminimages','Delete');
				$cancel=Yii::t('ImgManagerModule.adminimages','Cancel');


				$dp=new CActiveDataProvider('Gal');
				$this->widget('zii.widgets.grid.CGridView', array(
						'id'=>'gal-grid',
						'dataProvider'=>$gal_Model->search(),
						// 	'filter'=>$gal_Model,
// 						'cssFile'=> YiiUtil::registerCss('imgManager.css','gridView/gridView.css'),
						'pager' => array('cssFile' => Yii::app()->baseUrl . '/css/gridViewStyle/gridView.css'),
						'cssFile' => Yii::app()->baseUrl . '/css/gridViewStyle/gridView.css',
						'htmlOptions' => array('class' => 'grid-view rounded'),

						'columns'=>array(
								'id',
								'title',
// 								'tr_title',
								'g_desc',
// 								'tr_desc',
								array(
										'class'=>'CButtonColumn',
										'buttons'=>array(
												'gallery_delete' => array(
														'label'=>Yii::t('ImgManagerModule.adminimages','Delete'),     // text label of the button
														'url'=>'$data->id',       // a PHP expression for generating the URL of the button
														'imageUrl'=>YiiUtil::publishedImageUrl('imgManager.css','gridView','delete','png'),  // image URL of the button. If not set or false, a text link is used
														'options'=>array("class"=>"del",'title'=>Yii::t('ImgManagerModule.adminimages','Delete')), // HTML options for the button tag

												),
												'gallery_update' => array(
														'label'=>Yii::t('ImgManagerModule.adminimages','Update'),     // text label of the button
														'url'=>'$data->id',       // a PHP expression for generating the URL of the button
														'imageUrl'=>YiiUtil::publishedImageUrl('imgManager.css','gridView','update','png'),  // image URL of the button. If not set or false, a text link is used
														'options'=>array("class"=>"fan_update",'title'=>Yii::t('ImgManagerModule.adminimages','Update')), // HTML options for the button tag

												)
										),
										'template' => '{gallery_update}{gallery_delete}',
										//   'updateButtonImageUrl'=>YiiUtil::getCustomCssUrl('gridView/update.png'),
										//  'deleteButtonImageUrl'=>YiiUtil::getCustomCssUrl('gridView/delete.png'),

								),

						),
						'afterAjaxUpdate'=>'js:function(){


						$("tbody tr:even").addClass("alt-row");


						//AJAX DELETE WITH CONFIRAMTION DIALOG
						var deletes=new Array();
						var dialogs=new Array();

						$(".del").each(function(index) {

						var id =$(this).attr("href");

						deletes[id]=function(){

						$.ajax({
						type: "POST",
						url: "'.Yii::app()->request->baseUrl.'/imgManager/pl/galleryDelete",
						data:{"id":id},
						success: function(data){

						var  res=jQuery.parseJSON(data);
						$.fn.yiiGridView.update("gal-grid", {url:""});

						$.ajax({
						type: "POST",
						url: "'.Yii::app()->baseUrl.'/imgManager/pl/fetchGalSelectionList",
						data:{},
						success: function(data){  //remember selection
						var oldselection=  $("#gal_name").val();
						//remove all options from gallery dropdownlist
						$("#gal_name")
						.find("option[value!=no_gal_selected]")
						.remove();
						var  result=jQuery.parseJSON(data);
						var res=result["options"];
						//add the updated options to gallery dropdownlist.
						jQuery.each(res, function(value, title) {
						$("#gal_name").append("<option value="+value+">"+title+"</option>");
});
						//If we are deleting the selected gallery
						if (id==oldselection){
						//set the selected value to no_gal_selected
						$("#gal_name").val("no_gal_selected");
						//update the title and description in the wrapper div
						$("div.content-box-header > h3").text("No Gallery selected");
						$("#desc_wrapper").text("");
						$("#gallery").children().remove().end().html("<div class=\'black-text\'>'.Yii::t('ImgManagerModule.adminimages','No Gallery selected').'</div>");
						$("#pluploader").children().remove().end().html("<div class=\'black-text\'>'.Yii::t('ImgManagerModule.adminimages','No Gallery selected').'</div>");
} else
						//reset the original selection
						$("#gal_name").val(oldselection);
}

});//ajax

}//success

})//ajax


};//end of deletes


						dialogs[id]=

						$("<div style=\'text-align:center;\'></div>")
						.html("'.$del_con.'<br><br><h2 style=\'color:#999999\'>ID: "+id+"</h2>"  )
						.dialog(
						{
						autoOpen: false,
						title: "'.$del_title.'",
						modal:true,
						resizable:false,
						buttons: [
						{
						text: "'.$del.'",
						click: function() {


						deletes[id]();
						$(this).dialog("close");


}
},

{
						text: "'.$cancel.'",
						click: function() { $(this).dialog("close"); }
}


						]
}
				);






						$(this).bind("click", function() {
						dialogs[id].dialog("open");
						// prevent the default action, e.g., following a link
						return false;
});

});//each end

						//AJAX GAL  UPDATE


						$(".fan_update").each(function(index) {

						var id =$(this).attr("href");


						$(this).bind("click", function() {
						$.ajax({
						type: "POST",
						url: "'.Yii::app()->baseUrl.'/imgManager/pl/returnGalForm",
						data:{"update_galid":id},
						success: function(data){

						$.fancybox(data,
						{    "transitionIn"	:	"elastic",
						"transitionOut"    :      "elastic",
						"speedIn"		:	600,
						"speedOut"		:	200,
						"overlayShow"	:	false,
						"hideOnContentClick": false,
						"onClosed":    function(){$.fn.yiiGridView.update("gal-grid", {url:""});
						$.ajax({
						type:"POST",
						url: "'.Yii::app()->baseUrl.'/imgManager/pl/fetchGalSelectionList",
						data:{},
						success: function(data){  //remeber selection
						var oldselection=  $("#gal_name").val();
						//remove all options from gallery dropdownlist
						$("#gal_name")
						.find("option[value!=no_gal_selected]")
						.remove();
						var  result=jQuery.parseJSON(data);
						var res=result["options"];
						var descs=result["descs"];

						//add the updated options to gallery dropdownlist.
						jQuery.each(res, function(value, title) {
						$("#gal_name").append("<option value="+value+">"+title+"</option>");
});
						$("#gal_name").val(oldselection);
						//if we are updating the selected gallery...
						if (id==oldselection){
						//update the title and description in the wrapper div
						$("div.content-box-header > h3").text(res[id]);
						$("#desc_wrapper").text(descs[id]);
}
}

});//ajax
}//onclosed
}
				);

} //success
});//ajax
						return false;
});

});//each end




}',

)); ?>

			</div>


		</div>
		<!--slider tabs   -->

	</div>
	<!-- End .content-box-content -->
</div>
<!-- End .content-box -->



<script type="text/javascript">
    //COMBOBOX

    (function( $ ) {
		$.widget( "ui.combobox", {
			_create: function() {
				var self = this,
					select = this.element.hide(),
					selected = select.children( ":selected" ),
					value = selected.val() ? selected.text() : "";
				var input = this.input = $( "<input>" )
					.insertAfter( select )
					.val( value )
					.autocomplete({
						delay: 0,
						minLength: 0,
						source: function( request, response ) {
							var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
							response( select.children( "option" ).map(function() {
								var text = $( this ).text();
								if ( this.value && ( !request.term || matcher.test(text) ) )
									return {
										label: text.replace(
											new RegExp(
												"(?![^&;]+;)(?!<[^<>]*)(" +
												$.ui.autocomplete.escapeRegex(request.term) +
												")(?![^<>]*>)(?![^&;]+;)", "gi"
											), "<span style='color:#62F2F0;font-weight:bolder;'>$1</span>" ),
										value: text,
										option: this
									};
							}) );
						},
						select: function( event, ui ) {
							ui.item.option.selected = true;
							self._trigger( "selected", event, {
								item: ui.item.option
							});
						},
						change: function( event, ui ) {
							if ( !ui.item ) {
								var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( $(this).val() ) + "$", "i" ),
									valid = false;
								select.children( "option" ).each(function() {
									if ( $( this ).text().match( matcher ) ) {
										this.selected = valid = true;
										return false;
									}
								});
								if ( !valid ) {
									// remove invalid value, as it didn't match anything
									$( this ).val( "" );
									select.val( "" );
									input.data( "autocomplete" ).term = "";
									return false;
								}
							}
						}
					})
					.addClass( "ui-widget ui-widget-content ui-corner-left" );

				input.data( "autocomplete" )._renderItem = function( ul, item ) {
					return $( "<li></li>" )
						.data( "item.autocomplete", item )
						.append( "<a>" + item.label + "</a>" )
						.appendTo( ul );
				};

				this.button = $( "<button type='button'>&nbsp;</button>" )
					.attr( "tabIndex", -1 )
					.attr( "title", "Show All Items" )
					.insertAfter( input )
					.button({
						icons: {
							primary: "ui-icon-triangle-1-s"
						},
						text: false
					})
					.removeClass( "ui-corner-all" )
					.addClass( "ui-corner-right ui-button-icon" )
					.click(function() {
						// close if already visible
						if ( input.autocomplete( "widget" ).is( ":visible" ) ) {
							input.autocomplete( "close" );
							return;
						}

						// work around a bug (likely same cause as #5265)
						$( this ).blur();

						// pass empty string as value to search for, displaying all results
						input.autocomplete( "search", "" );
						input.focus();
					});
			},

			destroy: function() {
				this.input.remove();
				this.button.remove();
				this.element.show();
				$.Widget.prototype.destroy.call( this );
			}
		});
	})( jQuery );

	$(function() {
		$( ".sel" ).combobox();
	});




    //------------------------------------------------------------------------------
 //BUTTONS
$(function() {
 $( "#sub_btn" ).button({ label: "<?php echo Yii::t('ImgManagerModule.adminimages', 'Save' )?>" }).click(function() { return false; });
});

//TABS
      $( function()
			{
				var cookieName = 'stickyTab3';

				$( '#slidertabs' ).tabs( {
					selected: ( $.cookies.get( cookieName ) || 0 ),
					select: function( e, ui )
					{
						$.cookies.set( cookieName, ui.index );
					}
				} );
			} );


          var imginfo=new Object();

          var unique_ids=new Array();
          var op="";

       $(document).ready(function() {


//get links for the select options.
  $.ajax({
                    type: "POST",
                    url: "<?php echo Yii::app()->baseUrl; ?>/imgManager/pl/getlinks/",
                    data:{'echojson':true},

                    success: function(data) {

                      links=jQuery.parseJSON(data);
                      for (var l in links)
                             {
                        op=op+"<option value='"+links[l]["url"]+"'>"+links[l]["title"]+"</option>";
                                 };
                    } //success
                }); //ajax


//show the form only when user has uploaded images
          $("#uploaded_images").hide();


//Submit title and link for newly uploaded images,will call actionHandle of Pl controller
            $("#sub_btn").click(function() {

                for (var i=0;i<unique_ids.length;i++)
                {
                    var infoobj=new Object;
                    var titlekey="title_"+unique_ids[i];
                      var tr_titlekey="tr_title_"+unique_ids[i];
                    var desckey="desc_"+unique_ids[i];
                      var tr_desckey="tr_desc_"+unique_ids[i];
                    var urlkey="url_select_"+unique_ids[i];

                   infoobj["title"]= $('input[name =' + titlekey+']').val();
                       infoobj["tr_title"]= $('input[name =' + tr_titlekey+']').val();
                   infoobj["desc"]= $('textarea[name =' + desckey+']').val();
                   infoobj["tr_desc"]= $('textarea[name =' + tr_desckey+']').val();
                   infoobj["url"]=$('select:[name='+ urlkey +'] option:selected').val();
                     infoobj["gid"]= $('input[name ="galid"]').val();


                    imginfo[unique_ids[i]]= infoobj;

                   // console.log("INFOOBJ: "+ JSON.stringify(infoobj));
                   // console.log("TITLEKEY: "+ titlekey);
                   // console.log("URLKEY: "+ urlkey);
                };

                var imginfo_parsed= jQuery.parseJSON (JSON.stringify( imginfo));

                $.ajax({
                    type: "POST",
                    url: "<?php echo Yii::app()->baseUrl; ?>/imgManager/pl/handle/",
                    data: { 'imginfo_parsed':imginfo_parsed,'galid':"<?php echo  $this->galid;?>"},
                    success: function() {


                        $('#image_inputs').empty();
                        $('#uploaded_images').fadeOut(1500, function() { $(this).hide();  });
                        $('#success-note > div').html("<?php echo Yii::t('ImgManagerModule.adminimages','Images Submitted!') ?>");
                        $('#success-note').attr('style','').fadeIn(3500);
                        window.location="<?php echo Yii::app()->baseUrl; ?>/imgManager/pl/index";
                    } //success
                }); //ajax

              }); //subbtn



      //BIND FANCYBOX to to edit icon,so that when clicked,  _imgupdateform
      //partial view is rendered inside fancybox.
        $('.fan').each(function(index) {

            var $id=$(this).attr('id');
            var parentdiv=$(this).parent('div');
            var fileid=parentdiv.attr('id');


            $(this).bind('click', function() {
                $.ajax({
                    type: "POST",
                    url: "<?php echo Yii::app()->baseUrl; ?>/imgManager/pl/returnform",
                     data:$(".fileinfo"+fileid).serialize(),
                    success: function(data){

                        $.fancybox(data,
                        {    "transitionIn"	:	"elastic",
                            "transitionOut"    :      "elastic",
                             "speedIn"		:	600,
                            "speedOut"		:	200,
                            "overlayShow"	:	false,
                            "hideOnContentClick": false
                        }
                    );
                        //  console.log(data);
                    } //success
                });//ajax
                return false;
            });//bind

        }); //each


//BIND PRETTY PHOTO to show a slideshow of the images
$("a[rel^='prettyPhoto']").prettyPhoto({theme: "dark_rounded",
                                                           slideshow:5000,
                                                           autoplay_slideshow:false,
                                                           deeplinking: false,
                                                           social_tools:false
                                                           });



  //BIND JUI DIALOG ,for image delete confirmation.
  $('.del_link').each(function(index) {

            var $id=$(this).attr('id');
            var parentdiv=$(this).parent('div');
            var fileid=parentdiv.attr('id');

              var title=$(".fileinfo"+fileid).filter("#title").attr('value');
              var filename=$(".fileinfo"+fileid).filter("#basename").attr('value')
                +$(".fileinfo"+fileid).filter("#extension").attr('value');


            var  dialog=$('<div></div>')
            .html('<?php echo $del_msg  ?><br><br> '+
                      '<?php echo $tit ?> : '+ title+'<br><br>'+
                      '<?php echo $or ?> : '+filename)
            .dialog(
            {
                autoOpen: false,
                title: '<?php echo $del_title_image ?>',
                modal:true,
                resizable:false,
                buttons: [
                    {
                        text: "<?php echo $del ?>",
                        click: function() {
                            $.ajax({
                                type:"POST",
                                url: "<?php echo Yii::app()->baseUrl; ?>/imgManager/pl/delete",
                                data:$(".fileinfo"+fileid).serialize(),
                                success: function(res){

                                   var imginfo= jQuery.parseJSON (res);
                                  // console.log(imginfo);
                                 //  console.log("test basename "+imginfo.basename);

                                    $("#"+fileid).fadeOut(1500,function(){
                                     //     $.fn.yiiListView.update("lv");
                                        $(this).remove();
                                        var message= imginfo.basename +imginfo.extension+" "+"<?php echo Yii::t('ImgManagerModule.adminimages', "has been deleted successfully.") ;?>" ;
                                        $("#success-note >div").html(message).parent().fadeIn(1000);


                                    });

                                }
                            });

                            $(this).dialog("close"); }
                    },

                    {
                        text: "<?php echo $cncl ?>",
                        click: function() { $(this).dialog("close"); }
                    }


                ]
            }
        );


            $('#'+$id).bind('click', function() {
                dialog.dialog('open');
		// prevent the default action, e.g., following a link
		return false;
            });


            //console.log('fileid ' + ': ' + $id);
        });  //each

//AJAX GAL  UPDATE


 $('.fan_update').each(function(index) {

        var id =$(this).attr('href');


       $(this).bind('click', function() {
                 $.ajax({
                    type: "POST",
                    url: "<?php echo Yii::app()->baseUrl; ?>/imgManager/pl/returnGalForm",
                      data:{"update_galid":id},
                  //    data: jQuery.extend({}, $(".fileinfo"+fileid).serialize(), {})     ,

                    success: function(data){

                        $.fancybox(data,
                        {    "transitionIn"	:	"elastic",
                            "transitionOut"    :      "elastic",
                             "speedIn"		:	600,
                            "speedOut"		:	200,
                            "overlayShow"	:	false,
                            "hideOnContentClick": false,
                             "onClosed":    function(){$.fn.yiiGridView.update('gal-grid', {url:''});
                                                                        $.ajax({
                                                                               type: 'POST',
                                                                            url: "<?php echo Yii::app()->baseUrl; ?>/imgManager/pl/fetchGalSelectionList",
                                                                              data:{},
                                                                              success: function(data){  //remeber selection
                                                                                                                       var oldselection=  $('#gal_name').val();
                                                                                                                     //remove all options from gallery dropdownlist
                                                                                                                     $('#gal_name')
                                                                                                                      .find('option[value!=no_gal_selected]')
                                                                                                                       .remove();
                                                                                                               var  result=jQuery.parseJSON(data);
                                                                                                               var res=result['options'];
                                                                                                               var descs=result['descs'];

                                                                                                               //add the updated options to gallery dropdownlist.
                                                                                                               jQuery.each(res, function(value, title) {
                                                                                                               $('#gal_name').append('<option value="'+value+'">'+title+'</option>');
                                                                                                                                                                         });
                                                                                                                       $('#gal_name').val(oldselection);
                                                                                                                                          //if we are updating the selected gallery...
                                                                                                                                               if (id==oldselection){
                                                                                                                                              //update the title and description in the wrapper div
                                                                                                                                            $('div.content-box-header').text(res[id]);
                                                                                                                                             $('#desc_wrapper').text(descs[id]);

                                                                                                                                               }
                                                                                                                  }

                                                                                                    });//ajax
                                                                                                                                   }//onclosed
                        }
                    );
                        //  console.log(data);
                    } //success
                });//ajax
                return false;
            });

  });//each end





//AJAX Gallery  DELETE WITH CONFIRMATION DIALOG
var deletes=new Array();
var dialogs=new Array();


 $('.del').each(function(index) {

        var id =$(this).attr('href');

deletes[id]=function(){

  $.ajax({
                    type: "POST",
                    url: "<?php echo Yii::app()->request->baseUrl ?>/imgManager/pl/galleryDelete",
                  data:{"id":id},
                    success: function(data){

                      var  res=jQuery.parseJSON(data);
                      $.fn.yiiGridView.update("gal-grid", {url:""});

                       $.ajax({
                                                                             type: 'POST',
                                                                            url: "<?php echo Yii::app()->baseUrl; ?>/imgManager/pl/fetchGalSelectionList",
                                                                              data:{},
                                                                              success: function(data){  //remeber selection
                                                                                                                      var oldselection=  $('#gal_name').val();
                                                                                                                     //remove all options from gallery dropdownlist
                                                                                                                     $('#gal_name')
                                                                                                                     .find('option[value!=no_gal_selected]')
                                                                                                                      .remove();
                                                                                                               var  result=jQuery.parseJSON(data);
                                                                                                               var res=result['options'];
                                                                                                               //add the updated options to gallery dropdownlist.
                                                                                                               jQuery.each(res, function(value, title) {
                                                                                                               $('#gal_name').append('<option value="'+value+'">'+title+'</option>');
                                                                                                                                                                         });
                                                                                                                               //If we are deleting the selected gallery
                                                                                                                               if (id==oldselection){
                                                                                                                                        //set the selected value to 'no_gal_selected'
                                                                                                                                       $('#gal_name').val('no_gal_selected');
                                                                                                                                              //update the title and description in the wrapper div
                                                                                                                                            $('div.content-box-header').text("<?php echo  Yii::t('ImgManagerModule.adminimages','No Gallery selected')?>");
                                                                                                                                            $('#desc_wrapper').text('');
                                                                                                                                            $('#gallery').children().remove().end().html("<div class='black-text'><?php echo  Yii::t('ImgManagerModule.adminimages','No Gallery selected')?></div>");
                                                                                                                                            $('#pluploader').children().remove().end().html("<div class='black-text'><?php echo  Yii::t('ImgManagerModule.adminimages','No Gallery selected')?></div>");

                                                                                                                                               } else
                                                                                                                                  //reset the original selection
                                                                                                                               $('#gal_name').val(oldselection);

                                                                                                                  }//success

                                                                                                    });//ajax

                    }//success

                    })//ajax

};//end of deletes


dialogs[id]=

$('<div style="text-align:center;"></div>')
            .html('<?php echo $del_con?><br><br>'+'<h2 style="color:#999999">ID: '+ id +'</h2>' )

            .dialog(
            {
                autoOpen: false,
                title: '<?php echo $del_title ?>',
                modal:true,
                resizable:false,
                buttons: [
                    {
                        text: "<?php echo $del ?>",
                        click: function() {


                     deletes[id]();
                     $(this).dialog("close");


                         }
                    },

                    {
                        text: "<?php echo $cancel ?>",
                        click: function() { $(this).dialog("close"); }
                    }


                ]
            }
        );






       $(this).bind('click', function() {
                dialogs[id].dialog('open');
		// prevent the default action, e.g., following a link
		return false;
            });

  });//each end


//GALLERY CREATION BIND FANCYBOX
      //partial view is rendered inside fancybox.

            $('#galcreate').bind('click', function() {
                $.ajax({
                    type: "POST",
                    url: "<?php echo Yii::app()->baseUrl; ?>/imgManager/pl/returnGalForm",
                      data:{},
                  //    data: jQuery.extend({}, $(".fileinfo"+fileid).serialize(), {})     ,

                    success: function(data){

                        $.fancybox(data,
                        {    "transitionIn"	:	"elastic",
                            "transitionOut"    :      "elastic",
                             "speedIn"		:	600,
                            "speedOut"		:	200,
                            "overlayShow"	:	false,
                            "hideOnContentClick": false,
                             "onClosed":    function(){$.fn.yiiGridView.update('gal-grid', {url:''});
                                                                    $.ajax({
                                                                               type: 'POST',
                                                                            url: "<?php echo Yii::app()->baseUrl; ?>/imgManager/pl/fetchGalSelectionList",
                                                                              data:{},
                                                                              success: function(data){  //remeber selection
                                                                                                                      var oldselection=  $('#gal_name').val();
                                                                                                                     //remove all options from gallery dropdownlist
                                                                                                                     $('#gal_name')
                                                                                                                      .find('option[value!=no_gal_selected]')
                                                                                                                       .remove();
                                                                                                               var  result=jQuery.parseJSON(data);
                                                                                                               var res=result['options'];
                                                                                                               //add the updated options to gallery dropdownlist.
                                                                                                               jQuery.each(res, function(value, title) {
                                                                                                               $('#gal_name').append('<option value="'+value+'">'+title+'</option>');
                                                                                                                                                                         });
                                                                                                                               //set the selection again
                                                                                                                               $('#gal_name').val(oldselection);

                                                                                                                  }

                                                                                                    });//ajax
                                                                                                  } //onclosed function
                        }//fancybox
                    );//fancybox

                    } //success
                });//ajax
                return false;
            });//bind


    });//document ready


      </script>
