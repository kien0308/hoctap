<?php

/**
 * @package Study Education Lite
 */
?>
<?php
$boxvariable = array();
for ($k = 1; $k <= 4; $k++) {
?>
    <?php $boxid    = absint(get_theme_mod('study_education_lite_box' . $k)); ?>
    <?php $boxquery = new WP_query('page_id=' . $boxid); ?>
    <?php
    if ($boxquery->have_posts() && $boxid > 0) :
        while ($boxquery->have_posts()) : $boxquery->the_post();
            $thumbnail_id  = get_post_thumbnail_id($post->ID);
            $alt           = esc_html(get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true));
            $image         = esc_url(get_the_post_thumbnail_url($post->ID, 'study-education-lite-home-box-size'));
            $titless       = esc_html(get_the_title($post->ID));
            $my_postid     = $post->ID;
            $content       = esc_html(study_education_lite_get_excerpt($my_postid, '250'));
            $url           = esc_url(get_the_permalink($my_postid));
            $boxvariable[] = array('boxid' => $post->ID, 'boximage' => $image, 'alt' => $alt, 'box_title' => $titless, 'box_content' => $content, 'url' => $url);
        endwhile;
        wp_reset_postdata();
    endif;
    ?>

<?php } ?>
<?php
if (!empty($boxvariable)) {
?>
    <section id="pageboxes">
        <div class="container">
            <div class="pageclmn fadeInRight">
                <div class="box-equal-height">
                    <?php foreach ($boxvariable as $boxvariables) { ?>

                        <div class="commonboxrs top4box col-md-3 col-sm-12 col-lg-3">
                            <div class="topboxbg">
                                <a href="<?php echo esc_url($boxvariables['url']); ?>">
                                    <div class="thumbbx img-responsive img-thumbnail"><img alt="<?php echo esc_attr($boxvariables['alt']); ?>" src="<?php echo esc_url($boxvariables['boximage']); ?>"></div>
                                </a>
                                <div class="pagecontent">
                                    
                                        <a href="<?php echo esc_url($boxvariables['url']); ?>">
                                            <h4><?php echo esc_html($boxvariables['box_title']); ?></h4>
                                        </a>
                                    
                                    <!--top-resourcebox-->
                                    <div class="resourcebox">
                                        <p><?php
                                            $boxid = esc_attr($boxvariables['boxid']);
                                            echo esc_html(study_education_lite_get_excerpt($boxid, 150));
                                            ?></p>
                                        
                                        <!--resourcebutton-->
                                    </div>
                                    <a class="rdmore fourreadmore pagemore" href="<?php echo esc_url($boxvariables['url']); ?>"><?php echo esc_html__('Read More', 'study-education-lite') ?> &nbsp; &nbsp; &nbsp; &nbsp; <i class="fa fa-angle-right"></i>
</a>
                                </div>
                                <!--mainresourcebox-->
                            </div>
                            <!--topboxbg-->
                        </div>

                    <?php } ?>
                </div>
                <!--box-equal-height-->
            </div><!-- middle-align -->
            <div class="clear"></div>
        </div><!-- container -->
    </section>
<?php } ?>