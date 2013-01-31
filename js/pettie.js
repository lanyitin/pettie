//init pettie obj {{{
var pettie = (function (theObj) {
	theObj.init_functions = [];
	theObj.game = {};
	theObj.timers = {};
	theObj.init = function () {
		this.init_functions.forEach(function (pFunction) {
			pFunction();
		});
	};
	return theObj;
})({});
//}}}
// Custome functions {{{
(function (theObj) {
	theObj.post = function (para_url, options, para_beforeSend) {
		var ajax_opts = {
			url: para_url,
	type : "POST",
	data: options,
	beforeSend:para_beforeSend,
	//timeout:10 * 1000,
		}
		return $.ajax(ajax_opts).fail(function (jqXHR, textStatus, errorThrown) {
			if (errorThrown == "timeout") {
				alert("Due to connection issue, we are going to refresh this page now!");
				window.location.reload();
			} else {
				//alert(errorThrown + ":" + para_url);
			}
		});
	}
	theObj.dialog = function () {
		return $("<div/>").attr("id", "dialog");
	}
})(pettie);
// }}} Custome functions
// Images {{{
(function (theObj) {
	var theModule = theObj.images = {};
	theModule.state = 0;
	theModule.pet_img = $("<img/>");
	theModule.exp_border_img = $("<img/>");
	theModule.exp_mask_img = $("<img/>");
	theModule.control_img = $("<img/>");
	theModule.control_btn_img = $("<img/>");
	theModule.control_btn_click_img = $("<img/>");
	theModule.control_up_btn_img = $("<img/>");
	theModule.control_up_btn_click_img = $("<img/>");
	theModule.control_down_btn_img = $("<img/>");
	theModule.control_down_btn_click_img = $("<img/>");
	theModule.interaction_img = $("<img/>");
	theModule.feed_img = $("<img/>");
	theModule.clean_img = $("<img/>");
	theModule.shot_img = $("<img/>");
	theModule.game_img = $("<img/>");
	theModule.data_img = $("<img/>");
	theModule.bg_img = $("<img/>");
	theModule.pupu_img = $("<img/>");
	theModule.dirty_img = $("<img/>");
	theModule.sick_img = $("<img/>");
	theModule.hungry_img = $("<img/>");

	theObj.init_functions.push(function () {
		theModule.pupu_img.attr("src", theObj.url + "images/poopoo.png").load(function () {theModule.state += 1});
		theModule.control_down_btn_click_img.attr("src", theObj.url + "images/controlLeft.png").load(function () {theModule.state += 1});
		theModule.control_down_btn_img.attr("src", theObj.url + "images/controlLeft_before.png").load(function () {theModule.state += 1});
		theModule.control_up_btn_click_img.attr("src", theObj.url + "images/controlRight.png").load(function () {theModule.state += 1});
		theModule.control_up_btn_img.attr("src", theObj.url + "images/controlRight_before.png").load(function () {theModule.state += 1});
		theModule.control_btn_click_img.attr("src", theObj.url + "images/controlButton_click.png").load(function () {theModule.state += 1});
		theModule.control_btn_img.attr("src", theObj.url + "images/controlButton.png").load(function () {theModule.state += 1});
		theModule.control_img.attr("src", theObj.url + "images/control.png").load(function () {theModule.state += 1});
		theModule.exp_mask_img.attr("src", theObj.url + "images/EXP_mask.png").load(function () {theModule.state += 1});
		theModule.exp_border_img.attr("src", theObj.url + "images/EXP_border.png").load(function () {theModule.state += 1});
		theModule.pet_img.attr("src", theObj.url + "images/dog.png").load(function () {theModule.state += 1});
		theModule.interaction_img.attr("src", theObj.url + "images/hand.png").load(function () {theModule.state += 1});
		theModule.feed_img.attr("src" , theObj.url + "/images/meat.png").load(function () {theModule.state += 1});
		theModule.clean_img.attr("src", theObj.url + "/images/broom.png").load(function () {theModule.state += 1});
		theModule.shot_img.attr("src", theObj.url + "/images/injection.png").load(function () {theModule.state += 1});
		if(pettie.username==pettie.sb_name){	
			theModule.game_img.attr("src", theObj.url + "images/playGame.png").load(function () {theModule.state += 1});
		}else{
			theModule.game_img.attr("src", theObj.url + "images/playGame_disable.png").load(function () {theModule.state += 1});
		}
		theModule.data_img.attr("src", theObj.url + "images/data.png").load(function () {theModule.state += 1});
		theModule.bg_img.attr("src", theObj.url + "images/petBackground.png").load(function () {theModule.state += 1});

		theModule.dirty_img.attr("src", theObj.url + "images/status_dirty.png").load(function () {theModule.state += 1});
		theModule.sick_img.attr("src", theObj.url + "images/status_sick.png").load(function () {theModule.state += 1});
		theModule.hungry_img.attr("src", theObj.url + "images/status_hungry.png").load(function () {theModule.state += 1});
	});
})(pettie);
// }}}
// notification {{{
(function (theObj) {
	var theModule = theObj.notify = {};
	theModule.friendRequest = [];
	theModule.msg_notify = [];
	theModule.fetchFriendRequest = function () {
		theObj.post(theObj.url + "api/friend/list/pendding/").done(function (data) {
			theModule.friendRequest.length = 0;
			data = JSON.parse(data);
			data.forEach(function (pe, index){
				theModule.friendRequest.push(data[index]);
			});
			theModule.changeNotifyBtnText();
		});
	}
	theModule.fetchMsgNotify = function () {
		theObj.post(theObj.url + "api/notification/message/").done(function (data) {
			theModule.msg_notify.length = 0;
			data = JSON.parse(data);
			data.forEach(function (pe, index){
				theModule.msg_notify.push(data[index]);
			});
			theModule.changeNotifyBtnText();
		});
	}

	theModule.changeNotifyBtnText = function () {
		var count = theModule.friendRequest.length + theModule.msg_notify.length;
		if(count > 0) {
			$("#notifyBtn").html("通知(" + count + ")");
		} else {
			$("#notifyBtn").html("通知");
		}
	}
	theModule.onNotifyBtnClick = function () {
		var dialog = theObj.dialog().attr("title", "通知");
		var RequestList = $("<ul/>").attr("id", "FriendRequestList").appendTo(dialog);
		theModule.friendRequest.forEach(function(pElement){
			var theLi = $("<li/>").appendTo(RequestList);
			$("<img/>").attr("src", pettie.url + pElement.Pic).attr("width", "32").appendTo(theLi);
			if (pElement.isSend == "1") {
				text = $("<span/>").html("你寄了一個好友邀請給"+ pElement.username).appendTo(theLi);
				cancelBtn = $("<button/>").attr("data-href", theObj.url + "friend/cancel/" + pElement.username + "/").html("Cancel").appendTo(theLi).click(function () {
					theObj.post($(this).attr("data-href")).done(function () {$(theLi).remove()});
				});
			} else {
				text2="寄給你一個好友邀請";
				text = $("<span/>").html(text2 + pElement.username).appendTo(theLi);
				acceptBtn = $("<button/>").attr("data-href", theObj.url + "friend/confirm/" + pElement.username + "/").html("Accept").appendTo(theLi).click(function () {
					theObj.post($(this).attr("data-href")).done(function () {$(theLi).remove()});
				});
				denyBtn = $("<button/>").attr("data-href", theObj.url + "friend/deny/" + pElement.username + "/").html("Deny").appendTo(theLi).click(function () {
					theObj.post($(this).attr("data-href")).done(function () {$(theLi).remove()});
				});
			}
		});
		theModule.msg_notify.forEach(function (pElement) {
			var theLi = $("<li/>").appendTo(RequestList).click(function () {pettie.post(theObj.url + "api/notification/msg/delete/" + pElement.nid +'/').done(function (){theObj.blog.popCommentList(pElement)})});
			$("<p/>").html(pElement.who_reply + " comment on one of your post:" + pElement.reply_msg).appendTo(theLi).append($("<a/>").attr("href", "javascript://"));

		});
		dialog.dialog({
			close:function (event, ui) {
				dialog.remove();
			},
			width: 650,
			height: 520,
			resizable: false
		});
	}
	theObj.init_functions.push(function (){
		theModule.fetchFriendRequest();
		theModule.fetchMsgNotify();
	});
})(pettie);
// }}} notification
// {{{ Language Relative Variable
(function (theObj){
	theObj.language = {
		delete : "刪除",
	share : "分享",
	speak : "說",
	ask : "問",
	like : "喜歡",
	unlike : " 取消喜歡",
	edit : "編輯",
	dog : "小狗",
	cat : "小貓",
	fish : "魚",
	low_health_to_exercise: '因為健康度低於30，所以不能做運動'
	}
})(pettie);
// }}}
// blog relative functions {{{
blogModule = (function (theObj) {
	var theModule = theObj.blog = {}
	theModule.post_queue = [];
	theModule.posts_displayed = [];
	theModule.comments = [];
	theModule.fetchAction = null;
	theModule.fetchPosts = function (pUrl) {
		$.ajax({url:pUrl}).done(function (data) {
			data = JSON.parse(data);
			posts = data.posts;
			comments = data.comments;
			for(i = 0; i< posts.length; i++) {
				theModule.push_post_data_to_post_queue(posts[i]);
			}
		});
	}
	theModule.push_post_data_to_post_queue = function (push_data) {
		theModule.post_queue.push(push_data);
	}
	theModule.fetchPostList = function () {
		theModule.fetchPosts(theObj.url + "api/blog/list/" + theObj.sb_name + "/");
		theModule.fetchAction = theModule.fetchUnreadPostList;
	}
	theModule.fetchUnreadPostList = function () {
		theModule.fetchPosts(theObj.url + "api/blog/unread/list/" + theObj.sb_name + "/");
	}
	theModule.fetchFriendsPost = function () {
		theModule.fetchPosts(theObj.url + "api/blog/friends/list/" + theObj.sb_name + "/");
		theModule.fetchAction = theModule.fetchFriendsUnread;
	}
	theModule.fetchFriendsUnread = function () {
		theModule.fetchPosts(theObj.url + "api/blog/friends/unread/list/" + theObj.sb_name + "/");
	}
	theModule.fetchPostLiked = function () {
		theModule.fetchPosts(theObj.url + "blog/liked/list/" + theObj.sb_name + "/");
		theModule.fetchAction = theModule.fetchUnreadLiked;
	}
	theModule.fetchUnreadLiked = function () {
		theModule.fetchPosts(theObj.url + "blog/liked/unread/" + theObj.sb_name + "/");
	}
	theModule.fetchFriendList = function (callback) {
		$.ajax({url:theObj.url + "api/friend/list/" + theObj.sb_name}).done(function (data) {				
			data = JSON.parse(data);
			delete theModule.friends;
			theModule.friends = [];
			for(var key in data) {
				theModule.friends.push(data[key]);
			}
			if( typeof callback === "function") {
				callback();
			}
		});
	}
	theModule.fetchCircleList = function (callback) {
		$.ajax({url:theObj.url + "api/circle/list/"}).done(function (data) {
			data = JSON.parse(data);
			delete theModule.circles;
			theModule.circles = [];
			for(var key in data) {
				theModule.circles.push(data[key]);
			}
			if( typeof callback === "function") {
				callback();
			}
		});
	}
	theModule.clean_post_queue = function () {
		$("#post-list").html("");
		delete theModule.post_queue;
		theModule.post_queue = [];
		delete theModule.posts_displayed;
		theModule.posts_displayed = [];
	}
	theModule.display_posts_in_queue = function () {
		while(theModule.post_queue.length > 0) {
			var post = theModule.post_queue.shift();
			var post_with_dom = new post_template(post);
			if(theModule.posts_displayed.length) {
				for(i = 0; i < theModule.posts_displayed.length; i++) {
					if(i < theModule.posts_displayed.length - 1) {
						if((new Date(theModule.posts_displayed[i].time)) < (new Date(post.time)) && (new Date(theModule.posts_displayed[i].time)) < (new Date(post.time))) {
							break;
						}
					}
				}
				$(theModule.posts_displayed[i - 1].template).before(post_with_dom.template);
			} else {
				$("#post-list").prepend(post_with_dom.template);
			}
			theModule.posts_displayed.push(post_with_dom);
		}
	}
	theModule.onMsgCatChange = function () {
		$("#message_list li").css("background-color", "");
		$(this).css("background-color", "#FFF");
		switch (this.getAttribute("data-action")) {
			case "all":
				theModule.fetchAction = theModule.fetchPostList;
				theModule.clean_post_queue();
				break;
			case "liked":
				theModule.fetchAction = theModule.fetchPostLiked;
				theModule.clean_post_queue();
				break;
			case "friends":
				theModule.fetchAction = theModule.fetchFriendsPost;
				theModule.clean_post_queue();
				break;
			case "plus":
				theModule.fetchAction = null;
				dialog = theObj.dialog().attr("title", "Circle List");
				theModule.circles.forEach(function(pElement) {
					$(dialog).append($("<div/>").html(pElement.name).click(function() {
						theModule.fetchPosts(theObj.url + "blog/circle/" +pElement.id+"/");
						theModule.clean_post_queue();
						dialog.remove();
					}));
				});
				dialog.dialog({
					close: function (event, ui) {
						dialog.remove();
					},
					width: 100,
					height:300 
				});
				break;
		}
	}
	theModule.popCommentList = function (data) {
		self = data;
		var dialog = pettie.dialog().attr("title", self.username);
		if(self.reply == 0) {
			pettie.post(pettie.url + "blog/comments/" + self.id + "/").done(function(data) {
				var d = JSON.parse(data);
				var comments_dom = [];
				var comment_list_dom = $("<div/>").attr("class","comment-list");
				var comment_content_dom = $("<textarea/>").css("width", "300px").css("height", 100);
				var type_select = $("<select/>").attr("name", "type").append('<option value="'+pettie.language.like+'">'+pettie.language.like+'</option><option value="' + pettie.language.share + '">'+pettie.language.share+'</option><option value="'+pettie.language.speak+'">'+pettie.language.speak+'</option><option value="'+pettie.language.ask+'">'+pettie.language.ask+'</option>');
				var submit_btn_dom =$("<button/>").html("回復").click(function (event) {
					event.stopPropagation();
					pettie.post(pettie.url + "api/blog/post/comment/" + self.id + "/", {content:comment_content_dom.val(), type:type_select.val()}).done(function (pData) {
						var d = JSON.parse(pData);
						d.time = new Date().getTime() + 1000*60*60*15;
						comment_list_dom.prepend(new post_template(d).template);
					});
				});
				d.comments.forEach(function (pElement) {
					comment_list_dom.prepend(new post_template(pElement).template);
				});
				dialog.append(new post_template(self).template);
				dialog.append("<hr/>");
				dialog.append(comment_list_dom);
				dialog.append(type_select);
				dialog.append(comment_content_dom);
				dialog.append(submit_btn_dom);
				dialog.dialog({
					close: function (event, ui) {
						dialog.remove();
					},
					width: 370,
					height: 540 
				});
			});
		}

	}

	var init_function = function () {
		$("#message_list li").click(theModule.onMsgCatChange);
		$("#message_list li:eq(0)").click();
		theModule.fetchPostList();
		theModule.fetchFriendList();
		theModule.fetchCircleList();
	};

	theObj.init_functions.push(init_function);
	return theModule;
})(pettie);
// }}}
//Pet relative functions {{{
var petModule = (function (theObj) {
	var theModule = theObj.pet = {}
	theModule.data = null;
	theModule.exercise = function (para_exp) {
		if (theModule.data.health >= 30) {
			pettie.post(theObj.url + "api/pet/exercise/" + parseInt(para_exp) + "/", {}, theObj.petUI.disableUI).done(function () {
				if(theModule.data.satiation>=1){
					theModule.data.satiation = parseInt(theModule.data.satiation) - 1;
				}else{
					theModule.data.satiation=0;
				}
				if(theModule.data.cleanliness>=1){
					theModule.data.cleanliness = parseInt(theModule.data.cleanliness) - 1;
				}else{
					theModule.data.cleanliness=0;
				}

				//level
				theModule.data.currentExperience = parseInt(theModule.data.currentExperience);
				theModule.data.requiredExperience = parseInt(theModule.data.requiredExperience);
				theModule.data.level = parseInt(theModule.data.level);							
				theModule.data.currentExperience += para_exp;
				if (theModule.data.currentExperience >= theModule.data.requiredExperience) {
					theModule.data.currentExperience %= theModule.data.requiredExperience;
					theModule.data.level += 1;
					theModule.data.requiredExperience = 10 + Math.pow(2, theModule.data.level);
					alert("Level up");
				}
				theObj.petUI.updateAttributeBar();
				theObj.petUI.enableUI()
			});
		} else {
			alert(theObj.language.low_health_to_exercise);
		}
	}
	theModule.drain = function(callback) {
		if(theModule.data.excreta > 0) {
			var ran = Math.random();
			if(ran < 0.6) {
				pettie.post(theObj.url + "api/pet/drain/"+ pettie.sb_name + "/", {}, theObj.petUI.disableUI).done(function (){
					theModule.data.excreta--;
					if(theModule.data.needClean <= 9) {
						theModule.data.needClean++ ;
					}else{
						theModule.data.needClean = 10;
					}
					if(theModule.data.cleanliness >= 1) {
						theModule.data.cleanliness = theModule.data.cleanliness - 1 ;
					}else{
						theModule.data.cleanliness = 0;
					}
					callback();
					theObj.petUI.enableUI()
				});
			}
		}
	}
	theModule.feed = function (callback) {
		if(this.data.satiation >= 30) {
			alert("目前寵物還沒肚子餓，請有需要時再餵食");
			return;
		}
		if (this.data.feedC <= 0) {
			alert("今日餵食次數已達上限，請明天再餵食");
			return;
		}
		pettie.post(theObj.url + "api/pet/feed/"+ pettie.sb_name + "/", {}, theObj.petUI.disableUI).done(function () {
			if(theModule.data.satiation<=27) {
				theModule.data.satiation= parseInt(theModule.data.satiation) + 3;
			}else{
				theModule.data.satiation = 30;
			}
			//確認便便數量
			if(theModule.data.excreta<=8) {
				theModule.data.excreta = parseInt(theModule.data.excreta) + 2;
			}else{
				theModule.data.excreta = 10;
			}
			if(theModule.data.feedC>=1){
				theModule.data.feedC--;
			}else{
				theModule.data.feedC=0;
			}
			callback();
			theObj.petUI.updateAttributeBar();
			theObj.petUI.enableUI()
		});
	}
	theModule.injection = function (callback) {
		if(!(theModule.data.health >= 30 || theModule.data.injectionC <= 0)) {
			pettie.post(pettie.url + "api/pet/injection/"+ pettie.sb_name + "/", {}, theObj.petUI.disableUI).done(function () {
				theModule.data.status = theObj.language.health;
				theModule.data.satiation = 15;
				theModule.data.cleanliness =15;
				if(theModule.data.injectionC>=1){
					theModule.data.injectionC--;
				}else{
					theModule.data.injectionC=0;
				}
				callback();
				theObj.petUI.updateAttributeBar();
				theObj.petUI.enableUI()
			});
		} else {
			alert("the Healthness is over 30");
		}
	}
	theModule.touch = function (){
		theObj.petUI.addActionFrames({action:"touching", frames:9});
	}
	theModule.hit = function (){
		theObj.petUI.addActionFrames({action:"hitting", frames:11});
	}
	theModule.cute = function (){
		theObj.petUI.addActionFrames({action:"cuteing", frames:21});
	}
	theModule.trick = function (){
		theObj.petUI.addActionFrames({action:"tricking", frames:18});
	}
	return theModule;
})(pettie);
// }}}
// {{{ petUI fucntion
uiModule = (function (theObj) {
	var theModule = theObj.petUI = {};
	theModule.currentFrame = 1;
	theModule.action_index = 0;
	theModule.check_action_index = -1;
	theModule.canvasDrawingInterval = 150;
	theModule.canUiWork = true;
	theModule.actionFramesQueue = [];
	theModule.addActionFrames = function (actionFrames) {
		regxText = /^(walking|staying)/;
		if(theModule.actionFramesQueue[0] !== undefined && regxText.test(theModule.actionFramesQueue[0].action) && !regxText.test(actionFrames.action) ) {
			theModule.actionFramesQueue.unshift(actionFrames);
			theModule.currentFrame = 1;
		} else {
			theModule.actionFramesQueue.push(actionFrames);
		}
	}
	theModule.disableUI = function () {
		theModule.canUiWork = false;
		theModule.cs.canvas.style.cursor = "wait";
	}
	theModule.enableUI = function () {
		theModule.canUiWork = true;
		theModule.cs.canvas.style.cursor = "default";
	}
	theModule.wheninit_pupu = function (){
		if(pettie.pet.data.needClean>0){
			//random put execreta when init
			for(var i=0;i< pettie.pet.data.needClean;i++){
				var init_ranX =Math.round(Math.random()*600); //整個高度 520 下方選單160 上面180綠色線 寬 600
				var init_ranY =Math.round(Math.random()*520);
				if(init_ranX >= 563){init_ranX=init_ranX-37;}
				if(init_ranY <= 180){init_ranY = init_ranY +180;}
				if(init_ranX <= 37){init_ranX = init_ranX +37;}
				if(init_ranY >=323){
					init_ranY = init_ranY -37;
					if(init_ranX<=160){init_ranX=init_ranX+160;}
					if(init_ranX>=440){init_ranX=init_ranX-160-37;}
				}

				var pupu = new ImageDrawable(theObj.images.pupu_img[0], init_ranX, init_ranY, theObj.images.pupu_img[0].width, theObj.images.pupu_img[0].height);
				pupu.click = function () {
					var self = this;
					if(theModule.check_action_index == 1) {
						theObj.post(theObj.url + "api/pet/clean/" + pettie.sb_name + "/", {}, theModule.disableUI).done(function () {
							if(theObj.pet.data.cleanliness<=25){
								theObj.pet.data.cleanliness = parseInt(theObj.pet.data.cleanliness) + 5;
							}else{
								theObj.pet.data.cleanliness=30;
							}
							theModule.updateAttributeBar();
							theModule.cs.drawables.splice($.inArray(self, theModule.cs.drawables), 1);
							theModule.enableUI();
						}).error(function () {
							theModule.cs.drawables.splice(theModule.cs.drawables.indexOf(theModule.character), 0, self);
							theModule.enableUI();
						});
					}
				}
				pupu.setContext(theModule.cs.context);
				theModule.cs.drawables.splice(theModule.cs.drawables.indexOf(theModule.character), 0, pupu);
			}
		}
	}
	theModule.adopt = function() {	
		if(!pettie.pet.data) {
			if(pettie.sb_name==pettie.username){ //To check the page is self page 
				var infomation = new Array(pettie.language.dog, pettie.language.cat, pettie.language.fish);
				var check = 0;
				var dialog = theObj.dialog().attr("title", "Select your pet").css({'background-image': 'url(' + pettie.url + 'images/selectPet.png)','width':'650'});
				var dog_img = $("<div/>").attr("id" ,"dog_img").css({'left': '69px',
					'top':'91px',										
					'position':'absolute',
					'width':'203px',
					'height':'134px',
					//'background-color':'red',

				}).click(function() {
					check =1;
					$("#info").empty().append(infomation[0]);
					$("#Type").attr('value',"狗");
					$("#dog_img").css("background-image","url("+ pettie.url + "images/selectPet_check.png)");
				}).mouseenter(function() {
					check=0;
					$("#info").empty().append(infomation[0]);
					$("#dog_img").css("background-image","url()");
				}).mouseleave(function() {
					if(check==0) {
						$("#info").empty();
					}
				});
				/*var cat_img =$("<div/>").css({'left':'364px',
				  'top': '49px',
				  'position':'absolute',
				  'width':'203px',
				  'height':'134px',
				  'background-color':'yellow',
				  '-moz-transform' : 'rotate(5deg)',
				  '-webkit-transform' : 'rotate(5deg)',
				  '-o-transform': 'rotate(5deg)',
				  '-ms-transform': 'rotate(5deg)',
				  'transform': 'rotate(5deg)'
				  }).click(function() {
				  check=1;
				  $("#info").empty().append(infomation[1]);
				  $("#Type").attr('value',"貓");
				  }).mouseenter(function() {
				  check=0;
				  $("#info").empty().append(infomation[1]);
				  }).mouseleave(function() {
				  if(check==0) {
				  $("#info").empty();
				  }
				  });
				  var fish_img =$("<div/>").css({'left':'61px',
				  'top': '273px',
				  'position':'absolute',
				  'width':'203px',
				  'height':'134px',
				  'background-color':'green',
				  '-moz-transform' : 'rotate(-6deg)',
				  '-webkit-transform' : 'rotate(-6deg)',
				  '-o-transform': 'rotate(-6deg)',
				  '-ms-transform': 'rotate(-6deg)',
				  'transform': 'rotate(-6deg)'
				  }).click(function() {
				  check=1;
				  $("#info").empty().append(infomation[2]);
				  $("#Type").attr('value',"魚");
				  }).mouseenter(function() {
				  check=0;
				  $("#info").empty().append(infomation[2]);
				  }).mouseleave(function() {
				  if(check==0) {
				  $("#info").empty();
				  }
				  });
				  comming soon*/
				var petnamelab = $("<label/>").html("Name :").css({'position':'absolute',
					'top':'223px',
					'left':'320px'});
				var name = $("<input/>").attr({type:"text",name:"Nmae", id:"Name"});

				var petgender = $("<span/>").html("Gender :").css({'position':'absolute',
					'top':'257px',
					'left':'320px'});
				var genderlab1 = $("<label/>").css({'position':'absolute',
					'top':'257px',
					'left':'408px'});		
				var gender1 =$("<input/>").attr({type:"radio",name:"Gender", value:"1",checked:"true" });
				var gender1lab = "&nbsp;♂ &nbsp;" ;
				var genderlab2 = $("<label/>").css({'position':'absolute',
					'top':'257px',
					'left':'461px'});
				var gender2 =$("<input/>").attr({type:"radio",name:"Gender",value:"2"});
				var gender2lab = " ♀<br/>" ;

				var type = $("<input/>").attr({'type':"text",'name':"Type",'id':"Type",'hidden':"hidden"});
				var infolab = $("<label/>").html("Introduction : <br/>").css({'position':'absolute',
					'top':'290px',
					'left':'320px'});

				var info =$("<textarea/>").attr({name:"introduction",id:"info",readonly:"readonly", rows : "4", cols : "30"});
				var infolab2 ="<br/>";
				var submit = $("<input/>").attr({type:"image",src: pettie.url + 'images/adoptButton.png',alt:"petsubmit"}).css({'position':'absolute', 'top':'420px', 'left':'502px'}).click(function() {
					if(petcheck_data()) {				
						pettie.post(pettie.url+"api/pet/adopt/" + pettie.sb_name + "/",{Gender: $('input:radio[name=Gender]:checked').val(), Type:$(type).val(), Name:$(name).val() ,introduction:$(info).val()}).done(function (data) {
							data = JSON.parse(data);
							if(data.content.UserID != undefined && data.content.PetID != undefined) {
								pettie.pet.data = data.content;
								pettie.petUI.init_dog_spirit();
								pettie.petUI.updateAttributeBar();
								dialog.remove();
							}
						});
					}
				});
				dialog.append(dog_img);
				//dialog.append(cat_img);
				//dialog.append(fish_img);
				petnamelab.append(name);
				dialog.append(petnamelab);
				dialog.append(petgender);
				genderlab1.append(gender1);
				genderlab1.append(gender1lab);
				dialog.append(genderlab1);
				genderlab2.append(gender2);
				genderlab2.append(gender2lab);
				dialog.append(genderlab2);
				dialog.append(type);
				infolab.append(info);
				dialog.append(infolab);		
				dialog.append(infolab2);
				dialog.append(submit);
				dialog.dialog({
					close:function (event, ui) {
						dialog.remove();
					},
					width: 650,
					height: 520,
					resizable: false
				});
			}
		} else {
			pettie.petUI.init_dog_spirit();
		}

	}

	theModule.newPupu = function () {
		theModule.updateAttributeBar();
		var pupu = new ImageDrawable(theObj.images.pupu_img[0], theModule.character.getX() + theModule.character.getWidth()/2, theModule.character.getY() + theModule.character.getHeight() - 32, 32, 32);
		pupu.click = function () {
			if(theModule.check_action_index == 1) {
				var thePupu = pupu;
				theModule.cs.drawables.splice($.inArray(thePupu, theModule.cs.drawables), 1);
				if(theObj.pet.data.cleanliness <= 25){
					theObj.pet.data.cleanliness = parseInt(theObj.pet.data.cleanliness) + 5;
				}else{
					theObj.pet.data.cleanliness = 30;
				}
				theModule.updateAttributeBar();
				theObj.post(theObj.url + "api/pet/clean/" + pettie.sb_name + "/").error(function () {
					theModule.cs.drawables.splice(theModule.cs.drawables.indexOf(theModule.character), 0, thePupu);
				});
			}
		}
		pupu.setContext(theModule.cs.context);
		theModule.cs.drawables.splice(theModule.cs.drawables.indexOf(theModule.character), 0, pupu);
	}

	theModule.action_change = function (offset, pElement) {
		temp_action_index = (theModule.action_index + offset) % theModule.action_label.length;
		theModule.action_index = temp_action_index;
		if(theModule.action_index < 0) {theModule.action_index = theModule.action_label.length - 1;}
		else if(theModule.action_index == theModule.action_label.length) {theModule.action_index = 0;}
		theModule.action_image_label.setImg(theModule.action_label[theModule.action_index]);
	};
	theModule.getRandomDogActionAndFrames = function () {
		var rand = Math.floor((Math.random()*100) % 8);
		var frames = Math.floor((Math.random()*100) % 8) + 6;
		switch(rand) {
			case 0:
				if(
						!theModule.expbar.contains({x:theModule.character.x, y:theModule.character.y}) &&
						!theModule.expbar.contains({x:theModule.character.x, y:theModule.character.y + theModule.character.height})&&
						!theModule.levelbar.contains({x:theModule.character.x, y:theModule.character.y}) &&
						!theModule.levelbar.contains({x:theModule.character.x, y:theModule.character.y}) &&
						!theModule.namebar.contains({x:theModule.character.x, y:theModule.character.y + theModule.character.height})&&
						!theModule.namebar.contains({x:theModule.character.x, y:theModule.character.y + theModule.character.height})
				  ) {
					  console.log(true);
					  return {action:ActionTypes.walking_left, frames:frames};
				  }
				console.log(false);
			case 1:
				if(theModule.character.x < (theModule.cs.canvas.width -theModule.character.movingPx* frames - 160 - 150)) {
					return {action:ActionTypes.walking_right, frames:frames};
				}
			case 2:
				if(theModule.character.y > theModule.character.movingPx* frames + 290) {
					return {action:ActionTypes.walking_up, frames:frames};
				}
			case 3:
				if(theModule.character.y < theModule.cs.canvas.height - theModule.character.movingPx*frames - 150) {
					return {action:ActionTypes.walking_down, frames:frames};
				}
			default:
				return {action:ActionTypes.staying, frames:frames * 2};
		}
	}

	theModule.action_label = [theObj.images.feed_img[0], theObj.images.clean_img[0], theObj.images.shot_img[0], theObj.images.interaction_img[0], theObj.images.game_img[0], theObj.images.data_img[0]];	
	theModule.action_functions = [
		function() {theObj.pet.feed(function () {
			theModule.addActionFrames({action:"eating", frames:6 * 3});
		})}, null, function () {theObj.pet.injection(function () {
			theModule.addActionFrames({action:"injecting", frames:9});
		})}, null, null, null];
	function convertToRadians(degree) {
		return degree*(Math.PI/180);
	}
	theModule.init_dog_spirit = function () {
		theModule.character = new Spirit({img:theObj.images.pet_img[0], width:150, height:150, movingPixel:2, actiontypes:window.ActionTypes, actionstates:window.ActionStates});
		theModule.character.click = function () {
			if (typeof theModule.action_functions[theModule.check_action_index] === "function") {
				theModule.action_functions[theModule.check_action_index]();
			}
		}
		theModule.character.setY(200);
		theModule.character.setX(300);
		theModule.cs.addDrawable(theModule.character);
		theModule.wheninit_pupu();
	}
	theModule.init_attr_bars = function () {
		theModule.health = new AttributeBar({x:20, y:20, value:29.9,maxValue:100, caption:"健康"});
		theModule.cs.addDrawable(theModule.health);
		theModule.food = new AttributeBar({x:20, y:40, value:29.9,maxValue:30, caption:"飽足"});
		theModule.cs.addDrawable(theModule.food);
		theModule.clean = new AttributeBar({x:20, y:60, value:29.9,maxValue:30, caption:"清潔"});
		theModule.cs.addDrawable(theModule.clean);
		theModule.cs.addDrawable(theModule.clean);
		theModule.expbar = new ExpBar({x:0, y:theModule.cs.canvas.height-theObj.images.exp_border_img[0].height, width:theObj.images.exp_border_img[0].width, height:theObj.images.exp_border_img[0].height, maskImg:theObj.images.exp_mask_img[0], baseImg:theObj.images.exp_border_img[0]});
		theModule.cs.addDrawable(theModule.expbar);
		theModule.namebar = new TextDrawable(theObj.pet.data.Name, theModule.expbar.getX() + theModule.expbar.getWidth(), theModule.expbar.getY() + theModule.expbar.getHeight() / 2);
		theModule.cs.addDrawable(theModule.namebar);
		theModule.levelbar = new TextDrawable("Level " + theObj.pet.data.level, theModule.namebar.getX(), theModule.namebar.getY() + 18/*theModule.namebar.getHeight()*/);
		theModule.cs.addDrawable(theModule.levelbar);
		theModule.statusBar = new LinearLayout({x: theModule.health.x + 200,y: theModule.health.y});
		theModule.dirty_img = new ImageDrawable(theObj.images.dirty_img[0]);
		theModule.dirty_img.context = theModule.cs.context;
		theModule.sick_img = new ImageDrawable(theObj.images.sick_img[0]);
		theModule.sick_img.context = theModule.cs.context;
		theModule.hungry_img = new ImageDrawable(theObj.images.hungry_img[0]);
		theModule.hungry_img.context = theModule.cs.context;
		theModule.cs.addDrawable(theModule.statusBar);
		theModule.updateAttributeBar();
	}
	theModule.updateAttributeBar = function () {
		theObj.pet.data.health = Math.floor(parseInt(theObj.pet.data.satiation) + parseInt(theObj.pet.data.cleanliness)) * 5 /3;
		theModule.health.setValue(theObj.pet.data.health);
		theModule.food.setValue(theObj.pet.data.satiation);
		theModule.clean.setValue(theObj.pet.data.cleanliness);
		theModule.expbar.setPercentage(parseInt(theObj.pet.data.currentExperience)/parseInt(theObj.pet.data.requiredExperience));
		theModule.levelbar.setText("Level " + theObj.pet.data.level);
		var statusElements = [];
		if (Math.floor(theObj.pet.data.health) < 30) {
			statusElements.push(theModule.sick_img);
		}
		if (Math.floor(theObj.pet.data.cleanliness)<10) {
			statusElements.push(theModule.dirty_img);
		}
		if (Math.floor(theObj.pet.data.satiation)<10) {
			statusElements.push(theModule.hungry_img);
		}
		theModule.statusBar.subView = statusElements;
		theModule.namebar.setText(theObj.pet.data.Name);

	}
	theModule.init_control = function () {
		var controlX = 440;
		var controlY = 360;
		theModule.ButtonCircle = new ImageDrawable(theObj.images.control_img[0], controlX, controlY, 160, 160);
		theModule.cs.addDrawable(theModule.ButtonCircle);

		theModule.ButtonLabelCheck = new ImageDrawable(theObj.images.control_btn_img[0], controlX + 70, controlY + 71, 83, 83);
		theModule.ButtonLabelCheck.click = function () {
			clearTimeout(theModule.cursor_change_timers);
			theModule.check_action_index = theModule.action_index;
			if(pettie.username==pettie.sb_name){
				switch (theModule.action_index) {
					case 0:
						document.getElementById("PetView").style.cursor="url(\"" + theObj.url + "images/meat_mouse.png\"), auto";
						break;
					case 1:
						document.getElementById("PetView").style.cursor="url(\"" + theObj.url + "images/broom_mouse.png\"), auto";
						break;
					case 2:
						document.getElementById("PetView").style.cursor="url(\"" + theObj.url + "images/injection_mouse.png\"), auto";
						break;
					case 3:
						dialog = theObj.dialog().attr("title", "Action List").load(theObj.url + "template/ActionList.phtml");
						dialog.dialog({
							close: function (event, ui) {
								dialog.remove();
							},
							resizable: false,
							width: 160,
							height:150,
							position: [590,400]
						});
						dialog.effect( "slide", "slow" );
						break;
					case 4:
						dialog = theObj.dialog().attr("title", "Game List").load(pettie.url + "game/gameList/");
						dialog.dialog({
							close: function (event, ui) {
								dialog.remove();
							},
							resizable: false,
							width: 700,
							height:500,
							position: [400,100]
						});
						dialog.effect( "slide", "slow" );
						break;
					case 5:
						dialog = theObj.dialog().attr("title","PetInfo").load(pettie.url+"pet/PetInfo/" + pettie.sb_name+"/");
						dialog.dialog({
							close: function (event, ui) {
								dialog.remove();
							},
							resizable: false,
							width: 650,
							height:480,
							position: [450,100]
						});
						dialog.effect( "slide", "slow" );
						break;
				}
			}else{
				switch (theModule.action_index) {
					case 0:
						document.getElementById("PetView").style.cursor="url(\"" + theObj.url + "images/meat_mouse.png\"), auto";
						break;
					case 1:
						document.getElementById("PetView").style.cursor="url(\"" + theObj.url + "images/broom_mouse.png\"), auto";
						break;
					case 2:
						document.getElementById("PetView").style.cursor="url(\"" + theObj.url + "images/injection_mouse.png\"), auto";
						break;
					case 3:
						dialog = theObj.dialog().attr("title", "Action List").load(theObj.url + "template/ActionList.phtml");
						dialog.dialog({
							close: function (event, ui) {
								dialog.remove();
							},
							resizable: false,
							width: 160,
							height:150,
							position: [590,400]
						});
						dialog.effect( "slide", "slow" );
						break;
					case 4:
						alert("you can't not do this action.");
						break;
					case 5:
						dialog = theObj.dialog().attr("title","PetInfo").load(pettie.url+"pet/PetInfo/" + pettie.sb_name+"/");
						dialog.dialog({
							close: function (event, ui) {
								dialog.remove();
							},
							resizable: false,
							width: 650,
							height:480,
							position: [450,100]
						});
						dialog.effect( "slide", "slow" );
						break;
				}
			}
			theModule.ButtonLabelCheck.setImg(theObj.images.control_btn_click_img[0]);
			setTimeout(function () {
				theModule.ButtonLabelCheck.setImg(theObj.images.control_btn_img[0]);
			}, 0.2 * 1000);
			theModule.cursor_change_timers = setTimeout(function () {
				document.getElementById("PetView").style.cursor="default";
				theModule.check_action_index = -1;
			}, 5 * 1000);
		};
		theModule.cs.addDrawable(theModule.ButtonLabelCheck);


		theModule.ButtonUp = new ImageDrawable(theObj.images.control_up_btn_img[0], controlX + 78, controlY+1, 27, 74);
		theModule.ButtonUp.configContext = function () {
			this.context.save();
			this.context.translate(this.x, this.y);
			this.context.rotate(this.rotation);
		}
		theModule.ButtonUp.onDraw = function () {
			this.context.drawImage(this.image, 0, 0);
		}
		theModule.ButtonUp.setRotation(convertToRadians(-15));
		theModule.ButtonUp.click = function () {
			theModule.action_change(1, this);
			this.setImg(theObj.images.control_up_btn_click_img[0]);
			setTimeout(function () {
				theModule.ButtonUp.setImg(theObj.images.control_up_btn_img[0]);
			}, 0.2 * 1000);
		};
		theModule.cs.addDrawable(theModule.ButtonUp);

		theModule.ButtonDown = new ImageDrawable(theObj.images.control_down_btn_img[0], controlX + 3, controlY + 96, 68, 27);
		theModule.ButtonDown.configContext = function () {
			this.context.save();
			this.context.translate(this.x, this.y);
			this.context.rotate(this.rotation);
		}
		theModule.ButtonDown.onDraw = function () {
			this.context.drawImage(this.image, 0, 0);
		}
		theModule.ButtonDown.setRotation(convertToRadians(9.5));
		theModule.ButtonDown.click = function () {
			theModule.action_change(-1, this);
			this.setImg(theObj.images.control_down_btn_click_img[0]);
			setTimeout(function () {
				theModule.ButtonDown.setImg(theObj.images.control_down_btn_img[0]);
			}, 0.2 * 1000);
		};
		theModule.cs.addDrawable(theModule.ButtonDown);
		theModule.action_image_label = new ImageDrawable(theObj.images.feed_img[0], controlX + 20,  controlY + 30);
		theModule.action_image_label.setFill(true);
		theModule.cs.addDrawable(theModule.action_image_label);
	}
	theModule.init_function = function() {
		theModule.cs = new CanvasState(document.getElementById("PetView"));
		theModule.cs.canvas.oncontextmenu = function (evt) {return false;};

		var tid = setInterval(function () {
			if (theObj.images.state == 18 + 3) {
				var bg = new ImageDrawable(theObj.images.bg_img[0], 0, 0, theModule.cs.canvas.width, theModule.cs.canvas.height);;
				theModule.cs.addDrawable(bg);

				theModule.init_attr_bars();
				theModule.init_control();
				theModule.adopt();
				clearInterval(tid);
				theModule.drawingTimerId = setInterval(function () {
					if (theModule.character) {
						if (theObj.pet.data.health <= 0 && theModule.currentAction !== "dieing") {
							theModule.addActionFrames({action:"dieing", frames:999});
							if (theObj.username === theObj.sb_name) {
								theObj.petUI.disableUI();
								pettie.post(pettie.url + "api/pet/death/" + theObj.username + "/").done(function () {
									var dialog = pettie.dialog();
									dialog.append("You can adopt new pet in couple seconds");
									dialog.dialog();
									setTimeout(function () {window.location.reload()});
								});
							}
						} else {
							if (theModule.actionFramesQueue[0] == undefined) {
								theModule.addActionFrames(theModule.getRandomDogActionAndFrames());
								theModule.currentFrame = 1;
							}
							if (theModule.currentFrame > theModule.actionFramesQueue[0].frames) {
								theModule.currentFrame = 1;
								theModule.actionFramesQueue.shift();
								if (theModule.actionFramesQueue[0] == undefined) {
									theModule.addActionFrames(theModule.getRandomDogActionAndFrames());
								}
							}
						}

						theModule.character.currentAction = theModule.actionFramesQueue[0].action;
						theModule.currentFrame++;
						if (theModule.actionFramesQueue[0].callbacks != undefined && typeof theModule.actionFramesQueue[0].callbacks[theModule.currentFrame] === "function") {
							theModule.actionFramesQueue[0].callbacks[theModule.currentFrame]();
						}
					}

					theModule.cs.canOpWork = theModule.canUiWork;
					theModule.cs.context.clearRect(0, 0, theModule.cs.canvas.width, theModule.cs.canvas.height);
					theModule.cs.drawables.forEach(function (pElement) {
						pElement.draw();
					});
				}, 150);
			}
		},100);
	};
	theObj.init_functions.push(theModule.init_function);
})(pettie);

