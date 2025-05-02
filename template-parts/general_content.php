<?php
    $upperCopy = get_sub_field('upper_copy');
    $columnWidth = get_sub_field('column_width');
    $colWidthClass = 'sm-12';

    $extraClasses = '';

    if(isset($columnWidth) && $columnWidth != '')
    {
        switch($columnWidth)
        {
            case 'Full Width':
                $colWidthClass = 'small-12';
                break;
            case 'Two Column':
                $colWidthClass = 'small-6';
                break;
            case 'Three Column':
                $colWidthClass = 'small-4';
                break;
            default:
                $colWidthClass = 'small-12';
                break;
        }
    }

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

    $moduleID = get_sub_field('module_id');
    $idHTML = '';

    if(isset($moduleID) && $moduleID != '')
    {
        $cleanModuleID = str_replace(' ', '-', strtolower(trim($moduleID)));

        $idHTML = 'id="'.$cleanModuleID.'"';
    }

    $bgColor = get_sub_field('background_color');
    $bgColorStyle = '';

    if(isset($bgColor) && $bgColor != '')
    {
        $bgColorStyle = 'background: '.$bgColor.';';
    }

    $roundedClass = '';
    $roundImages = get_sub_field('round_images');

    if(isset($roundImages) && $roundImages == true)
    {
        $roundedClass = 'rounded-images';
    }
?>
<section style="<?php echo $topPaddingStyle; ?><?php echo $bottomPaddingStyle; ?><?php echo $bgColorStyle; ?>" class="general-content-block <?php echo $roundedClass; ?>" <?php echo $idHTML; ?>>
    <div class="grid-container">
        <div class="upper-copy">
            <?php echo $upperCopy; ?>
        </div>
        <?php if(have_rows('columns')){ ?>
        <div class="grid-x">
            <?php
                while(have_rows('columns'))
                {
                    the_row();

                    $icon = get_sub_field('icon');
                    $iconHTML = '';
                    $iconAligment = strtolower(get_sub_field('icon_alignment'));
                    $columnContent = get_sub_field('column_content');

                    if(isset($icon) && !empty($icon))
                    {
                        $iconExtension = pathinfo($icon['url'], PATHINFO_EXTENSION);

                        if($iconExtension == 'svg')
                        {
                            $iconHTML = '<div class="icon align-'.$iconAligment.'">'.file_get_contents($icon['url']).'</div>';
                        }
                        else
                        {
                            $iconHTML = '<div class="icon align-'.$iconAligment.'"><img alt="'.$icon['alt'].'" src="'.$icon['url'].'"></img></div>';
                        }
                    }

                    echo '
                    <div class="'.$colWidthClass.'">
                        '.$iconHTML.'
                        '.$columnContent.'
                    </div>
                    ';
                }
            ?>
        </div>
        <?php } ?>
    </div>
</section>