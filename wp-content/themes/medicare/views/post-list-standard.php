<?php

	$share_html = '<div class="btIconRow">' . boldthemes_get_share_html( $permalink, 'blog', 'btIcoSmallSize', 'btIcoOutlineType btIcoAccentColor' ) . '</div>';

	$supertitle_html = '';
	$subtitle_html = '';

	if ( $blog_author || $blog_date || $show_comments_number ) {
		if ( ! $blog_side_info ) {
			
			if ( $blog_date ) {
				$supertitle_html .= '<span class="btArticleDate">' . esc_html( date_i18n( MedicareTheme::$boldthemes_date_format, strtotime( get_the_time( 'Y-m-d' ) ) ) ) . ' </span>'; 
			}
			
			if ( $blog_author ) {
				$supertitle_html .= $author_html;
			}

			$supertitle_html .= $categories_html;

			if ( $show_comments_number ) {
				$supertitle_html .= '<a href="' . esc_url_raw( $permalink ) . '#comments" class="btArticleComments">' . $comments_number . '</a>';
			}
			
			$dash = $blog_use_dash ? "top" : "";
		} else {
			$supertitle_html .= $categories_html;
			$dash = $blog_use_dash ? "top" : "";
			if ( $show_comments_number ) {
				$supertitle_html .= '<a href="' . esc_url_raw( $permalink ) . '#comments" class="btArticleComments">' . $comments_number . '</a>';
			}
		}
		
		
	} else {
		
	}

	
	
	echo '<article class="' . esc_attr( implode( ' ', get_post_class( $class_array ) ) ) . '">';
		echo '<div class="port">';
			echo '<div class="boldCell">';
			if($media_html != "") {
				echo '<div class = "boldRow">';
					echo '<div class="rowItem col-sm-12 btTextCenter">' . $media_html . '</div>';
				echo '</div><!-- /boldRow -->';
			}

			if ( $blog_side_info && ! is_search() ) {
				echo '<div class="articleSideGutter btTextCenter">';
				$avatar_html = get_avatar( get_the_author_meta( 'ID' ), 144 ); 
					
				if ( $avatar_html != '' ) {
					echo '<div class="asgItem avatar"><a href="' . esc_url_raw( $author_url ) . '">' . $avatar_html . '</a></div>';
				}
				if ( $blog_author ) {
					echo '<div class="asgItem title"><span>' . $author_html . '</span></div>';
				}
				if ( $blog_date ) {
					echo '<div class="asgItem date"><small><span class="btArticleDate">' . date_i18n( "d", strtotime( ( $blog_date ) ) ) . "/". date_i18n( "M", strtotime( ( $blog_date ) ) ). "/". date_i18n( "Y", strtotime( ( $blog_date ) ) ) . '</span></small></div>';
				}	
				
				echo '</div>';
			}
			
				$extra_class = '';
				if ( $post_format == 'link' && $media_html == '' ) {
					$extra_class = 'linkOrQuote';
				}
				echo '<div class="boldRow btArticleListBody' . $extra_class . '">';
					echo '<div class="rowItem col-sm-12">';
						echo '<div class="rowItemContent">';
							echo '<div class="btClear btSeparator bottomSmallSpaced noBorder"><hr></div>';
							echo boldthemes_get_heading_html( $supertitle_html, '<a href="' . esc_url_raw( $permalink ) . '">' . get_the_title() . '</a>', $subtitle_html, 'large', $dash, 'btAlternateDash', '' );
							echo '<div class="btArticleListBodyContent">' . $content_final_html . '</div>';
						echo '</div>' ;
						echo '<div class="btClear btSeparator bottomSmallSpaced border"><hr></div>';
					echo '</div>';
				echo '</div><!-- /boldRow -->';
				
			
				echo '<div class="boldRow btArticleFooter">';
					// echo '<div class="rowItem col-sm-6 col-ms-12 btTextLeft btReadArticle">' . boldthemes_get_icon_html( 'fa_f129', $permalink, esc_html__( 'CONTINUE READING', 'medicare' ), 'btIcoOutlineType btIcoAccentColor btIcoExtraSmallSize' ) . '</div>';
					echo '<div class="rowItem col-sm-6 col-ms-12 btTextLeft btReadArticle"><a class="btContinueReading" href="' . $permalink . '">' . esc_html__( 'CONTINUE READING', 'medicare' ) . '</a></div>';
					echo '<div class="rowItem col-sm-6 col-ms-12 btTextRight btShareArticle">' . $share_html . '</div>';
				echo '</div><!-- /boldRow -->';
			echo '</div><!-- boldCell -->';			
		echo '</div><!-- port -->';
	echo '</article><!-- /articles -->';

?>