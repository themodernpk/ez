<?php $user = $data['user']; ?>

<hr/>

<div class="row">

    <!--left-->

    <div class="col-sm-9">

        <!-- Wrapper div -->
        <div>
            <?php
            /*echo "<pre>";
            print_r($user);
            echo "</pre>";*/
            ?>
            <!-- panel accordinian -->
            <div class="panel-group" id="accordion">
                <!-- panel 1 -->
                <div class="panel panel-inverse overflow-hidden">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse"
                               data-parent="#accordion" href="#collapseOne" aria-expanded="false">
                                <i class="fa fa-plus-circle pull-right"></i>
                                User Profile
                            </a>
                        </h3>
                    </div>


                    <div id="collapseOne" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                        <div class="panel-body">

                            <div style="border-bottom:1px solid #ccc; margin-bottom:15px;">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <h4><i class="fa fa-user"></i> PERSONAL INFORMATION </h4>
                                    </div>
                                    @if(Auth::user()->id == $user->id)
                                        <div class="col-sm-6">
                                            <a class="btn btn-success pull-right" href='{{ URL::route('account');}}'> <i
                                                        class="fa fa-edit"></i> Edit</a>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="row mgbt-xs-0">
                                        <label class="col-xs-5 control-label"><b>First Name:</b></label>

                                        <div class="col-xs-7 controls">{{$user->name}}</div>
                                        <!-- col-sm-10 -->
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="row mgbt-xs-0">
                                        <label class="col-xs-5 control-label"><b>Mobile</b></label>

                                        <div class="col-xs-7 controls">{{$user->mobile}}</div>
                                        <!-- col-sm-10 -->
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="row mgbt-xs-0">
                                        <label class="col-xs-5 control-label"><b>Email</b></label>

                                        <div class="col-xs-7 controls">{{$user->email}}</div>
                                        <!-- col-sm-10 -->
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="row mgbt-xs-0">
                                        <label class="col-xs-5 control-label"><b>User Name:</b></label>

                                        <div class="col-xs-7 controls">{{$user->username}}</div>
                                        <!-- col-sm-10 -->
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="row mgbt-xs-0">
                                        <label class="col-xs-5 control-label"><b>Last Login</b></label>

                                        <div class="col-xs-7 controls">{{Dates::showTimeAgo($user->lastlogin)}}</div>
                                        <!-- col-sm-10 -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- panel 2 -->
                <!--<div class="panel panel-inverse overflow-hidden">
                  <div class="panel-heading">
                    <h3 class="panel-title">
                      <a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false">
                          <i class="fa fa-plus-circle pull-right"></i>
                        User Gallery
                      </a>
                    </h3>
                  </div>
                  <div id="collapseTwo" class="panel-collapse collapse" aria-expanded="false">

                    <!-- panel-2 body -->
                <!--<div class="panel-body">

                            <div style="border-bottom:1px solid #ccc; margin-bottom:15px;">
                              <div class="row" >
                                <div class="col-sm-6">
                                 <h4><i class="fa fa-user"></i>  Gallery </h4>
                                </div>
                                @if(Auth::user()->id == $user->id)
                                 <div class="col-sm-6">
                                   <button class="btn btn-success pull-right "> <i class="fa fa-edit"></i> Add pics</button>
                                 </div>
                                 @endif</div>
                            </div>

                            <!-- Navigation menu -->
                <!--<ul class="nav nav-pills">
                  <li class=""><a href="#nav-pills-tab-1" data-toggle="tab" aria-expanded="false">All Pics</a></li>
                  <li class=""><a href="#nav-pills-tab-2" data-toggle="tab" aria-expanded="false">Pics of you</a></li>
                  <li class=""><a href="#nav-pills-tab-3" data-toggle="tab" aria-expanded="false">Favorite</a></li>
                  <li class="active"><a href="#nav-pills-tab-4" data-toggle="tab" aria-expanded="true">Other</a></li>
                </ul>
               <!--End  Navigation menu -->

                <!-- navigation menu content -->
                <!--<div class="tab-content">
                   <div class="tab-pane fade" id="nav-pills-tab-1">
                       <h3 class="m-t-10">All Pics</h3>
                     <p>
                       Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                       Integer ac dui eu felis hendrerit lobortis.
                     </p>
                   </div>
                   <div class="tab-pane fade" id="nav-pills-tab-2">
                       <h3 class="m-t-10">Pics of you</h3>
                     <p>
                       Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                       Integer ac dui eu felis hendrerit lobortis.
                     </p>
                   </div>
                   <div class="tab-pane fade" id="nav-pills-tab-3">
                       <h3 class="m-t-10">Favorite</h3>
                     <p>
                       Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                       Integer ac dui eu felis hendrerit lobortis.
                     </p>
                   </div>
                  <div class="tab-pane fade active in" id="nav-pills-tab-4">
                       <h3 class="m-t-10">Other</h3>
                     <p>
                       Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                       Integer ac dui eu felis hendrerit lobortis.
                     </p>
                   </div>
                </div>
              <!-- End navigation menu content -->
                <!--</div>
                <!-- end panel-2 body -->
                <!--</div>
              </div>
             <!-- end of panel 2 -->

                <!-- panel 3 -->
                <!--<div class="panel panel-inverse overflow-hidden">
                  <div class="panel-heading">
                    <h3 class="panel-title">
                      <a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false">
                          <i class="fa fa-plus-circle pull-right"></i>
                        Experience and Education
                      </a>
                    </h3>
                  </div>
                  <div id="collapseThree" class="panel-collapse collapse" aria-expanded="false">
                    <div class="panel-body">
                      <div class="row">
                       <!-- Experience -->
                <!--<div class="col-sm-6 ">
                  <h3><i class="fa fa-file-text-o "></i> EXPERIENCE</h3>
                  <ul style="list-style:none;margin:0;padding:0">
                      <li>
                          <i class="fa  fa-circle-o"></i>
                          <a href="#"style=" margin-left: 10px;">Owner</a> at
                          <a href="#">Vendroid Ltd.</a>
                           <br>
                           <i style=" margin-left: 20px;"> March 2013 ~ Now</i>
                           <br><br>
                      </li>
                      <li>
                          <i class="fa  fa-circle-o"></i>
                          <a href="#"style=" margin-left: 10px;">CEO</a> at
                          <a href="#">Vendroid Ltd.</a>
                           <br>
                           <i style=" margin-left: 20px;"> March 2013 ~ Now</i>
                           <br><br>
                      </li>
                  </ul>
                </div>
                <!--End  Experience -->

                <!-- Education -->
                <!--<div class="col-sm-6">
                  <h3><i class="fa fa-trophy"></i> EDUCATION</h3>
                  <div >
                    <ul style="list-style:none;margin:0;padding:0" >

                       <li>
                          <i class="fa  fa-circle-o"></i>
                          <a href="#"style=" margin-left: 10px;">Bachelor's  degree, E-Commerce/Design </a> at
                           <a href="#">St.Martin</a>
                           <br>
                           <i style=" margin-left: 20px;"> March 2013 ~ Now</i>
                           <br><br>
                      </li>
                      <li>
                      <i class="fa  fa-circle-o"></i>
                      <a href="#"style=" margin-left: 10px;"> Master's </a> at
                      <a href="#"> St.Martin </a>
                      <br>
                      <i style=" margin-left: 20px;"> March 201 ~ Now</i>
                      <br><br>
                      </li>
                    </ul>
                  </div>
                </div>
                <!-- End Education -->

                <!-- </div>
                 <!-- End Row -->
                <!-- </div>
                 <!-- end panel-3 body -->
                <!--</div>
              </div>
              <!-- end panel 3 -->


                <!-- panel 4 -->
                <!--<div class="panel panel-inverse overflow-hidden">
                  <div class="panel-heading">
                    <h3 class="panel-title">
                      <a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false">
                          <i class="fa fa-plus-circle pull-right"></i>
                        Activity and Skills
                      </a>
                    </h3>
                  </div>
                  <div id="collapseFour" class="panel-collapse collapse" aria-expanded="false">
                    <div class="panel-body">
                      <div class="row">
                        <!-- Activities -->
                <!--<div class="col-sm-7">
                  <h3 class="mgbt-xs-15 font-semibold"><i class="fa fa-globe mgr-10 profile-icon"></i> ACTIVITY</h3>
                  <div class="">
                    <div class="content-list">
                      <ul>
                        <li>Activity 1 </li>
                        <li>Activity 2</li>
                        <li> Activity 3</li>
                      </ul>

                      <div class="closing text-center" style=""> <a href="#">See All Activities <i class="fa fa-angle-double-right"></i></a>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Activities -->

                <!-- skills -->
                <!--<div class="col-sm-5">
                  <h3 ><i class="fa fa-flask"></i> SKILL</h3>
                  <div class="skill-list">
                    <div class="skill-name"> Photoshop </div>
                    <div class="progress  progress-sm">
                      <div style="width: 90%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="90" role="progressbar" class="progress-bar progress-bar-success "> <span class="sr-only">90%</span> </div>
                    </div>
                  </div>
                  <div class="skill-list">
                    <div class="skill-name"> Illustrator </div>
                    <div class="progress  progress-sm">
                      <div style="width: 20%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="20" role="progressbar" class="progress-bar progress-bar-danger "> <span class="sr-only">20%</span> </div>
                    </div>
                  </div>
                  <div class="skill-list">
                    <div class="skill-name"> PHP </div>
                    <div class="progress  progress-sm">
                      <div style="width: 50%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="50" role="progressbar" class="progress-bar progress-bar-warning ">
                       <span class="sr-only">50% Complete</span>
                     </div>
                    </div>
                  </div>
                  <div class="skill-list">
                    <div class="skill-name"> Javascript </div>
                    <div class="progress  progress-sm">
                      <div style="width: 60%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="60" role="progressbar" class="progress-bar progress-bar-info "> <span class="sr-only">60% Complete</span> </div>
                    </div>
                  </div>
                </div>
               <!-- skills -->
                <!-- </div>
               </div>
               <!-- end panel-4 body -->
                <!--</div>
              </div>
              <!-- end panel-4 -->


                <!-- panel 5 -->
                <!--<div class="panel panel-inverse overflow-hidden">
                  <div class="panel-heading">
                    <h3 class="panel-title">
                      <a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false">
                          <i class="fa fa-plus-circle pull-right"></i>
                        Projects
                      </a>
                    </h3>
                  </div>
                  <div id="collapseFive" class="panel-collapse collapse" aria-expanded="false">
                    <!-- panel-5 body -->
                <!--<div class="panel-body">
                  <div>
                        <div class="vd_info tr">
                        <a class="btn btn-sm btn-info pull-right">
                            <i class="fa fa-plus "></i> Add Project
                        </a>
                        </div>
                      <h3 >
                      <i class="fa fa-bolt "></i> PROJECTS
                      </h3>
                    <!-- start table  -->
                <!--<table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Logo / Photos</th>
                                        <th>Clients</th>
                                        <th>Start Date</th>
                                        <th>Status</th>
                                        <th>Revenue</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                               <tbody>
                                 <tr>
                                    <td>1</td>
                                    <td>
                                        <img height="80" src="{{User::thumbnail($user->id)}}" alt="example image">
                                        </td>
                                        <td>Zoe Corp </td>
                                        <td class="center">2010/02/03</td>
                                        <td class="center">
                                            <span class="label label-success">Finish</span>
                                        </td>
                                        <td class="center">
                                            <strong>$ 250</strong>
                                        </td>
                                        <td class="menu-action rounded-btn">
                                            <a class="btn btn-circle btn-sm btn-icon btn-info" data-placement="top" data-toggle="tooltip" data-original-title="view">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a class="btn btn-circle btn-sm btn-icon btn-warning" data-placement="top" data-toggle="tooltip" data-original-title="edit">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a class="btn btn-circle btn-sm btn-icon btn-danger" data-placement="top" data-toggle="tooltip" data-original-title="delete">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </td>
                                 </tr>
                                 <tr>
                                    <td>2</td>
                                    <td>
                                        <img height="80" src="{{User::thumbnail($user->id)}}" alt="example image">
                                        </td>
                                        <td>Zoe Corp </td>
                                        <td class="center">2010/02/03</td>
                                        <td class="center">
                                            <span class="label label-success">Finish</span>
                                        </td>
                                        <td class="center">
                                            <strong>$ 250</strong>
                                        </td>
                                        <td class="menu-action rounded-btn">
                                            <a class="btn btn-circle btn-sm btn-icon btn-info" data-placement="top" data-toggle="tooltip" data-original-title="view">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a class="btn btn-circle btn-sm btn-icon btn-warning" data-placement="top" data-toggle="tooltip" data-original-title="edit">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a class="btn btn-circle btn-sm btn-icon btn-danger" data-placement="top" data-toggle="tooltip" data-original-title="delete">
                                                <i class="fa fa-times"></i>
                                            </a>
                                           </td>
                                  </tr>
                              </tbody>
                             </table>
                             <!-- end table  -->
                <!--</div>
               </div>
               <!-- end panel-5 body -->
                <!--</div>
              </div>

              <!-- panel 6 -->
                <!--<div class="panel panel-inverse overflow-hidden">
                        <div class="panel-heading">
                          <h3 class="panel-title">
                            <a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false">
                                <i class="fa fa-plus-circle pull-right"></i>
                             Portfolio
                            </a>
                          </h3>
                        </div>
                        <div id="collapseSix" class="panel-collapse collapse" aria-expanded="false">
                          <div class="panel-body">
                           <h3>{{$user->name."'s portfolio"}}</h3>
                          </div>
                        </div>
                      </div>

                       <!-- panel 7  -->
                {{--  <div class="panel panel-inverse overflow-hidden">--}}
                {{--   <div class="panel-heading">
                     <h3 class="panel-title">
                       <a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseSeven" aria-expanded="false">
                           <i class="fa fa-plus-circle pull-right"></i>
                        Groups/friends/Biography
                       </a>
                     </h3>
                   </div>--}}
                {{--  <div id="collapseSeven" class="panel-collapse collapse" aria-expanded="false">
                    <div class="panel-body">
                     Biography:::::
                     name:Qadir
                     city: jharkhand
                     Age : 21
                     status : Unmarried
                     Worked with: Team Member/friends
                    </div>
                  </div>--}}
                {{-- </div>--}}
            </div>
            <!-- end of accordian panel -->
        </div>
        <!--end wrapper div-->

    </div>

    <!--/left-->


    <!--right-->
    <div class="col-sm-3">

        <div class="panel panel-success" data-sortable-id="ui-widget-11">
            <div class="panel-heading">
                <h4 class="panel-title">User Profile Pic</h4>
            </div>
            <div class="panel-body">
                <div class="text-center vd_info-parent">
                    <img alt="example image" src="{{User::thumbnail($user->id)}}" style=" height: 100px;width: 100px;">
                </div>
                <br>
                <center>
                    <!-- form for change profile pic -->
                    {{ Form::open(array('url'=>'#','method'=>'POST', 'files'=>true)) }}

                    <button type="button" name="image" class="btn btn-sm btn-success "><i
                                class="fa fa-file-picture-o"></i> Change Picture
                    </button>
                    {{ Form::close() }}
                </center>
                <br>

                <div>
                    <table class="table table-striped table-hover">
                        <tbody>
                        <tr>
                            <td style="width:50%;">Status</td>
                            <td><span class="label label-success">
                                          @if(($user->active) == 1)
                                        Active
                                    @else
                                        Inactive
                                    @endif


                                  </span></td>
                        </tr>
                        <tr class="info">
                            <td>Member Since</td>
                            <td><em><?php echo date("d M, Y", strtotime($user->created_at));?></em></td>
                        </tr>
                        <tr>
                            <td>Last Login</td>
                            <td><em>{{Dates::showTimeAgo($user->lastlogin)}}</em></td>
                        </tr>
                        {{--<tr>
                          <td colspan="2" align="center"><b>Currently Working in</b> </td>
                        </tr>--}}
                        {{-- <tr class="info">
                           <td colspan="2"><em>WebReinvent Technologies pvt ltd</em> </td>
                         </tr>--}}
                        {{--<tr>
                          <td colspan="2" align="center"><b>Designation</b> </td>
                        </tr>--}}
                        {{-- <tr class="info">
                           <td colspan="2" class="text-center"><em>Php Developer</em> </td>
                         </tr>--}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!--/right-->

</div><!-- end of main row -->

<hr/>

