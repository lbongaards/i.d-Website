<?php get_header(); ?>





<!-- ****** -->
<!-- EVENTS -->
<!-- ****** -->
<section class="events">

<?php $today = date('Ymd');
$upcoming_loop = new WP_Query( array(
  'post_type' => 'event',
  'posts_per_page' => 4,
  'meta_query' => array(
	array(
	  'key'     => 'start_datetime',
	  'compare' => '>=',
	  'value'   => $today,
	  'type'    => 'DATE'
	),
  ),
  'orderby' => 'start_datetime',
  'order' => 'ASC',
) );
if ($upcoming_loop->have_posts()) :
	$upcoming_no = 0; ?>

	<?php while($upcoming_loop->have_posts()) : $upcoming_loop->the_post();
		if($upcoming_no === 0): ?>

    <?php include 'inc/frontpage-event.php'; ?>

	<div class="events--small">
	<?php else:
	  if($upcoming_no === 1) { ?>
		<article class="event--small">
		  <h2 class="events--small__series-title">Upcoming events</h2>
		</article>

	  <?php }

	  include( 'inc/small-event.php' );

		endif;
		$upcoming_no++;
		endwhile; endif; ?>

	</div>

	<hr class="events--divider">

	<div class="events--small">
	  <?php
		wp_reset_postdata();
		$past_loop = new WP_Query( array(
		  'post_type' => 'event',
		  'posts_per_page' => 3,
		  'meta_query' => array(
			array(
			  'key'     => 'start_datetime',
			  'compare' => '<',
			  'value'   => $today,
			  'type'    => 'DATE'
			),
		  ),
		  'orderby' => 'start_datetime',
		  'order' => 'DESC',
		) );
		if ($past_loop->have_posts()) : ?>
		<div class="event--small event--small--end">
		  <h2 class="events--small__series-title">Past events</h2>
		</div>
	<?php
		  while($past_loop->have_posts()) {
			$past_loop->the_post();
			include( 'inc/small-event.php' );
		  } endif; ?>

	</div>
	</section>

<?php wp_reset_postdata(); ?>





<!-- ********* -->
<!-- VACANCIES -->
<!-- ********* -->
<?php
// filter
function my_posts_where( $where ) {

	$where = str_replace("meta_key = 'dates_%", "meta_key LIKE 'dates_%", $where);

	return $where;
}

add_filter('posts_where', 'my_posts_where');


// find todays date
$date = date('Ymd');

// args
$args = array(
	'post_type' => 'vacancy',
	'meta_query'	=> array(
		'relation'		=> 'AND',
		array(
			'key'		=> 'dates_%_start_date',
			'compare'	=> '<=',
			'value'		=> $date,
		),
		array(
			'key'		=> 'dates_%_end_date',
			'compare'	=> '>=',
			'value'		=> $date,
		)
	)
);

$vacancy_loop = new WP_Query( $args );
if($vacancy_loop->have_posts()) : ?>
<section class="vacancies">
	<?php while($vacancy_loop->have_posts()) : $vacancy_loop->the_post(); ?>

		<article class="vacancy">

			<div class="vacancy__thumb">
				<?php if ( has_post_thumbnail() ) : ?>
					<?php the_post_thumbnail('vacancy__img', array(
						'class' => 'vacancy__img')); ?>
				<?php endif; ?>
			</div>

			<div class="vacancy__content">
				<h3 class="vacancy__title">
					Vacancy:
					<?php
						$categories = get_the_category();

						if ( ! empty( $categories ) ) {
							echo esc_html( $categories[0]->name );
						}
					?>
				</h3>
				<p><?php the_title(); ?></p>
				<?php

				$file = get_field('vacancy_attachment');

				if( $file ): ?>

					<a target="_blank" class="button"
			href="<?php echo $file['url']; ?>">
			<i class="fa fa-file-text-o"></i> Attachment
		  </a>

				<?php endif; ?>
			</div>

		</article>

	<?php endwhile; ?>

  <div class="vacancy">
		<a class="vacancy__archivelink"
      href="<?php echo get_post_type_archive_link( 'vacancy' ); ?>">
      All vacancies
    </a>
	</div>

  </section>

<?php
endif;

wp_reset_postdata();
?>





<!-- ****** -->
<!-- SOCIAL -->
<!-- ****** -->
<section class="social">
	<h2>Social Media</h2>
	<div class="social__wrapper">
		<?php include 'inc/social-feed.php'; ?>
	</div>
</section>





<!-- **** -->
<!-- BLOG -->
<!-- **** -->
<h2>Nieuws en blog</h2>
<section class="news">
	<?php
		$args = array( 'post_type' => 'post', 'posts_per_page' => 6 );
		$loop = new WP_Query( $args );
    if($loop->have_posts()) : while($loop->have_posts()) :
			$loop->the_post();
			include 'inc/small-news-item.php';
		endwhile; endif;
		wp_reset_postdata();
	?>
</section>



<?php get_footer(); ?>
