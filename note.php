Gutenberg: 
    metabox1.wpengine.com
    metabox7.wpengine.com → metabox1dev.wpengine.com
    metabox13.wpengine.com
    metabox15.wpengine.com → metabox13dev.wpengine.com
Bricks:
    metabox5.wpengine.com
    metabox22.wpengine.com/
    metabox29.wpengine.com → metabox22dev.wpengine.com
Oxygen
    metabox6.wpengine.com
    metabox03.wpengine.com → metabox6dev.wpengine.com
Zion:
    x12.wpengine.com 
Elementor
    metabox2.wpengine.com
    metabox8.wpengine.com → metabox2dev.wpengine.com
    metabox10.wpengine.com
    metabox2stg.wpengine.com
Brizy
    metabox21.wpengine.com
Breakdance
    metabox14.wpengine.com
    metabox17.wpengine.com→ metabox14dev.wpengine.com
Kadence
    metabox4.wpengine.com
    metabox1stg.wpengine.com
Beaver Builder
    https://metabox28.wpengine.com/ →  metabox4dev.wpenginepowered.com
Divi:
    metabox21.wpengine.com → metabox4stg.wpengine.com

Genesis block : metabox14stg.wpengine.com
Restricted Account: user: demo, password: Admin123
wp-admin Account: user: admin, password: luoibieng

Khi Oxygen không update được thì vào save lại License xong là update là được
jQuery(function($) {
    // Mã bên trong này sẽ chỉ chạy sau khi DOM đã sẵn sàng
    //$ là biểu tượng thay thế cho đối tượng jQuery. Khi bạn viết $(selector), bạn đang gọi một phương thức của jQuery để tìm phần tử HTML với bộ chọn selector
    $('#my-element').hide(); // Ẩn phần tử có id là "my-element"
});

<div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
        {% for clone in post.homepage_fields %}

        <div class="carousel-item {% if loop.first %}active{% endif %}">
            
            <img src="{{ clone.single_image.full.url }}" width="{{ clone.single_image.full.width }}" height="{{ clone.single_image.full.height }}" alt="{{ clone.single_image.full.alt }}">
            <div class="container">
                <div class="carousel-caption  {% if loop.first %}text-start{% endif %} {% if loop.last %}text-end{% endif %}">
                    <h1>{{ clone.title }}</h1>
                    <p>{{ clone.description }}</p>
                    <p><a class="btn btn-lg btn-primary" href="{{ clone.button_link }}">{{ clone.button_text }}</a></p>
                </div>
            </div>
        </div>
        {% endfor %}
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
</div>

<?php

function justread_custom_scripts() {
    $terms = get_terms( array(
        'taxonomy'   => 'location',
        'hide_empty' => false,
    ) );
    foreach ( $terms as $term ) {
        $location[] = $term->name;
    }
    $object = [
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'location_autocomplete' => $location,
    ];

    
    wp_enqueue_script( 'justread-ajax-filter-hotel', get_stylesheet_directory_uri() . '/js/filter-hotel.js', array( 'jquery' ), '', true );
    wp_localize_script( 'justread-ajax-filter-hotel', 'ajax_object', $object );
}
add_action( 'wp_enqueue_scripts', 'justread_custom_scripts' );

function justread_filter_hotel() {

    $location = $_POST['location'];
    $query_arr = array(
        'post_type' => 'hotel',
        'post_status' => 'publish',
        'tax_query' => array(
            array(
                'taxonomy' => 'location',
                'field'    => 'name',
                'terms'    => array( $location ),
                'operator' => 'IN',
            ),
        ),
    );
    $query = new WP_Query( $query_arr );

    if ( $query->have_posts() ) :
       
        while ( $query->have_posts() ) : $query->the_post();
             $posts = the_title();
            

            // get_template_part( 'content', get_post_format() );

        endwhile;
       
    else :
        $posts = '<h1>' . __( 'No post', 'justread' ) .'</h1>';
    endif;

    $return = array(
        'post' => $posts,
    );
    wp_send_json( $return );
}
add_action( 'wp_ajax_justread_filter_hotel', 'justread_filter_hotel' );
add_action( 'wp_ajax_nopriv_justread_filter_hotel', 'justread_filter_hotel' );

?>


Creating taxonomy thumbnails & featured Images

MB Views

{% set args = {taxonomy: 'portfolio-type',hide_empty: false} %}
{% set portfolios = mb.get_terms( args ) %}
<div class="portfolio container">
    <h1 class="heading-title">Portfolio</h1>
    <div class="thumbnail-images">
    {% for portfolio in portfolios %}
        <div class="item">
            <div class="overlay-thumbnail-categories">
                {% set image_upload = mb.get_term_meta( portfolio.term_id, 'upload_portfolio_thumbnail', true ) %}
                {% set image_url = mb.get_term_meta( portfolio.term_id, 'url_portfolio_thumbnail', true ) %}
                {% if image_upload %}
                    {% set image_upload_link = mb.wp_get_attachment_image_src( image_upload, large) %}
                    <div class="thumbnail" style="background-image:url({{ image_upload_link [0] }})"></div>
                    <img src="{{ image_upload_link[0] }}">
                {% elseif image_url %}
                    <div class="thumbnail" style="background-image:url({{ image_url }})"></div>
                    <img src="{{ image_url }}">
                {% else %}
                    <img src="http://demo1.elightup.com/test-metabox/wp-content/uploads/2020/11/oriental-tiles.png">
                {% endif %}
            </div>
            <div class="category-title">
                <div class="category-name">{{ portfolio.name }}</div>
                <p class="description">
                    {{ portfolio.description }}
                </p>
                <a href="{{ mb.get_category_link( portfolio.term_id ) }}" target="_blank" rel="noopener">View More</a>
            </div>
        </div>
    {% endfor %}
    </div>
</div>


<style type="text/css">
    
.archive.tax-portfolio-type #content.container {
    max-width: 100%;
}
.archive.tax-portfolio-type #content.container .thumbnail-cat{
    width: 100%;
    height: 400px;
    object-fit: cover;
}
.archive.tax-portfolio-type #content.container .page-title,
.archive.tax-portfolio-type #content.container .archive-description,
.archive.tax-portfolio-type #content.container .entries{
     max-width: var(--container);
    margin-inline: auto;
    padding-left: 12px;
    padding-right: 12px;
}
</style>

<?php
    
    $current_term = get_queried_object();
    if ( $current_term->taxonomy == 'portfolio-type' ){
        $terms= get_the_terms( $post->ID, 'portfolio-type');
        $background_image = get_term_meta( $terms[0]->term_id, 'upload_portfolio_thumbnail', true );
        if ($background_image) {
            $link_image = wp_get_attachment_image_src( $background_image, 'full' );
            $link_image_source = $link_image[0];
        }
        else {
            $link_image_source = get_term_meta( $terms[0]->term_id, 'url_portfolio_thumbnail', true );
        }
        if ( !empty( $terms ) ){
            $term = array_shift( $terms );
        }
    }
    
?>
<div class="port-thumbnail">
    <img class="thumbnail-cat" src="<?php echo $link_image_source ?>">
</div>


{% set args = {taxonomy: 'portfolio-type',hide_empty: false} %}
{% set portfolios = mb.get_terms( args ) %}
<div class="portfolio container">
    <h1 class="heading-title">Portfolio</h1>
    <div class="thumbnail-images">
    {% for portfolio in portfolios %}
        <div class="item">
            <div class="overlay-thumbnail-categories">
                {% set image_upload = mb.get_term_meta( portfolio.term_id, 'upload_portfolio_thumbnail', true ) %}
                {% set image_url = mb.get_term_meta( portfolio.term_id, 'url_portfolio_thumbnail', true ) %}
                {% if image_upload %}
                    {% set image_upload_link = mb.wp_get_attachment_image_src( image_upload, large) %}
                    <div class="thumbnail" style="background-image:url({{ image_upload_link [0] }})"></div>
                    <img src="{{ image_upload_link[0] }}">
                {% elseif image_url %}
                    <div class="thumbnail" style="background-image:url({{ image_url }})"></div>
                    <img src="{{ image_url }}">
                {% else %}
                    <img src="https://metabox.io/wp-content/uploads/2020/03/MB-Views-extension.jpg">
                {% endif %}
            </div>
            <div class="category-title">
                <div class="category-name">{{ portfolio.name }}</div> 
                <p class="description">
                    {{ portfolio.description }}
                </p>
                <a href="{{ mb.get_category_link( portfolio.term_id ) }}" rel="noopener">View More</a>
            </div>
        </div>
    {% endfor %}
    </div>
</div>





@import url('https://fonts.googleapis.com/css2?family=Karla:wght@300;400;500;700&display=swap');
.thumbnail-images .item .overlay-thumbnail-categories .thumbnail {
    position: absolute;
    width: 100%;
    height: 100%;
    /* background-color: #00b1b3; */
    z-index: 1;
    left: -30px;
    top: 30px;
    background-size: 100% 100%;
    filter: drop-shadow(0.35rem 0.35rem 0.4rem rgba(0, 0, 0, 0.5));
    opacity: 0.5;
    border-radius: 10px;
}
.thumbnail-images {
    display: flex;
    flex-direction: column;
}
.portfolio.container {
    max-width: 1240px;
    margin: 20px auto 50px;
    width: 100%;
    padding: 0 20px;
    font-family: 'Karla';
}
.thumbnail-images .item {
    display: inline-flex;
    flex-direction: row;
    align-items: center;
    margin-bottom: 50px;
    justify-content: center;
}
.thumbnail-images .item .overlay-thumbnail-categories img {
    max-width: 400px;
    min-height: 400px;
    object-fit: cover;
    position: relative;
    vertical-align: top;
    z-index: 2;
    border-radius: 10px;
}
.thumbnail-images .item:nth-child(2n) .overlay-thumbnail-categories {
    text-align: right;
    margin-right: 0;
}
.thumbnail-images .item:nth-child(2n) {
    flex-direction: row-reverse;
}
.thumbnail-images .item:nth-child(2n) .category-title {
    padding-left: 0;
    margin-right: 40px;
}
.thumbnail-images .item .overlay-thumbnail-categories {
    margin-right: 40px;
    position: relative;
}
.thumbnail-images .item .category-title .category-name,
.thumbnail-images .item .category-title .description {
    max-width: 400px;
    width: 100%;
}
.thumbnail-images .item:nth-child(2n) .overlay-thumbnail-categories .thumbnail {
    right: -30px;
    left: auto;
}
.thumbnail-images .item .category-title .category-name {
    font-size: 40px;
}
.thumbnail-images .item .category-title .description {
    font-size: 17px;
}
.portfolio.container .heading-title {
    text-align: center;
    margin-bottom: 20px;
    font-size: 65px;
}
.thumbnail-images .item .category-title a {
    color: #fff;
    background-color: #f25252;
    padding: 10px 20px;
    border-radius: 3px;
    transition: all 0.3s;
    text-transform: uppercase;
    border: 1px solid #f25252;
    width: max-content;
}
.thumbnail-images .item .category-title {
    display: inline-flex;
    flex-direction: column;
}
.thumbnail-images .item .category-title a:hover {
    color: #f25252;
    background-color: #fff;
}
@media and (max-width:991px) {
    .thumbnail-images .item {
        flex-direction: column;
    }

    .thumbnail-images .item .overlay-thumbnail-categories {
        margin-right: 0;
    }

    .thumbnail-images .item:nth-child(2n) {
        flex-direction: column;
    }

    .thumbnail-images .item:nth-child(2n) .category-title {
        margin-right: 0;
    }

    .thumbnail-images .item .overlay-thumbnail-categories .thumbnail {
        display: none;
    }

    .thumbnail-images .item .category-title .description {
        margin-top: 0;
    }
}

// php meta box block
add_filter( 'rwmb_meta_boxes', function( $meta_boxes ) {
    $meta_boxes[] = [
        'title' => 'Contact Us with PHP',
        'id'    => 'contact-with-php',
        'type'  => 'block', // Important.
        'icon'  => 'email', // Or you can set a custom SVG if you don't like Dashicons
        'category' => 'layout',
        'context' => 'side', // The block settings will be available on the right sidebar.
        'supports' => [
          'align' => ['wide', 'full'],
        ],
        'render_template' => get_stylesheet_directory() . '/blocks/contact/template.php', // The PHP template that renders the block.
        'enqueue_style'   => get_stylesheet_directory_uri() . '/blocks/contact/style.css', // CSS file for the block.
        // Now register the block fields.
        'fields' => [
            [
                'type' => 'text',
                'id'   => 'title',
                'name' => 'Title',
            ],
            [
                'type' => 'textarea',
                'id'   => 'description',
                'name' => 'Description',
            ],
            [
                'id'   => 'contact_information',
                'type' => 'group',
                'name'   => 'Contact Information',
                'clone'  => true,
                'max_clone'=> 3,            
                'fields' => [                    
                    [
                        'type' => 'single_image',
                        'id'   => 'icon',
                        'name' => 'Icon',
                    ],
                    [
                        'type' => 'text',
                        'id'   => 'name',
                        'name' => 'Name',
                    ],
                    [
                        'type' => 'textarea',
                        'id'   => 'content',
                        'name' => 'Content',
                    ],
                ],        
            ],
        ],
    ];
    return $meta_boxes;
} );











{% if term.taxonomy == 'portfolio-type' %}
<div class="port-thumbnail">
    <div class="thumbnail-cat">
        {% set image_upload = term.upload_portfolio_thumbnail.full.url %}
        {% set image_url = term.url_portfolio_thumbnail %}
        {% if image_upload %}
            <img src="{{ image_upload }}">
        {% elseif image_url %}                  
            <img src="{{ image_url }}">
        {% else %}
            <img src="https://metabox.io/wp-content/uploads/2020/03/MB-Views-extension.jpg">
        {% endif %}
    </div>          
</div>
{% endif %}


.archive.tax-portfolio-type #content.container {
    max-width: 100%;
}

.archive.tax-portfolio-type #content.container .thumbnail-cat img {
    width: 100%;
    height: 600px;
    object-fit: cover;
}

.archive.tax-portfolio-type #content.container .page-title,
.archive.tax-portfolio-type #content.container .archive-description,
.archive.tax-portfolio-type #content.container .entries {
    max-width: var(--container);
    margin-inline: auto;
    padding-left: 12px;
    padding-right: 12px;
}



#gallery image
<?php
function get_image() {

    $images = rwmb_meta( 'image_gallery', ['size' => 'large'] );
    foreach ( $images as $image ) : ?>
        <img src="<?= $image['url']; ?>" alt="<?= $image['alt'] ?>">
    <?php endforeach;
}
add_shortcode( 'gallery_image', 'get_image' );

?>


#215 p1 dynamic banner
{% set settings = mb.get_option( 'banner' ) %}

{% if( settings.show == 1) %}
    {% set image_ids = settings.image %}
    {% set image_attributes = mb.wp_get_attachment_image_src( image_ids, 'full') %}
    <div class="banner" style="width:{{ settings.width }} ; background-image: url(' {{ image_attributes[0] }} ' )">
        <div class= "content-banner">
            <h2 style="color:{{ settings.color }} " class="title-banner {{ settings.titles_position }} "> {{ settings.title }} </h2>
            <div style="color: {{ settings.description_color }} " class="description-banner {{ settings.descriptions_position }} ">{{ settings.description }}</div>
        </div>
    </div>
{% endif %}




