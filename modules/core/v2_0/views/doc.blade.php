@extends('core::layout.core')

@section('content')

    <style>
        body {
            font-size: 16px;
            line-height: 25px;
        }

        p {
            color: #444;
        }

        .email-content {
            padding: 20px 80px;
        }
    </style>

    <link href="http://www.steamdev.com/snippet/css/jquery.snippet.css" rel="stylesheet"/>




    <div id="page-container" class="fade in">
        <!-- begin #header -->
        <div id="header" class="header navbar navbar-default ">
            <!-- begin container-fluid -->
            <div class="container-fluid">

                <!-- begin mobile sidebar expand / collapse button -->
                <div class="navbar-header">
                    <a href="index-2.html" class="navbar-brand"><span class="navbar-logo"></span> LV App</a>
                    <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <!-- end mobile sidebar expand / collapse button -->


            </div>
            <!-- end container-fluid -->
        </div>
        <!-- end #header -->


        <!-- begin #content -->
        <div id="content" class="container">


            <div class="row">

                <br/>
                <br/>


                <!-- begin col-2 -->
                <div class="col-md-2">
                    {{--   <form>
                           <div class="input-group m-b-15">
                               <input type="text" class="form-control input-sm input-white" placeholder="Search">
                               <span class="input-group-btn">
                                   <button class="btn btn-sm btn-inverse" type="button"><i class="fa fa-search"></i></button>
                               </span>
                           </div>
                       </form>--}}
                    <div class="hidden-sm hidden-xs">
                        <h5 class="m-t-20"><a href="?page=setup">Setup</a></h5>
                        <!--<ul class="nav nav-pills nav-stacked nav-inbox">
                            <li><a href="?page=setup"> Application Installation</a></li>
                            <li><a href="?page=setup">Application Directory</a></li>

                        </ul>-->
                        <h5 class="m-t-20"><a href="?page=dashboard">Application Backend</a></h5>
                        <!--<h5 class="m-t-20"><a href="?page=admin">Admin</a></h5>-->

                        <h5 class="m-t-20"><a href="?page=imp-func">Code Snippets</a></h5>
                        <h5 class="m-t-20"><a href="?page=module">Module</a></h5>
                        <h5 class="m-t-20"><a href="?page=api">API</a></h5>


                    </div>
                </div>
                <!-- end col-2 -->
                <!-- begin col-10 -->
                <div class="col-md-10">

                    <div class="email-content">

                        @if(Input::get('page') == 'setup')

                            <div>
                                <h2 class="lead"><i class="fa fa-hand-o-right"></i> Setup</h2>
                                <ul>
                                    <li><a href="#database">Database</a></li>
                                    <li><a href="#application-installation"> Application Installation</a></li>
                                    <li><a href="#application-directory"> Application Directory</a></li>

                                </ul>
                                <hr>

                                <p><a name="database"></a></p>

                                <h4 class="text-success"><i class="fa fa-long-arrow-right"></i> Database</h4>

                                <p>Before you start with the application all you need is to create a blank database.</p>

                                <p><a name="application-installation"></a></p>

                                <h4 class="text-success"><i class="fa fa-long-arrow-right"></i> Application Installation</h4>

                                <ul>
                                    <li>Install Composer :</li>

                                    <p>As our system is built on top of laravel, So laravel utilizes Composer to manage
                                        its dependencies, and make sure
                                        that you have installed composer on your system. You can download the composer
                                        from <a href="https://getcomposer.org/download/" target="_blank">here</a> . </p>

                                    <p>After installation of composer, all you need is to get the vendor folder inside
                                        the laravel folder, with the help of composer.</p>

                                    <li>Server Requirements :</li>

                                    <p>The Laravel framework has a few system requirements:
                                    <ul>
                                        <li> PHP >= 5.4</li>
                                        <li>Mcrypt PHP Extension</li>
                                        <li>OpenSSL PHP Extension</li>
                                    </ul>
                                    </p>

                                    <li>App Set Up:</li>

                                    <p>When you will run the app on your localhost there will be three steps which are
                                        as follows:</p>

                                    <ul>
                                        <li>Database Configuration</li>
                                        <p>Where you need to put the database name which you have created.</p>

                                        <li>Run Migrations</li>
                                        <p>Migration are a type of version control for your database. If you ever lose
                                            the database or any tables, all you need is to run the migration from here
                                            and all your tables will be back. </p>
                                        <li>Create Admin Account</li>
                                        <p>Lastly you need to create your account.</p>

                                    </ul>

                                    <li>App Log In:</li>
                                    <p>After you are done with the above steps, now you can login to the app.</p>


                                </ul>

                                <p><a name="application-directory"></a></p>

                                <h4 class="text-success"><i class="fa fa-long-arrow-right"></i> Application Directory</h4>

                                <p>The main "files" of our application resides in the modules directory inside
                                    "Core".</p>

                                <p>The Assets directory contains the css and js that need to be called in the
                                    pages. </p>

                            </div>

                        @elseif(Input::get('page') == 'dashboard')
                            <div>
                                <h3><i class="fa fa-hand-o-right"></i> Application Backend</h3>
                                <ul>
                                    <li><a href="#board">Dashboard</a></li>
                                    <li><a href="#admin">Admin</a></li>
                                </ul>

                                <hr>

                                <p><a name="board"></a></p>

                                <h4 class="text-success"><i class="fa fa-long-arrow-right"></i> Dashboard</h4>

                                <p>You can view the activity logs created by you and the user which you have
                                    created.</p>

                                <p>Check the Notifications.</p>

                                <p>You can able to update your profile.</p>

                                <p><a name="admin"></a></p>

                                <h4 class="text-success"><i class="fa fa-long-arrow-right"></i> Admin</h4>
                                <ul>
                                    <li>Permissions</li>
                                    <ul>
                                        <li>You can view the list of permissions.</li>
                                        <li>Activate / Deactivate permissions if you are allowed to do so.</li>
                                        <li> Delete permission if you are allowed to do so.</li>
                                        <li>Permanent Delete if you are allowed to do so.</li>
                                        <li>Add permission if you are allowed to do so.</li>

                                    </ul>
                                    <li>Groups</li>
                                    <ul>
                                        <li>You can view the list of Groups</li>
                                        <li>Add group if you are allowed to do so.</li>
                                        <li>Activate / Deactivate group if you are allowed to do so.</li>
                                        <li>Delete group if you are allowed to do so.</li>
                                        <li>Permanent Delete if you are allowed to do so.</li>
                                        <li>You can able to check the list of permissions associated with the group on
                                            click of check permissions blue link.
                                        </li>
                                        <li>Activate / Deactivate the permission list.</li>
                                    </ul>
                                    <li>Users</li>
                                    <ul>
                                        <li>You can view the list of users.</li>
                                        <li>Add user if you are allowed to do so.</li>
                                        <li>Activate / Deactivate user if you are allowed to do so.</li>
                                        <li>Delete user if you are allowed to do so.</li>
                                        <li>Permanent Delete if you are allowed to do so.</li>
                                        <li>Edit User if you are allowed to do so.</li>
                                    </ul>
                                    <li>Activities</li>
                                    <ul>
                                        <li>You can view the list of all activity log.</li>
                                        <li>You can able to search the activity on date basis or by column filter.</li>
                                    </ul>
                                    <li>Module</li>
                                    <ul>
                                        <li>You can view the list of modules, which module is active or you can able to
                                            install, uninstall, upgrade the module according to your wish.
                                        </li>

                                    </ul>


                                </ul>


                            </div>

                        @elseif(Input::get('page') == 'imp-func')
                            <div>
                                <h2 class="lead"><i class="fa fa-hand-o-right"></i> Code Snippets</h2>
                                <ul>
                                    <li><a href="#route">Route</a></li>
                                    <li><a href="#helper">Helper</a></li>
                                    <li><a href="#controller">Controller</a></li>
                                    <li><a href="#log">Log</a></li>
                                    <li><a href="#view">Views</a></li>
                                </ul>
                                <hr>
                                <p><a name="route"></a></p>

                                <h4 class="text-success"><i class="fa fa-long-arrow-right"></i> Route</h4>
                                <dl>
                                    <dt>Core routes</dt>
                                    <dd> - Here is where you can register all of the routes for an application.</dd>

                                </dl>


                                <p><a name="helper"></a></p>

                                <h4 class="text-success"><i class="fa fa-long-arrow-right"></i> Helper</h4>
                                <ul>
                                    <li>Constant.php:</li>
                                    <p>We have defined the constants for displaying the Success, Error, Warning and Info
                                        messages. </p>
