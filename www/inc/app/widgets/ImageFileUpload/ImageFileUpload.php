<?php
/**
 * $Id: AttachmentFileUpload.php 1175 2014-11-22 13:00:32Z atonkin $
 */
Yii::import('booster.widgets.TbFileUpload');

class ImageFileUpload extends TbFileUpload
{

    private $_assetsUrl;

    /**
     * Wheter or not to preview image files before upload
     */
    public $previewImages = false;

    /**
     * Whether or not to add the image processing pluing
     */
    public $imageProcessing = false;

    /**
     *
     * @var string name of the form view to be rendered
     */
    public $formView = 'form';

    /**
     *
     * @var string name of the upload view to be rendered
     */
    public $uploadView = 'upload';

    /**
     *
     * @var string name of the download view to be rendered
     */
    public $downloadView = 'download';

    /**
     *
     * @var string name of the view to display images at bootstrap-slideshow
     */
    public $previewImagesView;

    /**
     * Generates the required HTML and Javascript
     */
    public function run()
    {
        list ($name, $id) = $this->resolveNameID();

        $this->options['url'] = $this->url;

        // if acceptFileTypes is not set as option, try getting it from models rules
        if (! isset($this->options['acceptFileTypes'])) {
            $fileTypes = $this->getFileValidatorProperty($this->model, $this->attribute, 'types');
            if (isset($fileTypes)) {
                $fileTypes = (preg_match(':jpg:', $fileTypes) && ! preg_match(':jpe:', $fileTypes) ? preg_replace(':jpg:', 'jpe?g', $fileTypes) : $fileTypes);
                $this->options['acceptFileTypes'] = 'js:/(\.)(' . preg_replace(':,:', '|', $fileTypes) . ')$/i';
            }
        }

        // if maxFileSize is not set as option, try getting it from models rules
        if (! isset($this->options['maxFileSize'])) {
            $fileSize = $this->getFileValidatorProperty($this->model, $this->attribute, 'maxSize');
            if (isset($fileSize)) {
                $this->options['maxFileSize'] = $fileSize;
            }
        }

        $this->render($this->uploadView);
        $this->render($this->downloadView);
        $this->render($this->formView, array('model' => $this->model));

        $this->registerClientScript($id);
    }

    /**
     * Registers and publishes required scripts
     *
     * @param string $id
     */
    public function registerClientScript($id)
    {
        $booster = Booster::getBooster();
        $booster->registerAssetCss('fileupload/jquery.fileupload-ui.css');

        // Upgrade widget factory
        // @todo remove when jquery.ui 1.9+ is fully integrated into stable Yii versions
        $booster->registerAssetJs('fileupload/vendor/jquery.ui.widget.js');
        // The Templates plugin is included to render the upload/download listings
        $booster->registerAssetJs("fileupload/tmpl.min.js", CClientScript::POS_END);

        // The Iframe Transport is required for browsers without support for XHR file uploads
        $booster->registerAssetJs('fileupload/jquery.iframe-transport.js');
        $booster->registerAssetJs('fileupload/jquery.fileupload.js');

        $this->getAssetsUrl();
        // locale
        Yii::app()->clientScript->registerScriptFile($this->_assetsUrl . '/js/jquery.fileupload-locale.js', CClientScript::POS_END);
        // The File Upload user interface plugin
        Yii::app()->clientScript->registerScriptFile($this->_assetsUrl . '/js/jquery.fileupload-ui.js', CClientScript::POS_END);

        $options = CJavaScript::encode($this->options);
        Yii::app()->clientScript->registerScript(__CLASS__ . '#' . $id, "jQuery('#{$id}').fileupload({$options});", CClientScript::POS_END);
    }

    /**
     * Check for a property of CFileValidator
     *
     * @param CModel $model
     * @param string $attribute
     * @param null $property
     *
     * @return string property's value or null
     */
    private function getFileValidatorProperty($model = null, $attribute = null, $property = null)
    {
        if (! isset($model, $attribute, $property)) {
            return null;
        }

        foreach ($model->getValidators($attribute) as $validator) {
            if ($validator instanceof CFileValidator) {
                $ret = $validator->$property;
            }
        }
        return isset($ret) ? $ret : null;
    }

    /**
     * Returns the URL to the published assets folder.
     *
     * @return string the URL
     */
    protected function getAssetsUrl()
    {
        if ($this->_assetsUrl !== null) {
            return $this->_assetsUrl;
        } else {
            $assetsPath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';

            if (YII_DEBUG)
                $assetsUrl = Yii::app()->assetManager->publish($assetsPath, false, - 1, true);
            else
                $assetsUrl = Yii::app()->assetManager->publish($assetsPath);

            return $this->_assetsUrl = $assetsUrl;
        }
    }
}