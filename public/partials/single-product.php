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
    the_post();

  ?>

	<section class="section">
    <div class="container">
      <figure class="image is-3by1"><img src="<?php the_post_thumbnail(); ?>" alt="Big Image" /></figure>
    </div>
  </section>


  <section class="section">
    <div class="container has-text-centered">
      <h1 class="title"><?php the_title(); ?></h1>
      <h2 class="subtitle"><?php echo get_post_custom()['kp_subtitle'][0]; ?></h2>
      <div class="content">
        <p>
          <?php the_content(); ?>
        </p>
        <span class="tag is-light">#4K</span>
        <span class="tag is-light">#Cinema</span>
        <span class="tag is-light">#Camera</span>
      </div>
    </div>
  </section>r


  <section class="section">
    <div class="container">
      <div class="columns">
        <div class="column ">
          <figure class="image">
            <a href="#">
              <img src="https://via.placeholder.com/600x350" alt="Product Image" />
            </a>
          </figure> 
        </div>
        <div class="column">
          <h2 class="title is-4">Datenblatt</h2>
          <table class="table is-fullwidth is-hoverable">
            <thead>
              <tr>
                <th>One</th>
                <th>Two</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Three</td>
                <td>Four</td>
              </tr>
              <tr>
                <td>Five</td>
                <td>Six</td>
              </tr>
              <tr>
                <td>Seven</td>
                <td>Eight</td>
              </tr>
              <tr>
                <td>Nine</td>
                <td>Ten</td>
              </tr>
              <tr>
                <td>Eleven</td>
                <td>Twelve</td>
              </tr>
            </tbody>
          </table>
          <a href="<?php echo get_post_custom()['kp_manufacturer'][0]; ?>" class="button is-light is-medium">Link zum Hersteller</a>
          <a href="<?php echo get_post_custom()['kp_datasheet'][0]; ?>" class="button is-light is-medium">Datenblatt</a>
          <a href="#" class="button is-light is-medium">Download</a>
        </div>
      </div>
    </div>
  </section>


  <section class="section">
    <div class="container">
      <div class="columns">
        <div class="column">
          <div class="content">
            <h3 class="title is-4"><?php echo get_post_custom()['kp_info_title_1'][0]; ?></h3>
            <p>
              <?php echo get_post_custom()['kp_info_content_1'][0]; ?>
            </p>
          </div>
        </div>
        <div class="column">
          <div class="content">
            <h3 class="title is-4"><?php echo get_post_custom()['kp_info_title_2'][0]; ?></h3>
            <p>
              <?php echo get_post_custom()['kp_info_content_2'][0]; ?>
            </p>
          </div>
        </div>
        <div class="column">
          <div class="content">
            <h3 class="title is-4"><?php echo get_post_custom()['kp_info_title_3'][0]; ?></h3>
            <p>
              <?php echo get_post_custom()['kp_info_content_3'][0]; ?>
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>


  <section class="section">
    <div class="container has-text-centered">
      <a href="#" class="button is-medium is-black">Weitere Produkte &gt;</a>
    </div>
  </section>


<?php
endwhile; // End of the loop.
get_footer();