<pre class="php">
    define('core_app_name', 'LV App');<br/>
    // Here Constant is 'core_app_name' and the value is 'LV App'
</pre>


                                    <li>Functions.php</li>
                                    <p>All the important and common functions which is being called every where in the
                                        project is here in this file. </p>

<pre class="php">
/* #################################
 * This function returns table name in encrypted format to perform bulkAction
 * We assume that if $table is null ,then second segment of url will be table
 * get the table from url, to do that get the second segment from url
 * Use Request::segment($uri_segment) , gives the table name
 * get table name in encrypted format, Decrypt it and return it
 * #################################
 */

    function get_table_name($uri_segment = 2, $table=NULL)
    {
        if($table == NULL)
        {
            $table = Request::segment($uri_segment);
        }
        $encoded_name = Crypt::encrypt($table);
        return $encoded_name;
    }

</pre>


<pre class="php">

function get_model_from_table($table)
{
/* #################################
* @$table is argument , it holds table name ,of which model name is required
* Valid only for tables like, users, groups, permissions etc
* remove the last letter
* make the first letter
* checks if model exist then return it ,then code below this if will then not executed
* examples: from "users" table, we get "User" Model
* #################################
*/

$table_name = substr($table, 0, -1);
$class_name = ucfirst($table_name);

if(class_exists($class_name))
{
return $class_name;
}

/* #################################
* if the above condtion fails then it will execute
* this code is to get model from table "activities". its model will be "Activity"
* first get the last three letter of table and check it ends with "ies",
* if yes then ,remove the last three character of table and add "y" in end.
* capitalize the first letter and return it
* #################################
*/

$last_three = substr($table, -3);

if($last_three == "ies")
{
    $class_name = ucfirst(substr($table, 0, -3)."y");

    if(class_exists($class_name))
    {
        return $class_name;
    }
}
}

