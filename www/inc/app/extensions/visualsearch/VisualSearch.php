<?php

class VisualSearch extends CInputWidget
{
	public $htmlOptions = array();

	public function init()
	{
		parent::init();
		Yii::app()->clientScript->registerCoreScript('jquery');
		Yii::app()->clientScript->registerCoreScript('jquery.ui');
		Yii::app()->clientScript->registerCoreScript('autocomplete');
		$assetsPath = Yii::getPathOfAlias('ext.visualsearch.assets');
		if (YII_DEBUG)
			$assetsUrl = Yii::app()->assetManager->publish($assetsPath, false, -1, true);
		else
			$assetsUrl = Yii::app()->assetManager->publish($assetsPath);
		Yii::app()->clientScript->registerCssFile($assetsUrl.'/build/visualsearch-datauri.css');
		Yii::app()->clientScript->registerScriptFile($assetsUrl.'/build/jquery.ui.position.js', CClientScript::POS_HEAD);
		Yii::app()->clientScript->registerScriptFile($assetsUrl.'/build/jquery.ui.widget.js', CClientScript::POS_HEAD);
		Yii::app()->clientScript->registerScriptFile($assetsUrl.'/build/underscore-1.1.5.js', CClientScript::POS_HEAD);
		Yii::app()->clientScript->registerScriptFile($assetsUrl.'/build/backbone-0.5.0.js', CClientScript::POS_HEAD);
		Yii::app()->clientScript->registerScriptFile($assetsUrl.'/build/visualsearch.js', CClientScript::POS_HEAD);
		if (!isset($this->htmlOptions['id']))
			$this->htmlOptions['id'] = $this->getId();

		Yii::app()->clientScript->registerScript('vs_init', "
$(document).ready(function() {
	var visualSearch = VS.init({
		container : $('#{$this->getId()}'),
		query     : '',
// 		callbacks : {
// 			search       : function(query, searchCollection) {},
// 			facetMatches : function(callback) {},
// 			valueMatches : function(facet, searchTerm, callback) {}
// 		}
callbacks : {

search       : function(query, searchCollection) { alert(query)},

  // These are the facets that will be autocompleted in an empty input.
  facetMatches : function(callback) {
    callback([
      'account', 'filter', 'access', 'title',
      { label: 'city',    category: 'location' },
      { label: 'address', category: 'location' },
      { label: 'country', category: 'location' },
      { label: 'state',   category: 'location' },
    ]);
  },
  // These are the values that match specific categories, autocompleted
  // in a category's input field.  searchTerm can be used to filter the
  // list on the server-side, prior to providing a list to the widget.
  valueMatches : function(facet, searchTerm, callback) {
    switch (facet) {
    case 'account':
        callback([
          { value: '1-amanda', label: 'Amanda' },
          { value: '2-aron',   label: 'Aron' },
          { value: '3-eric',   label: 'Eric' },
          { value: '4-jeremy', label: 'Jeremy' },
          { value: '5-samuel', label: 'Samuel' },
          { value: '6-scott',  label: 'Scott' }
        ]);
        break;
      case 'filter':
        callback(['published', 'unpublished', 'draft']);
        break;
      case 'access':
        callback(['public', 'private', 'protected']);
        break;
      case 'title':
        callback([
          'Pentagon Papers',
          'CoffeeScript Manual',
          'Laboratory for Object Oriented Thinking',
          'A Repository Grows in Brooklyn'
        ]);
        break;
    }
  }
}
	});
});



		",CClientScript::POS_END);
	}

	public function run()
	{
		echo CHtml::openTag('div', $this->htmlOptions);
		echo '</div>';
	}
}
?>