<?php
function short_code_banner() {
    // Banner
    $settings = get_option( 'banner' ); 
    $image_ids = $settings['image'];
    $show = $settings['show']; 
    $image_attributes = wp_get_attachment_image_src( $image_ids, 'full');

    $title = rwmb_meta( 'title', ['object_type' => 'setting'], 'banner' );
    $description = rwmb_meta( 'description', ['object_type' => 'setting'], 'banner' );

    $titles_position = rwmb_meta( 'titles_position', ['object_type' => 'setting'], 'banner' );
    $descriptions_position = rwmb_meta( 'descriptions_position', ['object_type' => 'setting'], 'banner' );

    $color = rwmb_meta( 'color', ['object_type' => 'setting'], 'banner' );
    $description_color = rwmb_meta( 'description_color', ['object_type' => 'setting'], 'banner' );

    $width = rwmb_meta( 'width', ['object_type' => 'setting'], 'banner' );

    $html = '';
    if ( $show == 1 ) { 
        $html .= '<div class="banner" style="width: ' . $width . ' ; background-image: url(' .  $image_attributes[0]  . ' )">';
            $html .= '<div class= "content-banner"> ';

                $html .= '<h2 style="color: ' . $color . ' " class="title-banner ' . $titles_position . ' ">' . $title . '</h2>';

                $html .= '<div style="color: ' . $description_color . ' " class="description-banner ' . $descriptions_position . ' ">' . $description . '</div>';

            $html .= '</div>';
        $html .= '</div>';
    }

    return $html;
}
add_shortcode( 'banner-shortcode', 'short_code_banner' );

?>

<style>
.main .content-banner h2 {
    font-size: 40px;
}
.main .content-banner div {
    font-size: 35px;
}
.main .banner {
    height: 400px;
}
.banner {
    position: relative;
    height: 250px;
    background-repeat: no-repeat!important;
    background-size: cover;
    background-position: center;
}

.banner .left {
    text-align: left;
}

.banner .right {
    text-align: right;
}

.banner .center {
    text-align: center;
}

.content-banner {
    width: 50%;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
</style>

//  MB Blocks 
<div class="mb-main-restaurant">
    {% if title %}
        <div class="title-menu"> {{ title }} </div>
        <div class="mb-line"></div>
        <div class="description-menu">{{ description }} </div>
    {% endif %}
    <div class="food-list">
        {% for clone in menu %}
            <div class="food-item">
                <div class="img-food"> {{ mb.wp_get_attachment_image( clone.image,'thumbnail' ) }} </div>
                <div class="wapper-item">
                    <div class="name-food"> {{ clone.food_name }} </div>
                    <div class="price-food"> {{ clone.price }} </div>
                </div>
                <div class="ingredient-food"> {{ clone.ingredient }} </div>
            </div>
        {% endfor %}
    </div>
</div>

<style>
    .title-menu{
        font-size: 32px;
        text-align: center;
        font-weight: bold;
        color: #1a1919;
    }
    .description-menu{
        margin-top: 20px;
        font-size: 18px;
        text-align: center;
        color: #1a1919;
    }
    .title-menu {
        height: 50px;
        top: 25px;
        transform: translateX(-50%);
        left: 50%;
        position: relative;
        background: #fff;
        width: 130px;
        font-size: 32px;
        text-align: center;
        font-weight: bold;
        color: #b14411;
    }
    .mb-line{
        height: 3px;
        background: #b14411;
    }
    .food-list{
        display: flow-root;
        margin-top: 50px;
    }
    .food-item {
        width: 50%;
        float: left;
        margin-bottom:50px;
    }
    .ingredient-food{
        margin-right:150px;
    }
    .img-food{
            display: block;
        float: left;
    }
    .img-food img{
        border-radius:50%;
        margin: 5px 30px 0 0;
    }
    .name-food{
        font-size: 22px;
        font-weight: bold;
        color: #1a1919;
    }
    .wapper-item{
        position:relative;
        display: flex;
    }
    .price-food{
        position: absolute;
        left: 220px;
        font-size:18px;
    }
    .editor-styles-wrapper .wp-block {
        max-width: 1200px!important;
    }
</style>






<div class="mb-main-address">
    {% for clone in address_brand %}
        <div class="add-item">
            <div class="title-restaurant">
                {{ mb.wp_get_attachment_image( clone.icon ,'thumbnail' ) }}
                <div class="name-restaurant">{{ clone.restaurant }}</div>
            </div>
            <div class="name-restaurant2">{{ clone.restaurant_description }}</div>
            <div class="address-restaurant">{{ clone.address }}</div>
            <div class="number-phone">{{ clone.number_phone }}</div>
            <div class="email-address">{{ clone.email }}</div>
            <div class="social-address">
                {% for clone1 in clone.social %}
                    <a href="{{ clone1.1 }}" class="fa fa-{{ mb.strtolower(clone1.0) }}"></a>   
                {% endfor %}
            </div>
        </div>      
    {% endfor %}
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
    .mb-main-address {
        width: 100%;
        display: flex;
        color: #fff;
        background: #2c3e50;
    }
    .address-restaurant {
        padding-right: 150px;
        font-size: 15px;
        color: #9f9c9c;
        margin-bottom:20px;
    }
    .name-restaurant{
        font-size:30px;
        margin-bottom: 20px;
    }
    .name-restaurant2, .title-restaurant, .number-phone, .email-address{
        margin-bottom:20px;
    }
        .add-item {
        padding: 30px 60px;
        width: 50%;
        float: left;
    }
    .title-restaurant{
        display: flex;
    }
    .title-restaurant img{
        float: left;
        width: 25px;
        height: 35px;
        margin-right: 10px;
        background: #fff;
    }
    .mb-main-address .social-address .fa {
        width: 40px!important;
        margin-right: 20px;
        border: 1px solid #00b1b3;
        color: #00b1b3;
        border-radius: 50%;
        padding: 10px;
        text-align: center;
        text-decoration: none;
    }
    .editor-styles-wrapper .wp-block {
        max-width: 1200px!important;
    }
</style>





<div class="mb-main-contact">
    <div class="ct_title"> {{ title }} </div>
    <div class="ct_des">{{ description }} </div>
    <div class="contact-info">
        {% for clone in contact_information %}
            <div class="ct-item">
                {{ mb.wp_get_attachment_image( clone.icon,'thumbnail' ) }}                   
                <div class="ct-title">{{ clone.name }} </div>        
                <div class="ct-description"> {{ clone.content }} </div>
            </div>
        {% endfor %}
    </div>
</div>

<style>
.ct_title{
    margin-top:50px;
    color: #2e2424;
    font-weight: bold;
    font-size: 40px;
}
.ct_des{
    padding: 0 28%;
}
.ct_title, .ct_des{
    text-align: center;
}
.ct-item {
    text-align: center;
    width: 33%;
    float: left;
}
.ct-item img {
    width: 50px;
    height: auto;
    background: #fff;
}
.contact-info {
    margin-top: 50px;
    display: flex;
}
.ct-title {
    text-transform: uppercase;
    color: #726f6f;
    font-weight: bold;
}
.editor-styles-wrapper .wp-block {
    max-width: 1200px!important;
}
</style>




<?php
add_filter( 'rwmb_meta_boxes', function( $meta_boxes ) {
    $meta_boxes[] = [
        'title' => 'Contact Us with PHP',
        'id'    => 'contact-with-php',
        'type'  => 'block', // Important.
        'icon'  => 'email', // Or you can set a custom SVG if you don't like Dashicons
        'category' => 'layout',
        'context' => 'side', // The block settings will be available on the right sidebar.
        'supports' => [
          'align' => ['wide', 'full'],
        ],
        'render_template' => get_stylesheet_directory() . '/blocks/contact/template.php', // The PHP template that renders the block.
        'enqueue_style'   => get_stylesheet_directory_uri() . '/blocks/contact/style.css', // CSS file for the block.
        // Now register the block fields.
        'fields' => [
            [
                'type' => 'text',
                'id'   => 'title',
                'name' => 'Title',
            ],
            [
                'type' => 'textarea',
                'id'   => 'description',
                'name' => 'Description',
            ],
            [
                'id'   => 'contact_information',
                'type' => 'group',
                'name'   => 'Contact Information',
                'clone'  => true,
                'max_clone'=> 3,            
                'fields' => [                    
                    [
                        'type' => 'single_image',
                        'id'   => 'icon',
                        'name' => 'Icon',
                    ],
                    [
                        'type' => 'text',
                        'id'   => 'name',
                        'name' => 'Name',
                    ],
                    [
                        'type' => 'textarea',
                        'id'   => 'content',
                        'name' => 'Content',
                    ],
                ],        
            ],
        ],
    ];
    return $meta_boxes;
} );


?>
<?php
/**
 * The template file to display the block.
 *
 * Available parameters:
 * @param array $attributes The block attributes.
 * @param bool  $is_preview Whether in the preview mode.
 */

// Fields data. 
if ( empty( $attributes['data'] ) ) {
    return;
}

?>

<div class="mb-main-contact">
    <div class="ct_title"><?php mb_the_block_field( 'title' ); ?>  </div>
    <div class="ct_des"><?php mb_the_block_field( 'description' ); ?> </div>
    <div class="contact-info">
        <?php 
        $contacts = mb_get_block_field( 'contact_information' ); 
        foreach ($contacts as $contact) :       
            $image_id = $contact[ 'icon' ] ?? 0;
            $image = RWMB_Image_Field::file_info( $image_id, [ 'size' => 'thumbnail' ] ); ?>
        
            <div class="ct-item">
                <img src="<?= $image['url'];?>" alt="">                
                <div class="ct-title"><?= $contact['name'];?> </div>        
                <div class="ct-description"> <?= $contact['content'];?></div>
            </div>
        <?php endforeach; ?>
    </div>
</div>



.ct_title{
    margin-top:50px;
    color: #2e2424;
    font-weight: bold;
    font-size: 40px;
}
.ct_des{
    padding: 0 28%;
}
.ct_title, .ct_des{
    text-align: center;
}
.ct-item {
    text-align: center;
    width: 33%;
    float: left;
}
.ct-item img {
    width: 50px;
    height: auto;
    background: #fff;
}
.contact-info {
    margin-top: 50px;
    display: flex;
}
.ct-title {
    text-transform: uppercase;
    color: #726f6f;
    font-weight: bold;
}
.editor-styles-wrapper .wp-block {
    max-width: 1200px!important;
}

<?php
// custom query show end startdate and enddate

add_action('elementor/query/my_custom_filter_event', function($query){ 
    $query->set( 'post_type', [ 'event' ] );
    
    $meta_query = [
        'relation' => 'OR',
        [
            'relation' => 'AND',
            [
                'key' => 'end_date',
                'value' => date( 'Y-m-d', current_time( 'timestamp' ) ),
                'compare' => '<=',
            ],
            [
                'key' => 'start_date',
                'value' => date( 'Y-m-d', current_time( 'timestamp' ) ),
                'compare' => '>=',
            ],
        ],
        [
            'key' => 'end_date',
            'value' => date( 'Y-m-d', current_time( 'timestamp' ) ),
            'compare' => '>=',
        ]
    ];
    $query->set( 'meta_query', $meta_query );
});

// hoặc dùng đoạn này để check cả trường hợp không có ngày bắt đầu chỉ có ngày kết thúc
add_action('elementor/query/my_custom_filter', function($query) {
    $query->set('post_type', ['arrangement']);

    $meta_query = [
        'relation' => 'OR',
        [
            'relation' => 'AND',
            [
                'key' => 'start_dato',
                'value' => date('d. M y', current_time('timestamp')),
                'compare' => '<=',
            ],
            [
                'key' => 'slut_dato',
                'value' => date('d. M y', current_time('timestamp')),
                'compare' => '>=',
            ],
        ],
        [
            'relation' => 'AND',
            [
                'key' => 'start_dato',
                'value' => date('d. M y', current_time('timestamp')),
                'compare' => '>=',
            ],
            [
                'key' => 'slut_dato',
                'compare' => 'NOT EXISTS', // Sjekker om sluttdato ikke eksisterer
            ],
        ],
    ];
    $query->set('meta_query', $meta_query);
});
?>
https://brickslabs.com/posts-grouped-by-acf-select-field-value-as-tabs-in-bricks/
https://brickslabs.com/custom-meta-box-thumbnail-slider-in-wordpress/
https://brickslabs.com/meta-box-category-colors-in-single-posts/
https://brickslabs.com/nested-meta-box-query-loop-inside-a-cpt-query-loop-in-bricks/
https://brickslabs.com/dynamic-multiple-galleries-in-bricks-using-meta-box/



https://brickslabs.com/dynamic-source-for-video-element-in-bricks-using-meta-box-post-field/
https://brickslabs.com/post-specific-footers-in-bricks-using-meta-box/


<?php
add_action('elementor/query/my_custom_filter', function($query){ 
    $query->set( 'post_type', [ 'restaurant' ] );

$query = new WP_Query( array(
    'meta_key' => 'post_views_count',
    'orderby' => 'meta_value_num',
    'posts_per_page' => 5
) );
});

?>

 most view restaurant 
 <?php
function my_query_filter_most_views( $query ) {
    $query->set( 'orderby', 'meta_value_num' );
    $query->set( 'meta_key', 'entry_views' );
    $query->set( 'order', 'DESC' );
}
add_action( 'elementor/query/custom_filter', 'my_query_filter_most_views' );
?>

hoặc kiểu này với MB Views

{% set args = { post_type: 'restaurant', posts_per_page: 6, orderby: 'meta_value', meta_key: 'entry_views', order: 'DESC' } %}
{% set posts = mb.get_posts( args ) %}
{% for post in posts %}

{{ post.title }}
<br/>
    
{% endfor %}


Show Upcoming Events + Elementor

heading: color: #525252 font 28 marrgin 10 0 10 0

icon space 10   color: #BE4104 size: 18   text size 18 font-wold=blod color #696E74

icon space 10   color: #BE4104 size: 20   text size 20 font-wold=blod color #9A9FA3

heading marrgin 20 0 20 0


loop betw 0 0
<?php
add_action('elementor/query/filter_events', function($query) {
    $current_datetime = current_datetime()->format('Y-m-d');
    $query->set('post_type', ['event']);
     $meta_query [] = [    
       'relation' => 'OR',
       [
            'key' => 'start_date',
            'value' => date($current_datetime),
            'compare' => '>=', 
        ],
        [
            'key' => 'end_date',
            'value' => date($current_datetime),
            'compare' => '>=', 
        ]  
    ];
    $query->set('meta_query', $meta_query);
});

?>
#FAQ MB blocks 
<div class="mb-faqs">
    {% for clone in faqs_group %}
        <div class="item-faq">                           
            <div class="mb-question">{{ clone.question }} </div>  
            <div class="mb-answer">{{ clone.answer }} </div>            
        </div>
    {% endfor %}
</div>

<style>
  .item-faq {
     margin-bottom: 25px;
    }
    .mb-question {
      background: #bfbfbf;
      padding: 10px 10px;
      font-weight: bold;
      font-size: 20px;
      color: #000;
  }
  .mb-answer {
      padding: 10px;
      font-size: 18px;
  }
</style>


# create button download and preview with Kadence
image size 3:4

section padding xxs

title font 19 margin botton xxs

excerp limit 12

bott download  padding top xxs, padding bottm xxs
text background #ffa100, full


text2 background #fa4362, full

<?php


add_action( 'estar_entry_footer_before', 'estar_child_add_link' );
add_shortcode( 'estar_button_download', 'estar_child_add_link');
function estar_child_add_link() {    
        $files = rwmb_meta( 'file_download' );
        foreach ( $files as $file ) : ?>

        <a class="document_link" href="<?php echo $file['url'] ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
            Download Document
        </a>

        <?php endforeach;
}
?>
#Upcoming event with MB Views
{% set args = { post_type: 'event', posts_per_page: -1 } %}
{% set posts = mb.get_posts( args ) %}
    {% for post in posts %}
      
    {% if post.end_date  >=  mb.date('Y-m-d') %}
            {{ post.title }} </br>
            {{ post.end_date | date( 'h:i A' ) }} </br>
              
        {% endif %}        

    {% endfor %} 



<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

<div class="mb-container">
    <h1 id="mb_header" class="md_headline">Upcoming Events</h1>
    {% set args = { post_type: 'event', posts_per_page: -1 } %}
    {% set posts = mb.get_posts( args ) %}
    <div class="mb-dynamic-list"> 
        {% for post in posts %}
            {% if post.end_date  >=  mb.date('Y-m-d') %}
                <div class="mb-block"> 
                    <img src="{{ post.thumbnail.large.url }}" width="{{ post.thumbnail.large.width }}" height="{{ post.thumbnail.large.height }}" alt="{{ post.thumbnail.large.alt }}">
                    <div class="mb_content">
                        <div class="mb_title">{{ post.title }} </div>
                        <div class="mb_startdate">
                            <i class="fa fa-calendar"></i>
                            {{ post.start_date | date( 'Y-m-d' ) }}
                        </div>
                        <div class="mb_enddate">
                            <i class="fa fa-calendar"></i>
                            {{ post.end_date | date( 'Y-m-d' ) }} 
                        </div>
                        <div class="mb_location">
                            <i class="fa fa-location-arrow"></i>
                            {{ post.location }} 
                        </div>
                    </div>
                </div>
            {% endif %}        
        {% endfor %} 
    </div>
</div>




{% set args = { post_type: 'event', posts_per_page: -1 } %}
{% set posts = mb.get_posts( args ) %}
{% for post in posts %}
    {% if post.end_date  >=  mb.date('Y-m-d') %}    
         <img src="{{ post.thumbnail.large.url }}" width="{{ post.thumbnail.large.width }}" height="{{ post.thumbnail.large.height }}" alt="{{ post.thumbnail.large.alt }}">
        {{ post.title }}
        {{ post.start_date | date( 'Y-m-d' ) }}
        {{ post.end_date | date( 'Y-m-d' ) }} 
        {{ post.location }} 
    {% endif %}   
{% endfor %} 



code CSS  
.mb-dynamic-list {
    display: flex !important;
    flex-direction: row;
    flex-wrap: wrap;
    width: 100%;
}
#mb_header {
    text-align: center;
    margin: 50px 0 40px 0;
    text-transform: uppercase;
}
.mb_content {
    line-height: 2;
}
.mb-block {
    flex-direction: column;
    display: flex;
    text-align: left;
    align-items: flex-start;
    gap: 5px;
    width: 33.33%;
    padding-left: 10px;
    padding-right: 10px;
    margin-bottom: 30px;
}
.mb_title {
    display: inline-block;
    text-decoration: inherit;
    font-family: Inherit;
    font-size: 23px;
    font-weight: bold;
    margin-bottom: 10px;
    line-height: 1;
}
.mb_content .fa {
    font-size: 18px;
    color: #e9435a;
    margin-right: 7px;
}
.mb_startdate,
.mb_location,
.mb_enddate {
    color: #52565a;
    font-size: 17px;
    font-weight: 700;
}
.mb_content .mb_location {
    color: #999999;
    font-size: 20px;
    font-weight: 600;
}



