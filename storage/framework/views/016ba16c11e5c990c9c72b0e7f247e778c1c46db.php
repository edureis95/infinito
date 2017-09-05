<script type="text/javascript" src="https://secure.skypeassets.com/i/scom/js/skype-uri.js"></script>
<style>
</style>

<div class="col-xs-1 sidebar-right">
    <ul class="nav nav-sidebar2">
      <?php $__currentLoopData = $usersList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
         <?php if($user->skype != "" and $user->id != Auth::user()->id): ?>
            <li class="chat-users buttonCursor">
            <div id="SkypeButton<?php echo e($user->id); ?>" class="skypeButton img-thumbnail" style="padding-bottom: 0; width: 70%;">
      
            </div>
            </li>
         <?php endif; ?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
   </ul>
</div>

<script type="text/javascript">
$( document ).ready(function() {
   <?php $__currentLoopData = $usersList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <?php if($user->skype != "" && $user->id != Auth::user()->id): ?>
       var style = document.createElement('style');
       style.type = 'text/css';
       style.innerHTML = '#SkypeButton<?php echo e($user->id); ?> img { content:url("/uploads/avatars/<?php echo e($user->avatar); ?>"); width: 100%; height: 30px; margin: 0 !important;}';
       Skype.ui({
       "name": "chat",
       "element": "SkypeButton<?php echo e($user->id); ?>",
       "participants": ["<?php echo e($user->skype); ?>"],
       });

       document.getElementsByTagName('head')[0].appendChild(style);
      <?php endif; ?>
   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

});

$(window).scroll(function(){
   if($(window).scrollTop() < $("#main-nav").height())
       $(".sidebar-right").css({"margin-top": - ($(window).scrollTop()) + "px"});
   else
       $(".sidebar-right").css({"margin-top": - $("#main-nav").height() + "px"});
   });

</script>
