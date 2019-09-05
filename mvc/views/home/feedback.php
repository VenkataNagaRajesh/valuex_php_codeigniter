<link href='<?= base_url() ?>assets/bootstrap-star-rating/css/star-rating.min.css' type='text/css' rel='stylesheet'>
<!-- Bootstrap Star Rating JS -->
	<script src='<?= base_url() ?>assets/bootstrap-star-rating/js/star-rating.min.js' type='text/javascript'></script>
<div class="container top-bar">
	<div class="row">
		<div class="col-md-12">
			<div class="col-md-2">
				<img class="img-responsive" src="<?php echo base_url('assets/home/images/emir.png'); ?>" alt="logo">
			</div>
		</div>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="feedback-widget">
				<div class="feedback-title">
					<h2>Feedback Widget</h2>
					<p><b>Give us your Valuable feedback - we are listening!</b></p>
				</div>
				<div class="feedback-bar">
					<h3>
						Hi Ram !!
						<span class="pull-right">Connect with us 
							<a href="#"><i class="fa fa-facebook"></i></a>
							<a href="#"><i class="fa fa-twitter"></i></a>
							<a href="#"><i class="fa fa-youtube"></i></a>
						</span>
					</h3>
					<form>
						<p>1.Overall Experience</p>
							<label class="radio-inline">
							  <input type="radio" name="overall_experience" id="overall_experience" value="very_good" checked>Very Good
							</label>
							<label class="radio-inline">
							  <input type="radio" name="overall_experience" id="overall_experience" value="good">Good
							</label>
							<label class="radio-inline">
							  <input type="radio" name="overall_experience" id="overall_experience" value="good_fair">Good Fair
							</label>
							<label class="radio-inline">
							  <input type="radio" name="overall_experience" id="overall_experience" value="poor">Poor
							</label>
						<p>2. Timely Response</p>
							<label class="radio-inline">
							  <input type="radio" name="time_response" id="time_response" value="very_good" checked>Very Good
							</label>
							<label class="radio-inline">
							  <input type="radio" name="time_response" id="time_response" value="good">Good
							</label>
							<label class="radio-inline">
							  <input type="radio" name="time_response" id="time_response" value="good_fair">Good Fair
							</label>
							<label class="radio-inline">
							  <input type="radio" name="time_response" id="time_response" value="poor">Poor
							</label>
						<p>3. Our Support</p>
							<label class="radio-inline">
							  <input type="radio" name="our_support" id="our_support" value="very_good" checked>Very Good
							</label>
							<label class="radio-inline">
							  <input type="radio" name="our_support" id="our_support" value="good">Good
							</label>
							<label class="radio-inline">
							  <input type="radio" name="our_support" id="our_support" value="good_fair">Good Fair
							</label>
							<label class="radio-inline">
							  <input type="radio" name="our_support" id="our_support" value="poor">Poor
							</label>
						<p>4. Overall Satisfaction</p>
							<label class="radio-inline">
							  <input type="radio" name="overall_satisfaction" id="overall_satisfaction" value="very_good" checked>Very Good
							</label>
							<label class="radio-inline">
							  <input type="radio" name="overall_satisfaction" id="overall_satisfaction" value="good">Good
							</label>
							<label class="radio-inline">
							  <input type="radio" name="overall_satisfaction" id="overall_satisfaction" value="good_fair">Good Fair
							</label>
							<label class="radio-inline">
							  <input type="radio" name="overall_satisfaction" id="overall_satisfaction" value="poor">Poor
							</label>
						<p class="want-rate">Want to rate with us for customer services?</p>
						<!--<div class="feed-rating">
							<input class="rating">
						</div>-->
						
                <div class="post-action">
                    <!-- Rating Bar -->
					<input id="customer_service" class="rating-loading ratingbar" data-min="0" data-max="5" data-step="1">
                </div>
           
						<p>Is there anything you would like to tell us?</p>
						<textarea col="30" rows="2" class="form-control" placeholder="Type Here" name="message"  id="message" ></textarea>
						<button type="button" class="btn btn-danger col-md-offset-3" onclick="submitAction()">Submit</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<script type='text/javascript'>
	$(document).ready(function(){

		// Initialize
		 $('.ratingbar').rating({
	    	showCaption:false,
	    	showClear: false,
	    	size: 'sm'
	    });

		// Rating change
	    $('.ratingbar').on('rating:change', function(event, value, caption) {
	    	var id = this.id;
	    	var splitid = id.split('_');
	    	var postid = splitid[1];
	    	
		   	$.ajax({
		   		url: '<?= base_url() ?>index.php/posts/updateRating',
		   		type: 'post',
		   		data: {postid: postid, rating: value},
		   		success: function(response){
		   			$('#averagerating_'+postid).text(response);
		   		}
		   	});
		});
	});
	
	function submitAction(){
		var overall_experience = $("input[name=overall_experience]:checked").val();
		var time_response = $("input[name=time_response]:checked").val();
		var our_support = $("input[name=our_support]:checked").val();
		var overall_satisfaction = $("input[name=overall_satisfaction]:checked").val();
		var customer_service = $('.ratingbar').val();
		var message = $('#message').val();
		$.ajax({
		   		url: '<?= base_url("general/submitFeedback")?>',
		   		type: 'post',
		   		data: {pnr_ref:'AS0413',overall_experience: overall_experience, time_response: time_response,our_support: our_support,overall_satisfaction: overall_satisfaction,customer_service: customer_service,message:message},
		   		success: function(response){
                   alert("Thank You for Giving FeedBack");		   			
					window.location = "<?=base_url('home/index')?>";
		   		}
		   	});
				
	}
	
	</script>