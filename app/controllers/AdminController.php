<?php


class AdminController extends BaseController {
    public function showAdmin()
    {
        if(Sentry::check())
        {
            $this->data['page']  = 'admin';
            $this->data['oCats'] = Categories::all();
            return View::make("admin", $this->data);
        }
        else
        {
            return Redirect::to("login")->with('error', true)->with('message','You must be logged in as an administrator.');
        }
    }

    public function getSingleLib()
    {
        $oLib = Libraries::find(Input::get('id'));

        if(!is_null($oLib))
        {
            return Response::json($oLib);
        }
        else
        {
            return Response::json(['error' => 'No library with that id found.'], 404);
        }
    }

    public function getLibs($type)
    {
        $bPublic = $type == 'public';
        $oLibs = Libraries::where('public', '=', $bPublic)->get();
        $aData = [
            'data' => []
        ];

        foreach($oLibs as $oLib)
        {
            # Image
            if($oLib->getImages() == null)
            {
                $sImg = asset('/assets/img/lib_placeholder.png');
            }
            else
            {
                $sImg = asset('/assets/img/libs/' . $oLib->getImages()[0] . '.png');
            }

            # Url Type
            if($oLib->isGitHubUrl())
            {
                $sUrlType = '<i class="fa fa-fw fa-github-square"></i> GitHub';
            }
            else
            {
                $sUrlType = '<i class="fa fa-fw fa-globe"></i> Website';
            }

            if($bPublic)
            {
                $aData['data'][] = [
                    $oLib->id,
                    '<a href="' . $sImg . '" class="prev-img" data-lightbox="' . str_random() . '" data-title="' . $oLib->title . '" target="_blank"><img src="' . $sImg . '" class="td-img"></a>',
                    $oLib->title,
                    $oLib->submittor_email,
                    $sUrlType,
                    '<div class="btn-group">'
                    . '<a href="' . url('/lib/' .$oLib->slug) . '" class="btn btn-default btn-xs" target="_blank"><i class="fa fa-fw fa-globe"></i></a>'
                    . '<a href="' . $oLib->url . '" class="btn btn-default btn-xs" target="_blank"><i class="fa fa-fw fa-external-link"></i></a>'
                    . '<a href="#" class="btn btn-warning btn-xs btn-edit-lib" data-id="' . $oLib->id . '"><i class="fa fa-fw fa-edit"></i></a>'
                    . '</div>'
                ];
            }
            else
            {
                $aData['data'][] = [
                    $oLib->id,
                    '<a href="' . $sImg . '" class="prev-img" data-lightbox="' . str_random() . '" data-title="' . $oLib->title . '" target="_blank"><img src="' . $sImg . '" class="td-img"></a>',
                    $oLib->title,
                    $oLib->submittor_email,
                    $oLib->getShortenedDescription(),
                    $sUrlType,
                    '<div class="btn-group btn-group-sm">
                         <a href="' . $oLib->url . '" class="btn btn-primary" target="_blank"><i class="fa fa-fw fa-globe"></i></a>
                         <a href="#" class="btn btn-success btn-accept" data-id="' . $oLib->id . '"><i class="fa fa-fw fa-check"></i></a>
                         <a href="#" class="btn btn-danger btn-decline" data-id="' . $oLib->id . '"><i class="fa fa-fw fa-ban"></i></a>
                     </div>'
                ];
            }
        }

        return Response::json($aData);
    }

    /**
     * Update library
     * @return \Illuminate\Http\RedirectResponse
     */
    function updateLibrary()
    {
        $sInputTitle          = Input::get('title');
        $sInputUrl            = Input::get('url');
        $sInputDesc           = Input::get('description');
        $sInputKeywords       = Input::get('keywords');
        $sInputGradle         = Input::get('gradle');
        $sInputCat            = Input::get('category');
        $sInputMinSdk         = Input::get('min_sdk');
        $sInputBaseImage      = Input::get('inputBaseImage');
        $sImageGuid           = str_random(32);


        $oLib                  = Libraries::find(intval(Input::get('id')));

        if(is_null($oLib))
        {
            return Redirect::to('/admin')->with('error', true)->with('message', 'We could not find this library. Probably a server side issue.');
        }

        $oLib->title           = $sInputTitle;
        $oLib->url             = $sInputUrl;
        $oLib->gradle          = $sInputGradle;
        $oLib->min_sdk         = $sInputMinSdk;
        $oLib->keywords        = strlen($sInputKeywords) > 0 ? $sInputKeywords : null;
        $oLib->public          = Input::has('public');
        $oLib->featured        = Input::has('featured');
        $oLib->category_id     = intval($sInputCat);
        $oLib->description = $sInputDesc;

        if(strlen($sInputBaseImage) > 0 && Input::has('allowEditImage'))
        {
            File::put(public_path() . '/assets/img/libs/' . $sImageGuid . '.png', base64_decode(str_replace('data:image/png;base64,', '', $sInputBaseImage)));
            $oLib->img = json_encode([$sImageGuid]);
        }

        $oLib->save();

        return Redirect::to('/admin')->with('success', true)->with('message', 'Successfully edited library "' . $oLib->title . '"');
    }

