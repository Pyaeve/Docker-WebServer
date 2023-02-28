<?php

    namespace App\Http\Controllers;
    use Goutte\Client;
    use Illuminate\Http\Request;
    use JanDrda\LaravelGoogleCustomSearchEngine\LaravelGoogleCustomSearchEngine;
    class SEOController extends Controller
    {
        //private creal
        private $crawler;
        function analizar(Request $req){

                //
          
           $seo_tags= ['title','description','keywords','viewport','robots'];    
           $og_tags = ['og:title','og:url','og:locale','og:title','og:description','og:site','og:site_name','og:image','og:type'];
           $tw_tags = ['twitter:title','twitter:url','twitter:card','twitter:description','twitter:site','twitter:card','twitter:image'];
            //$url =  'https://farmaciacatedral.com.py/v2/producto/nutrilon-premium-3-duopack-80040017257';
            if(isset($_GET['url'])){

                $domain = parse_url($_GET['url']);
               // dd($domain);
                $url = $_GET['url'];
                $client = new Client();
                $crawler = $client->request('GET', $url);
                $response = $client->getResponse();
                $headers =$response->getHeaders();
              //  dd($headers);
                $gzip = 0;
                if(isset($headers['content-encoding'][0]) && $headers['content-encoding'][0]=='gzip'){
                    $gzip = 1;
                }else{
                    $gzip=0;
                }

                //die($headers['Content-Encoding'][0]); 
             
                $links = $crawler->filter('a')->each(function($node) {

                    return [
                        'href'=>$node->attr('href'),
                        'title' => $node->attr('title'),
                        'alt' => $node->attr('alt'),
                        'rel'=> $node->attr('rel')
                    ];




                });
                // Get the latest post in this category and display the titles
                // dd($links);
               // dd($links);

                $imgs = $crawler->filter('img')->each(function($node) {

                    return [
                        'src'=>$node->attr('src'),
                        'title' => $node->attr('title'),
                        'alt' => $node->attr('alt'),
                        
                    ];

                });
 //dd($imgs);
                $title = $crawler->filterXpath('//title')->text();
                $metas = $crawler->filter('meta')->each(function($node) {

                    return [
                        'property'=>$node->attr('property'),
                        'name' => $node->attr('name'),
                        'content' => $node->attr('content'),
                    ];




                });




         
                $jsonLd = $crawler->filter('script[type="application/ld+json"]')->each(function ($node) {

                    return [
                        'property'=>'script',
                        'name' => 'jsonLd',
                        'content' => $node->text(),
                    ];




                });


                $robots  = $client->request('GET', $url.'/robots.txt');
                $response = $client->getResponse();
               if ($response->getStatusCode() === 200) {
                 $robots = 1;
               }else{
                 $robots =0;
               }
             

               $sitemaps  = $client->request('GET', $url.'/sitemap.xml');
                $response = $client->getResponse();
               if ($response->getStatusCode() === 200) {
                 $sitemaps = 1;
                
               }else{
                    $sitemaps  = $client->request('GET', $url.'/sitemap_index.xml');
                    $response = $client->getResponse();
                    if ($response->getStatusCode() === 200) {
                        $sitemaps = 1;
                
                    }else{
                        $sitemaps  = $client->request('GET', $url.'/sitemap-index.xml');
                        $response = $client->getResponse();
                        if ($response->getStatusCode() === 200) {
                            $sitemaps = 1;
                        }else{
                             $sitemaps =0;
                        }
                        $sitemaps =0;
                    $sitemaps =0;
               }
           }
                //$jsonLd = \jso

                $parameters = array(
                     'start' => 1, // start from the 10th results,
                     'num' => 1, // number of results to get, 10 is maximum and also default value
                    'gl' => 'py',
                'lr' => 'lang_es'
                 );


                 foreach ($metas as $node) {
                // code...
                    if($node['name']=='keywords'){
                        $keywords=$node['content'];
                    }else{
                        $node['name']='keywords';
                        $node['content']=0;
                    }

                }
                if(!empty($keywords)){
                    $keywords = explode(',',$keywords);
                }else{
                    $keywords = explode(',','site:'.$domain['host'].', SERP');
                }

                //($keywords);

                $cse = new LaravelGoogleCustomSearchEngine(); // initialize
                $serp = $cse->getResults($keywords[0],$parameters); // get first 10 results for query 'some phrase
                 //dd($metas);
                return view('app.app_seo_scrapp',['metas'=>$metas,'title'=>$title,'jsonLd'=>$jsonLd,'serp'=>$serp,'keywords'=>$keywords[0],'gzip'=>$gzip, 'robots'=>$robots,'sitemap'=>$sitemaps, 'images'=>$imgs,'links'=>$links,'seo_tags'=>$seo_tags,'og_tags'=>$og_tags,'tw_tags'=>$tw_tags]);

            }else{
                 return view('app.app_seo_scrapp');

            }


           //   dd($data);

}

private function getOgTag($property,$crawler)
  {
    $metatag = 'meta[property="og:' . $property . '"]';
    if ($crawler->filter($metatag)->count()) {
        return trim($this->crawler
                    ->filter($metatag)
                    ->first()
                    ->attr('content'));
    }
    return '';
  }

function MostrarFormAnalisisSEO(){

}  
}
