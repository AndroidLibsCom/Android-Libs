<?php
class UserController extends BaseController {
    public function showLogin()
    {
        if(Sentry::check())
        {
            $this->data['page'] = 'profile';
            return View::make("profile", $this->data);
        }
        else
        {
            $this->data['page'] = 'login';
            return View::make("login", $this->data);
        }
    }

    public function showRegister()
    {
        if(Sentry::check())
        {
            $this->data['page'] = 'profile';
            return View::make("profile", $this->data);
        }
        else
        {
            $this->data['page'] = 'register';
            return View::make("register", $this->data);
        }
    }

    public function showProfile()
    {
        $oLikes  = Like::with('library')->where('user_id', '=', Sentry::getUser()->getId())->get();
        $oaLikes = [];

        $x = 0;
        $y = 0;

        # Order for 4 in one row
        foreach($oLikes as $oLike)
        {
            if($x == 3)
            {
                $x = 0;
                $y++;
            }
            $oaLikes[$y][] = $oLike;

            $x++;
        }

        $this->data['page']             = 'profile';
        $this->data['oUser']            = Sentry::getUser();
        $this->data['oaLikes']          = $oaLikes;
        $this->data['iLikes']           = $oLikes->count();
        $this->data['oSubmittedLibs']   = Libraries::where('submittor_email', '=', Sentry::getUser()->email)->get();
        return View::make('profile', $this->data);
    }

    public function showOtherProfile($sUsername)
    {
        $oLikes  = Like::with('library')->where('user_id', '=', Sentry::findUserByLogin($sUsername)->getId())->get();
        $oaLikes = [];

        $x = 0;
        $y = 0;

        # Order for 4 in one row
        foreach($oLikes as $oLike)
        {
            if($x == 3)
            {
                $x = 0;
                $y++;
            }
            $oaLikes[$y][] = $oLike;

            $x++;
        }

        $this->data['page']             = 'user_show';
        $this->data['oUser']            = Sentry::findUserByLogin($sUsername);
        $this->data['oaLikes']          = $oaLikes;
        $this->data['iLikes']           = $oLikes->count();
        $this->data['oSubmittedLibs']   = Libraries::where('submittor_email', '=', Sentry::findUserByLogin($sUsername)->email)->get();
        return View::make('profile_other', $this->data);
    }

    public function updateProfile()
    {
        $oUser = Sentry::getUser();
        # Change the submittor email of all libraries
        if($oUser->email != Input::get('email'))
        {
            # Check if the new email is taken
            $oEmailCheck = User::where('email', '=', Input::get('email'))->first();
            if($oEmailCheck == null)
            {
                foreach(Libraries::where('submittor_email', '=', $oUser->email)->get() as $oLib)
                {
                    $oLib->submittor_email = Input::get('email');
                    $oLib->save();
                }

                $oUser->email       = Input::get('email');
            }
            else
            {
                return Redirect::to('/user/profile')->with('error', true)->with('message', 'We could not change your e-mail. It is already taken.');
            }
        }
        $oUser->newsletter  = Input::has('newsletter');

        if(Input::has('remove_avatar') && $oUser->avatar != null)
        {
            File::delete(public_path() . '/assets/img/avatars/' . $oUser->avatar . '.png');
            $oUser->avatar = null;
        }

        if(Input::hasFile('avatar'))
        {
            if($oUser->avatar != null)
            {
                File::delete(public_path() . '/assets/img/avatars/' . $oUser->avatar . '.png');
            }

            $oFile = Input::file('avatar');
            if($oFile->getClientMimeType() != 'image/png')
            {
                return Redirect::to('/user/profile')->with('error', true)->with('message', 'We only accept .png files as avatar!');
            }

            $sAvatarId = str_random(32);
            $oFile->move(public_path() . '/assets/img/avatars', $sAvatarId . '.png');
            $oUser->avatar = $sAvatarId;
        }


        if(strlen(Input::get('password')) > 0)
        {
            $oUser->password = Input::get('password');
        }

        $oUser->save();
        return Redirect::to('/user/profile')->with('success', true)->with('message', 'Your profile has been updated.');
    }