    /*
     * Add new library
     */
    function addLibrary()
    {
        $sInputTitle          = Input::get('title');
        $sInputUrl            = Input::get('url');
        $sInputDesc           = Input::get('description');
        $sInputCat            = Input::get('category');
        $sInputGradle         = Input::get('gradle');
        $sInputMinSdk         = Input::get('min_sdk');
        $oInputImage          = Input::file('img');
        $sInputKeywords       = Input::get('keywords');
        $sInputSubmitterEmail = Sentry::getUser()->email;
        $sImageGuid           = str_random(32);
        $sDisqusId            = str_random(20);
        $aAcceptedMimes       = ["image/png"];

        if($oInputImage != null)
        {
            $sImageMime           = $oInputImage->getClientMimeType();

            if (in_array($sImageMime, $aAcceptedMimes)) {

                $oLib                  = new Libraries;
                $oLib->title           = $sInputTitle;
                $oLib->url             = $sInputUrl;
                $oLib->description     = $sInputDesc;
                $oLib->disqus          = $sDisqusId;
                $oLib->gradle          = $sInputGradle;
                $oLib->min_sdk         = $sInputMinSdk;
                $oLib->keywords        = strlen($sInputKeywords) > 0 ? $sInputKeywords : null;
                $oLib->public          = false;
                $oLib->img             = json_encode([$sImageGuid]);
                $oLib->submittor_email = $sInputSubmitterEmail;
                $oLib->category_id     = intval($sInputCat);
                $oLib->public          = Input::has('public');
                $oLib->featured        = Input::has('featured');
                $oLib->save();


                $oInputImage->move(public_path() . '/assets/img/libs/', $sImageGuid . '.png');



                return Redirect::to('admin#add')->with('success', true)->with('message', "Library was successfully added!");
            }
            else
            {
                return Redirect::to('admin#add')->with('error', true)->with('message', "Wrong file format (PNG only).");
            }
        }
        else
        {
            $oLib                  = new Libraries;
            $oLib->title           = $sInputTitle;
            $oLib->url             = $sInputUrl;
            $oLib->description     = $sInputDesc;
            $oLib->disqus          = $sDisqusId;
            $oLib->min_sdk         = $sInputMinSdk;
            $oLib->public          = false;
            $oLib->img             = json_encode([]);
            $oLib->submittor_email = $sInputSubmitterEmail;
            $oLib->category_id     = intval($sInputCat);
            $oLib->public          = Input::has('public');
            $oLib->featured        = Input::has('featured');
            $oLib->save();

            return Redirect::to('admin#add')->with('success', true)->with('message', "Library was successfully added!");
        }

    }

    /*
     * Accept library
     */
    function acceptLibrary($id)
    {
        Session::set('LibraryId', $id);
        $oLib = Libraries::find($id);
        $oLib->public = true;
        $oLib->save();

        $oRelatedUser = User::where('email', '=', $oLib->submittor_email)->first();
        $bSendEmails = true;
        # Check if user wants email notifications
        if($oRelatedUser != null)
        {
            $bSendEmails = $oRelatedUser->newsletter;
        }

        if($bSendEmails)
        {
            Mail::send('emails.accepted', [], function($message)
            {
                $oLib = Libraries::find(Session::get('LibraryId'));
                $message->from('submit@android-libs.com', "Android-Libs");
                $message->to($oLib->submittor_email, 'AndroidLibs Submitter')->subject("Your AndroidLibs library '" . $oLib->title . "' has been accepted");
            });
        }


        return Redirect::to('admin#submitted-libs')->with('success', true)->with('message', "Library was successfully accepted!");
    }

    /*
     * Decline library
     */
    function declineLibrary($id, $reason)
    {
        Session::set('LibraryId', $id);

        $oLib = Libraries::find($id);
        //Delete Image
        foreach($oLib->getImages() as $sImage)
        {
            File::delete(public_path() . '/assets/img/libs/' . $sImage . '.png');
        }

        $oRelatedUser = User::where('email', '=', $oLib->submittor_email)->first();
        $bSendEmails = true;
        # Check if user wants email notifications
        if($oRelatedUser != null)
        {
            $bSendEmails = $oRelatedUser->newsletter;
        }

        if($bSendEmails)
        {
            Mail::send('emails.declined', ["reason" => $reason], function ($message) {
                $oLib = Libraries::find(Session::get('LibraryId'));
                $message->from('submit@android-libs.com', "Android-Libs");
                $message->to($oLib->submittor_email, 'AndroidLibs Submitter')->subject("Your AndroidLibs library '" . $oLib->title . "' was declined");
            });
        }

        $oLib->delete();
        return Redirect::to('admin#submitted-libs')->with('success', true)->with('message', "Library was successfully declined!");
    }

    /*
     * Remove library
     */
    function removeLibrary($id)
    {
        $oLib = Libraries::find($id);
        //Delete Image
        File::delete(public_path() . '/assets/img/libs/' . $oLib->img . $oLib->img_ext);
        $oLib->delete();
        return Redirect::to('admin#public-libs')->with('success', true)->with('message', "Library was successfully removed!");
    }
} 