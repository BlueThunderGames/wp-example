<?php 
    $upperCopy = get_sub_field('upper_copy');
    $leftCardHeading = get_sub_field('left_card_heading');
    $leftCardCopy = get_sub_field('left_card_copy');
    $rightCardHeading = get_sub_field('right_card_heading');
    $rightCardCopy = get_sub_field('right_card_copy');

    $topPadding = get_sub_field('top_padding');
    $bottomPadding = get_sub_field('bottom_padding');
    $topPaddingStyle = '';
    $bottomPaddingStyle = '';

    if(isset($topPadding) && $topPadding != '' && is_numeric($topPadding))
    {
        $topPaddingStyle = 'padding-top: '.$topPadding.'vh;';
    }

    if(isset($bottomPadding) && $bottomPadding != '' && is_numeric($bottomPadding))
    {
        $bottomPaddingStyle = 'padding-bottom: '.$bottomPadding.'vh;';
    }
?>
<section class="hover-cards-container" style="<?php echo $topPaddingStyle; ?><?php echo $bottomPaddingStyle; ?>">
    <div class="grid-container">
        <?php if(isset($upperCopy) && $upperCopy != ''){ ?>
        <div class="upper-copy">
            <?php echo $upperCopy; ?>
        </div>
        <?php } ?>
        <div class="grid-x">
            <div class="hover-card" data-aos="fade-right" data-aos-offset="300" data-aos-delay="200">
                <div class="card-bg"></div>
                <div class="card-table">
                    <div class="card-table-cell">
                        <div class="card-title">
                            <?php echo $leftCardHeading; ?>
                        </div>
                        <div class="card-copy">
                            <?php echo $leftCardCopy; ?>
                        </div>
                    </div>
                </div>
                <div class="card-line">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="54" viewBox="0 0 20 54" fill="none">
                        <path d="M10 35L10 9.38773e-07" stroke="#81D8D0"/>
                        <circle cx="10" cy="44" r="4.5" fill="#81D8D0" stroke="#81D8D0"/>
                        <circle cx="10" cy="44" r="9.5" stroke="#81D8D0"/>
                    </svg>
                </div>
            </div>
            <div class="hover-card" data-aos="fade-left" data-aos-offset="300" data-aos-delay="200">
                <div class="card-bg"></div>
                <div class="card-table">
                    <div class="card-table-cell">
                        <div class="card-title">
                            <?php echo $rightCardHeading; ?>
                        </div>
                        <div class="card-copy">
                            <?php echo $rightCardCopy; ?>
                        </div>
                    </div>
                </div>
                <div class="card-line">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="54" viewBox="0 0 20 54" fill="none">
                        <path d="M10 35L10 9.38773e-07" stroke="#81D8D0"/>
                        <circle cx="10" cy="44" r="4.5" fill="#81D8D0" stroke="#81D8D0"/>
                        <circle cx="10" cy="44" r="9.5" stroke="#81D8D0"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</section>