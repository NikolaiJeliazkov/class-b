<?php

// this contains the application parameters that can be maintained via GUI
return array(
	'PostPreviewSize' => 200,
	// this is displayed in the header section
	'appName'=>'V А клас',
	'appUrl'=>'http://a.to4ka.net',
	// this is used in error pages
	'adminEmail'=>'"V А клас" <admin@class-b.net>',
	'schoolHtml'=>'<a href="http://www.smg.bg/">Софийска математическа гимназия</a>',
	// number of posts displayed per page
	'postsPerPage'=>5,
	// maximum number of comments that can be displayed in recent posts portlet
	'recentPostsCount'=>10,
	// maximum number of tags that can be displayed in tag cloud portlet
	'tagCloudCount'=>20,
	// whether post comments need to be approved before published
	'commentNeedApproval'=>true,
	// the copyright information displayed in the footer section
	'copyrightInfo'=>'Copyright &copy; 2009 by to4ka.net',
	'analyticsScript' => "
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-54947902-1', 'auto');
  ga('send', 'pageview');
</script>
",

);