// }}}
// MessageBoard Manipulate {{{
var post_template = function (post_data) {
	var self = this;
	self.data = post_data;
	self.change_date_text = function () {
		var diff_days, diff_hours, diff_mintues;
		var data_timestemp = (new Date(self.data.time)).getTime() + 1000*60*60*16;
		diff_days = ((((new Date).getTime()) - data_timestemp) / 1000 / 60 / 60 / 24 );
		diff_hours = diff_days * 24;
		diff_mintues = diff_hours * 60;

		if (diff_days >= 1) {
			self.datetime.html(parseInt(diff_days) + "天前");
		} else if (diff_hours >= 1 && diff_days < 1) {
			self.datetime.html(parseInt(diff_hours) + "小時前");
		} else if (diff_mintues >= 1 && diff_hours < 1) {
			self.datetime.html(parseInt(diff_mintues) + "分鐘前");
		} else {
			//var theDataObj = new Date(data_timestemp);
			self.datetime.html("Just now!");
		}
	}

	var change_like_text = function () {
		if ($.inArray(pettie.userid.toString(), self.data.who_likes) > -1) {
			self.like_operation.html($("<span/>").html(pettie.language.unlike + "(" + self.data.popular + ")").click(function(event) {
				event.stopPropagation();
				pettie.post(pettie.url + "blog/post/unlike/" + self.data.id+"/").done(function () {
					self.data.popular-=1;
					self.data.who_likes.splice($.inArray(pettie.userid.toString(), self.data.who_likes),1)
					change_like_text();
				});
			}));
		} else {
			self.like_operation.html($("<span/>").html(pettie.language.like + "(" + self.data.popular + ")").click(function (event) {
				event.stopPropagation();
				pettie.post(pettie.url + "blog/post/like/" + self.data.id+"/").done(function () {
					self.data.popular += 1;
					self.data.who_likes.push(pettie.userid.toString());
					change_like_text();
				});
			}));
		}
	}

	this.template = $("<div/>").addClass("post-entry").addClass("post-mouseout").click(function () {pettie.blog.popCommentList(self.data);}).mouseover(function () {
		self.template.removeClass("post-mouseout").children("div.post-right-wrapper").children("div.post-entry-content").removeClass("post-entry-content-mouseout");
	}).mouseleave(function () {
		self.template.addClass("post-mouseout").children("div.post-right-wrapper").children(".post-entry-content").addClass("post-entry-content-mouseout");
	});
	this.template.data = self;
	this.img_wrapper = $("<div/>").addClass("post-img-wrapper").appendTo(this.template);
	this.entry_left_wrapper = $("<div/>").addClass("post-right-wrapper").appendTo(this.template);
	this.pic = $("<img/>").attr("src", pettie.url + self.data.Pic).appendTo(this.img_wrapper);
	this.owner = $("<div/>").addClass("post-entry-owner").appendTo(this.entry_left_wrapper);
	this.type = $("<div/>").addClass("post-entry-type").html("<a href=\""+pettie.url+"main/index/" + self.data.owner + "\">" + self.data.owner + "</a>" + self.data.type).appendTo(this.entry_left_wrapper);
	this.content = $("<div/>").addClass("post-entry-content").addClass("post-entry-content-mouseout").html(self.data.content).appendTo(this.entry_left_wrapper);
	this.operation = $("<span/>").addClass("post-entry-operation").appendTo(this.entry_left_wrapper);
	this.datetime = $("<span/>").addClass("post-entry-time").appendTo(this.operation);
	this.like_operation = $("<span/>").addClass("post-entry-like").appendTo(this.operation);
	self.change_date_text();
	change_like_text();
	var theData = self.data;
	if (pettie.username === self.data.owner) {
		this.operation.append($("<span/>").html(pettie.language.edit).click(function(event) {
			event.stopPropagation();
			var _self = self;
			var dialog = pettie.dialog().attr("title", "Edit Post");
			var type_select = $("<select/>").attr("name", "type").append('<option value="'+pettie.language.like+'">'+pettie.language.like+'</option><option value="' + pettie.language.share + '">'+pettie.language.share+'</option><option value="'+pettie.language.speak+'">'+pettie.language.speak+'</option><option value="'+pettie.language.ask+'">'+pettie.language.ask+'</option>');
			var context = $("<textarea/>").attr("name", "context").val(theData.content);
			var submit_btn = $("<button/>").html("submit").click(function () {
				url = pettie.url + "blog/post/edit/" + theData.id;
				pettie.post(url , {type:type_select.val(), content:context.val()}).done(function (data) {	
					dialog.remove();
					_self.content[0].innerHTML = context.val();
					_self.data.content = context.val();
					_self.data.type = type_select.val();
				});
			});
			dialog.append(type_select);
			dialog.append(context);
			dialog.append(submit_btn);
			$(".ui-dialog").remove();
			dialog.dialog({
				close: function (event, ui) {
					dialog.remove();
				},
				width: 600,
				height: 450
			});
		}));
		this.operation.append($("<span/>").html(pettie.language.delete).click(function (event) {
			event.stopPropagation();
			pettie.post(pettie.url + "blog/post/delete/" + theData.id + "/").done(function() {
				$(self.template).remove();
			});
		}));
	}
}
//}}}
var modify_group = function (theCircle) {
	if (pettie.username === pettie.sb_name) {
		var gen_group_list_entity = function (theCircle) {
			var group_list_entity = $("<li/>").html(theCircle["name"])
				.attr("key", theCircle["id"])
				.click(function () {refresh_friends_list($(this).attr("key"))})
				.append($("<a/>").html(pettie.language.delete).attr("href", "#").click(function () {;pettie.post(pettie.url + "circle/delete/" + theCircle.id + "/").done(pettie.blog.fetchCircleList(init_group_list))}));
			return group_list_entity;
		}
		var init_group_list = function () {
			$(group_list).html("");
			for (var key in pettie.blog.circles) {
				group_list.append(gen_group_list_entity(pettie.blog.circles[key]));
			}
		}

		var init_friend_list = function () {
			$(friend_list).html("");;
			for (var key in pettie.blog.friends) {
				var theData = pettie.blog.friends[key];
				friend_list.append(createFriendListEntity(theData));
			}
		}

		var createFriendListEntity = function (para_data) {
			var theDom =  $("<li/>").html(para_data["username"]).append(
					$("<input/>").attr("type", "checkbox").click(function () {
						var checkbox_dom = $(this);
						var li_dom = $(this).parent();
						var post_data = {users:li_dom.attr("key")};
						var url;
						if (checkbox_dom.attr("checked") === "checked") {
							url = pettie.url + "circle/add/user/"+$("#modify_group_circle_list .ui-selected").attr("key")+"/";
						} else {
							url = pettie.url + "circle/remove/user/"+$("#modify_group_circle_list .ui-selected").attr("key")+"/";
						}
						pettie.post(url, post_data);
					}
					)).append( $("<button/>").html("Delete").click(function () {
						pettie.post(pettie.url + "friend/delete/" + para_data["username"] + "/").done( function () {
							console.log(theDom, para_data);
							$(theDom).remove()
						})
					}))
					.attr("key", para_data["id"]) .click(function () {});
					return theDom;
		}
		var refresh_friends_list = function (circleid) {
			$.ajax({url:pettie.url + "friend/group/"+ circleid + "/"}).done(function (data) {
				var in_group_friends = JSON.parse(data);
				$("#modify_group_friend_list li input[type*=checkbox]").attr("checked", false);
				for(var i = 0; i < in_group_friends.length; i++) {
					$("#modify_group_friend_list li[key*="+in_group_friends[i].id+"] input[type*=checkbox]").attr("checked", true);
				}
			});
		}
		//generate view
		var dialog = pettie.dialog().attr("title", "Friends & Circles");
		var createGroupBtn = $("<button/>");
		createGroupBtn.html("New Group");
		createGroupBtn.click(function () {
			var circle_name = window.prompt("Please Enter N Name For New Group");
			if (circle_name != null && circle_name != "") {
				pettie.post(pettie.url + "circle/create", {name:circle_name}).done(function() {
					pettie.blog.fetchCircleList(init_group_list);
				});
			}
		});
		var group_list = $("<ul/>").css("float", "left").attr("id", "modify_group_circle_list").css("width", "50%");
		init_group_list();
		var friend_list = $("<ul/>").css("float", "left").attr("id", "modify_group_friend_list").css("width", "50%");
		init_friend_list();

		group_list.selectable();
		dialog.append(group_list);
		dialog.append(friend_list);
		dialog.append(createGroupBtn);
		$(".ui-dialog").remove();
		dialog.dialog({
			close: function (event, ui) {
				dialog.remove();
			},
			width: 600,
			height: 450
		});
	} else {
		alert("Changing friend's setting is not allowed");
	}
}
var modify_setting = function () {
	if (pettie.username === pettie.sb_name) {
		dialog = pettie.dialog().attr("title", "Edit Profile").load(pettie.url + "member/profile/edit");
		$(".ui-dialog").remove();
		dialog.dialog({
			close: function (event, ui) {
				dialog.remove();
			},
			width: 400,
			height:300		
		});
	} else {
		alert("Changing friend's setting is not allowed");
	}
}

