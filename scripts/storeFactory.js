angular
	.module('ngStore')
	.factory('storeFactory', function ($http) {
		//var cribsData = ;
		function getOffers() {
			//return cribsData;
			return $http.get('data/data.json');
		}

		return{
			getOffers:getOffers
		}
	});