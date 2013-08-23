<?
Yii::app()->user->returnUrl = $this->createUrl('/site/sitepoll');
require('locale.php');

$this->pageTitle=Yii::app()->name . ' - '. Yii::t('pages', 'sitepoll');
?>

<a name="content"></a>
<h1>
<?php echo Yii::t('pages', 'sitepoll'); ?>
</h1>
<br>
<div class="poll-results" style="margin-bottom: 300px;">
<?php
	$sp = new SitePoll();
	$data = $sp->getResults($poll);

	$subject = $sp->getPollSubject($poll);

?>
	<div class="poll-title-hero hero">
	<?php echo Yii::t('pages', 'sitepoll'.$poll.'.subject'); ?>
	</div>

	<div id="pollbox">
<?php
	while (($row = $data->read()) != false) {
		echo '<div class="poll-value" width="'.$row['hits'].'%">';
		echo Yii::t('pages', $row['title']) . '</div>';
	}
	if ($voted) {
?>
	</div><!-- pollbox -->
	<div class="poll-popup hero">
<?php
		echo Yii::t('pages', 'voted.thank');
?>
	</div>
<?php
	}
?>

</div>

<script>
$(document).ready(function(){
	window.location='#content';
	$('.poll-value').each(function(k,v) {
		var percents = $(v).attr('width');
		$(v).css('width', percents);
		$(v).append('&nbsp;' + percents);
	});
});
</script>