function petcheck_data() {
	if(document.getElementById("Name").value.length==0) {
		alert("Please enter the pet's name.");
		$("#submit").attr('src', pettie.url + 'images/adoptButton.png'); 
		return false;
	}
	if(document.getElementById("Name").value.length>10) {
		alert("Pet's name is too long, the maximum length is 10 words.");
		$("#submit").attr('src', pettie.url + 'images/adoptButton.png'); 
		return false;
	}
	if(document.getElementById("Type").value.length==0) {
		alert("Please select your pet.");
		$("#submit").attr('src', pettie.url + 'images/adoptButton.png'); 
		return false;
	}
	if(document.getElementById("info").value.length==0) {
		alert("Please select your pet.");
		$("#submit").attr('src', pettie.url + 'images/adoptButton.png'); 
		return false;
	}
	$("#submit").attr('src', pettie.url + 'images/adoptButton.png'); 
	return true;
}

function guessnumber() {
	$('.ui-dialog').remove();
	dialog = pettie.dialog().attr("title", "Guess number").load(pettie.url + "game/guess/");
	dialog.dialog({
		close: function (event, ui) {
			dialog.remove();
		},
		resizable: false,
		width: 690,
		height: 565
	});
}

function catchbutterfly() {
	$('.ui-dialog').remove();
	dialog = pettie.dialog().attr("title", "Catch butterfly").load(pettie.url + "game/catch/",null,function() {init_catch();Catch_time();catchbutterflyclock()});
	dialog.dialog({
		close: function (event, ui) {
			clearInterval(pettie.timers.butterfly_timer);
			butterfly_CountDownSec = 60;
			dialog.remove();
		},
		resizable: false,
		width: 650,
		height: 530
	});

}
function guessPic() {
	dialog = pettie.dialog().attr("title", "Guess Picture").load(pettie.url + "game/guessPic/",null,function(){calculateTime()});
	dialog.dialog({
		close: function (event, ui) {
			dialog.remove();
			guessPic_num =Math.floor( Math.random()*guessPic_pic.length );
			guessPic_sec=0;
			guessPic_min=3;
			clearInterval(guessPic_vartime);
		},
		resizable: false,
		width: 685,
		height: 540
	});
}
function gameinfoguessnumber() {
	document.getElementById("gameinfo").innerHTML="Avoid to guess the specific number from 0 to 50 in 10 times.";
}
function gameinfocatchbutterfly() {
	document.getElementById("gameinfo").innerHTML="Guess what the picture is behind the mask in 3 minutes. You can use the hint but it will subtract 10 seconds.";
}
function catchbutterflyclock() {
	pettie.timers.butterfly_timer = setInterval('change()', 1000);
}
function change() {
	if (butterfly_CountDownSec !=0) {
		butterfly_CountDownSec = butterfly_CountDownSec-1;
		document.getElementById("catchbutterflyclock").innerHTML =butterfly_CountDownSec + " second";
	} 

	else {
		document.getElementById("catchbutterflyclock").innerHTML = "Game Over";
		return;
	}
}
function mouseOverguess()
{
	if(document.getElementById("guessimg")) {
		document.getElementById("guessimg").src = pettie.url+"images/guessBtn_over.png";
	}
}
function mouseOutguess()
{
	if(document.getElementById("guessimg")) {
		document.getElementById("guessimg").src = pettie.url+"images/guessBtn.png";
	}
}
function mouseOvercatch()
{
	if (document.getElementById("catchimg")) {
		document.getElementById("catchimg").src = pettie.url+"images/catchBtn_over.png";
	}
}
function mouseOutcatch()
{
	if (document.getElementById("catchimg")) {
		document.getElementById("catchimg").src = pettie.url+"images/catchBtn.png";
	}
}
function searchfriend(){
	dialog = pettie.dialog().attr("title", "Search friend").load(pettie.url + "friend/search/" + $("#searchFriend").val() + "/");
	$(".ui-dialog").remove();
	dialog.dialog({
		close: function (event, ui) {
			dialog.remove();
		},
		resizable: false,
		width: 650,
		height:480,
		position: [450,100]
	});
}

