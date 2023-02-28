<?php
//session_start();
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Carbon\Carbon;
use SchulzeFelix\SearchConsole\Period;
use Spatie\Browsershot\Browsershot;
use JanDrda\LaravelGoogleCustomSearchEngine\LaravelGoogleCustomSearchEngine;
use Dzava\Lighthouse\Lighthouse;
   use Goutte\Client;
Route::get('/', function () {
    return view('welcome');
});

//Route::get('/home', 'HomeController@index')->name('home');


Route::get('img', function () {
    $base64Data = Browsershot::url('https://www.porta.com.py')
 
   
    ->base64Screenshot();
 
  
    return view('screenshot',['image'=>'data:image/jpeg;base64,'.$base64Data]);
}); 

Route::get('serp',function(){
   // dd($_GET);
   
    if(!empty($_GET['q'])){
        $q = $_GET['q'];
    }else{
        $q = "seo para ecommerce";
    }
    if(!empty($_GET['o'])){
        $q = $_GET['o'].$q;
    }
    if(!empty($_GET['c'])){
        $c = $_GET['c'];
    }else{
        $c = "py";
    }
     $parameters = array(
    'start' => 1, // start from the 10th results,
    'num' => 10, // number of results to get, 10 is maximum and also default value
    'gl' => $c,
    'lr' => 'lang_es'
);
    $cse = new LaravelGoogleCustomSearchEngine(); // initialize
$results = $cse->getResults($q,$parameters); // get first 10 results for query 'some phrase' 
   return view('app_cse',['results'=>$results]);
})->name('backend.serp.consultar');


Route::get('sca',function(){
       $token = $_SESSION['google_token'];
//$sites = SearchConsole::setAccessToken($token)->listSites();
  // dd($sites);  
   
 
    $data = SearchConsole::setAccessToken($token)->setQuotaUser('uniqueQuotaUserString')
        ->searchAnalyticsQuery(
            'https://pyaeveapps.com/',
            Period::create(Carbon::now()->subDays(30), Carbon::now()->subDays(2)),
            ['query', 'page', 'country', 'device', 'date'],
            [['dimension' => 'query', 'operator' => 'notContains', 'expression' => 'cheesecake']],
            1000,
            'web',
            'all',  
            'auto'
        ); 
        dd($data);
});

Route::get('auth/facebook', 'Auth\LoginFacebookController@redirect');
Route::get('auth/facebook/callback', 'Auth\LoginFacebookController@callback');
Route::get('login/google', 'Auth\LoginGoogleController@redirect');
Route::get('login/google/callback', 'Auth\LoginGoogleController@callback');




Route::get('seo','SEOController@analizar')->name('seo-analizer');   

Route::get('lsa',function(){
    return (new Lighthouse())
    
   
    ->audit('https://www.porta.py');
});

Route::get('verificar',function(){
    $parameters = array(
    'start' => 1, // start from the 10th results,
    'num' => 10, // number of results to get, 10 is maximum and also default value
    'gl' => 'py',
    'lr' => 'lang_es'
);
    $cse = new LaravelGoogleCustomSearchEngine(); // initialize
    $results = $cse->getResults('site:porta.com.py',$parameters); // get first 10 results for query 'some phrase' 
   return view('app_cse',['results'=>$results]);
}); 
Route::get('len',function(){
    $text = '¿Quieres Saber ⚠️ si tu página está Indexada en Google? Comprobarlo es Muy FÁCIL, y si no, te Enseñamos lo que DEBES Hacer ☝ Ver el paso a paso';
    echo strlen($text);
});



Route::get('/home', 'HomeController@index')->name('home');
Auth::routes();   


// Generate a login URL
Route::get('/facebook/login', function(Scottybo\LaravelFacebookSdk\LaravelFacebookSdk $fb)
{
    // Send an array of permissions to request
    $login_url = $fb->getLoginUrl(['email']);

    // Obviously you'd do this in blade :)
    echo '<a href="' . $login_url . '">Login with Facebook</a>';
});

// Endpoint that is redirected to after an authentication attempt
Route::get('/facebook/callback', function(Scottybo\LaravelFacebookSdk\LaravelFacebookSdk $fb)
{
    // Obtain an access token.
    try {
        $token = $fb->getAccessTokenFromRedirect();
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
        dd($e->getMessage());
    }

    // Access token will be null if the user denied the request
    // or if someone just hit this URL outside of the OAuth flow.
    if (! $token) {
        // Get the redirect helper
        $helper = $fb->getRedirectLoginHelper();

        if (! $helper->getError()) {
            abort(403, 'Unauthorized action.');
        }

        // User denied the request
        dd(
            $helper->getError(),
            $helper->getErrorCode(),
            $helper->getErrorReason(),
            $helper->getErrorDescription()
        );
    }

    if (! $token->isLongLived()) {
        // OAuth 2.0 client handler
        $oauth_client = $fb->getOAuth2Client();

        // Extend the access token.
        try {
            $token = $oauth_client->getLongLivedAccessToken($token);
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            dd($e->getMessage());
        }
    }

    $fb->setDefaultAccessToken($token);

    // Save for later
    Session::put('fb_user_access_token', (string) $token);

    // Get basic info on the user from Facebook.
    try {
        $response = $fb->get('/me?fields=id,name,email');
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
        dd($e->getMessage());
    }

    // Convert the response to a `Facebook/GraphNodes/GraphUser` collection
    $facebook_user = $response->getGraphUser();

    // Create the user if it does not exist or update the existing entry.
    // This will only work if you've added the SyncableGraphNodeTrait to your User model.
    $user = App\User::createOrUpdateGraphNode($facebook_user);

    // Log the user into Laravel
    Auth::login($user);

    return redirect('/')->with('message', 'Successfully logged in with Facebook');
}); 