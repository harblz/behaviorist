<script>
	/*
	function generateSchedule() {
		var transitionEnd = 'webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend';
		var transitionsSupported = ( $('.csstransitions').length > 0 );
		//if browser does not support transitions - use a different event to trigger them
		if( !transitionsSupported ) transitionEnd = 'noTransition';

		//should add a loding while the events are organized

		function SchedulePlan( element ) {
			this.element = element;
			this.timeline = this.element.find('.timeline');
			this.timelineItems = this.timeline.find('li');
			this.timelineItemsNumber = this.timelineItems.length;
			this.timelineStart = getScheduleTimestamp(this.timelineItems.eq(0).text());
			//need to store delta (in our case half hour) timestamp
			this.timelineSlotDuration = getScheduleTimestamp(this.timelineItems.eq(1).text()) - getScheduleTimestamp(this.timelineItems.eq(0).text());

			this.eventsWrapper = this.element.find('.events');
			this.events = this.eventsWrapper.find('.events-group');
			this.singleEvents = this.events.find('.single-event');
			this.eventSlotHeight = this.events.eq(0).children('.top-info').outerHeight();


			this.modal = this.element.find('.event-modal');
			this.modalHeader = this.modal.find('.header');
			this.modalHeaderBg = this.modal.find('.header-bg');
			this.modalBody = this.modal.find('.body');
			this.modalBodyBg = this.modal.find('.body-bg');
			this.modalMaxWidth = 800;
			this.modalMaxHeight = 480;

			this.animating = false;

			this.initSchedule();
		}

		SchedulePlan.prototype.initSchedule = function() {
			this.scheduleReset();
			this.initEvents();
		};

		SchedulePlan.prototype.scheduleReset = function() {
			var mq = this.mq();
			if( mq == 'desktop' && !this.element.hasClass('js-full') ) {
				//in this case you are on a desktop version (first load or resize from mobile)
				this.eventSlotHeight = this.events.eq(0).children('.top-info').outerHeight();
				this.element.addClass('js-full');
				this.placeEvents();
				this.element.hasClass('modal-is-open') && this.checkEventModal();
			} else if(  mq == 'mobile' && this.element.hasClass('js-full') ) {
				//in this case you are on a mobile version (first load or resize from desktop)
				this.element.removeClass('js-full loading');
				this.events.children('ul').add(this.singleEvents).removeAttr('style');
				this.eventsWrapper.children('.grid-line').remove();
				this.element.hasClass('modal-is-open') && this.checkEventModal();
			} else if( mq == 'desktop' && this.element.hasClass('modal-is-open')){
				//on a mobile version with modal open - need to resize/move modal window
				this.checkEventModal('desktop');
				this.element.removeClass('loading');
			} else {
				this.element.removeClass('loading');
			}
		};

		SchedulePlan.prototype.initEvents = function() {
			var self = this;

			this.singleEvents.each(function(){
				//create the .event-date element for each event
				var durationLabel = '<span class="event-date">'+$(this).data('start')+' - '+$(this).data('end')+'</span>';
				console.log('durationLabel', durationLabel)
				$(this).children('a').prepend($(durationLabel));

				//detect click on the event and open the modal
				$(this).on('click', 'a', function(event){
					event.preventDefault();
					if( !self.animating ) self.openModal($(this));
				});
			});

			//close modal window
			this.modal.on('click', '.close', function(event){
				event.preventDefault();
				if( !self.animating ) self.closeModal(self.events.find('.selected-event'));
			});
			this.element.on('click', '.cover-layer', function(event){
				if( !self.animating && self.element.hasClass('modal-is-open') ) self.closeModal(self.events.find('.selected-event'));
			});
		};

		SchedulePlan.prototype.placeEvents = function() {
			var self = this;
			this.singleEvents.each(function(){
				//place each event in the grid -> need to set top position and height
				var start = getScheduleTimestamp($(this).attr('data-start')),
					duration = getScheduleTimestamp($(this).attr('data-end')) - start;
					console.log(start, duration);

				var eventTop = self.eventSlotHeight*(start - self.timelineStart)/self.timelineSlotDuration,
					eventHeight = self.eventSlotHeight*duration/self.timelineSlotDuration;
					console.log(eventTop, eventHeight);

				$(this).css({
					top: (eventTop -1) +'px',
					height: (eventHeight+1)+'px'
				});
			});

			this.element.removeClass('loading');
		};

		SchedulePlan.prototype.openModal = function(event) {
			var self = this;
			var mq = self.mq();
			this.animating = true;

			//update event name and time
			this.modalHeader.find('.event-name').text(event.find('.event-name').text());
			this.modalHeader.find('.event-date').text(event.find('.event-date').text());
			this.modal.attr('data-event', event.parent().attr('data-event'));

			//update event content
			this.modalBody.find('.event-info').load(event.parent().attr('data-content')+'.html .event-info > *', function(data){
				//once the event content has been loaded
				self.element.addClass('content-loaded');
			});

			this.element.addClass('modal-is-open');

			setTimeout(function(){
				//fixes a flash when an event is selected - desktop version only
				event.parent('li').addClass('selected-event');
			}, 10);

			if( mq == 'mobile' ) {
				self.modal.one(transitionEnd, function(){
					self.modal.off(transitionEnd);
					self.animating = false;
				});
			} else {
				var eventTop = event.offset().top - $(window).scrollTop(),
					eventLeft = event.offset().left,
					eventHeight = event.innerHeight(),
					eventWidth = event.innerWidth();

				var windowWidth = $(window).width(),
					windowHeight = $(window).height();

				var modalWidth = ( windowWidth*.8 > self.modalMaxWidth ) ? self.modalMaxWidth : windowWidth*.8,
					modalHeight = ( windowHeight*.8 > self.modalMaxHeight ) ? self.modalMaxHeight : windowHeight*.8;

				var modalTranslateX = parseInt((windowWidth - modalWidth)/2 - eventLeft),
					modalTranslateY = parseInt((windowHeight - modalHeight)/2 - eventTop);

				var DetailsBgScaleY = modalHeight/eventHeight,
					MoreBgScaleX = (modalWidth - eventWidth);

				//change modal height/width and translate it
				self.modal.css({
					top: eventTop+'px',
					left: eventLeft+'px',
					height: modalHeight+'px',
					width: modalWidth+'px',
				});
				transformElement(self.modal, 'translateY('+modalTranslateY+'px) translateX('+modalTranslateX+'px)');

				//set modalHeader width
				self.modalHeader.css({
					width: eventWidth+'px',
				});
				//set modalBody left margin
				self.modalBody.css({
					marginLeft: eventWidth+'px',
				});

				//change modalBodyBg height/width ans scale it
				self.modalBodyBg.css({
					height: eventHeight+'px',
					width: '1px',
				});
				transformElement(self.modalBodyBg, 'scaleY('+DetailsBgScaleY+') scaleX('+MoreBgScaleX+')');

				//change modal modalHeaderBg height/width and scale it
				self.modalHeaderBg.css({
					height: eventHeight+'px',
					width: eventWidth+'px',
				});
				transformElement(self.modalHeaderBg, 'scaleY('+DetailsBgScaleY+')');

				self.modalHeaderBg.one(transitionEnd, function(){
					//wait for the  end of the modalHeaderBg transformation and show the modal content
					self.modalHeaderBg.off(transitionEnd);
					self.animating = false;
					self.element.addClass('animation-completed');
				});
			}

			//if browser do not support transitions -> no need to wait for the end of it
			if( !transitionsSupported ) self.modal.add(self.modalHeaderBg).trigger(transitionEnd);
		};

		SchedulePlan.prototype.closeModal = function(event) {
			var self = this;
			var mq = self.mq();

			this.animating = true;

			if( mq == 'mobile' ) {
				this.element.removeClass('modal-is-open');
				this.modal.one(transitionEnd, function(){
					self.modal.off(transitionEnd);
					self.animating = false;
					self.element.removeClass('content-loaded');
					event.removeClass('selected-event');
				});
			} else {
				var eventTop = event.offset().top - $(window).scrollTop(),
					eventLeft = event.offset().left,
					eventHeight = event.innerHeight(),
					eventWidth = event.innerWidth();

				var modalTop = Number(self.modal.css('top').replace('px', '')),
					modalLeft = Number(self.modal.css('left').replace('px', ''));

				var modalTranslateX = eventLeft - modalLeft,
					modalTranslateY = eventTop - modalTop;

				self.element.removeClass('animation-completed modal-is-open');

				//change modal width/height and translate it
				this.modal.css({
					width: eventWidth+'px',
					height: eventHeight+'px'
				});
				transformElement(self.modal, 'translateX('+modalTranslateX+'px) translateY('+modalTranslateY+'px)');

				//scale down modalBodyBg element
				transformElement(self.modalBodyBg, 'scaleX(0) scaleY(1)');
				//scale down modalHeaderBg element
				transformElement(self.modalHeaderBg, 'scaleY(1)');

				this.modalHeaderBg.one(transitionEnd, function(){
					//wait for the  end of the modalHeaderBg transformation and reset modal style
					self.modalHeaderBg.off(transitionEnd);
					self.modal.addClass('no-transition');
					setTimeout(function(){
						self.modal.add(self.modalHeader).add(self.modalBody).add(self.modalHeaderBg).add(self.modalBodyBg).attr('style', '');
					}, 10);
					setTimeout(function(){
						self.modal.removeClass('no-transition');
					}, 20);

					self.animating = false;
					self.element.removeClass('content-loaded');
					event.removeClass('selected-event');
				});
			}

			//browser do not support transitions -> no need to wait for the end of it
			if( !transitionsSupported ) self.modal.add(self.modalHeaderBg).trigger(transitionEnd);
		}

		SchedulePlan.prototype.mq = function(){
			//get MQ value ('desktop' or 'mobile')
			var self = this;
			return window.getComputedStyle(this.element.get(0), '::before').getPropertyValue('content').replace(/["']/g, '');
		};

		SchedulePlan.prototype.checkEventModal = function(device) {
			this.animating = true;
			var self = this;
			var mq = this.mq();

			if( mq == 'mobile' ) {
				//reset modal style on mobile
				self.modal.add(self.modalHeader).add(self.modalHeaderBg).add(self.modalBody).add(self.modalBodyBg).attr('style', '');
				self.modal.removeClass('no-transition');
				self.animating = false;
			} else if( mq == 'desktop' && self.element.hasClass('modal-is-open') ) {
				self.modal.addClass('no-transition');
				self.element.addClass('animation-completed');
				var event = self.events.find('.selected-event');

				var eventTop = event.offset().top - $(window).scrollTop(),
					eventLeft = event.offset().left,
					eventHeight = event.innerHeight(),
					eventWidth = event.innerWidth();

				var windowWidth = $(window).width(),
					windowHeight = $(window).height();

				var modalWidth = ( windowWidth*.8 > self.modalMaxWidth ) ? self.modalMaxWidth : windowWidth*.8,
					modalHeight = ( windowHeight*.8 > self.modalMaxHeight ) ? self.modalMaxHeight : windowHeight*.8;

				var DetailsBgScaleY = modalHeight/eventHeight,
					MoreBgScaleX = (modalWidth - eventWidth);

				setTimeout(function(){
					self.modal.css({
						width: modalWidth+'px',
						height: modalHeight+'px',
						top: (windowHeight/2 - modalHeight/2)+'px',
						left: (windowWidth/2 - modalWidth/2)+'px',
					});
					transformElement(self.modal, 'translateY(0) translateX(0)');
					//change modal modalBodyBg height/width
					self.modalBodyBg.css({
						height: modalHeight+'px',
						width: '1px',
					});
					transformElement(self.modalBodyBg, 'scaleX('+MoreBgScaleX+')');
					//set modalHeader width
					self.modalHeader.css({
						width: eventWidth+'px',
					});
					//set modalBody left margin
					self.modalBody.css({
						marginLeft: eventWidth+'px',
					});
					//change modal modalHeaderBg height/width and scale it
					self.modalHeaderBg.css({
						height: eventHeight+'px',
						width: eventWidth+'px',
					});
					transformElement(self.modalHeaderBg, 'scaleY('+DetailsBgScaleY+')');
				}, 10);

				setTimeout(function(){
					self.modal.removeClass('no-transition');
					self.animating = false;
				}, 20);
			}
		};

		var schedules = $('.full-schedule');
		var objSchedulesPlan = [],
			windowResize = false;

		if( schedules.length > 0 ) {
			schedules.each(function(){
				//create SchedulePlan objects
				objSchedulesPlan.push(new SchedulePlan($(this)));
			});
		}

		$(window).on('resize', function(){
			if( !windowResize ) {
				windowResize = true;
				(!window.requestAnimationFrame) ? setTimeout(checkResize) : window.requestAnimationFrame(checkResize);
			}
		});

		$(window).keyup(function(event) {
			if (event.keyCode == 27) {
				objSchedulesPlan.forEach(function(element){
					element.closeModal(element.events.find('.selected-event'));
				});
			}
		});

		function checkResize(){
			objSchedulesPlan.forEach(function(element){
				element.scheduleReset();
			});
			windowResize = false;
		}

		function getScheduleTimestamp(time) {
			//accepts hh:mm format - convert hh:mm to timestamp
			time = time.replace(/ /g,'');
			var timeArray = time.split(':');
			var timeStamp = parseInt(timeArray[0])*60 + parseInt(timeArray[1]);
			return timeStamp;
		}

		function transformElement(element, value) {
			element.css({
			    '-moz-transform': value,
			    '-webkit-transform': value,
				'-ms-transform': value,
				'-o-transform': value,
				'transform': value
			});
		}
	};
	*/

	function transformElement(element, value) {
		element.css({
		    '-moz-transform': value,
		    '-webkit-transform': value,
			'-ms-transform': value,
			'-o-transform': value,
			'transform': value
		});
	};

	function getScheduleTimestamp(time) {
		//accepts hh:mm format - convert hh:mm to timestamp
		time = time.replace(/ /g,'');
		var timeArray = time.split(':');
		var timeStamp = parseInt(timeArray[0])*60 + parseInt(timeArray[1]);
		return timeStamp;
	};

	import SessionNotes from './SessionNotes.vue'

    export default {
        name: 'full-calendar',

        components: {
        	SessionNotes,
        },

        data() {
          return {
            week: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
            appts: {},
            appointments: {},
            apptModal: {
            	id: null,
            	top: 0,
            	left: 0,
            	height: 0,
            	width: 0,
            	eventTime: '',
            	eventLocation: '',
            	eventStatus: '',
            	eventService: '',
            	eventClientID: null,
            	eventClientName: '',
            	eventTherapistID: null,
            	eventTherapistName: '',
            	eventInfoVisible: false,
            },
          }
        },

        methods: {
			convertToDateTime: function(appt) {
				if ( typeof(appt) !== 'undefined') {
					//console.log('qq', appt);
					return moment(appt.start_time).format("ddd, hA") + ' - ' + moment(appt.end_time).format("hA");
				}
			},

			formatAppt: function(appt) {
				//console.log(appt);

  			    var start    = getScheduleTimestamp(moment(appt.start_time).format('H:mm')),
  			        end      = getScheduleTimestamp(moment(appt.end_time).format('H:mm')),
  				    duration = end - start;
  				//console.log(start, end, duration);

  				var schedule = $('.full-schedule');
				schedule.timeline = schedule.find('.timeline');
				schedule.timelineItems = schedule.timeline.find('li');
				schedule.timelineItemsNumber = schedule.timelineItems.length;
				schedule.timelineStart = getScheduleTimestamp(schedule.timelineItems.eq(0).text());

				//need to store delta (in our case half hour) timestamp
				schedule.timelineSlotDuration = getScheduleTimestamp(schedule.timelineItems.eq(1).text()) - getScheduleTimestamp(schedule.timelineItems.eq(0).text());

				schedule.eventsWrapper = schedule.find('.events');
				schedule.events = schedule.eventsWrapper.find('.events-group');
				schedule.singleEvents = schedule.events.find('.single-event');
				schedule.eventSlotHeight = 30;

				var eventTop = schedule.eventSlotHeight*(start - schedule.timelineStart)/schedule.timelineSlotDuration,
					eventHeight = schedule.eventSlotHeight*duration/schedule.timelineSlotDuration;

				var styleObject = {
					top: (eventTop -1) +'px',
					height: (eventHeight+1)+'px',
				}
				return styleObject;
			},

			findAppointment: function(apptID, key) {

				var appointments = this.appointments[key];

				var result = Object.keys(appointments)
					.map(key => appointments[key]) // turn an array of keys into array of appointments.
					.filter(appt=> appt.id == Number(apptID));


				return result[0];
			},

			openModal: function(event) {
				var target    		= $(event.target).closest('.single-event');
				var transitionEnd 	= 'webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend';
				var apptModal 		= $('.event-modal');
				var schedule 		= $('.full-schedule');

				target.addClass('selected-event');

				schedule.addClass('modal-is-open');
				$('.full-schedule .event-modal .close, .full-schedule .event-modal .event-info').css('opacity', 0);

				apptModal.attr('data-event', target.attr('data-event'));


				this.apptModal.id = Number(target.attr('id'));

				// configure modal dimensions
				this.apptModal.top = target.offset().top - $(window).scrollTop(),
				this.apptModal.left = target.offset().left,
				this.apptModal.height = target.innerHeight(),
				this.apptModal.width = target.innerWidth();

				// configure modal details
				var apptData = this.findAppointment(target[0].dataset.apptId, target[0].dataset.dow);

        		this.apptModal.eventTime 			= moment(apptData.start_time).format("h:mm - ") + moment(apptData.end_time).format("h:mm a"),
        		this.apptModal.eventLocation 		= apptData.user.city,
        		this.apptModal.eventStatus 			= "Active",
        		this.apptModal.eventService 		= apptData.service,
        		this.apptModal.eventClientID 		= apptData.client.id,
        		this.apptModal.eventClientName 		= apptData.client.first_name + ' ' + apptData.client.last_name,
        		this.apptModal.eventTherapistID 	= apptData.user.id,
        		this.apptModal.eventTherapistName 	= apptData.user.first_name + ' ' + apptData.user.last_name;

				var windowWidth = $(window).width(),
					windowHeight = $(window).height();

				var modalWidth = ( windowWidth*.8 > 800 ) ? 800 : windowWidth*.8,
					modalHeight = ( windowHeight*.8 > 480 ) ? 480 : windowHeight*.8;

				var modalTranslateX = parseInt((windowWidth - modalWidth)/2 - this.apptModal.left),
					modalTranslateY = parseInt((windowHeight - modalHeight)/2 - this.apptModal.top);

				var DetailsBgScaleY = modalHeight/this.apptModal.height,
					MoreBgScaleX = (modalWidth - this.apptModal.width);

				// apptModal, apptModalHeader, apptModalBody, apptModalBodyBg
				//change modal height/width and translate it
				apptModal.css({
					top: this.apptModal.top+'px',
					left: this.apptModal.left+'px',
					height: modalHeight+'px',
					width: modalWidth+'px',
				});
				transformElement(apptModal, 'translateY('+modalTranslateY+'px) translateX('+modalTranslateX+'px)');

				//set modalHeader width
				$('#apptModalHeader').css({
					width: this.apptModal.width+'px',
				});

				//set modalBody left margin
				$('#apptModalBody').css({
					marginLeft: this.apptModal.width+'px',
				});

				//change modalBodyBg height/width and scale it
				$('#apptModalBodyBg').css({
					height: this.apptModal.height+'px',
					width: '1px',
				});
				transformElement($('#apptModalBodyBg'), 'scaleY('+DetailsBgScaleY+') scaleX('+MoreBgScaleX+')');

				//change modal modalHeaderBg height/width and scale it
				$('#apptModalHeaderBg').css({
					height: this.apptModal.height+'px',
					width: this.apptModal.width+'px',
				});

				// hide the apptModal info for a more graceful transition
				this.apptModal.eventInfoVisible = true;
				$('.full-schedule .event-modal .close, .full-schedule .event-modal .event-info').css('opacity', 1);

				transformElement($('#apptModalHeaderBg'), 'scaleY('+DetailsBgScaleY+')');

				$('#apptModalHeaderBg').one(transitionEnd, function(){
					//wait for the  end of the modalHeaderBg transformation and show the modal content
					$('#apptModalHeaderBg').off(transitionEnd);
					schedule.addClass('animation-completed');
				});
			},

			closeModal: function(event) {

				var target    = $(event.target).closest('.single-event');
				var transitionEnd = 'webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend';

				var apptModal = $('.event-modal');

				var modalTop = Number(apptModal.css('top').replace('px', '')),
					modalLeft = Number(apptModal.css('left').replace('px', ''));

				var modalTranslateX = this.apptModal.left - modalLeft,
					modalTranslateY = this.apptModal.top - modalTop;

				$('.full-schedule').removeClass('animation-completed');

				//change modal width/height and translate it
				apptModal.css({
					width: this.apptModal.width+'px',
					height: this.apptModal.height+'px'
				});
				transformElement(apptModal, 'translateX('+modalTranslateX+'px) translateY('+modalTranslateY+'px)');

				//scale down modalBodyBg element
				transformElement($('#apptModalBodyBg'), 'scaleX(0) scaleY(1)');
				//scale down modalHeaderBg element
				transformElement($('#apptModalHeaderBg'), 'scaleY(1)');

				// hide the apptModal info for a more graceful transition
				this.apptModal.eventInfoVisible = false;

				var data = this;

				$('#apptModalHeaderBg').one(transitionEnd, function(){
					//wait for the  end of the modalHeaderBg transformation and reset modal style
					$('#apptModalHeaderBg').off(transitionEnd);
					apptModal.addClass('no-transition');
					setTimeout(function(){
						//self.modal.add(self.modalHeader).add(self.modalBody).add(self.modalHeaderBg).add(self.modalBodyBg).attr('style', '');
						$('#apptModalHeader').attr('style', '');
						$('#apptModalBody').attr('style', '');
						$('#apptModalHeaderBg').attr('style', '');
						$('#apptModalBodyBg').attr('style', '');
					}, 10);
					setTimeout(function(){
						apptModal.removeClass('no-transition');
					}, 20);

					$('.full-schedule').removeClass('content-loaded modal-is-open');
					$('#'+data.apptModal.id).removeClass('selected-event');
				});

				//browser do not support transitions -> no need to wait for the end of it
				//if( !transitionsSupported ) self.modal.add(self.modalHeaderBg).trigger(transitionEnd);
			},

			dayNameToNumber: function(dayName) {
				var weekdays = [ "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday" ];
				return weekdays.indexOf(dayName);
			},

			eventColor(index) {
				return 'event-'+index;
			},

			convertDateTimeToHHMM: function(datetime) {

				return moment(datetime).format('HH:mm');
			}
        },

        created() {
        	this.$http.get('/schedule/week')
        		.then( response => {
        			this.appts = response.data;
        			var appts = { '6': [], '5': [], '4': [], '3': [], '2': [], '1': [], '0': [] };
        			this.appts.forEach(appt => {
        				appts[moment(appt.start_time).day()].push(appt)
        			});
        			this.appointments = appts;
        		});
        }
    }
