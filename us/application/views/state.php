<?php include Kohana::find_file('views', 'header') ?>


<div id="main">
	<div id="primary">
		<div id="content" role="main">
			<article id="default" class="default post type-post status-publish format-standard hentry category-uncategorized">

				<header class="entry-header">
					<h1 class="entry-title">
					<?php echo $page_h1; ?>
					</h1>
					<div class="entry-meta">
						<span class="sep"><?php echo $page_breadcrumb; ?></span>
					</div><!-- .entry-meta -->

					<?php echo ($table_of_contents != '' ? $table_of_contents : ''); ?>

				</header><!-- .entry-header -->

				<div class="entry-content">
						<?php echo $body; ?>
				</div><!-- .entry-content -->

			</article>
		</div><!-- #content -->
	</div><!-- #primary -->


<?php include Kohana::find_file('views', 'state_sidebar') ?>

<?php include Kohana::find_file('views', 'footer') ?>
<!-- #default view>