</pre>


<pre class="php">
/* #################################
 * This function returns exceptions which is already defined
 * Before performing any operation like delete/activate etc
 * This function Checks Whether there is any Exception or not
 * This function returns a array which is the Exception defined in setting.php file
 * @setting.php resides in helpers directory
 * To Access Setting use Config::get('arg1') function
 * @arg1 is name of setting ,which is alredy defined for exceptional case
 * #################################
 */

function core_settings($key)
{
    // get the setting in array format
    $settings = Config::get('core.settings');
    return $settings[$key];
}
</pre>


                                    <li>Settings.php</li>
                                    <p>This is basically for handling the exceptions.</p>
<pre class="php">
$settings[Table Name]['exceptions'] = array(1);
// pass the id on which you don’t anyone to perform any action.
</pre>


                                </ul>


                                <p><a name="controller"></a></p>

                                <h4 class="text-success"><i class="fa fa-long-arrow-right"></i> Controller</h4>
                                <ul>
                                    <li>Admin Controller</li>
                                    <p>All the pages under admin tab is being displayed from the admin controller.</p>

<pre class="php">
/* #################################
 * This method is defined to perform Bulk Action on following tables
 * "Group/Permission/User " tables
 * We perform 'Activate/DeActivate/Soft Delete/permanent delete/restore' operation in bulk
 * Based on our action we perform operation using 'switch' concept
 * We have multiple submit button in the form , name of each button is 'action'
 * So, We use $input['action'], gives the 'value' of submit button which is 'clicked'
 * In the 'value' attribute of submit button , what 'action' to be performed is defined
 * We will get the table name from hidden field of button
 * Our table name is in 'encrypted' form 'Decrypt' it, and get the model for the table
 * Use 'get_model_from_table' function to get table name ,defined in 'helpers/function.php'
 * Before performing ny action we 'log' the activity..which is stored in activity table
 * The 'log' method is defined in Activity Model
 * #################################
 */

    public function bulkAction()
    {
        $input = Input::all();

        // get table name from hidden field
        // this will be in encrypted form
        $input['table'] = Crypt::decrypt($input['table']);
        $model_name = get_model_from_table($input['table']);

        ...
    }
</pre>


                                    <li>Ajax Controller</li>
                                    <p>All the ajax related codes resides in this Controler.</p>

                                    <p>Ajax Syntax Eg.</p> 
<pre class="php">
    $.ajax({
    type: "POST",
    url: "<?php echo URL::route('markRead'); ?>",
    context: this,
    success: function(msg)
    {

    }
    })

</pre>

                                </ul>


                                <p><a name="log"></a></p>

                                <h4 class="text-success"><i class="fa fa-long-arrow-right"></i> Activity Log</h4>

                                <p></p>