    public function activate($userId, $code)
    {
        try
        {
            // Find the user using the user id
            $user = Sentry::findUserById($userId);

            // Attempt to activate the user
            if ($user->attemptActivation($code))
            {
                // User activation passed
                return Redirect::to('/login')->with('success', true)->with('message', 'Your account is now activated. You can now login!');
            }
            else
            {
                // User activation failed
                return Redirect::to('/login')->with('error', true)->with('message', 'We could not activate that user. Please write our support at alex@youngandcreative.de about your problem.');
            }
        }
        catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            return Redirect::to('/login')->with('error', true)->with('message', 'We could not find any users for that activation code.');
        }
        catch (Cartalyst\Sentry\Users\UserAlreadyActivatedException $e)
        {
            return Redirect::to('/login')->with('error', true)->with('message', 'This user is already activated. Please login! :-)');
        }
    }

    public function gitHubAuth()
    {
        if(Sentry::check()) {
            return Redirect::to('/')->with('error', true)->with('message', 'You are already logged in!');
        }

        // get data from input
        $code = Input::get( 'code' );

        $GitHubService = OAuth::consumer('GitHub');

        if ( !empty( $code ) ) {

            // This was a callback request from linkedin, get the token
            $token = $GitHubService->requestAccessToken( $code );
            // Send a request with it. Please note that XML is the default format.
            $result = json_decode($GitHubService->request('user'), true);

            if(!empty($token)){

                try{
                    // Find the user using the user id
                    $oUser = User::where('email', '=', $result['email'])->orWhere('username', '=', $result['login'])->first();
                    if($oUser != null)
                    {
                        Sentry::login(Sentry::findUserById($oUser->id), false);

                        return Redirect::to('/')->with('success', true)->with('message', 'Welcome back, ' . $oUser->username . '!');
                    }
                    else
                    {
                        throw new Cartalyst\Sentry\Users\UserNotFoundException;
                    }
                }
                catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
                {
                    // Register the user
                    $user = Sentry::register(array(
                        'email'       => $result['email'],
                        'username'    => $result['login'],
                        'password'    => 'github_change',
                        'github_auth' => true,
                    ), true);

                    $usergroup = Sentry::getGroupProvider()->findById(2);
                    $user->addGroup($usergroup);

                    Sentry::login($user, false);

                    return Redirect::to('/')->with('success', true)->with('message', 'Welcome to Android-Libs, ' . $oUser->username . '!');
                }

            }

        }// if not ask for permission first
        else {
            // get linkedinService authorization
            $url = $GitHubService->getAuthorizationUri();

            // return to linkedin login url
            return Redirect::to( (string)$url );
        }
    }

    public function processRegister()
    {
        try
        {
            // Let's register a user.
            $user = Sentry::register([
                 'email'        => Input::get('email'),
                 'password'     => Input::get('password'),
                 'username'     => Input::get('username'),
                 'newsletter'   => Input::has('newsletter'),
            ], true);

            $user->addGroup(Sentry::findGroupById(2));
            // Let's get the activation code
            /*$activationCode = $user->getActivationCode();

            // Send activation code to the user so he can activate the account
            Mail::send('emails.auth.activation', ['code' => $activationCode, 'userId' => $user->getId() ], function($message)
            {
                $message->from('register@android-libs.com', "Android-Libs.com");
                $message->to(Input::get('email'), Input::get('username'))->subject('Android-Libs.com - Activate your account!');
            });
            */
            return Redirect::to('/login')->with('success', true)->with('message', 'Thank you for registration. Please check your E-Mail Account to activate your account. <strong>Make sure to check out your Spam Folder!</strong>');

        }
        catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
        {
            return Redirect::to('/login')->with('error', true)->with('message', 'The login field is required.');
        }
        catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
        {
            return Redirect::to('/login')->with('error', true)->with('message', 'The password field is required.');
        }
        catch (Cartalyst\Sentry\Users\UserExistsException $e)
        {
            return Redirect::to('/login')->with('error', true)->with('message', 'A user with this username already exists. Please choose another one!');
        }
    }

    public function processLogin()
    {
        $credentials = [
            "username"  => Input::get('username'),
            "password" => Input::get('password')
        ];
        try {
            $oUser = Sentry::authenticate($credentials, Input::get('remember', false));
            return Redirect::intended('/')->with('success', true)->with('message', 'Welcome back, ' . $oUser->username . '!');
        }
        catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
        {
            return Redirect::to('/login')->with('error', true)->with('message', 'The login field is required.');
        }
        catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
        {
            return Redirect::to('/login')->with('error', true)->with('message', 'The password field is required.');
        }
        catch (Cartalyst\Sentry\Users\WrongPasswordException $e)
        {
            return Redirect::to('/login')->with('error', true)->with('message', 'You have entered a wrong username or password.');
        }
        catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            return Redirect::to('/login')->with('error', true)->with('message', 'You have entered a wrong username or password.');
        }
        catch (Cartalyst\Sentry\Users\UserNotActivatedException $e)
        {
            return Redirect::to('/login')->with('error', true)->with('message', 'This user is not activated. Please check your E-Mail Account.');
        }
    }

    public function logout()
    {
        Sentry::logout();
        return Redirect::to('/')->with('success', true)->with('message', 'You sucessfully logged out.');
    }

    public function forgotPassword()
    {
        try
        {
            // Find the user using the user email address
            $user = Sentry::findUserByLogin(Input::get('email'));

            // Get the password reset code
            $resetCode = $user->getResetPasswordCode();

            Mail::send('emails.auth.reminder', ['token' => $resetCode], function($message)
            {
                $message->to('foo@example.com', 'John Smith')->subject('Welcome!');
            });

            // Now you can send this code to your user via email for example.

            return Redirect::to('/login')->with('success', true)->with('message', 'Please check your e-mail account for further instructions.');
        }
        catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            return Redirect::to('/login')->with('error', true)->with('message', 'We could not find that e-mail address.');
        }
    }

    public function likeLibrary()
    {
        $oLib  = Libraries::with('categories')->find(intval(Input::get('id')));
        $oUser = Sentry::getUser();

        $oLikedLib = Like::where('user_id', '=', $oUser->getId())->where('library_id', '=', $oLib->id)->first();
        $bLiked = true;

        if($oLikedLib == null)
        {
            $oLikedLib = new Like;
            $oLikedLib->user_id     = $oUser->getId();
            $oLikedLib->library_id  = $oLib->id;
            $oLikedLib->category_id = $oLib->categories->id;
            $oLikedLib->save();
        }
        else
        {
            $oLikedLib->delete();
            $bLiked = false;
        }

        return Response::json(['liked' => $bLiked]);
    }

}