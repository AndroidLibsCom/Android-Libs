@extends('layout')

@section('content')
    <div class="row">
    	<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-md-offset-2 col-lg-offset-2">
            <h3>About us</h3>
            <hr>
            <p>
                Hello, we are Android-Libs.com!
            </p>
            <p>
                You can find all your favourite android libraries and tools on our portal.
            </p>
            <br>
            <h4>Founders</h4>
            <br>
            <table class="table-about">
                <tbody>
                    <tr>
                        <td>
                            <img src="{{ asset('assets/img/alex.png', true) }}" alt="Alex Mahrt" class="img-circle img-responsive img-about">
                        </td>
                        <td>
                            <strong>Alexander Mahrt</strong>
                            <p>Hi, I'm Alex. I'm the founder of AndroidLibs.</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img src="{{ asset('assets/img/chathura.png', true) }}" alt="Chathura Mahrt" class="img-circle img-responsive img-about">
                        </td>
                        <td>
                            <strong>Chathura Wijesinghe</strong>
                            <p>Hi, I'm Chathura. I'm the co-founder of AndroidLibs.</p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <br>
            <h4>Partners</h4>
            <p>We are looking for partners. <a href="mailto:info@android-libs.com?subject=Partnership" target="_blank">Please drop us a line,</a> if you'd like to become one.</p>
            <br>
            <h4>Side Projects</h4>
            <p>
                We are working on a couple of side-projects. Some of them are android related; check them out:
            </p>
            <ul>
                <li><a href="http://android-jobs.eu" target="_blank">AndroidJobs - A Portal for android related jobs</a></li>
                <li><strong>Coming soon:</strong> Android-Tutorials - How can I...? Answer your question in our upcoming portal!</li>
            </ul>
        </div>
    </div>
@stop