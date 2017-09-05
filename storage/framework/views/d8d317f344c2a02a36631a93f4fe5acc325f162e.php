<?php $__env->startSection('content'); ?>
<link href="css/mail_client.css" rel="stylesheet" type="text/css" media="all" />
<link href='//fonts.googleapis.com/css?family=Nunito:400,300,700' rel='stylesheet' type='text/css'>
<div class="col-md-11">
<div class="main">
	<h1>Personal Mail Widget</h1>
	<div class="account" style="border-style: solid;width: 70%;">
		<div class="account-info">
			<div class="account-top">
				<div class="account-top-left">
					<img src="uploads/avatars/default.jpg" alt="">
				</div>
				<div class="account-top-right">
					<h2><?php echo e(Auth::user()->name); ?></h2>
				</div>
				<div class="clear"> </div>
			</div>
			<div class="account-bottom">
				<div class="tabs">
					<nav> 
						<a><span> </span>Inbox <i>4</i></a>
						<a><span class="icon1"></span>Starred <i>3</i></a> 
						<a><span class="icon2"></span>Spam</a>
						<a><span class="icon3"></span>Sent <i>555</i></a>
						<a><span class="icon4"></span>Deleted</a>
					</nav>
					<div class="content">
						<?php $__currentLoopData = $emailsInbox; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $email): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<div class="text">
							<div class="text-left">
								<span class="star "> </span>
							</div>
							<div class="text-right">
								<h4><a href="#">$email->header->subject</a></h4><label>6:02 PM  </label>
								<p>Lorem Ipsum is dummy text Of industry. </p>
								<p class="from">From</p>
								<h6> Malorum Borney</h6>
							</div>
							<div class="clear"> </div>
						</div>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
					</div>
					<div class="content">
						<div class="text">
							<div class="text-left">
								<span class="star "> </span>
							</div>
							<div class="text-right">
								<h4><a href="#">Flux Capacitor!</a></h4><label>6:02 PM  </label>
								<p>Lorem Ipsum is dummy text Of industry. </p>
								<p class="from">From</p>
								<h6> Malorum Borney</h6>
							</div>
							<div class="clear"> </div>
						</div>
						<div class="text">
							<div class="text-left">
								<span class="star active"> </span>
							</div>
							<div class="text-right">
								<h4><a href="#">My First Name </a></h4><label>5:30 PM </label>
								<p>It requires 2 gigaWatts of electricity... </p>
								<p class="from">From</p>
								<h6>Dr. Emmett Brown</h6>
							</div>
							<div class="clear"> </div>
						</div>
						<div class="text">
							<div class="text-left">
								<span class="star active"> </span>
							</div>
							<div class="text-right">
								<h4><a href="#">Fini Bonorum </a></h4><label>5:12 PM </label>
								<p>Lorem Ipsum is dummy text Of industry. </p>
								<p class="from">From</p>
								<h6> Ricky Anthony</h6>
							</div>
							<div class="clear"> </div>
						</div>
					</div>
					<div class="content">
						<div class="text">
							<div class="text-left">
								<span class="star active"> </span>
							</div>
							<div class="text-right">
								<h4><a href="#">My First Name</a></h4><label>2:30 PM </label>
								<p>Lorem Ipsum is dummy text Of industry. </p>
								<p class="from">From</p>
								<h6> Malorum Borney</h6>
							</div>
							<div class="clear"> </div>
						</div>
						<div class="text ">
							<div class="text-left">
								<span class="star"> </span>
							</div>
							<div class="text-right">
								<h4><a href="#">Flux Capacitor!</a></h4><label>2:30 PM </label>
								<p>It requires 2 gigaWatts of electricity... </p>
								<p class="from">From</p>
								<h6>Dr. Emmett Brown</h6>
							</div>
							<div class="clear"> </div>
						</div>
						<div class="text">
							<div class="text-left">
								<span class="star active"> </span>
							</div>
							<div class="text-right">
								<h4><a href="#">Dolorem ipsum </a></h4><label>2:30 PM </label>
								<p>Lorem Ipsum is dummy text Of industry. </p>
								<p class="from">From</p>
								<h6> Ricky Anthony</h6>
							</div>
							<div class="clear"> </div>
						</div>
						<div class="text">
							<div class="text-left">
								<span class="star active"> </span>
							</div>
							<div class="text-right">
								<h4><a href="#">Sweet last name!</a></h4><label>2:00 PM </label>
								<p>Lorem Ipsum is dummy text Of industry. </p>
								<p class="from">From</p>
								<h6> Patrick Star</h6>
							</div>
							<div class="clear"> </div>
						</div>
						<div class="text">
							<div class="text-left">
								<span class="star"> </span>
							</div>
							<div class="text-right">
								<h4><a href="#">Dolorem ipsum</a></h4><label>1:15 PM </label>
								<p>Lorem Ipsum is dummy text Of industry. </p>
								<p class="from">From</p>
								<h6> Patrick Star</h6>
							</div>
							<div class="clear"> </div>
						</div>
					</div>
					<div class="content">
						<div class="text ">
							<div class="text-left">
								<span class="star"> </span>
							</div>
							<div class="text-right">
								<h4><a href="#">My First Name</a></h4> <label>11:50 AM </label>
								<p>Lorem Ipsum is dummy text Of industry. </p>
								<p class="from">From</p>
								<h6> Malorum Borney</h6>
							</div>
							<div class="clear"> </div>
						</div>
						<div class="text">
							<div class="text-left">
								<span class="star active"> </span>
							</div>
							<div class="text-right">
								<h4><a href="#">Hi Friend...  </a></h4><label>10:05 AM </label>
								<p>It requires 2 gigaWatts of electricity... </p>
								<p class="from">From</p>
								<h6>Dr. Emmett Brown</h6>
							</div>
							<div class="clear"> </div>
						</div>
						<div class="text">
							<div class="text-left">
								<span class="star active"> </span>
							</div>
							<div class="text-right">
								<h4><a href="#">Flux Capacitor!</a></h4><label>9:30 AM </label>
								<p>Lorem Ipsum is dummy text Of industry. </p>
								<p class="from">From</p>
								<h6> Ricky Anthony</h6>
							</div>
							<div class="clear"> </div>
						</div>
						<div class="text">
							<div class="text-left">
								<span class="star"> </span>
							</div>
							<div class="text-right">
								<h4><a href="#">My First Name </a></h4><label>8:45 PM </label>
								<p>Lorem Ipsum is dummy text Of industry. </p>
								<p class="from">From</p>
								<h6> Patrick Star</h6>
							</div>
							<div class="clear"> </div>
						</div>
						<div class="text">
							<div class="text-left">
								<span class="star active"> </span>
							</div>
							<div class="text-right">
								<h4><a href="#">Sweet last name!</a></h4><label>11:50 PM </label>
								<p>Lorem Ipsum is dummy text Of industry. </p>
								<p class="from">From</p>
								<h6> Patrick Star</h6>
							</div>
							<div class="clear"> </div>
						</div>
					</div>
					<div class="content">
						<div class="text ">
							<div class="text-left">
								<span class="star active"> </span>
							</div>
							<div class="text-right">
								<h4><a href="#">Sweet last name!</a></h4><label>11:50 PM </label>
								<p>Lorem Ipsum is dummy text Of industry. </p>
								<p class="from">From</p>
								<h6> Malorum Borney</h6>
							</div>
							<div class="clear"> </div>
						</div>
						<div class="text">
							<div class="text-left">
								<span class="star"> </span>
							</div>
							<div class="text-right">
								<h4><a href="#">My First Name</a></h4><label>10:55 PM </label>
								<p>It requires 2 gigaWatts of electricity... </p>
								<p class="from">From</p>
								<h6>Dr. Emmett Brown</h6>
							</div>
							<div class="clear"> </div>
						</div>
						<div class="text ">
							<div class="text-left">
								<span class="star active"> </span>
							</div>
							<div class="text-right">
								<h4><a href="#">Flux Capacitor!</a></h4><label>10:15 PM </label>
								<p>Lorem Ipsum is dummy text Of industry. </p>
								<p class="from">From</p>
								<h6> Ricky Anthony</h6>
							</div>
							<div class="clear"> </div>
						</div>
						<div class="text">
							<div class="text-left">
								<span class="star active"> </span>
							</div>
							<div class="text-right">
								<h4><a href="#">Hi Friend... </a></h4><label>9:23 PM </label>
								<p>It requires 2 gigaWatts of electricity... </p>
								<p class="from">From</p>
								<h6>Dr. Emmett Brown</h6>
							</div>
							<div class="clear"> </div>
						</div>
					</div>
				</div>
				<div class="options">
					<select tabindex="4" class="dropdown">
						<option value="" class="label">Options</option>
						<option value="1">English</option>
						<option value="2">French</option>
						<option value="3">German</option>
					</select>
				</div>
			</div>
		</div>
	</div>
</div>
</div>

<script>
	$(function() {
	  $('.tabs nav a').on('click', function() {
		show_content($(this).index());
	  });
	  
	  show_content(0);

	  function show_content(index) {
		// Make the content visible
		$('.tabs .content.visible').removeClass('visible');
		$('.tabs .content:nth-of-type(' + (index + 1) + ')').addClass('visible');

		// Set the tab to selected
		$('.tabs nav a.selected').removeClass('selected');
		$('.tabs nav a:nth-of-type(' + (index + 1) + ')').addClass('selected');
	  }
	});
	</script>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36251023-1']);
  _gaq.push(['_setDomainName', 'jqueryscript.net']);
  _gaq.push(['_trackPageview']);

  (function() {
	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>