</script>

<template>
	<div id="container-flex">
		<h3 class="title is-3">Schedule</h3>
		<section class="container-fluid">
			<div class="full-schedule-bg hidden-xs"></div>
			<div class="full-schedule loading" style="z-index: 1;">
			<div class="timeline">
				<ul>
					<li><span>06:00</span></li>
					<li><span>06:30</span></li>
					<li><span>07:00</span></li>
					<li><span>07:30</span></li>
					<li><span>08:00</span></li>
					<li><span>08:30</span></li>
					<li><span>09:00</span></li>
					<li><span>09:30</span></li>
					<li><span>10:00</span></li>
					<li><span>10:30</span></li>
					<li><span>11:00</span></li>
					<li><span>11:30</span></li>
					<li><span>12:00</span></li>
					<li><span>12:30</span></li>
					<li><span>1:00</span></li>
					<li><span>1:30</span></li>
					<li><span>2:00</span></li>
					<li><span>2:30</span></li>
					<li><span>3:00</span></li>
					<li><span>3:30</span></li>
					<li><span>4:00</span></li>
					<li><span>4:30</span></li>
					<li><span>5:00</span></li>
					<li><span>5:30</span></li>
					<li><span>6:00</span></li>
					<li><span>6:30</span></li>
					<li><span>7:00</span></li>
					<li><span>7:30</span></li>
					<li><span>8:00</span></li>
				</ul>
			</div> <!-- .timeline -->


			<div class="events">
				<ul>

					<li v-for="day in week" class="events-group" v-bind:class="day">
						<div class="top-info">
							<span> {{ day }} </span>
						</div>
						<ul>
							<li v-for="(appt, index) in appointments[dayNameToNumber(day)]"
								v-on:click="openModal"
								v-bind:style="formatAppt(appt)"
								:id="appt.id"
								class="single-event"
								:data-dow="dayNameToNumber(day)"
								:data-appt-id='appt.id'
								:data-service="appt.service"
								:data-client-id="appt.client.id"
								:data-datetime-start="appt.start_time"
								:data-datetime-end="appt.end_time"
								:data-start="convertDateTimeToHHMM(appt.start_time)"
								:data-end="convertDateTimeToHHMM(appt.end_time)"
								:data-event="eventColor(index)"
								>
									<a href="#0">
										<em class="event-name">
											{{ appt.client.first_name }}
											{{ appt.client.last_name }}
											<br>
										</em>
										<small class="event-service-type" style="color: white;">
											{{ convertToDateTime(appt) }}
											<br />
										</small>
									</a>
							</li>
						</ul>
					</li>

				</ul>
			</div>


			<div id="apptModal" class="event-modal">
				<header id="apptModalHeader" class="header">
					<div class="container-flex content" style="text-align: left;width: 100%;height: 100%;">
						<ul id="modalHeaderBtns" v-show="apptModal.eventInfoVisible">
							<li>
								<span class="event-name" v-text="apptModal.eventClientName"></span>
							</li>
							<li>
								<span class="event-name" v-text="apptModal.eventTime"></span>
							</li>
							<li>
								<span class="event-data" v-text="apptModal.eventService"></span>
							</li>
							<li>
								<span class="event-data" v-text="apptModal.eventLocation"></span>
							</li>
							<li>
								<span class="event-data" v-text="apptModal.eventStatus"></span>
							</li>
						</ul>
					</div>

					<div id="apptModalHeaderBg" class="header-bg"></div>
				</header>

				<div id="apptModalBody" class="body">
					<div class="event-info" v-show="apptModal.eventInfoVisible">
						<session-notes :clientID="apptModal.eventClientID"></session-notes>
					</div>
					<div id="apptModalBodyBg" class="body-bg"></div>
				</div>

				<a href="#0" v-on:click="closeModal" class="close" v-show="apptModal.eventInfoVisible">Close</a>
			</div>

			<div class="cover-layer"></div>
			</div> <!-- .full-schedule -->
		</section>
	</div>
</template>

<style>
	h3 {
		margin-bottom: 0px !important;
	}
</style>
