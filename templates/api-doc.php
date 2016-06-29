<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Page Template
 *
 * This template is the default page template. It is used to display content when someone is viewing a
 * singular view of a page ('page' post_type) unless another page template overrules this one.
 * @link http://codex.wordpress.org/Pages
 *
 * @package WooFramework
 * @subpackage Template
 */

	$doc = WpApiDoc::get_doc();
	//echo get_the_title($doc->intro)

	function api_doc_body_class($classes){
		$classes[] = 'layout-right-content';
		return $classes;
	}
	add_filter('body_class','api_doc_body_class');

	get_header();
	global $woo_options;
?>

<!-- Cowboy Coding ON -->

<style type="text/css">

    #main {
        width: 72%;
    }

    .hentry .entry {
		font-size: 1em;
		color: #444;
	}

	strong.header {
        font-size:20px;
        color:#1a212c;
    }

    p {
        margin-bottom:1em
    }

    h2,div.api-doc-item {
        margin-top:2em
    }

    .header .edit, h2 .edit, h1 .edit {
        border:1px #f36557 solid;
        border-radius:4px;
        font-style:normal;
        margin-left:5px;
        font-size:12px;
        text-align:center;
        padding:2px 5px;
        color:#f36557 !important;
    }

    .edit:hover {
        text-decoration:none;
    }

    code {
        color:#444;
    }

    h1 {
        font-size:48px;
    }

    h2 {
        border-bottom:1px #eeeeee solid;
        font-size:36px;
    }

    .api-doc-depth-2 .header {
        border-bottom:1px #eeeeee solid;
        display:block;
        font-size:24px;
        margin-bottom:10px;
    }

    .api-doc-depth-3 .header {
        font-style:italic;
        margin-right:10px;
    }

    .col-right {
        border:1px #eeeeee solid;
        padding:10px 0px 10px 10px;
        width:240px;
    }

    ul.toc-lvl-2 li {
        font-size:16px;
    }

    ul.toc-lvl-3 li {
        font-weight:normal;
    }

	strong.arguments-title{
		display:block;
		margin: 15px 0 10px;
		font-size: 20px;
		color: #666;
	}

	strong.return-title{
		display:block;
		margin: 15px 0 10px;
		font-size: 20px;
		color: #666;
	}

</style>

