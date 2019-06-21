angular
	.module('ngChat')
	.factory('chatFactory', function ($http) {
		//var cribsData = ;
		function getChat() {
			//return cribsData;
			return $http.get('data/comments.json');
		}

		return{
			getChat:getChat
		}
	});