// Timer {{{
pettie.timers.testDrain = setInterval(function () {
	pettie.pet.drain(function () {pettie.petUI.addActionFrames({action:ActionTypes.pupuing, frames:3 * 3, callbacks:[null,null,null,null,null,null,null,null,null,null,pettie.petUI.newPupu]});});
},600*1000);
pettie.timers.fetchPosts = setInterval(function () {if(typeof pettie.blog.fetchAction === "function") {pettie.blog.fetchAction();}}, 40000);
pettie.timers.displayPosts = setInterval(pettie.blog.display_posts_in_queue, 1000);
pettie.timers.updatePostTime = setInterval(function() {pettie.blog.posts_displayed.forEach(function(pElement) {pElement.change_date_text()});}, 60000);
pettie.timers.fetchNofifys = setInterval(function() {pettie.notify.fetchFriendRequest();pettie.notify.fetchMsgNotify()}, 60000);
// }}}
$(function () { 
	pettie.init();
});
//GuessPic part{{{
//function guessPic_Game(){
var guessPic_pic = new Array("dog", "cat", "alpaca", "colosseum", "dolphin", "horse", "ketchup",
		"lincoln", "moai", "nemo", "nike", "saturn", "watermelon", "yoshi", "ham",
		"bed");
var guessPic_hint = new Array("Animal", "Animal", "Animal", "The Ruins", "Animal", "Animal", "Sauce",
		"Person", "Carved", "Movie Character", "Brand", "Planet", "Fruit", "Video Game Character", "Food",
		"Furniture");
