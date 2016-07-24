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

	WpApiDocCache::start();

	$doc = WpApiDoc::get_doc();
	//echo get_the_title($doc->intro)

	function api_doc_body_class($classes){
		$classes[] = 'layout-right-content';
		return $classes;
	}
	add_filter('body_class','api_doc_body_class');

	function api_doc_title( $title ) {
		return "<span>Doc / </span>". $title;
	}
	add_filter( 'single_post_title', 'api_doc_title' );
	
	get_header();
	global $woo_options;
?>

<!-- Cowboy Coding ON -->

<style type="text/css">

	h1 span {
		font-size: 45%;
	}
	
    #main {
        width: 72%;
		padding-left: 0;
		padding-top: 0;
    }
	
	aside#doc-menu{
	    float: left;
		padding: 2em 0 2em 4%;
		width: 25%;
	}
	
	aside#doc-menu h3{
		font-size: 20px;
		padding-top: 0.5em;
	}
	
	aside#doc-menu ul{
		list-style-type: none;
		padding-bottom: 0.3em;
		margin-top: 0.5em;
	}
	
	aside h2{
		font-size: 20px;
		margin: 1.5em 0 0;
	}
	
	aside h2:first-of-type{
		margin-top: 2em;
	}
	
	aside h2 span{
		font-size: 15px;
	}
	
	aside ul li.current{
		font-size: 140%;
	}

	.intro{
		padding-top:4em;
	}
	
    .hentry .entry {
		font-size: 1em;
		color: #444;
	}

	strong.header {
        font-size:20px;
        color:#1a212c;
    }
	
	#main li {
	    margin-bottom: 0.3em;
	}
	
    p {
		margin: 1em 0;
    }
	
	p + ul {
		margin-top: -0.5em;
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
	
	h3 {
	    margin-top: 3%;
	}
	
	h4 {
	    margin: 3% 0 2%;
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

<script>
/*
 Sticky-kit v1.1.2 | WTFPL | Leaf Corcoran 2015 | http://leafo.net
*/
(function(){var b,f;b=this.jQuery||window.jQuery;f=b(window);b.fn.stick_in_parent=function(d){var A,w,J,n,B,K,p,q,k,E,t;null==d&&(d={});t=d.sticky_class;B=d.inner_scrolling;E=d.recalc_every;k=d.parent;q=d.offset_top;p=d.spacer;w=d.bottoming;null==q&&(q=0);null==k&&(k=void 0);null==B&&(B=!0);null==t&&(t="is_stuck");A=b(document);null==w&&(w=!0);J=function(a,d,n,C,F,u,r,G){var v,H,m,D,I,c,g,x,y,z,h,l;if(!a.data("sticky_kit")){a.data("sticky_kit",!0);I=A.height();g=a.parent();null!=k&&(g=g.closest(k));
if(!g.length)throw"failed to find stick parent";v=m=!1;(h=null!=p?p&&a.closest(p):b("<div />"))&&h.css("position",a.css("position"));x=function(){var c,f,e;if(!G&&(I=A.height(),c=parseInt(g.css("border-top-width"),10),f=parseInt(g.css("padding-top"),10),d=parseInt(g.css("padding-bottom"),10),n=g.offset().top+c+f,C=g.height(),m&&(v=m=!1,null==p&&(a.insertAfter(h),h.detach()),a.css({position:"",top:"",width:"",bottom:""}).removeClass(t),e=!0),F=a.offset().top-(parseInt(a.css("margin-top"),10)||0)-q,
u=a.outerHeight(!0),r=a.css("float"),h&&h.css({width:a.outerWidth(!0),height:u,display:a.css("display"),"vertical-align":a.css("vertical-align"),"float":r}),e))return l()};x();if(u!==C)return D=void 0,c=q,z=E,l=function(){var b,l,e,k;if(!G&&(e=!1,null!=z&&(--z,0>=z&&(z=E,x(),e=!0)),e||A.height()===I||x(),e=f.scrollTop(),null!=D&&(l=e-D),D=e,m?(w&&(k=e+u+c>C+n,v&&!k&&(v=!1,a.css({position:"fixed",bottom:"",top:c}).trigger("sticky_kit:unbottom"))),e<F&&(m=!1,c=q,null==p&&("left"!==r&&"right"!==r||a.insertAfter(h),
h.detach()),b={position:"",width:"",top:""},a.css(b).removeClass(t).trigger("sticky_kit:unstick")),B&&(b=f.height(),u+q>b&&!v&&(c-=l,c=Math.max(b-u,c),c=Math.min(q,c),m&&a.css({top:c+"px"})))):e>F&&(m=!0,b={position:"fixed",top:c},b.width="border-box"===a.css("box-sizing")?a.outerWidth()+"px":a.width()+"px",a.css(b).addClass(t),null==p&&(a.after(h),"left"!==r&&"right"!==r||h.append(a)),a.trigger("sticky_kit:stick")),m&&w&&(null==k&&(k=e+u+c>C+n),!v&&k)))return v=!0,"static"===g.css("position")&&g.css({position:"relative"}),
a.css({position:"absolute",bottom:d,top:"auto"}).trigger("sticky_kit:bottom")},y=function(){x();return l()},H=function(){G=!0;f.off("touchmove",l);f.off("scroll",l);f.off("resize",y);b(document.body).off("sticky_kit:recalc",y);a.off("sticky_kit:detach",H);a.removeData("sticky_kit");a.css({position:"",bottom:"",top:"",width:""});g.position("position","");if(m)return null==p&&("left"!==r&&"right"!==r||a.insertAfter(h),h.remove()),a.removeClass(t)},f.on("touchmove",l),f.on("scroll",l),f.on("resize",
y),b(document.body).on("sticky_kit:recalc",y),a.on("sticky_kit:detach",H),setTimeout(l,0)}};n=0;for(K=this.length;n<K;n++)d=this[n],J(b(d));return this}}).call(this);
</script>

<!-- Cowboy Coding OFF -->

    <div id="content" class="page">

        <div class="wrapper">

			<aside id="doc-menu">
				<!--<div style="">-->
				<h2>Doc /</h2>
				<ul>
				<?php foreach( WpApiDoc::getDocRootPages() as $rootPage ): ?>
					<?php $current = is_page($rootPage->ID) ?>
					<li class="<?php echo $current ? 'current' : '' ?>">
						<?php if ( !$current ): ?>
							<a href="<?php echo get_permalink( $rootPage ) ?>">
						<?php endif ?>
						<?php echo get_the_title( $rootPage ) ?>
						<?php if ( !$current ): ?>
							</a>
						<?php endif ?>
					</li>
				<?php endforeach ?>
				</ul>
				
				<h2>In this section:</h2>
                <?php foreach($doc->headings as $heading): ?>

                    <!--<div id="" class="widget">-->
		           		<h3>
		           			<a href="#<?php echo WpApiDoc::get_dom_id($heading) ?>">
				      			<?php echo get_the_title($heading) ?>
				    		</a>
				    	</h3>
						<?php if (!empty($heading->items) ): ?>
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
						<?php endif; ?>
					<!--</div>-->
				<?php endforeach ?>

                    <!--</div>-->
            </aside>
			
			<script>jQuery("#doc-menu").stick_in_parent();</script>

    		<section id="main">

                <article <?php post_class(); ?>>

                    <section class="entry">

						<?php $intro = WpApiDoc::get_content($doc->intro) ?>
						<?php if ( !empty( $intro ) ): ?>
							<div class="intro">
								<?php echo $intro; ?>
							</div>
						<?php endif ?>
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

        </div><!-- /.wrapper -->

    </div><!-- /#content -->

<?php 

get_footer();

WpApiDocCache::end();