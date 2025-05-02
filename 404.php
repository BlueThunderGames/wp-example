<?php
	get_header();

	$pageCopy = get_field('404_copy', 'option');
?>
<section class="general-content-block error-page-block">
    <div class="grid-container">
        <div class="upper-copy">
			<?php echo $pageCopy; ?>
		</div>
	</div>
</section>
<section class="white-space-block double-space"></section>
<?php 
    get_footer(); 
?>