#search-posts-by-taxonomy/
<?php
get_header(); ?>
    <div id="primary" class="content-area">
        <header class="page-header">
            <?php
            the_archive_title( '<h1 class="page-title">', '</h1>' );
            the_archive_description( '<div class="archive-description">', '</div>' );
            ?>
        </header>

        <div class="filter-hotel" style="margin-left:48px;">
            <p>Search Hotel</p>
            <input class="filter-input" id="location" type="" name="" placeholder="Location">
            <input class="filter-action" type="submit" name="" value="Search">
        </div>  
        
        <main id="main" class="site-main grid grid--3">
       
            <?php if ( have_posts() ) :
                while ( have_posts() ) : the_post();
                    get_template_part( 'template-parts/content', get_post_format() );
                endwhile;
            else :
                get_template_part( 'template-parts/content', 'none' );
            endif; ?>
            
        </main>
    </div>
<?php get_footer(); ?>
<?php

function justread_custom_scripts() {
    $terms = get_terms( array(
        'taxonomy'   => 'location',
        'hide_empty' => false,
    ) );
    foreach ( $terms as $term ) {
        $location[] = $term->name;
    }
    $object = [
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'location_autocomplete' => $location,
    ];

    wp_enqueue_style( 'style-jquery', '//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css', true );
    wp_enqueue_script( 'jquery-ui-library', 'https://code.jquery.com/ui/1.13.2/jquery-ui.js', array( 'jquery' ), '', true );
    wp_enqueue_script( 'justread-ajax-filter-hotel', get_stylesheet_directory_uri() . '/js/filter-hotel.js', array( 'jquery' ), '', true );
    wp_localize_script( 'justread-ajax-filter-hotel', 'ajax_object', $object );
}
add_action( 'wp_enqueue_scripts', 'justread_custom_scripts' );

function justread_filter_hotel() {
    $location = $_POST['location'];
    $query_arr = array(
        'post_type' => 'hotel',
        'post_status' => 'publish',
        'tax_query' => array(
            array(
                'taxonomy' => 'location',
                'field'    => 'name',
                'terms'    => array( $location ),
                'operator' => 'IN',
            ),
        ),
    );
    $query = new WP_Query( $query_arr );

    if ( $query->have_posts() ) :
        ob_start();
        while ( $query->have_posts() ) : $query->the_post();
            get_template_part( 'template-parts/content', get_post_format() );
        endwhile;
        $posts = ob_get_clean();
    else :
        $posts = '<h1>' . __( 'No post', 'justread' ) .'</h1>';
    endif;

    $return = array(
        'post' => $posts,
    );
    wp_send_json( $return );
}
add_action( 'wp_ajax_justread_filter_hotel', 'justread_filter_hotel' );
add_action( 'wp_ajax_nopriv_justread_filter_hotel', 'justread_filter_hotel' );

?>
jQuery( function ( $ ) {
    function filterHotel() {
        var location = ajax_object.location_autocomplete;
        $( '#location' ).autocomplete({
            source: location
        });

        $( '.filter-action' ).on( 'click', function() {
            var location = $( '#location' ).val();
            jQuery.ajax({
                url: ajax_object.ajax_url,
                type: "POST",
                data: {
                    action: 'justread_filter_hotel',
                    location: location,
                },
                success: function(response) {
                    $( '.site-main' ).html(response.post);
                }
            });
        } );
    }
    filterHotel();
} );


#Upcoming events - Breadace

return [
  'post_type' => 'event',
  'posts_per_page'=>-1,
  'meta_key'=> 'end_date',
  'meta_compare'=> '>=',
  'meta_value'=>date('Y-m-d'),
];


change RSS:
<?php
/* Remove ALL WP update notifications */
function remove_core_updates() {
    global $wp_version;
    return (object) array('last_checked' => time(), 'version_checked' => $wp_version,);
}

add_filter('pre_site_transient_update_core', 'remove_core_updates');
add_filter('pre_site_transient_update_plugins', 'remove_core_updates');
add_filter('pre_site_transient_update_themes', 'remove_core_updates');


    add_action( 'init', 'your_prefix_register_taxonomy' );
function your_prefix_register_taxonomy() {
    $args = [
        'label'  => esc_html__( 'My taxonomy', 'your-textdomain' ),
        'labels' => [
            'menu_name'                  => esc_html__( 'My taxonomy', 'your-textdomain' ),
            'all_items'                  => esc_html__( 'All My taxonomy', 'your-textdomain' ),
            'edit_item'                  => esc_html__( 'Edit My taxonomy', 'your-textdomain' ),
            'view_item'                  => esc_html__( 'View My taxonomy', 'your-textdomain' ),
            'update_item'                => esc_html__( 'Update My taxonomy', 'your-textdomain' ),
            'add_new_item'               => esc_html__( 'Add new My taxonomy', 'your-textdomain' ),
            'new_item'                   => esc_html__( 'New My taxonomy', 'your-textdomain' ),
            'parent_item'                => esc_html__( 'Parent My taxonomy', 'your-textdomain' ),
            'parent_item_colon'          => esc_html__( 'Parent My taxonomy', 'your-textdomain' ),
            'search_items'               => esc_html__( 'Search My taxonomy', 'your-textdomain' ),
            'popular_items'              => esc_html__( 'Popular My taxonomy', 'your-textdomain' ),
            'separate_items_with_commas' => esc_html__( 'Separate My taxonomy with commas', 'your-textdomain' ),
            'add_or_remove_items'        => esc_html__( 'Add or remove My taxonomy', 'your-textdomain' ),
            'choose_from_most_used'      => esc_html__( 'Choose most used My taxonomy', 'your-textdomain' ),
            'not_found'                  => esc_html__( 'No My taxonomy found', 'your-textdomain' ),
            'name'                       => esc_html__( 'My taxonomy', 'your-textdomain' ),
            'singular_name'              => esc_html__( 'My taxonomy', 'your-textdomain' ),
        ],
        'public'               => true,
        'show_ui'              => true,
        'show_in_menu'         => true,
        'show_in_nav_menus'    => true,
        'show_tagcloud'        => true,
        'show_in_quick_edit'   => true,
        'show_admin_column'    => false,
        'show_in_rest'         => true,
        'hierarchical'         => false,
        'query_var'            => true,
        'sort'                 => false,
        'rewrite_no_front'     => false,
        'rewrite_hierarchical' => false,
        'rewrite' => true
    ];
    register_taxonomy( 'my-taxonomy', [ 'post' ], $args );
}

/**
 * Meta Box- Add custom fields to RSS Feed
 *
 */

function prefix_add_custom_fields_to_feed($content) {
    if(is_feed()) {
        $post_id = get_the_ID();
            $price = rwmb_meta('price');
            $output = '<div><h3>Hotel Information</h3>';
            $output .= '<p><strong>Price:</strong> ' . $price . '</p>';

            $availability = rwmb_meta('availability');
            $output .= '<p><strong>Availability:</strong> ' . $availability . '</p>';
            $output .= '</div>'; 
        $content = $content.$output;
    }
    return $content;
}
add_filter('the_content','prefix_add_custom_fields_to_feed');


?>
#insert map
AIzaSyAI9kPkskayYti5ttrZL_UfBlL3OkMEbvs


function add_google_map() {
    $args = array(
        'zoom' => 14,
        'marker' => true,
    );
    $map = rwmb_meta( 'map', $args );
    echo $map;
}
add_action( 'estar_entry_content_after', 'add_google_map' );



#448 P3 404 not not_found
{% set group = attribute( site, '404-page' ) %}
<div class="error-page">
    <div class="error-image">
        <img src="{{ group.image.thumbnail.url }}" width="{{ group.image.thumbnail.width }}" height="{{ group.image.thumbnail.height }}" alt="{{ group.image.thumbnail.alt }}">
    </div>
    <div class="error-content">
        <p class="error-message">{{ group.message }}</p>
        <div class="error-button">
            {% for clone in group.button %}
                <a href="{{ clone.url }}" class="button-name">{{ clone.name }}</a>
            {% endfor %}
        </div>
    </div>
</div>


#CSS  
.error-page {
    display: flex;
}

.error-page {
    display: flex;
    gap: 30px;
    align-items: center;
}

.error-image {
    width: 40%;
}

p.error-message {
    font-size: 18px;
    font-weight: 500;
}

.error-button {
    display: flex;
    gap: 15px;
}

a.button-name {
    background: #000;
    padding: 12px;
    border-radius: 4px;
    color: #fff;
    text-decoration: none;
}



https://github.com/wpmetabox/mb-blocks.git

git clone https://github.com/wpmetabox/mb-blocks.git

git checkout feat-block-json



code bài video play list  
<div class="playlist-container">
    <div class="playlist-content">
        <p class="playlist-title">Playlist</p>
        <div id="video-playlist">
            {% for clone in post.video %}
                <div class="video">
                    <img src="https://img.youtube.com/vi/{{ clone.id }}/mqdefault.jpg"/>
                    <div movieurl="https://www.youtube.com/embed/" class="video-name" >{{ clone.title }}</div>
                </div> 
            {% endfor %}
        </div>
    </div>
    <div class="playlist-iframe">
        <iframe  id="videoarea" src="https://www.youtube.com/embed/{{post.video[0].id}}" 
        title="YouTube video player" frameborder="0" 
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
        allowfullscreen></iframe>
    </div>
</div>


{% for clone in post.video %}
    {{ clone.id }}
  {{ clone.title }}
{% endfor %}


CSS 
.playlist-container {
    display: flex;
    margin: 10px 0px;
    gap: 15px;
    align-items: center;
}

#playlist {
    display: table;
}

#playlist li {
    cursor: pointer;
    padding: 8px;
}

#video-playlist {
    max-height: 300px;
    overflow-y: scroll;
}

#playlist li:hover {
    color: blue;
}

#videoarea {
    width: 100%;
    aspect-ratio: 16/9;
}

.video {
    display: flex;
    gap: 10px;
    margin-bottom: 10px;
    transition: all 0.3s ease;
}

.video:hover {
    cursor: pointer;
}

.video img {
    width: 100px;
    aspect-ratio: 16/9;
    object-fit: cover;
}

.playlist-content {
    flex: 4;
}

.playlist-iframe {
    flex: 6;
}

.playlist-title {
    font-size: 18px;
    font-weight: bold;
}

.video-name {
    color: #555;

}

.video.active {
    transition: all 0.3s ease;
}

.video.active .video-name {
    color: #000;
    font-weight: 500;
}


JS  
jQuery(function ($) {
    $("#video-playlist .video").on("click", function () {
        $('.video').removeClass('active');
        $(this).addClass('active');
        $("#videoarea").attr({
            "src": $(this).find('.video-name').attr("movieurl"),
        })
    })
})


const readingProgress = document.querySelector('#reading-progress-fill');
document.addEventListener('scroll', function (e) {
    let w = (document.body.scrollTop || document.documentElement.scrollTop) / (document.documentElement.scrollHeight - document.documentElement.clientHeight) * 100;
    readingProgress.style.setProperty('width', w + '%');
});


Coming Soon Page + MB Views


code ở template khi chưa có thẻ div:
{% set group = attribute( site, 'coming-soon' ) %}
{{ group.background.full.url }} <br/>
{{ group.title }} <br/>
{{ group.description }} <br/>
{{ group.time | date( 'Y-m-d H:i' ) }} <br/>

code ở template khi đã có thẻ div:
{% set group = attribute( site, 'coming-soon' ) %}
<div id="main-comingsoon" data-time="{{ group.time | date( 'Y-m-d H:i' ) }}" style="background-image: url('{{ group.background.full.url }}')">
    <div class="cm-title">{{ group.title }}</div>
    <div class="cm-description">{{ group.description }}</div>
    <div id="run_countdown">
        <div class="item">
            <div id="set_day"></div>
            <p>Days</p>
        </div>
        <div class="item">
            <div id="set_hours"></div>
            <p>Hours</p>
        </div>
        <div class="item">
            <div id="set_minutes"></div>
            <p>Minutes</p>
        </div>
        <div class="item">
            <div id="set_second"></div>
            <p>Seconds</p>
        </div>       
    </div>    
</div>


Code trong tab CSS:
#main-comingsoon {
    position: fixed;
    background-size: cover;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    z-index: 9999;
}

.cm-title,
.cm-description {
    text-align: center;
    color: #fff;
}

.cm-title {
    padding-top: 10%;
    font-size: 80px;
    font-weight: bold;
    text-transform: uppercase;
}

