<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


Route::get('/', 'IndexController@showIndex');
Route::get('/index/{lastIndex}', 'IndexController@getIndexLibraries');
Route::get('/featured', 'IndexController@showFeatured');
Route::get('/lib/{slug}', 'LibraryController@showLibrary');

# User Routes
Route::get('/login', 'UserController@showLogin');
Route::get('/register', 'UserController@showRegister');
Route::get('/logout', 'UserController@logout');
Route::get('/activate/{userId}/{code}', 'UserController@activate');
Route::post('/login', 'UserController@processLogin');
Route::get('/login/github', 'UserController@gitHubAuth');
Route::post('/register', 'UserController@processRegister');
Route::post('/forgot/password', 'UserController@forgotPassword');

Route::post('/search/libraries/', 'LibraryController@searchLibraries');
Route::get('/search/{slug}', 'LibraryController@categorizeLibraries');

Route::post('/submit', 'LibraryController@submitLibrary');
Route::get('/lib/get/stats', 'LibraryController@getStatsAsJson');
Route::post('/lib/image/suggest', 'LibraryController@suggestImage');


Route::group(['before' => 'auth'], function() {

    Route::get('/user/profile', 'UserController@showProfile');
    Route::post('/user/profile/update', 'UserController@updateProfile');
    Route::post('/lib/like', 'UserController@likeLibrary');
});
Route::get('/user/{username}', 'UserController@showOtherProfile');

Route::group(['before' => 'admin'], function() {
    Route::get('/admin', 'AdminController@showAdmin');
    Route::post('/admin/add', 'AdminController@addLibrary');
    # Ajax Routes
    Route::get('/admin/{type}/get', 'AdminController@getLibs');
});


# Lib Routes
Route::get('/admin/lib/accept/{id}', [ 'before' => 'admin', 'uses' => 'AdminController@acceptLibrary']);
Route::get('/admin/lib/decline/{id}/{reason}',  [ 'before' => 'admin', 'uses' => 'AdminController@declineLibrary']);
Route::get('/admin/lib/remove/{id}',  [ 'before' => 'admin', 'uses' => 'AdminController@removeLibrary']);
Route::post('/admin/lib/add',  [ 'before' => 'admin', 'uses' => 'AdminController@addLibrary']);

# Show mail in cool design
Route::get('/mail/{type}', function ($type) {
    if ($type == "submitted")
        return View::make('emails.submitted');
    else if ($type == "accepted")
        return View::make('emails.accepted');
    else if ($type == "declined")
        return View::make('emails.declined');
});


# In route handling
Route::get('/submit', 'IndexController@showSubmit');

Route::get('/sitemap', 'IndexController@getSiteMap');
Route::get('/sitemap.xml', 'IndexController@getSiteMap');

Route::get('/rss', function() {
    $oLibs      = Libraries::with('categories')->where('public', '=', true)->orderBy('created_at', 'desc')->get();
    $oFeed = Rss::feed('2.0', 'UTF-8');
    $oFeed->channel([
            'title'         => 'Android-Libs.com RSS Feed',
            'description'   => 'A list of libraries from android-libs.com',
            'link'          => 'http://android-libs.com'
        ]);

    foreach($oLibs as $oLib)
    {
        $iLikes = Like::where('library_id', '=', $oLib->id)->count();
        $oFeed->item([
            'title'             => $oLib->title . ' (' . $oLib->categories->name . ')',
            'description|cdata' => $oLib->getShortenedDescription(),
            'pubDate'           => $oLib->created_at->toRfc2822String(),
            'link'              => 'http://android-libs.com/lib/' . $oLib->slug
        ]);
    }

    return Response::make($oFeed, 200, ['Content-Type' => 'text/xml']);
});

Route::get('/test', function() {
    set_time_limit(0);




    # Licenses
    $oLibs      = Libraries::all();
    $aFileNames = [ 'README', 'README.md' ];
    $i = 0;
    foreach($aFileNames as $sFile)
    {
        foreach($oLibs as $oLib)
        {
            if($oLib->isGitHubUrl())
            {
                try {
                    $aGitHub            = GitHub::repo()->contents()->show($oLib->getGitHubUserName(), $oLib->getGitHubRepoName(), '/' . $sFile);
                    $sDecodedContent    = base64_decode($aGitHub['content']);

                    if(preg_match("/compile '([a-z].*)'/i", $sDecodedContent, $aCompStrings) === 1)
                    {
                        if(count($aCompStrings) == 2)
                        {
                            $oLib->gradle = $aCompStrings[1];
                            $oLib->save();
                            $i++;
                        }
                    }

                } catch (Exception $ex) {
                    /*if($i == 2)
                    {
                        return Response::json(['error' => true, 'message' => $ex->getMessage()]);
                    }*/
                }
            }
        }
    }
    return Response::json(['libs_changed' => $i ]);

    /*
    # Licenses
    $aFileNames = [ 'LICENSE', 'LICENSE.md', 'LICENSE.txt' ];
    $i = 0;
    foreach($aFileNames as $sFile)
    {
        try {
            $aGitHub            = GitHub::repo()->contents()->show('square', 'android-times-square', '/' . $sFile);
            $aGitHub['error']   = false;
            return Response::json($aGitHub);

        } catch (Exception $ex) {
            if($i == 2)
            {
                return Response::json(['error' => true, 'message' => $ex->getMessage()]);
            }
        }
        $i++;


    return Response::json($aGitHub);
    }*/
});