<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<script src="https://cdn.userway.org/widget.js" data-account="vtoZmzouJM"></script>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<title>
		<?php wp_title( '|', true, 'right' ); ?>
	</title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link rel="icon" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/favicon.ico" type="image/x-icon"/>
	<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/favicon.ico" type="image/x-icon"/>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <?php wp_head(); ?>
	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-TFS42G7');</script>
	<!-- End Google Tag Manager -->
</head>
<?php 
	$bannerIconHTML = '';
	$hideBanner = get_field('hide_announcement_banner', 'option');
	$bannerIcon = get_field('announcement_banner_icon', 'option');

	$bannerHeadingHTML = '';
	$bannerHeading = get_field('announcement_banner_heading', 'option');

	$bannerContentHTML = get_field('announcement_banner_copy', 'option');
	$bannerBtn = get_field('announcement_banner_button', 'option');
	$bannerBtnTarget = 'target="_self"';
	$perspectivesLink = get_field('back_button', 'option');

	if(isset($perspectivesLink) && !empty($perspectivesLink))
	{
		$perspectivesLink = $perspectivesLink['url'];
	}
	else 
	{
		$perspectivesLink = '/cit-resources/';
	}


	if(isset($bannerIcon) && !empty($bannerIcon))
	{
		$bannerIconExtension = pathinfo($bannerIcon['url'], PATHINFO_EXTENSION);

		if($bannerIconExtension == 'svg')
		{
			$bannerIconHTML = file_get_contents($bannerIcon['url']);
		}
		else
		{
			$bannerIconHTML = '<img src="'.$bannerIcon['url'].'" alt="'.$bannerIcon['alt'].'">';
		}
	}

	if(isset($bannerBtn['target']) && $bannerBtn['target'] != '')
	{
		$bannerBtnTarget = 'target="'.$bannerBtn['target'].'"';
	}

	if(isset($bannerBtn) && !empty($bannerBtn))
	{
		$bannerBtnHTML = '<a href="'.$bannerBtn['url'].'" '.$bannerBtnTarget.' class="btn btn-secondary">'.$bannerBtn['title'].'</a>';
	}

	if(isset($bannerHeading) && $bannerHeading != '')
	{
		$bannerHeadingHTML = '<h5>'.$bannerHeading.'</h5>';
	}

	$extraBodyClasses = [];

	if(!isset($_COOKIE['bannerClosed']) && (!isset($hideBanner) || $hideBanner == false))
	{
		if((isset($bannerHeading) && $bannerHeading != '') || (isset($bannerContentHTML) && $bannerContentHTML != ''))
		{
			$extraBodyClasses[] = 'announcement-banner';
		}
	}

	$searchPlaceholder = get_field('search_placeholder', 'option');


	$defaultThumbArray = [];
	$lastUsedThumbnail = '';

	if(have_rows('perspectives_thumbnails', 'option'))
    {
        while(have_rows('perspectives_thumbnails', 'option'))
        {
            the_row();

            $defaultThumbArray[] = get_sub_field('thumbnail');
        }
    }

	$featuredPosts = [];
	$featuredPostsCounter = 0;

	$featuredArgs = array(
		'post_type' => 'post',
		'posts_per_page' => 4,
		'post_status' => 'publish',
		'tax_query' => array(
			array(
				'taxonomy' => 'category',
				'field' => 'term_id',
				'terms' => 1658
			)
			),
		'meta_query' => array(
			array( 
				'key' => 'hide_on_perspectives',
				'value' => '1',
				'compare' => '!='
			)
		)
	);

	$featuredQuery = new WP_Query($featuredArgs);

	if($featuredQuery->have_posts())
	{
		while($featuredQuery->have_posts())
		{
			$featuredQuery->the_post();

			$itemID = get_the_ID();
			$itemTitle = get_the_title();
			$itemLink = get_the_permalink($itemID);
			$itemThumb = get_the_post_thumbnail_url(get_the_ID(), 'full');
			$passedThumbnail = '';

			if(isset($itemThumb) && $itemThumb != '')
			{
				$passedThumbnail = $itemThumb;
			}
			else
			{
				if (!empty($defaultThumbArray)) {
					do {
						$randomKey = array_rand($defaultThumbArray);
						$randomThumbnail = $defaultThumbArray[$randomKey];
					} while ($randomThumbnail == $lastUsedThumbnail && count($defaultThumbArray) > 1);

					$passedThumbnail = $randomThumbnail;
					// Update the last used thumbnail
					$lastUsedThumbnail = $randomThumbnail;
				}
			}

			$featuredPosts[$featuredPostsCounter] = [
				'title' => $itemTitle,
				'link' => $itemLink,
				'thumbnail' => $passedThumbnail
			];

			$featuredPostsCounter++;
		}
	}
