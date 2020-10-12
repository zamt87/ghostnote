<?php
get_header();

    $filteredNotes = new WP_Query(
        array(
            'posts_per_page' => -1,
            'post_type' => 'note',
            'tax_query' => array(
                array(
                    'taxonomy' => 'category',
                    'field' => 'slug',
                    'terms' => array('copyright','cultural-heritage')
                )
            )
        )
    );

    
    echo '<div class="wrapper">';

    if($filteredNotes->have_posts()){
        
            echo '<div class="cards_wrap">';
              echo '<div class="cards_wrap_inner">';
                while($filteredNotes->have_posts()){
                    $filteredNotes->the_post(); ?>
                        <div class="card_item <?php $categories = get_the_category();
                                if (!empty($categories)){
                                    foreach($categories as $category){
                                        echo $category->slug . ' ';
                                    }
                                }
                            ?>"
                        >
                            <a href="#">
                                    <div class="card_inner">
                                        
                                            <div class="card_top">
                                                <?php 
                                                    $categories = get_the_category();
                                                    if (!empty($categories)){
                                                        foreach($categories as $category){
                                                            echo $category->name . ' ';
                                                        }
                                                    }
                                                ?>
                                            </div>
                                            
                                            <div class="card_bottom">
                                                <div class="card_title">
                                                    <h1 class="article-title"><?php the_title(); ?></h1>
                                                </div>
                                                
                                                <div class="card_content">
                                                    
                                                </div>
                            
                                            </div>
                                                   
                                            <span class="card_read-more hide">
                                                Read More
                                            </span>
                                        
                                    </div>
                            </a>
                        </div>
                      
                <?php }
            echo '</div>';
          echo '</div>';
        
    }
    echo '</div>';
    
get_footer();
?>
