<?php
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Libraries extends Eloquent implements SluggableInterface {
    use SluggableTrait;

    protected $sluggable = [
        'build_from' => 'title',
        'save_to'    => 'slug',
    ];

	protected $table = 'libraries';
	public $timestamps = true;


    public function categories()
    {
        return $this->belongsTo('Categories', 'category_id', 'id');
    }

    public function likes()
    {
        return $this->hasMany('Like', 'library_id', 'id');
    }

    public function isGitHubUrl()
    {
        return stripos($this->url, 'github.com') == false ? false : true;
    }

    public function hasGradle()
    {
        return $this->gradle != null;
    }

    public function getGitHubUserName()
    {
        $sStrippedUrl = str_replace('http://github.com/', '', $this->url);
        $sStrippedUrl = str_replace('https://github.com/', '', $sStrippedUrl);
        return substr($sStrippedUrl, 0, stripos($sStrippedUrl, '/', 1));
    }

    public function getGitHubRepoName()
    {
        $sStrippedUrl = str_replace('http://github.com/', '', $this->url);
        $sStrippedUrl = str_replace('https://github.com/', '', $sStrippedUrl);
        return substr($sStrippedUrl, stripos($sStrippedUrl, '/') + 1, strlen($sStrippedUrl));
    }

    public function getApiLevel()
    {
        $aApiLevels = [
            "None (1 | 1.0)",
            "None (2 | 1.1)",
            "Cupcake (3 | 1.5)",
            "Donut (4 | 1.6)",
            "Eclair (5 | 2.0)",
            "Eclair (6 | 2.0.1)",
            "Eclair (7 | 2.1.x)",
            "Froyo (8 | 2.2.x)",
            "Gingerbread (9 | 2.3.0 - 2.3.2)",
            "Gingerbread (10 | 2.3.3 - 2.3.4)",
            "Honeycomb (11 | 3.0.x)",
            "Honeycomb (12 | 3.1.x)",
            "Honeycomb (13 | 3.2)",
            "ICS (14 | 4.0.0 - 4.0.2)",
            "ICS (15 | 4.0.3 - 4.0.4)",
            "Jelly Bean (16 | 4.1.0 - 4.1.1)",
            "Jelly Bean (17 | 4.2.0, 4.2.2)",
            "Jelly Bean (18 | 4.3)",
            "KitKat (19 | 4.4)",
            "KitKat Watch (20 | 4.4W)",
            "Lollipop (21 | 5.0)"
        ];

        if($this->min_sdk == null)
        {
            return 'Unknown :(';
        }

        return $aApiLevels[$this->min_sdk - 1];
    }

    public function getCreatedDate()
    {
        return date('d/m/Y', strtotime($this->created_at));
    }

    public function getUpdatedDate()
    {
        return date('d/m/Y', strtotime($this->updated_at));
    }

    public function getImages()
    {
        if($this->img == null) {
            return null;
        } else {
            return json_decode($this->img);
        }
    }

    public function getShortenedDescription()
    {
        if(strlen($this->description) > 100)
        {
            // Truncate - cut after last word
            $string = trim($this->description);

            if(strlen($string) > 100) {
                $string = wordwrap($string, 100);
                $string = explode("\n", $string, 2);
                $string = $string[0] . ' ...';
            }
            return $string;
        }
        else
        {
            return $this->description;
        }
    }


}