?>
<body <?php body_class($extraBodyClasses); ?>>
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TFS42G7"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
<section class="header-container">
	<a class="skip-layout-link" href="#main-page-content">Skip to Content</a>
	<?php 
		if((isset($bannerHeading) && $bannerHeading != '') || (isset($bannerContentHTML) && $bannerContentHTML != '')){
	?>
	<?php if(!isset($_COOKIE['bannerClosed']) && (!isset($hideBanner) || $hideBanner == false)){ ?>
	<div class="banner-modal">
		<div class="banner-modal-inner">
			<div class="grid-container">
				<div class="grid-x">
					<?php if(isset($bannerIconHTML) && $bannerIconHTML != ''){ ?>
					<div class="banner-modal-icon">
						<?php echo $bannerIconHTML; ?>
					</div>
					<?php } ?>
					<div class="banner-copy-wrapper">
						<?php if(isset($bannerHeadingHTML) && $bannerHeadingHTML != ''){ ?>
							<?php echo $bannerHeadingHTML; ?>
						<?php } ?>
						<?php if(isset($bannerContentHTML) && $bannerContentHTML != ''){ ?>
							<div class="desc-container">
								<?php echo $bannerContentHTML; ?>
							</div>
						<?php } ?>
					</div>
					<?php if(isset($bannerBtnHTML) && $bannerBtnHTML != ''){ ?>
						<div class="banner-btn-wrapper">
							<?php echo $bannerBtnHTML; ?>
						</div>
					<?php } ?>
				</div>
			</div>
			<a href="#" aria-label="Close Modal" class="close-btn">
				<svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 23 23" fill="none">
					<path d="M22.6879 1.88524C22.9012 1.6699 23.0059 1.40988 22.9997 1.10514C23.0058 0.802437 22.9012 0.542404 22.6879 0.325042C22.4726 0.113765 22.2125 0.00507065 21.9078 0C21.6051 0.00507871 21.3451 0.113765 21.1277 0.325042L11.5065 9.94628L1.88524 0.325042C1.6699 0.113765 1.40988 0.00507065 1.10514 0C0.802437 0.00507871 0.542404 0.113765 0.325042 0.325042C0.113765 0.542414 0.00507065 0.802437 0 1.10514C0.00507871 1.40988 0.113765 1.66991 0.325042 1.88524L9.94628 11.5065L0.325042 21.1277C0.113765 21.3451 0.00507065 21.6051 0 21.9078C0.00507871 22.2125 0.113765 22.4726 0.325042 22.6879C0.542414 22.9012 0.802437 23.0059 1.10514 22.9997C1.40988 23.0058 1.66991 22.9012 1.88524 22.6879L11.5065 13.0667L21.1277 22.6879C21.3451 22.9012 21.6051 23.0059 21.9078 22.9997C22.2125 23.0058 22.4726 22.9012 22.6879 22.6879C22.9012 22.4726 23.0059 22.2125 22.9997 21.9078C23.0058 21.6051 22.9012 21.3451 22.6879 21.1277L13.0667 11.5065L22.6879 1.88524Z" fill="#F7F6FB"/>
				</svg>
			</a>
			<a href="#" aria-label="Minimize Modal" class="banner-minify-btn">
				<svg xmlns="http://www.w3.org/2000/svg" width="27" height="14" viewBox="0 0 27 14" fill="none">
					<path d="M26.0669 14C25.817 13.9985 25.5781 13.9026 25.4005 13.7322L13.4931 2.20466L1.58579 13.7322C1.21487 14.067 0.634905 14.0578 0.276566 13.7094C-0.083354 13.3625 -0.092785 12.801 0.252991 12.4419L12.8266 0.269322C13.0027 0.097383 13.2432 2.31551e-06 13.493 2.35919e-06C13.7429 2.40288e-06 13.9834 0.0973832 14.1594 0.269322L26.733 12.4419C26.9955 12.7051 27.0725 13.0947 26.9279 13.4325C26.7833 13.7718 26.4456 13.9939 26.0669 14Z" fill="#F7F6FB"/>
				</svg>
			</a>
		</div>
	</div>
	<?php } ?>
	<?php } ?>
	<div class="trim-menu-wrapper">
		<div class="grid-container">
			<div class="grid-x">
				<?php 
					$hideSearch = get_field('hide_search', 'option');

					if(!isset($hideSearch) || $hideSearch == false)
					{
				?>
				<div class="search-wrapper">
					<a href="#" class="search-icon" aria-label="Search this website">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
							<path d="M14.7562 15.9911L9.15936 10.3942C8.71516 10.7496 8.19989 11.0339 7.62243 11.2382C7.04497 11.4425 6.43198 11.5491 5.77457 11.5491C4.15769 11.5491 2.79845 10.9894 1.67907 9.87007C0.559689 8.75069 0 7.38257 0 5.77457C0 4.16657 0.568573 2.79845 1.68795 1.67907C2.80733 0.559689 4.16657 0 5.78345 0C7.40033 0 8.75958 0.559689 9.87896 1.67907C10.9983 2.79845 11.558 4.16657 11.558 5.77457C11.558 6.4231 11.4514 7.04497 11.2471 7.62243C11.0428 8.19989 10.7585 8.71516 10.4031 9.15936L16 14.7562L14.7562 16V15.9911ZM5.78345 9.77235C6.89395 9.77235 7.83565 9.38145 8.61743 8.60855C9.39922 7.83565 9.78123 6.88506 9.78123 5.77457C9.78123 4.66408 9.39034 3.72238 8.61743 2.94059C7.84453 2.1588 6.89395 1.77679 5.78345 1.77679C4.67296 1.77679 3.73126 2.16768 2.94947 2.94059C2.16768 3.71349 1.78567 4.66408 1.78567 5.77457C1.78567 6.88506 2.17657 7.82676 2.94947 8.60855C3.72238 9.39034 4.67296 9.77235 5.78345 9.77235Z" fill="#81D8D0"/>
						</svg>
					</a>
					<form action="/" method="GET" class="search-form">
						<label for="search" class="screen-reader-text"><?php echo $searchPlaceholder; ?></label>
						<input type="text" name="s" id="search" placeholder="<?php echo $searchPlaceholder; ?>" class="search-input">
						<button type="submit">
							<?php echo $searchPlaceholder; ?>
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
								<path d="M14.7562 15.9911L9.15936 10.3942C8.71516 10.7496 8.19989 11.0339 7.62243 11.2382C7.04497 11.4425 6.43198 11.5491 5.77457 11.5491C4.15769 11.5491 2.79845 10.9894 1.67907 9.87007C0.559689 8.75069 0 7.38257 0 5.77457C0 4.16657 0.568573 2.79845 1.68795 1.67907C2.80733 0.559689 4.16657 0 5.78345 0C7.40033 0 8.75958 0.559689 9.87896 1.67907C10.9983 2.79845 11.558 4.16657 11.558 5.77457C11.558 6.4231 11.4514 7.04497 11.2471 7.62243C11.0428 8.19989 10.7585 8.71516 10.4031 9.15936L16 14.7562L14.7562 16V15.9911ZM5.78345 9.77235C6.89395 9.77235 7.83565 9.38145 8.61743 8.60855C9.39922 7.83565 9.78123 6.88506 9.78123 5.77457C9.78123 4.66408 9.39034 3.72238 8.61743 2.94059C7.84453 2.1588 6.89395 1.77679 5.78345 1.77679C4.67296 1.77679 3.73126 2.16768 2.94947 2.94059C2.16768 3.71349 1.78567 4.66408 1.78567 5.77457C1.78567 6.88506 2.17657 7.82676 2.94947 8.60855C3.72238 9.39034 4.67296 9.77235 5.78345 9.77235Z" fill="#81D8D0"/>
							</svg>
						</button>
					</form>
				</div>
				<?php } ?>
				<ul class="trim-menu">
					<?php 
						while(have_rows('trim_menu_items', 'option'))
						{
							the_row();

							$trimLink = get_sub_field('menu_item');
							$trimTarget = 'target="_self"';

							if(isset($trimLink['target']) && $trimLink['target'] != '')
							{
								$trimTarget = 'target="'.$trimLink['target'].'"';
							}

							echo '<li><a href="'.$trimLink['url'].'" '.$trimTarget.'>'.$trimLink['title'].'</a></li>';
						}
					?>
				</ul>
			</div>
		</div>
	</div>
	<div class="lower-header">
		<div class="grid-container">
			<header>
				<div class="grid-x">
					<div class="header-logo-wrapper small-4">
						<div class="logo-light">
							<a href="/" aria-label="Home Link" class="logo logo-desktop">
								<svg xmlns="http://www.w3.org/2000/svg" width="168" height="72" viewBox="0 0 168 72" fill="none">
									<path d="M40.3577 10.7188H51.073V21.434C45.1524 21.434 40.3577 16.6357 40.3577 10.7188Z" fill="#D0D1DB"/>
									<path d="M40.3577 0.00341797C40.3577 5.92399 45.156 10.7187 51.073 10.7187V0.00341797H40.3577Z" fill="#D0D1DB"/>
									<path d="M126.091 10.7188C126.091 16.6357 121.292 21.434 115.375 21.434V10.7188H126.091Z" fill="#D0D1DB"/>
									<path d="M126.091 0.00341797H115.375V10.7187C121.292 10.7187 126.091 5.92039 126.091 0.00341797Z" fill="#D0D1DB"/>
									<path d="M29.6389 0.00341797C29.6389 5.92399 34.4372 10.7187 40.3542 10.7187V0.00341797H29.6389Z" fill="#A7A9B4"/>
									<path d="M136.806 0.00341797C136.806 5.92399 132.008 10.7187 126.091 10.7187V0.00341797H136.806Z" fill="#A7A9B4"/>
									<path d="M83.2226 10.7189L75.6438 3.14013C79.8306 -1.04671 86.6145 -1.04671 90.7977 3.14013L83.219 10.7189H83.2226Z" fill="#F7F6FB"/>
									<path d="M72.5072 10.7187C72.5072 4.80174 67.7089 0.00341797 61.7919 0.00341797H51.0767C51.0767 5.92039 55.875 10.7187 61.7919 10.7187H51.0767C51.0767 16.6393 55.875 21.434 61.7919 21.434H81.1867C76.2409 20.4628 72.5108 16.1033 72.5108 10.8734V10.7151L72.5072 10.7187Z" fill="#F7F6FB"/>
									<path d="M83.2224 21.438L90.8011 29.0167C86.6143 33.2036 79.8305 33.2036 75.6472 29.0167L83.226 21.438H83.2224Z" fill="#F7F6FB"/>
									<path d="M93.9414 10.877C93.9414 16.1069 90.2114 20.4664 85.2656 21.4376H104.66C110.577 21.4376 115.376 16.6393 115.376 10.7223H104.66C110.577 10.7187 115.376 5.92399 115.376 0.00341797H104.66C98.7398 0.00341797 93.9414 4.80174 93.9414 10.7187V10.877Z" fill="#F7F6FB"/>
									<path d="M8.3557 49.9686L10.4311 50.5045V54.677C10.0103 54.864 9.45276 55.0259 8.91682 55.0259C5.84143 55.0259 3.83794 52.767 3.83794 48.2708C3.83794 44.102 5.58605 42.1416 7.82335 42.1416C9.61822 42.1416 10.9671 43.3754 12.5533 46.3573L13.4166 46.3105L13.208 40.9043H12.4166L11.6253 41.6956C10.7153 41.2532 9.5283 40.9978 8.08233 40.9978C3.39911 40.9978 0 44.494 0 48.8967C0 53.2994 2.98186 56.5366 7.12914 56.5366C8.78373 56.5366 10.0427 56.0726 11.298 55.3244L12.9742 56.3963L13.672 56.3028V50.5009L15.2798 49.965V49.2204H8.35929V49.965L8.3557 49.9686Z" fill="#F7F6FB"/>
									<path d="M34.6133 55.4219C33.8688 55.2349 33.2861 54.9543 32.8437 54.4651C32.3077 53.8609 31.8869 53.0659 31.3509 51.6703C30.8402 50.3646 29.9517 49.4582 28.1353 49.1093V48.782C31.0955 48.2712 32.4911 46.8468 32.4911 45.0088C32.4911 42.7031 30.4625 41.3291 27.0849 41.3291H18.8372V42.0988L21.0277 42.6132V54.8932L18.8372 55.4039V56.1737H26.6893V55.4039L24.5239 54.8932V49.5805H25.0131C26.272 49.5805 26.9698 49.9546 27.5274 51.2567L28.5309 53.6091C29.369 55.519 29.9049 56.1701 31.7214 56.1701H34.6097V55.4255L34.6133 55.4219ZM25.8296 48.4331L24.5239 48.4546V42.4909C24.6858 42.4442 25.5275 42.4657 25.7577 42.4657C27.6677 42.5341 28.9482 43.3758 28.9482 45.3793C28.9482 47.3828 27.6892 48.3863 25.826 48.4331H25.8296Z" fill="#F7F6FB"/>
									<path d="M51.4793 51.4615L50.9218 51.368L49.1737 53.5585C48.4291 54.4686 47.9148 54.8642 46.5191 54.911L43.21 55.0045V49.2961H44.2818C45.5156 49.2961 45.8645 49.6451 46.4004 51.2313L46.6342 51.9075H47.2853V45.5481H46.6558L46.4004 46.2927C45.8429 47.9005 45.5156 48.2027 44.2818 48.2027H43.21V42.4727L45.6559 42.5411C47.1702 42.5879 47.6378 42.9368 48.5226 44.0338L50.1521 46.1093L50.7096 45.969L50.2887 41.3325H37.5232V42.1023L39.7137 42.613V54.893L37.5232 55.4038V56.1735H50.965L51.4793 51.4687V51.4615Z" fill="#F7F6FB"/>
									<path d="M64.245 41.1887H61.7774L56.4899 54.6772L54.6951 55.4002V56.1699H59.7739V55.4721L58.1913 54.8427L59.425 51.3464H64.5507L65.8312 54.9793L63.896 55.4685V56.1663H71.2338V55.3966L69.3922 54.7671L64.2414 41.1851L64.245 41.1887ZM59.8207 50.181L61.8494 44.3791H62.058L64.1334 50.181H59.8243H59.8207Z" fill="#F7F6FB"/>
									<path d="M82.6541 42.4224L83.4454 42.4476C84.5856 42.4943 85.0281 42.9152 86.1935 44.4762L87.8013 46.6668L88.4056 46.5517L87.6826 41.3325H74.0538L73.3308 46.5517L73.9351 46.6668L75.5429 44.4762C76.6364 42.9835 77.1508 42.4943 78.291 42.4476L79.1543 42.4224V54.8858L76.8486 55.4002V56.1699H84.9561V55.4002L82.6505 54.8858V42.4224H82.6541Z" fill="#F7F6FB"/>
									<path d="M110.843 50.5045L112.451 49.9686V49.224H105.531V49.9686L107.602 50.5045V54.677C107.182 54.864 106.624 55.0259 106.088 55.0259C103.013 55.0259 101.009 52.767 101.009 48.2708C101.009 44.102 102.757 42.1416 104.995 42.1416C106.79 42.1416 108.138 43.3754 109.725 46.3573L110.588 46.3105L110.379 40.9043H109.588L108.797 41.6956C107.887 41.2532 106.7 40.9978 105.254 40.9978C100.57 40.9978 97.1677 44.494 97.1677 48.8967C97.1677 53.2994 100.15 56.5366 104.297 56.5366C105.951 56.5366 107.21 56.0726 108.469 55.3244L110.145 56.3963L110.843 56.3028V50.5009V50.5045Z" fill="#F7F6FB"/>
									<path d="M131.785 56.1665V55.4219C131.04 55.2349 130.458 54.9543 130.015 54.4651C129.479 53.8609 129.058 53.0659 128.526 51.6703C128.012 50.3646 127.127 49.4582 125.31 49.1093V48.782C128.271 48.2712 129.666 46.8468 129.666 45.0088C129.666 42.7031 127.641 41.3291 124.26 41.3291H116.012V42.0988L118.203 42.6132V54.8932L116.012 55.4039V56.1737H123.864V55.4039L121.699 54.8932V49.5805H122.188C123.447 49.5805 124.145 49.9546 124.706 51.2567L125.71 53.6091C126.548 55.519 127.084 56.1701 128.9 56.1701H131.788L131.785 56.1665ZM123.001 48.4331L121.695 48.4546V42.4909C121.857 42.4442 122.699 42.4657 122.929 42.4657C124.839 42.5341 126.12 43.3758 126.12 45.3793C126.12 47.3828 124.861 48.3863 122.997 48.4331H123.001Z" fill="#F7F6FB"/>
									<path d="M143.529 41.1887H141.058L135.77 54.6772L133.975 55.4002V56.1699H139.054V55.4721L137.472 54.8427L138.705 51.3464H143.831L145.111 54.9793L143.176 55.4685V56.1663H150.514V55.3966L148.672 54.7671L143.525 41.1851L143.529 41.1887ZM139.101 50.181L141.126 44.3791H141.335L143.41 50.181H139.101Z" fill="#F7F6FB"/>
									<path d="M162.143 41.3252V42.0266L163.657 42.7496L160.514 48.4795L157.136 42.6093L158.884 42.0266V41.3252H151.309V42.0949L153.338 42.8179L157.74 50.1809V54.7922L155.456 55.4V56.1662H163.542V55.4L161.237 54.7922V49.6665L165.567 42.8179L167.409 42.0949V41.3252H162.143Z" fill="#F7F6FB"/>
									<path d="M32.4229 67.1547H34.2285V71.8955H35.5378V67.1547H37.3471V65.9497H32.4229V67.1547Z" fill="#F7F6FB"/>
									<path d="M45.4331 67.9282V67.9102C45.4331 67.3491 45.2532 66.8815 44.9223 66.5506C44.5303 66.1585 43.9475 65.9463 43.1886 65.9463H40.4729V71.892H41.7822V69.9893H42.8109L44.0842 71.892H45.6129L44.1598 69.7698C44.9151 69.4893 45.4331 68.885 45.4331 67.9282ZM44.1094 67.9965C44.1094 68.4965 43.7425 68.8382 43.1059 68.8382H41.7822V67.1297H43.0807C43.7173 67.1297 44.1094 67.4174 44.1094 67.9786V67.9965Z" fill="#F7F6FB"/>
									<path d="M52.5154 69.356C52.5154 70.2984 52.0299 70.784 51.2313 70.784C50.4328 70.784 49.9472 70.284 49.9472 69.3164V65.9533H48.6379V69.3488C48.6379 71.0969 49.6163 71.989 51.2098 71.989C52.8032 71.989 53.8175 71.1041 53.8175 69.3057V65.9497H52.5082V69.356H52.5154Z" fill="#F7F6FB"/>
									<path d="M59.6948 68.3383C58.6661 68.0757 58.4107 67.9462 58.4107 67.5577V67.5398C58.4107 67.252 58.6733 67.0218 59.1733 67.0218C59.6732 67.0218 60.1912 67.2412 60.72 67.6081L61.3998 66.6225C60.7955 66.137 60.0581 65.8672 59.1913 65.8672C57.9755 65.8672 57.1122 66.5794 57.1122 67.6585V67.6764C57.1122 68.8562 57.8856 69.1872 59.0833 69.4929C60.0761 69.7483 60.2811 69.9173 60.2811 70.2483V70.2662C60.2811 70.6151 59.9574 70.8274 59.4251 70.8274C58.7452 70.8274 58.1841 70.5468 57.6518 70.1044L56.8784 71.0288C57.5906 71.6655 58.5006 71.982 59.3999 71.982C60.684 71.982 61.5832 71.3202 61.5832 70.1404V70.1224C61.5832 69.0865 60.9034 68.6548 59.6984 68.3383H59.6948Z" fill="#F7F6FB"/>
									<path d="M64.2917 67.1547H66.101V71.8955H67.4067V67.1547H69.216V65.9497H64.2917V67.1547Z" fill="#F7F6FB"/>
									<path d="M79.8414 70.7913C78.8235 70.7913 78.1185 69.9424 78.1185 68.9245V68.9065C78.1185 67.8886 78.8415 67.0541 79.8414 67.0541C80.4349 67.0541 80.9025 67.3095 81.3629 67.7267L82.1938 66.7663C81.6435 66.2232 80.9709 65.8491 79.8486 65.8491C78.0214 65.8491 76.748 67.2339 76.748 68.9245V68.9425C76.748 70.651 78.0465 71.9999 79.7983 71.9999C80.9457 71.9999 81.6255 71.5934 82.237 70.9388L81.4061 70.0971C80.9385 70.5215 80.5212 70.7949 79.845 70.7949L79.8414 70.7913Z" fill="#F7F6FB"/>
									<path d="M88.1394 65.8491C86.3049 65.8491 84.9705 67.2339 84.9705 68.9245V68.9425C84.9705 70.6331 86.2869 71.9999 88.1214 71.9999C89.9558 71.9999 91.2903 70.6151 91.2903 68.9245V68.9065C91.2903 67.216 89.9738 65.8491 88.1394 65.8491ZM89.9234 68.9389C89.9234 69.9568 89.1933 70.7913 88.1394 70.7913C87.0855 70.7913 86.3373 69.9424 86.3373 68.9245V68.9065C86.3373 67.8886 87.0675 67.0541 88.1214 67.0541C89.1753 67.0541 89.9234 67.903 89.9234 68.9209V68.9389Z" fill="#F7F6FB"/>
									<path d="M97.5528 68.464L95.9881 65.9497H94.5781V71.8955H95.8622V68.0395L97.5168 70.5538H97.5528L99.2254 68.0144V71.8955H100.524V65.9497H99.1139L97.5528 68.464Z" fill="#F7F6FB"/>
									<path d="M106.506 65.9497H104.078V71.8955H105.387V70.1114H106.38C107.714 70.1114 108.782 69.3992 108.782 68.0215V68.0036C108.782 66.7878 107.926 65.9497 106.506 65.9497ZM107.455 68.0467C107.455 68.5575 107.074 68.946 106.419 68.946H105.383V67.1295H106.394C107.049 67.1295 107.455 67.4424 107.455 68.0287V68.0467Z" fill="#F7F6FB"/>
									<path d="M113.314 65.9067L110.768 71.8956H112.102L112.645 70.5612H115.16L115.703 71.8956H117.07L114.523 65.9067H113.318H113.314ZM113.113 69.4066L113.904 67.4786L114.696 69.4066H113.117H113.113Z" fill="#F7F6FB"/>
									<path d="M124.102 69.6114L121.318 65.9497H120.113V71.8955H121.404V68.1151L124.282 71.8955H125.393V65.9497H124.102V69.6114Z" fill="#F7F6FB"/>
									<path d="M131.281 68.3381L129.86 65.9497H128.332L130.619 69.5502V71.8955H131.925V69.5251L134.209 65.9497H132.724L131.281 68.3381Z" fill="#F7F6FB"/>
								</svg>
							</a>
							<a href="/" aria-label="Home Link" class="logo logo-sticky"></a>
							<a href="/" aria-label="Home Link" class="logo logo-mobile">
								<svg xmlns="http://www.w3.org/2000/svg" width="213" height="24" viewBox="0 0 213 24" fill="none">
									<g clip-path="url(#clip0_809_9316)">
										<path d="M8.00195 7.99902H16.0039V15.9981C11.5826 15.9981 8.00195 12.4161 8.00195 7.99902Z" fill="#D0D1DB"/>
										<path d="M8.00195 0C8.00195 4.41978 11.5852 7.99911 16.0039 7.99911V0H8.00195Z" fill="#D0D1DB"/>
										<path d="M72.0283 7.99902C72.0283 12.4161 68.445 15.9981 64.0264 15.9981V7.99902H72.0283Z" fill="#D0D1DB"/>
										<path d="M72.0283 0H64.0264V7.99911C68.445 7.99911 72.0283 4.4171 72.0283 0Z" fill="#D0D1DB"/>
										<path d="M0 0C0 4.41978 3.58329 7.99911 8.00196 7.99911V0H0Z" fill="#A7A9B4"/>
										<path d="M80.0303 0C80.0303 4.41978 76.447 7.99911 72.0283 7.99911V0H80.0303Z" fill="#A7A9B4"/>
										<path d="M40.0151 7.99935L34.3555 2.34171C37.4821 -0.783824 42.5481 -0.783824 45.6721 2.34171L40.0124 7.99935H40.0151Z" fill="#F7F6FB"/>
										<path d="M32.0132 7.99911C32.0132 3.58201 28.4299 0 24.0112 0H16.0093C16.0093 4.4171 19.5926 7.99911 24.0112 7.99911H16.0093C16.0093 12.4189 19.5926 15.9982 24.0112 15.9982H38.4948C34.8014 15.2732 32.0159 12.0188 32.0159 8.11457V7.99642L32.0132 7.99911Z" fill="#F7F6FB"/>
										<path d="M40.0154 16.001L45.675 21.6586C42.5484 24.7842 37.4824 24.7842 34.3584 21.6586L40.0181 16.001H40.0154Z" fill="#F7F6FB"/>
										<path d="M48.0199 8.11725C48.0199 12.0215 45.2344 15.2759 41.541 16.0009H56.0246C60.4433 16.0009 64.0266 12.4189 64.0266 8.00179H56.0246C60.4406 7.9991 64.0239 4.41978 64.0239 0H56.0219C51.6032 0 48.0199 3.58201 48.0199 7.99911V8.11725Z" fill="#F7F6FB"/>
										<path d="M94.0226 6.76661L95.5725 7.1667V10.2815C95.2582 10.4211 94.8418 10.542 94.4416 10.542C92.145 10.542 90.6488 8.85567 90.6488 5.49922C90.6488 2.38711 91.9543 0.923697 93.625 0.923697C94.9654 0.923697 95.9727 1.84471 97.1573 4.07071L97.802 4.0358L97.6462 0H97.0552L96.4643 0.590736C95.7847 0.260461 94.8983 0.0698143 93.8184 0.0698143C90.3211 0.0698143 87.7827 2.67979 87.7827 5.96644C87.7827 9.25308 90.0095 11.6697 93.1066 11.6697C94.3422 11.6697 95.2824 11.3233 96.2198 10.7648L97.4716 11.565L97.9927 11.4952V7.16402L99.1934 6.76393V6.2081H94.0253V6.76393L94.0226 6.76661Z" fill="#F7F6FB"/>
										<path d="M113.631 10.8344C113.075 10.6948 112.64 10.4854 112.309 10.1202C111.909 9.66908 111.595 9.07566 111.195 8.03381C110.813 7.0591 110.15 6.38244 108.793 6.12198V5.87763C111.004 5.49633 112.046 4.43301 112.046 3.06089C112.046 1.3397 110.531 0.313965 108.009 0.313965H101.85V0.88859L103.485 1.27257V10.4397L101.85 10.821V11.3956H107.713V10.821L106.096 10.4397V6.47373H106.462C107.402 6.47373 107.923 6.75299 108.339 7.72502L109.089 9.48112C109.715 10.9069 110.115 11.393 111.471 11.393H113.628V10.8371L113.631 10.8344ZM107.071 5.61716L106.096 5.63328V1.18127C106.217 1.14637 106.846 1.16248 107.018 1.16248C108.444 1.21349 109.4 1.84182 109.4 3.33746C109.4 4.8331 108.46 5.58226 107.069 5.61716H107.071Z" fill="#F7F6FB"/>
										<path d="M126.226 7.87807L125.81 7.80826L124.505 9.44353C123.949 10.1229 123.564 10.4182 122.522 10.4531L120.051 10.523V6.2616H120.851C121.773 6.2616 122.033 6.52207 122.434 7.70622L122.608 8.21103H123.094V3.46098H122.624L122.434 4.01681C122.017 5.21708 121.773 5.44263 120.851 5.44263H120.051V1.16516L121.878 1.21618C123.008 1.25109 123.358 1.51155 124.018 2.33052L125.235 3.87986L125.652 3.77514L125.337 0.313965H115.804V0.88859L117.44 1.26988V10.437L115.804 10.8183V11.393H125.842L126.226 7.88076V7.87807Z" fill="#F7F6FB"/>
										<path d="M135.762 0.209473H133.919L129.971 10.2788L128.63 10.8186V11.3932H132.423V10.8723L131.241 10.4024L132.163 7.79238H135.99L136.947 10.5044L135.501 10.8696V11.3905H140.981V10.8159L139.606 10.346L135.762 0.209473ZM132.455 6.92238L133.97 2.59121H134.126L135.676 6.92238H132.458H132.455Z" fill="#F7F6FB"/>
										<path d="M149.507 1.1305L150.098 1.1493C150.949 1.1842 151.28 1.49837 152.15 2.66373L153.351 4.29899L153.802 4.21307L153.262 0.316895H143.084L142.544 4.21307L142.996 4.29899L144.196 2.66373C145.013 1.54938 145.397 1.1842 146.249 1.1493L146.893 1.1305V10.4346L145.171 10.8186V11.3932H151.226V10.8186L149.504 10.4346V1.1305H149.507Z" fill="#F7F6FB"/>
										<path d="M170.558 7.1667L171.759 6.76661V6.21079H166.59V6.76661L168.138 7.1667V10.2815C167.823 10.4211 167.407 10.542 167.007 10.542C164.71 10.542 163.214 8.85567 163.214 5.49922C163.214 2.38711 164.519 0.923697 166.19 0.923697C167.531 0.923697 168.538 1.84471 169.722 4.07071L170.367 4.0358L170.211 0H169.62L169.029 0.590736C168.35 0.260461 167.463 0.0698143 166.384 0.0698143C162.886 0.0698143 160.345 2.67979 160.345 5.96644C160.345 9.25308 162.572 11.6697 165.669 11.6697C166.905 11.6697 167.845 11.3233 168.785 10.7648L170.037 11.565L170.558 11.4952V7.16402V7.1667Z" fill="#F7F6FB"/>
										<path d="M186.2 11.3932V10.8374C185.644 10.6977 185.208 10.4883 184.878 10.1231C184.478 9.67201 184.163 9.07859 183.766 8.03674C183.382 7.06203 182.721 6.38537 181.365 6.12491V5.88056C183.575 5.49926 184.617 4.43594 184.617 3.06382C184.617 1.34263 183.105 0.316895 180.58 0.316895H174.421V0.89152L176.057 1.2755V10.4426L174.421 10.8239V11.3986H180.285V10.8239L178.668 10.4426V6.47666H179.033C179.973 6.47666 180.494 6.75592 180.913 7.72795L181.663 9.48405C182.289 10.9099 182.689 11.3959 184.045 11.3959H186.202L186.2 11.3932ZM179.64 5.61741L178.665 5.63352V1.18152C178.786 1.14661 179.414 1.16272 179.586 1.16272C181.013 1.21374 181.969 1.84207 181.969 3.3377C181.969 4.83334 181.029 5.5825 179.637 5.61741H179.64Z" fill="#F7F6FB"/>
										<path d="M194.967 0.209228H193.121L189.173 10.2786L187.833 10.8183V11.3929H191.625V10.872L190.443 10.4021L191.365 7.79213H195.192L196.149 10.5041L194.704 10.8693V11.3903H200.183V10.8156L198.808 10.3457L194.964 0.206543L194.967 0.209228ZM191.66 6.92214L193.173 2.59097H193.328L194.878 6.92214H191.66Z" fill="#F7F6FB"/>
										<path d="M208.868 0.313965V0.834887L210.001 1.3746L207.651 5.65207L205.129 1.26988L206.434 0.834887V0.313965H200.78V0.885905L202.292 1.42562L205.58 6.92216V10.3645L203.877 10.8183V11.393H209.913V10.8183L208.191 10.3645V6.53818L211.428 1.42562L212.8 0.885905V0.313965H208.868Z" fill="#F7F6FB"/>
										<path d="M87.7773 20.3859H89.1285V23.9249H90.1062V20.3859H91.4573V19.4863H87.7773V20.3859Z" fill="#F7F6FB"/>
										<path d="M97.4957 20.9629V20.9495C97.4957 20.5306 97.3614 20.1815 97.1142 19.9345C96.8214 19.6418 96.3863 19.4834 95.8195 19.4834H93.7915V23.922H94.7692V22.5015H95.5375L96.4884 23.922H97.63L96.5448 22.3377C97.1089 22.1283 97.4957 21.6772 97.4957 20.9629ZM96.5045 21.0139C96.5045 21.3872 96.2305 21.6423 95.7551 21.6423H94.7666V20.3668H95.7363C96.2117 20.3668 96.5045 20.5816 96.5045 21.0005V21.0139Z" fill="#F7F6FB"/>
										<path d="M102.784 22.0292C102.784 22.7327 102.422 23.0952 101.825 23.0952C101.229 23.0952 100.866 22.722 100.866 21.9996V19.489H99.8887V22.0238C99.8887 23.3288 100.619 23.9947 101.809 23.9947C102.999 23.9947 103.757 23.3342 103.757 21.9916V19.4863H102.779V22.0292H102.784Z" fill="#F7F6FB"/>
										<path d="M108.143 21.269C107.375 21.073 107.184 20.9763 107.184 20.6863V20.6729C107.184 20.4581 107.38 20.2863 107.754 20.2863C108.127 20.2863 108.514 20.4501 108.909 20.7239L109.416 19.9882C108.965 19.6257 108.415 19.4243 107.767 19.4243C106.859 19.4243 106.215 19.956 106.215 20.7615V20.775C106.215 21.6557 106.792 21.9027 107.687 22.131C108.428 22.3216 108.581 22.4478 108.581 22.6948V22.7083C108.581 22.9687 108.339 23.1272 107.942 23.1272C107.434 23.1272 107.015 22.9177 106.618 22.5874L106.04 23.2775C106.572 23.7528 107.251 23.9891 107.923 23.9891C108.882 23.9891 109.553 23.495 109.553 22.6143V22.6009C109.553 21.8275 109.046 21.5053 108.146 21.269H108.143Z" fill="#F7F6FB"/>
										<path d="M111.576 20.3859H112.927V23.9249H113.905V20.3859H115.256V19.4863H111.576V20.3859Z" fill="#F7F6FB"/>
										<path d="M123.191 23.1005C122.431 23.1005 121.904 22.4668 121.904 21.7069V21.6935C121.904 20.9336 122.444 20.3107 123.191 20.3107C123.634 20.3107 123.983 20.5013 124.327 20.8128L124.948 20.0958C124.537 19.6904 124.034 19.4111 123.196 19.4111C121.832 19.4111 120.881 20.4449 120.881 21.7069V21.7204C120.881 22.9958 121.851 24.0028 123.159 24.0028C124.016 24.0028 124.523 23.6993 124.98 23.2106L124.359 22.5823C124.01 22.8992 123.699 23.1032 123.194 23.1032L123.191 23.1005Z" fill="#F7F6FB"/>
										<path d="M129.388 19.4111C128.018 19.4111 127.021 20.4449 127.021 21.7069V21.7204C127.021 22.9824 128.005 24.0028 129.375 24.0028C130.744 24.0028 131.741 22.969 131.741 21.7069V21.6935C131.741 20.4315 130.758 19.4111 129.388 19.4111ZM130.72 21.7177C130.72 22.4776 130.175 23.1005 129.388 23.1005C128.601 23.1005 128.042 22.4668 128.042 21.7069V21.6935C128.042 20.9336 128.587 20.3107 129.375 20.3107C130.162 20.3107 130.72 20.9444 130.72 21.7043V21.7177Z" fill="#F7F6FB"/>
										<path d="M136.415 21.3633L135.249 19.4863H134.196V23.9249H135.152V21.0464L136.39 22.9233H136.415L137.664 21.0276V23.9249H138.636V19.4863H137.583L136.415 21.3633Z" fill="#F7F6FB"/>
										<path d="M143.101 19.4863H141.288V23.9249H142.265V22.5931H143.007C144.003 22.5931 144.801 22.0614 144.801 21.033V21.0196C144.801 20.112 144.162 19.4863 143.101 19.4863ZM143.813 21.0518C143.813 21.4331 143.528 21.7231 143.039 21.7231H142.265V20.3671H143.02C143.509 20.3671 143.813 20.6007 143.813 21.0384V21.0518Z" fill="#F7F6FB"/>
										<path d="M148.188 19.4541L146.286 23.9249H147.283L147.688 22.9287H149.566L149.972 23.9249H150.992L149.09 19.4541H148.191H148.188ZM148.035 22.0668L148.626 20.6275L149.217 22.0668H148.037H148.035Z" fill="#F7F6FB"/>
										<path d="M156.244 22.2198L154.165 19.4863H153.262V23.9249H154.227V21.1028L156.378 23.9249H157.208V19.4863H156.244V22.2198Z" fill="#F7F6FB"/>
										<path d="M161.602 21.2693L160.544 19.4863H159.402L161.108 22.1742V23.9249H162.086V22.1554L163.791 19.4863H162.682L161.602 21.2693Z" fill="#F7F6FB"/>
									</g>
									<defs>
										<clipPath id="clip0_809_9316">
										<rect width="212.8" height="24" fill="white"/>
										</clipPath>
									</defs>
								</svg>
							</a>
						</div>
					</div>
					<div class="header-menu-wrapper small-8">
						<div class="grid-x">
							<div class="menu-wrapper">
								<?php if(have_rows('menu_items', 'option')){ ?>
								<ul class="header-menu">
									<?php 
										while(have_rows('menu_items', 'option'))
										{
											the_row();

											$parentLink = get_sub_field('parent_item');
											$parentTarget = 'target="_self"';
											$parentClass = 'no-children';
											$dropdownType = get_sub_field('dropdown_type');
											$dropdownContent = get_sub_field('dropdown_content');
											$menuCats = get_sub_field('menu_categories');
											$menuTags = get_sub_field('menu_tags');
											
											if(isset($parentLink['target']) && $parentLink['target'] != '')
											{
												$parentTarget = 'target="'.$parentLink['target'].'"';
											}

											if(have_rows('child_links') || $dropdownType == 'Perspectives')
											{
												$parentClass = 'has-children';
											}

											$accessibleHTML = '';

											if($parentClass == 'has-children')
											{
												$accessibleHTML = '
												<button aria-expanded="false" aria-label="Show '.$parentLink['title'].' Child Menu" class="keyboard-toggle"></button>';
											}

											echo '<li class="'.$parentClass.'"><a href="'.$parentLink['url'].'" '.$parentTarget.'>'.$parentLink['title'].'</a>'.$accessibleHTML.'';

											if(have_rows('child_links') || $dropdownType == 'Perspectives')
											{
													echo '<ul class="sub-menu visible">';
													echo '<li class="menu-outer"><ul class="inner-menu">';

													if($dropdownType == 'Content')
													{
														echo '<li class="inner-menu-wrapper">';

															echo '<ul class="child-menu">';

															while(have_rows('child_links'))
															{
																the_row();

																$childLink = get_sub_field('child_link');
																$childTarget = 'target="_self"';

																if(isset($childLink['target']) && $childLink['target'] != '')
																{
																	$childTarget = 'target="'.$childLink['target'].'"';
																}

																echo '<li><a href="'.$childLink['url'].'" '.$childTarget.'>'.$childLink['title'].'</a></li>';
															}

															echo '</ul>';
														
														echo '</li>';

														echo '<li class="menu-card-wrapper">
															<span class="content-card content-only">'.$dropdownContent.'</span>';
														echo '</li>';
													}

													if($dropdownType == 'Perspectives')
													{
														$catsHTML = '';
														$tagsHTML = '';

														if(isset($menuCats) && !empty($menuCats))
														{
															foreach($menuCats as $cat)
															{
																$catLink = get_term_link($cat);

																$catsHTML .= '<a href="'.$perspectivesLink.'?cat='.$cat->term_id.'">'.$cat->name.'</a>';
															}
														}

														if(isset($menuTags) && !empty($menuTags))
														{
															foreach($menuTags as $tag)
															{
																$tagLink = get_term_link($tag);

																$tagsHTML .= '<a href="'.$perspectivesLink.'?tag='.$tag->term_id.'">'.$tag->name.'</a>';
															}
														}

														echo '<li class="inner-menu-wrapper perspectives-menu-wrapper">';
															echo '<ul class="child-menu">';
																echo '<li><a href="'.$parentLink['url'].'" '.$parentTarget.'>See All Perspectives</a></li>';
																echo '<li class="cats-wrapper">'.$catsHTML.'</li>';
																echo '<li class="tags-wrapper">'.$tagsHTML.'</li>';
															echo '</ul>';
														echo '</li>';

														if(!empty($featuredPosts))
														{
															echo '<li class="menu-card-wrapper perspectives-card-wrapper">';
																echo '<span class="perspectives-title">Featured <strong>Perspectives</strong></span>';
																echo '<span class="swiper-buttons">
																<span class="swiper-button-prev">
																	<svg xmlns="http://www.w3.org/2000/svg" width="104" height="104" viewBox="0 0 104 104" fill="none"> <g filter="url(#filter0_d_1367_5079)"> <circle cx="22" cy="22" r="22" transform="matrix(-1 0 0 1 70 26)" fill="#D0D1DB"/> </g> <path d="M42.893 48.7071C42.5025 48.3166 42.5025 47.6834 42.893 47.2929L49.257 40.9289C49.6475 40.5384 50.2806 40.5384 50.6712 40.9289C51.0617 41.3195 51.0617 41.9526 50.6712 42.3431L45.0143 48L50.6712 53.6569C51.0617 54.0474 51.0617 54.6805 50.6712 55.0711C50.2806 55.4616 49.6475 55.4616 49.257 55.0711L42.893 48.7071ZM52.4001 47C52.9524 47 53.4001 47.4477 53.4001 48C53.4001 48.5523 52.9524 49 52.4001 49L52.4001 47ZM43.6001 47L52.4001 47L52.4001 49L43.6001 49L43.6001 47Z" fill="#2F3942"/> <defs> <filter id="filter0_d_1367_5079" x="0" y="0" width="104" height="104" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"> <feFlood flood-opacity="0" result="BackgroundImageFix"/> <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/> <feOffset dx="4" dy="4"/> <feGaussianBlur stdDeviation="15"/> <feComposite in2="hardAlpha" operator="out"/> <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/> <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1367_5079"/> <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1367_5079" result="shape"/> </filter> </defs> </svg>
																</span>
																<span class="swiper-button-next">
																	<svg xmlns="http://www.w3.org/2000/svg" width="104" height="104" viewBox="0 0 104 104" fill="none"> <g filter="url(#filter0_d_1367_5080)"> <circle cx="22" cy="22" r="22" transform="matrix(1 1.74846e-07 1.74846e-07 -1 26 70)" fill="#D0D1DB"/> </g> <path d="M53.107 47.2929C53.4975 47.6834 53.4975 48.3166 53.107 48.7071L46.743 55.0711C46.3525 55.4616 45.7194 55.4616 45.3288 55.0711C44.9383 54.6805 44.9383 54.0474 45.3288 53.6569L50.9857 48L45.3288 42.3431C44.9383 41.9526 44.9383 41.3195 45.3288 40.9289C45.7194 40.5384 46.3525 40.5384 46.743 40.9289L53.107 47.2929ZM43.5999 49C43.0476 49 42.5999 48.5523 42.5999 48C42.5999 47.4477 43.0476 47 43.5999 47L43.5999 49ZM52.3999 49L43.5999 49L43.5999 47L52.3999 47L52.3999 49Z" fill="#2F3942"/> <defs> <filter id="filter0_d_1367_5080" x="0" y="0" width="104" height="104" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"> <feFlood flood-opacity="0" result="BackgroundImageFix"/> <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/> <feOffset dx="4" dy="4"/> <feGaussianBlur stdDeviation="15"/> <feComposite in2="hardAlpha" operator="out"/> <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/> <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1367_5080"/> <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1367_5080" result="shape"/> </filter> </defs> </svg>
																</span>
																</span>';
																echo '<ul class="featured-wrapper swiper">';
															 	echo '<li class="swiper-wrapper">';

																foreach($featuredPosts as $post)
																{
																	$postTitle = trimStringToFullWord(25, $post['title']);

																	echo '
																	<span class="slide swiper-slide">
																		<a href="'.$post['link'].'" class="slide-link">
																			<span class="slide-img" style="background-image:url('.$post['thumbnail'].');"></span>
																			<span class="slide-title">'.$postTitle.'</span>
																		</a>
																	</span>';
																}

																echo '</li>';


																echo '</ul>';
															echo '</li>';
														}
												}
												


												echo '</ul>';
												echo '</ul></li>';
											}

											echo '</li>';
										}
									?>
								</ul>
								<?php } ?>
							</div>
							<?php 
								$menuClass = 'single-col';
								$mainMenu = get_field('main_menu', 'option');
								$menuType = get_field('menu_type', 'option');

								if($menuType == 'Multi-Column')
								{
									$menuClass = 'multi-col';
								}
								elseif($menuType == 'Multi-Column Staggered Children')
								{
									$menuClass = 'multi-col staggered';
								}

								if(have_rows('main_menu', 'option')){
							?>
							<div class="menu-wrapper">
								<ul class="header-menu <?php echo $menuClass; ?>">
									<?php 
										while(have_rows('main_menu', 'option'))
										{
											the_row();
											
											$link = get_sub_field('link');
											$linkTarget = 'target="_self"';
											$parentClass = 'no-children';
											$hasChildren = false;
											$hasGrandChildren = false;
											$subMenuClass = '';
											$displayFeatured = false;

											$featuredPost = get_sub_field('featured_post');
											$featuredItemLink = get_sub_field('featured_item_link');
											$featuredItemImg = get_sub_field('featured_item_image');
											$featuredLinkTarget = 'target="_self"';
											$featuredItemTitle = get_sub_field('featured_item_title');
											$featuredItemStyle = '';

											if(isset($featuredItemLink['target']) && $featuredItemLink['target'] != '')
											{
												$featuredLinkTarget = 'target="'.$featuredItemLink['target'].'"';
											}

											if(isset($featuredPost) && $featuredPost != '')
											{
												$subMenuClass = 'featured-item';

												$displayFeatured = true;

												$featuredItemLink = get_the_permalink($featuredPost);
												$featuredItemTitle = get_the_title($featuredPost);
												$featuredItemImg = get_the_post_thumbnail_url($featuredPost, 'full');

												if(isset($featuredItemImg) && $featuredItemImg != '')
												{
													$featuredItemStyle = 'style="background-image:url('.$featuredItemImg.');"';
												}
											}
											elseif(isset($featuredItemLink) && $featuredItemLink != '')
											{
												$subMenuClass = 'featured-item';

												$displayFeatured = true;

												$featuredItemLink = $featuredItemLink['url'];

												if(isset($featuredItemImg) && $featuredItemImg != '')
												{
													$featuredItemStyle = 'style="background-image:url('.$featuredItemImg.');"';
												}
											}

											if(isset($link['target']) && $link['target'] != '')
											{
												$linkTarget = 'target="'.$link['target'].'"';
											}

											if(have_rows('child_links'))
											{
												$parentClass = 'has-children';
												$hasChildren = true;
											}

											echo '<li class="'.$parentClass.'">';

											echo '<a href="'.$link['url'].'" '.$linkTarget.'>'.$link['title'].'</a>';

											if($hasChildren)
											{
												echo '<button aria-expanded="false" aria-label="Toggle Submenu" class="keyboard-toggle"></button>';
											}

											if(have_rows('child_links')) 
											{
												echo '<ul class="sub-menu '.$subMenuClass.'">';

												if($menuType == 'Multi-Column')
												{
													echo '
														<li class="inner-menu-wrapper">
															<ul class="inner-menu">
													';

													if($displayFeatured)
													{
														echo '
															<li class="featured-item">
																<a href="'.$featuredItemLink.'" '.$featuredLinkTarget.'>
																	<span class="featured-item-img" '.$featuredItemStyle.'>
																		<span class="read-more">
																			<span class="read-more-label">Read More</span>
																			<span class="read-more-arrow">
																				<svg xmlns="http://www.w3.org/2000/svg" width="16" height="13" viewBox="0 0 16 13" fill="none">
																					<path d="M8.26454 12.4389L8.87925 13L16 6.5L8.87925 0L8.26454 0.561121L14.3294 6.0989H0V6.90142H14.3294L8.26454 12.4389Z" fill="white"/>
																				</svg>
																			</span>
																			<span class="bg"></span>
																		</span>
																	</span>
																	<span class="featured-item-title">'.$featuredItemTitle.'</span>
																</a>
															</li>
														';
													}
												}
												elseif($menuType == 'Multi-Column Staggered Children')
												{
													echo '
														<li class="inner-menu-wrapper">
															<ul class="inner-menu">
													';
												}

												if($menuType == 'Multi-Column' || $menuType == 'Single Stack') 
												{
													while(have_rows('child_links'))
													{
														the_row();

														$childLink = get_sub_field('child_link');
														$childTarget = 'target="_self"';
														$childClass = 'no-children';

														if(isset($childLink['target']) && $childLink['target'] != '')
														{
															$childTarget = 'target="'.$childLink['target'].'"';
														}

														if(have_rows('grandchild_links'))
														{
															$childClass = 'has-children';
															$hasGrandChildren = true;
														}

														echo '<li class="'.$childClass.'">';
														echo '<a href="'.$childLink['url'].'" '.$childTarget.'>
														'.$childLink['title'].'
														<span class="arrow-icon">
															'.$iconHTML.'
														</span>
														</a>';

														if(have_rows('grandchild_links'))
														{
															if($menuType != 'Multi-Column')
															{
																echo '<button aria-expanded="false" aria-label="Toggle Submenu" class="keyboard-toggle"></button>';
															}
															
															echo '<ul class="sub-menu">';

															while(have_rows('grandchild_links'))
															{
																the_row();

																$grandchildLink = get_sub_field('grandchild_link');
																$grandchildTarget = 'target="_self"';

																if(isset($grandchildLink['target']) && $grandchildLink['target'] != '')
																{
																	$grandchildTarget = 'target="'.$grandchildLink['target'].'"';
																}

																echo '<li>';
																echo '<a href="'.$grandchildLink['url'].'" '.$grandchildTarget.'>
																'.$grandchildLink['title'].'
																<span class="arrow-icon">
																	'.$iconHTML.'
																</span>
																</a>';
																echo '</li>';
															}

															echo '</ul>';
														}
													}
												}
												else 
												{
													echo '<li class="left-menu-items"><ul class="left-menu">';

													$rightMenuClass = 'no-items';

													while(have_rows('child_links'))
													{
														the_row();

														$childLink = get_sub_field('child_link');
														$childTarget = 'target="_self"';
														$childClass = 'no-children';
														$linkSide = get_sub_field('link_side');

														if($linkSide == 'Left')
														{
															if(isset($childLink['target']) && $childLink['target'] != '')
															{
																$childTarget = 'target="'.$childLink['target'].'"';
															}

															if(have_rows('grandchild_links'))
															{
																$childClass = 'has-children';
																$hasGrandChildren = true;
															}

															echo '<li class="'.$childClass.'">';
															echo '<a href="'.$childLink['url'].'" '.$childTarget.'>
															'.$childLink['title'].'
															<span class="arrow-icon">
																'.$iconHTML.'
															</span>
															</a>';

															if(have_rows('grandchild_links'))
															{
																if($menuType != 'Multi-Column')
																{
																	echo '<button aria-expanded="false" aria-label="Toggle Submenu" class="keyboard-toggle"></button>';
																}
																
																echo '<ul class="sub-menu">';

																while(have_rows('grandchild_links'))
																{
																	the_row();

																	$grandchildLink = get_sub_field('grandchild_link');
																	$grandchildTarget = 'target="_self"';

																	if(isset($grandchildLink['target']) && $grandchildLink['target'] != '')
																	{
																		$grandchildTarget = 'target="'.$grandchildLink['target'].'"';
																	}

																	echo '<li>';
																	echo '<a href="'.$grandchildLink['url'].'" '.$grandchildTarget.'>
																	'.$grandchildLink['title'].'
																	<span class="arrow-icon">
																		'.$iconHTML.'
																	</span>
																	</a>';
																	echo '</li>';
																}

																echo '</ul>';
															}
														}

														if($linkSide == 'Right')
														{
															$rightMenuClass = 'has-items';
														}
													}

													echo '</ul></li>';

													echo '<li class="right-menu-items '.$rightMenuClass.'"><ul class="right-menu">';

													while(have_rows('child_links'))
													{
														the_row();

														$childLink = get_sub_field('child_link');
														$childTarget = 'target="_self"';
														$childClass = 'no-children';
														$linkSide = get_sub_field('link_side');

														if($linkSide == 'Right')
														{
															if(isset($childLink['target']) && $childLink['target'] != '')
															{
																$childTarget = 'target="'.$childLink['target'].'"';
															}

															if(have_rows('grandchild_links'))
															{
																$childClass = 'has-children';
																$hasGrandChildren = true;
															}

															echo '<li class="'.$childClass.'">';
															echo '<a href="'.$childLink['url'].'" '.$childTarget.'>
															'.$childLink['title'].'
															<span class="arrow-icon">
																'.$iconHTML.'
															</span>
															</a>';

															if(have_rows('grandchild_links'))
															{
																if($menuType != 'Multi-Column')
																{
																	echo '<button aria-expanded="false" aria-label="Toggle Submenu" class="keyboard-toggle"></button>';
																}
																
																echo '<ul class="sub-menu">';

																while(have_rows('grandchild_links'))
																{
																	the_row();

																	$grandchildLink = get_sub_field('grandchild_link');
																	$grandchildTarget = 'target="_self"';

																	if(isset($grandchildLink['target']) && $grandchildLink['target'] != '')
																	{
																		$grandchildTarget = 'target="'.$grandchildLink['target'].'"';
																	}

																	echo '<li>';
																	echo '<a href="'.$grandchildLink['url'].'" '.$grandchildTarget.'>
																	'.$grandchildLink['title'].'
																	<span class="arrow-icon">
																		'.$iconHTML.'
																	</span>
																	</a>';
																	echo '</li>';
																}

																echo '</ul>';
															}
														}
													}

													echo '</ul></li>';
												}
												

												echo '</li>';

												if($menuType == 'Multi-Column' || $menuType == 'Multi-Column Staggered Children')
												{
													echo '</ul></li>';
												}

												echo '</ul>';
											}

											echo '</li>';
										}
									?>
								</ul>
							</div>
							<?php } ?>
							<div class="mobile-tab-wrapper">
								<a href="#" class="nav-tab" aria-label="Trigger Mobile Navigation">
									<svg xmlns="http://www.w3.org/2000/svg" width="48" height="40" viewBox="0 0 48 40" fill="none">
										<path d="M0.5 24C0.5 11.0213 11.0213 0.5 24 0.5H47.5V17C47.5 29.4264 37.4264 39.5 25 39.5H0.5V24Z" stroke="#81D8D0"/>
										<path d="M16 16H32" stroke="#81D8D0" stroke-linecap="round"/>
										<path d="M16 24H32" stroke="#81D8D0" stroke-linecap="round"/>
									</svg>
								</a>
							</div>
						</div>
					</div>
				</div>
			</header>
		</div>
	</div>
