<?php
/**
 * The Product Page template file
 * Template Name: Product
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Karuk
 */

$post = get_queried_object();
$post_custom = get_post_custom();
$category_name = wp_get_post_terms($post->ID, 'karuk_products_category');
if ( $category_name ):
  $category_name = $category_name[0];
endif;

get_header();
the_post();

?>

<main itemscope itemtype="http://schema.org/Product">
  <section class="section">
    <div class="container">
      <?php if ( $category_name ): ?>
        <div class="product_link">
          <a href="<?php echo get_category_link( $category_name->term_id ); ?>"><?php echo __('Show more in ', 'karuk'); echo $category_name->name; ?></a>
        </div>
      <?php endif; ?>
      <?php 
      if ( has_post_thumbnail() ):
      ?>
        <figure class="image is-3by1 is-fullwidth">
          <img itemprop="image" src="<?php echo get_the_post_thumbnail_url(); ?>" alt="Big Image" />
        </figure>
      <?php endif; ?>
    </div>
  </section>


  <section class="section">
    <div class="container has-text-centered">
      <h1 class="title" itemprop="name"><?php the_title(); ?></h1>
        <div class="columns">
          <div class="content column is-three-fifths is-offset-one-fifth">
            <p itemprop="description">
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

          
            <?php
              if (array_key_exists('kp_product_images', $post_custom)) {
                $images = get_post_meta(get_the_ID(), 'kp_product_images', true);

                // Don't show slider if only one image has been uploaded.
                if ( count($images) > 1 ):
                  echo '<ul id="product-slider">';
                else:
                  echo "<ul>";
                endif;
                
                foreach ($images as $image) {
            ?>
                <li>
                  <figure class="image is-1by1">
                    <a href="#">
                      <img src="<?php echo $image['kp_product_image_field_id']['url']; ?>" alt="Product Image" />
                    </a>
                  </figure>
                </li>
            <?php
                }
              }
            ?>
          </ul>
           
        </div>
        <div class="column is-half">
          <h2 class="title is-4"><?php _e('Technical Facts', 'karuk'); ?></h2>
          <?php echo $post_custom['kp_products_table'][0]; ?>

          <br />

          <a href="<?php echo $post_custom['kp_manufacturer'][0]; ?>" class="button is-light is-small" itemprop="manufacturer">
            <span><?php _e('Manufacturer', 'karuk'); ?></span>
          </a>
          <a href="<?php echo $post_custom['kp_datasheet'][0]; ?>" class="button is-light is-small"><?php _e('Datasheet', 'karuk'); ?></a>
        </div>
      </div>
    </div>
  </section>


  <?php 
  $files = get_post_meta(get_the_ID(), 'kp_product_files', true); 
  ?>
  <section id="downloads" class="section">
    <div class="container">
      <div class="columns">
        <?php if ($files != ''): ?>
        <div class="column">
          <h4 class="title is-5">Downloads</h4>
          <table class="table is-hoverable is-fullwidth">
            <thead>
              <tr>
                <td><?php _e('File', 'karuk-products') ?></td>
              </tr>
            </thead>
            <tbody>
              <?php 
              foreach ($files as $file) {
                $file_url = $file['kp_product_file_field_id']['url'];
                $ext_re = '/[\w|\.|:|\/|-]+\/([\w|\.|:|\/|-]+)\.(\w+)/m';
                preg_match_all($ext_re, $file_url, $ext, PREG_SET_ORDER, 0);

                switch ($ext[0][2]) {
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
                <tr>
                  <td class="level is-mobile">
                    <a href="<?php echo $file_url; ?>" title="<?php echo $file_url; ?>" target="_new" class="level-left">
                      <span class="icon is-medium level-item">
                        <i class="fa fa-2x fa-<?php echo $ext_class; ?>"></i>
                      </span>
                      <span class="level-item"><?php echo $ext[0][1]; ?></span>
                    </a>
                  </td>
                </tr>
                
              <?php 
              }
              ?>
            </tbody>
          </table>
        </div>
        <?php endif; ?>
        <div class="column">
          <h4 class="title is-5"><?php echo $post_custom['kp_info_title'][0]; ?>  </h4>
          <div class="content">
            <?php echo $post_custom['kp_info_content'][0]; ?>
          </div>
        </div>
      </div>
    </div>
  </section>


  <section class="section" id="fitting_products">
    <div class="container">
    <h3 class="title is-4"><?php _e('Fitting Products', 'karuk'); ?></h3>
      
      <?php karuk_fitting_products(6, wp_get_post_tags($post->ID)); ?> 
       
    </div>
  </section>
</main>


<?php
get_footer();