var guessPic_num = Math.floor( Math.random()*guessPic_pic.length );
var cBoxes = document.getElementsByClassName("boxcaption");
var guessPic_sec=0;
var guessPic_min=3;
var guessPic_vartime;

//Submit Answer
function guessPic_submitAns(){
	$("#guessPic_form").submit(function(){
		if ($("#guessPic_inputAns").val().toLowerCase() == guessPic_pic[guessPic_num]) {
			$("#test").html("Correct!!").show();
			for(var a=0; a<cBoxes.length; a++) {
				cBoxes[a].style.opacity = 0;
			}
			return true;
		}else{
			$("#test").html("Wrong...").show().fadeOut(1000);
			return false;
		}
	});
}
function guessPic_init() {
	var hintImg = document.getElementById("hintImg");
	var giveImg = document.getElementById("giveImg");

	guessPic_vartime = setInterval(calculateTime,1000);
	document.ansform.reset();
	$("#hintbtn").removeAttr("disabled");
	$("#ansbtn").removeAttr("disabled");
	$("#givebtn").removeAttr("disabled");

	var temp = document.getElementById("questionImage");
	temp.src = pettie.url+"images/questions/" + guessPic_pic[guessPic_num] + ".jpg";

	for(var i=0; i<cBoxes.length; i++) {
		cBoxes[i].onclick = showPicture;
		cBoxes[i].onmouseout = hidePicture;
		cBoxes[i].currentTop = 0;
	}

	$("#ansbtn").hover(
			function(){ this.src=pettie.url+"images/ansbutton_push.png"; },
			function(){ this.src=pettie.url+"images/ansbutton.png"; }
			);
	$("#givebtn").hover(
			function(){ giveImg.src=pettie.url+"images/givebutton_push.png"; },
			function(){ giveImg.src=pettie.url+"images/givebutton.png"; }
			);
	$("#hintbtn").hover(
			function(){ hintImg.src=pettie.url+"images/hintbutton_push.png"; },
			function(){ hintImg.src=pettie.url+"images/hintbutton.png"; }
			);


}

