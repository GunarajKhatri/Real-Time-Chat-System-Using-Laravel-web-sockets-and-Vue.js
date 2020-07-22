<template>
	<div class="container-fluid h-100" style="margin-top:50px;">
			<div class="row justify-content-center h-100">
				<div class="col-md-4 col-xl-3 chat">
					<div class="card mb-sm-3 mb-md-0 contacts_card">
					<div class="card-header">
						<div class="input-group">
							<input type="text" placeholder="Search..." name="" class="form-control search">
							<div class="input-group-prepend">
								<span class="input-group-text search_btn"><i class="fas fa-search"></i></span>
							</div>
						</div>
					</div>
					<div class="card-body contacts_body">
						<p class="text-center font-weight-bold" style="font-size:23px;color:white;">Active Friends</p>
						<ul class="contacts">
						<li class="active" v-for="user in users">
							<div class="d-flex bd-highlight"  v-if="user.name!=authuser.name">
								<div class="img_cont">
									<img src="/projectN/public/ros.jpg" style="height:70px;width:70px;"class="rounded-circle user_img_msg">
									<span class="online_icon"></span>
								</div>
								<div class="user_info">
									<span>{{user.name}}</span>
									<p>{{user.name}} is online</p>
								</div>
							</div>
						</li>
						
						</ul>
					</div>
				</div></div>
				<div class="col-md-8 col-xl-6 chat">
					<div class="card">
						<div class="card-header msg_head">
							<div class="d-flex bd-highlight">
								<div class="img_cont">
									<img src="/projectN/public/ros.jpg" style="height:70px;width:70px;"class="rounded-circle user_img_msg">
									<span class="online_icon"></span>
								</div>
								<div class="user_info">
									<span>Chat Box {{this.$store.state.username}}</span>
									
								</div>
								<div class="video_cam">
									<span><i class="fas fa-video"></i></span>
									<span><i class="fas fa-phone"></i></span>
								</div>
							</div>
							<span id="action_menu_btn"><i class="fas fa-ellipsis-v"></i></span>
							<div class="action_menu">
								<ul>
									<li><i class="fas fa-user-circle"></i> View profile</li>
									<li><i class="fas fa-users"></i> Add to close friends</li>
									<li><i class="fas fa-plus"></i> Add to group</li>
									<li><i class="fas fa-ban"></i> Block</li>
								</ul>
							</div>
						</div>
						<div class="card-body msg_card_body" v-chat-scroll>
							<div :class="{
								Sameuser:(msg.user.id==currentuserid),
								Diffuser:(msg.user.id!=currentuserid)
							}" v-for="msg,key in messages">

								<div class="img_cont_msg">
									<!-- <span class="msg_name">{{msg.user.name}}</span> -->
									<img src="/projectN/public/ros.jpg" style="height:40px;width:40px;"class="rounded-circle user_img_msg"v-if="msg.user.id!=currentuserid">
								</div>
								<div :class="{
								classSameuser:(msg.user.id==currentuserid),
								classDiffuser:(msg.user.id!=currentuserid)
							}">
									{{msg.message}}<br>
									<span class="msg_time"v-if="msg.user.id!=currentuserid">
													{{msg.created_at }}
													</span>
									
								</div>
							</div>
							
							</div> 
						</div>
						<div class="card-footer">
							
							<p class="text-white" v-if="this.$store.state.typinguser">

							{{this.$store.state.typinguser.name}} is typing.......</p>
							<div class="input-group">

								<div class="input-group-append">
									<span class="input-group-text attach_btn"><i class="fas fa-paperclip"></i></span>
								</div>
								<textarea v-model="message" class="form-control type_msg" placeholder="Type your message..." @keydown="showtyping()"></textarea><br>
								<div>
									<!-- <span><i class="fa fa-paper-plane" aria-hidden="true"></i></span> -->
									<button class="btn btn-primary" @click="send()">send</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
</template>
<script>
    export default {
    	props:['authuser','currentuserid'],
       data(){
       	return{
       		message:'',
       		clr:'msg_cotainer'
       	}
       } ,
       created(){
       	console.log(this.authuser)
       	// Unfortunately this listenForWhisper does not work
       	//tried a lot could not figured out 
       	Echo.join('Chat')
       		.listenForWhisper('typing',response=>{
       			console.log('typing')
       			console.log(response.name)
       	});
       		//---------------------------------------
       	this.$store.dispatch('eventchat');
       	this.$store.dispatch('fetchmessage');
       	 

       },
       computed:{
 	messages(){
 		return this.$store.state.messages
 	},
 	users(){
 		return this.$store.state.activeusers
 	},
 	date(){
 		return new Date().toLocaleString();
 			}
 	
       },
       methods:{
       	send(){
       		this.$store.dispatch('sendmessage',{
       			message:this.message
       		}).then(response =>{
                            this.message=''
                    });
       	},
       	showtyping(){
       		this.$store.dispatch('showtyping',this.authuser)
       	}
       		
       	}
       }
    
</script>
<style scoped>
.classSameuser{
	margin-top: auto;
		margin-bottom: auto;
		margin-right: 10px;
		border-radius: 25px;
		background-color: #78e08f;
		padding: 10px;
		position: relative;

}
.classDiffuser{ 
	margin-top: auto;
		margin-bottom: auto;
		margin-left: 10px;
		border-radius: 25px;
		background-color: #82ccdd;
		padding: 10px;
		position: relative;
}
.Sameuser{
	display:flex;
	justify-content:flex-end;
	margin-bottom:10px;
}
.Diffuser{
	display:flex;
	justify-content:flex-start;
	margin-bottom:14px;
}

</style>