<pre class="php">
Activity::log("Module Name - Action", Action done on ID, Auth::user()->id (logged in user id), Action Name, Table name, Last Inserted ID);
</pre>

                                <p><a name="view"></a></p>

                                <h4 class="text-success"><i class="fa  fa-long-arrow-right"></i> View</h4>
                                <ul>
                                    <li>Javascript.bladde.php :</li>

                                    <p>All the Common Javascripts that is being called in the project resides here in
                                        this file.</p>
<pre class="php">
/* If Block Name is "row_edit" then only this javascript will work */
$( document ).ready(function() {
    $('.editable').editable({
    type: 'text',
    url: "<?php echo URL::route('ajax_edit'); ?>",
    success: function(response)
    {
    if(response == "failed")
    {
    $.gritter.add({
    title: '<label class="btn btn-xs btn-icon btn-circle btn-danger"><i class="fa fa-times"></i></label>  Undefined Error',
    sticky: false,
    });
    $(this).attr('checked','checked');
    }

    if(response == "success")
    {
    $.gritter.add({
    title: '<label class="btn btn-xs btn-icon btn-circle btn-success"><i class="fa fa-check"></i></label>  Edited Successfully',
    sticky: false,
    });
    }
    $(".pace").addClass('pace-inactive');
    }
    });
});


</pre>
                                    <p>Where ever we want to call this javascript in the view file all we need to do is
                                        just to add these simple lines of code.</p>
<pre class="php">
 View::make('core::layout.javascript')->with('block_name', 'row_edit');
</pre>


                                </ul>


                            </div>

                        @elseif(Input::get('page') == 'module')
                            <div>
                                <h2 class="lead"><i class="fa fa-hand-o-right"></i> Module</h2>
                                <ul>
                                    <li><a href="#introduction">Introduction</a></li>
                                    <li><a href="#find-modules">Finding Modules</a></li>
                                    <li><a href="#module-installation">Installation</a></li>

                                </ul>
                                <hr>

                                <p><a name="introduction"></a></p>

                                <h4 class="text-success"><i class="fa fa-long-arrow-right"></i> Introduction</h4>

                                <p>Our App is designed to be a modular application system. </p>

                                <p>A module is a collection of classes, templates and other resources, that is loaded
                                    into the App.</p>

                                <p><a name="find-modules"></a></p>

                                <h4 class="text-success"><i class="fa fa-long-arrow-right"></i> Finding Modules</h4>
                                <p> Your Module should consists two files, one is "details.xml" where you will write down your module name, module description, date etc.
                                    and second is every module versions should include "version.xml" where version details will reside.
                                </p>


<pre class="php">
    //Lv is the main folder, Modules is the folder where all your modules resides, Core is the default module.
    LV
    |
    |
    |___modules
            |
            |
            |__Core__
            |        
            |
            |
            |__Test
                   |
                   |__V1_0
                   |
                   |
                   |__details.xml


</pre>

                                <p><a name="module-installation"></a></p>

                                <h4 class="text-success"><i class="fa fa-long-arrow-right"></i> Installation</h4>

                                <p>Module should exist inside the module folder.</p>

                                <p>You can Install, Uninstall, Upgrade module from <a href="{{URL::route('modules')}}">here</a> .</p>

                                <img src="<?php echo asset_path(); ?>/img/module.png" style="width: 785px;">

                                <p> When the user will click on "Install" button, "moduleInstall()" function will be called inside core folder "AdminController" file. </p>

                            </div>

                        @elseif(Input::get('page') == 'api')
                            <div>
                                <h2 class="lead"><i class="fa fa-hand-o-right"></i> API</h2>
                                <!--<ul>
                                    <li><a href="#introduction">Introduction</a></li>
                                    <li><a href="#find-modules">Finding Modules</a></li>
                                    <li><a href="#module-installation">Installation</a></li>

                                </ul>-->
                                <hr>


                                    <p><h4 class="text-success">Following url must be set for authentication:</h4></p>
                                    <table class="table table-striped table-bordered ">
                                        <tr>
                                            <td width="250"><b>login_email</b></td>
                                            <td>{Required} Email for validation</td>
                                        </tr>
                                        <tr>
                                            <td><b>login_password</b></td>
                                            <td>{Required} Set valid password address</td>
                                        </tr>
                                    </table>

                                    <p><h4 class="text-success">To Create/Fetch User:</h4></p>

                                    <table class="table table-striped table-bordered ">
                                        <tr width="250">
                                            <td><b>API URL</b></td>
                                            <td>{{URL::route('apiUserCreate')}}</td>
                                        </tr>

                                        <tr>
                                            <td><b>email</b></td>
                                            <td>{Required} Set valid email address</td>
                                        </tr>
                                        <tr>
                                            <td><b>group_id</b></td>
                                            <td>{Required} | If not set than application will use default group_id</td>
                                        </tr>
                                        <tr>
                                            <td><b>username</b></td>
                                            <td>If not set than application will generator username from email</td>
                                        </tr>
                                        <tr>
                                            <td><b>password</b></td>
                                            <td>If not set than application will generator random password</td>
                                        </tr>
                                        <tr>
                                            <td><b>name</b></td>
                                            <td>If not set than application will use email</td>
                                        </tr>
                                        <tr>
                                            <td><b>mobile</b></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="center"><b>Following response will be generated in json format</b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>status</b></td>
                                            <td>failed | success</td>
                                        </tr>
                                        <tr>
                                            <td><b>errors</b></td>
                                            <td>errors in array format</td>
                                        </tr>
                                        <tr>
                                            <td><b>data</b></td>
                                            <td>it variable will contain actuall response data</td>
                                        </tr>
                                    </table>

                                    <p><h4 class="text-success">How to execute:</h4></p>