//Picture
function showPicture() {
	doChange(this, this.currentTop, -($(this).height()/2), 10, 35, 0.5);
}
function hidePicture() {
	doChange(this, this.currentTop, 0, 10, 5, 0.5);
}
function doChange(elem, startTop, endTop, steps, intervals, powr) {
	var stepCount = 0;
	function moveBox() {
		var delta = endTop - startTop;
		var stepp = startTop + (Math.pow(((1 / steps)*stepCount),powr)*delta);

		elem.currentTop = Math.ceil(stepp);
		elem.style.top = elem.currentTop + "px";
		stepCount++;

		if (stepCount > steps) window.clearInterval(elem.boxChangeInterval);
	}	
	if (elem.boxChangeInterval) window.clearInterval(elem.boxChangeInterval);
	elem.boxChangeInterval = window.setInterval(moveBox, intervals);
}

//CalculateTime
function calculateTime(){
	var timeSpan = document.getElementById("guessPic_time");
	guessPic_sec -= 1;
	if(guessPic_sec < 0){
		guessPic_sec = 59;
		guessPic_min -= 1;
		if(guessPic_min < 0){
			guessPic_min =0;
			guessPic_sec =0;
			alert("Time Out!!\n(The screen will be closed in 5 seconds.)");
			giveUp();
		}
	}

	if(guessPic_sec>=10){
		timeSpan.innerHTML= "0"+guessPic_min +" : "+ guessPic_sec;
		if(guessPic_min>=10){
			timeSpan.innerHTML = guessPic_min +" : "+ guessPic_sec;
		}
	}else{
		timeSpan.innerHTML= "0"+ guessPic_min +" : 0"+ guessPic_sec;
		if(guessPic_min>=10){
			timeSpan.innerHTML = guessPic_min +" : 0"+ guessPic_sec;
		}
	}
}