.cm-description {
    font-size: 40px;
    padding: 50px 15%;
}

#run_countdown {
    padding-top: 20px;
    display: flex;
    justify-content: center;
}

#run_countdown p {
    color: #fff;
    font-size: 30px;
    margin-top: 10px;
}

.item {
    color: #fff;
    padding: 0 20px;
    text-align: center;
}

.item>div {
    border-radius: 5px;
    background: #5cd3d9;
    width: 85px;
    height: 80px;
    font-weight: bold;
    font-size: 50px;
    margin: 0 auto;
}


Code trong tab Javascript:
var get_date = document.getElementById("main-comingsoon").getAttribute("data-time");
var countDownDate = new Date(get_date).getTime();
var countdownfunction = setInterval(function () {
    var now = new Date().getTime();
    var distance = countDownDate - now;

    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    document.getElementById("set_day").innerHTML = days;
    document.getElementById("set_hours").innerHTML = hours;
    document.getElementById("set_minutes").innerHTML = minutes;
    document.getElementById("set_second").innerHTML = seconds;

    if (distance < 0) {
        clearInterval(countdownfunction);
        document.getElementById("main-comingsoon").remove();
    }
}, 1000);


MB448 P4 - Custom 404 Page Not Found - Breakdance



Code PHP khi chưa có thẻ div:
<?php
$group = rwmb_meta( 'button', ['object_type' => 'setting'], '404-page' ); 
foreach ($group  as $value) :       
   echo $value['title'];
   echo $value['url'];
endforeach;
?>


Code php khi đã có thẻ div:

<?php
$group = rwmb_meta( 'button', ['object_type' => 'setting'], '404-page' ); ?>
<div class="content-button">
  <?php foreach ($group  as $value) : ?>
        <a class="mb_button" href="<?php echo $value['url'];?>"><?php echo $value['title'];?></a> 
  <?php endforeach; ?>
</div>



Code CSS:

.breakdance{
  background-color:#fff;
}
a.mb_button {
     border-radius: 5px;
    margin-right: 30px;
    color: #fff;
    padding: 12px;
    background: #363636;
    text-decoration: none;
}
a.mb_button:hover{
    color: #d39450;
}

Sorry, we couldn't find the page you were looking for!

Oops! The page you're looking for seems to have wandered off. Let's get you back on track!

Back To Home
https://metabox.io/

Help Center
https://support.metabox.io/


text font-size 21 font-width: 600



Before After Image - MB Views
https://codepen.io/pig3onkick3r/pen/YzqqWKY
đoạn code template trong mb views:

<div class="mb-container">
    <div id="before-after-slider">
        <div id="before-image">
            <img src="{{ post.before_image.full.url }}" width="{{ post.before_image.full.width }}" height="{{ post.before_image.full.height }}" alt="{{ post.before_image.full.alt }}">
            <div class="text-before">{{ post.before_content }} </div>
        </div>
        <div id="after-image">
            <img src="{{ post.after_image.full.url }}" width="{{ post.after_image.full.width }}" height="{{ post.after_image.full.height }}" alt="{{ post.after_image.full.alt }}">
            <div class="text-after">{{ post.after_content }} </div>
        </div>

        <div id="resizer">
            <div class="mb-icon">
                <div id="triangle-left"></div>
                <div id="triangle-right"></div>
            </div>
        </div>

    </div>
</div>


Code CSS trong MB Views: 

#triangle-right {
    width: 0;
    height: 0;
    border-top: 8px solid transparent;
    border-left: 8px solid #fff;
    border-bottom: 8px solid transparent;
}

#triangle-left {
    margin-right: 5px;
    width: 0;
    height: 0;
    border-top: 8px solid transparent;
    border-right: 8px solid #fff;
    border-bottom: 8px solid transparent;
}

.mb-icon {
    cursor: pointer;
    background: linear-gradient(62deg, #c93072 5%, #3365c0);
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
    display: flex;
    justify-content: center;
    align-items: center;
    color: white;
    position: absolute;
    margin: 0 0 0 -18px;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 3px solid white;
}

.text-before {
    width: max-content;
    position: absolute;
    bottom: 10px;
    left: 10px;
    color: #fff;
    background: #0c0202;
    padding: 3px 7px;
}

.text-after {
    width: max-content;
    position: absolute;
    bottom: 5px;
    right: 5px;
    color: #fff;
    background: #0c0202;
    padding: 3px 5px;
}

.mb-container img {
    max-width: none;
    width: 100%;
    display: block;
}

#before-after-slider {
    width: 100%;
    position: relative;
    overflow: hidden;
    border: 3px solid white;
}

#after-image {
    display: block
}

#before-image {
    position: absolute;
    height: 100%;
    width: 50%;
    top: 0;
    left: 0;
    overflow: hidden;
    z-index: 2;
}

#resizer {
    position: absolute;
    display: flex;
    align-items: center;
    z-index: 5;
    top: 0;
    left: 50%;
    height: 100%;
    width: 4px;
    background: white;
    -ms-touch-action: pan-y;
    touch-action: pan-y;
}


Code Javascript trong mb views:

const slider = document.getElementById('before-after-slider');
const before = document.getElementById('before-image');
const beforeImage = before.getElementsByTagName('img')[0];
const resizer = document.getElementById('resizer');

let active = false;

document.addEventListener("DOMContentLoaded", function () {
    let width = slider.offsetWidth;
    console.log(width);
    beforeImage.style.width = width + 'px';
});

window.addEventListener('resize', function () {
    let width = slider.offsetWidth;
    console.log(width);
    beforeImage.style.width = width + 'px';
})

resizer.addEventListener('mousedown', function () {
    active = true;
    resizer.classList.add('resize');
});

document.body.addEventListener('mouseup', function () {
    active = false;
    resizer.classList.remove('resize');
});

document.body.addEventListener('mouseleave', function () {
    active = false;
    resizer.classList.remove('resize');
});

document.body.addEventListener('mousemove', function (e) {
    if (!active) return;
    let x = e.pageX;
    x -= slider.getBoundingClientRect().left;
    slideIt(x);
    pauseEvent(e);
});

function slideIt(x) {
    let transform = Math.max(0, (Math.min(x, slider.offsetWidth)));
    before.style.width = transform + "px";
    resizer.style.left = transform - 0 + "px";
}

function pauseEvent(e) {
    if (e.stopPropagation) e.stopPropagation();
    if (e.preventDefault) e.preventDefault();
    e.cancelBubble = true;
    e.returnValue = false;
    return false;
}




MB458 P1 - Pricing Table with Metabox + Breakdance

1 số đoạn code CSS sử dụng trong bài:

%%SELECTOR%%{
  background-color:#df703142;
  padding: 15px;
}




article:nth-child(2) > .mb-pricing-tables{
  border: 5px solid #ef7a37;
  transform: scale(1.1);
}

.mb-pricing-container .mbei-groups .mbei-group:nth-child(3) .mb-pricing-tables{
  border: 5px solid #ef7a37;
  transform: scale(1.1);
}

.mbei-groups .mbei-group:nth-child(3) .mb-pricing-tables {
    border: 5px solid #ef7a37;
    transform: scale(1.1);
}



#MB458 P4 Pricing table page - mb views

{% for clone in post.plans %}
    {{ clone.title }} <br/>
    {{ clone.price }} <br/>
    {{ clone.description }} <br/>
    {% for clone in clone.features %}
        {{ clone.item }} <br/>
    {% endfor %}
    {{ clone.button }} <br/>
    {{ clone.button_url }} <br/>
{% endfor %}




<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

<div class="mb-pricing-container">
    <div class="mb-content">
    {% for clone in post.plans %}
        <div class="mb-item">
            <div class="mb-title">{{ clone.title }}</div>
            <div class="mb-price">${{ clone.price }}/Year</div>
            <div class="mb-description">{{ clone.description }}</div>
            <div class="mb-features">
            {% for clone in clone.features %}
                <div class="item-feature">
                    <i class="fa fa-check-circle "></i>
                    {{ clone.item }}
                </div>
            {% endfor %}
            </div>
            <div class="mb-button">
                <a href="{{ clone.button_url }}">{{ clone.button }}</a>
            </div>
        </div>
    {% endfor %}
    </div>
</div>




<style type="text/css">
    .mb-pricing-container .mb-item:nth-child(2) {
    border: 5px solid #ef7a37;
    transform: scale(1.1);
}


.mb-content {
    display: flex !important;
    flex-direction: row;
    flex-wrap: wrap;
    width: 100%;

}

.mb-item {
    width: 30%;
    margin: 18px;
    text-align: center;
    border: 3px solid #78787885;
    border-radius: 15px;

}

.mb-title {
    font-size: 23px;
    font-weight: bold;
    margin-top: 15px;
}

.mb-price {
    font-size: 50px;
    font-weight: 800;
    color: #262626;
}

.mb-description {
    padding: 15px 0;
    background: #f7b793;
    font-size: 20px;
    margin: 20px 0;
}

.mb-features {
    padding-left: 2.5em;
    text-align: left;
}

.item-feature {
    font-weight: 500;
    color: #262626;
    font-size: 18px;
    padding: 10px 0;
}

.item-feature i.fa.fa-check-circle {
    color: #ef7a37;
}

.mb-button {
    margin: 20px;
}

.mb-button a:hover {
    text-decoration: underline;
}

.mb-button a {
    background: #ef7a37;
    padding: 8px 15px;
    border-radius: 4px;
    color: #fff;
}

</style>

nếu bật cái Term Meta mà k bật user meta thì nó báo
Term Meta dùng cho tạo field taxonomy
User meta  dùng tạo field cho user
nếu tạo field cho User thì bật mỗi cái User meta thôi,còn tạo cho Taxonomy thì bật thêm Term meta nữa


#translate label field
1. đăng kí label với string bằng php, add code sau vào function.php
do_action( 'wpml_register_single_string', 'Meta Box Labels', $meta_box['id'] . '_title', $meta_box['title'] );
do_action( 'wpml_register_single_string', 'Meta Box Labels', $meta_box['id'] . '_' . $field['id'], $field['name'] );
ví dụ 
do_action( 'wpml_register_single_string', 'Meta Box Labels', 'test-field-post' . '_title', 'Test Field Post' );
do_action( 'wpml_register_single_string', 'Meta Box Labels', 'test-field-post' . '_' . 'mb_address', 'MB Address' );
do_action( 'wpml_register_single_string', 'Meta Box Labels', 'order' . '_' . 'mb_order', 'MB Order' );

trong đó test-field-post là id field group còn mb_address là id của field cần dịch label

2.Sử dụng WPML String Translation để dịch các nhãn
WPML -> String Translation -> Domain -> chọn  'Meta Box Labels' hoặc tên mà bạn đã khai báo trong đoạn mã
Dịch các label  đó sang các ngôn ngữ mà bạn muốn

3. Hiển thị label đã dịch, sử dụng code này để hiện thị label bạn muốn
$field_label = apply_filters( 'wpml_translate_single_string', 'Your Field Label', 'Meta Box Labels', 'meta_box_id_your_field_id' );
echo $field_label;
ví dụ cụ thể:
$field_label = apply_filters( 'wpml_translate_single_string', 'MB Address', 'Meta Box Labels', 'test-field-post_mb_address' );
echo $field_label;
hoặc
$field_label = apply_filters( 'wpml_translate_single_string', 'MB Order', 'Meta Box Labels', 'order_mb_order' );
echo $field_label;

đoạn meta_box_id_your_field_id có 2 yếu tố 1 là meta_box_id và your_field_id 

để gọi label của custom field có thể dùng đoạn code sau trong single post
$field_label = rwmb_get_field_settings( 'field_id');
echo $field_label['name'];

hoặc
$field_label = apply_filters( 'wpml_translate_single_string', 'MB Order', 'Meta Box Labels', 'order_mb_order' );
echo $field_label;
với trong đó order là id field group còn mb_order là id của field cần dịch label

#translte custom field in setting page
https://support.metabox.io/topic/translate-fields-in-settings-pages-with-wpml/
https://wpml.org/documentation/support/language-configuration-files/translate-strings-in-wp-options-table/
https://wpml.org/documentation/support/language-configuration-files/custom-fields-translation-options/
https://share.getcloudapp.com/QwuA02PY
1. String translation -> Translate texts in admin screens -> search id field cần dịch -> add string translate
2. String translation -> search id field  -> dịch sang ngôn ngữ cần 
3. tạo 1 file wpml-config.xml trong thư mục theme, cùng cấp với file funtion.php
<wpml-config>
    <admin-texts>
        <key name='option_name'>
            <key name='field_id' />
        </key>
    </admin-texts>
</wpml-config>
4. ...\wp-content\themes\estar\template-parts\content\post.php
<?php 
    $options = get_option( 'option_name' );
    echo $options['field_id'];
?>
<?php 
    $options = get_option( 'mb_brand' );
    echo $options['mb_description'];
?>

#translate custom field value user and taxonomy
pTcHHXYPHF
Trong trả lời của bên WPML có hướng dẫn về việc translate giá trị custom fields cho user meta & term meta. Các em nghiên cứu để làm tutorial tương tự như bài translate custom fields cho post nhé.
https://wpml.org/documentation/getting-started-guide/string-translation/finding-strings-that-dont-appear-on-the-string-translation-page/
https://wpml.org/documentation/getting-started-guide/string-translation/

Translate custom field in post
1. chọn, thêm language : WPML -> Lanuge
2. chọn field cần dịch: WMPL -> settting -> tìm field cần dịch -> click translate
3. vào post -> nhập value -> click dịch bên sidebar
4. show ra font-end, sử dụng mb view hiện single post

Translate custom field in Taxonomy
1. WPML → Translation Management -> Chọn Language
2. Go to WPML → Settings ->  Custom Term Meta Translation -> chọn field term cần translate, postype và taxonomy cần translate
3. Go to WPML → Taxonomy Translation -> chọn Taxonomies cần translate -> translate
4. show ra font-end, sử dụng mb view hiện archive taxonomy -> select language in sidebar

Translate Custom Fields Value for User and Taxonomy

Code trong function.php:

add_filter( 'wpml_translatable_user_meta_fields', function( $fields ) {
   $fields[] = 'level';
   return $fields;
} ); 

add_filter( 'wpml_translatable_user_meta_fields', function( $fields ) {
   $fields[] = 'job_description';
   return $fields;
} ); 


add_filter( 'wpml_translatable_user_meta_fields', function( $fields ) {
   $fields = array('author_level','author_job_description');
   return $fields;
} );


hook ‘wpml_translatable_user_meta_fields’: Làm cho một số trường meta người dùng nhất định có thể dịch được thông qua Dịch chuỗi WPML
Note: Trong phần more option  -> administrator: chọn vai trò người dùng mà bạn muốn dịch, ví dụ nếu có 1 user có role subscriber (vai trò là “subscriber”) thì mình phải chọ tích vào ô subscriber đó thì value của các field trong user đó mới xuất hiện trong ô tìm kiếm của String translate và  sau khi translate ngoài front-end mới thấy được là bản dịch

Code trong views Translating User Meta:


<div class="mb-author">
    <h2>Author</h2>
    <div class="mb-img">{{ mb.get_avatar( author.ID, 80 ) }}</div>
    <div class="display-name">{{ author.display_name }}</div>
    <div class="mb-field">
        <div class="level-value">{{ mb.get_the_author_meta('author_level',author.ID) }} </div>
        <div class="job-value">{{ mb.get_the_author_meta('author_job_description',author.ID) }} </div>
    </div>
</div>



CSS: 
.mb-author .mb-img {
    float: left;
    margin-right: 25px;
    margin-top: 10px;
}


Code trong views Translating Term Meta:

{% set post_id = post.ID  %}
{% set category_detail = mb.get_the_category(post_id) %}
<h2>Categories</h2>
{% for category in category_detail %}
    <div class="mb-category">
        <div class="item">
            {% set meta_title = mb.get_term_meta( category.term_id, 'meta_title', true) %}  
            {% set meta_description = mb.get_term_meta( category.term_id, 'meta_description', true) %}

            <div class="mb-taxonomy">{{ category.cat_name }} </div>
            <div class="meta_title"><b>Meta Title:</b> {{ meta_title }}</div>
            <div class="meta_description"><b>Meta Description:</b> {{ meta_description }} </div>
        </div>
    </div>
{% endfor %}



CSS:
.mb-category {
    background: #edededc2;
    margin-bottom: 25px;
    padding: 10px;
}

.mb-taxonomy {
    text-transform: uppercase;
    font-weight: 500;
    color: #995d5dd1;
}



cách gọi field trong setting page của DS
Id của setting page là brand

{for:value {option:brand} [<li>{get:value}]}    
Test Field Value Meta box
value description
106


{for:value {option:brand} [{get:value}] @ sep=", "}
Test Field Value Meta box, value description, 106


{option:brand | dump}   
array ( 'mb_name' => 'Test Field Value Meta box', 'mb_description' => 'value description', 'logo' => 106, )

String Traslate
Dịch chuỗi WPML đề cập đến việc dịch bất kỳ nội dung nào nằm ngoài trình chỉnh sửa WordPress.
Khi sử dụng WPML, bạn có thể dễ dàng dịch nội dung bài đăng bằng cách tạo một phiên bản “trùng lặp” của từng phần nội dung bằng ngôn ngữ mới (hoặc bằng cách sử dụng Trình chỉnh sửa dịch nâng cao mới của WPML).

Tuy nhiên, giao diện đó không cho phép bạn dịch các phần của trang web nằm ngoài trình chỉnh sửa WordPress, như văn bản từ chủ đề của bạn, nội dung nhất định từ các plugin khác, dòng giới thiệu trang web, v.v.

Đó là lúc dịch chuỗi WPML xuất hiện – nó cung cấp cho bạn một giao diện hoàn toàn riêng biệt để chỉ quản lý những phần nội dung đó. Về cơ bản, đó là thứ cho phép bạn đảm bảo rằng bạn có thể dịch 100% trang web WordPress của mình.



Bạn luôn có thể thêm lại các chuỗi bằng cách vào WPML → Theme and Plugins Localization . Chọn plugin hoặc chủ đề và quét để làm cho các chuỗi của nó có sẵn để dịch lại.

wpml_translatable_user_meta_fields
Đảm bảo một số trường meta của người dùng có thể dịch được thông qua WPML String Translation.


khi add code trong function.php thì k cần vào user lưu lại, nó sẽ tự có trong string, chỉ cần click vào role 1 lần, nhưng nếu trong field có value update thì role đang bỏ click sẽ k hiện , phải click mới hiện


Các Role: Administrator, Editor, Author, Contributor , Shop manager
Được phép thêm, sửa, xóa bài post
Các Role: Web Designer( chỉ xem được front-end), Subscriber, Customer, 
Không có quyền thêm, sửa, xóa bài post


#Tên field là Author Level và Author Jod Description
khi show ra frontend thì show ở page single post thay vì ở archive page user

Junior 
Senior 
Tech Lead 

phần chọn Role, sau khi xem fornt-end, bài post nào thuộc author nào được dịch, đầu tiên click dịch các role, sau đó thử
bỏ tích 1 role, để hiện ra ngoài xem cái đó bị mất dịch



WPML String Translation là một thành phần của plugin WPML, cho phép bạn dịch các chuỗi văn bản từ theme và các plugin được sử dụng trên trang web WordPress của bạn. Điều này bao gồm các chuỗi mà không thể dịch trực tiếp qua trình chỉnh sửa bài viết hoặc trang thông thường, chẳng hạn như:
    Văn bản trong tiêu đề, footer, hoặc widget.
    Thông báo lỗi hoặc thông điệp hệ thống.
    Các chuỗi từ giao diện quản trị viên hoặc plugin bên thứ ba (như WooCommerce).
    Các mục menu hoặc URL tùy chỉnh.


wpml  Multilingual CMS  dịch được
Title và Content của Post, Page
WPML cho phép dịch categories , tags , và các taxonomy 
Menu
Widgets



#402 P5 Create download and preview button - zion
<?php 
$files = rwmb_meta( 'file_sdc2bqibkzr', [ 'limit' => 1 ] );
$file = reset( $files );
?>
<a href="<?= $file['url'] ?>" download class="zb-el-button ebook-style ebook-style1"><span class="zb-el-button__text">Download</span></a>
<a href="<?= $file['url'] ?>" class="zb-el-button ebook-style ebook-style2"><span class="zb-el-button__text">Preview</span></a>


.ebook-style{
    margin:10px 0px;
    margin: 10px 0px;
    text-decoration: none !important;
    text-align: center;
    display: block;
}
.ebook-style:hover{
    color:#fff;
}
.ebook-style1{
    background:#ffa100;
}
.ebook-style2{
    background:#fa4362;
}



https://metabox12.wpengine.com/wp-admin/admin.php?page=hide-admin-menu

#short mb frondend submission
Texas Taco Festival Restaurant New

Come hungry and get ready for the 6th annual Norfolk Taco Festival!

333 Waterside Drive Norfolk, VA 23510 United States

Date and time
location

Dashboard 


#update MB Blocks, Builder, Views
The 100+ Most Famous Quotes
Life Quote
Ralph Waldo Emerson
Lecture
“The purpose of life is not to be happy. It is to be useful, to be honorable, to be compassionate, to have it make some difference that you have lived and lived well.”


#mb-block-quote{
    display: flex;
    flex-wrap: nowrap;
}
.quote-content{
    background: #2c8791;
    color: #fff;
    width: 100%;
    text-align: center;
}
.quote_author::after,
.quote_author::before{
    content:" ~ ";
}
.quote__image {
    height: 100%!important;
}
.quote_author{
    font-weight: 500;
    font-size: 18px;
    padding: 0 20px;
}
.quote_content{
    padding: 30px;
    font-style: italic;
    font-size: 20px;
}
.quote_position{
    padding: 0 30px;
}


{{ attributes.avatar.full.url }}
<div id="mb-block-quote">
    <div class="quote-content">
        <div class="quote_content">{{ attributes.content }}</div>
        <div class="quote_author">{{ attributes.name }}</div>
        <div class="quote_position">{{ attributes.position }}</div>
    </div>
    <div class="quote_avater">
        <img class="quote__image" src="{{ attributes.avatar.full.url }}">
    </div>
</div>



#Create a Bio Page using Setting page + MB Views

Code trong tab templates lúc chưa style:
<img src="{{ site.bio_page.avatar.full.url }}" width="{{ site.bio_page.avatar.full.width }}" height="{{ site.bio_page.avatar.full.height }}" alt="{{ site.bio_page.avatar.full.alt }}"> <br/>
{{ site.bio_page.name }} <br/>
{{ site.bio_page.address }} <br/>
{{ site.bio_page.description }} <br/>
{{ site.bio_page.contact }} <br/>
{% for clone in site.bio_page.verified_accounts %}
    {{ clone.icon }} <br/>
    {{ clone.account_title }} <br/>
    {{ clone.account_url }} <br/>
{% endfor %}
{% for clone in site.bio_page.links %}
    {{ clone.title }} <br/>
    {{ clone.url }} <br/>
{% endfor %}

Code trong tab template khi đã thêm thẻ div để style:
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
<div class="mb-profile">
    <div class="mb-bio">
        <div class="mb-avatar">
            <img src="{{ site.bio_page.avatar.full.url }}" width="{{ site.bio_page.avatar.full.width }}" height="{{ site.bio_page.avatar.full.height }}" alt="{{ site.bio_page.avatar.full.alt }}">
        </div>
        <div class="bio-name">{{ site.bio_page.name }}</div>
        <div class="bio-address">{{ site.bio_page.address }}</div>  
        <div class="bio-description">{{ site.bio_page.description }}</div>

        <span class="button-readmore">Read more</span>
        <div class="contact">
            <button class="hover-shadow cursor">Contact</button> 
            <div class="mb-overlay"></div>
            <div id="myModal" class="modal">
                <span class="close cursor" >×</span>                    
                <div class="modal-content info-link">
                    <div class="icon-link"><i class="fa fa-at"></i></div>
                    <i class="fa fa-mail"></i><div class="mb-email">Email</div>
                    <a class="link-mail" href="mailto:{{ site.bio_page.contact }}">{{ site.bio_page.contact }}</a>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-account">
        <h3>Verified Accounts</h3>
        {% for clone in site.bio_page.verified_accounts %}
        <div class="item-accounts">
            <div class="icon-accounts">{{ clone.icon }}</div>
            <div class="info-accounts">
                <div class="title-accounts">{{ clone.account_title }}</div>
                <div class="mb-url"><a href="{{ clone.account_url }}">{{ clone.account_url }}</a></div>
            </div>
        </div>
        {% endfor %}
    </div>

    <div class="mb-link">
        <h3>Links</h3>
        {% for clone in site.bio_page.links %}
        <div class="item-link">
            <div class="icon-link"><i class="fa fa-link"></i></div>
            <div class="info-link">
                <div class="title-link">{{ clone.title }}</div>
                <div class="mb-url"><a href="{{ clone.url }}">{{ clone.url }}</a></div>
            </div>
        </div>
        {% endfor %}
    </div>

</div>




Code trong tab CSS:
body {
    margin: 0;
    padding: 0;
}
.mb-profile {
    width: 100%;
    padding: 64px 0 48px;
    background-color: #c4acac;
}

.mb-profile a{
    color: #1d4fc4;
}
.mb-bio,
.mb-account,
.mb-link {
    background-color: #fff;
    border-radius: 4px;
    display: flex;
    flex-direction: column;
    padding: 32px 40px;
    position: relative;
    margin: 0 auto 24px;
    max-width: 560px;
}

.mb-avatar {
    margin-bottom: 20px;
}
.icon-accounts{
    height: 24px;
        width: 24px;
}
.mb-avatar img {
    border-radius: 50%;
    width: 150px;
    height: 150px;
}
.bio-description {
    font-size: 16px;
    line-height: 1.4;
}
.bio-address{
    font-style: italic;
}

.bio-description{
        margin-top: 15px;
}
.bio-name {
    font-family: sans-serif;
    font-size: 38px;
    font-weight: bold;
}
.title-link,
.title-accounts {
    font-size: 18px;
    font-weight: bold;
}
.icon-link,
.icon-accounts{
    margin-right: 15px;
    height: 24px;
    width: 24px;
    float: left;
    margin-top: 5px;
}
.mb-url a:hover {
    text-decoration: underline;
}

.mb-url a {
    font-size: 20px;
    text-decoration: none;
}
.item-accounts,
.item-link {
    align-items: flex-start;
    border-top: 1px solid #f0f0f0;
    display: flex;
    flex-direction: row;
    gap: 8px;
    padding: 16px 0;
}

/* style button */
.modal {
    opacity: 0;
    position: fixed;
    z-index: 0;
    width: 555px;
    height: 150px;
    overflow: auto;
    background-color: #fff;
    transition: all .15s linear;
    -webkit-transform: translate3d(0, 200px, 0);
    transform: translate3d(0, 200px, 0);
}

.show-popup .modal {
    align-items: center;
    justify-content: center;
    position: fixed;
    top: 45%;
    z-index: 10000;
}

.show-popup .modal {
    opacity: 1;
    -webkit-transform: translateZ(0);
    transform: translateZ(0);
}

.modal-content {
    position: relative;
    background-color: #fefefe;
    padding: 38px;
}
.modal-content .link-mail {
    text-decoration: none;
    color: #1d4fc4;
    font-size: 20px;
}
.modal-content .link-mail:hover{
    text-decoration: underline;
}
.mb-email{
    font-size: 18px;
    font-weight: bold;
}
.modal-content .fa.fa-at{
    margin-top: 5px;
    font-size: 19px;
}
.close {
    z-index: 9;
    color: #999;
    position: absolute;
    right: 25px;
    font-size: 35px;
}

.close:hover,
.close:focus {
    color: #302a2a;
    text-decoration: none;
    cursor: pointer;
}

.cursor {
    cursor: pointer;
}
.show-popup .mb-overlay {
    opacity: 1;
    display: block;
}

.mb-overlay {
    z-index: 99;
    width: 100%;
    display: none;
    background-color: rgba(16, 21, 23, .4);
    bottom: 0;
    left: 0;
    opacity: 0;
    position: fixed;
    right: 0;
    top: 0;
}

.mb-overlay {
    transition: all .15s linear;
}
button.cursor:hover{    
    color: #50bbd9;
    border: 1px solid #50bbd9;
    transition: all .15s linear;
}
button.cursor{
    border-radius: 5px;
    border: 1px solid #6c7cb1;
    color: #6c7cb1;
    width: 100%;
    height: 40px;
    background: #fff;
    font-size: 18px;
    margin-top: 15px;
}


/*style readmore*/
.bio-description {
    letter-spacing: -.32px;
    line-height: 140%;
    white-space: pre-line;
    font-size: 18px;
    font-weight: 400;
    line-height: 26px;
    overflow: hidden;
}

.button-readmore:hover{
    text-decoration: underline;
}
.button-readmore {
    font-size: 18px;
    color: #6c7cb1;
    font-weight: 600;
    text-decoration: none;
    font-style: italic;
    cursor: pointer;
}

.button-readmore:hover {
    opacity: 0.9;
}

.mb-bio .bio-description {
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    display: -webkit-box;
    height: var(--truncate-height, auto);
    overflow: hidden;
    transition: height 0.3s ease;
}

   
.mb-bio .bio-description.show-full-content {
    -webkit-line-clamp: unset;
    height: var(--truncate-height-expanded, auto);
}



Code trong Tab Script:

jQuery(document).ready(function ($) {
    $('.button-readmore').click(function () {
        $(this).parent().find('.bio-description').toggleClass('show-full-content');
        if ($(this).text() == "Read more")
            $(this).text("Read less")
        else
            $(this).text("Read more");
    })

    $(".hover-shadow").click(function () {
        $('.contact').toggleClass('show-popup');
    });

    $(".close.cursor").click(function () {
        $(".contact").removeClass("show-popup");
    });
})



#Display Event Group by Month and Year



Code săp xếp theo  ‘Month Year’ trong functions.php:

function sort_month_events() {
    $the_query = new WP_Query( [
        'post_type'      => 'event',
        'posts_per_page' => - 1,
        'meta_key'       => 'start_date',
        'orderby'        => 'meta_value',
        'order'          => 'ASC',
    ] );
    
    $all_events = [];
     while ( $the_query->have_posts() ) :
        $the_query->the_post();
        $date       = strtotime( get_post_meta( get_the_ID(), 'start_date', true ) ); 
        $month = date( "F Y", $date );
        $all_events[ $month ][] = $the_query->post;
    endwhile;
    
    $html = '';
    $html.= '<div class="sort-month-events">';
        foreach ( $all_events as $month => $events ) :
            $html.= "<div class='mb-month'>
                <h3>$month</h3>
                    <ul>";
                    foreach ( $events as $event ) : 
                        $html.= '<li>';
                            $html.= date( "j F Y", strtotime(rwmb_meta('start_date', '', $event->ID)) ) . ' :
                            <a href="'.post_permalink( $event->ID ).'">'.$event->post_title.'</a>
                        </li>';
                    endforeach;
                    $html.= '</ul>
            </div>';
        endforeach;
    $html.= '</div>';
    
    return $html;
}
add_shortcode( 'sort_month', 'sort_month_events' );





