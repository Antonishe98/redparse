<?php
<?php
set_time_limit(0);
include_once ('lib/simple_html_dom.php');
include_once ('lib/curl_query.php');
/*ACCESS TO THE NEXT PAGE*/
for ($i=1; $i<=1; $i++) {
    $html = curl_get('http://satu.kz/search?category=15230431&search_scope=product&search=%D0%9D%D0%B0%D0%B9%D1%82%D0%B8&collapse=1&search_in_region=&search_term=%D0%BA%D0%BE%D0%BD%D0%B4%D0%B8%D1%82%D0%B5%D1%80%D1%81%D0%BA%D0%B8%D0%B5&page='.$i);
    $get=str_get_html($html);
       if ($get->find('body .b-grids__item', 0)) {
        foreach ($get->find('body .b-grids__item') as $good_class) {
            if ($done = $good_class->find('h3 a', 0)) {
				$good_curl_link = curl_get($done->href);
                if ($get_good = str_get_html($good_curl_link)) {
                    if ($post = $get_good->find('body', 0)) {
						$email = $post->find('a[itemprop=email]', 0);
                        $csv = array($email->innertext);
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

?>