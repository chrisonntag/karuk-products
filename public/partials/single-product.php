<?php
/**
 * The Product Page template file
 * Template Name: Product
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Karuk
 */

get_header();
?>

  <?php
  while ( have_posts() ) :
    $post = get_queried_object();
    $post_custom = get_post_custom();
    $category_name = wp_get_post_terms($post->ID, 'karuk_products_category');
    if ( $category_name ):
      $category_name = $category_name[0];
    endif;
    the_post();

  ?>

	<section class="section">
    <div class="container">
      <?php if ( $category_name ): ?>
        <div class="product_link">
          <a href="<?php echo get_category_link( $category_name->term_id ); ?>"><?php echo __('Show more ', 'karuk'); echo $category_name->name; ?></a>
        </div>
      <?php endif; ?>
      <?php 
      if ( the_post_thumbnail() ):
      ?>
        <figure class="image is-3by1"><img src="<?php the_post_thumbnail(); ?>" alt="Big Image" /></figure>
      <?php endif; ?>
    </div>
  </section>


  <section class="section">
    <div class="container has-text-centered">
      <h1 class="title"><?php the_title(); ?></h1>
        <div class="columns">
          <div class="content column is-three-fifths is-offset-one-fifth">
            <p>
              <?php the_content(); ?>
            </p>
            <?php
              $tags = wp_get_post_tags($post->ID);
              foreach ($tags as $tag) {
                $tag = $tag->to_array();
                echo '<a href="'. get_tag_link($tag['term_id']) .'"><span class="tag is-light">#'. $tag['name'] .'</span></a>';
              }
            ?>
          </div>
        </div>
    </div>
  </section>r


  <section class="section">
    <div class="container">
      <div class="columns">
        <div class="column is-half">

          <ul id="product-slider">
            <?php 
              $re = '/."(https?:\/\/[^"]+\.(jpg|png|jpeg|JPEG|JPG|PNG|bmp|BMP))"./m';
              $images_str = $post_custom['kp_product_images'][0]; 

              preg_match_all($re, $images_str, $images, PREG_SET_ORDER, 0);

              foreach ($images as $image) {
            ?>
              <li>
                <figure class="image is-2by1">
                  <a href="#">
                    <img src="<?php echo $image[1]; ?>" alt="Product Image" />
                  </a>
                </figure>
              </li>
            <?php
              }
            ?>
          </ul>
           
        </div>
        <div class="column is-half">
          <h2 class="title is-4">Technical Facts</h2>
          <?php echo $post_custom['kp_products_table'][0]; ?>

          <br />

          <a href="<?php echo $post_custom['kp_manufacturer'][0]; ?>" class="button is-light is-small">Hersteller Website</a>
          <a href="<?php echo $post_custom['kp_datasheet'][0]; ?>" class="button is-light is-small">Datenblatt</a>
          <?php if ( array_key_exists('kp_product_files', $post_custom) ): ?>
            <a href="#downloads" class="button is-light is-small">Downloads</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </section>


  <section class="section">
  </section>


  <section class="section">
    <div class="container">
      <div class="columns">
        <div class="column">
          <div class="content">
            <h3 class="title is-4"><?php echo $post_custom['kp_info_title_1'][0]; ?></h3>
            <p>
              <?php echo $post_custom['kp_info_content_1'][0]; ?>
            </p>
          </div>
        </div>
        <div class="column">
          <div class="content">
            <h3 class="title is-4"><?php echo $post_custom['kp_info_title_2'][0]; ?></h3>
            <p>
              <?php echo $post_custom['kp_info_content_2'][0]; ?>
            </p>
          </div>
        </div>
        <div class="column">
          <div class="content">
            <h3 class="title is-4"><?php echo $post_custom['kp_info_title_3'][0]; ?></h3>
            <p>
              <?php echo $post_custom['kp_info_content_3'][0]; ?>
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>


  <?php
  $files_re = '/."(https?:\/\/[^"]+\.(\w+))"./m';
  $files_str = $post_custom;

  if ( array_key_exists('kp_product_files', $files_str) ):
  ?>
  <section id="downloads" class="section">
    <div class="container">
      <div class="level">
      <?php 
      $files_str = $files_str['kp_product_files'][0]; 
      preg_match_all($files_re, $files_str, $files, PREG_SET_ORDER, 0);

      foreach ($files as $file) {
        switch ($file[2]) {
          case 'pdf':
            $ext_class = "file-pdf";
            break;
          case 'zip':
          case 'tar':
            $ext_class = "file-archive";
            break;
          case 'xlsx':
          case 'xls':
            $ext_class = "file-excel";
            break;
          case 'docx':
          case 'doc':
            $ext_class = "file-word";
            break;
          case 'mp4':
          case 'mov':
            $ext_class = "file-video";
            break;
          case 'jpg':
          case 'jpeg':
          case 'png':
            $ext_class = "file-image";
            break;
          default:
            $ext_class = "file";
            break;
        }
      ?>
        
        <a href="<?php echo $file[1]; ?>" class="level-item has-text-centered">
          <span class="icon is-large">
            <i class="fa fa-3x fa-<?php echo $ext_class; ?>"></i>
          </span>
        </a>
        
      <?php 
      }
      ?>
      </div>
    </div>
  </section>
  <?php endif; ?>


  <section class="section">
    <div class="container has-text-centered">
      <a href="#" class="button is-medium is-black">&Auml;hnliche Produkte</a>
    </div>
  </section>


<?php
endwhile; // End of the loop.
get_footer();

