<?php 
?>
<!-- HEAD -->
	<?php 
	
	$title = @$data ? FSText :: _('Sửa kỳ hạn'): FSText :: _('Sửa kỳ hạn');
	global $toolbar;
	$toolbar->setTitle($title);
	$toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png'); 
	$toolbar->addButton('apply',FSText::_('Apply'),'','apply.png'); 
	$toolbar->addButton('save',FSText::_('Save'),'','save.png'); 
	$toolbar->addButton('cancel',FSText::_('Cancel'),'','cancel.png');   
	
	$this -> dt_form_begin();
	TemplateHelper::dt_edit_text(FSText :: _('Name'),'name',@$data -> name);
//	TemplateHelper::dt_edit_text(FSText :: _('Price'),'price',@$data -> price);
	TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
//	TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',str_replace('/original/','/resized/',URL_ROOT.@$data->image));
	TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
//    TemplateHelper::dt_edit_text(FSText :: _('Tóm tắt'),'code',@$data -> code);
//    TemplateHelper::dt_edit_text(FSText :: _('Mô tả'),'content',@$data -> content,'',650,450,1);


    $this -> dt_form_end(@$data);
	?>
<!-- END HEAD-->