Code sắp xếp theo Months within Years trong functions.php :

note: tương tự như code ở trên, code ở dưới này chỉ thêm 1 key vào mảng để gán các sự kiện có cùng tháng cùng năm tháng 1 mảng mới, code sẽ copy tương tự và chỉ thêm và sửa 1 số dòng giải thích code sau:

function sort_year_events() {
    $the_query = new WP_Query( [
        'post_type'      => 'event',
        'posts_per_page' => - 1,
        'meta_key'       => 'start_date',
        'orderby'        => 'meta_value',
        'order'          => 'ASC',
    ] );
    
    $all_events = [];
while ( $the_query->have_posts() ) :
        $the_query->the_post();
        $date       = strtotime( get_post_meta( get_the_ID(), 'start_date', true ) ); 
        $month = date( "F Y", $date );
        $year = date( "Y", $date );
        $all_events[ $year ][ $month ][] = $the_query->post;
    endwhile;
    
    $html = '';
    $html.= '<div class="sort-year-events">';
        foreach ( $all_events as $year => $years ) :
            $html.= "<div class='mb-year'>
                <h3>$year</h3>";
                foreach ( $years as $month => $events ) :
                    $html.=  "<h6>$month</h6>
                    <ul>";
                    foreach ( $events as $event ) : 
                        $html.= '<li>';
                            $html.= date( "j F Y", strtotime(rwmb_meta('start_date', '', $event->ID)) ) . ' :
                            <a href="'.post_permalink( $event->ID ).'">'.$event->post_title.'</a>
                        </li>';
                    endforeach;
                    $html.= '</ul>';
                endforeach;
            $html.=  '</div>';
        endforeach;
    $html.= '</div>';
    
    return $html;
}
add_shortcode( 'sort_year', 'sort_year_events' );



Code CSS trong Customize:

 /*style sort month*/
    .sort-month-events{
        width: 100%;
    }
    .mb-month{
        width: 30%;
        padding: 18px;
        margin: 15px 0;
        border: 2px solid #78787885;
        border-radius: 15px;        
    }
    
    .mb-month{
        background: #1fccf51a;
    }


/*style sort year*/
    .sort-year-events {
        width: 100%;
    }
    .sort-year-events {
        display: flex !important;
        flex-direction: row;
        flex-wrap: wrap;
    }
    .sort-year-events .mb-year {
        margin: 0 15px 15px 0;
    }
    .mb-year h3{
        background: #1fccf56e;
        padding:8px;
    }
    .mb-year {
        width: 30%;
        padding: 18px;
        margin: 15px 0;
        border: 2px solid #78787885;
        border-radius: 15px;        
    }




#Block Bindings API
Chức năng của Block Bindings API là cho phép bạn "liên kết" dữ liệu động với các thuộc tính của khối, 

sau đó được phản ánh trong mã đánh dấu HTML cuối cùng được xuất ra trình duyệt ở giao diện người dùng.

Using post meta as a block binding source


Supported Blocks    Supported Attributes

Image:  url, alt, title
Paragraph:  content
Heading:    content
Button: url, text, linkTarget, rel


Using a custom block binding source

source_name: 
source_properties
    label: 
    get_value_callback: 
    uses_context:
function themeslug_bindings_callback( $source_args, $block_instance, $attribute_name ) {

$source_args:  An array
$block_instance:
$attribute_name: 


<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"core/post-meta","args":{"key":"projectslug_mood"}}}}} -->
<p></p>
<!-- /wp:paragraph -->

<!-- wp:image {"metadata":{"bindings":{"url":{"source":"core/post-meta","args":{"key":"projectslug_image_url"}},"alt":{"source":"core/post-meta","args":{"key":"projectslug_image_alt"}}}}} -->
<figure class="wp-block-image"><img src="" alt=""/></figure>
<!-- /wp:image -->

<!-- wp:paragraph -->
<p></p>
<!-- /wp:paragraph -->


<!-- wp:image {"metadata":{"bindings":{"url":{"source":"themeslug/custom-source-example"}}}} -->
<figure class="wp-block-image"><img alt=""/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"themeslug/custom-source-example"}}}} -->
<p></p>
<!-- /wp:paragraph -->

<!-- wp:image {"metadata":{"bindings":{"url":{"source":"themeslug/custom-source-example"}, "alt":{"source":"themeslug/custom-source-example"}}}} -->
<figure class="wp-block-image"><img alt=""/></figure>
<!-- /wp:image -->

<!-- wp:image {
    "metadata":{
        "bindings":{
            "url":{
                "source":"themeslug/custom-source-example",
                "args":{
                    "key":"themeslug_image_url"
                }
            },
            "alt":{
                "source":"themeslug/custom-source-example"
            }
        }
    }
} -->
<figure class="wp-block-image"><img alt=""/></figure>
<!-- /wp:image -->

<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {
    "metadata":{
        "bindings":{
            "url":{
                "source":"themeslug/custom-source-example",
                "args":{
                    "key":"themeslug_button_url"
                }
            },
            "text":{
                "source":"themeslug/custom-source-example"
            }
        }
    }
} -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button">Custom Source</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->



#block theme
cấu trúc các file như Docs
https://developer.wordpress.org/themes/core-concepts/theme-structure/

các file html sẽ gọi các file php trong folder patterns
ví dụ: <!-- wp:pattern {"slug":"twentytwentyfour/mbtest"} /-->  là gọi file mbtest.php
trong file mbtest.php cũng phải khai báo 
/**
 * Title: mb test
 * Slug: twentytwentyfour/mbtest
 * Inserter: no
 */

 Tưởng tự file single.html sẽ xử lí single
 Tưởng tự file home.html sẽ xử lí home page

 các file html đó sẽ nằm ở folter "templates"
 chú ý nếu sửa giao diện các template thì khi edit bằng code bất cứ template nào sẽ không nhận
 có thể phải vào template reset lại tất cả các thay đổi đó, sau đó edit code ở các file mới nhận


#create a simple image lightbox
<script src="https://cdn.jsdelivr.net/npm/medium-zoom/dist/medium-zoom.js"></script>
<script>
    mediumZoom( '.entry-content img', {
        margin: 100,
        background: 'rgba(0,0,0,.8)',
        scrollOffset: 50,
    } );
</script>



#Create Syntax Highlighter
<script>
    ( function( d ) {
      if ( !d.querySelector( '.entry-content pre' ) ) {
        return;
      }

      let l = d.createElement( 'link' );
      l.rel = 'stylesheet';
      l.href = '//cdn.jsdelivr.net/gh/highlightjs/cdn-release@11.5.0/build/styles/github.min.css';
      d.head.appendChild( l );

      import( 'https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@11.5.0/build/es/highlight.min.js' )
        .then( ( { default: hljs } ) => d.querySelectorAll( '.entry-content pre' ).forEach( hljs.highlightElement ) );
    } )( document );
</script>

Metabox Relationship: Show all other events related to the artists of the current event

https://brickslabs.com/acf-relationship-show-all-other-events-related-to-the-artists-of-the-current-event/
https://www.hertswildlifetrust.org.uk/events?gad_source=1&gclid=CjwKCAjwzIK1BhAuEiwAHQmU3oRqlsf3essOUE8a5ChMVPSykQGFWNsbjfJzErz3SFQVYkR4PnCMQxoCYRIQAvD_BwE

Show Events Related


Code trong file related-events.php

<?php
/**
 * Title: Related events
 * Slug: twentytwentyfour/related-events
 * Inserter: no
 */
?>

<h2 style="font-weight:bold;">Related Events</h2>

<?php

$current_id = get_the_ID();
$connected = new WP_Query( [
    'relationship' => [
        'id'      => 'event-to-artist',
        'from'      => get_the_ID(),
    ],
] );

$atist_related = [];
while ( $connected->have_posts() ) : 
    $connected->the_post(); 
    $atist_related[] = get_the_ID();
endwhile;

$events_related = [];
foreach ( $atist_related as $id_atist ) :
    $connected1 = new WP_Query( [
        'relationship' => [
            'id'      => 'event-to-artist',
            'to'      => $id_atist,
        ],
    ] );
    while ( $connected1->have_posts() ) : 
        $connected1->the_post();
        
        $events_related [get_the_ID()] = get_the_title();
    endwhile;
endforeach;

unset($events_related[$current_id]);?>

<?php foreach ( $events_related as $key => $value ) : ?>
    <li><a href="<?php the_permalink($key); ?>"><?php echo $value; ?></a></li>
<?php endforeach;?>


Code trong file single.html:
<!-- <!-- wp:group {"style":{"spacing":{"margin":{"top":"var:preset|spacing|40"},"padding":{"bottom":"var:preset|spacing|50"}}},"layout":{"type":"constrained"}} -->
    <div class="wp-block-group">
        <!-- wp:pattern {"slug":"twentytwentyfour/related-events"} /-->
    </div>
    <!-- /wp:group → -->

với mb view:

<h2 style="font-weight:bold;">Related Events</h2>
{% set artists = [] %}
{% set current_id =  post.ID %}

{% set relationship = attribute( relationships, 'event-to-artist' ) %}
{% for post in relationship.to %}
    {% set artists = artists|merge([post.ID]) %}
{% endfor %}

{% set events_related = [] %}
{% for artist in artists %} 
    {% set shortcode = '[artist_list artist_id="' ~ artist ~ '" current_id="' ~ current_id ~ '" /]' %}
    {% set events = mb.do_shortcode(shortcode) %}
    
    {% set events = mb.explode(' ', events) %}  

    {% for event in events %}
        {% if( (mb.in_array(event, events)) == 1) %}
            {% set events_related = events_related|merge([event]) %}
        {% endif %}
    {% endfor %}    
{% endfor %}

{% set list_event = mb.array_unique(events_related) %} 
{% for event in list_event %}
    {{ event }} 
{% endfor %}    

cả code php

add_shortcode( 'artist_list', function ($atts) {
    extract( shortcode_atts( array(
           'artist_id' =>'',
           'current_id' =>'',
        ), $atts));
    $connected = new WP_Query( [
        'relationship' => [
            'id'    =>  'event-to-artist',
            'to'  => $artist_id,
        ],        
    ]);    
    $events_related = []; 
    while ( $connected->have_posts() ) : $connected->the_post(); 
        $events_related[get_the_ID()] = "<li><a>".get_the_title()."</a></li>";
    endwhile; 
    unset($events_related[$current_id]);
    $events_related = implode(' ',$events_related); 
    return $events_related;
} );



Note: bài này là Hiển thị tất cả các sự kiện khác liên quan đến artist của sự kiện hiện tại
, nghĩa là event A khi chọn relationship với artist 1 và artist  2, thì ở page single của event A sẽ hiện thị các event related sẽ là các event liên quan tới artist 1 và artist  2, nghĩa là cứ event nào có chọn relationship artist 1 và artist  2 thì gọi event đó ra

Ở bài này sử dụng block theme Twenty Twenty-Four  mặc định của wordpress, nên cấu trúc thêm code PHP vào file single post sẽ khác,  file  single.html là file hiện thị single post, muốn thêm code thì thêm lệnh để gọi file PHP đó, đặt file php ở folder “patterns” của theme và sau đó gọi file php theo cú pháp của block theme

cách 2 làm với mb view

