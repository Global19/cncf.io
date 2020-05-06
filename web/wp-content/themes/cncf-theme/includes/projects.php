<?php
/**
 * Projects Shortcode
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

 /**
  * Add Projects shortcode.
  *
  * @param array $atts Attributes.
  */
function add_projects_shortcode( $atts ) {

	// Attributes.
	$atts = shortcode_atts(
		array(
			'stage' => 'graduated', // set default.
		),
		$atts,
		'projects'
	);

	$chosen_taxonomy = $atts['stage'];

	if ( ! is_string( $chosen_taxonomy ) ) {
		return;
	}

	$query_args = array(
		'post_type'      => 'cncf_project',
		'post_status'    => array( 'publish' ),
		'posts_per_page' => -1,
		'tax_query'      => array(
			array(
				'taxonomy' => 'cncf-project-stage',
				'field'    => 'slug',
				'terms'    => $chosen_taxonomy,
			),
		),
		'orderby'        => 'title',
		'order'          => 'ASC',
	);

	$project_query = new WP_Query( $query_args );
	if ( $project_query->have_posts() ) {
		ob_start();
		?>

<div class="projects-wrapper">
		<?php
		while ( $project_query->have_posts() ) :
			$project_query->the_post();

			// project stage.
			$project_stage = Cncf_Utils::get_term_names( get_the_ID(), 'cncf-project-stage', true );

			$project_category = get_post_meta( get_the_ID(), 'cncf_project_category', true );

			$github = get_post_meta( get_the_ID(), 'cncf_project_github', true );

			$stack_overflow = get_post_meta( get_the_ID(), 'cncf_project_stack_overflow', true );

			$dev_stats = get_post_meta( get_the_ID(), 'cncf_project_dev_stats', true );

			$logos = get_post_meta( get_the_ID(), 'cncf_project_logos', true );

			$mail = get_post_meta( get_the_ID(), 'cncf_project_mail', true );

			$blog = get_post_meta( get_the_ID(), 'cncf_project_blog', true );

			$twitter = get_post_meta( get_the_ID(), 'cncf_project_twitter', true );

			$slack = get_post_meta( get_the_ID(), 'cncf_project_slack', true );

			$youtube = get_post_meta( get_the_ID(), 'cncf_project_youtube', true );

			$gitter = get_post_meta( get_the_ID(), 'cncf_project_gitter', true );

			$image = new Image();

			?>
	<div class="project-box">
		<!-- thumbnail  -->
			<?php
			if ( has_post_thumbnail() ) {
				echo wp_get_attachment_image( get_post_thumbnail_id(), 'project', false, array( 'class' => 'project-thumbnail' ) );
			} else {
				?>
		<img src="https://via.placeholder.com/100x100/d9d9d9/000000" alt=""
			class="project-thumbnail">
				<?php
			}
			?>

		<h3 class="project-title"><?php the_title(); ?></h3>

			<?php if ( $project_category ) : ?>
		<h6 class="project-category">
				<?php echo esc_html( $project_category ); ?></h6>
		<?php endif; ?>

		<div class="project-icons">

			<?php if ( $github ) : ?>
			<a title="<?php the_title(); ?> on Github"
				href="<?php echo esc_html( $github ); ?>"
				rel="noreferrer noopener"><?php $image->get_svg( '/social/github.svg' ); ?></a>
			<?php endif; ?>

			<?php if ( $dev_stats ) : ?>
			<a title="<?php the_title(); ?> on DevStats"
				href="<?php echo esc_html( $dev_stats ); ?>"
				rel="noreferrer noopener"><?php $image->get_svg( '/social/cncf-devstats.svg' ); ?></a>
			<?php endif; ?>

			<?php if ( $logos ) : ?>
			<a title="<?php the_title(); ?> Logos"
				href="<?php echo esc_html( $logos ); ?>"
				rel="noreferrer noopener"><?php $image->get_svg( '/social/cncf-artwork.svg' ); ?></a>
			<?php endif; ?>

			<?php if ( $stack_overflow ) : ?>
			<a title="<?php the_title(); ?> on Stack Overflow"
				href="<?php echo esc_html( $stack_overflow ); ?>"
				rel="noreferrer noopener"><?php $image->get_svg( '/social/stack-overflow.svg' ); ?></a>
			<?php endif; ?>

			<?php if ( $twitter ) : ?>
			<a title="<?php the_title(); ?> on Twitter"
				href="<?php echo esc_html( $twitter ); ?>"
				rel="noreferrer noopener"><?php $image->get_svg( '/social/twitter.svg' ); ?></a>
			<?php endif; ?>

			<?php if ( $blog ) : ?>
			<a title="<?php the_title(); ?> Blog"
				href="<?php echo esc_html( $blog ); ?>"
				rel="noreferrer noopener"><?php $image->get_svg( '/social/blog.svg' ); ?></a>
			<?php endif; ?>

			<?php if ( $mail ) : ?>
			<a title="<?php the_title(); ?> Discussions"
				href="<?php echo esc_html( $mail ); ?>"
				rel="noreferrer noopener"><?php $image->get_svg( '/social/email.svg' ); ?></a>
			<?php endif; ?>

			<?php if ( $slack ) : ?>
			<a title="<?php the_title(); ?> Slack"
				href="<?php echo esc_html( $slack ); ?>"
				rel="noreferrer noopener"><?php $image->get_svg( '/social/slack.svg' ); ?></a>
			<?php endif; ?>

			<?php if ( $youtube ) : ?>
			<a title="<?php the_title(); ?> on YouTube"
				href="<?php echo esc_html( $youtube ); ?>"
				rel="noreferrer noopener"><?php $image->get_svg( '/social/youtube.svg' ); ?></a>
			<?php endif; ?>

			<?php if ( $gitter ) : ?>
			<a title="<?php the_title(); ?> on Gitter"
				href="<?php echo esc_html( $gitter ); ?>"
				rel="noreferrer noopener"><?php $image->get_svg( '/social/gitter.svg' ); ?></a>
			<?php endif; ?>

		</div>

	</div>
			<?php
		endwhile;
		wp_reset_postdata();
	}
	?>
</div>
	<?php
	$block_content = ob_get_clean();
	return $block_content;
}
add_shortcode( 'projects', 'add_projects_shortcode' );