<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;
//use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
class Module extends Eloquent
{
    protected $connection = 'mysql';
    /* ****** Code Completed till 10th april */
    use SoftDeletingTrait;
    protected $dates = ['deleted_at'];
    protected $softDelete = true;

    protected $guarded = array('id');

    protected $fillable = [
        'name',
        'version',
        'active'
    ];

    //--------------------------
    /* ******\ Code Completed till 10th april */
}