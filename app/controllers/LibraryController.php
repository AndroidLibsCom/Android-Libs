<?php

class LibraryController extends BaseController
{

    private $catSlug = null;

    /*
     * Get github stats as json
     */
    public function getStatsAsJson()
    {
        $bIsGitHub = true;
        $iIssues   = 0;
        $iStarred  = 0;
        $oLibrary  = Libraries::find(Input::get('id', 0));
        try {
            if ($oLibrary == null) {
                throw new Exception("Library not found in database.");
            } else {

                $aGitRepo = GitHub::repo()->show($oLibrary->getGitHubUserName(), $oLibrary->getGitHubRepoName());
                $iIssues  = $aGitRepo['open_issues'];
                $iStarred = $aGitRepo['stargazers_count'];
            }
        } catch (Exception $ex) {
            $bIsGitHub = false;
        }

        return Response::json([
            'isGitHub' => $bIsGitHub,
            'issues'   => $iIssues,
            'starred'  => $iStarred
        ]);
    }


    /*
     * Get library by id
     */
    public function showLibrary($slug)
    {
        $oLib            = Libraries::with('categories', 'likes')->where('slug', '=', $slug)->first();
        $oFiveRandomLibs = Libraries::where('category_id', '=', $oLib->category_id)
            ->where('id', '!=', $oLib->id)->take(5)->orderByRaw('RAND()')->get();
        $aGitHub         = [];
        if ($oLib->isGitHubUrl()) {
            try {
                $aGitHub                        = GitHub::repo()->show($oLib->getGitHubUserName(), $oLib->getGitHubRepoName());
                $this->data['aContributors']    = GitHub::repo()->contributors($oLib->getGitHubUserName(), $oLib->getGitHubRepoName());
                $oLib->githubOk                 = true;
            } catch (Exception $ex) {
                $oLib->githubOk = false;
            }
        }
        if ($oLib != null) {

            if(Sentry::check())
            {
                $this->data['bIsLiked']        = Like::where('user_id', '=', Sentry::getUser()->getId())->where('library_id', '=', $oLib->id)->count() != 0;
            }

            $this->data['oSubmittor']      = User::where('email', '=', $oLib->submittor_email)->first();
            $this->data['oLib']            = $oLib;
            $this->data['oFiveRandomLibs'] = $oFiveRandomLibs;
            $this->data['oGitHub']         = json_decode(json_encode($aGitHub), false);
            return View::make('show', $this->data);
        } else {
            App::abort(404, 'Library not found');
        }
    }

    /*
     * Search Libraries by a user given query
    */
    public function searchLibraries()
    {

        $oLibs     = Libraries::with('categories', 'likes')->select('*')
            ->where('public', '=', true)
            ->where(function ($sqlQuery) {
                $query = Input::get('query');
                $sqlQuery->where("title", "LIKE", "%" . $query . "%");
                $sqlQuery->orWhere("description", "LIKE", "%" . $query . "%");
            })->orderBy('id', 'desc')->get();


        return Response::json($oLibs);
    }


    /*
     * Only show category libs
     */
    public function categorizeLibraries($slug)
    {
        $this->catSlug = $slug;
        $oCats         = Categories::all();
        // Select likes and group them by their categories - order them by their like count
        $oTopCats  = Like::with('category')
            ->selectRaw('*, COUNT(category_id) AS likes')
            ->groupBy('category_id')
            ->orderByRaw('COUNT(category_id) DESC')
            ->take(5)
            ->get();
        $aLibs     = Libraries::with('likes')
            ->whereHas('categories', function ($sqlQuery) {
                $sqlQuery->where('slug', '=', $this->catSlug);
            })
            ->where('public', '=', true)
            ->orderBy('id', 'desc')->paginate(9);
        $libraries = IndexController::prepareLibrary($aLibs);

        $this->data["oTopCategories"] = $oTopCats;
        $this->data['libraries']      = $libraries;
        $this->data['categories']     = $oCats;
        $this->data['oPagination']    = $aLibs;
        $this->data['slug']           = $slug;
        $this->data["iUsers"]           = count(Sentry::findAllUsers());
        $this->data["oRandomLibs"]      = Libraries::where('public', '=', true)->limit(5)->orderByRaw('RAND()')->get();
        return View::make('index', $this->data);
    }