{% set atist_related = { relationship: { id: 'event-to-artist', from: post.ID }, nopaging: true, post_type: 'artist' } %}
{% set atists = mb.get_posts(atist_related)|reverse %}
{% set unique_events = [] %} {# Danh sách các ID sự kiện đã xử lý #}

<ul>
    {% for atist in atists %}
        {% set event_related = { relationship: { id: 'event-to-artist', to: atist.ID }, nopaging: true, post_type: 'event' } %}
        {% set events = mb.get_posts(event_related)|reverse %} {# Đảo ngược thứ tự #}

            {% for event in events %}
                {% if event.ID not in unique_events and event.ID != post.ID %}
                    {% set unique_events = unique_events|merge([event.ID]) %}
                   <li><a href="{{ event.url }}">{{ event.post_title }}</a></li>
                {% endif %}
            {% endfor %}

    {% endfor %}
</ul>


#Định hướng Content trong thời gian tới: Ngoài các bài tutorials dành cho users của Meta Box, mình sẽ phát triển thêm các topic có ích cho users WP nói chung, hoặc các chủ đề hot. Một số nhóm nội dung như:
Nhóm Nội dung dành cho dev: VSC, CMS, CSS, thư viện mới,... => Anh Hải hoặc anh Tuấn Anh tìm hiểu, đề xuất
Nhóm Nội dung về marketing: Cách viết ND hấp dẫn, cách target đến khách hàng, cách setup qc, tối ưu chỉ số, từ khỏa, quản trị website, các plugin hữu ích...
Nhóm Nội dung general: tin tức, cộng đồng phù hợp với user: ví dụ WP 6.6 cải thiện gì, Gu sẽ phát triển ntn trong tương lai, page builder update có gì hữu ích cho user Meta Box, so sánh các plugin lq, deal trên app sumo, các bài list review,...
=> xem trên social, newsletter
Cách làm: thấy chủ đề có khả năng hot trên các kênh (social, newsletter,...) -> ping lên để cả team trao đổi và thống nhất -> Sau đó viết






link tham khảo
https://www.w3schools.com/js/tryit.asp?filename=tryai_chartjs_bars_colors_more
https://www.w3schools.com/ai/tryit.asp?filename=tryai_google_chart_pie3d
https://www.w3schools.com/ai/tryit.asp?filename=tryai_plotly_pie
https://www.w3schools.com/js/tryit.asp?filename=tryai_chartjs_lines
https://www.w3schools.com/js/tryit.asp?filename=tryai_chartjs_lines_multi

#453 Open Hour
Code JS
var getTimeElement = document.getElementById("time");
var TimeObject = JSON.parse(getTimeElement.getAttribute("data-time")); //JSON.parse() convert một chuỗi JSON và biến nó thành một đối tượng (mảng)

// Short day
var date = new Date();
Date.shortDays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']; // tạo 1 mảng có các giá trị 
function short_Days(date) {
    return Date.shortDays[date.getDay()]; // .getDay() trả về số 1 2 3, để trả về giá trị như kiểu Date.shortDays[0] chính là "Sun"
}

// Get time now
var now = date.getHours() + "." + date.getMinutes();

// Loop TimeObject
TimeObject.forEach(function (elm) {

    if (elm.day == short_Days(date)) { //elm.day = sun, mon, ... vì giá trị field là như vậy

        var timeSlots = elm.timeSlots

        var statusArray = [];
        timeSlots.forEach(function (elm) {
            if (parseFloat(now) > parseFloat(elm.start_time) && parseFloat(now) < parseFloat(elm.end_time)) { // parseFloat trả về 1 số thực để so sánh
                statusArray.push('open') //push() trong JavaScript được sử dụng để thêm một hoặc nhiều phần tử vào trong mảng
            } else {
                statusArray.push('close')
            }
        })

        if (statusArray.includes('open')) { //includes() được sử dụng để xác định xem một mảng hoặc chuỗi có chứa một phần tử
            document.getElementById("restaurant-status").innerHTML = `OPEN`;
        } else {
            document.getElementById("restaurant-status").innerHTML = `CLOSE`;
        }

    }
})



#chart
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
{% set type = post.type.value %}
{% set title = mb.explode(' ',post.chart_title) %}
{% set key = [] %}
{% set value = [] %}
{% set color = [] %}
{% set line_color = post.line_color %}

{% for clone in post.categories %}
    {% set key = key|merge([clone.key_x]) %}
    {% set value = value|merge([clone.value_y]) %}
    {% set color = color|merge([clone.color]) %}  
{% endfor %}

<canvas id="myChart" 
data-type='{{type}}'
data-title='{{title|json_encode()}}'
data-line-color='{{line_color}}'
data-color='{{color|json_encode()}}'
data-key='{{key|json_encode()}}'
data-value='{{value|json_encode()}}'

style="width:100%;max-width:600px"> <!-- width trong CSS đơn giản dùng để set chiều rộng cụ thể cho một phần tử, trong khi max-width dùng để xác định chiều rộng tối đa của một phần tử. -->
</canvas>

<script type="text/javascript">
var getTimeElement = document.getElementById("myChart");  //getElementById trả về phần tử có thuộc tính IDe là giá trị được chỉ định.
var title = JSON.parse(getTimeElement.getAttribute("data-title")).join(' ');  // JSON.parsenhận vào một chuỗi JSON và chuyển đổi (transform) nó thành một đối tượng JavaScript, .join là nối các phần tử của mảng lại với nhau thành một chuỗi ngăn cách bởi dấu cách

var type = getTimeElement.getAttribute("data-type");
var line_color = getTimeElement.getAttribute("data-line-color");
var color = JSON.parse(getTimeElement.getAttribute("data-color"));
var xValues = JSON.parse(getTimeElement.getAttribute("data-key"));
var yValues = JSON.parse(getTimeElement.getAttribute("data-value"));

if (type == 'line') {
    var mb_datasets = [{ borderColor: line_color, data: yValues, fill: false }];
    var mb_legend = false;
} else if (type == 'bar') {
    var mb_datasets = [{ backgroundColor: color, data: yValues, fill: false }];
    var mb_legend = false;
} else {
    var mb_datasets = [{ backgroundColor: color, data: yValues, fill: false }];
    var mb_legend = true;
}

new Chart("myChart", {
    type: type,
    data: {
        labels: xValues,
        datasets: mb_datasets,
    },
    options: {
        legend: { display: mb_legend },
        title: {
            display: true,
            text: title,
        }
    }
});
</script>



#làm topic custom widget full width
function my_custom_fonts() {
    echo '<style>
        .wp-block[data-type="core/widget-area"] {
            max-width: 90%!important;
        }
        .wp-block[data-type="core/widget-area"]
        .blocks-widgets-container .editor-styles-wrapper {
            max-width: 100%!important;
        }
    </style>';
}
add_action('admin_enqueue_scripts', 'my_custom_fonts');



#create load more button
{{ site.archive.post_type }} <br>
{{ site.archive.item_first }} <br>
{{ site.archive.item_load_more }} <br>
{{ site.archive.column.value }}

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
{% set args = { post_type: site.archive.post_type, posts_per_page: -1 } %}
{% set posts = mb.get_posts( args ) %} 
<div class="mb-container">
    <div class="mb-row">
        {% for post in posts %}
        <div class="mb-coloumn coloumn-{{ site.archive.column.value }}">
            <div class="mb-content">
                <div class="item">                 
                    <img src="{{ post.thumbnail.full.url }}" width="{{ post.thumbnail.full.width }}" height="{{ post.thumbnail.full.height }}" alt="{{ post.thumbnail.full.alt }}">
                    <h3>{{ post.title }} </h3>    
                    <div>{{ post.content }}</div>                     
                </div>
            </div>
        </div>
        {% endfor %}            
    </div>
    <a href="" data-first="{{ site.archive.item_first }}" data-loadmore="{{ site.archive.item_load_more }}" id="load-more">Load More</a>
</div>



.mb-container {
    max-width: 100%;
}

.mb-row {
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
}

.mb-content .item div {
    padding: 0 10px 5px;
}

.mb-content {
    height: 100%;
    display: none;
    padding: 0 10px 30px;
}

.mb-content h3 {
    margin: 10px;
    color: #d14e4e;
}

.item {
    background: #3658992b;
    height: auto;
    width: 100%;
}

.item img {
    width: 100%;
    height: 250px;
}

.coloumn-2 {
    width: 50%;
}

.coloumn-3 {
    width: 33.33%;
}

.coloumn-4 {
    width: 25%;
}

.coloumn-5 {
    width: 20%;
}

#load-more {
    text-decoration: none;
    transition: 0.3s;
    background-color: #000;
    color: #fff !important;
    padding: 5px 10px;
    border-radius: 4px;
    font-size: 20px;
    margin: 50px 0;
    display: inline-block;
    position: relative;
    left: 50%;
    transform: translate(-50%);
}

#load-more:hover {
    background-color: #d14e4e;
    text-decoration: none;
}

<script type="text/javascript">
    
jQuery(document).ready(function ($) {
    var getTimeElement = document.getElementById("load-more");
    var first = getTimeElement.getAttribute("data-first");
    var loadmore = getTimeElement.getAttribute("data-loadmore");
    $(".mb-content").slice(0, first).show();
    $("#load-more").on("click", function (e) {
        e.preventDefault();
        $(".mb-content:hidden").slice(0, loadmore).slideDown();
        if ($(".mb-content:hidden").length == 0) {
            $("#load-more").css('visibility', 'hidden');
        }
    });
});
</script>

#bảo mật, tối ưu hóa hiệu suất  cơ bản của 1 web
SEO: any SEO plugin, I prefer Slim SEO for simplicity (disclaimer: my plugin)
Cache: any cache plugin, I prefer Surge for simplicity
Security: probably spam protection is enough. I'd use WP Bruiser or WP Amour


#tăng tốc độ trang web
Ví dụ:
SELECT * FROM users LIMIT 100;
Sử dụng LIMIT để giới hạn số lượng kết quả trả về.

Sử dụng Plugin Query Monitor để gỡ lỗi và tăng hiệu suất


page builder
bảo mật
backup
Custom field
SEO


Tổng Kết:
Shared Hosting phù hợp cho những trang web nhỏ và cá nhân với lượng truy cập thấp, nhưng tốc độ và hiệu suất không ổn định.
VPS Hosting và Cloud Hosting là giải pháp tối ưu cho những trang web có lượng truy cập trung bình đến cao, đảm bảo hiệu suất ổn định và tốc độ nhanh.
Dedicated Server và Managed WordPress Hosting mang lại tốc độ tốt nhất cho các trang web lớn, nhưng chi phí cao và yêu cầu quản trị chuyên nghiệp.
CDN không phải là hosting chính, nhưng kết hợp với các loại hosting khác sẽ cải thiện đáng kể tốc độ tải trang ở nhiều khu vực địa lý.


liệt kê các plugin cần thiết cho WordPress website theo từng ngành nghề



1. Doanh nghiệp và Thương mại Điện tử
WooCommerce: Tạo và quản lý cửa hàng trực tuyến.
Yoast SEO: Tối ưu hóa SEO cho trang web.
WPForms: Tạo các biểu mẫu liên hệ và đơn hàng.
MonsterInsights: Theo dõi phân tích web.
Wordfence Security: Bảo mật trang web.
2. Blog và Nội Dung
Yoast SEO: Tối ưu hóa nội dung cho công cụ tìm kiếm.
Akismet Anti-Spam: Ngăn chặn spam trong bình luận.
Jetpack: Tăng cường hiệu suất và bảo mật.
Edit Flow: Quản lý quy trình làm việc của nội dung.
Social Snap: Chia sẻ nội dung trên mạng xã hội.
3. Giáo dục và Trường Học
LearnDash: Tạo và quản lý các khóa học trực tuyến.
LMS: Hệ thống quản lý học tập.
BuddyPress: Tạo các cộng đồng học tập.
WP Courseware: Quản lý nội dung khóa học.
Restrict Content Pro: Quản lý quyền truy cập nội dung.
4. Sáng tạo và Nghệ thuật
Envira Gallery: Tạo và quản lý các thư viện hình ảnh.
Elementor: Xây dựng các trang web tùy chỉnh với giao diện kéo và thả.
WPBakery Page Builder: Trình tạo trang kéo và thả.
Slider Revolution: Tạo các slider và hiệu ứng động.
Smush: Tối ưu hóa hình ảnh.
5. Dịch vụ và Freelancer
Bookly: Quản lý lịch hẹn và đặt lịch.
WP Job Manager: Quản lý danh sách việc làm.
WPForms: Tạo biểu mẫu liên hệ và yêu cầu dịch vụ.
WooCommerce: Tạo cửa hàng trực tuyến cho dịch vụ.
MemberPress: Quản lý hội viên và đăng ký.
6. Nhà hàng và Đặt bàn
OpenTable Widget: Tích hợp hệ thống đặt bàn của OpenTable.
Restaurant Menu by MotoPress: Tạo và quản lý thực đơn nhà hàng.
Bookly: Quản lý đặt bàn và lịch hẹn.
WP Restaurant Manager: Quản lý đặt bàn và thực đơn.
Table Rate Shipping: Tùy chỉnh phí vận chuyển theo khu vực.
7. Y tế và Sức khỏe
Bookly: Quản lý đặt lịch hẹn cho bác sĩ và phòng khám.
WPForms: Tạo biểu mẫu đăng ký và liên hệ.
Health Coach: Quản lý chương trình và tư vấn sức khỏe.
Medical WP Theme: Chủ đề WordPress dành riêng cho ngành y tế.
Elementor: Xây dựng các trang web tùy chỉnh cho phòng khám hoặc bác sĩ.


{% for item in post.image_gallery %}
    <img src="{{ item.full.url }}" width="{{ item.full.width }}" height="{{ item.full.height }}" alt="{{ item.full.alt }}">
{% endfor %}



#horizontal accodion
https://codepen.io/LysisLou/pen/oqKWwK
https://codepen.io/m49nn/pen/vMJzyx
https://codepen.io/erickarbe/pen/maLooq

Code trong tab template lúc chưa add thẻ div:
{% set args = { post_type: 'post', posts_per_page: -1} %}
{% set posts = mb.get_posts( args ) %}
{% for post in posts %}
    {{ post.ID }} <br>
    {{ post.title }} <br>
    <img src="{{ post.thumbnail.full.url }}" width="{{ post.thumbnail.full.width }}" height="{{ post.thumbnail.full.height }}" alt="{{ post.thumbnail.full.alt }}"> <br>
{% endfor %}
   
Code trong tab template lúc đã add thẻ div:
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
{% set args = { post_type: 'post', posts_per_page: -1} %}
{% set posts = mb.get_posts( args ) %}
<div class="accordian">
    <ul>
    {% for post in posts %}
        <li class="mb-item">
            <div class="image_title">
                <a href="{{ mb.get_permalink( post.ID ) }}">{{ mb.substr(post.title, 0, 15) }} ...</a>
            </div>
            <a href="#" class="mb-image">
                <img src="{{ post.thumbnail.full.url }}" width="{{ post.thumbnail.full.width }}" height="{{ post.thumbnail.full.height }}" alt="{{ post.thumbnail.full.alt }}">
            </a>
        </li>
    {% endfor %}
    </ul>
</div>

Code trong tab CSS:
.accordian {
    height: 320px;
    overflow: hidden;
}

.accordian ul {
    width: 100%;
    padding: 0;
    margin: 0;
}

.accordian li {
    position: relative;
    display: block;
    float: left;
    box-shadow: 0 0 25px 10px rgba(0, 0, 0, 0.5);
    -webkit-box-shadow: 0 0 25px 10px rgba(0, 0, 0, 0.5);
    -moz-box-shadow: 0 0 25px 10px rgba(0, 0, 0, 0.5);
    transition: all 1s;
    -webkit-transition: all 1s;
    -moz-transition: all 1s;
}


.accordian li img {
    height: 320px;
    transition: all 1s;
    -webkit-transition: all 1s;
    -moz-transition: all 1s;
    display: block;
}

.image_title {
    background: rgba(0, 0, 0, 0.5);
    position: absolute;
    left: 0;
    bottom: 0;
}

.image_title a:hover {
    color: #e3d27c;
}

.image_title a:focus {
    outline-style: inherit;
}

.image_title a {
    display: block;
    color: #fff;
    text-decoration: none;
    padding: 20px;
    font-size: 16px;
}

.accordian ul {
    display: inline-block;
    width: 100%;
}


Code trong tab JS:
$(function () {
    var width_accordian = $('.accordian ul').css("width");
    $('.accordian .image_title').css("width", width_accordian);

    var lis_count = $('.accordian .mb-item').length;
    function set_width_time() {
        var width = 100 / lis_count;
        $('.accordian .mb-item').css("width", width + '%');
    }
    set_width_time();

    $(".accordian ul li.mb-item").hover(function () {
        var width1 = 40 / (lis_count - 1);
        $('.accordian .mb-item').css("width", width1 + '%');
        $(this).css("width", '60%');
    }, function () {
        set_width_time();
    });
});


#Related Services grouped by Service Categories on Single Branch Posts in Bricks
https://brickslabs.com/related-services-grouped-by-service-categories-on-single-branch-posts-in-bricks/

function related_taxonomy_group_post(){
    $current_id = get_the_ID();
    $connected = new WP_Query( [
        'relationship' => [
            'id'      => 'event-to-restaurant',
            'from'      => get_the_ID(),
        ],
    ] );

    $restaurant_related = [];
    while ( $connected->have_posts() ) : 
        $connected->the_post(); 
        $cat_detail = get_the_terms(get_the_ID(),'portfolio-type');        
        foreach ($cat_detail as $cat) {
            $name_cat = $cat->name;
            $restaurant_related[ $name_cat ][] = $connected->post;
        }
    endwhile;    

    $html = '';
    foreach ( $restaurant_related as $name_cat => $restaurants ) :
        $html.= '<h3>'.$name_cat.'</h3>';
        foreach ( $restaurants as $restaurant ) : 
            $html.= '<li><a href="'.post_permalink( get_the_ID() ).'">'.$restaurant->post_title .'</a></li>';
        endforeach;
    endforeach;

    return $html;
}
add_shortcode( 'related_taxonomy_post', 'related_taxonomy_group_post' );


function sort_month_events() {

    $the_query = new WP_Query( [
        'post_type'      => 'event',
        'posts_per_page' => - 1,
        'meta_key'       => 'start_date',
        'orderby'        => 'meta_value',
        'order'          => 'ASC',
    ] );
    $all_events = [];
    while ( $the_query->have_posts() ) :
        $the_query->the_post();
        $date       = strtotime( get_post_meta( get_the_ID(), 'start_date', true ) ); 
        $month = date( "F Y", $date );
        $all_events[ $month ][] = $the_query->post;
    endwhile;

    $html = '';
    $html.= '<div class="sort-month-events">';
        foreach ( $all_events as $month => $events ) : 
            $html.= "<div class='mb-month'>
                <h3>$month</h3>
                    <ul>"; 
                    foreach ( $events as $event ) : 
                        $html.= '<li>';
                            $html.= date( "j F Y", strtotime(rwmb_meta('start_date', '', $event->ID)) ) . ' : 
                            <a href="'.post_permalink( $event->ID ).'">'.$event->post_title.'</a>
                        </li>';
                    endforeach;
                    $html.= '</ul>
            </div>';
        endforeach;
    $html.= '</div>';

    return $html;
}
add_shortcode( 'sort_month', 'sort_month_events' );

