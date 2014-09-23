<?php

Yii::import('zii.widgets.CPortlet');

class RecentPosts extends CPortlet
{
	public $title='Последни статии';
	public $maxComments=10;

	public function getRecentPosts()
	{
		return Post::model()->findRecentPosts($this->maxComments);
	}

	protected function renderContent()
	{
		$this->render('recentPosts');
	}
}