<pre class="php">
<?php

    $html = '
// api url
$url = "' . URL::route('apiUserCreate') . '";

// build query string
$query = "login_email=demo@email.com&login_password=demopassword";
$query .= "&name=Client Name";
$query .= "&email=passemail@gmail.com";

// execute via curl
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec ($ch);

if ($errno = curl_errno($ch)) {
    echo $errno;
}
curl_close ($ch);

//json decoded response
$response = json_decode($response);

';
    echo $html; ?>
</pre>



                            </div>

                        @else
                            <div>
                                <h2 class="lead">Setup</h2>
                                <ul>
                                    <li><a href="#database">Database</a></li>
                                    <li><a href="#application-installation"> Application Installation</a></li>
                                    <li><a href="#application-directory"> Application Directory</a></li>

                                </ul>
                                <hr>

                                <p><a name="database"></a></p>

                                <h3><i class="fa fa-long-arrow-right"></i> Database</h3>

                                <p>Before you start with the application all you need is to create a blank database.</p>

                                <p><a name="application-installation"></a></p>

                                <h3><i class="fa fa-long-arrow-right"></i> Application Installation</h3>

                                <ul>
                                    <li>Install Composer :</li>

                                    <p>As our system is built on top of laravel, So laravel utilizes Composer to manage
                                        its dependencies, and make sure
                                        that you have installed composer on your system. You can download the composer
                                        from <a href="https://getcomposer.org/download/" target="_blank">here</a> . </p>

                                    <p>After installation of composer, all you need is to get the vendor folder inside
                                        the laravel folder, with the help of composer.</p>

                                    <li>Server Requirements :</li>

                                    <p>The Laravel framework has a few system requirements:
                                    <ul>
                                        <li> PHP >= 5.4</li>
                                        <li>Mcrypt PHP Extension</li>
                                        <li>OpenSSL PHP Extension</li>
                                    </ul>
                                    </p>

                                    <li>App Set Up:</li>

                                    <p>When you will run the app on your localhost there will be three steps which are
                                        as follows:</p>

                                    <ul>
                                        <li>Database Configuration</li>
                                        <p>Where you need to put the database name which you have created.</p>

                                        <li>Run Migrations</li>
                                        <p>Migration are a type of version control for your database. If you ever lose
                                            the database or any tables, all you need is to run the migration from here
                                            and all your tables will be back. </p>
                                        <li>Create Admin Account</li>
                                        <p>Lastly you need to create your account.</p>

                                    </ul>

                                    <li>App Log In:</li>
                                    <p>After you are done with the above steps, now you can login to the app.</p>


                                </ul>

                                <p><a name="application-directory"></a></p>

                                <h3><i class="fa fa-long-arrow-right"></i> Application Directory</h3>

                                <p>The main "files" of our application resides in the modules directory inside
                                    "Core".</p>

                                <p>The Assets directory contains the css and js that need to be called in the
                                    pages. </p>

                            </div>


                        @endif


                    </div>

                </div>
                <!-- end col-10 -->
            </div>


        </div>
        <!-- end #content -->


        <!-- begin scroll to top btn -->
        <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade"
           data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
        <!-- end scroll to top btn -->
    </div>

@stop


@section('page_specific_foot')
    <script src="http://www.steamdev.com/snippet/js/jquery.snippet.js"></script>
    <script>
        $(document).ready(function () {

            $("pre.php").snippet("php", {style: "golden"});


        });
    </script>

@stop
