angular
	.module('ngStore')
	.controller('storeController', function($scope, storeFactory) {
		//$scope.hello = 'Hello world!';
		//$scope.cribs = cribsFactory.getCribs();
		$scope.offers;

		$scope.priceInfo = {
			min: 0,
			max: 1000000
		}

		$scope.newListing = {};
		$scope.addOffer = function(newListing) {
			newListing.image = 'default-product';
			$scope.offers.push(newListing);
			$scope.newListing = {};
		}

		$scope.editOffer = function (offer) {
			$scope.editListing = true;
			$scope.existingListing = offer;
		}

		$scope.saveOfferEdit = function() {
			$scope.existingListing = {};
			$scope.editListing = false;
		}

		$scope.deleteOffer = function (listing) {
			var index = $scope.offers.indexOf(listing);
			$scope.offers.splice(index, 1);
			$scope.existingListing = {};
			$scope.editListing = false;
		}
		
		storeFactory.getOffers().success(function(data) {
			$scope.offers = data;
		}).error(function(error) {
			console.log(error);
		});

		/*$scope.sayHello = function () {
			console.log("Hello!");
		}*/
	});