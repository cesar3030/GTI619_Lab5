@extends('app')

@section('content')
<div class="container">
  <h1 class="text-title">{{ $title }}</h1>
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
        <div class="panel-heading">General parameters</div>
        <div class="panel-body">
          @foreach ($appConfig as $app)
          <form id="config_form" class="form-horizontal">
            <fieldset>

              <!-- Form Name -->
              <legend>Application configuration</legend>

              <!-- Text input-->
              <div class="form-group">
                <label class="col-md-4 control-label" for="number_attempt_allowed">Number Attempt allowed</label>
                <div class="col-md-4">
                  <input id="number_attempt_allowed" name="number_attempt_allowed" value="{{$app->number_attempt_allowed}}" type="number" min="1" placeholder="(number)" class="form-control input-md">

                </div>
              </div>

              <!-- Text input-->
              <div class="form-group">
                <label class="col-md-4 control-label" for="number_last_password_disallowed">Number last password disallowed</label>
                <div class="col-md-4">
                  <input id="number_last_password_disallowed" name="number_last_password_disallowed" value="{{$app->number_last_password_disallowed}}" type="number" min="0" placeholder="(a number)" class="form-control input-md">

                </div>
              </div>

              <!-- Multiple Radios (inline) -->
              <div class="form-group">
                <label class="col-md-4 control-label" for="password_number_required">Password number required</label>
                <div class="col-md-4">
                  @if($app->password_number_required === 1)
                  <label class="radio-inline" for="password_number_required-0">
                    <input type="radio" name="password_number_required" id="password_number_required-0" value="1" checked="checked">
                    yes
                  </label>
                  <label class="radio-inline" for="password_number_required-1">
                    <input type="radio" name="password_number_required" id="password_number_required-1" value="0">
                    no
                  </label>
                  @else
                    <label class="radio-inline" for="password_number_required-0">
                      <input type="radio" name="password_number_required" id="password_number_required-0" value="1">
                      yes
                    </label>
                    <label class="radio-inline" for="password_number_required-1">
                      <input type="radio" name="password_number_required" id="password_number_required-1" value="0" checked="checked">
                      no
                    </label>
                  @endif
                </div>
              </div>

              <!-- Multiple Radios (inline) -->
              <div class="form-group">
                <label class="col-md-4 control-label" for="password_lower_case_required">Password lower case required</label>
                <div class="col-md-4">
                  @if($app->password_lower_case_required === 1)
                  <label class="radio-inline" for="password_lower_case_required-0">

                    <input type="radio" name="password_lower_case_required" id="password_lower_case_required-0" value="1" checked="checked">
                    yes
                  </label>
                  <label class="radio-inline" for="password_lower_case_required-1">
                    <input type="radio" name="password_lower_case_required" id="password_lower_case_required-1" value="0">
                    no
                  </label>
                  @else
                  <label class="radio-inline" for="password_lower_case_required-0">

                    <input type="radio" name="password_lower_case_required" id="password_lower_case_required-0" value="1">
                    yes
                  </label>
                  <label class="radio-inline" for="password_lower_case_required-1">
                    <input type="radio" name="password_lower_case_required" id="password_lower_case_required-1" value="0" checked="checked">
                    no
                  </label>
                  @endif
                </div>

              </div>

              <!-- Multiple Radios (inline) -->
              <div class="form-group">
                <label class="col-md-4 control-label" for="password_special_characters_required">Password special characters required</label>
                <div class="col-md-4">
                  @if($app->password_special_characters_required === 1)
                    <label class="radio-inline" for="password_special_characters_required-0">
                      <input type="radio" name="password_special_characters_required" id="password_special_characters_required-0" value="1" checked="checked">
                      yes
                    </label>
                    <label class="radio-inline" for="password_special_characters_required-1">
                      <input type="radio" name="password_special_characters_required" id="password_special_characters_required-1" value="0">
                      no
                    </label>
                  @else
                    <label class="radio-inline" for="password_special_characters_required-0">
                      <input type="radio" name="password_special_characters_required" id="password_special_characters_required-0" value="1">
                      yes
                    </label>
                    <label class="radio-inline" for="password_special_characters_required-1">
                      <input type="radio" name="password_special_characters_required" id="password_special_characters_required-1" value="0" checked="checked">
                      no
                    </label>
                  @endif

                </div>
              </div>

              <!-- Multiple Radios (inline) -->
              <div class="form-group">
                <label class="col-md-4 control-label" for="password_upper_case_required">Password upper case required</label>
                <div class="col-md-4">
                  @if($app->password_upper_case_required === 1)
                    <label class="radio-inline" for="password_upper_case_required-0">
                      <input type="radio" name="password_upper_case_required" id="password_upper_case_required-0" value="1" checked="checked">
                      yes
                    </label>
                    <label class="radio-inline" for="password_upper_case_required-1">
                      <input type="radio" name="password_upper_case_required" id="password_upper_case_required-1" value="0">
                      no
                    </label>
                  @else
                    <label class="radio-inline" for="password_upper_case_required-0">
                      <input type="radio" name="password_upper_case_required" id="password_upper_case_required-0" value="1">
                      yes
                    </label>
                    <label class="radio-inline" for="password_upper_case_required-1">
                      <input type="radio" name="password_upper_case_required" id="password_upper_case_required-1" value="0" checked="checked">
                      no
                    </label>
                  @endif

                </div>
              </div>

              <!-- Text input-->
              <div class="form-group">
                <label class="col-md-4 control-label" for="password_min_length">Password min length</label>
                <div class="col-md-4">
                  <input id="password_min_length" name="password_min_length" value="{{$app->password_min_length}}" type="number" min="7" placeholder="( number > 7)" class="form-control input-md">

                </div>
              </div>

              <!-- Text input-->
              <div class="form-group">
                <label class="col-md-4 control-label" for="password_time_life">Password time life</label>
                <div class="col-md-4">
                  <input id="password_time_life" name="password_time_life" value="{{$app->password_time_life}}" type="number" min="1" placeholder="(duration in days >=1)" class="form-control input-md">

                </div>
              </div>

              <!-- Text input-->
              <div class="form-group">
                <label class="col-md-4 control-label" for="time_restriction">Time Restriction</label>
                <div class="col-md-4">
                  <input id="time_restriction" name="time_restriction" value="{{$app->time_restriction}}" type="number" min="0" placeholder="(Time in seconds)" class="form-control input-md">

                </div>
              </div>

              <!-- Text input-->
              <div class="form-group">
                <label class="col-md-4 control-label" for="nb_max_times_bloked">Max time blocked account</label>
                <div class="col-md-4">
                  <input id="nb_max_times_bloked" name="nb_max_times_bloked" value="{{$app->nb_max_times_bloked}}" type="number" min="0" class="form-control input-md">

                </div>
              </div>

            </fieldset>
          </form>
          @endforeach
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
        <div class="panel-heading">Users management</div>
        <div class="panel-body">
          @foreach($users as $user)
          <div class="row">
            <label class="col-md-2 control-label" for="user_{{$user->id}}_role">{{$user->name}}</label>
            <div class="col-md-6">
              @foreach($roles as $role)
              <label class="radio-inline" for="user_{{$user->id}}_role-{{$role->role_id}}">
                @if($user->role_id === $role->role_id)
                  <input type="radio" name="user-{{$user->id}}_role" id="user_{{$user->id}}_role-{{$role->role_id}}" value="{{$role->role_id}}" checked="checked">
                  {{$role->name}}
                @else
                  <input type="radio" name="user-{{$user->id}}_role" id="user_{{$user->id}}_role-{{$role->role_id}}" value="{{$role->role_id}}">
                  {{$role->name}}
                @endif
              </label>
              @endforeach
            </div>
            <div class="col-md-4">
              @if($user->desactivated === 1)
                <button name="activate_{{$user->id}}" class="btn btn-success" style="margin-bottom: 5px;">Activate</button>
              @else
                <button name="desactivate_{{$user->id}}" class="btn btn-danger" style="margin-bottom: 5px;">Desactivate</button>
              @endif
                <button name="reset_{{$user->id}}" class="btn btn-warning" style="margin-bottom: 5px;">Reset Password</button>
            </div>
          </div>

          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>
  <script type="text/javascript">
    $(document).ready(function(){

      $("input[type=radio]").on("click",function(){

        var name = $(this).attr("name").split("-");
        var url='';
        switch(name[0]){
          case "password_lower_case_required":
            url="/admin/config/password/character/lower/"+$(this).val();
            break;
          case "password_upper_case_required":
            url="/admin/config/password/character/upper/"+$(this).val();
            break;
          case "password_special_characters_required":
            url="/admin/config/password/character/special/"+$(this).val();
            break;
          case "password_number_required":
            url="/admin/config/password/character/number/"+$(this).val();
            break;
          case "user":
            var user = $(this).attr("id").split("_");
            url="/user/"+user[1]+"/role/"+$(this).val();
            break;
        }

        console.log(url);
        ajaxBackend(url);

      });


      $("input[type=number]").on("focusout",function(){

        var $myForm = $('#config_form');
        if (!$myForm[0].checkValidity()) {
          // If the form is invalid, submit it. The form won't actually submit;
          // this will just cause the browser to display the native HTML5 error messages.

          //$myForm.find(':submit').click();
          $('<input type="submit">').hide().appendTo($myForm).click().remove();
          alert("invalid value");
          return;
        }

        var name = $(this).attr("name");
        var url='';

        switch(name){
          case "number_attempt_allowed":
            url="/admin/config/attempt/"+$(this).val();
            break;
          case "time_restriction":
            url="/admin/config/restriction/"+$(this).val();
            break;
          case "number_last_password_disallowed":
            url="/admin/config/password/disallow/"+$(this).val();
            break;
          case "password_time_life":
            url="/admin/config/password/life/"+$(this).val();
            break;
          case "password_min_length":
            url="/admin/config/password/length/"+$(this).val();
            break;
          case "nb_max_times_bloked":
            url="/admin/config/account/blocked/"+$(this).val();
            break;
        }

        console.log(url);
        ajaxBackend(url);
      });


      $("button").on("click",function(){

        var name = $(this).attr("name").split("_");
        var url='';
        var newClass="";
        var newName="";
        var newText="";

        switch(name[0]){
          case "activate":
            url="/user/"+name[1]+"/account/desactivate/0";
                  newClass="btn btn-danger";
                  newName="desactivate_"+name[1];
                  newText="Desactivate";
            break;
          case "desactivate":
            url="/user/"+name[1]+"/account/desactivate/1";
            newClass="btn btn-success";
            newName="activate_"+name[1];
            newText="Activate";
            break;
          case "reset":
            url="/user/"+name[1]+"/password/reset";
            break;
        }


        console.log(url);
        ajaxBackend(url);

        if(newClass.length>0 && newName.length>0 && newText.length>0){
          $(this).text(newText);
          $(this).attr("class",newClass);
          $(this).attr('name',newName);
        }

      });



    });



    /**
     * Function that execute an ajax request to the backend
     * @param url of the endpoint that we want to reach
     */
    function ajaxBackend(url){

      toastr.clear();

      $.ajax({
        type: "get",
        url: url,
        success: function(){
          toastr.success('Success', 'Operation done !');
          return true;
        },
        error: function(){
          toastr.error('FAIL', 'Error occurred!');
          return false;
        }
      });
    }
  </script>
@endsection