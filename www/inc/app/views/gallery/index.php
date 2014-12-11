<?php
$this->breadcrumbs=array($m->getTitle());
$this->widget('zii.widgets.CListView', array(
		'dataProvider'=>Gallery::search(9),
		'itemView'=>'_view',
		'template'=>"{items}\n{pager}",
		'cssFile'=>false,
		'pager'=>array(
				'class' => 'CLinkPager',
				'cssFile'=>false,
				'header'=>'',
				'prevPageLabel'=>'По-нови',
				'nextPageLabel'=>'По-стари',
				'maxButtonCount'=>'0',
		),
		'htmlOptions' => array('style'=>'padding-top:0px;')
));

$this->widget('CLinkPager');
