<?php 
/*$cs = Yii::app()->getClientScript();
$cs->registerCssFile(Yii::app()->request->baseUrl. '/css/vis.css');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/api.js' , CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/vis.min.js' , CClientScript::POS_END);*/
$this->pageTitle=$this::moduleTitle;
?>
<style type="text/css">
 
</style>
<!-- START PROJECT SECTION -->
<section id="project" class="section" >
	<span class="sequence-prev" ></span>
	<span class="sequence-next" ></span>
    <ul class="sequence-canvas">
    	<li class="animate-in" style="background-image: url('<?php echo Yii::app()->theme->baseUrl;?>/images/slider/1.jpg');">
        	<div class="slide-content">
            	<h1>Welcome !</h1>
            	<h3>We're #ASSOCIATION-NAME, a young Charity Association ! We build School in #COUNTRY to globalize knowledge and education... 
				(you can add here any kind of content such as description, button, images...)</h3>
        	</div>
    	</li>
    	<li style="background-color: #82b440;">
        	<div class="slide-content">
            	<h1>Our Project</h1>
            	<h3>Describe here your project in a few sentences, to explain to your visitors what you're doing and what you need their help, 
            	or maybe something else </h3>
            	<div class="progress progress-striped">
				  <div class="progress-bar progress-bar-success" style="width: 80%">
				    <span class="sr-only">Fundraising to realize our Amazing project</span>
				  </div>
				</div>
				<div class="pull-right">
					<a href="#donation" class="btn btn-default">Help us with a Donation</a>
				</div>
        	</div>
    	</li>
    	<li style="background-color: #0DB4E9;">
        	<div class="slide-content">
            	<h1>Who Is Behind</h1>
            	<div class="center">
            		<img src="<?php echo Yii::app()->theme->baseUrl;?>/images/slider/funder.jpg" class="pull-left" alt="image in slider slide">
	            	<h3>Funder Name</h3>
	            	<p>Few words about the creation, the ideas, biography of the funder...</p>
					<a href="#" class="btn btn-twitter"><span class="icon icon-twitter"></span> Twitter</a>
            	</div>
        	</div>
    	</li>
    </ul>
	<ul class="sequence-pagination">
		<li>Welcome</li>
		<li>Our Project</li>
		<li>Who is behind</li>
	</ul>
</section>
<!-- END PROJECT SECTION -->

<script type="text/javascript">

$(document).ready( function() 
{ 

</script>
