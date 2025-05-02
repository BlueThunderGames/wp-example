<?php
get_header();

$searchHeading = get_field('search_page_heading', 'option');
$searchPlaceholder = get_field('search_placeholder', 'option');
?>
<section class="search-results-wrapper general-content-block">
	<div class="grid-container">
		<h2 class="text-center"><?php echo $searchHeading; ?></h2>
		<div class="search-inner">
				<div class="search-form-wrapper">
					<form action="/" method="GET" class="banner-form">
						<label for="searchPageInput"><?php echo $searchPlaceholder; ?></label>
						<input type="text" id="searchPageInput" <?php if(isset($_GET['s']) && $_GET['s'] != ''){ echo 'value="'.$_GET['s'].'"';} ?> name="s" required placeholder="<?php echo $searchPlaceholder; ?>">
						<a href="#" aria-title="Clear Search" class="clear-search">
							<svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 34 34" fill="none">
								<title>Clear Search</title>
								<rect width="34" height="34" rx="10" fill="#EFEFEF"/>
								<path d="M11.9922 22.008L22.0109 11.9922M11.9922 11.9922L22.0109 22.008" stroke="#959595" stroke-width="1.5" stroke-linecap="round"/>
							</svg>
						</a>
						<button type="submit">
							Search
						</button>
					</form>	
				</div>
			<div class="medium-12 cell">
			<?php if(isset($_GET['s']) && $_GET['s'] != ''){ $searchCounter = 0; ?>  
			<?php if ( have_posts() ) { ?>		
				<?php while ( have_posts() ) { the_post(); ?>
				<?php
					$postLink = get_the_permalink();
					$searchCounter++;
				?>
				<div class="searchResult">
					<a href="<?php echo $postLink; ?>" class="search-result-link">
						<span class="post-title"><?php relevanssi_the_title(); ?></span>
						<span class="post-excerpt"><?php the_excerpt(); ?></span>
					</a>
				</div>
				<?php } if($searchCounter == 0){echo '<h2 class="text-center">No Results Found!</h2>'; } ?>
				<?php }else{ echo '<h2 class="text-center">No Results Found!</h2>';} ?>
				<?php } ?>
			</div>
	  </div>
  </div>
</section>
<?php get_footer(); ?>