/* in my case base url of my app is localhost/projectN/public
  So modified it as per ur url in axios part 
*/
export default{
	state:{
		messages:{},
		username:null,
		activeusers:{},
		typinguser:false
	},
	getters:{},
	actions:{
		
			sendmessage(context,payload){
				return new Promise((resolve,reject)=>{
		axios.post('/projectN/public/send',{message:payload.message}).then((response)=>{
	   context.commit('fetchCurrent',response.data)
	  resolve(response)
	  })
	  .catch((error)=>{console.log(error)
	  	reject(error)
	  })
		})
		},		
	fetchmessage(context){

      axios.post('/projectN/public/fetch').then((response)=>
	   context.commit('fetch',response.data)
	  ) 	
   },
   showtyping(context,payload){ 
   	Echo.join('Chat')
   		.whisper('typing',payload);
   }, 
   eventchat(context){
   	Echo.join('Chat')
   		.here(user=>{
   			context.commit('currentactiveuser',user)
   		}).joining(user=>{
   			context.commit('joininguser',user)
   		}).leaving(user=>{
   			context.commit('leavinguser',user)
   		})
       	.listen('ChartEvent',(event)=>{
       		context.commit('listenevent',event.chat)
       	});

       	

       	

   } 
   
},
	 
	mutations:{	
		currentactiveuser(state,payload){
			state.activeusers=payload
		},
		joininguser(state,payload){
			state.activeusers.push(payload)
		},
		leavinguser(state,payload){
			state.activeusers=state.activeusers.filter(u => u.id!=payload.id)
		},
		listenevent(state,payload){
			
			state.messages.push(payload) 
		},
		typinguse(state,payload){
			console.log(payload)
			state.typinguser=payload
		},
	fetch(state,payload){
		
		state.messages=payload	
		
	},
	fetchCurrent(state,payload){
		console.log(payload)
		payload.user.name="You";
		state.messages.push(payload)
	}
	}
	

}
