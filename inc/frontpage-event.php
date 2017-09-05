<article class="event--page__header colorVibrant">
	<a href="<?php the_permalink(); ?>" class="event--page__link">
		<div class="event--page__short-info">

			<span class="event--page__indication"><?php esc_attr_x('Up next', 'frontpage up next title', 'svid-theme-domain');?></span>
			<h2 class="event--page__name"><?php the_title(); ?></h2>

			<?php
				$start = new DateTime(get_field('start_datetime'));
				$start->setTimezone( new DateTimeZone('Europe/Amsterdam') );

				$end = new DateTime(get_field('end_datetime'));
				$end->setTimezone( new DateTimeZone('Europe/Amsterdam') );

				$start_month = $start->format('F');
				$start_day   = $start->format('jS');

				$end_month = $end->format('F');
				$end_day   = $end->format('jS');

				$start_time = $start->format('H:i');
				$end_time   = $end->format('H:i');

				$location_name = get_field('location_name');
			?>
			<div class="event--page__datetime">
				<?php
					echo $start_month . ' ' . $start_day . ', '. $start_time . ' – ';
					if ($start_day != $end_day){
						echo $end_month . ' ' . $end_day . ', ' . $end_time;
					} else {
						echo $end_time;
					}
					echo ($location_name) ? ' @ ' . $location_name : '';
				?>
			</div>

			<?php if ( has_post_thumbnail() ) : ?>
			<div class="event--page__thumb event--frontpage__thumb colorVibrantGradient">
				<?php
				the_post_thumbnail(
					'large',
					array('class' => 'event--page__img')
				);
				?>
			</div>
			<?php endif; ?>

		</div>
	</a>
</article>