//Show Time in alert when win
function showTime(){
	guessPic_sec = check(guessPic_sec);
	guessPic_min = check(guessPic_min);
	alert("Congratulation!! You get 5 exp.\n Total time: " +guessPic_min+" : "+guessPic_sec+"\n(The screen will be closed in 3 seconds.");
	function check(i){
		if(i<10)
			i="0"+i;
		return i;
	}
	pettie.pet.exercise(5);
	gameOver();
}

//Hint
function showHint(){
	if(guessPic_sec>=10){
		guessPic_sec-=10;
	}else{
		if(guessPic_min>=1){
			guessPic_sec = guessPic_sec+50;
			guessPic_min-=1;
		}else{
			guessPic_sec=0;
			document.getElementById("guessPic_time").innerHTML= "0"+ guessPic_min +" : 0"+ guessPic_sec;
			giveUp();
		}
	}
	$("#hintword").html(guessPic_pic[guessPic_num].length+" Letters,"+guessPic_hint[guessPic_num]);
	$("#hint").fadeIn(1000);
	document.getElementById("hintbtn").disabled="disabled";
	document.getElementById("hintImg").src=pettie.url+"images/hintbutton_dis.png";
}

//Give up
function giveUp(){
	for(var a=0; a<cBoxes.length; a++) {
		cBoxes[a].style.opacity = 0;
	}
	$("#test").html(guessPic_pic[guessPic_num].toUpperCase()).show();
	alert("The screen will be closed in 3 seconds.");
	pettie.pet.exercise(3);
	gameOver();
}

//disable all button & stop time
function gameOver(){
	window.clearInterval(guessPic_vartime);
	guessPic_num =Math.floor( Math.random()*guessPic_pic.length );
	guessPic_sec=0;
	guessPic_min=3;
	document.getElementById("ansbtn").disabled="disabled";
	document.getElementById("ansbtn").src=pettie.url+"images/ansbutton_dis.png";
	document.getElementById("hintbtn").disabled="disabled";
	document.getElementById("hintImg").src=pettie.url+"images/hintbutton_dis.png";
	document.getElementById("givebtn").disabled="disabled";
	document.getElementById("giveImg").src=pettie.url+"images/givebutton_dis.png";
	setTimeout(function(){$("#dialog").remove();alert("timeout");},3*1000);
}
//}
//}}}
function addfriendbtnhide(){
	//<?php echo PETTIE_URL;?>friend/add/<?php echo $tpl_sb->username;?>/
	pettie.post(pettie.url + "friend/add/" +  pettie.sb_name+"/").done(function () {
		document.getElementById('addfriendbtnhideimg').style.visibility='hidden';
	});
}
// vim: foldmethod=marker:
