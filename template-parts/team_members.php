<?php 
    $heading = get_sub_field('heading');
    $copy = get_sub_field('copy');

    $topPadding = get_sub_field('top_padding');
    $bottomPadding = get_sub_field('bottom_padding');
    $topPaddingStyle = '';
    $bottomPaddingStyle = '';
    $bgColor = get_sub_field('background_color');
    $bgColorStyle = '';

    if(isset($bgColor) && $bgColor != '')
    {
        $bgColorStyle = 'background-color: '.$bgColor.';';
    }

    if(isset($topPadding) && $topPadding != '' && is_numeric($topPadding))
    {
        $topPaddingStyle = 'padding-top: '.$topPadding.'vh;';
    }

    if(isset($bottomPadding) && $bottomPadding != '' && is_numeric($bottomPadding))
    {
        $bottomPaddingStyle = 'padding-bottom: '.$bottomPadding.'vh;';
    }

    $moduleID = get_sub_field('module_id');
    $idHTML = '';

    if(isset($moduleID) && $moduleID != '')
    {
        $cleanModuleID = str_replace(' ', '-', strtolower(trim($moduleID)));

        $idHTML = 'id="'.$cleanModuleID.'"';
    }
?>
<section class="team-member-container" style="<?php echo $topPaddingStyle; ?><?php echo $bottomPaddingStyle; ?><?php echo $bgColorStyle; ?>" <?php echo $idHTML; ?>>
    <div class="grid-container">
        <?php if(isset($heading) && $heading != ''){ ?>
            <div class="heading-wrapper">
                <h2><?php echo $heading; ?></h2>
            </div>
        <?php } ?>
        <?php if(isset($copy) && $copy != ''){ ?>
        <div class="member-copy-wrapper">
            <?php echo $copy; ?>
        </div>
        <?php } ?>
        <?php if(have_rows('team_members')){ ?>
        <div class="grid-x members-wrapper version-a">
            <?php 
                $random = rand(1, 9999);
                $itemNumber = 0;

                while(have_rows('team_members'))
                {
                    the_row();

                    $itemNumber++;
                    $name = get_sub_field('name');
                    $memberImg = get_sub_field('member_image');
                    $title = get_sub_field('title');
                    $email = get_sub_field('email_address');
                    $phoneNumber = get_sub_field('phone_number');
                    $bio = get_sub_field('bio');
                    $mapRegionName = get_sub_field('map_region_name');
                    $twitterURL = get_sub_field('twitter_url');
                    $linkedinURL = get_sub_field('linkedin_url');
                    $linkedinHTML = '';

                    $titleHTML = '';
                    $modalTitleHTML = '';
                    $memberImgStyle = '';

                    if(isset($title) && $title != '')
                    {
                        $titleHTML = '<span class="member-title">'.$title.'</span>';

                        $modalTitleHTML = '<h4>'.$title.'</h4>';
                    }

                    if(isset($memberImg) && !empty($memberImg))
                    {
                        $memberImgStyle = 'style="background-image: url('.$memberImg['url'].')"';
                    }

                    $cleanName = preg_replace("/[^A-Za-z0-9 ]/", '', $name);
                    $cleanName = str_replace(' ', '-', $cleanName);
                    $cleanName = strtolower($cleanName);

                    $cleanName = ''.$random.'-'.$itemNumber.'-'.$cleanName;

                    if(isset($linkedinURL) && $linkedinURL != '')
                    {
                        $linkedinHTML = '
                        <span class="linked-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                                <path d="M21.9587 0C22.961 0 23.9051 0.192313 24.7909 0.576939C25.6767 0.961565 26.4518 1.48606 27.1161 2.15041C27.7805 2.81476 28.305 3.58984 28.6896 4.47565C29.0742 5.36145 29.2665 6.30554 29.2665 7.3079V21.9237C29.2665 22.926 29.0742 23.876 28.6896 24.7734C28.305 25.6709 27.7805 26.4518 27.1161 27.1161C26.4518 27.7805 25.6767 28.305 24.7909 28.6896C23.9051 29.0742 22.961 29.2665 21.9587 29.2665H7.3079C6.30554 29.2665 5.36145 29.0742 4.47565 28.6896C3.58984 28.305 2.81476 27.7805 2.15041 27.1161C1.48606 26.4518 0.961565 25.6709 0.576939 24.7734C0.192313 23.876 0 22.926 0 21.9237V7.3079C0 6.30554 0.192313 5.36145 0.576939 4.47565C0.961565 3.58984 1.48606 2.81476 2.15041 2.15041C2.81476 1.48606 3.58984 0.961565 4.47565 0.576939C5.36145 0.192313 6.30554 0 7.3079 0H21.9587ZM10.0702 10.9793H6.39878V22.8678H10.0702V10.9793ZM8.25198 10.0352C8.7415 10.0352 9.16692 9.86041 9.52824 9.51075C9.88955 9.16109 10.0702 8.72985 10.0702 8.21701C10.0702 7.70418 9.88955 7.27293 9.52824 6.92327C9.16692 6.57361 8.7415 6.39878 8.25198 6.39878C7.73914 6.39878 7.30207 6.57361 6.94075 6.92327C6.57944 7.27293 6.39878 7.70418 6.39878 8.21701C6.39878 8.72985 6.57944 9.16109 6.94075 9.51075C7.30207 9.86041 7.73914 10.0352 8.25198 10.0352ZM22.8678 15.9795C22.8678 15.1403 22.6347 14.3186 22.1684 13.5144C21.7022 12.7101 21.0962 12.0982 20.3502 11.6786C19.6742 11.3057 18.8875 11.1075 17.99 11.0842C17.0926 11.0609 16.2825 11.2124 15.5599 11.5388V10.9793H11.8884V22.8678H15.5599V15.5948L17.0634 14.8606C17.2499 14.7673 17.5063 14.7207 17.8327 14.7207C18.159 14.7207 18.4038 14.779 18.5669 14.8955C18.7068 14.9655 18.8467 15.117 18.9865 15.3501C19.1264 15.5832 19.1963 15.793 19.1963 15.9795V22.8678H22.8678V15.9795Z" fill="#F7F6FB"/>
                            </svg>
                        </span>
                        ';
                    }

                    $linkHref = '';
                    $anchorClass = 'no-bio';
                    $regionHTML = '';
                    $fancyData = '';

                    if(isset($bio) && $bio != '')
                    {
                        $linkHref = '#modal-'.$cleanName;
                        $anchorClass = 'has-bio';
                        $fancyData = 'data-fancybox="team" data-src="'.$linkHref.'"';
                    }
                    elseif(isset($mapRegionName) && $mapRegionName != '')
                    {
                        $cleanRegion = str_replace(" ", '_', strtolower(trim($mapRegionName)));

                        $linkHref = ''.$cleanRegion.'';

                        $anchorClass = 'has-region';

                        $regionHTML = '<span class="region-name">Region: '.$mapRegionName.'</span>';
                    }

                    echo '
                    <a href="'.$linkHref.'" '.$fancyData.' class="member-item '.$anchorClass.'" data-aos="fade" data-aos-offset="190">
                        <span class="member-img" '.$memberImgStyle.'>
                            '.$linkedinHTML.'
                        </span>
                        <span class="img-overlay">
                                <span class="overlay-bg"></span>
                        </span>
                        <span class="member-name">
                            '.$name.'
                        </span>
                        '.$titleHTML.'
                        '.$regionHTML.'
                    </a>
                    ';
                }
            ?>
        </div>
        <?php } ?>
    </div>
    <?php 
        if(have_rows('team_members'))
        {
            $itemNumber = 0;

            while(have_rows('team_members'))
            {
                the_row();

                $itemNumber++;
                $name = get_sub_field('name');
                $memberImg = get_sub_field('member_image');
                $title = get_sub_field('title');
                $bio = get_sub_field('bio');
                $mapRegionName = get_sub_field('map_region_name');
                $twitterURL = get_sub_field('twitter_url');
                $linkedinURL = get_sub_field('linkedin_url');

                $titleHTML = '';
                $modalTitleHTML = '';
                $memberImgStyle = '';
                $contactHTML = '';

                if(isset($title) && $title != '')
                {
                    $titleHTML = '<span class="member-title">'.$title.'</span>';

                    $modalTitleHTML = '<h4>'.$title.'</h4>';
                }

                if(isset($memberImg) && !empty($memberImg))
                {
                    $memberImgStyle = 'style="background-image: url('.$memberImg['url'].')"';
                }

                $cleanName = preg_replace("/[^A-Za-z0-9 ]/", '', $name);
                $cleanName = str_replace(' ', '-', $cleanName);
                $cleanName = strtolower($cleanName);

                $cleanName = ''.$random.'-'.$itemNumber.'-'.$cleanName;

                $twitterLinkHTML = '';
                $linkedinLinkHTML = '';

                if(isset($twitterURL) && $twitterURL != '')
                {
                    $twitterLinkHTML = '
                    <li>
                        <a href="'.$twitterURL.'" aria-label="View on Twitter" target="_blank">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                                <path d="M21.9587 0C22.961 0 23.9051 0.192313 24.7909 0.576939C25.6767 0.961565 26.4518 1.48606 27.1161 2.15041C27.7805 2.81476 28.305 3.58984 28.6896 4.47565C29.0742 5.36145 29.2665 6.30554 29.2665 7.3079V21.9237C29.2665 22.926 29.0742 23.876 28.6896 24.7734C28.305 25.6709 27.7805 26.4518 27.1161 27.1161C26.4518 27.7805 25.6767 28.305 24.7909 28.6896C23.9051 29.0742 22.961 29.2665 21.9587 29.2665H7.3079C6.30554 29.2665 5.36145 29.0742 4.47565 28.6896C3.58984 28.305 2.81476 27.7805 2.15041 27.1161C1.48606 26.4518 0.961565 25.6709 0.576939 24.7734C0.192313 23.876 0 22.926 0 21.9237V7.3079C0 6.30554 0.192313 5.36145 0.576939 4.47565C0.961565 3.58984 1.48606 2.81476 2.15041 2.15041C2.81476 1.48606 3.58984 0.961565 4.47565 0.576939C5.36145 0.192313 6.30554 0 7.3079 0H21.9587ZM10.0702 10.9793H6.39878V22.8678H10.0702V10.9793ZM8.25198 10.0352C8.7415 10.0352 9.16692 9.86041 9.52824 9.51075C9.88955 9.16109 10.0702 8.72985 10.0702 8.21701C10.0702 7.70418 9.88955 7.27293 9.52824 6.92327C9.16692 6.57361 8.7415 6.39878 8.25198 6.39878C7.73914 6.39878 7.30207 6.57361 6.94075 6.92327C6.57944 7.27293 6.39878 7.70418 6.39878 8.21701C6.39878 8.72985 6.57944 9.16109 6.94075 9.51075C7.30207 9.86041 7.73914 10.0352 8.25198 10.0352ZM22.8678 15.9795C22.8678 15.1403 22.6347 14.3186 22.1684 13.5144C21.7022 12.7101 21.0962 12.0982 20.3502 11.6786C19.6742 11.3057 18.8875 11.1075 17.99 11.0842C17.0926 11.0609 16.2825 11.2124 15.5599 11.5388V10.9793H11.8884V22.8678H15.5599V15.5948L17.0634 14.8606C17.2499 14.7673 17.5063 14.7207 17.8327 14.7207C18.159 14.7207 18.4038 14.779 18.5669 14.8955C18.7068 14.9655 18.8467 15.117 18.9865 15.3501C19.1264 15.5832 19.1963 15.793 19.1963 15.9795V22.8678H22.8678V15.9795Z" fill="#2F3942"/>
                            </svg>
                        </a>
                    </li>';
                }

                if(isset($linkedinURL) && $linkedinURL != '')
                {
                    $linkedinLinkHTML = '
                    <li>
                        <a href="'.$linkedinURL.'" aria-label="View on LinkedIn" target="_blank">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                                <path d="M21.9587 0C22.961 0 23.9051 0.192313 24.7909 0.576939C25.6767 0.961565 26.4518 1.48606 27.1161 2.15041C27.7805 2.81476 28.305 3.58984 28.6896 4.47565C29.0742 5.36145 29.2665 6.30554 29.2665 7.3079V21.9237C29.2665 22.926 29.0742 23.876 28.6896 24.7734C28.305 25.6709 27.7805 26.4518 27.1161 27.1161C26.4518 27.7805 25.6767 28.305 24.7909 28.6896C23.9051 29.0742 22.961 29.2665 21.9587 29.2665H7.3079C6.30554 29.2665 5.36145 29.0742 4.47565 28.6896C3.58984 28.305 2.81476 27.7805 2.15041 27.1161C1.48606 26.4518 0.961565 25.6709 0.576939 24.7734C0.192313 23.876 0 22.926 0 21.9237V7.3079C0 6.30554 0.192313 5.36145 0.576939 4.47565C0.961565 3.58984 1.48606 2.81476 2.15041 2.15041C2.81476 1.48606 3.58984 0.961565 4.47565 0.576939C5.36145 0.192313 6.30554 0 7.3079 0H21.9587ZM10.0702 10.9793H6.39878V22.8678H10.0702V10.9793ZM8.25198 10.0352C8.7415 10.0352 9.16692 9.86041 9.52824 9.51075C9.88955 9.16109 10.0702 8.72985 10.0702 8.21701C10.0702 7.70418 9.88955 7.27293 9.52824 6.92327C9.16692 6.57361 8.7415 6.39878 8.25198 6.39878C7.73914 6.39878 7.30207 6.57361 6.94075 6.92327C6.57944 7.27293 6.39878 7.70418 6.39878 8.21701C6.39878 8.72985 6.57944 9.16109 6.94075 9.51075C7.30207 9.86041 7.73914 10.0352 8.25198 10.0352ZM22.8678 15.9795C22.8678 15.1403 22.6347 14.3186 22.1684 13.5144C21.7022 12.7101 21.0962 12.0982 20.3502 11.6786C19.6742 11.3057 18.8875 11.1075 17.99 11.0842C17.0926 11.0609 16.2825 11.2124 15.5599 11.5388V10.9793H11.8884V22.8678H15.5599V15.5948L17.0634 14.8606C17.2499 14.7673 17.5063 14.7207 17.8327 14.7207C18.159 14.7207 18.4038 14.779 18.5669 14.8955C18.7068 14.9655 18.8467 15.117 18.9865 15.3501C19.1264 15.5832 19.1963 15.793 19.1963 15.9795V22.8678H22.8678V15.9795Z" fill="#2F3942"/>
                            </svg>
                        </a>
                    </li>
                    ';
                }

                if(isset($email) && $email != '' && isset($phoneNumber) && $phoneNumber != '')
                {
                    $contactHTML = '<span class="contact-info"><a href="mailto:'.$email.'">'.$email.'</a> | <a href="tel:'.cleanPhone($phoneNumber).'">'.$phoneNumber.'</a></span>';
                }
                elseif(isset($email) && $email != '')
                {
                    $contactHTML = '<span class="contact-info"><a href="mailto:'.$email.'">'.$email.'</a></span>';
                }
                elseif(isset($phoneNumber) && $phoneNumber != '')
                {
                    $contactHTML = '<span class="contact-info"><a href="tel:'.cleanPhone($phoneNumber).'">'.$phoneNumber.'</a></span>';
                }

                if((isset($bio) && $bio != '') && (!isset($mapRegionName) || $mapRegionName == ''))
                {
                    echo '
                    <div class="team-modal" id="modal-'.$cleanName.'">
                        <div class="modal-inner">
                            <div class="modal-img">
                                <div '.$memberImgStyle.' class="member-img"></div>
                            </div>
                            <div class="modal-content">
                                <div class="grid-x">
                                    <div class="modal-copy">
                                        <h2>'.$name.'</h2>
                                        '.$modalTitleHTML.'
                                        <ul class="social-links">
                                            '.$twitterLinkHTML.'
                                            '.$linkedinLinkHTML.'
                                        </ul>
                                        <div class="modal-bio">
                                            '.$bio.'
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    ';
                }
            }
        }
    ?>
</section>