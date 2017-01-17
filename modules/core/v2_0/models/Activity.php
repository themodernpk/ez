<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;
//use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
class Activity extends Eloquent
{
    /* ****** Code Completed till 10th april */
    protected $connection = 'mysql';
    protected $table = 'activities';
    use SoftDeletingTrait;
    protected $dates = ['deleted_at'];
    protected $softDelete = true;
    protected $guarded = array('id');
    protected $fillable = [
        'user_id',
        'label',
        'name',
        'parent_id',
        'content'
    ];
    //------------------------------------------------------------
    /* #################################
     * This function returns all the activity which is performed
     * All Activity is stored in activity table
     * This Activity is called in admin Dashboard page
     * #################################
     */
    public static function get($filter = array(), $limit = 50)
    {
        /*
         * This block executes if we pass certain value to argument
         * Example: if we want to see a particular activity then if will be executed
         * otherwise only else block will be executed which returns all activity till now
         */
        $q = new Activity();
        if (!empty($filter)) {
            foreach ($filter as $key => $value) {
                $q = $q->where($key, $value);
            }
        }
        $list = $q->orderBy('created_at', 'desc')->take($limit)->get();
        return $list;
    }

    //------------------------------------------------------------
    /* #################################
     * This function returns all the activity
     * this function returns log for admin as well as user specific
     * for admin it return complete log
     * for user it return log belongs to that user
     * first it checks the currently logged in user, then its group's slug
     * if it is admin then it returns complete log
     * Otherwise it returns log to that user
     * #################################
     */
    public static function html()
    {
        $group_slug = Auth::user()->group->slug;
        //entire log for admin only
        if ($group_slug == 'admin') {
            $items = Activity::orderBy('created_at', 'desc')->orderBy('id', 'desc')->take(50)->get();
        } // user specific log only
        else {
            $items = Activity::where('user_id', '=', Auth::user()->id)->orderBy('created_at', 'desc')->orderBy('id', 'desc')->take(50)->get();
        }
        return View::make('core/backend/modules/activities')->with('items', $items)->render();
    }

    //------------------------------------------------------------
    public static function getList($current_user_only = false)
    {
        $modelname = __CLASS__;
        $results = Custom::search($modelname, 'content', $current_user_only);
        return $results;
    }

    //------------------------------------------------------------
    /* ### this function will be use to Register log activities , in activities table
     * Every time we perform opeartion like insert/delete/activate , we log activity
     * $content = message to display, it may contain hyperlinks
     * $user_id = current user who is performing the action
     * $label = short code of action
     * $name = to group activities, db table name
     * $parent_id = db table id
     */
    public static function log($content, $user_id = NULL, $label = NULL, $name = NULL, $parent_id = NULL)
    {
        $activity = new Activity;
        if ($user_id != NULL) {
            $activity->user_id = $user_id;
        }
        if ($label != NULL) {
            $activity->label = $label;
        }
        if ($name != NULL) {
            $activity->name = $name;
        }
        if ($parent_id != NULL) {
            $activity->parent_id = $parent_id;
        }
        $activity->content = $content;
        $activity->save();
    }

    //------------------------------------------------------------
    /* ### returns the the user information belongs to the activity
     * This is reltionship defined between user and activity model
     * Since every activity belongs to user
     * using this we can fetch , to which user activity belongs
     * Since Activity table has column "user_id"
    */
    public function user()
    {
        return $this->belongsTo('User');
    }

    //------------------------------------------------------------
    /* ******\ Code Completed till 10th april */
}