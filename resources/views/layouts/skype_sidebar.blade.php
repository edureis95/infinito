<script type="text/javascript" src="https://secure.skypeassets.com/i/scom/js/skype-uri.js"></script>
<script src="https://swc.cdn.skype.com/sdk/v1/sdk.min.js"></script>
<style>
</style>

<div class="col-xs-1 sidebar-right">
    <ul class="nav nav-sidebar2">
      @foreach($usersList as $user)
         @if($user->skype != "" and $user->id != Auth::user()->id)
            <li class="chat-users buttonCursor">
            <div id="SkypeButton{{$user->id}}" class="skypeButton" style="width: 70%;">
      
            </div>
            </li>
         @endif
      @endforeach
   </ul>
</div>

<script type="text/javascript">
$( document ).ready(function() {
   @foreach($usersList as $user)
      @if($user->skype != "" && $user->id != Auth::user()->id)
       var style = document.createElement('style');
       style.type = 'text/css';
       style.innerHTML = '#SkypeButton{{$user->id}} img { width:0px; height:0px; padding-left: 150%; padding-top: 150%; zoom: 0.12; background: url("/uploads/avatars/{{$user->avatar}}"); margin-left: 0 !important; background-repeat: no-repeat; background-position: center; display: block;}';
       Skype.ui({
       "name": "chat",
       "element": "SkypeButton{{$user->id}}",
       "participants": ["{{$user->skype}}"],
       });

       document.getElementsByTagName('head')[0].appendChild(style);
      @endif
   @endforeach

});


</script>