</section>
<?php /*
<section class="page-transition-container">
	<div class="ggt-logo-wrapper"></div>
</section>
*/ ?>
<section class="mobile-nav-container">
	<div class="grid-container">
		<div class="upper-nav">
			<div class="mobile-logo-wrapper">
				<a href="/" aria-label="Go Home" class="mobile-logo">
					<svg xmlns="http://www.w3.org/2000/svg" width="213" height="24" viewBox="0 0 213 24" fill="none">
						<g clip-path="url(#clip0_1367_5552)">
						<path d="M8.00195 7.99902H16.0039V15.9981C11.5826 15.9981 8.00195 12.4161 8.00195 7.99902Z" fill="#D0D1DB"/>
						<path d="M8.00195 0C8.00195 4.41978 11.5852 7.99911 16.0039 7.99911V0H8.00195Z" fill="#D0D1DB"/>
						<path d="M72.0283 7.99902C72.0283 12.4161 68.445 15.9981 64.0264 15.9981V7.99902H72.0283Z" fill="#D0D1DB"/>
						<path d="M72.0283 0H64.0264V7.99911C68.445 7.99911 72.0283 4.4171 72.0283 0Z" fill="#D0D1DB"/>
						<path d="M0 0C0 4.41978 3.58329 7.99911 8.00196 7.99911V0H0Z" fill="#A7A9B4"/>
						<path d="M80.0303 0C80.0303 4.41978 76.447 7.99911 72.0283 7.99911V0H80.0303Z" fill="#A7A9B4"/>
						<path d="M40.0151 7.99935L34.3555 2.34171C37.4821 -0.783824 42.5481 -0.783824 45.6721 2.34171L40.0124 7.99935H40.0151Z" fill="#F7F6FB"/>
						<path d="M32.0132 7.99911C32.0132 3.58201 28.4299 0 24.0112 0H16.0093C16.0093 4.4171 19.5926 7.99911 24.0112 7.99911H16.0093C16.0093 12.4189 19.5926 15.9982 24.0112 15.9982H38.4948C34.8014 15.2732 32.0159 12.0188 32.0159 8.11457V7.99642L32.0132 7.99911Z" fill="#F7F6FB"/>
						<path d="M40.0154 16.001L45.675 21.6586C42.5484 24.7842 37.4824 24.7842 34.3584 21.6586L40.0181 16.001H40.0154Z" fill="#F7F6FB"/>
						<path d="M48.0199 8.11725C48.0199 12.0215 45.2344 15.2759 41.541 16.0009H56.0246C60.4433 16.0009 64.0266 12.4189 64.0266 8.00179H56.0246C60.4406 7.9991 64.0239 4.41978 64.0239 0H56.0219C51.6032 0 48.0199 3.58201 48.0199 7.99911V8.11725Z" fill="#F7F6FB"/>
						<path d="M94.0226 6.76661L95.5725 7.1667V10.2815C95.2582 10.4211 94.8418 10.542 94.4416 10.542C92.145 10.542 90.6488 8.85567 90.6488 5.49922C90.6488 2.38711 91.9543 0.923697 93.625 0.923697C94.9654 0.923697 95.9727 1.84471 97.1573 4.07071L97.802 4.0358L97.6462 0H97.0552L96.4643 0.590736C95.7847 0.260461 94.8983 0.0698143 93.8184 0.0698143C90.3211 0.0698143 87.7827 2.67979 87.7827 5.96644C87.7827 9.25308 90.0095 11.6697 93.1066 11.6697C94.3422 11.6697 95.2824 11.3233 96.2198 10.7648L97.4716 11.565L97.9927 11.4952V7.16402L99.1934 6.76393V6.2081H94.0253V6.76393L94.0226 6.76661Z" fill="#F7F6FB"/>
						<path d="M113.631 10.8344C113.075 10.6948 112.64 10.4854 112.309 10.1202C111.909 9.66908 111.595 9.07566 111.195 8.03381C110.813 7.0591 110.15 6.38244 108.793 6.12198V5.87763C111.004 5.49633 112.046 4.43301 112.046 3.06089C112.046 1.3397 110.531 0.313965 108.009 0.313965H101.85V0.88859L103.485 1.27257V10.4397L101.85 10.821V11.3956H107.713V10.821L106.096 10.4397V6.47373H106.462C107.402 6.47373 107.923 6.75299 108.339 7.72502L109.089 9.48112C109.715 10.9069 110.115 11.393 111.471 11.393H113.628V10.8371L113.631 10.8344ZM107.071 5.61716L106.096 5.63328V1.18127C106.217 1.14637 106.846 1.16248 107.018 1.16248C108.444 1.21349 109.4 1.84182 109.4 3.33746C109.4 4.8331 108.46 5.58226 107.069 5.61716H107.071Z" fill="#F7F6FB"/>
						<path d="M126.226 7.87807L125.81 7.80826L124.505 9.44353C123.949 10.1229 123.564 10.4182 122.522 10.4531L120.051 10.523V6.2616H120.851C121.773 6.2616 122.033 6.52207 122.434 7.70622L122.608 8.21103H123.094V3.46098H122.624L122.434 4.01681C122.017 5.21708 121.773 5.44263 120.851 5.44263H120.051V1.16516L121.878 1.21618C123.008 1.25109 123.358 1.51155 124.018 2.33052L125.235 3.87986L125.652 3.77514L125.337 0.313965H115.804V0.88859L117.44 1.26988V10.437L115.804 10.8183V11.393H125.842L126.226 7.88076V7.87807Z" fill="#F7F6FB"/>
						<path d="M135.762 0.209473H133.919L129.971 10.2788L128.63 10.8186V11.3932H132.423V10.8723L131.241 10.4024L132.163 7.79238H135.99L136.947 10.5044L135.501 10.8696V11.3905H140.981V10.8159L139.606 10.346L135.762 0.209473ZM132.455 6.92238L133.97 2.59121H134.126L135.676 6.92238H132.458H132.455Z" fill="#F7F6FB"/>
						<path d="M149.507 1.1305L150.098 1.1493C150.949 1.1842 151.28 1.49837 152.15 2.66373L153.351 4.29899L153.802 4.21307L153.262 0.316895H143.084L142.544 4.21307L142.996 4.29899L144.196 2.66373C145.013 1.54938 145.397 1.1842 146.249 1.1493L146.893 1.1305V10.4346L145.171 10.8186V11.3932H151.226V10.8186L149.504 10.4346V1.1305H149.507Z" fill="#F7F6FB"/>
						<path d="M170.558 7.1667L171.759 6.76661V6.21079H166.59V6.76661L168.138 7.1667V10.2815C167.823 10.4211 167.407 10.542 167.007 10.542C164.71 10.542 163.214 8.85567 163.214 5.49922C163.214 2.38711 164.519 0.923697 166.19 0.923697C167.531 0.923697 168.538 1.84471 169.722 4.07071L170.367 4.0358L170.211 0H169.62L169.029 0.590736C168.35 0.260461 167.463 0.0698143 166.384 0.0698143C162.886 0.0698143 160.345 2.67979 160.345 5.96644C160.345 9.25308 162.572 11.6697 165.669 11.6697C166.905 11.6697 167.845 11.3233 168.785 10.7648L170.037 11.565L170.558 11.4952V7.16402V7.1667Z" fill="#F7F6FB"/>
						<path d="M186.2 11.3932V10.8374C185.644 10.6977 185.208 10.4883 184.878 10.1231C184.478 9.67201 184.163 9.07859 183.766 8.03674C183.382 7.06203 182.721 6.38537 181.365 6.12491V5.88056C183.575 5.49926 184.617 4.43594 184.617 3.06382C184.617 1.34263 183.105 0.316895 180.58 0.316895H174.421V0.89152L176.057 1.2755V10.4426L174.421 10.8239V11.3986H180.285V10.8239L178.668 10.4426V6.47666H179.033C179.973 6.47666 180.494 6.75592 180.913 7.72795L181.663 9.48405C182.289 10.9099 182.689 11.3959 184.045 11.3959H186.202L186.2 11.3932ZM179.64 5.61741L178.665 5.63352V1.18152C178.786 1.14661 179.414 1.16272 179.586 1.16272C181.013 1.21374 181.969 1.84207 181.969 3.3377C181.969 4.83334 181.029 5.5825 179.637 5.61741H179.64Z" fill="#F7F6FB"/>
						<path d="M194.967 0.209228H193.121L189.173 10.2786L187.833 10.8183V11.3929H191.625V10.872L190.443 10.4021L191.365 7.79213H195.192L196.149 10.5041L194.704 10.8693V11.3903H200.183V10.8156L198.808 10.3457L194.964 0.206543L194.967 0.209228ZM191.66 6.92214L193.173 2.59097H193.328L194.878 6.92214H191.66Z" fill="#F7F6FB"/>
						<path d="M208.868 0.313965V0.834887L210.001 1.3746L207.651 5.65207L205.129 1.26988L206.434 0.834887V0.313965H200.78V0.885905L202.292 1.42562L205.58 6.92216V10.3645L203.877 10.8183V11.393H209.913V10.8183L208.191 10.3645V6.53818L211.428 1.42562L212.8 0.885905V0.313965H208.868Z" fill="#F7F6FB"/>
						<path d="M87.7773 20.3859H89.1285V23.9249H90.1062V20.3859H91.4573V19.4863H87.7773V20.3859Z" fill="#F7F6FB"/>
						<path d="M97.4957 20.9629V20.9495C97.4957 20.5306 97.3614 20.1815 97.1142 19.9345C96.8214 19.6418 96.3863 19.4834 95.8195 19.4834H93.7915V23.922H94.7692V22.5015H95.5375L96.4884 23.922H97.63L96.5448 22.3377C97.1089 22.1283 97.4957 21.6772 97.4957 20.9629ZM96.5045 21.0139C96.5045 21.3872 96.2305 21.6423 95.7551 21.6423H94.7666V20.3668H95.7363C96.2117 20.3668 96.5045 20.5816 96.5045 21.0005V21.0139Z" fill="#F7F6FB"/>
						<path d="M102.784 22.0292C102.784 22.7327 102.422 23.0952 101.825 23.0952C101.229 23.0952 100.866 22.722 100.866 21.9996V19.489H99.8887V22.0238C99.8887 23.3288 100.619 23.9947 101.809 23.9947C102.999 23.9947 103.757 23.3342 103.757 21.9916V19.4863H102.779V22.0292H102.784Z" fill="#F7F6FB"/>
						<path d="M108.143 21.269C107.375 21.073 107.184 20.9763 107.184 20.6863V20.6729C107.184 20.4581 107.38 20.2863 107.754 20.2863C108.127 20.2863 108.514 20.4501 108.909 20.7239L109.416 19.9882C108.965 19.6257 108.415 19.4243 107.767 19.4243C106.859 19.4243 106.215 19.956 106.215 20.7615V20.775C106.215 21.6557 106.792 21.9027 107.687 22.131C108.428 22.3216 108.581 22.4478 108.581 22.6948V22.7083C108.581 22.9687 108.339 23.1272 107.942 23.1272C107.434 23.1272 107.015 22.9177 106.618 22.5874L106.04 23.2775C106.572 23.7528 107.251 23.9891 107.923 23.9891C108.882 23.9891 109.553 23.495 109.553 22.6143V22.6009C109.553 21.8275 109.046 21.5053 108.146 21.269H108.143Z" fill="#F7F6FB"/>
						<path d="M111.576 20.3859H112.927V23.9249H113.905V20.3859H115.256V19.4863H111.576V20.3859Z" fill="#F7F6FB"/>
						<path d="M123.191 23.1005C122.431 23.1005 121.904 22.4668 121.904 21.7069V21.6935C121.904 20.9336 122.444 20.3107 123.191 20.3107C123.634 20.3107 123.983 20.5013 124.327 20.8128L124.948 20.0958C124.537 19.6904 124.034 19.4111 123.196 19.4111C121.832 19.4111 120.881 20.4449 120.881 21.7069V21.7204C120.881 22.9958 121.851 24.0028 123.159 24.0028C124.016 24.0028 124.523 23.6993 124.98 23.2106L124.359 22.5823C124.01 22.8992 123.699 23.1032 123.194 23.1032L123.191 23.1005Z" fill="#F7F6FB"/>
						<path d="M129.388 19.4111C128.018 19.4111 127.021 20.4449 127.021 21.7069V21.7204C127.021 22.9824 128.005 24.0028 129.375 24.0028C130.744 24.0028 131.741 22.969 131.741 21.7069V21.6935C131.741 20.4315 130.758 19.4111 129.388 19.4111ZM130.72 21.7177C130.72 22.4776 130.175 23.1005 129.388 23.1005C128.601 23.1005 128.042 22.4668 128.042 21.7069V21.6935C128.042 20.9336 128.587 20.3107 129.375 20.3107C130.162 20.3107 130.72 20.9444 130.72 21.7043V21.7177Z" fill="#F7F6FB"/>
						<path d="M136.415 21.3633L135.249 19.4863H134.196V23.9249H135.152V21.0464L136.39 22.9233H136.415L137.664 21.0276V23.9249H138.636V19.4863H137.583L136.415 21.3633Z" fill="#F7F6FB"/>
						<path d="M143.101 19.4863H141.288V23.9249H142.265V22.5931H143.007C144.003 22.5931 144.801 22.0614 144.801 21.033V21.0196C144.801 20.112 144.162 19.4863 143.101 19.4863ZM143.813 21.0518C143.813 21.4331 143.528 21.7231 143.039 21.7231H142.265V20.3671H143.02C143.509 20.3671 143.813 20.6007 143.813 21.0384V21.0518Z" fill="#F7F6FB"/>
						<path d="M148.188 19.4541L146.286 23.9249H147.283L147.688 22.9287H149.566L149.972 23.9249H150.992L149.09 19.4541H148.191H148.188ZM148.035 22.0668L148.626 20.6275L149.217 22.0668H148.037H148.035Z" fill="#F7F6FB"/>
						<path d="M156.244 22.2198L154.165 19.4863H153.262V23.9249H154.227V21.1028L156.378 23.9249H157.208V19.4863H156.244V22.2198Z" fill="#F7F6FB"/>
						<path d="M161.602 21.2693L160.544 19.4863H159.402L161.108 22.1742V23.9249H162.086V22.1554L163.791 19.4863H162.682L161.602 21.2693Z" fill="#F7F6FB"/>
						</g>
						<defs>
						<clipPath id="clip0_1367_5552">
						<rect width="212.8" height="24" fill="white"/>
						</clipPath>
						</defs>
					</svg>
				</a>
			</div>
			<div class="mobile-close-wrapper">
				<a href="#" aria-label="Close Navigation" aria-label="Close Mobile Menu" class="mobile-close-btn">
				<svg xmlns="http://www.w3.org/2000/svg" width="48" height="40" viewBox="0 0 48 40" fill="none">
					<path d="M0.5 24C0.5 11.0213 11.0213 0.5 24 0.5H47.5V17C47.5 29.4264 37.4264 39.5 25 39.5H0.5V24Z" stroke="#81D8D0"/>
					<path d="M18.3433 25L29.657 13.6863" stroke="#81D8D0" stroke-linecap="round"/>
					<path d="M18.3433 14L29.657 25.3137" stroke="#81D8D0" stroke-linecap="round"/>
				</svg>
				</a>
			</div>
		</div>
			<div class="mobile-nav-wrapper">
			<?php if(have_rows('menu_items', 'option')){ ?>
				<ul class="mobile-menu">
					<?php 
						while(have_rows('menu_items', 'option'))
						{
							the_row();

							$parentLink = get_sub_field('parent_item');
							$parentTarget = 'target="_self"';
							$parentClass = 'no-children';
							$dropdownType = get_sub_field('dropdown_type');
							$dropdownContent = get_sub_field('dropdown_content');
							$menuCats = get_sub_field('menu_categories');
							$menuTags = get_sub_field('menu_tags');
							$parentExpanderHTML = '';
							
							if(isset($parentLink['target']) && $parentLink['target'] != '')
							{
								$parentTarget = 'target="'.$parentLink['target'].'"';
							}

							if(have_rows('child_links') || $dropdownType == 'Perspectives')
							{
								$parentClass = 'has-children';
								$parentExpanderHTML = '
								<span class="expander-arrow">
									<svg xmlns="http://www.w3.org/2000/svg" width="8" height="14" viewBox="0 0 8 14" fill="none">
										<path d="M1 1L7 7L1 13" stroke="#A7A9B4" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
								</span>
								';
							}

							echo '<li class="'.$parentClass.'"><a href="'.$parentLink['url'].'" '.$parentTarget.'>'.$parentLink['title'].''.$parentExpanderHTML.'</a>';

							if(have_rows('child_links') || $dropdownType == 'Perspectives')
							{
									echo '<ul class="sub-menu">';
									echo '<li class="menu-outer"><ul class="inner-menu">';

									if($dropdownType == 'Content')
									{
										echo '<li class="inner-menu-wrapper">';

											echo '<ul class="child-menu">';

											echo '
											<li>
												<a class="back-btn" aria-label="Back">
													<svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 44 44" fill="none">
														<circle cx="22" cy="22" r="21.5" transform="matrix(-1 0 0 1 44 0)" stroke="#A7A9B4"/>
														<path d="M22 28L16 22L22 16" stroke="#A7A9B4" stroke-linecap="round" stroke-linejoin="round"/>
														<path d="M28 22.5C28.2761 22.5 28.5 22.2761 28.5 22C28.5 21.7239 28.2761 21.5 28 21.5V22.5ZM16 22.5H28V21.5H16V22.5Z" fill="#A7A9B4"/>
													</svg>
												</a>
											</li>';

											echo '<li><a href="'.$parentLink['url'].'" '.$parentTarget.'>'.$parentLink['title'].'</a></li>';

											while(have_rows('child_links'))
											{
												the_row();

												$childLink = get_sub_field('child_link');
												$childTarget = 'target="_self"';

												if(isset($childLink['target']) && $childLink['target'] != '')
												{
													$childTarget = 'target="'.$childLink['target'].'"';
												}

												echo '<li><a href="'.$childLink['url'].'" '.$childTarget.'>'.$childLink['title'].'</a></li>';
											}

											echo '</ul>';
										
										echo '</li>';

										echo '<li class="menu-card-wrapper">
											<span class="content-card content-only">'.$dropdownContent.'</span>';
										echo '</li>';
									}

									if($dropdownType == 'Perspectives')
									{
										$catsHTML = '';
										$tagsHTML = '';

										if(isset($menuCats) && !empty($menuCats))
										{
											foreach($menuCats as $cat)
											{
												$catLink = get_term_link($cat);

												$catsHTML .= '<a href="'.$perspectivesLink.'?cat='.$cat->term_id.'">'.$cat->name.'</a>';
											}
										}

										if(isset($menuTags) && !empty($menuTags))
										{
											foreach($menuTags as $tag)
											{
												$tagLink = get_term_link($tag);

												$tagsHTML .= '<a href="'.$perspectivesLink.'?tag='.$tag->term_id.'">'.$tag->name.'</a>';
											}
										}

										echo '<li class="inner-menu-wrapper perspectives-menu-wrapper">';
											echo '<ul class="child-menu">';
											echo '<li>
													<a class="back-btn" aria-label="Back">
														<svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 44 44" fill="none">
															<circle cx="22" cy="22" r="21.5" transform="matrix(-1 0 0 1 44 0)" stroke="#A7A9B4"/>
															<path d="M22 28L16 22L22 16" stroke="#A7A9B4" stroke-linecap="round" stroke-linejoin="round"/>
															<path d="M28 22.5C28.2761 22.5 28.5 22.2761 28.5 22C28.5 21.7239 28.2761 21.5 28 21.5V22.5ZM16 22.5H28V21.5H16V22.5Z" fill="#A7A9B4"/>
														</svg>
													</a>
												</li>';
												echo '<li><a href="'.$parentLink['url'].'" '.$parentTarget.'>See All Perspectives</a></li>';
												echo '<li class="cats-wrapper">'.$catsHTML.'</li>';
												echo '<li class="tags-wrapper">'.$tagsHTML.'</li>';
											echo '</ul>';
										echo '</li>';

										if(!empty($featuredPosts))
										{
											echo '<li class="menu-card-wrapper perspectives-card-wrapper">';
												echo '<span class="perspectives-title">Featured <strong>Perspectives</strong></span>';
												echo '<span class="swiper-buttons">
												<span class="swiper-button-prev">
													<svg xmlns="http://www.w3.org/2000/svg" width="104" height="104" viewBox="0 0 104 104" fill="none"> <g filter="url(#filter0_d_1367_5079)"> <circle cx="22" cy="22" r="22" transform="matrix(-1 0 0 1 70 26)" fill="#D0D1DB"/> </g> <path d="M42.893 48.7071C42.5025 48.3166 42.5025 47.6834 42.893 47.2929L49.257 40.9289C49.6475 40.5384 50.2806 40.5384 50.6712 40.9289C51.0617 41.3195 51.0617 41.9526 50.6712 42.3431L45.0143 48L50.6712 53.6569C51.0617 54.0474 51.0617 54.6805 50.6712 55.0711C50.2806 55.4616 49.6475 55.4616 49.257 55.0711L42.893 48.7071ZM52.4001 47C52.9524 47 53.4001 47.4477 53.4001 48C53.4001 48.5523 52.9524 49 52.4001 49L52.4001 47ZM43.6001 47L52.4001 47L52.4001 49L43.6001 49L43.6001 47Z" fill="#2F3942"/> <defs> <filter id="filter0_d_1367_5079" x="0" y="0" width="104" height="104" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"> <feFlood flood-opacity="0" result="BackgroundImageFix"/> <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/> <feOffset dx="4" dy="4"/> <feGaussianBlur stdDeviation="15"/> <feComposite in2="hardAlpha" operator="out"/> <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/> <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1367_5079"/> <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1367_5079" result="shape"/> </filter> </defs> </svg>
												</span>
												<span class="swiper-button-next">
													<svg xmlns="http://www.w3.org/2000/svg" width="104" height="104" viewBox="0 0 104 104" fill="none"> <g filter="url(#filter0_d_1367_5080)"> <circle cx="22" cy="22" r="22" transform="matrix(1 1.74846e-07 1.74846e-07 -1 26 70)" fill="#D0D1DB"/> </g> <path d="M53.107 47.2929C53.4975 47.6834 53.4975 48.3166 53.107 48.7071L46.743 55.0711C46.3525 55.4616 45.7194 55.4616 45.3288 55.0711C44.9383 54.6805 44.9383 54.0474 45.3288 53.6569L50.9857 48L45.3288 42.3431C44.9383 41.9526 44.9383 41.3195 45.3288 40.9289C45.7194 40.5384 46.3525 40.5384 46.743 40.9289L53.107 47.2929ZM43.5999 49C43.0476 49 42.5999 48.5523 42.5999 48C42.5999 47.4477 43.0476 47 43.5999 47L43.5999 49ZM52.3999 49L43.5999 49L43.5999 47L52.3999 47L52.3999 49Z" fill="#2F3942"/> <defs> <filter id="filter0_d_1367_5080" x="0" y="0" width="104" height="104" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"> <feFlood flood-opacity="0" result="BackgroundImageFix"/> <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/> <feOffset dx="4" dy="4"/> <feGaussianBlur stdDeviation="15"/> <feComposite in2="hardAlpha" operator="out"/> <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/> <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1367_5080"/> <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1367_5080" result="shape"/> </filter> </defs> </svg>
												</span>
												</span>';
												echo '<ul class="featured-wrapper swiper">';
												echo '<li class="swiper-wrapper">';

												foreach($featuredPosts as $post)
												{
													$postTitle = trimStringToFullWord(25, $post['title']);

													echo '
													<span class="slide swiper-slide">
														<a href="'.$post['link'].'" class="slide-link">
															<span class="slide-img" style="background-image:url('.$post['thumbnail'].');"></span>
															<span class="slide-title">'.$postTitle.'</span>
														</a>
													</span>';
												}

												echo '</li>';

												echo '</ul>';
											echo '</li>';
										}
								}
								
								echo '</ul>';
								echo '</ul></li>';
							}

							echo '</li>';
						}
					?>
				</ul>
			<?php } ?>
			</div>
		</div>
	</div>
	<div class="mobile-lower-wrapper">
		<div class="grid-container">
			<div class="mobile-search">
				<form action="/" method="GET" class="search-form">
					<label for="mobile-search" class="screen-reader-text"><?php echo $searchPlaceholder; ?></label>
					<input type="text" name="s" id="mobile-search" placeholder="<?php echo $searchPlaceholder; ?>" class="search-input">
					<button type="submit">
						<?php echo $searchPlaceholder; ?>
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
							<path d="M14.7562 15.9911L9.15936 10.3942C8.71516 10.7496 8.19989 11.0339 7.62243 11.2382C7.04497 11.4425 6.43198 11.5491 5.77457 11.5491C4.15769 11.5491 2.79845 10.9894 1.67907 9.87007C0.559689 8.75069 0 7.38257 0 5.77457C0 4.16657 0.568573 2.79845 1.68795 1.67907C2.80733 0.559689 4.16657 0 5.78345 0C7.40033 0 8.75958 0.559689 9.87896 1.67907C10.9983 2.79845 11.558 4.16657 11.558 5.77457C11.558 6.4231 11.4514 7.04497 11.2471 7.62243C11.0428 8.19989 10.7585 8.71516 10.4031 9.15936L16 14.7562L14.7562 16V15.9911ZM5.78345 9.77235C6.89395 9.77235 7.83565 9.38145 8.61743 8.60855C9.39922 7.83565 9.78123 6.88506 9.78123 5.77457C9.78123 4.66408 9.39034 3.72238 8.61743 2.94059C7.84453 2.1588 6.89395 1.77679 5.78345 1.77679C4.67296 1.77679 3.73126 2.16768 2.94947 2.94059C2.16768 3.71349 1.78567 4.66408 1.78567 5.77457C1.78567 6.88506 2.17657 7.82676 2.94947 8.60855C3.72238 9.39034 4.67296 9.77235 5.78345 9.77235Z" fill="#81D8D0"/>
						</svg>
					</button>
				</form>
			</div>
			<div class="trim-menu-wrapper">
				<ul class="trim-menu">
					<?php 
						while(have_rows('trim_menu_items', 'option'))
						{
							the_row();

							$trimLink = get_sub_field('menu_item');
							$trimTarget = 'target="_self"';

							if(isset($trimLink['target']) && $trimLink['target'] != '')
							{
								$trimTarget = 'target="'.$trimLink['target'].'"';
							}

							echo '<li><a href="'.$trimLink['url'].'" '.$trimTarget.'>'.$trimLink['title'].'</a></li>';
						}
					?>
				</ul>
			</div>
		</div>
	</div>
</section>
<div id="main-page-content"></div>