function sort_year_events() {
    $the_query = new WP_Query( [
        'post_type'      => 'event',
        'posts_per_page' => - 1,
        'meta_key'       => 'start_date',
        'orderby'        => 'meta_value',
        'order'          => 'ASC',
    ] );
    
    $all_events = [];
    while ( $the_query->have_posts() ) :
        $the_query->the_post();
        $date       = strtotime( get_post_meta( get_the_ID(), 'start_date', true ) ); 
        $month = date( "F Y", $date );
        $year = date( "Y", $date );
        $all_events[ $year ][ $month ][] = $the_query->post;
    endwhile;

    $html = '';
    $html.=  '<div class="sort-year-events">';
        foreach ( $all_events as $year => $years ) : 
            $html.=  "<div class='mb-year'>
                <h3>$year</h3>";
               foreach ( $years as $month => $events ) :
                    $html.=  "<h6>$month</h6>
                    <ul>"; 
                    foreach ( $events as $event ) : 
                        $html.=  '<li>';
                            $html.=  date( "j F Y", strtotime(rwmb_meta('start_date', '', $event->ID)) ) . ' : ';
                            $html.=  '<a href="'.post_permalink( $event->ID ).'">'.$event->post_title.'</a>
                        </li>';
                    endforeach;
                    $html.=  '</ul>';
                endforeach;
            $html.=  '</div>';
        endforeach;
    $html.=  '</div>';

    return $html;
}

add_shortcode( 'sort_year', 'sort_year_events' );

làm với MB views
{% set event_query = {post_type: 'event', posts_per_page: -1, meta_key: start_date, orderby: 'meta_value', order: 'ASC'} %}
{% set events = mb.get_posts(event_query) %}

{% set grouped_events = {} %}
{% for event in events %}
    {% set month = event.start_date|date('Y-m') %}
    
    {% if grouped_events[month] is not defined %}
        {% set grouped_events = grouped_events|merge({(month): []}) %}
    {% endif %}
    {% set grouped_events = grouped_events|merge({(month): grouped_events[month]|merge([event])}) %}
{% endfor %}

{% for month in grouped_events %}
    <h3>{{ month|date('F Y') }}</h3>
    <ul>
        {% for event in grouped_events[month]|sort((a, b) => a.start_date <=> b.start_date) %}
            <li>
                {{ event.start_date|date('j F Y') }} : <a href="{{ mb.post_permalink(event.ID) }}">{{ event.post_title }}</a>
            </li>
        {% endfor %}
    </ul>
{% endfor %}

#event calendar
https://codepen.io/tag/event-calendar
https://codepen.io/ravistrats360/pen/XWqrKMX

Show Events to Calendar

Code trong tab templates lúc chưa add thẻ div: 
{% set args = { post_type: 'event', posts_per_page: -1} %}
{% set posts = mb.get_posts( args ) %}
{% for post in posts %}
   {{ post.ID }} <br>
   {{ post.start_date | date( 'Y-m-d H:i' ) }} <br>
   {{ post.end_date | date( 'Y-m-d H:i' ) }} <br>
{% endfor %} 

Code trong tab templates lúc đa add thẻ div và thư viện CSS, JS: 

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/locale-all.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css" />

{% set args = { post_type: 'event', posts_per_page: -1} %}
{% set posts = mb.get_posts( args ) %}

{% set event_info = [] %}
{% for post in posts %}
    {% set event_info = event_info|merge([{ title: post.title, start: post.start_date | date( 'Y-m-d H:i' ), end: post.end_date | date( 'Y-m-d H:i' ) }]) %}
{% endfor %}

<div id="calendar" data-event='{{ event_info|json_encode() }}'></div>

Code trong tab CSS:
.fc-event,
.fc-event-dot {
    background-color: #d8613c !important;
}

.fc-event {
    border: 1px solid #d8613c !important;
}

.fc-day-grid-event {
    padding: 3px 1px;
}

.fc-toolbar button,
.fc-button-group button {
    text-transform: capitalize;
}

.fc-scroller.fc-day-grid-container {
    height: auto !important;
}


Code trong tab Javascript:
$(function () {
    var getTimeElement = document.getElementById("calendar");
    var data_event = JSON.parse(getTimeElement.getAttribute("data-event"));

    const current_date = new Date();

    $('#calendar').fullCalendar({
        locale: 'en',
        header: {
            left: 'prev,next, today',
            center: 'title',
            right: 'month,basicWeek,basicDay'
        },
        defaultDate: current_date,
        navLinks: true,
        editable: true,
        eventLimit: true,
        events: data_event,
    });
});


Note: tiêu đề các event khi hiện thị thường có số 7a, 8: 45a nghĩa là giờ start date của event đó vì sử dụng field datatime piker nên là có set cả ngày và giờ, nếu sử dụng field datepiker thì sẽ không có set giờ thì title sẽ chỉ hiện title chứ không có giờ ở trước


#Post Data for the Current User in Bricks with Meta Box
https://www.facebook.com/groups/brickscommunity/posts/1455904225074093/
https://brickslabs.com/post-data-for-the-current-user-in-bricks-with-meta-box/
https://support.metabox.io/topic/traversing-multiple-related-cpts/

Sales Representative là gì có lẽ là thắc mắc của nhiều người. Sales Representative có nghĩa là người đại diện bán hàng/đại diện kinh doanh của một công ty
Sales Representative chịu trách nhiệm đại diện doanh nghiệp tiếp cận, giao tiếp, giới thiệu sản phẩm đến khách hàng theo chính sách, chiến lược của công ty nhằm đảm bảo chỉ tiêu kinh doanh cho khu vực mà mình phụ trách

Code mb views 
{% if mb.is_user_logged_in %}
    {% set salesrep_related = { relationship: { id: 'salesrep-to-user', to: user.ID }, nopaging: true, post_type: 'salesrep' } %}
    {% set salesreps = mb.get_posts(salesrep_related) %}

    {% for salesrep in salesreps %}
    <div class="mb-container"> 
        <div class="mb-content">
            <div class="mb-your-sale">Your Sales Representative</div>
            <div class="mb-title-sale">{{  salesrep.post_title }}</div>
            <img src="{{ mb.get_the_post_thumbnail_url(salesrep.ID) }}" alt="{{  salesrep.post_title }}" />
            <div class="mb-phone"><b>Phone Number</b>: {{  salesrep.phone }}</div>
            <div class="mb-email"><b>Email</b>: {{  salesrep.email }}</div>
            <div class="mb-experience"><b>Years of experience</b>: {{  salesrep.years_of_experience }}</div>
            <div class="mb-language"><b>Language</b>: {{  salesrep.language.label }}</div>       
            <div class="mb-motto"><b>Working Motto</b>: {{  salesrep.working_motto }}</div>
        </div>
    </div>
    {% endfor %}

{% endif %}

Ở phần mb view phải check trường hợp user đã đăng nhập hay chưa còn chỗ user.id sẽ không có kết quả khi user chưa đăng nhập ngoài frontend, còn ở phần PHP thì get_current_user_id() luôn trả về một giá trị(bằng 0), ngay cả khi người dùng chưa đăng nhập

#Dynamic Styling with Data Attributes 

https://www.facebook.com/groups/brickscommunity/posts/assign-a-class-to-a-loop-item-based-on-taxonomyi-have-a-custom-post-type-homepag/1475121406485708/
https://www.youtube.com/watch?v=2xN_6xGMKQc
https://www.youtube.com/watch?app=desktop&v=JqHFf2LvvSY
https://www.youtube.com/watch?v=4jKe_g9s9TQ

{post_terms_my_taxonomy_slug} – Replace the “my_taxonomy_slug” part with the slug of the actual taxonomy you want to use
{post_terms_category:plain} – Remove the links via :plain filter
[data-color="Spa and Wellness"] {
    background: #266e8bc4;
}
[data-color="Infinity Pool"] {
    background: #008f5b;
}
[data-color="Dining Experiences"] {
    background: #a76565;
}
[data-color="Outdoor Activities"] {
    background: #b98804;
}
[data-color="Tech Comfort"] {
    background: #919090;
}
[data-color]{
    border-radius: 30px;
    color:#fff;
    overflow: hidden;
}




file function.php 

add_filter( 'rwmb_meta_boxes', function( $meta_boxes ) {
    $meta_boxes[] = [
        'title' => 'Contact Us with PHP',
        'id'    => 'contact-with-php',
        'type'  => 'block', // Important.
        'icon'  => 'email', // Or you can set a custom SVG if you don't like Dashicons
        'category' => 'layout',
        'context' => 'side', // The block settings will be available on the right sidebar.
        'supports' => [
          'align' => ['wide', 'full'],
        ],
        'render_template' => get_stylesheet_directory() . '/blocks/contact/template.php', // The PHP template that renders the block.
        'enqueue_style'   => get_stylesheet_directory_uri() . '/blocks/contact/style.css', // CSS file for the block.
        // Now register the block fields.
        'fields' => [
            [
                'type' => 'text',
                'id'   => 'title',
                'name' => 'Title',
            ],
            [
                'type' => 'textarea',
                'id'   => 'description',
                'name' => 'Description',
            ],
            [
                'id'   => 'contact_information',
                'type' => 'group',
                'name'   => 'Contact Information',
                'clone'  => true,
                'max_clone'=> 3,            
                'fields' => [                    
                    [
                        'type' => 'single_image',
                        'id'   => 'icon',
                        'name' => 'Icon',
                    ],
                    [
                        'type' => 'text',
                        'id'   => 'name',
                        'name' => 'Name',
                    ],
                    [
                        'type' => 'textarea',
                        'id'   => 'content',
                        'name' => 'Content',
                    ],
                ],        
            ],
        ],
    ];
    return $meta_boxes;
} );


function related_taxonomy_group_post(){
    $current_id = get_the_ID();
    $connected = new WP_Query( [
        'relationship' => [
            'id'      => 'event-to-restaurant',
            'from'      => get_the_ID(),
        ],
    ] );

    $restaurant_related = [];
    while ( $connected->have_posts() ) : 
        $connected->the_post(); 
        $cat_detail = get_the_terms(get_the_ID(),'portfolio-type');        
        foreach ($cat_detail as $cat) {
            $name_cat = $cat->name;
            $restaurant_related[ $name_cat ][] = $connected->post;
        }
    endwhile;    

    $html = '';
    foreach ( $restaurant_related as $name_cat => $restaurants ) : 
        $html.= '<h3>'.$name_cat.'</h3>';
        foreach ( $restaurants as $restaurant ) : 
            $html.= '<li><a href="'.get_post_permalink( get_the_ID() ).'">'.$restaurant->post_title .'</a></li>';
        endforeach;
    endforeach;

    return $html;
}
add_shortcode( 'related_taxonomy_post', 'related_taxonomy_group_post' );


function sort_month_events() {

    $the_query = new WP_Query( [
        'post_type'      => 'event',
        'posts_per_page' => - 1,
        'meta_key'       => 'start_date',
        'orderby'        => 'meta_value',
        'order'          => 'ASC',
    ] );
    $all_events = [];
    while ( $the_query->have_posts() ) :
        $the_query->the_post();
        $date       = strtotime( get_post_meta( get_the_ID(), 'start_date', true ) ); 
        $month = date( "F Y", $date );
        $all_events[ $month ][] = $the_query->post;
    endwhile;

    $html = '';
    $html.= '<div class="sort-month-events">';
        foreach ( $all_events as $month => $events ) : 
            $html.= "<div class='mb-month'>
                <h3>$month</h3>
                    <ul>"; 
                    foreach ( $events as $event ) : 
                        $html.= '<li>';
                            $html.= date( "j F Y", strtotime(rwmb_meta('start_date', '', $event->ID)) ) . ' : 
                            <a href="'.get_post_permalink( $event->ID ).'">'.$event->post_title.'</a>
                        </li>';
                    endforeach;
                    $html.= '</ul>
            </div>';
        endforeach;
    $html.= '</div>';

    return $html;
}
add_shortcode( 'sort_month', 'sort_month_events' );

function sort_year_events() {
    $the_query = new WP_Query( [
        'post_type'      => 'event',
        'posts_per_page' => - 1,
        'meta_key'       => 'start_date',
        'orderby'        => 'meta_value',
        'order'          => 'ASC',
    ] );
    
    $all_events = [];
    while ( $the_query->have_posts() ) :
        $the_query->the_post();
        $date       = strtotime( get_post_meta( get_the_ID(), 'start_date', true ) ); 
        $month = date( "F Y", $date );
        $year = date( "Y", $date );
        $all_events[ $year ][ $month ][] = $the_query->post;
    endwhile;

    $html = '';
    $html.=  '<div class="sort-year-events">';
        foreach ( $all_events as $year => $years ) : 
            $html.=  "<div class='mb-year'>
                <h3>$year</h3>";
               foreach ( $years as $month => $events ) :
                    $html.=  "<h6>$month</h6>
                    <ul>"; 
                    foreach ( $events as $event ) : 
                        $html.=  '<li>';
                            $html.=  date( "j F Y", strtotime(rwmb_meta('start_date', '', $event->ID)) ) . ' : ';
                            $html.=  '<a href="'.get_permalink( $event->ID ).'">'.$event->post_title.'</a>
                        </li>';
                    endforeach;
                    $html.=  '</ul>';
                endforeach;
            $html.=  '</div>';
        endforeach;
    $html.=  '</div>';

    return $html;
}

add_shortcode( 'sort_year', 'sort_year_events' );



add_action( 'rwmb_image1_after_save_field', function ( $new, $old, $object_id ) {  
    $alt_text = get_the_title( $object_id );  
    update_post_meta( $object_id, '_wp_attachment_image_alt', $alt_text );    
}, 10, 5 );

add_action( 'rwmb_image_advanced_after_save_field', function ( $new, $old, $object_id ) {    
    foreach ( $object_id as $image_id ) {
     $alt_text = get_the_title( $image_id ); 
        update_post_meta( $image_id, '_wp_attachment_image_alt', $alt_text );
    }
}, 10, 5 );


 add_action( 'rwmb_logo_after_save_field', function ( $new, $old, $object_id ) {  
    // $alt_text = wp_get_attachment_caption( $object_id );  // lấy caption ảnh
    $alt_text = get_post_field( 'post_content', $object_id );   // lấy descipriton ảnh
    update_post_meta( $object_id, '_wp_attachment_image_alt', $alt_text );    
}, 10, 3 );


hoặc lấy description ảnh
add_action( 'rwmb_{$field_id}_after_save_field', function ( $new, $old, $object_id ) {
$attachment = get_post( $object_id );
$alt_text = ! empty( $attachment->post_content ) ? $attachment->post_content : 'Default ALT Text';
update_post_meta( $object_id, '_wp_attachment_image_alt', $alt_text );
}, 10, 5 );


#thay đổi al text
https://support.metabox.io/topic/alt-text/
https://docs.metabox.io/actions/rwmb-after-save-field/
add_action( 'rwmb_single_image_after_save_field', function ( $new, $old, $object_id ) {   
    // Lấy tiêu đề của bài viết
    $alt_text = get_the_title( $object_id );   
    // Cập nhật ALT cho ảnh
    update_post_meta( $object_id, '_wp_attachment_image_alt', $alt_text );    
}, 10, 5 );

add_action( 'rwmb_image_advanced_after_save_field', function ( $new, $old, $object_id ) {    
    // Lấy tiêu đề của bài viết
   $alt_text = '';
    // Lặp qua từng ID ảnh để cập nhật ALT
    foreach ( $object_id as $image_id ) {
     $alt_text = get_the_title( $image_id ); 
        update_post_meta( $image_id, '_wp_attachment_image_alt', $alt_text );
    }
}, 10, 5 );
nếu muốn lấy description làm alt thì thay code:
add_action( 'rwmb_{field_id}_after_save_field', function ( $new, $old, $object_id ) {  
    $attachment = get_post( $object_id ); // Lấy object của ảnh  
    $alt_text = ! empty( $attachment->post_content ) ? $attachment->post_content : 'Default ALT Text'; // Lấy description của ảnh  
    update_post_meta( $object_id, '_wp_attachment_image_alt', $alt_text );    
}, 10, 5 );