    /*
     * Suggest a image
     */
    public function suggestImage()
    {
        $oLib = Libraries::find(Input::get('id', 0));
        if ($oLib != null) {
            $oSuggestion = new ImageSuggestion;

            // Check if file upload or url
            if (Input::hasFile('image')) {
                // Image has to be in png format
                if (Input::file('image')->getClientMimeType() != 'image/png') {
                    return Redirect::to('/lib/' . $oLib->slug)->with('error', true)->with('message', 'The image has to be in .png format! Your suggestion was not saved.');
                }

                $sFileName = str_random(32) . '.png';
                Input::file('image')->move(public_path() . '/assets/img/suggestions/', $sFileName);

                $oSuggestion->img = $sFileName;
                $oSuggestion->url = null;
            } else {
                $oSuggestion->img = null;
                $oSuggestion->url = Input::get('url', 'http://placehold.it/400x200');
            }
            $oSuggestion->library_id = $oLib->id;

            $oSuggestion->save();
            return Redirect::to('/lib/' . $oLib->slug)->with('success', true)->with('message', 'Thank you for your suggestion. We will check it as soon as possible.');
        } else {
            return Redirect::to('/')->with('error', true)->with('message', 'Could not save your suggestion, because we could not find that library.');
        }
    }


    /*
     * Submit user library
     */
    function submitLibrary()
    {
        $sInputTitle          = Input::get('inputTitle');
        $sInputUrl            = Input::get('inputUrl');
        $sInputDesc           = Input::get('inputDesc');
        $sInputGradle         = Input::get('inputGradle');
        $sInputCat            = Input::get('inputCategory');
        $sInputMinSdk         = Input::get('inputMinSdk');
        $sInputBaseImage      = Input::get('inputBaseImage');
        $sInputSubmitterEmail = Input::get('inputSubmitterEmail');
        $sImageGuid           = str_random(32);
        $sDisqusId            = str_random(20);



/*        $oLibCheck = Libraries::where('url', '=', $sInputUrl)->first();
        if($oLibCheck != null)
        {
            return Redirect::to('submit')->with('error', true)->with('message', 'Thank you for your submission! '
                . 'The submitted library is already on Android-Libs. Check it out: <a href="' . url('/lib/' . $oLibCheck->slug) . '">' . $oLibCheck->title . '</a>.');
        }*/


        $oLib                  = new Libraries;
        $oLib->title           = $sInputTitle;
        $oLib->url             = $sInputUrl;
        $oLib->gradle          = $sInputGradle;
        $oLib->disqus          = $sDisqusId;
        $oLib->min_sdk         = $sInputMinSdk;
        $oLib->public          = false;
        $oLib->submittor_email = $sInputSubmitterEmail;
        $oLib->category_id     = intval($sInputCat);

        if(strlen($sInputBaseImage) > 0)
        {
            File::put(public_path() . '/assets/img/libs/' . $sImageGuid . '.png', base64_decode(str_replace('data:image/png;base64,', '', $sInputBaseImage)));
            $oLib->img = json_encode([$sImageGuid]);
        }

        # Description
        if(Input::has('fetchDesc'))
        {
            $aGitHub = GitHub::repo()->show($oLib->getGitHubUserName(), $oLib->getGitHubRepoName());
            if($aGitHub['description'] != null && strlen($aGitHub['description']) > 0)
            {
                $oLib->description = $aGitHub['description'];
            }
        }
        else
        {
            $oLib->description = $sInputDesc;
        }

        $oLib->save();
        $oRelatedUser = User::where('email', '=', $oLib->submittor_email)->first();
        $bSendEmails = true;
        # Check if user wants email notifications
        if($oRelatedUser != null)
        {
            $bSendEmails = $oRelatedUser->newsletter;
        }

        if($bSendEmails) {
            Mail::send('emails.submitted', [], function ($message) {
                $message->from('submit@android-libs.com', "Android-Libs");
                $message->to(Input::get('inputSubmitterEmail'), 'AndroidLibs Submitter')->subject("Your AndroidLibs library has been submitted");
            });
        }

        return Redirect::to('submit')->with('success', true)->with('message', "You have successfully submitted a library. Thank you! :)");
    }

}