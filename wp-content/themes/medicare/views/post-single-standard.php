<?php

		$supertitle_html = '';
		$subtitle_html = '';

		if ( $blog_author || $blog_date || $show_comments_number ) {
				
				if ( $blog_date ) {
					$subtitle_html .= '<span class="btArticleDate">' . esc_html( date_i18n( MedicareTheme::$boldthemes_date_format, strtotime( get_the_time( 'Y-m-d' ) ) ) ) . ' </span>'; 
				}
				
				if ( $blog_author ) {
					$subtitle_html .= $author_html;
				}

				$supertitle_html .= $categories_html;

				if ( $show_comments_number ) {
					$subtitle_html .= '<a href="' . esc_url_raw( $permalink ) . '#comments" class="btArticleComments">' . $comments_number . '</a>';
				}
				
				$dash = $blog_use_dash ? "bottom" : "";
			
			
			
		} else {
			
	}

		echo '<article class="' . esc_attr( implode( ' ', get_post_class( $class_array ) ) ) . '">';
			echo '<div class="port">';
				echo '<div class="boldCell">';
				
				echo '<div class="boldRow">';
					echo '<div class="rowItem btTextLeft col-sm-12 btArticleHeader">';

						echo boldthemes_get_heading_html( $supertitle_html, get_the_title(), $subtitle_html , 'extralarge', $dash, 'btAlternateDash', '' ) ;

					echo '</div><!-- /rowItem -->';
				echo '</div><!-- /boldRow -->';

				if ( $media_html != '' ) {
					echo '<div class="boldRow bottomSmallSpaced">';
						echo '<div class="rowItem col-sm-12 btTextCenter">' . $media_html . '</div><!-- /rowItem -->';
					echo '</div><!-- /boldRow -->';
				}


							
				echo '<div class="boldRow">';
					echo '<div class="rowItem col-sm-12">';
			
				$extra_class = '';
				
				if ( $post_format == 'link' && $media_html == '' ) {
					$extra_class = 'linkOrQuote';
				}
				
						echo '<div class="btArticleBody portfolioBody ' . esc_attr( $extra_class ) . '">' . $content_html;

					echo '</div>';
				echo '</div><!-- /rowItem -->';
			echo '</div><!-- /boldRow -->';

			echo '<div class="boldRow topSmallSpaced bottomSmallSpaced">';
				echo '<div class="rowItem col-sm-6 tagsRowItem btTextLeft">';

					echo wp_kses_post( $tags_html );

				echo '</div><!-- /rowItem -->';
				echo '<div class="rowItem col-sm-6 cellRight shareRowItem btTextRight">';

					echo '<div class="socialRow">' . $share_html . '</div>';
			
				echo '</div><!-- /rowItem -->';
			echo '</div><!-- /boldRow -->';
           //if( wp_link_pages() ) { 
				echo '<div class="boldRow">';
					echo '<div class="rowItem col-sm-12 btLinkPages">';
						wp_link_pages();
					echo '</div><!-- /rowItem -->';
				echo '</div><!-- /boldRow -->';
			//}
			if ( boldthemes_get_option( 'blog_author_info' ) ) {
				echo '<div class="boldRow bottomSmallSpaced">';
					echo '<div class="rowItem col-sm-12 btAboutAutor">';
						
						echo wp_kses_post( $about_author_html );

					echo '</div><!-- /rowItem -->';
				echo '</div><!-- /boldRow -->';
			}

			echo '</div><!-- /boldCell -->';
		echo '</div><!-- /port -->';
	echo '</article>';

?>