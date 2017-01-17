<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;
//use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
class Notification extends Eloquent
{
    protected $connection = 'mysql';
    /* ****** Code Completed till 10th april */
    use SoftDeletingTrait;
    protected $dates = ['deleted_at'];
    protected $softDelete = true;

    protected $guarded = array('id');

    protected $fillable = [
        'user_id',
        'read',
        'name',
        'email_sent',
        'icon',
        'link',
        'content'
    ];

    /*
     * some examples of icon = fa fa-cloud-upload text-success bg-green
     * fa-cloud-upload = this defines fa icons from http://fortawesome.github.io/Font-Awesome/icons/
     * text-success = color of the icon, it can be text-dange,
     * examples = "fa-bug bg-red", "fa-check bg-green"
     */
    public static function log($user_id, $content, $link = NULL, $icon = NULL, $email_send = NULL)
    {
        $q = new Notification();
        $q->user_id = $user_id;
        $q->content = ucwords($content);
        if ($link != NULL) {
            $q->link = $link;
        }
        if ($icon != NULL) {
            $q->icon = "fa media-object " . $icon;
        }
        $q->save();
        if ($email_send != NULL) {
            //TODO: write code to send email
        }
    }

    //------------------------------------------------------------
    public static function get($send_email = false)
    {
        $items = Notification::where('user_id', '=', Auth::user()->id)
            ->where('read', '=', 0)
            ->orderBy('created_at', 'desc')
            ->get();
        if (count($items) < 1) {
            $items = Notification::where('user_id', '=', Auth::user()->id)
                ->where('read', '=', 0)
                ->orderBy('created_at', 'desc')
                ->limit(3)
                ->get();
        }

        if ($send_email == true) {
            //TODO: write email function for alert
        }
        return $items;
    }

    //------------------------------------------------------------
    public static function mark_as_read($filter = array())
    {
        $items = Notification::get($filter);
        if (count($items) < 1) {
            return false;
        }
        foreach ($items as $item) {
            $noti = Notification::find($item->id);
            $noti->read = 1;
            $noti->save();
        }
        return true;
    }

    //------------------------------------------------------------
    public static function count_unread($current_user = true)
    {
        if ($current_user == true) {
            $count = Notification::where('user_id', '=', Auth::user()->id)->where('read', '=', 0)->count();
        } else {
            $count = Notification::where('read', '=', 0)->count();
        }
        return $count;
    }

    //------------------------------------------------------------
    public static function getList($current_user_only = false)
    {
        $modelname = __CLASS__;
        $results = Custom::search($modelname, 'content', $current_user_only);
        return $results;
    }

    //------------------------------------------------------------
    /* ******\ Code Completed till 10th april */
}