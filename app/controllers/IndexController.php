<?php

class IndexController extends BaseController {

    /*
     * Show main page with list of android libraries
     */
    public function showIndex()
    {
        $this->data['page'] = 'libs';

        $oCats = Categories::all();
        // Select likes and group them by their categories - order them by their like count
        $oTopCats = Like::with('category')
            ->selectRaw('*, COUNT(category_id) AS likes')
            ->groupBy('category_id')
            ->orderByRaw('COUNT(category_id) DESC')
            ->take(5)
            ->get();


        $aLibs = Libraries::with('categories', 'likes')->select('*')->where('public','=', true)->limit(9)->orderBy('id', 'desc')->paginate(9);
        $libraries = $this->prepareLibrary($aLibs);

        $this->data["iUsers"]           = count(Sentry::findAllUsers());
        $this->data["libraries"]        = $libraries;
        $this->data['oPagination']      = $aLibs;
        $this->data["categories"]       = $oCats;
        $this->data["oTopCategories"]   = $oTopCats;
        $this->data["oRandomLibs"]      = Libraries::where('public', '=', true)->limit(5)->orderByRaw('RAND()')->get();
        return View::make("index", $this->data);
    }


    /*
 * Show main page with list of android libraries
 */
    public function showFeatured()
    {
        $this->data['page'] = 'libs';
        $oCats = Categories::all();
        // Select likes and group them by their categories - order them by their like count
        $oTopCats = Like::with('category')
            ->selectRaw('*, COUNT(category_id) AS likes')
            ->groupBy('category_id')
            ->orderByRaw('COUNT(category_id) DESC')
            ->take(5)
            ->get();


        $aLibs = Libraries::with('categories', 'likes')->select('*')->where('public','=', true)->where('featured', '=', true)->limit(9)->orderBy('id', 'desc')->paginate(9);
        $libraries = $this->prepareLibrary($aLibs);

        $this->data["iUsers"]           = count(Sentry::findAllUsers());
        $this->data["libraries"]        = $libraries;
        $this->data['oPagination']      = $aLibs;
        $this->data["categories"]       = $oCats;
        $this->data["oTopCategories"]   = $oTopCats;
        $this->data["oRandomLibs"]      = Libraries::where('public', '=', true)->limit(5)->orderByRaw('RAND()')->get();
        return View::make("index", $this->data);
    }


    /*
     * Shows the submit library page
     */
    public function showSubmit()
    {
        $this->data['oCategories'] = Categories::all();
        return View::make('submit', $this->data);
    }

    /*
     * Shows the about us page
     */
    public function showAbout()
    {
        return View::make('about', $this->data);
    }
    /*
     * Prepare libraries
     */
    public static function prepareLibrary($aLibs, $iIndex = 0)
    {
        // TODO: array_chunk ....
        $y = 0;
        $x = 0;
        $index = $iIndex;
        $libraries = [];
        foreach($aLibs as $lib)
        {
            if($x == 3) {
                $x = 0;
                $y++;
            }

            $lib["index"] = $index;

            if(strlen($lib["title"]) > 20)
                $lib["title"] = substr($lib["title"], 0, 20) . " " . substr($lib["title"], 20, strlen($lib["title"]));
            $lib["rating"] = round(floatval($lib["rating"]));
            $libraries[$y][$x] = $lib;
            $x++;
            $index++;
        }
        return $libraries;
    }

    /*
     * Generates a Sitemap
     */
    public static function getSiteMap()
    {
        $sitemap = App::make("sitemap");

        // Add static pages like this:
        $sitemap->add(URL::to('/'), '2014-12-10T12:30:00+02:00', '1.0', 'daily');

        // Add dynamic pages of the site like this (using an example of this very site):

        $oLibs = Libraries::all();

        foreach($oLibs as $oLib)
        {
            $sitemap->add(URL::to('/lib/' . $oLib->slug), $oLib->created_at, '0.9', 'weekly');
        }

        // Now, output the sitemap:
        return $sitemap->render('xml');
    }



}