<!-- Cowboy Coding OFF -->

    <div id="content" class="page">

        <div class="wrapper">

        	<?php //woo_main_before(); ?>

    		<section id="main">

                <article <?php post_class(); ?>>

    				<header>
    			    	<h1 id="<?php echo WpApiDoc::get_dom_id($doc->intro) ?>"><?php echo WpApiDoc::get_title_with_edit_link( $doc->intro, false ) ?></h1>
    				</header>

                    <section class="entry">

                    	<?php echo WpApiDoc::get_content($doc->intro) ?>

                    	<?php foreach($doc->headings as $heading): ?>
							<h2 id="<?php echo WpApiDoc::get_dom_id($heading) ?>"><?php echo WpApiDoc::get_title_with_edit_link($heading) ?></h2>
						    <?php echo WpApiDoc::get_content($heading) ?>
						    <?php foreach($heading->items as $item): ?>
						    	<div id="<?php echo WpApiDoc::get_dom_id($item) ?>" class="api-doc-item api-doc-depth-2">
									<strong class="header"><?php echo WpApiDoc::get_title_with_edit_link($item) ?></strong>
									<?php if( $usage = WpApiDoc::get_usage($item) ): ?>
										<code><?php echo $usage ?></code>
									<?php endif ?>
									<?php //echo WpApiDoc::get_edit_link($item) ?>
						      		<?php echo WpApiDoc::get_content($item) ?>
									<?php if( $arguments = WpApiDoc::get_arguments($item) ): ?>
										<div class="arguments">
											<strong class="arguments-title">Arguments :</strong>
											<?php echo $arguments ?>
										</div>
									<?php endif ?>
									<?php if( $return = WpApiDoc::get_return($item) ): ?>
										<div class="return">
											<strong class="return-title">Returns :</strong>
											<?php echo $return ?>
										</div>
									<?php endif ?>
					      		</div>
								<?php foreach($item->items as $sub_item): ?>
									<div id="<?php echo WpApiDoc::get_dom_id($sub_item) ?>" class="api-doc-item api-doc-depth-3">
										<strong class="header"><?php echo WpApiDoc::get_title_with_edit_link($sub_item) ?></strong>
										<?php if( $usage = WpApiDoc::get_usage($sub_item) ): ?>
											<code><?php echo $usage ?></code>
										<?php endif ?>
										<?php //echo WpApiDoc::get_edit_link($sub_item) ?>
										<?php echo WpApiDoc::get_content($sub_item) ?>
										<?php if( $arguments = WpApiDoc::get_arguments($sub_item) ): ?>
											<div class="arguments">
												<strong class="arguments-title">Arguments :</strong>
												<?php echo $arguments ?>
											</div>
										<?php endif ?>
										<?php if( $return = WpApiDoc::get_return($sub_item) ): ?>
											<div class="return">
												<strong class="return-title">Returns :</strong>
												<?php echo $return ?>
											</div>
										<?php endif ?>
									</div>
									<?php foreach($sub_item->items as $sub_sub_item): ?>
										<div id="<?php echo WpApiDoc::get_dom_id($sub_sub_item) ?>" class="api-doc-item api-doc-depth-4">
											<strong class="header"><?php echo WpApiDoc::get_title_with_edit_link($sub_sub_item) ?></strong>
											<?php if( $usage = WpApiDoc::get_usage($sub_sub_item) ): ?>
												<code><?php echo $usage ?></code>
											<?php endif ?>
											<?php echo WpApiDoc::get_content($sub_sub_item) ?>
											<?php if( $arguments = WpApiDoc::get_arguments($sub_sub_item) ): ?>
												<div class="arguments">
													<strong class="arguments-title">Arguments :</strong>
													<?php echo $arguments ?>
												</div>
											<?php endif ?>
											<?php if( $return = WpApiDoc::get_return($sub_sub_item) ): ?>
												<div class="return">
													<strong class="return-title">Returns :</strong>
													<?php echo $return ?>
												</div>
											<?php endif ?>
										</div>
									<?php endforeach ?>
								<?php endforeach ?>
							<?php endforeach ?>
						<?php endforeach ?>

                   	</section><!-- /.entry -->

                </article><!-- /.post -->

    		</section><!-- /#main -->

    		<?php //woo_main_after(); ?>

            <aside class="col-right">
				<!--<div style="">-->
                <?php foreach($doc->headings as $heading): ?>


                    <!--<div id="" class="widget">-->
		           		<h3>
		           			<a href="#<?php echo WpApiDoc::get_dom_id($heading) ?>">
				      			<?php echo get_the_title($heading) ?>
				    		</a>
				    	</h3>
		           		<ul class="toc-lvl-2">
		           			<?php foreach($heading->items as $item): ?>
								<li style="margin-top:10px;">
									<a href="#<?php echo WpApiDoc::get_dom_id($item) ?>"><?php echo get_the_title($item) ?></a>
									<?php if( !empty($item->items) ): ?>
										<ul class="toc-lvl-3">
											<?php foreach($item->items as $sub_item): ?>
												<li>
													<a href="#<?php echo WpApiDoc::get_dom_id($sub_item) ?>"><?php echo get_the_title($sub_item) ?></a>
													<?php if( !empty($sub_item->items) ): ?>
														<ul class="toc-lvl-4">
															<?php foreach($sub_item->items as $sub_sub_item): ?>
																<li>
																	<a href="#<?php echo WpApiDoc::get_dom_id($sub_sub_item) ?>"><?php echo get_the_title($sub_sub_item) ?></a>
																</li>
															<?php endforeach ?>
														</ul>
													<?php endif ?>
												</li>
											<?php endforeach ?>
										</ul>
									<?php endif ?>
								</li>
							<?php endforeach ?>
						</ul>
					<!--</div>-->
				<?php endforeach ?>

                    <!--</div>-->
            </aside>

        </div><!-- /.wrapper -->

    </div><!-- /#content -->

<?php get_footer(); ?>