<?php
/**
 * BootInputInline class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package bootstrap.widgets.input
 */

Yii::import('bootstrap.widgets.input.BootInputVertical');

/**
 * Bootstrap vertical form input widget.
 * @since 0.9.8
 */
class BootInputInline extends BootInputVertical
{
	/**
	 * Renders a drop down list (select).
	 * @return string the rendered content
	 */
	protected function dropDownList()
	{
		echo $this->getLabel();
		echo $this->form->dropDownList($this->model, $this->attribute, $this->data, $this->htmlOptions);
	}

	/**
	 * Renders a password field.
	 * @return string the rendered content
	 */
	protected function passwordField()
	{
		$this->htmlOptions['placeholder'] = $this->model->getAttributeLabel($this->attribute);
		echo $this->form->passwordField($this->model, $this->attribute, $this->htmlOptions);
	}

	/**
	 * Renders a textarea.
	 * @return string the rendered content
	 */
	protected function textArea()
	{
		$this->htmlOptions['placeholder'] = $this->model->getAttributeLabel($this->attribute);
		echo $this->form->textArea($this->model, $this->attribute, $this->htmlOptions);
	}

	/**
	 * Renders a text field.
	 * @return string the rendered content
	 */
	protected function textField()
	{
		$this->htmlOptions['placeholder'] = $this->model->getAttributeLabel($this->attribute);
		echo $this->form->textField($this->model, $this->attribute, $this->htmlOptions);
	}

	protected function textAutoComplete()
	{
		$this->htmlOptions['placeholder'] = $this->model->getAttributeLabel($this->attribute);
		$this->widget('CAutoComplete', array(
					'model'=>$this->model,
					'attribute'=>$this->attribute,
					'url'=>$this->data['url'],
					'multiple'=>$this->data['multiple'],
					'htmlOptions'=> $this->htmlOptions,
		));
	}

	protected function textCKEditor()
	{
		$this->htmlOptions['placeholder'] = $this->model->getAttributeLabel($this->attribute);
		$this->widget('application.extensions.editor.CKkceditor',array(
			"model"=>$this->model,                 # Data-Model
			"attribute"=>$this->attribute,         # Attribute in the Data-Model
			"config"=>$this->data['config'],
			"height"=>$this->data['height'],
			"width"=>$this->data['width'],
			"filespath"=>$this->data['filespath'],
			"filesurl"=>$this->data['filesurl'],
		));
	}

}
