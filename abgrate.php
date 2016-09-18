<?php
set_time_limit(0);
include_once ('lib/simple_html_dom.php');
include_once ('lib/curl_query.php');
/*ACCESS TO THE NEXT PAGE*/
for ($i=36; $i<=40; $i++) {
    $html = curl_get('http://www.voelkner.de/search/fact-search.html?keywords=weller&page='.$i);
    $get = str_get_html($html);
	$get_link=$get->find('body .off-canvas-wrap .inner-wrap .main-section #search-pages div[itemtype=http://schema.org/ItemList]', 0);
	$subination = $get_link->find('div');
       if ($get_link=$get->find('body .off-canvas-wrap .inner-wrap .main-section', 0)) {
        foreach ($subination as $good_class) {
            if ($done = $good_class->find('div .small-9 .row div a', 0)) {
                $good_curl_link = curl_get($done->href);
                if ($get_good = str_get_html($good_curl_link)) {
                    if ($post = $get_good->find('body .off-canvas-wrap .inner-wrap .main-section #product-detail', 0)) {
						$good_full_text = $post->find('.xlarge-8 .row .margin-top-m div', 2);
						$good_text = $get_good->find('body .off-canvas-wrap .inner-wrap .main-section #main h1', 0);
						$good_art = $post->find('.row .show-for-xlarge-up .row .small-7', 0);
						$ean = $post->find('.row .show-for-xlarge-up .row .small-7', 2);
						$tech_table = $post->find('.row .tech-table', 0); 
						$mark = $post->find('.row .tech-table tr', 3);
						$good_price = $post->find('.price-big span span', 0);
                        $good_cat_2 = $get_good->find('#container .topmain .main #content .breadcrumb span', 1);
                        $good_cat_4 = $get_good->find('#container .topmain .main #content .breadcrumb span', 3);
                        $good_cat_5 = $get_good->find('#container .topmain .main #content .breadcrumb span', 4);
                        //$good_sub_cat = $good_cat->find('a', 0);
                        $good_material = $get_good->find('#container .topmain .main #content .product-info .row .col-md-16 .kitchen-panel-info .row .col-md-11 .kitchen-details .kitchen-block .kitchen-list .row', 8);
                        $good_photo_select = $get_good->find('#container .topmain .main #content .product-info .row .col-md-8', 0);
                        $good_photo = $post->find('img', 0);
                        if($good_photo_2 = $get_good->find('body #container .topmain .main #content .product-info .row #add-gallery div', 1)) {
                            $sub_good_photo_2 = $good_photo_2->find('a img', 0);
                        }
                        if($good_photo_3 = $get_good->find('body #container .topmain .main #content .product-info .row #add-gallery div', 2)) {
                          $sub_good_photo_3 = $good_photo_3->find('a img', 0);
                        }
                        $csv = array($good_text->innertext . '$' .$sub_full_text->innertext. '$' .$tech_table->innertext. '$' .$good_art->plaintext.'$'.$ean->plaintext.'$'.$good_price->plaintext.'$'.$good_material->plaintext.'$'.$done->href.'$'.$good_photo->src.'$'.$good_photo->src.'|'.$sub_good_photo_2->src.'|'.$sub_good_photo_3->src.'$'.$good_cat_2->plaintext.'|'.$good_cat_4->plaintext.'|'.$good_cat_5->plaintext.'$'.$mark->plaintext.'$'.$fac1->plaintext);
                        //если указать w, то  ифнормация которая была в csv будет затерта
                        $handle = fopen('file.csv', "a");

                        foreach ($csv as $value) {
                            //Проходим массив
                            //Записываем, 3-ий параметр - разделитель поля
                            fputcsv($handle, explode('$', $value), '$');
                        }
                        fclose($handle); //Закрываем

                        echo 'Operation is done!' . '</br>';
                    }
                } else { echo 'Can`t open a href';}
            } else { echo 'Can`t find a href';}

        }
     }
    else {
        echo "Nothing in .main_content";
    }
   }
